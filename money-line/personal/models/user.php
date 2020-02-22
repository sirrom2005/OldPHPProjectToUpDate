<?php

namespace Moneyline\Personal\Model;

// models
require_once \COMMON_MODEL_PATH.'sysinfo.php';
require_once \COMMON_MODEL_PATH.'user.php';
require_once \PERSONAL_MODEL_PATH.'securityquestions.php';

use Raxan;
use Moneyline\Personal\Shared;
use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Model\SecurityQuestions;

// @TODO: Refactor Moneyline\Common\Model\User and Moneyline\Personal\Model\User code
// For now they are the same

/**
 * Personal User Data Model
 * This model contains commonly used functions for the logged in user account
 */
class User extends \Moneyline\Common\Model\User {

    protected static $agent;
    protected static $sessionCookieName = 'MnylNeSessId';
    protected static $loginCookieName = 'login_id';
    protected static $intranetCookieName = '';

    const LOGIN_STAUS_ACCOUNTLOCK = "ACCOUNTLOCK";
    const LOGIN_STATUS_LOCKED = "LOCKED";
    const LOGIN_STATUS_INVALIDLOGIN = "INVALIDLOGIN";
    const LOGIN_STATUS_TOOMANYDAYS = "TOOMANYDAYS";
    const LOGIN_STATUS_OK = "OK";
    const LOGIN_STATUS_NEW = "I";
    const LOGIN_STATUS_PWDEXPIRE = "PWDEXPIRE";
    const MASK_ACCOUNT = 'maskAccountNo';

    /**
     * Returns true if user successfully logged in
     * @return boolean
     */
    public static function isLogin() {
        return Shared::data('login-ok') ? true : false;
        // return self::isValidSession() ? true : false;
    }

    /**
     * Returns true if user is an internal user
     */
    public static function isInternalUser() {
        return Shared::data('internal-uid') ? true : false;
    }

    // check if user session is valid
    public static function isValidSession() {

        $loginOk = Shared::data('login-ok');
        if (!$loginOk)
            return false;
        else {
            // get ip address and screen name
            $remoteIp = $_SERVER['REMOTE_ADDR'];
            $pageName = SecureWebPageController::pageName();

            // get session tracking id
            $idFromServer = self::getSessionTrackingId();
            $idFromClient = isset($_COOKIE[self::$sessionCookieName]) ?
                    $_COOKIE[self::$sessionCookieName] : '';

            // check if we have a match from the client
            if ($idFromServer != $idFromClient)
                return false;

            // query session and screen id to session access log
            $sql = 'set nocount on
                    exec sp_session :sessionid, :remoteip, :pagename';
            $rt = self::query($sql, array(
                        ':sessionid' => $idFromServer,
                        ':remoteip' => $remoteIp,
                        ':pagename' => $pageName
                    ));
            $clientNo = $rt->fetchColumn(0);

            return ($clientNo > 0) ? true : false;
        }
    }

    /**
     * Adds a new reminder to customer's account
     * @param string $actionDate Date format must be in m/d/y
     * @param string $priority
     * @param string $summary
     * @param string $details
     * @return booleam
     */
    public static function addReminder($actionDate, $priority, $summary, $details) {
        $customerId = self::getCustomerId();
        $xml = self::createReminderXML($customerId, $actionDate, $priority, $summary, $details);

        $client = self::getWebService('CIServiceWS');
        $param = new \CIServiceWS\AddReminder();
        $param->xmlString = $xml;
        $rt = $client->AddReminder($param);

        if ($rt->return)
            Shared::removeData('user-reminders');
        return $rt->return ? true : false;
    }

    public static function createLoginInfo($uid, $userName) {
        $sql = "set nocount on \n";
        $sql .= "declare @LogID Int \n";
        $sql .= "insert into loginTracking ";
        $sql .= "([uid], userName, dtRequestMade, dtRequestReceived, loginStatus) ";
        $sql .= "Values (:uid, :user, GetDate(), Null, 'PENDING') \n";
        $sql .= " Set @LogID = @@Identity \n";
        $sql .= " Select @LogID as 'LoginIdentity' ";
        $result = self::query($sql, array(
                    ':uid' => $uid,
                    ':user' => $userName
                ));

        return $result->fetchColumn(0);
    }

    /**
     * Creates a login session id and inserts a record in the session
     * table for the person logging on
     * @param int $uid Universal ID
     * @param int $userName User Name
     * @return string Returns session id
     */
    public static function createSessionId($uid, $pin, $userName) {
        /* Check if user is already online */
        $sql = "SELECT * from session where [uid] = ?"; // and pin_no = $pin";
        $result = self::query($sql, $uid);
        $num_online = $result->rowCount();
        if ($num_online > 0) {
            $sql = "DELETE from session where [uid] = ?";
            self::query($sql, $uid);
        }

        $remoteaddr = $_SERVER["REMOTE_ADDR"];
        $remotehost = $_SERVER["REMOTE_HOST"];
        $browseragent = substr($_SERVER["HTTP_USER_AGENT"], 0, 99); // truncate to fix in varchar(100)
        // generate random login session id
        $num = 1;
        while ($num > 0):
            $sessionid = md5($remoteaddr . "|" . time() . "|" . rand());
            $sql = "SELECT * from session where session_id = ?";
            $result = self::query($sql, $sessionid);
            $num = $result->rowCount();
        endwhile;

        // log sesion id
        $sql = 'INSERT into session (session_id, [uid], start_time_sec, last_txn_sec, remoteip, username, user_agent) ' .
                'VALUES (:session, :uid, getdate(), getdate(), :remoteaddr,:user,:browseragent)';
        self::query($sql, array(
                    ':session' => $sessionid,
                    ':uid' => $uid,
                    ':remoteaddr' => $remoteaddr,
                    ':user' => $userName,
                    ':browseragent' => $browseragent
                ));

        // @todo: Check on this statement. Why not use AccessLog?
        // log access
        $sql = "INSERT INTO access_log VALUES (:session, :user, :uid, 'LON', :browseragent, :remoteaddr,:remotehost,getdate())";
        self::query($sql, array(
                    ':session' => $sessionid,
                    ':user' => $userName,
                    ':uid' => $uid,
                    ':browseragent' => $browseragent,
                    ':remoteaddr' => $remoteaddr,
                    ':remotehost' => $remotehost
                ));

        return ($sessionid);
    }

    /**
     * Count accounts by type and category
     */
    public static function countAcctbyType($ProductType, $AccountCategory) {
        $count = 0;
        $accounts = self::getClientAccounts();

        if ($ProductType == 'ALL') {
            $count = count($accounts);
        } else {
            for ($i = 0; $i < count($accounts); $i++) {
                if (strtoupper(trim($accounts[$i]['ProductType'])) == $ProductType && strtoupper(trim($accounts[$i]['AccountCategory'])) == $AccountCategory)
                    $count = $count + 1;
            }
        }
        return $count;
    }

    /**
     * Converts amount into inputed currency value. This function requires SysInfo
     * @param string $fCurrency
     * @param float $amount
     * @return float
     */
    public static function convertAmount($fCurrency, $amount) {
        $rates = SysInfo::getAllFxRatesAmount();
        $cnt = count($rates);
        $exchangeRate = 1;
        for ($i = 0; $i < $cnt; $i++) {
            if (strtoupper($rates[$i][0]) == strtoupper($fCurrency)) {
                $exchangeRate = $rates[$i][1];
            }
        }

        $amount = $amount * $exchangeRate;
        return $amount;
    }

    /**
     * Delete user reminder
     * @param int $id Reminder id
     * @return boolean
     */
    public static function deleteReminder($id) {
        $client = self::getWebService('CIServiceWS');
        $param = new \CIServiceWS\DeleteReminder();
        $param->reminderID = $id;
        $rt = $client->DeleteReminder($param);
        if ($rt->return)
            Shared::removeData('user-reminders');
        return $rt->return;
    }

    /**
     * Extract account information fron Client Accounts array web service result
     * @param \CISWebService\accounts $clientAccounts
     * @return Array
     */
    public static function extractAccountsFromArray($clientAccounts) {
        $index = 0;
        $accountInfo = array();
        if (is_array($clientAccounts)) {
            $cnt = count($clientAccounts);
            for ($i = 0; $i < $cnt; $i++) {
                $accCat = strtoupper(trim($clientAccounts[$i]->accountInfo->accountCategory));
                $accBal = $clientAccounts[$i]->accountBalance->currentBalance;
                $accProdType = strtoupper(trim($clientAccounts[$i]->accountInfo->productType));
                if ($accCat != "EQUITY ACCOUNT" && $accCat != "BOND ACCOUNT" && $accBal == 0) {
                    continue;
                }

                $accountInfo[$index]['AccountType'] = $clientAccounts[$i]->accountType;
                $accountInfo[$index]['AccountNo'] = str_replace(',', '', number_format(trim($clientAccounts[$i]->accountKey), 0));
                $accountInfo[$index]['AccountNoMask'] = self::maskAccountNo(str_replace(',', '', number_format(trim($clientAccounts[$i]->accountKey), 0)));
                $accountInfo[$index]['AccountDescription'] = $clientAccounts[$i]->accountDescription;
                $accountInfo[$index]['SigningInstructiions'] = $clientAccounts[$i]->signingInstructions;
                $accountInfo[$index]['AccountCategory'] = $clientAccounts[$i]->accountInfo->accountCategory;
                $accountInfo[$index]['AccountName'] = $clientAccounts[$i]->accountInfo->accountName;
                $accountInfo[$index]['Currency'] = $clientAccounts[$i]->accountInfo->currency;
                $accountInfo[$index]['BalanceDate'] = $clientAccounts[$i]->accountInfo->balanceDate;
                $accountInfo[$index]['ProductType'] = $clientAccounts[$i]->accountInfo->productType;
                $accountInfo[$index]['FundNo'] = $clientAccounts[$i]->accountInfo->fundNo;
                $accountInfo[$index]['MinInvestmentAmount'] = $clientAccounts[$i]->minInvestmentAmount;

                $accountInfo[$index]['CurrentBalance'] = $clientAccounts[$i]->accountBalance->currentBalance;
                $accountInfo[$index]['UnclearedBalance'] = $clientAccounts[$i]->accountBalance->unclearedBalance;
                $accountInfo[$index]['LiensBalance'] = $clientAccounts[$i]->accountBalance->liensBalance;
                $accountInfo[$index]['AvailableBalance'] = $clientAccounts[$i]->accountBalance->availableBalance;

                $accountInfo[$index]['OwnerShipList'] = null;
                $accountInfo[$index]['AssetList'] = null;
                $accountInfo[$index]['LiabilityList'] = null;

                if (is_array($clientAccounts[$i]->ownerShipList)) {
                    $accountInfo[$index]['OwnerShipList'] = $clientAccounts[$i]->ownerShipList;
                }
                if (is_array($clientAccounts[$i]->assetList) && ( $clientAccounts[$i]->accountInfo->fundNo == 18 || $accProdType == "BOND" || $accProdType == "INVESTOR")) {
                    $accountInfo[$index]['AssetList'] = $clientAccounts[$i]->assetList;
                }
                if (is_array($clientAccounts[$i]->liabilityList)) {
                    $accountInfo[$index]['LiabilityList'] = $clientAccounts[$i]->liabilityList;
                }
                $index++;
            }
        }
        return $accountInfo;
    }

    // function used to mask the account number for display
    // @todo move to Shared class
    public static function maskAccountNo($accountNo) {


        if (in_array(self::getUserPreference(self::MASK_ACCOUNT), array(1, 3))) {
            $maskedAccountNo = "xxxxxx";
        } else {
            $maskedAccountNo = $accountNo;
        }


        return $maskedAccountNo;
    }

    /**
     * Extract reminders from an array
     * @param array $array
     * @return array
     */
    public static function extractRemindersFromArray($array) {
        // load reminders
        $reminders = array();
        if (is_array($array)) {
            $cnt = count($array);
            for ($i = 0; $i < $cnt; $i++) {
                $reminders[$i]['ReminderId'] = trim($array[$i]->reminderId);
                $reminders[$i]['CustomerId'] = trim($array[$i]->customerID);
                $reminders[$i]['ReminderType'] = trim($array[$i]->reminderType);
                $reminders[$i]['ReminderInfo'] = trim($array[$i]->reminderInfo);
                $reminders[$i]['ActionDate'] = trim($array[$i]->actionDate);
                $reminders[$i]['Priority'] = trim($array[$i]->priority);
                $reminders[$i]['Summary'] = trim($array[$i]->summary);
                $reminders[$i]['Details'] = trim($array[$i]->details);
                $reminders[$i]['PriorityDesc'] = trim($array[$i]->priorityDescription);
            }
        }
        return $reminders;
    }

    /**
     * Extract notices from an array
     * @param array $array
     * @return array
     */
    public static function extractNoticesFromArray($array) {
        // load notices
        $notices = array();
        if (is_array($array)) {
            $cnt = count($array);
            for ($i = 0; $i < $cnt; $i++) {
                $notices[$i]['notice'] = trim($array[$i]->notice);
                $notices[$i]['priority'] = trim($array[$i]->priority);
                $notices[$i]['recipient'] = trim($array[$i]->recipient);
            }
        }
        return $notices;
    }

    /**
     * Filter accounts by type
     * @param string $ProductType
     * @param string $AccountCategory
     * @return array
     */
    public static function filterAcctbyType($ProductType, $AccountCategory, $refresh = false) {
        $result = array();
        $accounts = self::getClientAccounts($refresh);
        if ($ProductType == $AccountCategory) {
            $result = $accounts;
        } else {
            $cnt = count($accounts);
            for ($i = 0; $i < $cnt; $i++) {
                if (strtoupper(trim($accounts[$i]['ProductType'])) == $ProductType && strtoupper(trim($accounts[$i]['AccountCategory'])) == $AccountCategory)
                    $result[] = $accounts[$i];
            }
        }
        return $result;
    }

    /**
     * Find Accounts by Client No
     * @param int $customerID
     * @return \CIServiceWS\accounts
     */
    public static function findAccountsByClientNo($customerID) {
        $customerID = (int) $customerID;

        /** @var \CIServiceWS\CIServiceWS */
        $client = self::getWebService('CIServiceWS');
        $param = new \CIServiceWS\findByClientNo();
        $param->clientNo = $customerID;
        $rt = $client->findByClientNo($param);

        $accounts = $rt->return;
        return self::extractAccountsFromArray($accounts);
    }

    /**
     * Returns today's request history
     */
    public static function getTodaysRequestHistory() {
        $history = array();
        $reqstStartDate = date('m') . '/' . (date('d') - 1) . '/' . date('Y'); //Request start and end date.
        $reqstEndDate = date('m') . '/' . date('d') . '/' . date('Y');
        $customerId = self::getCustomerId();
        $rt = self::getClientTransactions($customerId, '', 'DESC', 50, '', '', $reqstStartDate, $reqstEndDate, '', '');
        $trans = $rt->clienttransactions;
        for ($j = 0; $j < count($trans) && is_array($trans); $j++) {
            $history[$j]['RequestDate'] = Raxan::cDate(substr($trans[$j]['requesteddate'], 0, 10))->format('d-M-Y');
            if (trim($trans[$j]['dateprocessed']) != '') {
                $history[$j]['ActionDate'] = Raxan::cDate(substr($trans[$j]['dateprocessed'], 0, 10))->format('d-M-Y');
            } else {
                $history[$j]['ActionDate'] = Raxan::cDate(substr($trans[$j]['effectivedate'], 0, 10))->format('d-M-Y');
            }
            $history[$j]['RequestType'] = $trans[$j]['categoryname'];
            $history[$j]['Details'] = $trans[$j]['description'];
            $history[$j]['Amount'] = $trans[$j]['amount'];
            $history[$j]['Status'] = $trans[$j]['status'];
        }

        return $history;
    }

    /**
     * Returns user information (preferences and reminders)
     * @param int $CustomerID
     * @param string $UserName
     * @param datetime $FromDate
     * @param datetime $ToDate
     * @return \CIServiceWS\userWSInfoDto
     */
    public static function getUserInfo() {

        $fromDate = self::getTodaysDate(); // returns ISO date format
        $date_list = split("/", $fromDate);
        $y = $date_list[0];
        $m = $date_list[1];
        $d = $date_list[2];
        $toDate = date("Y-m-d", mktime(0, 0, 0, $m, $d + 6, $y));

        $customerId = self::getCustomerId();
        $userName = self::getLoginName();

        /** @var $client \CIServiceWS\CIServiceWS */
        $xml = self::createUserInfoXML($customerId, $userName, $fromDate, $toDate);
        $client = self::getWebService('CIServiceWS');
        $param = new \CIServiceWS\GetUserWSInformations();
        $param->xmlString = $xml;
        $rt = $client->GetUserWSInformations($param);
        $info = $rt->return;
        $wsDeployDate = $info->webServiceDepldDate;
        $wsVersion = $info->webServiceVersion;
        $prefs = self::extractUserPrefsFromArray($info->userPreferences);
        $reminders = self::extractRemindersFromArray($info->reminders);
        Shared::data('user-prefs', $prefs);
        Shared::data('user-reminders', $reminders);
        Shared::data('ws-deploydate', $wsDeployDate);
        Shared::data('ws-version', $wsVersion);

        return array(
            'preferences' => $prefs,
            'reminders' => $reminders,
            'wsVersion' => $wsVersion,
            'wsDeployDate' => $wsDeployDate
        );
    }

    /**
     * Return remnder details for the current user
     * @return array
     */
    public static function getReminderDetails($reminderId) {
        return self::getReminders($reminderId);
    }

    /**
     * Return remnders for the current user
     * @return array
     */
    public static function getReminders($reminderId = null) {

        if (!$reminderId && Shared::data('user-reminders') != '') {
            return Shared::data('user-reminders');
        } else {
            $fromDate = self::getTodaysDate();      // ISO date format
            $date_list = explode("-", $fromDate);   // this is needed for JAX-WS
            $y = $date_list[0];
            $m = $date_list[1];
            $d = $date_list[2];
            $toDate = date("Y-m-d", mktime(0, 0, 0, $m, $d + 6, $y));
            $customerId = self::getCustomerId();
            /** @var $client \CIServiceWS\CIServiceWS */
            $client = self::getWebService('CIServiceWS');
            $param = new \CIServiceWS\getReminders();
            $param->customerId = $customerId;
            if ($reminderId)
                $param->reminderId = $reminderId;
            else {
                $param->fromDate = $fromDate;
                $param->toDate = $toDate;
                $param->reminderId = 0;
            }
            $rt = $client->getReminders($param);
            $reminders = $rt->return;
            if ($reminders && !is_array($reminders)) {
                $reminders = array($reminders);
            }

            $reminders = self::extractRemindersFromArray($reminders);

            // return only 1 reminder entry if id specified
            if ($reminderId)
                return $reminders[0];
            else
                return Shared::data('user-reminders', $reminders);
        }
    }

    /**
     * Return all remnders for the current user from 1970 to 50 years from current date
     * @return array
     */
    public static function getAllReminders() {
        $fromDate = '1970-01-01';   // convert date to ISO format - this is needed for JAX-WS
        $date_list = explode("-", self::getTodaysDate()); // iso date
        $y = $date_list[0] + 50;
        $m = $date_list[1];
        $d = $date_list[2];
        $dt = new \DateTime("$y-$m-$d");
        $toDate = $dt->format('Y-m-d');
        $customerId = self::getCustomerId();
        /** @var $client \CIServiceWS\CIServiceWS */
        $client = self::getWebService('CIServiceWS');
        $param = new \CIServiceWS\getReminders();
        $param->customerId = $customerId;
        $param->fromDate = $fromDate;
        $param->toDate = $toDate;
        $param->reminderId = 0;
        $rt = $client->getReminders($param);
        $reminders = $rt->return;
        if ($reminders && !is_array($reminders)) {
            $reminders = array($reminders);
        }

        $reminders = self::extractRemindersFromArray($reminders);
        return $reminders;
    }

    /**
     * Return web service deploy date
     * @return string
     */
    public static function getWebServiceDeployedDate() {
        if (!Shared::data('ws-deploydate'))
            self::getUserInfo();
        return Shared::data('ws-deploydate');
    }

    /**
     * Return web service version
     * @return string
     */
    public static function getWebServiceVersion() {
        if (!Shared::data('ws-version'))
            self::getUserInfo();
        return Shared::data('ws-version');
    }

    public static function getUserTransactionsPreferences($name) {
        $preference = self::getUserPreference($name);
        return ($preference == 1 || $preference == 3);
    }

    /**
     * Return user preference value
     * @param string $name
     * @return string
     */
    public static function getUserPreference($name) {
        $prefs = self::getUserPreferences();
        return $prefs && isset($prefs->{$name}) ? $prefs->{$name} : '';
    }

    /**
     * Return user preferences
     * @return \CIServiceWS\userPreferences
     */
    public static function getUserPreferences() {
        if (Shared::data('user-preferences')) {
            $userPrefs = Shared::data('user-preferences');
        } else {
            $uid = self::getUniversalId();
            $client = self::getWebService('CIServiceWS');
            $param = new \CIServiceWS\GetUserPreference();
            $param->uid = $uid;
            $rt = $client->GetUserPreference($param);
            if (($err = $rt->return->error))
                throw new \Moneyline\Common\DataModelException($err);  // handle error

                $userPrefs = $rt->return->result;
            Shared::data('user-preferences', $userPrefs); // save user prefs in session
        }
        return $userPrefs;
    }

    /**
     * Set User Preference value
     * @param string $name Camel Case user preference name
     * @param mixed $value Preference value
     * @return boolean
     */
    public static function setUserPreference($name, $value) {

        $uid = self::getUniversalId();
        $securityToken = self::getSecurityToken();
        $client = self::getWebService('CIServiceWS');
        $param = new \CIServiceWS\setUserPreference();
        $param->uid = $uid;
        $param->property = $name;
        $param->token = $securityToken;
        $param->value = $value;

        $rt = $client->setUserPreference($param);
        if (($err = $rt->return->error))
            throw new \Moneyline\Common\DataModelException($err);  // handle error
        
        $brt = $rt->return->result;
        if ($brt) { // update user preferences in session
            $prefs = & shared::data("user-preferences");
            $prefs->{$name} = $value;
        }

        return $brt;
    }

    /**
     * Save user preferences
     * @param CIServiceWS\UserPreferences $userPreferences
     * @return boolean 
     */
    public static function saveUserPreferences($userPreferences) {
        $securityToken = self::getSecurityToken();
        $client = self::getWebService('CIServiceWS');
        $param = new \CIServiceWS\AddEditUserPreference();
        $param->userPreferences = $userPreferences;
        $param->token = $securityToken;
        $rt = $client->AddEditUserPreference($param);
        if (($err = $rt->return->error))
            throw new \Moneyline\Common\DataModelException ($err);  // throw error

            $userPrefs = $rt->return->result;
        Shared::data('user-preferences', $userPrefs); // save user prefs in session

        return true;
    }

    /**
     * Return user preferences
     * @return array
     */
//    public static function getUserPreferencesEx() { // @todo: Is this used?
//
//        try {
//            $uid = self::getUniversalId();
//            /** @var $client \CIServiceWS\CIServiceWS */
//            $client = self::getWebService('CIServiceWS');
//                $param = new \CIServiceWS\GetUserPreference();
//                $param->uid = $uid;
//            $rt = $client->GetUserPreference($param);
//            $userPreferences = $rt->return->result;
//
//            return $userPreferences;
//        }
//        catch(Exception $ex) {
//            $err = Shared::ERROR_MODE_SYSERR;
//            $level = 'ERROR';
//            $label = 'Login';
//            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
//        }
//        return null;
//    }

    /**
     * Return transaction velocity total
     * @return array
     */
    public static function getTransactionVelocityTotal() {

        try {
            $customerID = self::getCustomerId();
            /** @var $client \CIServiceWS\CIServiceWS */
            $client = self::getWebService('TransactionGatewayWS');
            $param = new \TransactionGatewayWS\getTransactionVelocityTotal();
            $param->customerNo = $customerID;
            $rt = $client->getTransactionVelocityTotal($param);
            $velocityTotal = $rt->return;

            return $velocityTotal;
        } catch (Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level, $label);
        }

        return null;
    }

    /**
     * Check if client account has the necessary rights
     * @param mixed $account Can be an account number or an \CIServiceWS\accounts
     * @param string $rights Example WD
     * @return boolean
     */
    public static function hasRights($account, $rights) {
        $role = '';
        if (is_array($account))
            $accountInfo = $account;
        else {
            $account = (double) $account;
            $clientAccounts = User::getClientAccounts();
            foreach ($clientAccounts as $i => $acc) {
                if ($acc['AccountNo'] == $account) {
                    $accountInfo = $acc;
                    break;
                }
            }
        }
        $clientId = self::getCustomerId();
        $ownerShip = $accountInfo['OwnerShipList'];
        for ($j = 0; $j < count($ownerShip); $j++) {
            if ((double) trim($ownerShip[$j]->partyId) == $clientId) {
                $role = trim($ownerShip[$j]->role);
            }
        }
        return (strpos($role, $rights) === false) ? false : true;
    }

    /**
     * Check for signing rights
     * @param mixed $account
     * @param string $signInstrn
     * @return boolean
     */
    public static function hasSignInstruction($account, $signInstrn) {
        if (is_array($account))
            $accountInfo = $account;
        else {
            $account = (double) $account;
            $clientAccounts = User::getClientAccounts();
            foreach ($clientAccounts as $i => $acc) {
                if ($acc['AccountNo'] == $account) {
                    $accountInfo = $acc;
                    break;
                }
            }
        }
        if (strtoupper(trim($accountInfo['SigningInstructiions'])) == strtoupper($signInstrn))
            return true;
        else
            return false;
    }

    public static function logout() {
        Shared::data('login-ok', false);
        Raxan::dataStorage()->resetStore(); // remove session information
        setcookie(self::$sessionCookieName, '');
        Raxan::data("user", null);
        return true;
    }

    public static function login($user) {
        try {

            $username = $user->username;
            $uid = $user->uid;
            $customerId = $user->customerID;
            $isMobileUser = Shared::isMobileDevice();

            $loginTrackingId = self::createLoginInfo(0, $username);
            //get client information
            $clientService = self::getWebService('CIServiceWS');

            $getClientAccountDetails = new \CIServiceWS\getClientAccountDetails(); // @todo: check on this
            $getClientAccountDetails->customerID = $customerId;

            $rt = $clientService->getClientAccountDetails($getClientAccountDetails);

            if (isset($rt->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);
                return false;
            }

            $ciServiceDTO = $rt->return;

            $Login = $user;
            $clintInfo = $ciServiceDTO->clientInfo;
            $fullname = trim($clintInfo->firstName) . " " . trim($clintInfo->lastName);
            $eMail = trim($clintInfo->EMail);
            $taxRegistrationNo = trim($clintInfo->taxRegistrationNo);
            $clientType = trim($clintInfo->clientType);

            if (trim($fullname) == "") {
                $fullname = $username;
            }

            $customerName = trim($fullname);
            $customerEMail = $eMail;
            $pinNo = 0;

            // update the login message.
            $lastIP = trim($Login->lastIP) == "" ? "Unknown IP" : trim($Login->lastIP);
            $dt = Raxan::cDate(substr($Login->lastLogin, 0, 10));
            $loginMessage = Raxan::locale(
                            'external-loginmsg',
                            Shared::getFriendlyGreeting(), // greeting
                            $customerName, // customer name
                            $Login->visits,
                            $dt->format('F d, Y'),
                            $lastIP
            );

            $updatedDateTime = $ciServiceDTO->lastUpdatedTime;  // We can try and get date from server
            // check it terms and conditions ok
            $requireTermsConditions = (
                    $ciServiceDTO->termsConditions &&
                    $ciServiceDTO->termsConditions->userAcceptanceStatus == 'ACCEPTED'
                    ) ? false : true;

            // get client menus
            $userMenus = self::getUserMenusFromArray($ciServiceDTO->menus);

            // get client accounts
            $clientAccounts = self::extractAccountsFromArray($ciServiceDTO->accounts);

            // obtain associated pension member number
            // code below deprecated
//                Shared::loadModel('pension');
//                $pensionMemNo = Pension::findByNINO($taxRegistrationNo, $clientType);

            $lastLoginDate = $Login->lastLogin;
            $securityToken = $user->securityToken;

            // create the session
            $sessionid = User::createSessionId($uid, $pinNo, $username);

            // set session values to use used by User model
            Shared::data('base-currency', Raxan::config('base-currency'));  // set user base currency?
            Shared::data('client-accounts', $clientAccounts);
            Shared::data('last-login-datetime', $lastLoginDate);  // @todo updated
            Shared::data('last-updated-datetime', $updatedDateTime);      // last time client account info was loaded
            Shared::data('login-message', $loginMessage);
            Shared::data('customer-name', $customerName);
            Shared::data('client-type', $clientType);
            //Shared::data('pension-mem-no',$pensionMemNo);
            Shared::data('customer-id', $user->customerID);
            Shared::data('universal-id', $uid);
            Shared::data('customer-email', $customerEMail);
            Shared::data('user-menus', $userMenus);
            Shared::data('security-token', $securityToken);
            Shared::data('session-tracking-id', $sessionid);
            Shared::data('login-tracking-id', $loginTrackingId);
            Shared::data('login-name', $username);
            Shared::data('login-ok', true);
            //Shared::data('mobile-user',$isMobileUser);
            Shared::data('require-terms-conditions', $requireTermsConditions);

            // store session tracking id inside cookie
            setcookie('MnylNeSessId', $sessionid);

            // update user login status
            self::updateLoginInfo($loginTrackingId, 'SUCCESS', $uid);
            //unset($_SESSION["mobile-user"]);
            return true;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'User';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
            return false;
        }
        return false;
    }

    public static function getLocaleCode() {
        $l = Shared::data('user-locale');
        return $l ? $l : Raxan::locale();
    }

    /**
     * Returns localized tips
     */
    public static function getRandomTip() {
        $retries = 0;
        $tip = '';
        $tipsFile = Raxan::config('views.path') . 'tips.html';
        $tips = file_get_contents($tipsFile);
        $tips = explode("<hr>", trim($tips));
        // get random entry
        while (empty($tip) and $retries < 10) {
            $rnd = array_rand($tips);
            $tip = trim($tips[$rnd]);
            $retries++;
        }

        // get title        
        preg_match('/<h3>(.*)<\/h3>/', $tip, $m);
        $title = $m ? $m[1] : '';
        $tip = trim(str_replace('<h3>' . $title . '</h3>', '', $tip));

        return array(
            'type' => count($tips) == 1 ? 'announce' : 'tip', // tip or announce
            'title' => $title,
            'tip' => $tip
        );
    }

    /**
     * Returns user created notices
     */
    public static function getNotices() {
        if (Shared::data('user-notices') != '') {
            return Shared::data('user-notices');
        } else {
            $customerId = Shared::data('customer-id');
            $client = self::getWebService('CIServiceWS');
            $param = new \CIServiceWS\getNotices();
            $param->recipient = $customerId;
            $rt = $client->getNotices($param);
            $notices = $rt->return;
            if ($notices && !is_array($notices)) {
                $notices = array($notices);
            }
            $notices = self::extractNoticesFromArray($notices);
            return Shared::data('user-notices', $notices);
        }
    }

    /**
     * Returns true if terms and conditions need to be accepted
     * @return boolean
     */
    public static function requireTermsAndConditions() {
        return Shared::data('require-terms-conditions');
    }

    /**
     * Removes a menu from option from the user's menu list
     * @param string $menuId
     */
    public static function removeMenuOption($menuId) {
        $new_menu = array();
        $menus = self::getUserMenus();
        foreach ($menus as $item) {
            if ($item["menuId"] != $menuId) {
                $new_menu[] = $item;
            }
        }
        Shared::data('user-menus', $new_menu);
    }

    public static function setLocaleCode($code, $lang = null) {
        Shared::data('user-locale', $code);
        Raxan::setLocale($code, $lang);
    }

    public static function setTermsCondition($status) {
        if ($status != 'ACCEPTED' && $status != 'DECLINED')
            return false;
        $cid = self::getCustomerId();
        $expireInDays = Raxan::config('expiry-date-days');
        $username = self::getLoginName();
        $xml = self::createTermsXML($cid, $expireInDays, $status, $username);
        $client = self::getWebService('CIServiceWS');
        $param = new \CIServiceWS\CreateTermsConditionsLog();
        $param->xml = $xml;
        $rt = $client->CreateTermsConditionsLog($param);
        if (!$rt->return)
            return false;
        else {
            Shared::data('require-terms-conditions', false);
            return true;
        }
    }

    public static function initLocale() {
        Raxan::setLocale(self::getLocaleCode());
        Raxan::loadLangFile('common');  // load common language file
    }

    /**
     * Returns last login name from cookie
     * Used by the login system when remember me is checked
     * @return string
     */
    public static function getLastLoginName() {
        return isset($_COOKIE['login_id']) ? $_COOKIE['login_id'] : '';
    }

    public static function getLastUpdatedDateTime() {
        return Shared::data('last-updated-datetime');
    }

    public static function getLastLoginDateTime() {
        return Shared::data('last-login-datetime');
    }

    /**
     * Returns client accounts. This function requires the SysInfo model
     * @param boolean $refresh
     * @return array
     */
    public static function getClientAccounts($refresh = false) {
        if (!$refresh)
            $accounts = Shared::data('client-accounts');
        else {
            $cid = self::getCustomerId();
            $accounts = self::findAccountsByClientNo($cid);
            if ($accounts && count($accounts)) {
                Shared::data('client-accounts', $accounts);
                Shared::data('last-updated-datetime', SysInfo::getLocalTimeZone());
            }
        }

        return $accounts;
    }

    public static function getClientAccountDetails($searchAccountNo) {

        // pick up the account list stored on the ciient.
        $accountList = User::getClientAccounts();

        // loop through the array and check for the search account
        $accountInfo = array();
        if (is_array($accountList)) {
            $cnt = count($accountList);
            for ($i = 0; $i < $cnt; $i++) {
                if ($accountList[$i]['AccountNo'] == $searchAccountNo) {
                    $accountInfo = $accountList[$i];
                    return $accountInfo;
                }
            }
        }
        return null;
    }

    /**
     * Retrives the list of transactions executed by the user
     * given the specified parameters.
     * 
     * @param int $personNo
     * @param string $sortBy
     * @param string $sortOrder
     * @param int $numOfRecs
     * @param string $details
     * @param string $status
     * @param string $startDate
     * @param string $endDate
     * @param string $tranType
     * @param float $accountNo
     * @return \CIServiceWS\ctResult
     */
    public static function getClientTransactions(
    $personNo, $sortBy, $sortOrder, $numOfRecs, $details, $status, $startDate, $endDate, $tranType, $accountNo) {

        $xml = self::createRequestHistoryXML($personNo, $sortBy, $sortOrder, $numOfRecs, $details, $status, $startDate, $endDate, $tranType, $accountNo);
        $client = self::getWebService('CIServiceWS');
        $param = new \CIServiceWS\getClientTransactions();
        $param->xMLString = $xml;
        $rt = $client->getClientTransactions($param);
        return $rt->return;
    }

    /**
     * Returns user menus
     * @return array
     */
    public static function getUserMenus($parentId = null) {
        $menus = Shared::data('user-menus');
        if (!$menus) {
            $id = self::getCustomerId();
            $client = self::getWebService('CIServiceWS');
            $param = new \CIServiceWS\GetMenu();
            $param->clientNo = $id;
            $rt = $client->GetMenu($param);
            $menus = self::getUserMenusFromArray($rt->return);
            Shared::data('user-menus', $menus);
        }

        // filter by parent id
        if ($parentId) {
            $menus = array_filter($menus, function($menu) use($parentId) {
                                return ($menu['parentMenuId'] == $parentId) ? true : false;
                            });
            $menus = array_values($menus); //reassign index values
        }

        return $menus;
    }

    /**
     * Returns user menus from an array
     * @return array
     */
    public static function getUserMenusFromArray($menuArray) {
        $menus = array();
        /** @var $menu \CIServiceWS\menuDTO */
        foreach ($menuArray as $i => $menu) {
            $menus[$i] = array();
            // @todo: remove this demo filter 
            $link = str_replace('index.dti?$sessionid&PAGE=', '', $menu->menuLink);
            $menus[$i]['menuId'] = $menu->menuId;
            $menus[$i]['menuLink'] = $link;
            $menus[$i]['menuName'] = $menu->menuName;
            $menus[$i]['menuOrder'] = $menu->menuOrder;
            $menus[$i]['parentMenuId'] = $menu->parentMenuId;
            if (strpos("&ext=y", $menu->menuLink))
                $menus[$i]['menuTarget'] = '_blank';
            else
                $menus[$i]['menuTarget'] = '';
        }
        return $menus;
    }

    /**
     *  get internal (intranet) user id
     * @return string
     */
    public static function getInternalUserId() {
        return Shared::data('internal-uid');
    }

    /**
     * get internal (intranet) user name
     * @return string
     */
    public static function getInternalUserName() {
        return Shared::data('internal-username');
    }

    public static function getCustomerName() {
        return Shared::data('customer-name');
    }

    public static function getCustomerEmail() {
        return Shared::data('customer-email');
    }

    /**
     * Returns customer id
     * @return int
     */
    public static function getCustomerId() {
        return Shared::data('customer-id');
    }

    /**
     * Returns Universal ID
     * @return string
     */
    public static function getUniversalId() {
        return Shared::data('universal-id');
    }

    public static function getSecurityToken() {
        return Shared::data("security-token");
    }

    public static function getClientType() {
        return Shared::data('client-type');
    }

    public static function getPensionMemNo() {
        return Shared::data('pension-mem-no');
    }

    public static function getLoginMessgae() {
        return Shared::data('login-message');
    }

    /**
     * Returns current login or user name
     * @return string
     */
    public static function getLoginName() {
        return Shared::data('login-name');
    }

    /**
     * Returns login id for login tracking 
     * @return int
     */
    public static function getLoginTrackingId() {
        return Shared::data('login-tracking-id');
    }

    /**
     * Returns moneyline session id for the current user session\
     * This is the id created by the moneyline system to validate user login
     * @return string
     */
    public static function getSessionTrackingId() {
        return Shared::data('session-tracking-id');
    }

    public static function updateLoginInfo($logingTrackingId, $Status, $uid) {
        $sql = "Update loginTracking ";
        $sql .= "Set dtRequestReceived = GetDate(), ";
        $sql .= "loginStatus = :status, ";
        $sql .= "[uid] = :uid ";
        $sql .= "Where logId = $logingTrackingId ";
        $result = self::query($sql, array(
                    ':status' => $Status,
                    ':uid' => $uid
                ));
        If ($result)
            return true;
        else
            return false;
    }

    /**
     * This loads the security questions in view
     */
    public static function loadSecurityQuestions() {
        try {
            SecurityQuestions::loadSecurityQuestions();
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
    }

    /**
     *
     * @param AuthenticateWS\user $user
     * @return boolean
     *
     */
    public static function saveUPSecurityQuestions($sqnAnswers) {
        try {
            // save security questions

            $sq = new SecurityQuestions(); // @TODO: To be refactored. This should not be used in this manner
            $noofquestions = Raxan::config(securityQuestions::MAX_SQ_CNT_NAME);
            $uid = self::getUniversalId();
            $securityToken = self::getSecurityToken();

            for ($i = 1; $i <= $noofquestions; $i++) {

                $sq->addSecurityQuestionsAnswer($uid, $sqnAnswers[$i]["questionid"], $sqnAnswers[$i]["answer"]);
            }

            return $sq->saveSecurityQuestions($uid, $securityToken);
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     *
     * @param AuthenticateWS\user $user
     * @return boolean
     *
     */
    public static function saveSecurityQuestions($user) {
        try {
            // save security questions

            $sq = new securityQuestions();
            $noofquestions = Raxan::config(securityQuestions::MAX_SQ_CNT_NAME);


            $ansPrefix = securityQuestions::ANSW_ELEMENT_NAME_PREFIX;
            $quesPrefix = securityQuestions::QUST_ELEMENT_NAME_PREFIX;
            $uid = $user->uid;
            $securityToken = $user->securityToken;

            for ($i = 1; $i <= $noofquestions; $i++) {
                $ansname = $ansPrefix . $i;
                $qusname = $quesPrefix . $i;
                $questionId = $_POST[$qusname];
                $answer = $_POST[$ansname];

                $sq->addSecurityQuestionsAnswer($uid, $questionId, $answer);
            }

            return $sq->saveSecurityQuestions($uid, $securityToken);
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     *
     * This checks whether the answers to the two randomly selected security questions are correct
     * @param AuthenticateWS\user  $user
     * @param array $sqAnswers
     * @return boolean
     */
    public static function validateSecurityQuestionsAnswers($user, $sqAnswers) {
        try {
            return securityQuestions::validateSecurityQuestions($user, $sqAnswers);
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     * This gets two randomly selected user security questions
     * @param AuthenticateWS\user  $user
     * @return array
     */
    public static function getSecurityQuestions($user) {
        try {
            return securityQuestions::getSecurityQuestions($user);
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return null;
    }

    /**
     * This checks whether the user has setup his or her security questions
     * @param AuthenticateWS\user  $user
     * @return boolean 
     */
    public static function checkSecurityQuestions($user) {
        try {

            return securityQuestions::hasSecurityQuestions($user);
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }

        return false;
    }

    /**
     *
     * @param AuthenticateWS\user $user
     * @return boolean 
     * 
     */
    public static function checkPasswordWarningDays($user) {
        try {
            // password warning days : user is alerted to change password
            $pwdwarningdaysexpiry = Raxan::config('password-warning-days');
            return $user->daysToExpiry > 0 && $user->daysToExpiry <= $pwdwarningdaysexpiry;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_INVALIDPASSWORD;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     *
     * @param AuthenticateWS\user $user
     * @return boolean
     *
     *
     */
    public static function checkForcePinChange($user) {

        try {
            return $user->forcePinChange;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_INVALIDPASSWORD;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     *
     * @param AuthenticateWS\user $user
     * @return boolean
     *
     */
    public static function checkNewUserStatus($user) {
        try {
            return trim(strtoupper($user->internalStatus)) == self::LOGIN_STATUS_NEW;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_INVALIDPASSWORD;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /*     * *
     *
     *
     */

    public static function setUserPassword($customerId, $securityToken, $password) {
        try {

            $clientService = self::getWebService('AuthenticateWS');
            $supparam = new \AuthenticateWS\setUserPassword();
            $supparam->customerId = $customerId;
            $supparam->token = $securityToken;
            $supparam->newPassword = $password;

            $rt = $clientService->setUserPassword($supparam);



            if (isset($rt->return->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);
                return false;
            }
            return $rt->return->result;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_PASSWORDNOTCHANGED;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     *
     * @param \AuthenticateWS\user $user
     * @return boolean
     */
    public static function activateAccount($user) {
        try {
          
            $clientService = self::getWebService('AuthenticateWS');
            $param = new \AuthenticateWS\activateAccount();
            $param->customerNo = $user->customerID;
            $param->token = $user->securityToken;




            $rt = $clientService->activateAccount($param);



            if (isset($rt->return->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);
                return false;
            }
            return $rt->return->result;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_PASSWORDNOTCHANGED;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     *
     * @param \AuthenticateWS\user $user
     * @return string verificationKey
     */
    public static function EmailVerificationKey($user) {
        try {

            $clientService = self::getWebService('AuthenticateWS');
            $evkparam = new \AuthenticateWS\emailVerificationKey();
            $evkparam->customerId = $user->customerID;
            $evkparam->token = $user->securityToken;
            $evkparam->verificationKeyType = Shared::VERIFICATION_KEY_TYPES_CHANGEPWD;

            $rt = $clientService->emailVerificationKey($evkparam);

            if (isset($rt->return->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);
                return false;
            }
            return $rt->return->result;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_INVALIDPASSWORD;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     *
     * @param AuthenticateWS\user $user
     * @return boolean
     *
     */
    public static function checkForcePasswordChange($user) {
        try {
            return $user->forcePasswordChange;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_INVALIDPASSWORD;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     *
     * @param AuthenticateWS\user $user
     * @return boolean
     *
     */
    public static function checkPasswordExpiry($user) {
        try {
            return ($user->daysToExpiry <= 0 || $user->loginStatus == User::LOGIN_STATUS_PWDEXPIRE);
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_INVALIDPASSWORD;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     * This checks should there be security questions check
     * @param AuthenticateWS\user $user
     * @return boolean
     */
    public static function allowSecurityQuestionsCheck($user) {
        try {
            $clientService = self::getWebService('CIServiceWS');
            $param = new \CIServiceWS\GetUserPreference();
            $param->uid = $user->uid;
            $rt = $clientService->GetUserPreference($param);


            if (isset($rt->return->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);
                return false;
            }

            $userPreferences = $rt->return->result;

            return $userPreferences->aclAllowSecurityQuestions == 1 ||
            $userPreferences->aclAllowSecurityQuestions == 3;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
            Raxan::loadLangFile('errors');
        }
        return false;
    }

    /**
     *
     * @param AuthenticateWS\user $user
     * @return boolean
     *
     *
     */
    public static function allowRememberSecurityQuestions($user) {
        try {
            $clientService = self::getWebService('CIServiceWS');
            $param = new \CIServiceWS\GetUserPreference();
            $param->uid = $user->uid;
            $rt = $clientService->GetUserPreference($param);

            if (isset($rt->return->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);
                return false;
            }

            $userPreferences = $rt->return->result;
            return $userPreferences->rememberSecurityQuestions == 1 ||
            $userPreferences->rememberSecurityQuestions == 3;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     * This checks user's login name and password. Then it returns an user object
     * @param string $username
     * @param string $password
     * @return AuthenticateWS\user 
     * 
     */
    public static function validateUser($username, $password) {
        try {
            $clientService = self::getWebService('AuthenticateWS');

            $user = new \AuthenticateWS\user();
            $user->password = $password;
            $user->username = $username;
            $param = new \AuthenticateWS\validateUserByPassword();
            $param->user = $user;


            $rt = $clientService->validateUserByPassword($param);


            if (isset($rt->return->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);
                return null;
            }

            self::changeActions($rt->return->result);

            $user = $rt->return->result;
            Shared::data('universal-id', $user->uid);

            return $user;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_INVALIDPASSWORD;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return null;
    }

    /**
     * Validate external user login
     * @param string $user
     * @param string $pwd
     * @param int $pin
     * @param string $remoteIPAddr
     * @return \CISWebService\ciServiceDto
     */
    public static function _validateUser($user, $pwd = null, $pin = null, $internal = false) {

        // create login info
        $loginId = self::createLoginInfo(0, $user);
        $remoteIPAddr = $_SERVER['REMOTE_ADDR'];

        // internal login
        if ($internal) {

            $sid = isset($_COOKIE["intranetsid"]) ? $_COOKIE["intranetsid"] : '';

            $sql = "jmmbdata.dbo.ValidateSession :sid , :ipaddress";
            $rs = self::query($sql, array(
                        ':sid' => $sid,
                        ':ipaddress' => $remoteIPAddr
                    ));

            $row = $rs->fetch(PDO::FETCH_ASSOC);
            $rs->close();

            $message = "";
            if ($row["Username"] != "") {

                $uid = $row['UID'];
                $userName = $row['Username'];

                Shared::data('internal-uid', $uid);
                Shared::data('internal-username', $userName);

                $access = "Moneyline_Internal";

                $query = "Declare @error_message Varchar(200) ";
                $query .= "EXEC jmmbdata.dbo.validate_user_profile_nopwd :user, '$access', @error_message Output ";
                $query .= "Select @error_message as 'Message'";

                $rs = self::query($query, array(':user' => $userName));
                $message = $rs->fetchColumn(0);
                $rs->close();
            }

            // check if user was successfully validated
            $status = (strtoupper($message) == "OK") ? 'OK' :
                    (strtoupper($message) == "NEW") ? 'NEW' : null;
            if ($status === null) {
                self::updateLoginInfo($loginId, 'FAILURE', 0);
                return false;
            }

            if ($status == 'OK' || $status = 'NEW') {

                $customerId = $user;
                $PersonNo = $user;
                $pinNo = 0;
                $fullname = self::getInternalUserName();    // get internal user name

                $customerName = self::getInternalUserName();    // get internal user name
                $customerEMail = Raxan::config('site.email');

                $loginMessage = Raxan::locale(
                                'internal-loginmsg',
                                Shared::getFriendlyGreeting(), // greeting
                                $customerName                  // customer name
                );

                $dt = Raxan::cDate('now');
                $updatedDateTime = $dt->format('l dS of F Y h:i:s A');

                $requireTermsConditions = false;

                $userMenus = null; // menus will be loaded using User::getMenus
                // get client accounts
                $clientAccounts = self::findAccountsByClientNo($PersonNo);

                $clientType = 0;
                $pensionMemNo = 0;

                $lastLoginDate = null;
            }
        }
        // external login
        else {

            $noOfDays = Raxan::config('noofdays-to-lock');
            $xml = self::createLoginXML($user, $pwd, $pin, $remoteIPAddr, $noOfDays);
            $client = self::getWebService('AuthenticateWS');
            $vubpparam = new \AuthenticateWS\validateUserByPassword();

            $userWS = new \AuthenticateWS\user();
            $userWS->username = $user;
            $userWS->password = $pwd;
            $userWS->remoteAddres = $remoteIPAddr;

            $vubpparam->user = $userWS;
            $rt = $client->validateUserByPassword($vubpparam);
            $rt = $rt->return;

            $status = (!$rt || $rt->error || $rt->error == "true") ? null : 'OK';
            if ($status == null) {
                self::updateLoginInfo($loginId, 'FAILURE', 0);
                return false;
            }

            if ($status == 'OK' || $status == 'NEW') {

                $Login = $rt->user;
                $customerId = $Login->customerID;
                $loginStatus = strtoupper(trim($Login->loginStatus));

                $loginStatus = strtoupper(trim($Login->loginStatus));

                switch ($loginStatus) {
                    case self::LOGIN_STATUS_TOOMANYDAYS:
                        self::updateLoginInfo($loginId, 'TOOMANYDAYS_FAILURE', $customerId);
                        break;

                    case self::LOGIN_STATUS_LOCKED:
                    case self::LOGIN_STAUS_ACCOUNTLOCK:
                        self::updateLoginInfo($loginId, 'LOCKED', $customerId);
                        break;

                    case self::LOGIN_STATUS_INVALIDLOGIN:
                        self::updateLoginInfo($loginId, 'INVALIDLOGIN_FAILURE', $customerId);
                        break;
                }

                if (!( $loginStatus == self::LOGIN_STATUS_OK ||
                        $loginStatus == self::LOGIN_STATUS_PWDEXPIRE))
                    return $loginStatus;

                $clintInfo = $rt->clientInfo;
                $fullname = trim($clintInfo->firstName) . " " . trim($clintInfo->lastName);
                $eMail = trim($clintInfo->EMail);
                $taxRegistrationNo = trim($clintInfo->taxRegistrationNo);
                $clientType = trim($clintInfo->clientType);

                if (trim($fullname) == "") {
                    $fullname = $user;
                }

                $customerName = trim($fullname);
                $customerEMail = $eMail;
                $pinNo = 0;

                // update the login message.
                $lastIP = trim($Login->lastIP) == "" ? "Unknown IP" : trim($Login->lastIP);
                $dt = Raxan::cDate(substr($Login->lastLogin, 0, 10));
                $loginMessage = Raxan::locale(
                                'external-loginmsg',
                                Shared::getFriendlyGreeting(), // greeting
                                $customerName, // customer name
                                $Login->visits,
                                $dt->format('F d, Y'),
                                $lastIP
                );

                $updatedDateTime = $rt->lastUpdatedTime;  // We can try and get date from server
                // check it terms and conditions ok
                $requireTermsConditions = (
                        $rt->termsConditions &&
                        $rt->termsConditions->userAcceptanceStatus == 'ACCEPTED'
                        ) ? false : true;

                // get client menus
                $userMenus = self::getUserMenusFromArray($rt->menus);

                // get client accounts
                $clientAccounts = self::extractAccountsFromArray($rt->accounts);

                // obtain associated pension member number
                Shared::loadModel('pension');
                $pensionMemNo = Pension::findByNINO($taxRegistrationNo, $clientType);

                $lastLoginDate = $Login->lastLogin;
            }
        }


        // create the session
        $sessionid = self::createSessionId($customerId, $pinNo, $user);

        // set session values to use used by User model
        Shared::data('base-currency', Raxan::config('base-currency'));  // set user base currency?
        Shared::data('client-accounts', $clientAccounts);
        Shared::data('last-login-datetime', $lastLoginDate);  // @todo updated
        Shared::data('last-updated-datetime', $updatedDateTime);      // last time client account info was loaded
        Shared::data('login-message', $loginMessage);
        Shared::data('customer-name', $customerName);
        Shared::data('client-type', $clientType);
        Shared::data('pension-mem-no', $pensionMemNo);
        Shared::data('customer-id', $customerId);
        Shared::data('customer-email', $customerEMail);
        Shared::data('user-menus', $userMenus);
        Shared::data('session-tracking-id', $sessionid);
        Shared::data('login-tracking-id', $loginId);
        Shared::data('login-name', $user);
        Shared::data('login-ok', true);
        Shared::data('require-terms-conditions', $requireTermsConditions);

        // store session tracking id inside cookie
        setcookie('MnylNeSessId', $sessionid);

        // update user login status
        self::updateLoginInfo($loginId, 'SUCCESS', $customerId);

        return $status;
    }

    public static function validatePassword($username, $password) {

        try {
            $user = self::validateUser($username, $password);
            return strtoupper($user->loginStatus) != self::LOGIN_STATUS_INVALIDLOGIN;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_INVALIDPASSWORD;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }

        return false;
    }

    /**
     *
     * @param String $username
     * @param int $pinNo
     * @return AuthenticateWS\user
     */
    public static function validateUserByPin($username, $pinNo) {
        try {
            $clientService = self::getWebService('AuthenticateWS');


            $param = new \AuthenticateWS\validateUserByPin();
            $param->userName = $username;
            $param->pin = $pinNo;


            $rt = $clientService->validateUserByPin($param);


            if (isset($rt->return->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);
                return false;
            }


            return $rt->return->result;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_INVALIDPIN;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }

        return false;
    }

    // this function is used to validate the pin
    // it is to be merged in to the original function "validatePin"
    // created by Wendell Lawrence 

    public static function validatePin_2($username, $pinNo) {

        $clientService = self::getWebService('AuthenticateWS');


        $param = new \AuthenticateWS\validateUserByPin();
        $param->userName = $username;
        $param->pin = $pinNo;


        $rt = $clientService->validateUserByPin($param);

        return $rt->return;
    }

    public static function validatePin($username, $pinNo) {
        try {
            $clientService = self::getWebService('AuthenticateWS');


            $param = new \AuthenticateWS\validateUserByPin();
            $param->userName = $username;
            $param->pin = $pinNo;


            $rt = $clientService->validateUserByPin($param);



            if (isset($rt->return->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);
                return false;
            }



            return!(strtoupper($rt->return->result->loginStatus) == self::LOGIN_STATUS_INVALIDLOGIN
            );
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_INVALIDPIN;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }

        return false;
    }

    /**
     *
     * @param AuthenticateWS\user $user
     *
     */
    public static function changeActions($user) {
        try {
            $actionTypes = array("changePassword" => 1, "changePIN" => 2, "setupSecurityQustions" => 4);
            $actions = 0;
            if (self::checkNewUserStatus($user)) {
                $actions = 7;
            } else {
                $actions = (self::checkForcePasswordChange($user) || self::checkPasswordExpiry($user) || self::checkPasswordWarningDays($user) ? $actionTypes["changePassword"] : 0);
                $actions += ( self::checkForcePinChange($user) ? $actionTypes["changePIN"] : 0);
                $actions += ( !self::checkSecurityQuestions($user) ? $actionTypes["setupSecurityQustions"] : 0);
            }
            Raxan::data("changeActions", $actions);
            return true;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    /**
     *
     * @return int
     *
     */
    public static function getLoginActionFlow() {
        try {
            $actions = Raxan::data("changeActions");

            return $actions;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return 0;
    }

    /**
     *
     * @return string
     *
     */
    public static function showStartActionMessage() {
        try {
            $actions = Raxan::data("changeActions");
            $showMessage = array(1 => "forcePasswordChangeMessage",
                2 => "forcePINChangeMessage", 3 => "changePasswordnPinMessage",
                4 => "noSQMessage", 5 => "changePasswordnSQMessage",
                6 => "changePINnSQMessage", 7 => "changePasswordPinnSQMessage");

            return $showMessage[$actions];
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }

        return "";
    }

    /**
     *
     * @return string
     *
     */
    public static function showEndActionMessage() {
        try {
            $actions = Raxan::data("changeActions");
            $showMessage = array(1 => "passwordChangedMessage",
                2 => "pinChangedMessage", 3 => "changePasswordnPinCompleteMessage",
                4 => "SQChangedMessage", 5 => "changePasswordnSQCompleteMessage",
                6 => "changePINnSQCompleteMessage", 7 => "changePasswordPinnSQCompleteMessage");

            return $showMessage[$actions];
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }

        return "";
    }

    /**
     *
     *
     */
    public static function changePassword($username, $customerId, $securityToken, $oldPassword, $newPassword) {
        try {

            $clientService = self::getWebService('AuthenticateWS');

//            if(! self::validatePassword($username, $oldPassword))
//                    return false;
            $param = new \AuthenticateWS\ChangePassword();
            $param->customerNo = $customerId;
            $param->newPassword = $newPassword;
            $param->oldPassword = $oldPassword;
            $param->token = $securityToken;

            $rt = $clientService->ChangePassword($param);

//            $errormsg = print_r($rt,true);
            if (isset($rt->return->error)) {


                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);

                //Shared::showMessage($errormsg);
                //Shared::logRedirectToErrorPage($err, $errormsg, $level,$label );
                return false;
            }

            return $rt->return->result;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    public static function changePIN($username, $customerId, $securityToken, $oldPIN, $newPIN) {
        try {

            $clientService = self::getWebService('AuthenticateWS');

            if (!self::validatePIN($username, $oldPIN))
                return false;
            $param = new \AuthenticateWS\ChangePinNo();
            $param->customerNo = $customerId;
            $param->newPinNo = $newPIN;
            $param->oldPinNo = $oldPIN;
            $param->token = $securityToken;

            $rt = $clientService->ChangePinNo($param);



            if (isset($rt->return->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);

                return false;
            }

            return $rt->return->result;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    public static function changeUserName($customerId, $securityToken, $newUsername) {
        try {

            $clientService = self::getWebService('AuthenticateWS');


            $param = new \AuthenticateWS\setUsername();
            $param->customerNo = $customerId;
            $param->newUsername = $newUsername;
            $param->token = $securityToken;

            $rt = $clientService->setUsername($param);



            if (isset($rt->return->error)) {

                // handle returned error. for example, SYSERR
                Raxan::loadLangFile('errors');
                $errormsg = Raxan::locale($rt->return->error);
                Raxan::data("SYSERRMSG", $errormsg);

                return false;
            }

            Shared::data('login-name', $newUsername);
            return $rt->return->result;
        } catch (Exception $e) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level, $label);
        }
        return false;
    }

    // Protected Functions
    // ----------------------------

    protected static function createReminderXML($customerId, $actionDate, $priority, $summary, $details) {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="UTF-8"?>
            <AEReminders:AddEditReminder xmlns:AEReminders="http://www.dtinc.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dtinc.com AddEditReminders.xsd">
            <Customer-Id></Customer-Id>
            <Action-Date></Action-Date>
            <Priority></Priority>
            <Summary></Summary>
            <Details></Details>
            </AEReminders:AddEditReminder>');

        $dom->getElementsByTagName('Customer-Id')->item(0)->nodeValue = $customerId;
        $dom->getElementsByTagName('Action-Date')->item(0)->nodeValue = $actionDate;
        $dom->getElementsByTagName('Priority')->item(0)->nodeValue = $priority;
        $dom->getElementsByTagName('Summary')->item(0)->nodeValue = $summary;
        $dom->getElementsByTagName('Details')->item(0)->nodeValue = $details;

        return $dom->saveXML();
    }

    protected static function createLoginXML($UserName, $PassWord, $PIN, $RemoteAddress, $NoOfDays) {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="UTF-8"?>
            <CheckLogin:checklogin xmlns:CheckLogin="http://www.dtinc.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dtinc.com CheckLogin.xsd">
            <USER-NAME></USER-NAME>
            <PASS-WORD></PASS-WORD>
            <PIN></PIN>
            <REMOTE-ADDRESS></REMOTE-ADDRESS>
            <NO-OF-DAYS></NO-OF-DAYS>
            </CheckLogin:checklogin>');

        $dom->getElementsByTagName('USER-NAME')->item(0)->nodeValue = $UserName;
        $dom->getElementsByTagName('PASS-WORD')->item(0)->nodeValue = $PassWord;
        $dom->getElementsByTagName('PIN')->item(0)->nodeValue = $PIN;
        $dom->getElementsByTagName('REMOTE-ADDRESS')->item(0)->nodeValue = $RemoteAddress;
        $dom->getElementsByTagName('NO-OF-DAYS')->item(0)->nodeValue = $NoOfDays;

        return $dom->saveXML();
    }

    protected static function createRequestHistoryXML(
    $clientName, $sortBy, $sortOrder, $numOfRecs, $details, $status, $startDate, $endDate, $tranType, $accountNo) {

        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="UTF-8"?>
            <cs:searchoptions xmlns:cs="http://www.dtinc.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dtinc.com ClientTransactionSearchoptions.xsd">
		<clientname></clientname>
		<sortby></sortby>
		<sortorder></sortorder>
		<nooftransactions></nooftransactions>
		<description></description>
		<status></status>
		<transactiontype></transactiontype>
		<accountno></accountno>
		<requestedstartperiod></requestedstartperiod>
		<requestedendperiod></requestedendperiod>
		</cs:searchoptions>'
        );

        $dom->getElementsByTagName('clientname')->item(0)->nodeValue = $clientName;
        $dom->getElementsByTagName('sortby')->item(0)->nodeValue = $sortBy;
        $dom->getElementsByTagName('sortorder')->item(0)->nodeValue = $sortOrder;
        $dom->getElementsByTagName('nooftransactions')->item(0)->nodeValue = $numOfRecs;
        $dom->getElementsByTagName('description')->item(0)->nodeValue = $details;
        $dom->getElementsByTagName('status')->item(0)->nodeValue = $status;
        $dom->getElementsByTagName('transactiontype')->item(0)->nodeValue = $tranType;
        $dom->getElementsByTagName('accountno')->item(0)->nodeValue = $accountNo;
        $dom->getElementsByTagName('requestedstartperiod')->item(0)->nodeValue = $startDate;
        $dom->getElementsByTagName('requestedendperiod')->item(0)->nodeValue = $endDate;

        $result = $dom->saveXML();
        return $result;
    }

    protected static function createTermsXML($cutomerId, $expireInDays, $status, $username=null) {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="UTF-8"?>
            <TermsConditions:Conditions xmlns:TermsConditions="http://www.dtinc.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dtinc.com TermsConditions.xsd ">
            <Client-No></Client-No>
            <User-Name></User-Name>
            <Status></Status>
            <No-Of-Days></No-Of-Days>
            </TermsConditions:Conditions>');

        $dom->getElementsByTagName('Client-No')->item(0)->nodeValue = $cutomerId;
        $dom->getElementsByTagName('Status')->item(0)->nodeValue = $status;
        $dom->getElementsByTagName('No-Of-Days')->item(0)->nodeValue = $expireInDays;
        $dom->getElementsByTagName('User-Name')->item(0)->nodeValue = $username;

        return $dom->saveXML();
    }

    protected static function createUserInfoXML($ClientNo, $UserName, $FromDate, $ToDate) {
        $dom = new \DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="UTF-8"?>
            <Reminders:Reminders xmlns:Reminders="http://www.dtinc.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dtinc.com Reminders.xsd ">
            <Client-No></Client-No>
            <User-Name></User-Name>
            <From-Date></From-Date>
            <To-Date></To-Date>
            </Reminders:Reminders>');
        $dom->getElementsByTagName('Client-No')->item(0)->nodeValue = $ClientNo;
        $dom->getElementsByTagName('User-Name')->item(0)->nodeValue = $UserName;
        $dom->getElementsByTagName('From-Date')->item(0)->nodeValue = $FromDate;
        $dom->getElementsByTagName('To-Date')->item(0)->nodeValue = $ToDate;

        return $dom->saveXML();
    }

}

?>
