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

class ChangePasswordPage extends PublicWebPageController {

    protected $moduleId = 32; //Change password

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'changepwd.view.php';
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
            if (!User::isForcePasswordChange())
                $this->redirectTo('index.php'); // redirect to index.php
        }
    }

    // change event
    protected function changeEvent($e) {
        $post = $this->post;
        
        $old = $post->value('old');
        $pwd1 = $post->value('pwd1');
        $pwd2 = $post->value('pwd2');

        // validate postback
        $msg = array();
        if (empty($old))$msg[] = Raxan::locale('old.password');
        if (empty($pwd1)) $msg[]= Raxan::locale('new.password');
        if (empty($pwd2)) $msg[]= Raxan::locale('retype.password');
        if ($pwd1 && $pwd1!=$pwd2) $msg[]= Raxan::locale('password.mismatched');
        if (!empty($msg)) {
            // show message
            $msg = implode(', ',$msg);
            $msg = '<strong>'.Raxan::locale('missing.or.mismatched').'</strong>:<br />'.$msg;
            $this->flashmsg($msg,'fade','rax-box alert','msgbox');
            return;
        }

        try {
            // change password
            User::changePassword($old, $pwd1);
            $this->redirectTo('index.php');
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