<?php
/**
 * Corporaate Login
 * @author: Raymond Irving
 * @date: 14-july-2009
 */

require_once 'includes.php';
require_once CORPORATE_MODEL_PATH.'user.php';

use Moneyline\Common\PublicWebPageController;
use Moneyline\Common\DataModelException;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;


class LoginPage extends PublicWebPageController {

    protected $moduleId = 24; // CORPORATE LOGIN
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'login.view.php';       
        Raxan::loadLangFile('login'); // load language file
    }

    protected function _init() {
        parent::_init();

        try {
            if (User::isValidUser()) {
                $do = $this->get->textVal('do'); // get action
                if ($do=='logoff'||$do=='logout') {
                    // log off user
                    User::logout();
                    Raxan::dataStorage()->resetStore(); // restart session
                    $this->redirectTo('login.php');
                }
                else { // user already logged in - show home page
                    $this->redirectTo('index.php');
                }
            }
            else {
                // show login page
                $presetLoginInfo = Raxan::data(DataKeys::LOGIN_PRESET);
                if ($presetLoginInfo && !$this->isPostBack) {
                    $this['input[name="uid"]']->val($presetLoginInfo['user']);
                    $this['input[name="corpid"]']->val($presetLoginInfo['domain']);
                    Raxan::removeData(DataKeys::LOGIN_PRESET); // reset value
                }
            }
        }
        catch(DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>'.Raxan::locale('login.failed').'</strong>:<br />'.$msg;
            $this->flashmsg($msg,'bounce','rax-box error','msgbox');  // flash to msgbox
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }

    }

    /**
     * Login Event
     * @param RaxanWebPageEvent $e
     * @return void
     */
    protected function loginEvent($e) {
        $post = $this->post;
        $corp= $post->textVal('corpid');
        $uid = $post->textVal('uid');
        $pwd = $post->value('pwd');

        // validate postback
        $msg = array();
        if (empty($corp))$msg[] = Raxan::locale('corpid');
        if (empty($uid)) $msg[]= Raxan::locale('username');
        if (empty($pwd)) $msg[]= Raxan::locale('password');
        if (!empty($msg)) {
            // show message
            $msg = implode(', ',$msg);
            $msg = '<strong>'.Raxan::locale('missing.fields').'</strong>:<br />'.$msg;
            $this->flashmsg($msg,'fade','rax-box alert','msgbox'); // flash to msgbox
            return;
        }

        try {            
            User::login($corp,$uid,$pwd); // login
            $this->redirectTo('index.php'); // redirect to home page
        }
        catch(DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>'.Raxan::locale('login.failed').'</strong>:<br />'.$msg;
            $this->flashmsg($msg,'bounce','rax-box error','msgbox');  // flash to msgbox
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }
    }

}


?>