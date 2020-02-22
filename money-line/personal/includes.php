<?php
/**
 * Include Moneyline Personal base files
 */

// load common includes
require_once __DIR__.'/../common/includes.php';

define('PERSONAL_PATH', __DIR__.'/');
define('PERSONAL_LIBS_PATH', __DIR__.'/libs/');
define('PERSONAL_MODEL_PATH', __DIR__.'/models/');

// load local app libs
require_once PERSONAL_LIBS_PATH.'consts.php';
require_once PERSONAL_LIBS_PATH.'datakeys.php';
require_once PERSONAL_LIBS_PATH.'shared.php';
require_once PERSONAL_LIBS_PATH.'publicwebpagecontroller.php';
require_once PERSONAL_LIBS_PATH.'securewebpagecontroller.php';


// setup global system error event handler
Raxan::bindSysEvent('system_error', function($e, $err) {
    if ($err instanceof \Moneyline\Common\DataModelException) {
        $code = $err->getMessage();
        $msg = Raxan::locale($code);
        $err = 'Uncaught '.$code.': '.$msg;
    }
    // log and redirect to error page
    Moneyline\Personal\Shared::logRedirectToErrorPage(
        Moneyline\Personal\Consts::ERROR_MODE_SYSERR,
        $err,
        'ERROR',
        'System'
    );
    return true;
});

?>