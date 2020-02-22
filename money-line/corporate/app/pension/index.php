<?php

require_once __DIR__.'/../../includes.php';
require_once COMMON_PATH.'app/pension/index.php';

require_once CORPORATE_MODEL_PATH.'user.php';

use Moneyline\Common\Model\Pension;
use Moneyline\Common\DataModelException;
use Moneyline\Common\Pension\IPensionPage;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;

class PensionPage extends IPensionPage {

    protected $moduleId = 29; // CORPORATE PENSION

    protected $P3_SUBJECT_ID_KEY = "pension.memno";
    protected $APPLET_ACL_FEATURE = "P3Access";

    /**
     * Check Module Access
     * @return boolean
     */
    protected function  ICheckModuleAccess() {
        // ensure user has appropriate access to applet
        $status = User::hasFeature($this->APPLET_ACL_FEATURE);
        if (!$status) {
            $url = Raxan::config('site.url');
            Raxan::redirectTo($url.'error.php?vu=NOACCESS');
        }
        return $status;
    }

    /**
     * Returns Pension number
     * @return int
     */
    protected function IGetPensionNumber() {
        try {
            // get the the P3 Member number
            $userInfo = User::getUserInfo();
            $memno = (array_key_exists($this->P3_SUBJECT_ID_KEY, $userInfo->properties)
                    ?$userInfo->properties[$this->P3_SUBJECT_ID_KEY] : "");
            if (empty($memno)) {
                $msg = Raxan::locale('E-NOMEMNO');
                $this->flashmsg($msg,'fade',null,'errormsg');
                $url = Raxan::config('site.url');
                Raxan::redirectTo($url.'error.php?vu=FLSHERR');
            }
            return $memno;
        }
        catch (DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>' . Raxan::locale('request.failed') . '</strong>:<br />' . $msg;
            $this->flashmsg($msg, 'fade', 'rax-box error', 'msgbox'); // flash to msgbox
            return;
        }
        catch (Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }
    }

    // show error
    protected function IShowError($errMode)  {
        Shared::showErrorPage($errMode);
    }

    // navigate to home page
    protected function INavHome()  {
        $this->redirectTo('index.php');
    }
}


?>