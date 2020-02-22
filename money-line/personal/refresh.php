<?php

require_once '../../includes.php';

use Moneyline\Personal\Shared;
use Moneyline\Personal\SecureWebPageController;

/**
 * This page is used to refresh or update the client's session to
 * prevent it from timing out.
 */
class RefreshSessionPage extends SecureWebPageController {

    protected $moduleId = 11; // SYSTEM

    protected function _load() {
        parent::_load();
        Shared::data('refresh-session'); // retrieve a key from the session
        $this->halt('OK');
    }

}