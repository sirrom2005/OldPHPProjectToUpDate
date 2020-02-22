<?php
// load common included files
require 'common/includes.php';

/**
 * Moneyline Landing Page
 */
class Page extends RaxanWebPage {

    protected function  _config() {
        $this->masterTemplate = 'common/views/master.php';
        $this->autoAppendView = 'landing.view.php';
    }

}

?>