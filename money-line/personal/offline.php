<?php
/**
 * Offline Page
 */

require_once 'includes.php';

use Moneyline\Personal\PublicWebPageController;

class OfflinePage extends PublicWebPageController {

    protected $moduleId = 11; // SYSTEM

    protected function _config() {
        parent::_config();

        $this->autoAppendView = 'offline.view.php'; // automatically append offline.view.php

        // check if we should display the offline screen
        if (!Raxan::config('system-offline')) $this->redirectTo('login.php');
        else {            
            Raxan::loadLangFile('offline'); // load offilne language file
        }
    }
    
}

?>