<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\AccessLog;
use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Shared;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;

/**
 * Description of unRegPC
 * @author lloydj
 */
class unRegPC extends SecureWebPageController {

    protected $moduleId = 2; // ACCOUNT SUMMARY

    const MSG_UNREGISTERPC_TAG      = "unregisterPCMessage";
    const MSG_PCNOTREGISTERED_TAG   = "PCnotunregisterMessage";
    //protected  $degradable = true;
    protected function  _init() {
        parent::_init();
         $this->registerEvent('unregister','.unregisterPC');
         Raxan::loadLangFile('login');
         $msg = Raxan::locale(unRegPC::MSG_UNREGISTERPC_TAG);
         $this->registerVar("unregisterPCMsg", $msg);
         $msg = Raxan::locale(unRegPC::MSG_PCNOTREGISTERED_TAG);
         $this->registerVar("PCnotregisterPCMsg", $msg);
    }

    /**
     * Unregister PC
     * This event is triggered from a button on the web page
     * @param RaxanEvent $e
     */
    protected function unregisterPC($e)
    {
        $username = Shared::data("login-name");
        
        try
        {

            if( rememberSQ::unRegisterPC($username))
            {
                $cookieName = rememberSQ::cookieName($username);
                C("#unregpc")->addClass("hide");
                C()->evaluate("DeleteCookie('".$cookieName."')");
                Accesslog::log(AccessLog::ACTION_UNREGISTER_PC);
                return "successful";
            }
             else {
                   return "failed";
            }


        }catch(Exception $e)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level,$label );
            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_SYSERR);
            $this->showErrorMessage($msg);

            Accesslog::log(Accesslog::ACTION_UNREGISTER_PC_FAILED);
            
        }
        return "failed";
    }
    

}
?>
