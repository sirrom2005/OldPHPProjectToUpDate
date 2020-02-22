<?php
/**
 * Error Page
 */

require_once 'includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Shared;
use Moneyline\Personal\PublicWebPageController;
use Moneyline\Personal\Model\User;

/**
 * Personal Error Page
 */
class ErrorPage extends PublicWebPageController {

    protected $moduleId = 10; // ERROR 

    protected function _config() {
        parent::_config();
        
        Raxan::loadWidget('moneyline/messagebox');
    }

    protected function _init() {
        parent::_init();

        $this->appendView('error.view.php');

        // load data models
        try {
            User::initLocale();
            if (User::isLogin()) $this->signinbtn->remove();
            else $this->homebtn->remove();
        }
        catch(Exception $e) {
            $err = $e->getTraceAsString();
            Raxan::log($err, 'ERROR', 'Error Page');
        }

        Raxan::loadLangFile('errors');
        

        $modes=array('NOSSL','LOCKED','WRONGPASSWORD','WRONGPIN','INVALIDLOGIN',
            'DUPLOGON','DBERROR','NOAUTHENTICATION','NETWORKDOWN','TOOMANYDAYS',
            'NOACCESS','SYSERR'
        );

        $action = !in_array($this->activeView,$modes) ? 'SYSERR' : $this->activeView;

        $title = Raxan::locale($action.'-TITLE');
        $msg = Raxan::locale($action);
        if ($title) $this->errortitle->text($title);
        $this->errormsg->html($msg);

        $this->activeView = 'index';

    }



}

?>