<?php
/**
 * Include Moneyline Corporate base files
 */

// load common includes
require_once __DIR__.'/../common/includes.php';

define('CORPORATE_PATH', __DIR__.'/');
define('CORPORATE_LIBS_PATH', __DIR__.'/libs/');
define('CORPORATE_MODEL_PATH', __DIR__.'/models/');

// load local app libs
require_once CORPORATE_LIBS_PATH.'consts.php';
require_once CORPORATE_LIBS_PATH.'datakeys.php';
require_once CORPORATE_LIBS_PATH.'shared.php';
require_once CORPORATE_LIBS_PATH.'webpagedelegates.php';


// setup global system error event handler
//Raxan::bindSysEvent('system_error', function($e, $err) {
//    if ($err instanceof \Moneyline\Common\DataModelException) {
//        // data model exception
//        $code = $ex->getLastErrorCode();
//        $params = $ex->getLastErrorCodeParams();
//        $msg = Shared::getErrorMessage($code, $params);
//        $msg = '<strong>'.Raxan::locale('update.failed').'</strong>:<br />'.$msg;
//        $err = 'Uncaught '.$code.': '.$msg;
//        $page = \Moneyline\Common\WebPageController::controller();
//        $page->flashmsg($msg,'fade','rax-box','errorbox'); // flash to msgbox
//        $page->redirectTo('error.php?FLSHERR');
//    }
//    else {
//        // log and redirect to error page
//        \Moneyline\Corporate\Shared::logRedirectToErrorPage(
//            \Moneyline\Corporate\Consts::ERROR_MODE_SYSERR,
//            $err,
//            'ERROR',
//            'SYSTEM'
//        );
//    }
//    return true;
//});

?>