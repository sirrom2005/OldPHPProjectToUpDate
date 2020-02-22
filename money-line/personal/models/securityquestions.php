<?php

namespace Moneyline\Personal\Model;

require_once \COMMON_SERVICE_PATH.'AuthenticateWS.php';

use Raxan;
use Moneyline\Personal\Shared;
use Moneyline\Common\Model\SysInfo;

// @TODO: Refactor code. Maybe move these methods to User model

/**
 * Description of securityQuestions
 * @author lloydj
 */
class SecurityQuestions extends \Moneyline\Common\DataModel {
    const MAX_SQ_CNT_NAME ='max_security_questions_cnt';
    const LOGIN_SQ_CNT_NAME = 'login_security_questions_cnt';
    const MAX_NO_OF_SQ_LIST = 6;
    const LI_NODE_PREFIX = "#li-sqlist-widget";
    const SELECTOR_NAME_PREFIX = "#sqlist";
    const CLASS_NAME ='sqlist-widget';
    const QUST_ELEMENT_NAME_PREFIX = "sqlist";
    const ANSW_ELEMENT_NAME_PREFIX = "questansnew";

    //put your code here
    protected $NO_OF_SECURITY_ANSWERS;
    protected $NO_OF_RAND_SECURITY_QUESTIONS;
    protected $MAX_SECURITY_QUESTIONS_CNT;
    protected $answers;

    function __construct() {

        $this->NO_OF_RAND_SECURITY_QUESTIONS = Raxan::config(self::LOGIN_SQ_CNT_NAME);
        $this->NO_OF_SECURITY_ANSWERS = $this->NO_OF_RAND_SECURITY_QUESTIONS;
        $this->MAX_SECURITY_QUESTIONS_CNT = Raxan::config(self::MAX_SQ_CNT_NAME);

        $this->answers = array();
    }

    public function saveSecurityQuestions($uid, $securityToken) {
        try {
            $ws = new SharedDataModel();

            $clientService = $ws->getWebService('AuthenticateWS');

            $param = new AuthenticateWS\setUserSecurityQuestions();
            $param->uid = $uid;
            $param->token = $securityToken;
            $param->answers = $this->answers;

            $response = $clientService->setUserSecurityQuestions($param);

            return $response->return->result;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'User';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    public function addSecurityQuestionsAnswer($uid, $questionId, $answer) {
        try {
            $asq = new AuthenticateWS\assignedSecurityQuestionDTO();
            $asq->answer = $answer;
            $asq->uid = $uid;
            $asq->questionId = $questionId;
            $this->answers[] = $asq;
            return true;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'User';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }

        return false;
    }

    public function clearSecurityQuestionsAnswer() {
        $this->answers = array();
    }


    public static function loadSecurityQuestions() {

        $securityQuestionsDetails = SysInfo::getSecurityQuestions();


        $NUMOFSQ = Raxan::config(self::MAX_SQ_CNT_NAME);
        $NOINSLOT = (int) count($securityQuestionsDetails) / $NUMOFSQ;

        $MAXLIST = self::MAX_NO_OF_SQ_LIST;
        $linodeprefix = self::LI_NODE_PREFIX;
        $sqlistselectornameprefix = self::SELECTOR_NAME_PREFIX;
        $sqlistclassname = self::CLASS_NAME;

        $sqlStart = array();
        $sqlStart = array('id' => 0, 'question' => 'Select a question...', 'active' => 1);

        for ($cnt = 0; $cnt < $NUMOFSQ; $cnt++) {
            $nextOffset = $NOINSLOT * $cnt;
            $nextselectorcnt = $cnt + 1;
            $selectorname = $sqlistselectornameprefix . $nextselectorcnt;

            $linodename = $linodeprefix . $nextselectorcnt;
            $sqllist = array();

            if ($cnt < ($NUMOFSQ - 1)) {
                $sqlist = array_slice($securityQuestionsDetails, $nextOffset, $NOINSLOT);
                array_unshift($sqlist, $sqlStart);
            } else {
                $sqlist = array_slice($securityQuestionsDetails, $nextOffset);
                array_unshift($sqlist, $sqlStart);
            }
            P($selectorname)->bind($sqlist);
            C($selectorname)->addClass($sqlistclassname);
        }
        for ($cnt = $MAXLIST; $cnt > $NUMOFSQ; $cnt--) {
            $linodename = $linodeprefix . $cnt;
            C($linodename)->remove();
        }
        C()->evaluate('registerComboBoxControls');
        C()->evaluate('showComboBoxControls("' . $sqlistclassname . '")');
    }

    /**
     *
     * @param AuthenticateWS\user  $user
     * @return boolean
     */
    public static function hasSecurityQuestions($user) {

        try {

            $securityToken = $user->securityToken;
            $uid = $user->uid;
            $clientService = self::getWebService('AuthenticateWS');
            $param = new \AuthenticateWS\getUserSecurityQuestions();
            $param->uid = $uid;
            $param->token = $securityToken;
            $param->allQuestions = false;

            $sqresults = $clientService->getUserSecurityQuestions($param);
            $userSecurityQuestions = $sqresults->return->results;

            return $sqresults->return->results != null;
        } catch (Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'User';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     * This returns two random the security question for the user
     * @param AuthenticateWS\user  $user
     */
    public static function getSecurityQuestions($user) {
        try {
            $securityToken = $user->securityToken;
            $uid = $user->uid;
            $clientService = self::getWebService('AuthenticateWS');
            $param = new \AuthenticateWS\getUserSecurityQuestions();
            $param->token = $securityToken;
            $param->uid = $uid;
            $param->allQuestions = false;

            $sqresults = $clientService->getUserSecurityQuestions($param);
            // var_dump($sqresults);
            $userSecurityQuestions = $sqresults->return->results;

            if (!$userSecurityQuestions
                )return null;


            //get all questions detail

            $securityQuestionsDetails = SysInfo::getSecurityQuestions();


            $securityQuestionDetailsNoAns = array();
            $securityQuestionDetailsNoAns[] = null;
            $securityQuestionDetailsNoAns[] = null;
            $index = 0;
            foreach ($securityQuestionsDetails as $sqds) {
                if ($sqds['active'] == '1' &&
                        ($sqds['id'] == $userSecurityQuestions[0]->questionId ||
                        $sqds['id'] == $userSecurityQuestions[1]->questionId )) {
                    $index++;
                    if ($sqds['id'] == $userSecurityQuestions[0]->questionId)
                        $securityQuestionDetailsNoAns[0] = $sqds;
                    else
                        $securityQuestionDetailsNoAns[1] = $sqds;
                }
                if ($index == Raxan::config(self::LOGIN_SQ_CNT_NAME))
                    break;
            }

            // package  random questions
            $randSecurityQuestions = array(
                "ques1" => $securityQuestionDetailsNoAns[0],
                "ques2" => $securityQuestionDetailsNoAns[1]);


            $_SESSION['securityQuestions'] = $randSecurityQuestions;
            return $randSecurityQuestions;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'User';
            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }

        return null;
    }

    public static function validateSecurityQuestions($user, $sqAnswers) {

        try {
            $uid = $user->uid;
            $securityToken = $user->securityToken;
            $securityQuestions = Raxan::data('securityQuestions');
            $username = $user->username;

            if (!(is_array($sqAnswers) && count($sqAnswers) == Raxan::config(self::LOGIN_SQ_CNT_NAME)))
                return false;
            //$this->registerVar('securityans-incorrect', json_encode($this->questans1FP->textVal()));
            $clientService = self::getWebService('AuthenticateWS');
            $asqAnswers = array();

            // add the answer to the 1st question to assignedSecurityDTO
            $asqDTO = new \AuthenticateWS\assignedSecurityQuestionDTO();
            $asqDTO->answer = $sqAnswers[0];
            $asqDTO->uid = $uid;
            $asqDTO->questionId = $securityQuestions['ques1']['id'];
            $asqAnswers[] = $asqDTO;

            // store answer to the 2nd question to assignedSecurityDTO
            $asqDTO = new \AuthenticateWS\assignedSecurityQuestionDTO();
            $asqDTO->answer = $sqAnswers[1];
            $asqDTO->uid = $uid;
            $asqDTO->questionId = $securityQuestions['ques2']['id'];
            $asqAnswers[] = $asqDTO;

            //validate securty questions answers
            $validateSecurityQuestions = new \AuthenticateWS\validateSecurityQuestions();
            $validateSecurityQuestions->uid = $uid;
            $validateSecurityQuestions->token = $securityToken;
            $validateSecurityQuestions->responses = $asqAnswers;

            $response = $clientService->validateSecurityQuestions($validateSecurityQuestions);

            return $response->return->result;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
            return false;
        }
    }

}

?>
