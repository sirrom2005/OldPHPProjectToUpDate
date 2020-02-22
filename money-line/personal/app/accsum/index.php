<?php
/**
 * Account Summary Module
 * Displays home page and account summary information
 */

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';
require_once PERSONAL_MODEL_PATH.'accountinfo.php';

use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\AccountInfo;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;

/**
 * @property MoneylineNavbar $navbar
 * @property RaxanElement $expAccount
 * @property RaxanElement $expBranch
 */
class HomePage extends SecureWebPageController {

    protected $moduleId = 2; // ACCOUNT SUMMARY

    protected $accProdType  = '';
    protected $accCategory  = '';
    protected $refreshAccounts = false;
    protected $currencyRates;
    protected $allReminders = false;

    protected $nextBusinessDay;
    protected $sanitizer;

    protected function _config() {
        parent::_config();
        
        $this->mnuItem = 'HOME';

        Raxan::loadLangFile('accsum-module');       // load module language file
        Raxan::loadWidget('moneyline/navbar');      // navbar widget
        //Raxan::loadWidget('moneyline/adnote');    // advert widget

    }

    protected function _indexView() {
        $this->appendView('home.view.php'); // load view
        $this->loadScript('jquery-ui');
        $this->loadScript('jquery-scrollto');
    }

    protected function _load() {
        parent::_load(); // load shared master page

        $showPrefOnLogin = User::getUserPreference("showPrefsOnLogin");
        if($showPrefOnLogin == 1 ||
                $showPrefOnLogin == 3)
        {
            $url="../profile/preferences.php";
            if(User::setUserPreference("showPrefsOnLogin",0))
            {
                $this->redirectTo($url);
                return ;
            }
        }
        if (!$this->isAjaxRequest) {
            // register locale variables for client-side
            $this->registerVar('no-encash-rights',$this->Raxan->locale('no-encash-rights'));
            $this->registerVar('payee-missing',$this->Raxan->locale('payee-missing'));
            $this->registerVar('branch-missing',$this->Raxan->locale('branch-missing'));
            $this->registerVar('amount-missing',$this->Raxan->locale('amount-missing'));
            $this->registerVar('pin-missing',$this->Raxan->locale('pin-missing'));
            $this->registerVar('invalid-pin', $this->Raxan->locale('invalid-pin'));
            $this->registerVar('cut-off-time-pass',$this->Raxan->locale('cut-off-time-pass'));
            $this->registerVar('not-business-day',$this->Raxan->locale('not-business-day'));
            $this->registerVar('encash-message',$this->Raxan->locale('encash-message'));

            $this->registerVar('confirm-delete',$this->Raxan->locale('confirm-delete'));
            $this->registerVar('actiondate-incorrect',$this->Raxan->locale('actiondate-incorrect'));
            $this->registerVar('summary-missing',$this->Raxan->locale('summary-missing'));
            $this->registerVar('details-missing',$this->Raxan->locale('details-missing'));
        }

        $this->sanitizer = Raxan::dataSanitizer();
        $this->sanitizer->enableDirectInput();

        $this["#help"]->bind("#click",array(
            "callback"=>".showHelp",
            //"data"=>"login",
            "prefTarget"=>"target@help.php?vuh=accsum"
            ));

        // load page content
        if (!$this->isAjaxRequest) {

            // load the jQuery ui & Scroll To plugin
            $this->navbar->itemHeight = 75; // set navbar height

            // show welcome message
            $msg = User::getLoginMessgae();
            $this->welcomemsg->html($msg);

            // list account types
            $accTypes = SysInfo::getAccountDetails();//getProductTypes();//

            //$msg = print_r($accTypes, true);
            //$this->showMessage($msg);
            foreach ($accTypes as $i=>$accType) {
                $accTypes[$i]['count'] = User::countAcctbyType($accType['productType'],$accType['accountCategory']);
            }
            $this->accountTypes->bind($accTypes);

            // list currencies
            $this->currencyRates = SysInfo::getAllFxRatesAmount();
            $this->selCurrency->bind($this->currencyRates);

            // set default action date for reminders
            $date = new DateTime();
            $this->actiondate->val($date->format('Y-m-d'));

            // get request history
            $reqst = User::getTodaysRequestHistory();
            //$this->requestPending->text($this->Raxan->locale('request-pending',count($reqst)));
            $this->requestPending->textVal(count($reqst));
            // @todo: Display today's request history

            // setup express screen
            $prefs = User::getUserPreferences();
            $clientAccounts = User::getClientAccounts();
            //echo "<pre>";
            //print_r($clientAccounts);
            //echo "</pre>";
            $accounts = array();
            foreach ($clientAccounts as $i=>$account) {
                $prodType = strtoupper($account['ProductType']);
                if ($prodType=='FUND' &&
                    User::hasRights($account, 'WD') &&
                    User::hasSignInstruction($account, 'Any one to sign')
                ) {
                    $row = array();
                    $row['Currency'] = $account['Currency'];
                    $row['AccountNo'] = $account['AccountNo'];
                    $row['AvailableBalance'] = number_format($account['AvailableBalance'],2);
                    $accounts[] = $row;

                    if ($account['AccountNo'] == $prefs->defaultAccountNo)  { // Set default value
                        $this->expAccBalance->text($account['Currency'] . ' ' .number_format($account['AvailableBalance'],2));
                        $this->expAccCurrency->text($account['Currency']);
                    }
                }
            }
            if (count($accounts)==0) $this->expAccount->html('<option>'.Raxan::locale('no-accounts').'</option>');
            else {
                $this->expAccount->bind($accounts);
                $this->expAccount->val($prefs->defaultAccountNo);
            }
            // branches
            $branches = Sysinfo::getTransactionalBranches(User::getClientType(),false);
            $this->expBranch->bind($branches);
            $this->expBranch->prepend('<option>'.Raxan::locale('choose-branch').'</option>');

            // set default values
            $this->expAccName->val(User::getCustomerName());
            if ($prefs->branchCode) $this->expBranch->val($prefs->branchCode);
            if ($prefs->defaultAccountNo) $this->expAccount->val($prefs->defaultAccountNo);

            $this->expAccBalance->text($prefs->defaultAccountNo);
            if (((!$prefs->defaultAccountNo) || $prefs->defaultAccountNo == 'null') && count($accounts) > 0) {
                $this->expAccBalance->text($accounts[0]['Currency'] . ' ' . $accounts[0]['AvailableBalance']);
                $this->expAccCurrency->text($accounts[0]['Currency']);
            }
            


            // check if holiday or weekend
            $date = SysInfo::getTodaysDate();
            if (SysInfo::isHoliday($date) || 
                SysInfo::isWeekend($date)) $this->holiday->val(1);

            // check if cut off time
            if (SysInfo::isHeadOfficeCutOffTime($date)) $this->cutofftime->val(1);

            // set next business day
            $this->nextBusinessDay = SysInfo::getEffectiveDate($date);
            $this->registerVar('_nextBusinessDay', $this->nextBusinessDay);

        }

        $this->allReminders = $this->data('viewAllReminders');
        
    }

    protected function _prerender() {
        if (!$this->isAjaxRequest) {
            $this->showNotices();
            $this->showReminders();
            $this->showAccountSummary($this->refreshAccounts);
        }
    }


    /**
     * Add Reminder
     */
    protected function addReminder($e) {
        $post = $this->post;

        $actionDate = $post->formatDate('actiondate', 'm/d/y');
        $priority = in_array($post->textVal('priority'), array('H','M','L')) ? $post->textVal('priority') : '';
        $summary = substr($post->textVal('summary'),0,200);
        $details = substr($post->textVal('details'),0,500);

        // validate input
        $msg = array();
        $timestamp = new DateTime($actionDate);
        $timestamp = $timestamp->getTimestamp();
        if (!$actionDate || $timestamp < time()) $msg[] = $this->Raxan->locale('actiondate-incorrect');
        if (!$priority) $msg[] = $this->Raxan->locale('priority-missing');
        if (!$summary) $msg[] = $this->Raxan->locale('summary-missing');
        if (!$details) $msg[] = $this->Raxan->locale('details-missing');
        if (count($msg)>0) {
            $bullet = '*&nbsp;';
            $msg = $bullet.implode("<br />".$bullet,$msg);
            $this->msgbox->showMessage($msg,'Reminders');
            return;
        }

        // add reminder
        $rt = User::addReminder($actionDate, $priority, $summary, $details);
        if (!$rt) {
            c()->alert($this->Raxan->locale('update-failed'));
        }
        else {
            $this->showReminders();
            $this['#remindercontent']->updateClient();
            $this->reminderTitle->updateClient();
            c('#cancelReminderBtn')->click(); // close the form
        }
    }

    /**
     * Change Account type Event
     */
    protected function changeAccType($e) {
        $accType = $this->accountTypes->val();
        $accTypes = SysInfo::getAccountDetails();

        // setup filters
        if ($accType >0) $accType = $accType - 1;
        if (isset($accTypes[$accType])) {
            $this->accProdType = $accTypes[$accType]['productType'];
            $this->accCategory = $accTypes[$accType]['accountCategory'];
        }
    }

    /**
     * Delete reminder event
     */
    protected function deleteReminder($e) {
        $id = $e->intVal();

        if (!User::deleteReminder($id)) {
            $this->msgbox->showMessage($this->Raxan->locale('update-failed'));
        }
        else {
            $reminders = $this->allReminders ? User::getAllReminders() : User::getReminders();
            if (count($reminders)==0) {
                $elm = $this['#reminders .content'];
                $elm->html(Raxan::locale('no-reminders'));
                $elm->updateClient();
            }
        }
    }

    /**
     * Refresh Account balance event
     */
    protected function refreshAccountBalance($e) {
        $this->refreshAccounts = true;

        // call the changeAccType method/event
        $this->changeAccType($e);
    }

    protected function expressEncashment($e) {
        $_account = $this->expAccount->textVal();
        $_payee = $this->expAccName->textVal();
        $_amount = $this->expAccAmt->textVal();
        $_branch = $this->expBranch->textVal();

        //-- Validate user pin
        $wsClient = SharedDataModel::getWebService('AuthenticateWS');
        $param = new \AuthenticateWS\validateUserByPin();
        $param->userName = User::getLoginName();
        $param->pin = $this->expPin->textVal();

        $rt = $wsClient->validateUserByPin($param);
        $user   = $rt->return->result;

         if ($user->loginStatus == User::LOGIN_STATUS_INVALIDLOGIN) {
             Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_WRONGPIN);
            $this->msgbox->showMessage($msg);
            return false;
         }
         if (!User::hasRights($_account, "WD") || !User::hasSignInstruction($_account, 'Any one to sign')) {
            $msg = Raxan::locale('no-encash-rights');
            $this->msgbox->showMessage($msg);
            return false;
         }

         $wsClient = SharedDataModel::getWebService('CIServiceWS');
         
         $fundEncash = new fundEncashmentDTO();
         $fundEncash->cyclePeriod = "ONETIME";
         $fundEncash->accountNo = $_account;
         $fundEncash->payee = $_payee;
         $fundEncash->amountType = "FIXED";
         $fundEncash->amount = $_amount;
         $fundEncash->paymentMethod = "CHEQUE";
         $fundEncash->deliveryMethod = "PICKUP";
         $fundEncash->actionDate = SysInfo::getEffectiveDate(SysInfo::getTodaysDate());
         $fundEncash->branchAssigned = $_branch;
         $fundEncash->chargeCommission = false;
         $fundEncash->authorized = true;
         $fundEncash->description = "Express Encashment";
         $fundEncash->assignedTo = "MONEYLINE";
         $fundEncash->loggedBy = User::getLoginName();

         $param = new \CIServiceWS\doFundEncashment();
         $param->xMLString = $fundEncash->createXML();

         $return = $wsClient->doFundEncashment($param);
         $result = $return->return;

         //print_r($return->return);
         if ($result->error != 0){
             $this->msgbox->showMessage($result->message, 'Express Checkout');
             return false;
         }
         $msg = 'Transaction processed successfully.<br>Your request number is : ' . $result->requestNo;
         $this->showMessage($msg);

         $this->expAccAmt->val("");
         $this->expPin->val("");

         $this->refreshAccounts = true;

        // call the changeAccType method/event
         $this->changeAccType($e);
        //$this->showAccountSummary(false);
    }


    // show all reminders
    protected function viewAllReminders($e) {
        $reminders = User::getAllReminders();
        if (count($reminders)==0) {
            $this['#reminders .content']->html($this->Raxan->locale('no-reminders'));
        } 
        else {
            $title = $this->reminderTitle;
            $elm = $this['#reminders .content'];
            // show all reminders
            $elm->bind($reminders)->updateClient();
            $title->attr('langid','all-reminders')->updateClient();
            $this->allReminders = $this->data('viewAllReminders',true);
        }
    }

    // show reminder details event
    protected function viewReminderDetails($e) {
        $id = $e->intVal();
        $data = User::getReminderDetails($id);
        $dt = DateTime::createFromFormat('d/m/Y',$data['ActionDate']); //@todo: convert to ISO
        $data['ActionDate'] = $dt->format('Y-m-d');
        $detail = $this['<div id="reminderDetails'.$id.'" class="reminderDetails hide" />'];
        $detail->appendView('home.reminderdetails.view.php')->bind($data);
        $detail->updateClient()->client->slideDown();
    }

    // show notices
    protected function showNotices() {
        $notices = User::getNotices();
        if (count($notices) == 0) $this->notices->remove();
        else {
            $this['#notices .content']->bind($notices); // show notices
        }
    }

    // reminders
    protected function showReminders() {
        $html = '';
        $reminders = $this->allReminders ? User::getAllReminders() : User::getReminders();
        if (count($reminders)==0) {
            $this['#reminders .content']->html($this->Raxan->locale('no-reminders'));
        }
        else {
            if ($this->allReminders) {
                $this->reminderTitle->attr('langid','all-reminders');
            }
            else {
                $cn = 0; $filter = array();
                foreach($reminders as $rem) {
                    $cn++;  // display only top 5 reminders
                    if ($rem['Details']!='') $filter[] = $rem;
                    if ($cn==5) break;
                }
                $reminders = $filter;
            }
            $this['#reminders .content']->bind($reminders); // show reminders
        }
    }

    // show account summary
    protected function showAccountSummary($refresh = false) {
        // @todo: Rewrite this function to use Stephen's template approach - 
        $TotalCurrentBalance = 0.00;
        $TotalAvailableBalance = 0.00;
        $TotalLiens        = 0.00;
        $TotalUEs            = 0.00;
        $TotalDollarValue = 0.00;

        $html = array();

        // create data formater/sanitizer object
        $format = $this->Raxan->dataSanitizer(array());
        $format->enableDirectInput(); 
 
        //$this->showMessage(count(User::getClientAccounts()));
        $dtUpdate = User::getLastUpdatedDateTime();
        $accounts = User::filterAcctbyType(
            $this->accProdType,
            $this->accCategory,
            $refresh
        );
        if ($refresh) {
            $dtOldUpdate = User::getLastUpdatedDateTime();
            if ($dtOldUpdate==$dtUpdate) {
                $html = $this->Raxan->locale('account-not-refresh').'<br />';
            }
        }

        // get selected acctype
        $accType = $this->accountTypes->val();
        $prefs = User::getUserPreferences();
        if (!$accType) $accType = $prefs->accountType;
        if ($accType) 
            $this->accountTypes->val($accType);
        else 
            $accType = 0;

        // list accounts
        if (count($accounts)<=0) {
             $html[]= '<p><strong>'.$this->Raxan->locale('accounts-not-found',User::getLoginName()).'</strong></p><br><br>';
        }
        else {
            foreach ($accounts as $i=>$account) {
                $AccountNumber[$i] = $account['AccountNo'];
                $CurrentBalance    = User::convertAmount($account["Currency"], $account['CurrentBalance']);
                $AvailableBalance  = User::convertAmount($account["Currency"], $account['AvailableBalance']);
                $UnclearFunds      = User::convertAmount($account["Currency"], $account['UnclearedBalance']);
                $Liens             = User::convertAmount($account["Currency"], $account['LiensBalance']);
                $TotalDollarValue  = 0.00;

                $assetList         = $account['AssetList'];
                $liabilityList     = $account['LiabilityList'];

                $productType = strtoupper(trim($account['ProductType']));
                $accountCategory = strtoupper(trim($account['AccountCategory']));

                $accounts[$i]['AccNo'] = $i;
                $accounts[$i]['displayAccountName'] = str_pad(strlen($account['AccountName']) <= 40 ? $account['AccountName'] : (substr($account['AccountName'], 0, 40). '...'), 43,  ' ');
                $accounts[$i]['AccountBalance'] = round($account['CurrentBalance'],2);
                $accounts[$i]['AccType'] = $accType; 
                $accounts[$i]['showList'] = (($assetList && count($assetList) > 0) || ($liabilityList && count($liabilityList) > 0)) ? '' : 'none';
                
 
                /*
                // display current and available balances
                $html[]= '<!-- Current and Available Balances --> 
                    <table class="tpm" width="100%"  style="border:1px solid #71B6A3" bordercolor="#81AED4" cellpadding="0" cellspacing="0">
                       <tr bgcolor="#FCF6AE">
                        <td height="20" colspan="2">
                         <table width="100%" cellspacing="0" cellpadding="0">   
                            <tr> 
                              <td width="449"><img src="views/images/yellow_bullet.gif">&nbsp;Account No:&nbsp;<b>
                              <a href="app/info/accountdetails.php?AccNo='.$i.'&AccType='. $accType . '" title="Click here to view account details and transactions">'.$account['AccountNo'].'</a>  - <span langid="account-name" title="' . $account['AccountName'] . '">' .
                                (strlen($account['AccountName']) <= 50 ? $account['AccountName'] : (substr($account['AccountName'], 0, 50). '...')) . '</span></b></td>
                              <td width="141"><div align="right"><a title="Click here to view investment breakdown." href="app/info/investmentinfo.php?FundNo='.$account['FundNo'].'&AccountBalance='.round($account['CurrentBalance'],2).'&AccountNo='.$account['AccountNo'].'"><b>'.$account['AccountDescription'].'</b></a></div></td>
                              <td width="57" align="right">';
                              if (($assetList && count($assetList) > 0) || ($liabilityList && count($liabilityList) > 0)) {
                                 $html[]= '<a href="javascript:;"><img src="'.($prefs['showDetails'] == 0 ? 'views/images/plus.gif' : 'images/minus.gif').'" alt="'.$this->Raxan->locale('show-hide-details').'" name="show_hide_'.$i.'" hspace="3" border="0" id="show_hide_'.$i.'" style="cursor:hand" onClick="showHideDetail('.$i.')"></a>';
                              }
                      $html[]= '</td> 
                            </tr>
                        </table> 
                       </td>
                      </tr>';
                      /*<tr valign="middle" bgcolor="#A7D2E7">
                        <td height="20" colspan="2">
                            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td width="120" valign=top langid="account-name">&nbsp;Account Name:</td>
                                  <td valign=top><b>'.$account['AccountName'].'</td>
                                </tr>
                            </table>  
                        </td>
                      </tr>';*//*
                      //if ($AvailableBalance != $CurrentBalance){ 
                          $html[]= '<tr bgcolor="#F0F6FA">
                              <td width="30%" height="20">&nbsp;Current Balance:</td>
                              <td width="70%" align="right">'.$format->formatMoney($account["CurrentBalance"], 2,$account["Currency"]).'</td>
                          </tr>';
                      //} 
                      $html[]='<tr bgcolor="#D8EBFA"> 
                          <td width="30%">&nbsp;Available Balance: </td>
                          <td width="70%" align="right">'.
                            $format->formatMoney($account["AvailableBalance"], 2, $account["Currency"]).'
                          </td>
                    </tr>
                </table>';

                // display Equity (EMMA) account asset list
                if ($productType == "FUND" && $assetList && count($assetList) > 0){
                    $equityCurrency = '';
                    $html[]='<!-- EMMA Account -->  
                        <table width="100%"  border="1" cellspacing="0" cellpadding="0">
                          <tr id="detail_'.$i.'" style="display:'.($prefs['showDetails'] == 0 ? 'none': '').'">
                            <td>
                              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td >
                                      <table width="100%"  border="1" bordercolor="#81AED4" cellpadding="0" cellspacing="1">
                                        <tr bgcolor="#F0F6FA"> 
                                          <td height="20" colspan="5">Equity held as reported by JCSD: </td>
                                        </tr>
                                        <tr valign="middle"  bgcolor="#A7D2E7">
                                          <td height="20" width="14%"><b>Symbol</b> </td>
                                          <td height="20" width="15%"><b>Units</b></td>
                                          <td height="20" width="15%"><b>Market Price</b></td>
                                          <td height="20" width="18%"><b>Market Date</b></td>
                                          <td height="20" width="20%"><b>Dollar Value</b></td>
                                        </tr>';
                                for ($t = 0; $t < count($assetList); $t++) {
                                    $equity = $assetList[$t];
                                    if ($equity->assetKey == $accounts[$i]['AccountNo']) continue;
                                    $equityCurrency = $equity->currency;
                                    $html[]= '<tr bgcolor="#D8EBFA">
                                        <td height="20" width="14%"><a href="stockInfo&symbol='.$equity->assetKey.'" Title="">
                                            '.((float)$accounts[$i]['AccountNo'] == (float)$equity->assetKey ? Raxan::locale('cash-value') : $equity->assetKey).'
                                        </a></td>
                                        <td height="20" width="15%" align="right">
                                            '.$format->formatNumber($equity->assetValue,2).'
                                        </td>
                                        <td width="15%" align="right">
                                            '.$format->formatNumber($equity->purchaseValue,2).'
                                        </td>
                                        <td width="18%" align="left">
                                            '.$format->formatDate(str_replace(':','-',$equity->purchaseDate),'d-M-Y').'
                                        </td>
                                        <td width="20%" align="right">
                                            '.$format->formatNumber($equity->yield,2).'
                                        </td>
                                    </tr>';
                                    $TotalDollarValue += str_replace(',', '',$equity->yield);
                                }

                            $html[]='<tr bgcolor="#D8EBFA">
                                      <td height="20" bgcolor="#D4E5F1" colspan="3">&nbsp;</td>
                                      <td bgcolor="#A7D2E7" width="18%"><b>Total:</b></td>
                                      <td bgcolor="#A7D2E7" width="20%" align="right">
                                        '.$format->formatMoney($TotalDollarValue, 2, $equityCurrency).'
                                      </td>
                                    </tr>
                                  </table>
                                 </td>
                                </tr>
                             </table></td>
                         </tr>
                    </table>';
                }
  
                // display  Sure Investor account asset list
                if ($productType == "INVESTOR" && $accountCategory == "TRADING ACCOUNT" && $assetList && count($assetList) > 0){
                    $html[]= '<table width="100%"  border="0" cellspacing="0" cellpadding="0">
                        <tr id="detail_'.$i.'"  style="display:'.($prefs['showDetails'] == 0 ? 'none': '').'">
                            <td>
                              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td>
                                      <table width="100%"  border="1" bordercolor="#81AED4" cellpadding="0" cellspacing="1">
                                        <tr bgcolor="#F0F6FA">
                                          <td colspan="3" height="20">Maturities:</td>
                                        </tr>
                                        <tr bgcolor="#F0F6FA">
                                          <td width="30%" height="20"><b>Issue Date</b></td>
                                          <td><b>Maturity Date</b></td>
                                          <td align=right><b>Net Amount Due</b></td>
                                        </tr>';
                                for ($t = 0; $t < count($assetList); $t++) {
                                        $investment = $assetList[$t];
                                        $html[]='<tr bgcolor="#D8EBFA">
                                          <td height="20">'.
                                            $format->formatDate(str_replace(':','-',$investment->purchaseDate),'d-M-Y').'
                                          </td>
                                          <td>'.
                                            $format->formatDate(str_replace(':','-',$investment->maturityDate),'d-M-Y').'
                                          </td>
                                          <td align="right">'.
                                            $format->formatMoney($investment->netAmountDue,2,$investment->currency).'
                                          </td>
                                        </tr>';
                                }
                                $html[]='</table>
                                    </td>
                                </tr>
                            </table></td>
                        </tr>
                    </table>';
                }

                // display seller account liabilities
                if ($productType == "SELLER" && $liabilityList && count($liabilityList) > 0) {
                    $html[]= '<table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          <tr id="detail_'.$i.'" style="display:'.($prefs['showDetails'] == 0 ? 'none': '').'">
                            <td>
                              <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                  <td >
                                      <table width="100%" border="1" bordercolor="#81AED4" cellpadding="0" cellspacing="1">
                                        <tr bgcolor="#F0F6FA">
                                          <td colspan="3" height="20">PNotes:</td>
                                        </tr>
                                        <tr bgcolor="#F0F6FA">
                                          <td width="30%" height="20"><b>Issue Date</b></td>
                                          <td><b>Maturity Date</b></td>
                                          <td align=right><b>Net Amount Due</b></td>
                                        </tr>';
                              for ($t = 0; $t < count($liabilityList); $t++) {
                                  $seller = $liabilityList[$t];
                                  $html[]='<tr bgcolor="#D8EBFA">
                                          <td height="20" bgcolor="#D8EBFA">'.
                                            $format->formatDate(str_replace(':','-',$seller->originatedDate),'d-M-Y').'
                                          </td>
                                          <td bgcolor="#D8EBFA">'.
                                            $format->formatDate(str_replace(':','-',$seller->renewalDate),'d-M-Y').'
                                          </td>
                                          <td bgcolor="#D8EBFA" align="right">'.
                                            $format->formatMoney($seller->renewalAmount,2,$seller->currency).'
                                          </td>
                                        </tr>';
                              }
                              $html[]='</table>
                                </td>
                            </tr>
                        </table></td>
                      </tr>
                    </table>';

                }

                // display bond account asset list
                if ($productType == "INVESTOR" && $accountCategory == "BOND ACCOUNT" && $assetList && count($assetList) > 0) {
                    $BondInfo = $accounts[$i]['AssetList'];
                    $html[]='<table width="100%"  border="0" cellspacing="0" cellpadding="0">
                      <tr id="detail_'.$i.'" style="display:'.($prefs['showDetails'] == 0 ? 'none': '').'">
                        <td>
                          <table width="100%"  border="0" cellspacing="0" cellpadding="0">
                            <tr>
                              <td>
                                  <table width="100%"  border="1" bordercolor="#81AED4" cellpadding="0" cellspacing="1">
                                    <tr bgcolor="#F0F6FA">
                                      <td colspan="4" height="20">Maturities:</td>
                                    </tr>
                                    <tr bgcolor="#F0F6FA">
                                      <td width="30%" height="20"><b>Bond</b></td>
                                      <td width="30%" height="20"><b>Issue Date</b></td>
                                      <td><b>Maturity Date</b></td>
                                      <td><b>Maturity Value</b></td>
                                    </tr>';
                              for ($t = 0; $t < count($assetList); $t++) {
                                  $bond = $assetList[$t];
                                  if (strtoupper(trim($bond->prevTradeNo)) != "BOND") Continue;
                                  $html[]='<tr bgcolor="#D8EBFA">
                                      <td height="20">'.
                                        $bond->investmentDescription.'
                                      </td>
                                      <td height="20">'.
                                        $format->formatDate(str_replace(':','-',$bond->asOfDate),'d-M-Y').'&nbsp;
                                      </td>
                                      <td>'.
                                        $format->formatDate(str_replace(':','-',$bond->maturityDate),'d-M-Y').
                                      '</td>
                                      <td align="right">'.
                                        $format->formatMoney($bond->maturityValue,2,$bond->currency).'
                                      </td>
                                    </tr>';
                              }
                              $html[]='</table>
                                </td>
                            </tr>
                        </table></td>
                      </tr>
                    </table>';
                }*/

                /*
                  Logic based on code modified by: Manjunath Y. Maregowda on June 8, 2005.
                  Pupose: To subtract the amount if it is an PNote.
                */
                if (strtoupper($accounts[$i]['AccountType']) != "SELLER"){
                    $TotalCurrentBalance         = $TotalCurrentBalance + $CurrentBalance;
                    $TotalAvailableBalance       = $TotalAvailableBalance + $AvailableBalance;
                    $TotalUEs                    = $TotalUEs + $UnclearFunds;
                    $TotalLiens                  = $TotalLiens + $Liens;
                } else if (strtoupper($accounts[$i]['AccountType']) == "SELLER"){
                    $TotalCurrentBalance         = $TotalCurrentBalance - $CurrentBalance;
                    $TotalAvailableBalance       = $TotalAvailableBalance - $AvailableBalance;
                    $TotalUEs                    = $TotalUEs - $UnclearFunds;
                    $TotalLiens                  = $TotalLiens - $Liens;
                }

            }

            // convert account totals by currency
            $rates = $this->currencyRates;
            $cnt = count($rates); $totals = array();
            for ($i=0; $i < $cnt; $i++){
                $currency = $rates[$i][0];
                $totals[$currency] = array(
                    'currentBalance' => $rates[$i][0].' '.$format->formatNumber(($TotalCurrentBalance/$rates[$i][1]),2),
                    'liens' => $rates[$i][0].' ('.$format->formatNumber(($TotalLiens/$rates[$i][1]),2).')',
                    'uncleared' => $rates[$i][0].' ('.$format->formatNumber(($TotalUEs/$rates[$i][1]),2).')',
                    'availableBalance' => $format->formatNumber(abs(($TotalAvailableBalance/$rates[$i][1])),2)
                );
                if (($TotalAvailableBalance * $rates[$i][1]) < 0) {
                    $totals[$currency]['availableBalance'] = '<span class="red">'.$rates[$i][0].' ('.$totals[$currency]['availableBalance'].')</span>';
                }
                else {
                    $totals[$currency]['availableBalance'] = $rates[$i][0].' '.$totals[$currency]['availableBalance'];
                }
            }

            // get default currency
            $defCur = $this->selCurrency->val();
            if (!$defCur) $defCur = $prefs->currency ? $prefs->currency : Raxan::config('base-currency');

            // show totals
            $this->totalCurrentBalance->text($totals[$defCur]['currentBalance']);
            $this->totalLiens->text($totals[$defCur]['liens']);
            $this->totalUncleared->text($totals[$defCur]['uncleared']);
            $this->totalAvailableBalance->html($totals[$defCur]['availableBalance']);
            $this->registerVar('currencyTotals',$totals); // make the totals array available to the client

        }

        // show html info;
        //if (is_array($html)) $html = '<div>'.implode('',$html).'</div>';
        //$this->accSumInfo->html($html); 
        $this->accSumInfo->bind(
                $accounts,
                array(
                    'callback'=>array($this,'layoutCallback'),
                    'removeUnusedTags'=>true,
                    'format'=>array(
                        'CurrentBalance'=>'number:2',
                        'AvailableBalance'=>'number:2',
                        'AssetList'=>'html',    // format asset list as html
                        'LinksList'=>'html'     // format links list as html
                    )
                ));

    }

    // prepare the data for binding
    public function layoutCallback(&$row, $index, $tpl, $type, &$fmt){
        $assetList = $row['AssetList'];
        $liabilityList = $row['LiabilityList'];

        $row['OwnerShipList'] = null;
        $row['AssetList'] = null;
        $row['LiabilityList'] = null;
        $row['LinksList'] = null;

        $row['AccIdx'] = $index;

        $productType = strtoupper( trim($row["ProductType"]) );
        $accountCategory = strtoupper( trim($row["AccountCategory"]) );
        $accountType = strtoupper( trim($row["AccountType"]) );

        // create entries for the converted values
        /*
        $row['ConvertedCurrentBalance'] = $this->convertValue($row['Currency'], $row['CurrentBalance']);
        $row['ConvertedAvailableBalance'] = $this->convertValue($row['Currency'], $row['AvailableBalance']);
        $row['ConvertedUnclearedBalance'] = $this->convertValue($row['Currency'], $row['UnclearedBalance']);
        $row['ConvertedLiensBalance'] = $this->convertValue($row['Currency'], $row['LiensBalance']);
        */
        $sign = 1;
        if($accountType=="SELLER")$sign = -1;

        // compute totals
        /*
        $this->totals["NetBalance"] += ($this->convertValue($row['Currency'],$row['CurrentBalance']) * $sign);
        $this->totals["AvailableBalance"] += ($this->convertValue($row['Currency'],$row['AvailableBalance']) * $sign);
        $this->totals["UnclearedBalance"] += ($this->convertValue($row['Currency'],$row['UnclearedBalance']) * $sign);
        $this->totals["LiensBalance"] += ($this->convertValue($row['Currency'],$row['LiensBalance']) * $sign);
        */
        
        // Process EMMA accounts
        if($productType=='FUND' && SysInfo::isEquityFund($row['FundNo']) && count($assetList)>0){
            $this->processEmma($row, $index, $assetList);

        }else if($productType=='INVESTOR' && $accountCategory == 'TRADING ACCOUNT' && count($assetList)>0){
            $this->processTrading($row, $index, $assetList);

        } else if($productType=='SELLER' && count($liabilityList) > 0){
            $this->processSeller($row, $index, $liabilityList);

        } else if($productType=='INVESTOR' && $accountCategory == 'BOND ACCOUNT' && count($assetList)>0){
            $this->processBond($row, $index, $assetList);
        }
        C()->console($row);
    }

    protected function processEmma(&$row, $index, $assetList){
        //$assetList = $row['AssetList'];

        $cnt = count($assetList);
        $emmaTotal = 0.00;
        // get the asset list totals and do some pre-formatting where necessary
        for($i=0; $i < $cnt; $i++){
            $assetList[$i]->purchaseDate = str_replace(':','-',$assetList[$i]->purchaseDate);
            if( (int)$row["AccountNo"] == (int)$assetList[$i]->assetKey){
                $assetList[$i]->assetKey ="<span langid='emma.cash'>Cash Value</span>";
                $assetList[$i]->purchaseDate = "now";
            }
            $emmaTotal = $emmaTotal + $assetList[$i]->yield;
        }

        // bind the asset list to the emma template
        $childTempl = $this->bindChildTemplate(
                "home.aux.html","#emmaContainer", "#emmaDetails", $assetList,
                array( 
                    'format'=>array(
                        'assetKey'=>'html',
                        'assetValue'=>'number',
                        'purchaseValue'=>'money:2',
                        'purchaseDate'=>'date',
                        'yield'=>'money:2'
                    ))
                );

        $childTempl->find("#emmaTotal")->text( $this->sanitizer->formatMoney($emmaTotal,2))->end();
        //$this->AssetList->html($childTempl->html());
        $row['AssetList'] = $childTempl->html();
    }

    protected function processSeller(&$row, $index, $assetList){
        $cnt = count($assetList);

        // get the asset list totals and do some pre-formatting where necessary
        for($i=0; $i < $cnt; $i++){
            $assetList[$i]->asOfDate = str_replace(':','-',$assetList[$i]->asOfDate);
            $assetList[$i]->renewalDate = str_replace(':','-',$assetList[$i]->renewalDate);
        }

        $childTempl = $this->bindChildTemplate(
                "home.aux.html","#sellerContainer", "#tradeDetails", $assetList,
                array(
                    'format'=>array(
                        'asOfDate'=>'date',
                        'renewalAmount'=>'money:2',
                        'renewalDate'=>'date'
                    ))
                );

        $row['AssetList'] = $childTempl->html();
    }

    protected function processTrading(&$row, $index, $assetList){
        $cnt = count($assetList);

        // get the asset list totals and do some pre-formatting where necessary
        for($i=0; $i < $cnt; $i++){
            $assetList[$i]->purchaseDate = str_replace(':','-',$assetList[$i]->purchaseDate);
            $assetList[$i]->maturityDate = str_replace(':','-',$assetList[$i]->maturityDate);
        }

        // bind the asset list to the emma template
        $childTempl = $this->bindChildTemplate(
                "home.aux.html", "#tradeContainer", "#tradeDetails", $assetList,
                array(
                    'format'=>array(
                        'maturityDate'=>'date',
                        'netAmountDue'=>'money:2',
                        'purchaseDate'=>'date'
                    ))
                );

        $row['AssetList'] = $childTempl->html();
    }

    protected function processBond(&$row, $index, $assetList){
        $cnt = count($assetList);

        // get the asset list totals and do some pre-formatting where necessary
        for($i=0; $i < $cnt; $i++){
            $assetList[$i]->asOfDate = str_replace(':','-',$assetList[$i]->asOfDate);
            $assetList[$i]->maturityDate = str_replace(':','-',$assetList[$i]->maturityDate);
        }

        $childTempl = $this->bindChildTemplate(
                "home.aux.html","#bondContainer", "#bondDetails", $assetList,
                array(
                    'format'=>array(
                        'asOfDate'=>'date',
                        'maturityValue'=>'money:2',
                        'maturityDate'=>'date'
                    ))
                );     

        $row['AssetList'] = $childTempl->html();
    }

}

?>