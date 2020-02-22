<?php
/**
 * Corporate Error Page
 */

require_once 'includes.php';
require_once CORPORATE_MODEL_PATH.'user.php';

use Moneyline\Common\PublicWebPageController;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;

/**
 * Personal Error Page
 */
class ErrorPage extends PublicWebPageController {

    protected $moduleId = 25; // ERROR

    protected function _config() {
        parent::_config();
        $this->masterTemplate = null;
        $this->autoAppendView = 'error.view.php';
        Raxan::loadLangFile('errors');        
    }

    protected function _load() {
        parent::_init();

        // load data models
        try {
            if (User::isValidUser()) $this->findById('signinbtn')->remove();
            else $this->findByID('homebtn')->remove();
        }
        catch(Exception $e) {
            $err = $e->getTraceAsString();
            Raxan::log($err, 'ERROR', 'Error Page');
        }

        $modes = array('NOSSL','LOCKED','WRONGPASSWORD','WRONGPIN','INVALIDLOGIN',
            'DUPLOGON','DBERROR','NOAUTHENTICATION','NETWORKDOWN','TOOMANYDAYS',
            'NOACCESS','TIMEOUT','SYSERR','FLSHERR'
        );

        $action = !in_array($this->activeView,$modes) ? 'SYSERR' : $this->activeView;

        if ($action!='FLSHERR') {
            $title = Raxan::locale($action.'-TITLE');
            $msg = Raxan::locale($action);
            if ($title) $this->findById('errortitle')->text($title);
            $this->activeView = 'index';
            $this->flashmsg($msg,'fade',null,'errormsg'); // flash error to screen
        }
        
    }



}

?>