<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\AccessLog;
use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;

/**
 * User Preferences
 * @author lloydj
 */
class UserPreferencesPage extends SecureWebPageController {

    protected $moduleId = 6; // USER PROFILE

    const ERROR_MSG_USER_PREFERENCES_NOT_SAVED ="USERPREFERENCESNOTSAVED";
    const SAVED_MSG_USER_PREFERENCES_SAVED ="UserPreferencesSavedMessage";
    const ERROR_MSG_USER_PREFERENCES_SV_FAILED ="USERPREFERENCESVFAILED";
    const EMAIL_MSG_EMAIL_VERIFICATION_SENT ="EMAILSECUIRTYKEY";
    const ERROR_MSG_EMAIL_SECUIRTY_KEY_UP ="EMAILSECUIRTYKEYUP";

    const LANG_FILE_NAME ="UserPreferences";
    const ERROR_FILE_NAME ="errors";
    const DATA_USER ="user";
    const DATA_TMP_USERPREFERENCES ="tmp.user.prefers";
    const DATA_LOGIN_NAME ="login-name";

    protected function _config() {
        parent::_config();
        Raxan::loadLangFile(self::LANG_FILE_NAME);
        $this->mnuItem = 'PREF';
        $this->preserveFromContent = true;
    }

    protected function _indexView() {
        $this->appendView('user.preferences.view.php');
    }

    protected function _load() {
        parent::_load();


        // register locale for use on client
        if (!$this->isAjaxRequest) {

            $topMenu = $this->getTopLevelMenuId($this->mnuItem);
            $menus = User::getUserMenus($topMenu);
            if (isset($menus[0]) && $menus[0]['menuId'] == $this->mnuItem) {
                array_shift($menus); // remove overview menu
            }

            $this["#help"]->bind("#click", array(
                "callback" => ".showHelp",
                //"data"=>"login",
                "prefTarget" => "target@help.php?vuh=profile"
            ));

            //invalid.policy.type
            $this->registerVar('invalid-policy-type', $this->Raxan->locale('invalid.policy.type'));
            $this->registerVar('lock-tip', $this->Raxan->locale('lock.user.preference'));
            $this->registerVar('lock-tooltip', $this->Raxan->locale('lock.tooltip'));

            $this->sanitizer = Raxan::dataSanitizer();
            $this->sanitizer->enableDirectInput();
            $this->loadUserPreferences();
        }
    }

    private function loadUserPreferences() {

        $accTypes = SysInfo::getAccountDetails(); //getProductTypes();//
        uasort($accTypes, "accTypesCMP");
        $this->selDefaultAccountType->bind($accTypes);

        $branches = SysInfo::getBranches();
        $this->selDefaultBranch->bind($branches);

        $terms = SysInfo::getTradeTerms();
        $this->selDefaultTradeTerms->bind($terms);

        $clientAccounts = User::getClientAccounts();
        // get the user's default account so that it can be set
        //$preferences = User::getUserPreferences();
        //$defaultAccount = $preferences["default_account_no"];

        $this->selDefaultAccount->bind($clientAccounts);



        // list currencies
        $currencyRates = SysInfo::getAllFxRatesAmount();
        $this->selDisCurrTotals->bind($currencyRates);

        $mobileProviders = SysInfo::getMobileProviders();
        $this->selCellPhoneProvider->bind($mobileProviders);
        $velocityTotal = User::getTransactionVelocityTotal();

        $pref = User::getUserPreferences();

        C("#aclCheques")->attr("checked", ($pref->aclAllowCheques == 1 || $pref->aclAllowCheques == 3 ? "checked" : ""))->val($pref->aclAllowCheques);
        C("#spaclCheques, #aclCheques ")->attr("disabled", ( $pref->aclAllowCheques == 2 || $pref->aclAllowCheques == 3 ? "true" : ""));
        C("#aclIntTransfers")->attr("checked", ($pref->aclAllowInternalTransfers == 1 || $pref->aclAllowInternalTransfers == 3 ? "checked" : ""))->val($pref->aclAllowInternalTransfers);
        C("#spaclIntTransfers, #aclIntTransfers")->attr("disabled", ($pref->aclAllowInternalTransfers == 2 || $pref->aclAllowInternalTransfers == 3 ? "true" : ""));
        C("#aclWires")->attr("checked", ($pref->aclAllowLocalWires == 1 || $pref->aclAllowLocalWires == 3 ? "checked" : ""))->val($pref->aclAllowLocalWires);
        C("#spaclWires, #aclWires")->attr("disabled", ($pref->aclAllowLocalWires == 2 || $pref->aclAllowLocalWires == 3 ? "true" : ""));
        C("#aclIntrWires")->attr("checked", ($pref->aclAllowInternationalWires == 1 || $pref->aclAllowInternationalWires == 3 ? "checked" : ""))->val($pref->aclAllowInternationalWires);
        C("#spaclIntrWires, #aclIntrWires")->attr("disabled", ($pref->aclAllowInternationalWires == 2 || $pref->aclAllowInternationalWires == 3 ? "true" : ""));
        C("#aclCambio")->attr("checked", ($pref->aclAllowCambio == 1 || $pref->aclAllowCambio == 3 ? "checked" : ""))->val($pref->aclAllowCambio);
        C("#spaclCambio, #aclCambio")->attr("disabled", ($pref->aclAllowCambio == 2 || $pref->aclAllowCambio == 3 ? "true" : ""));
        C("#aclStandOrder")->attr("checked", ($pref->aclAllowStandingOrder == 1 || $pref->aclAllowStandingOrder == 2 ? "checked" : ""))->val($pref->aclAllowStandingOrder);
        C("#spaclStandOrder, #aclStandOrder")->attr("disabled", ($pref->aclAllowStandingOrder == 2 || $pref->aclAllowStandingOrder == 2 ? "true" : ""));
        C("#aclEquity")->attr("checked", ($pref->aclAllowEquity == 1 || $pref->aclAllowEquity == 3 ? "checked" : ""))->val($pref->aclAllowEquity);
        C("#spaclEquity, #aclEquity")->attr("disabled", ($pref->aclAllowEquity == 2 || $pref->aclAllowEquity == 3 ? "true" : ""));

        C("#verUserPrefModification")->attr("checked", ($pref->aclVerifyUserPreference == 1 || $pref->aclVerifyUserPreference == 3 ? "checked" : ""))->val($pref->aclVerifyUserPreference);
        C("#spverUserPrefModification, #verUserPrefModification")->attr("disabled", ($pref->aclVerifyUserPreference == 2 || $pref->aclVerifyUserPreference == 3 ? "true" : ""));
        C("#verPayeeWireTrans")->attr("checked", ($pref->aclVerifyWirePayee == 1 || $pref->aclVerifyWirePayee == 3 ? "checked" : ""))->val($pref->aclVerifyWirePayee);
        C("#spverPayeeWireTrans, #verPayeeWireTrans")->attr("disabled", ($pref->aclVerifyWirePayee == 2 || $pref->aclVerifyWirePayee == 3 ? "true" : ""));
        C("#verPayeeChequeEncashment")->attr("checked", ($pref->aclVerifyEncashPayee == 1 || $pref->aclVerifyEncashPayee == 3 ? "checked" : ""))->val($pref->aclVerifyEncashPayee);
        C("#spverPayeeChequeEncashment, #verPayeeChequeEncashment")->attr("disabled", ($pref->aclVerifyEncashPayee == 2 || $pref->aclVerifyEncashPayee == 3 ? "true" : ""));
        C("#verPayeeInternalTransfers")->attr("checked", ($pref->aclVerifyInternalPayee == 1 || $pref->aclVerifyInternalPayee == 3 ? "checked" : ""))->val($pref->aclVerifyInternalPayee);
        C("#spverPayeeInternalTransfers, #verPayeeInternalTransfers")->attr("disabled", ($pref->aclVerifyInternalPayee == 2 || $pref->aclVerifyInternalPayee == 3 ? "disabed" : ""));

        C("#umpWireTransfer")->attr("checked", ($pref->aclUserCanEditWirePayee == 1 || $pref->aclUserCanEditWirePayee == 3 ? "checked" : ""))->val($pref->aclUserCanEditWirePayee);
        C("#spumpWireTransfer, #umpWireTransfer")->attr("disabled", ($pref->aclUserCanEditWirePayee == 2 || $pref->aclUserCanEditWirePayee == 3 ? "true" : ""));
        C("#umpChequeEncashment")->attr("checked", ($pref->aclUserCanEditEncashPayee == 1 || $pref->aclUserCanEditEncashPayee == 3 ? "checked" : ""))->val($pref->aclUserCanEditEncashPayee);
        C("#spumpChequeEncashment, #umpChequeEncashment")->attr("disabled", ($pref->aclUserCanEditEncashPayee == 2 || $pref->aclUserCanEditEncashPayee == 3 ? "true" : ""));
        C("#umpInternalTransfer")->attr("checked", ($pref->aclUserCanEditInternalPayee == 1 || $pref->aclUserCanEditInternalPayee == 3 ? "checked" : ""))->val($pref->aclUserCanEditInternalPayee);
        C("#spumpInternalTransfer, #umpInternalTransfer")->attr("disabled", ($pref->aclUserCanEditInternalPayee == 2 || $pref->aclUserCanEditInternalPayee == 3 ? "true" : ""));

        C("#aclDailyLimitChange")->attr("checked", ($pref->aclUserCanEditDailyLimit == 1 || $pref->aclUserCanEditDailyLimit == 3 ? "checked" : ""))->val($pref->aclUserCanEditDailyLimit);
        C("#spaclDailyLimitChange, #aclDailyLimitChange")->attr("disabled", ($pref->aclUserCanEditDailyLimit == 2 || $pref->aclUserCanEditDailyLimit == 3 ? "true" : ""));


        C("#shAccountSummary")->attr("checked", ($pref->showAccountSummary == 1 ? "checked" : ""));
        C("#shExpressRequests")->attr("checked", ($pref->showExpressRequest == 1 ? "checked" : ""));
        C("#shMessages")->attr("checked", ($pref->showMessages == 1 ? "checked" : ""));
        C("#shPrintStatements")->attr("checked", ($pref->showPrintStatement == 1 ? "checked" : ""));
        C("input[name=rdAccountSummaryView][value=$pref->accountSummaryView]")->attr("checked", "checked");
        $showDetails = ($pref->showDetails == 1 ? 1 : 0);
        C("input[name=rdAccountSummaryDetails][value=$showDetails]")->attr("checked", "checked");
        $this->selDisCurrTotals->val($pref->currency);

        C("input[name=rdPensionViewDetails][value=$pref->pensionViewMode]")->attr("checked", "checked");
        C("#acUseTransWizard")->attr("checked", ($pref->useTransactionWizard == 1 ? "checked" : ""));
        C("#acEnableBroRegist")->attr("checked", ($pref->rememberSecurityQuestions == 1 || $pref->rememberSecurityQuestions == 3 ? "checked" : ""))->val($pref->rememberSecurityQuestions);
        C("#spacEnableBroRegist, #acEnableBroRegist")->attr("disabled", ($pref->rememberSecurityQuestions == 2 || $pref->rememberSecurityQuestions == 3 ? "true" : ""));
        C("#acMaskAcNo")->attr("checked", ($pref->maskAccountNo == 1 || $pref->maskAccountNo == 3 ? "checked" : ""))->val($pref->maskAccountNo);
        C("#spacMaskAcNo, #acMaskAcNo")->attr("disabled", ($pref->maskAccountNo == 2 || $pref->maskAccountNo == 3 ? "true" : ""));
        $this->selDefaultAccount->val($pref->defaultAccountNo);
        $this->selDefaultBranch->val($pref->branchCode);
        $this->selDefaultTradeTerms->val($pref->defaultTradeTerm);
        $this->selDefaultAccountType->val($pref->accountType);
        $this->acCellPhoneNo->val($pref->mobileNumber);

        $this->selNoofTrnx->val($pref->noOfTxns);
        //email transaction receipt
        if ($pref->disableEmailReceipts == 2) {// OFF
            C("#stEmailTransReceipts")->html("OFF")->addClass("show-off");
        } else {
            C("#stEmailTransReceipts")->html("ON")->addClass("show-on");
        }

        C("#atmCurrentUseage")->html($velocityTotal);
        C("#dlyTransactionLimit")->val($pref->dailyTransactionLimit);
        C("#dtlCurrency")->html($pref->currency);
        $remoteaddr = $_SERVER["REMOTE_ADDR"];
        C("#upLastLogin")->html($remoteaddr);

        C("#upUserName")->html(Shared::data('customer-name'));


        $viewHistory = $this->getLoginHistory();

        $this->lstHistory->bind($viewHistory);

        if ($pref->aclVerifyUserPreference == 1 ||
                $pref->aclVerifyUserPreference == 3) {
            C("#prefContinuebtn")->removeClass("hide");
            C("#prefSavebtn")->addClass("hide");
            $this->showSecurityQuestions();
        } else {
            C("#prefContinuebtn")->addClass("hide");
            C("#prefSavebtn")->removeClass("hide");
        }

        $transPolicyLevel = _var($pref->transactionPolicyLevel * 20);
        $this->registerVar("slider-init-value", $transPolicyLevel);
        C()->evaluate("upInit($transPolicyLevel)");
        //Raxan::data(self::DATA_USERPREFERENCES, $pref);

        //$this->showMessage(print_r($pref,true));
    }

    private function getLoginHistory() {
        $viewHistory = array();
        try {

            // @todo: move code to model
            
            //view login history
            $sql = "SELECT TOP 10 [id],[remote_ip],[dtstamp] " .
                    "FROM [webdata].[dbo].[AccessLog] where action_id=:action and " .
                    "uid=:uid order by dtstamp desc";
            $uid = User::getUniversalId();
            $result = \Moneyline\Common\DataModel::query($sql, array(
                        ':uid' => $uid,
                        ':action' => AccessLog::ACTION_LOGIN_SUCCESSFUL
                    ));


            $rows = $result->fetchAll(PDO::FETCH_ASSOC);
            if ($rows) {
                foreach ($rows as $i => $row) {
                    $viewHistory[$i]['ID'] = $row["id"];
                    $viewHistory[$i]['remoteIP'] = $row["remote_ip"];
                    $viewHistory[$i]['dtstamp'] = $this->Raxan->cDate($row["dtstamp"])->format("l, F j, Y , h:i:s a ");
                }
            }

            return $viewHistory;
        } catch (Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Raxan::loadLangFile(self::ERROR_FILE_NAME);
            $msg = Raxan::locale(Shared::ERROR_MODE_SYSERR);
            $this->showErrorMessage($msg);
            Shared::logRedirectToErrorPage($err, $ex, $level, $label);

            Accesslog::log(Accesslog::ACTION_CANNOT_SAVE_USER_PREFERENCES);
            return null;
        }
        return null;
    }

    private function canUpdatePreference($preference) {
        return ($preference == 0 || $preference == 1);
    }

    private function validatePreference($preference, $newvalue) {
        if (self::canUpdatePreference($preference)) {
            if ($newvalue) {
                $preference = ($newvalue == "on" ? 1 : $newvalue);
            } else {
                $preference = 0;
            }
        }

        return $preference;
    }

    private function collectUserPreferences() {
        try {
            $pref = User::getUserPreferences();
            $pref->aclAllowCheques = self::validatePreference($pref->aclAllowCheques, $this->post->hid_aclCheques);
            $pref->aclAllowInternalTransfers = self::validatePreference($pref->aclAllowInternalTransfers, $this->post->hid_aclIntTransfers);
            $pref->aclAllowLocalWires = self::validatePreference($pref->aclAllowLocalWires, $this->post->hid_aclWires);
            $pref->aclAllowInternationalWires = self::validatePreference($pref->aclAllowInternationalWires, $this->post->hid_aclIntrWires);
            $pref->aclAllowCambio = self::validatePreference($pref->aclAllowCambio, $this->post->hid_aclCambio);
            $pref->aclAllowStandingOrder = self::validatePreference($pref->aclAllowStandingOrder, $this->post->hid_aclStandOrder);
            $pref->aclAllowEquity = self::validatePreference($pref->aclAllowEquity, $this->post->hid_aclEquity);
            $pref->aclUserCanEditWirePayee = self::validatePreference($pref->aclUserCanEditWirePayee, $this->post->hid_umpWireTransfer);
            $pref->aclUserCanEditEncashPayee = self::validatePreference($pref->aclUserCanEditEncashPayee, $this->post->hid_umpChequeEncashment);
            $pref->aclUserCanEditInternalPayee = self::validatePreference($pref->aclUserCanEditInternalPayee, $this->post->hid_umpInternalTransfer);
            $pref->aclVerifyUserPreference = self::validatePreference($pref->aclVerifyUserPreference, $this->post->hid_verUserPrefModification);
            $pref->aclVerifyWirePayee = self::validatePreference($pref->aclVerifyWirePayee, $this->post->hid_verPayeeWireTrans);
            $pref->aclVerifyEncashPayee = self::validatePreference($pref->aclVerifyEncashPayee, $this->post->hid_verPayeeChequeEncashment);
            $pref->aclVerifyInternalPayee = self::validatePreference($pref->aclVerifyInternalPayee, $this->post->hid_verPayeeInternalTransfers);
            $pref->showAccountSummary = self::validatePreference($pref->showAccountSummary, $this->post->shAccountSummary);
            $pref->showMessages = self::validatePreference($pref->showMessages, $this->post->shMessages);
            $pref->showPrintStatement = self::validatePreference($pref->showPrintStatement, $this->post->shPrintStatements);
            $pref->showExpressRequest = self::validatePreference($pref->showExpressRequest, $this->post->shExpressRequests);
            $pref->useTransactionWizard = self::validatePreference($pref->useTransactionWizard, $this->post->acUseTransWizard);
            $pref->rememberSecurityQuestions = self::validatePreference($pref->rememberSecurityQuestions, $this->post->hid_acEnableBroRegist);
            $pref->maskAccountNo = self::validatePreference($pref->maskAccountNo, $this->post->hid_acMaskAcNo);
            $pref->transactionPolicyLevel = $this->post->hid_transPolicy;

            $pref->showDetails = ($this->post->rdAccountSummaryDetails == "1" ? 1 : 0);
            $pref->dailyTransactionLimit = $this->post->dlyTransactionLimit;
            $pref->accountSummaryView = $this->post->rdAccountSummaryView;
            $pref->noOfTxns = $this->post->selNoofTrnx;
            $pref->currency = $this->post->selDisCurrTotals;
            $pref->branchCode = $this->post->selDefaultBranch;
            $pref->accountType = $this->post->selDefaultAccountType;
            $pref->pensionViewMode = $this->post->rdPensionViewDetails;
            $pref->defaultTradeTerm = $this->post->selDefaultTradeTerms;
            $pref->mobileNumber = $this->post->acCellPhoneNo;
            $pref->mobileProvider = $this->post->selCellPhoneProvider;
            $pref->defaultAccountNo = $this->post->selDefaultAccount;

            return $pref;
        } catch (Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level, $label);
            Accesslog::log(AccessLog::ACTION_CANNOT_RESEND_VERIFICATION_KEY);

            return null;
        }
    }

    private function saveUserPreferences($pref) {
        $username = Shared::data(self::DATA_LOGIN_NAME);
        try {
            //save User Preferences
            User::saveUserPreferences($pref);

            Raxan::loadLangFile(self::LANG_FILE_NAME);
            $msg = Raxan::locale(self::SAVED_MSG_USER_PREFERENCES_SAVED);
            $this->showSuccessMessage($msg);
            Accesslog::log(AccessLog::ACTION_SAVE_USER_PREFERENCES);

        }
        catch (Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Raxan::loadLangFile(self::ERROR_FILE_NAME);
            $msg = Raxan::locale(Shared::ERROR_MODE_SYSERR);
            $this->showErrorMessage($msg);
            Shared::logRedirectToErrorPage($err, $ex, $level, $label);

            Accesslog::log(Accesslog::ACTION_CANNOT_SAVE_USER_PREFERENCES);
            return false;
        }
    }

    /**
     *
     * @param RaxanEvent $e
     * @return <type>
     *
     */
    protected function savePreferences($e) {
        $username = Shared::data(self::DATA_LOGIN_NAME);
        $this->registerVar('verify', "failed");
        try {

            $pref = $this->collectUserPreferences();
            if ($this->saveUserPreferences($pref)) {
                if ($pref->aclVerifyUserPreference == 1 ||
                        $pref->aclVerifyUserPreference == 3) {
                    C("#prefContinuebtn")->removeClass("hide");
                    C("#prefSavebtn")->addClass("hide");
                    $this->showSecurityQuestions();
                }
                $this->registerVar('verify', "success");
                return "success";
            }
        } catch (Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Raxan::loadLangFile(self::ERROR_FILE_NAME);
            $msg = Raxan::locale(Shared::ERROR_MODE_SYSERR);
            $this->showErrorMessage($msg);
            Shared::logRedirectToErrorPage($err, $ex, $level, $label);

            Accesslog::log(Accesslog::ACTION_CANNOT_SAVE_USER_PREFERENCES);
        }
        return "failed";
    }

    protected function showSecurityQuestions() {
        $user = Raxan::data(self::DATA_USER);
        //get security questions
        $securityQuestions = User::getSecurityQuestions($user);
        Raxan::data("securityQuestions", $securityQuestions);
        C('#question1')->html($securityQuestions["ques1"]["question"]);
        C('#question2')->html($securityQuestions["ques2"]["question"]);
    }

    /*
     *
     * @param RaxanEvent $e
     */

    protected function sendVerificationCode($e) {
        $username = "";
        try {
            $user = Raxan::data(self::DATA_USER);
            $username = $user->username;
            $verificationKey = $this->getEmailVerificationKey($user);
            if ($verificationKey) {
                Raxan::data("verificationKey", $verificationKey);
                Raxan::loadLangFile(self::LANG_FILE_NAME);
                $msg = Raxan::locale(self::EMAIL_MSG_EMAIL_VERIFICATION_SENT);
                $msg.="<br><h3 class='clear'>Security Code</h3><br><p>This security code is display only for development & testing purpose.<br/>Security code:<strong>$verificationKey</strong></p>";
                $this->showMessage($msg);

                Accesslog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_SENT);
            } else {
                Raxan::loadLangFile(self::ERROR_FILE_NAME);
                $msg = Raxan::locale(self::ERROR_MSG_EMAIL_SECUIRTY_KEY_UP);
                $this->showErrorMessage($msg);
                Accesslog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_NOT_SENT);
                return;
            }
        } catch (Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level, $label);
            Accesslog::log(AccessLog::ACTION_CANNOT_RESEND_VERIFICATION_KEY);

            return null;
        }
    }

    /*
     * 
     * @param RaxanEvent $e
     */

    protected function showSecurityVerification($e) {
        $username = Shared::data(self::DATA_LOGIN_NAME);

        try {
            $pref = $this->collectUserPreferences();

            $user = Raxan::data(self::DATA_USER);

            $verificationKey = $this->getEmailVerificationKey($user);
            if ($verificationKey) {
                Raxan::data("verificationKey", $verificationKey);
                Raxan::loadLangFile(self::LANG_FILE_NAME);
                $msg = Raxan::locale(self::EMAIL_MSG_EMAIL_VERIFICATION_SENT);
                $msg.="<br><h3 class='clear'>Security Code</h3><br><p>This security code is display only for development & testing purpose.<br/>Security code:<strong>$verificationKey</strong></p>";
                $this->showMessage($msg);

                Accesslog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_SENT);

                // store User Preferences until end of validation
                Raxan::data(self::DATA_TMP_USERPREFERENCES, $pref);

                $sv = _var("upsecurityVerification");
                C()->evaluate("showUPSection($sv,true)");
                Accesslog::log(AccessLog::ACTION_SHOW_SECURITY_VERIFICATION);
                return;
            } else {
                Raxan::loadLangFile(self::ERROR_FILE_NAME);
                $msg = Raxan::locale(self::ERROR_MSG_EMAIL_SECUIRTY_KEY_UP);
                $this->showErrorMessage($msg);
                Accesslog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_NOT_SENT);
                return;
            }
        } catch (Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level, $label);
            Accesslog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_NOT_SENT);

            return null;
        }
    }

    /*
     * @param RaxanEvent $e
     *
     */

    protected function verifySecurity($e) {
        $username = Shared::data(self::DATA_LOGIN_NAME);
        $this->registerVar('verify', "failed");
        try {
            //verify security code
            $seccode = $this->post->emVerifyCode;
            $pinNo = $this->post->secPIN;
            $sqAnswer1 = $this->post->questans1;
            $sqAnswer2 = $this->post->questans2;

            $verificationKey = Raxan::data("verificationKey");

            if ($verificationKey != $seccode) {
                Raxan::loadLangFile(self::ERROR_FILE_NAME);
                $msg = Raxan::locale(self::ERROR_MSG_USER_PREFERENCES_SV_FAILED);
                $this->showErrorMessage($msg);
                Accesslog::log(AccessLog::ACTION_INVALID_SECURITY_CODE);

                return "failed";
            }

            $user1 = User::validateUserByPin($username, $pinNo);
            $loginStatus = $user1->loginStatus;


            // check if login status was successful
            if (!($loginStatus == User::LOGIN_STATUS_OK ||
                    $loginStatus == User::LOGIN_STATUS_PWDEXPIRE)) {
                Raxan::loadLangFile(self::ERROR_FILE_NAME);
                $msg = Raxan::locale(self::ERROR_MSG_USER_PREFERENCES_SV_FAILED);
                $this->showErrorMessage($msg);


                Accesslog::log(AccessLog::ACTION_INVALID_PIN);
                return "failed";
            }


            $sqAnswers = array();
            $sqAnswers[] = $sqAnswer1;
            $sqAnswers[] = $sqAnswer2;
            $user = Raxan::data(self::DATA_USER);

            if (!User::validateSecurityQuestionsAnswers($user, $sqAnswers)) {

                Raxan::loadLangFile(self::ERROR_FILE_NAME);
                $msg = Raxan::locale(self::ERROR_MSG_USER_PREFERENCES_SV_FAILED);
                $this->showErrorMessage($msg);
                Accesslog::log(AccessLog::ACTION_INCORRECT_SECURITY_ANSWERS);
                return "failed";
            }

            // retrieve tmp userpref object
            $pref = Raxan::data(self::DATA_TMP_USERPREFERENCES);

            if ($this->saveUserPreferences($pref)) {
                Raxan::removeData(self::DATA_TMP_USERPREFERENCES); // remove tmp user prefs object
                $sv = _var("upPreferences");
                C()->evaluate("showUPSection($sv,true)");
                C()->evaluate("clearValues()");
                //show save button
                if ($pref->aclVerifyUserPreference == 0 ||
                        $pref->aclVerifyUserPreference == 2) {
                    C("#prefContinuebtn")->addClass("hide");
                    C("#prefSavebtn")->removeClass("hide");
                }
                $this->registerVar('verify', "success");
                return "success";
            }
        } catch (Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level, $label);
            Accesslog::log(AccessLog::ACTION_CANNOT_SAVE_USER_PREFERENCES);

            return "failed";
        }
        return "failed";
    }

    private function getEmailVerificationKey($user) {

        try {
            return User::EmailVerificationKey($user);
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
            return null;
        }
    }

}

function accTypesCMP($a, $b) {

    if ($a["displayDescription"] == $b["displayDescription"])
        return 0;
    return ($a["displayDescription"] < $b["displayDescription"] ? -1 : 1);
}

?>
