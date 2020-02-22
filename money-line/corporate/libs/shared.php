<?php

namespace Moneyline\Corporate;

Use Raxan;
use Moneyline\Common\WebPageController;
use Moneyline\Corporate\Model\User;

/**
 * Corporate Shared Class
 */
class Shared extends \Moneyline\Common\Shared {

    /**
     * Check Authentication
     */
    public static function checkAuthentication() {
        try {
            $url = Raxan::config('site.url');
            if (User::isValidUser()) {
                if(!User::isValidSession()){
                    // remove valid login if user session is not valid on server
                    Raxan::removeData(DataKeys::VALID_LOGIN);
                    self::showErrorPage(Consts::ERROR_MODE_TIMEOUT);
                }
                if (User::isForcePasswordChange()) {
                    // show password change screen
                    $page = WebPageController::controller();
                    $page->redirectTo($url.'changepwd.php');
                }
                else if (!User::getUserInfo()->hasSecurityQuestions) {
                    // show security questions
                    $page = WebPageController::controller();
                    $page->redirectTo($url.'changesecquestions.php');
                }
            }
            else {
                // user not logged in so redirtect to login
                $page = WebPageController::controller();
                $page->redirectTo($url.'login.php');
            }
        }
        catch(DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = self::getErrorMessage($code, $params);
            $page = WebPageController::controller();
            $page->flashmsg($msg,'bounce','rax-box alert');
        }
        catch(Exception $ex) {
            // general exception
            self::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }
    }

    /**
     * Calls a Soap method
     * @param $parameters Associative array or NULL
     * @deprecated
     */
    public static function call($method, $parameters = null) {
        return self::getSoapClient()->{$method}($parameters);
    }

    /**
     * Clone Object
     * @deprecated
     */
    public static function cloneObject($o, $fields, $returnAsArray = false) {
        $n = array();
        $fld = explode(',', $fields);
        foreach ($fld as $f) {
            $f = trim($f);
            $n[$f] = property_exists($o, $f) ? $o->{$f} : null;
        }
        return $returnAsArray ? $n : (object) $n;
    }

    /**
     * Set or returns shared data
     * @deprecated Use Raxan::data()
     */
    public static function & data($name, $value = null) {
        return Raxan::data($name, $value);
    }

    /**
     * Reset data
     * @deprecated Use Raxan::removeData()
     */
    public static function removeData($name) {
        Raxan::removeData($name);
    }


    /**
     * Redirect to website
     * @deprecated Use Raxan::redirectTo()
     */
    public static function redirectTo($url) {
        header('Location: ' . $url);
        exit();
    }

    public static function sortRecord($records, $orderBy, $reverse = false) {
        $tmp = array();
        $new = array();
        foreach ($records as $k => $row)
            $tmp[$k] = strtolower($row[$orderBy]);
        if ($reverse)
            arsort($tmp); else
            asort($tmp);
        foreach ($tmp as $k => $row)
            $new[] = $records[$k];
        return $new;
    }


}

?>