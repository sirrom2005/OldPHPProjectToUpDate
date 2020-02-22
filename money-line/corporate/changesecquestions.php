<?php
/**
 * Change User Password - Stand alone screen
 * Displayed after logging in for the first time
 * @author: Raymond Irving
 * @date: 14-july-2009
 */


require_once 'includes.php';
require_once CORPORATE_MODEL_PATH.'user.php';

use Moneyline\Common\DataModelException;
use Moneyline\Common\PublicWebPageController;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;

class ChangeQuestionsPage extends PublicWebPageController {

    protected $moduleId = 35; // Change Security Questions

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'changesecquest.view.php';
    }

    protected function _init() {
        parent::_init();
        Raxan::loadLangFile('login'); // load language file
    }


    protected function _load() {
        parent::_load();

        if (!User::isValidUser()) {
            // user not logged in
            $this->redirectTo('login.php');
        }
        else {
            // check if we should allow users to view this page
            $userInfo = User::getUserInfo();
            if ($userInfo->forcePasswordChange)
                $this->redirectTo('changepwd.php'); // redirect to changepwd.php
            if ($userInfo->hasSecurityQuestions)
                $this->redirectTo('index.php');     // redirect to index.php is already set

            // append security questions
            $this['.security-questions']->appendView('security.questions.php'); 

            try {
                // setup security questions
                $questions = User::getSecurityQuestions();
                $rows = is_array($questions) ? $questions : array();
                foreach($rows as $row) {
                    $questions[] = (array)$row;
                }
                $this['select']->bind($questions);
            }
            catch(DataModelException $ex) {
                // data model exception
                $code = $ex->getLastErrorCode();
                $params = $ex->getLastErrorCodeParams();
                $msg = Shared::getErrorMessage($code, $params);
                $msg = '<strong>'.Raxan::locale('request.failed').'</strong>:<br />'.$msg;
                $this->flashmsg($msg,'fade','rax-box error','msgbox'); // flash to msgbox
                $this->findById('webForm')->hide();
                return;
            }
            catch(Exception $ex) {
                // general exception
                Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
            }

        }
    }

    // change event
    protected function changeEvent($e) {
       
        // check and validate answers
        $post = $this->post;
        $msg = array();
        $answers = array(); $tmp = array();
        for($i = 1;$i<=4; $i++) {
            $question = $post->intVal('question'.$i);
            $answer = $post->value('answer'.$i);
            if (isset($tmp[$question])) $msg[] = Raxan::locale('question.inuse',$i);
            if (empty($answer)) $msg[] = Raxan::locale('answer.'.$i);
            $ans = new \CSFAdminWSService\secuirtyAnswer();
            $ans->questionID = $question;
            $ans->response = $answer;
            $answers[] = $ans;
            $tmp[$question] = true;
        }

        if (!empty($msg)) {
            // show message
            $msg = implode(', ',$msg);
            $msg = '<strong>'.Raxan::locale('missing.fields').'</strong>:<br />'.$msg;
            $this->flashmsg($msg,'fade','rax-box alert','msgbox');
            return;
        }

        try {
            // update login security question info
            User::saveSecurityAnswers($answers);
            $this->redirectTo('index.php'); // use ajax redirect
        }
        catch(DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>'.Raxan::locale('update.failed').'</strong>:<br />'.$msg;
            $this->flashmsg($msg,'fade','rax-box error','msgbox'); // flash to msgbox
            return;
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }

    }

}


?>