<?php

namespace Moneyline\Personal;

use Raxan, RaxanWebPage;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;

/**
 * Personal Shared Class
 */
class Shared extends \Moneyline\Common\Shared {

    // @todo: move to SharedConsts
    /* error modes  */
    const ERROR_MODE_NOSSL = 'NOSSL';
    const ERROR_MODE_LOCKED = 'LOCKED';
    const ERROR_MODE_WRONGPASSWORD = 'WRONGPASSWORD';
    const ERROR_MODE_WRONGPIN = 'WRONGPIN';
    const ERROR_MODE_INVALIDLOGIN = 'INVALIDLOGIN';
    const ERROR_MODE_DUPLOGON = 'DUPLOGON';
    const ERROR_MODE_DBERROR = 'DBERROR';
    const ERROR_MODE_NETWORKDOWN = 'NETWORKDOWN';
    const ERROR_MODE_TOOMANYDAYS = 'TOOMANYDAYS';
    const ERROR_MODE_SYSERR = 'SYSERR';
    const ERROR_MODE_NOACCESS = 'NOACCESS';
    const ERROR_MODE_NOAUTHENTICATION = 'NOAUTHENTICATION';
    const ERROR_MODE_NOSECURITYQUESTIONS = 'NOSECURITYQUESTIONS';
    const ERROR_MODE_INCORRECTSECURITYANSWERS ='INCORRECTSECURITYANSWERS';
    const ERROR_MODE_INVALIDSECURITYCODE ='INVALIDSECURITYCODE';
    const ERROR_MODE_PASSWORDNOTCHANGED ='PASSWORDNOTCHANGED';
    const ERROR_MODE_EMAILSECUIRTYKEY ="EMAILSECUIRTYKEY";
    const ERROR_MODE_INVALIDPIN ="INVALIDPIN";

    // @todo: To be moved to SharedConsts ??
    //verification key types 
    const VERIFICATION_KEY_TYPES_FORGETPWD ='FORGETPWD';
    const VERIFICATION_KEY_TYPES_CHANGEPIN ='CHANGEPIN';
    const VERIFICATION_KEY_TYPES_CHANGEPWD ='CHANGEPWD';

    // @todo: to be moved toSjharedConsts ??
    //LOgin Remember PC
    const LOGIN_REMEMBERPC ='REMEMBERPC';


    // Returns or sets session data value
    public static function &data($name, $value = null) {
        return Raxan::dataBank(self::$appId, $name, $value);
    }

    // remove data value
    public static function removeData($name) {
        return Raxan::removeDataBank(self::$appId, $name);
    }

    /**
     * Log and redirect to Error Page
     * @param $logMsg String or Exception object
     */
    public static function logRedirectToErrorPage($errMode, $logMsg = null, $level = 'ERROR', $label = null) {
        if (is_object($logMsg)) {
            $logMsg = $logMsg->getMessage() . "\n" .
                    $logMsg->getTraceAsString() . "\n";
        }

        Raxan::log($logMsg, $level, $label);
        self::showErrorPage($errMode);
    }

    /**
     * Show Error Page
     */
    public static function showErrorPage($errMode) {
        $page = RaxanWebPage::controller(); // get default page controller
        $url = Raxan::config('site.url');
        Raxan::redirectToView($errMode, $url . 'error.php', $page->isAjaxRequest);
    }

    // @todo: To be removed
    public static function showMessage($message, $continuebtn=true) {
        $var = _var($message);
        C()->evaluate("showMessage($var,$continuebtn)");
    }

    /**
     * Returns friendly greeting
     */
    // @todo: To be moved to Personal\SecureWebPage
    public static function getFriendlyGreeting() {
        if (date('H') >= 4 && date('H') < 12)
            $greet = Raxan::locale('good-morning');
        else if (date('H') >= 12 && date('H') <= 16)
            $greet = Raxan::locale('good-afternoon');
        else if (date('H') >= 17 && date('H') <= 19)
            $greet = Raxan::locale('good-evening');
        else
            $greet = Raxan::locale('good-night');
        return $greet;
    }

}


?>