<?php

require_once 'includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\AccessLog;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\Shared;
use Moneyline\Personal\PublicWebPageController;

class LogoutPage extends PublicWebPageController {

    protected $moduleId = 1; // LOGIN
    
    protected function _init() {
        parent::_init();
        try {
            $uid = User::getUniversalId();
            if (User::logout()) {
                AccessLog::log(AccessLog::ACTION_LOGOUT_SUCCESSFUL, $uid);
                $this->redirectTo('login.php');            
            }
        }catch (Exception $err) {
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $err,'ERROR',__CLASS__);
        }
    }


}

?>