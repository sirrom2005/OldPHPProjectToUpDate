<?php
/**
 * Reset User Password - Stand alone screen
 * @author: Raymond Irving
 */


require_once 'includes.php';
require_once CORPORATE_MODEL_PATH.'user.php';

use Moneyline\Common\DataModelException;
use Moneyline\Common\PublicWebPageController;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;


class ResetPasswordPage extends PublicWebPageController {

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'login.forgetpwd.view.php';
        Raxan::loadLangFile('login'); // load language file
    }
    
    protected function _load() {
        parent::_load();

        if (!$this->isAjaxRequest) {

            try {
                // get security questions
                $questions = User::getSecurityQuestions();
                $rows = is_array($questions) ? $questions : array();
                foreach($rows as $i=>$row) {
                    $questions[$row->questionID] = $row->questionText;
                }
                // save questions
                $this->data('security.questions',$questions);

                c('#username,#corpid')->keydown(_fn('
                    $("#continue").show();
                    $("#questions").hide();
                '));
            }
            catch(DataModelException $ex) {
                // data model exception
                $code = $ex->getLastErrorCode();
                $params = $ex->getLastErrorCodeParams();
                $msg = Shared::getErrorMessage($code, $params);
                $msg = '<strong>'.Raxan::locale('request.failed').'</strong>:<br />'.$msg;
                $this->flashmsg($msg,'fade','rax-box error','msgbox');
                return;
            }
            catch(Exception $ex) {
                // general exception
                Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);                
            }

        }


    }

    /**
     * Continue event
     * @param RaxanWebPageEvent $e
     * @return null
     */
    protected function continueEvent($e) {
        $post = $this->post;
        $user = $post->textVal('username');
        $domain = $post->textVal('corpid');

        try {
            // get assigned security questions
            $assignedIds = User::getAssignedSecurityQuestions($user,$domain);
            // build question list
            $myquestions = isset($assignedIds) ? $assignedIds: array();
            if (!is_array($myquestions)) $myquestions = array($questions);
            if (count($myquestions)==0) {
                $this->flashmsg(Raxan::locale('no.questions'),'fade','rax-box alert','msgbox');
            }
            else {
                c('#msgbox,#continue')->hide();
                $questions = $this->data('security.questions');
                if ($questions) for($i=0;$i<=4;$i++) {
                    if (isset($myquestions[$i])) {
                        $id = $myquestions[$i];
                        c('input[name="question'.($i+1).'"]')->val($id);
                        c('div#question'.($i+1).'text')->text($questions[$id]);
                    }
                }

                // show questions
                c('#questions')->show();
            }
        }
        catch(DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>'.Raxan::locale('request.failed').'</strong>:<br />'.$msg;
            $this->flashmsg($msg,'fade','rax-box error','msgbox');
            return;
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }

    }


    /**
     * Reset password event
     * @param RaxanWebPageEvent $e
     * @return null
     */
    protected function resetEvent($e) {
        $post = $this->post;
        $user = $post->emailVal('username');
        $domain = $post->emailVal('corpid');

        // check and validate answers
        $msg = array(); $answers = array();
        for($i = 1;$i<=4; $i++) {
            $question = $post->intVal('question'.$i);
            $answer = $post->value('answer'.$i);
            if (empty($answer)) $msg[] = Raxan::locale('answer.'.$i);
            $ans = new \CSFAdminWSService\secuirtyAnswer();
            $ans->questionID = $question;
            $ans->response = $answer;
            $answers[] = $ans;
        }
        
        if (!empty($msg)) {
            // show message
            $msg = implode(', ',$msg);
            $msg = '<strong>'.Raxan::locale('missing.fields').'</strong>:<br />'.$msg;
            $this->flashmsg($msg,'fade','rax-box alert','msgbox');
            return;
        }


        try{
            $success = User::resetPassword($domain, $user, $answers);
            if ($success) {
                $content = $this->getView('password.reset.notice.php');
                c('.master-content')->html($content);
                // save user name and domain
                Raxan::data(DataKeys::LOGIN_PRESET, array(
                    'user'    => $user,
                    'domain'  => $domain
                ));
            }
            else {
                $msg = Raxan::locale('ERR061'); // @todo: Change ERR061 to CERR061
                $this->flashmsg($msg,'fade','rax-box error','msgbox');
            }
        }
        catch(DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>'.Raxan::locale('update.failed').'</strong>:<br />'.$msg;
            $this->flashmsg($msg,'fade','rax-box error','msgbox');
            return;
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }

    }

}



?>
