<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';
require_once PERSONAL_MODEL_PATH.'transMod.php';

use Moneyline\Common\Model\AccessLog;
use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\Model\Trans;
use Moneyline\Personal\SecureWebPageController;


class TransactionPage extends SecureWebPageController {

    protected $moduleId = 8; // NEW TRANSACTION

    protected $trans , $tIndex  ;

    const ALLOW_CHEQUES                 = 'aclAllowCheques';
    const ALLOW_TRANSFERS               = 'aclAllowInternalTransfers';
    const ALLOW_LOCAL_WIRES             = 'aclAllowLocalWires';
    const ALLOW_INTERNATIONAL_WIRES     = 'aclAllowInternationalWires';
    const ALLOW_CAMBIO                  = 'aclAllowCambio';
    const ALLOW_STANDING_ORDER          = 'aclAllowStandingOrder';
    const ONLY_ENCASH_PICKUP            = 'aclAllowOnlyEncashmentPickup';
    const USE_TRANSACTION_WIZARD        = 'useTransactionWizard';
    const MASK_ACCOUNT                  = 'maskAccountNo';
    const DEFAULT_BRANCH                = 'branch';
    const DEFAULT_TRADE_TERM            = 'defaultTradeTerm';
    const DEFAULT_ACCOUNT_NO            = 'defaultAccountNo';

    protected function _config() {
        parent::_config();
        
        $this->mnuItem = 'PICK';
        Raxan::loadLangFile("trans-module");

    }



    protected function _load(){
        parent::_load();

    }

    
    protected function _init() {
        parent::_init();

        $this->loadScript("app/trans/views/trans.view.js", true);
        $this->loadScript("app/trans/views/moneyFunc.js", true);
        $this->loadCSS("app/trans/views/trans.css", true);

        // create the transaction session array if it is not already there.
        if (!is_array(Shared::data("trans")) || (count(Shared::data("trans")) == 0) ) {
            Shared::data("trans" , array(0 => $this->txnTemplate()));
            Shared::data("transIndex" , 0);
        }

        // link the session variable to local variable.
        $this->trans = & Shared::data("trans");
        $this->tIndex =  & Shared::data("transIndex") ;
        $this->tIndex =  ($this->tIndex > -1 ) ?  $this->tIndex : count($this->trans)-1   ;

        // for index view make a new transaction
        // this function will automatically delete unsaved and other new txns
        if ($this->activeView=="index")$this->txnNew();
        
        // check if the an account index was passed in
        $externalAccountIndex =  $this->get->intVal('sourceAccIndex');
        if ($externalAccountIndex) {
            Shared::data("transAccountIndexParam" , $externalAccountIndex);
        }
        // check if we have a payee already selected
        if (Shared::data("autoPayeeSelected")) {
            // check if the parameters are setup properly and go directly  to the payee view
            //if ($this->setupAutoPayee()) $this->activeView = "payee";
            if ($this->setupAutoPayee()) $this->redirectToView('payee');
        }

        // get the state of the module. and log when it starts
        $modState =  $this->get->value('modState');
        // check if the module has just started
        if ($modState == "" ) { 
            // set the flag to indicate that the module has started
            $this->clientPostbackUrl=Raxan::config("site.url").'app/trans/trans.php?modState=active';
            // log that the module has started
            AccessLog::log(AccessLog::ACTION_MODULE_ACCESS);
        }
       

    }
    protected function  _authorize() {
        $rt = parent::_authorize();

        $isInternalUser = User::isInternalUser();
        if ($isInternalUser ==  TRUE){
            $this->activeView = "noAccess";
        }
        return $rt;
    }

    protected function _expertView(){

        // set up the view
        $this->appendView('trans.view.php',"#expertDiv");
        //$this->appendView('trans.view.php',"#txnSummaryBox");
        //$this->txnSummaryDisplay();

        $this->txn("screenMode","EXPERT" );

        // calll the functions to set up the views
        $this->_expertTypeView();
        $this->_payeeView();
        $this->_sourceView();
        $this->_scheduleView();
        $this->find(".naviSection")->remove();
        $this->find(".topSection")->remove();
        //$this->find(".transSectionHeader")->hide();
        $this->find(".topSection")->hide();
        $this->find("#chargesInfoSection")->hide();
        $this->find("#accInfoSection")->hide();
        $this->find("#amountInfoSection")->hide();
        $this->find("#backButton")->hide();
        $this->find("#wizardButton")->show();

        // dont process ajax request beyond this point 
        if($this->isAjaxRequest) return ;


        //$this->find(".transSection")->hide();
        $this->find("#typeSection")->show();

    
    }

    // use to handle user who do not have access this page
    protected function _continueOrCancelView(){
        $this->appendView('trans.view.php',"#continueOrCancel");


    }
    // use to handle user who do not have access this page
    protected function _noAccessView(){
        $this->appendView('trans.view.php',"#noAccess");

    }
    protected function _indexView(){

        // check if the user prefers to use the wizard or the expert
        if ( !User::getUserTransactionsPreferences(self::USE_TRANSACTION_WIZARD) ) {
            $this->redirectToView("expert");
        }

        // determine the cancel mode
        if (!$this->isAjaxRequest) {
            if (Shared::data("transCancel" ) == 1 )
                Shared::data("transCancel" , 2 );
            else Shared::data("transCancel" , 0 );
        }

        $this->txn("screenMode","WIZARD" );


        // set up the view used to get first entry paramters
        $this->appendView('trans.view.php',"#type");

        // check if the user can do cheques
        if ( !User::getUserTransactionsPreferences(self::ALLOW_CHEQUES) ) {
            $this->typeOptionChequeSection->attr("disabled", "disabled")->updateClient();
        }
        // check if the user can do transfers
        if ( !User::getUserTransactionsPreferences(self::ALLOW_TRANSFERS) ) {
            $this->typeOptionTransferSection->attr("disabled", "disabled")->updateClient();
        }
        // check if the user can do wire
        if ( !User::getUserTransactionsPreferences(self::ALLOW_LOCAL_WIRES) &&
                !User::getUserTransactionsPreferences(self::ALLOW_INTERNATIONAL_WIRES) ) {
            $this->typeOptionWireSection->attr("disabled", "disabled")->updateClient();
        }


        // find the element for the trans type and select it.
        $chk = $this['input[value="'.$this->txn("transTypeSelected") .'"]'];
        $chk->attr("checked", "checked")->updateClient();


    }
    protected function _expertTypeView(){

        // set up the view used to get first entry paramters
        if ($this->txn("screenMode") != "EXPERT")
            $this->appendView('trans.view.php',"#expertType");

        // default the transaction tyle
        $transType = $this->txn("transTypeSelected");
        if (empty($transType)) {
            $transType = "" ; // default set to blank
            $this->txn("transTypeSelected" , $transType);
        }

        // set the screen control
        $this->transExpertType->val($transType);

    }
    protected function  _payeeView(){

        // set up the view used for selecting payee
        if ($this->txn("screenMode") != "EXPERT") {
            // go to this start if we are not in a pending  txn
            if ($this->txn("txnStatus") != "UNSAVED") $this->redirectToView("index");

            $this->appendView('trans.view.php',"#payee");
            $this->appendView('trans.view.php',"#txnSummaryBox");
            $this->txnSummaryDisplay();
        }


        // setup the back navigation and update it based on the current view
        $backView = "index";
        $this->backButton->attr("href" , "app/trans/trans.php?modState=active&vu=" . $backView);

        // setup the screen title
        $this->payeeScreenSubtitle->html("Select payee " . $this->txn("transTypeSelected") );
        $this->payeeScreenSubtitle->attr("langid" , "txn.payee.". $this->txn("transTypeSelected") );

        if(!$this->isAjaxRequest) $this->getPayees();
    }
    protected function _sourceView(){


        // set up the view used to get first entry paramters
        if ($this->txn("screenMode") != "EXPERT") {
            // go to this start if we are not in a pending  txn
            if ($this->txn("txnStatus") != "UNSAVED") $this->redirectToView("index");

            $this->appendView('trans.view.php',"#source");
            $this->appendView('trans.view.php',"#txnSummaryBox");
            $this->txnSummaryDisplay();
        }

        $backView = "payee";
        $this->backButton->attr("href" , "app/trans/trans.php?modState=active&vu=" . $backView);


        // register the variable for the currency
        $this->registerVar('payeeDetailCurrency',$this->txn('payeeDetailCurrency'));
        $this->registerVar('transTypeSelected',$this->txn('transTypeSelected'));
        $this->registerVar('baseCurrency', Raxan::config('base-currency'));
        //$this->registerVar('allowCambio', User::getUserTransactionsPreferences(self::ALLOW_CAMBIO) );

        //c()->alert($this->txn('transTypeSelected'));
        
        // event to handle amount info
        $this->amountEntered->bind('#keydown',array(
            'callback' => '.eventAmountEntered',
            'delay' => 300,
            /* 'autoToggle' => 'img#pre',*/
            'serialize' => '.frmTrans',
            'inputCache' => true ,
            'autoDisable' => '.conversionRate'
        ));

        // stop here if it's an ajax request
        if ($this->isAjaxRequest) return ;

        // get my accounts
        $myAccountList = User::getClientAccounts();
        $this->sourceAccount->bind($myAccountList, array(
                'format' => array(
                        'AvailableBalance'=>'money'
                    )
            ));
        $this->sourceAccount->prepend('<option value="" langid="txn.source.chooseAccount">Choose Account ...</option>');
        
        // if we have the value, set it
        if ($this->txn("sourceIndexSelected")> -1) {
            $this->sourceAccount->val($this->txn("sourceIndexSelected")+1);
            // call the function to display the account information
            $this->getSourceAccountInfo($this->txn("sourceIndexSelected"));
        }
        else {
            $externalAccountIndex = Shared::data("transAccountIndexParam");
            if ($externalAccountIndex > 0) {
                if (!array_key_exists($externalAccountIndex, $myAccountList)) {
                    $this->showErrorMessage(Raxan::locale("txn.error.source.accIndexNotValid"));
                }
                else{
                    $this->sourceAccount->val($externalAccountIndex+1);
                    $this->getSourceAccountInfo($externalAccountIndex);
                }
            }
            else {
                $defaultAccountNo = User::getUserPreference(self::DEFAULT_ACCOUNT_NO);
                if ($defaultAccountNo) {
                    $defaultAccountNoIndex = $this->getArrayKey($defaultAccountNo, $myAccountList);
                    $this->sourceAccount->val($defaultAccountNoIndex+1);
                    $this->getSourceAccountInfo($defaultAccountNoIndex);
                }
                else {
                    $this->sourceAccount->val(-1);
                    $this->getSourceAccountInfo(-1);

                }
            }
        }
        
        // populate the value that was entered
        $this->amountEntered->val($this->txn("amountEntered"));

        // get the list of currencies
        $currencyList = SysInfo::getAllFxRatesAmount();
        $this->amountCurrency->bind($currencyList, array(
            'callback' => array( $this, 'filterCurrency')
            ));


        // if we have the value, set it
        if ($this->txn("amountCurrency")) {
            // set the currency  value
            $this->amountCurrency->val($this->txn("amountCurrency"));
        }
        else {
            // set the currency  value
            $this->amountCurrency->val($this->txn("sourceCurrency") );
        }

        // show the option for international cheque
        if ($this->txn("transTypeSelected") =='CHEQUE') {
            $this->internationalChequeDisplay->show();
            if ($this->txn("internationalChequeRequested")== "on"){
                $this->internationalCheque->attr("checked","checked");
            }
        }

        // populate the screen with information needed
        $this->getCurrencyRatesInfo($this->txn("amountEntered"), $this->txn("amountCurrency") , $this->txn("sourceCurrency"));


    }
    protected function _scheduleView(){


        // set up the view used to get first entry paramters
        if ($this->txn("screenMode") != "EXPERT") {
            // go to this start if we are not in a pending  txn
            if ($this->txn("txnStatus") != "UNSAVED") $this->redirectToView("index");

            $this->appendView('trans.view.php',"#schedule");
            $this->appendView('trans.view.php',"#txnSummaryBox");
            $this->txnSummaryDisplay();
        }

        $backView = "source";
        $this->backButton->attr("href" , "app/trans/trans.php?modState=active&vu=" . $backView);

        // stop here if it's an ajax request
        if ($this->isAjaxRequest) return ;

        if (!User::getUserTransactionsPreferences(self::ALLOW_STANDING_ORDER) ) {
            $this->frequencyOptionMultiple->remove();
            
        }

        // find the element for the frequency option and select it.
        if($this->txn("frequencyOption")){
            $chk = $this['input[value="'.$this->txn("frequencyOption") .'"]'];
            $chk->attr("checked", "checked")->updateClient();
        }


        // get the list of cycle periods
        $cyclePeriodList = SysInfo::getCyclePeriods();
        $this->cyclePeriod->bind($cyclePeriodList);
        $this->cyclePeriod->val($this->txn("cyclePeriodCode"));

        // get the transaction date value if any is there
        if ($this->txn("txnEffectiveDate"))
            $this->transactionDate->val($this->txn("txnEffectiveDate"));
        else $this->transactionDate->val(date("Y-m-d"));
        // get the transction start date if any 
        if ($this->txn("cyclePeriodStartDate"))
            $this->cyclePeriodStartDate->val($this->txn("cyclePeriodStartDate"));
        else $this->cyclePeriodStartDate->val(date("Y-m-d"));

        if ($this->txn("frequencyOption") == "MULTIPLE" &&  (User::getUserTransactionsPreferences(self::ALLOW_STANDING_ORDER) ) ) {

            // set the value for date and number of days if any
            $this->cyclePeriodDays->val($this->txn("cyclePeriodDays"));
            $this->cyclePeriodEndDate->val($this->txn("cyclePeriodEndDate"));
           

            // setup to view only the transaction date section
            $this->oneTimeFrequency->hide()->updateClient();
            $this->multipleFrequency->show()->updateClient();
        }
        else {
            // get the transaction date value if any is there
            if ($this->txn("txnEffectiveDate")) 
                $this->transactionDate->val($this->txn("txnEffectiveDate"));
            else $this->transactionDate->val(date("Y-m-d"));
            
            

            // setup to view only the transaction date section
            $this->oneTimeFrequency->show()->updateClient();
            $this->multipleFrequency->hide()->updateClient();


        }

        // display the charges
        $this->getChargesInfo();

    }
    protected function _reviewView(){

        // set up the view used to get first entry paramters
        $this->appendView('trans.view.php',"#review");

        // bind the transaction list
        if (!$this->isAjaxRequest) {

            // get the pending transaction list
            $txnList = $this->txnAll("PENDING");
            // if there is none available go to the overview page
            if (count ($txnList)== 0 ) $this->redirectTo(Raxan::config("site.url").'app/trans');

            // show the pending transction
            $this->txnReviewList->bind($txnList, array(
                'callBack' => array( $this, 'filterTxnReview') ,
                'format' => array(
                        'txnMoreDetails'=>'html',
                        'amountEntered'=>'money'
                    )
            ));

            // if we only have one transaction show the details automatically
            if (count ($txnList)== 1 ) $this->txnDetails1->removeClass("hide");

        }
    

        //c()->alert(print_r($this->txnSelect(0) , true));
    }
    protected function _resultsView(){

        // set up the view used to get first entry paramters
        $this->appendView('trans.view.php',"#results");



        if (!$this->isAjaxRequest) {
            //
            $txnList = $this->txnAll();
            $this->txnReviewList->bind($txnList, array(
                'format' => array(
                        'txnMoreDetails'=>'html',
                        'txnProcessMessage'=>'html',
                        'amountEntered'=>'money'
                    )
            ));
            
            // delete the successfull transactions
            for ($index = 0; $index < count($txnList); $index++) {
                if (is_numeric($txnList[$index]['txnProcessRequestId'])) $this->txnDelete ($index);

            }

        }


    }

    public function filterCurrency(&$row){
        if ($row[0] == $this->txn("sourceCurrency") || $row[0] == $this->txn("payeeDetailCurrency") ||$this->txn("transTypeSelected") == "CHEQUE"  ) {
        }
        else return false;
    }
    public function filterTxnReview(&$row){
        if ($row["txnStatus"] != "PENDING") {
           return false ; //'<td colspan="9" langid="txn.review.transIncomplete" >Transaction Incomeplete</td>'; // return rendered row
        }
    }



    // process the transaction type selection
    protected function processType($e){

        // pick up the values entered and store them
        $transType = $this->post->textVal("transType") ;

        // get the transaction type codes available
        $transTypeCodeCheck = $this->getTransTypeCodesAvailable($transType);
        // ensure that a tranction type code was determined from the selected type
        if ( $transTypeCodeCheck['transTypeCodesAvailable'] == "") {
            $this->showErrorMessage($transTypeCodeCheck['error']);
            return 0;
        }
        else{
            $transTypeCodesAvailable = $transTypeCodeCheck['transTypeCodesAvailable'];
        }

        // store the values
        $this->txn("transTypeSelected", $transType );
        $this->txn("transTypeCodesAvailable", $transTypeCodesAvailable );
        $this->txn("payeeList" , "" ) ;
        $this->txn("txnStatus" , "UNSAVED") ;

        if ($this->txn("screenMode") == "EXPERT" ) {
            // get the payees for this type
            if(!$this->getPayees()) return 0;
            // show the option for international cheque
            if ($this->txn("transTypeSelected") =='CHEQUE') {
                $this->internationalChequeDisplay->show()->updateclient();
            }
        }
        else {
            // switch the view to select the payee for encashments
            $this->redirectToView("payee");
        }


        return 1;
    }

    // process the payee selection
    protected function processPayee($e){

        // pick up the values from client 
        $payeeIndexSelected             = $this->post->textVal("payeeList");
        $personalNote                   = $this->post->textVal("personalNote") ;
        // cheque specific values
        $branchCode                     = $this->post->textVal("branch") ;
        $deliveryMethod                 = $this->post->textVal("deliveryMethod") ;
        $addressIndexSelected           = $this->post->textVal("addressList");
        $addressLine1                   = $this->post->textVal("addressLine1") ;
        $addressLine2                   = $this->post->textVal("addressLine2") ;
        $addressLine3                   = $this->post->textVal("addressLine3") ;
        $addressCountryCode             = $this->post->textVal("addressCountryCode") ;
        $specialInstruction             = $this->post->textVal("specialInstruction") ;
        // transfer specific value 
        $transferAccountIndexSelected   = ($this->post->intVal("transferAccountList") | 0) - 1 ;
        $transferAccountTradeIndex   = $this->post->textVal("transferAccountTradeList")  ;
        $transferAccountTradeTradeTerms      = $this->post->textVal("transferAccountTradeTradeTerms")  ;
        // wire specific value
        $wireAccountIndexSelected       = ($this->post->intVal("wireAccountList") | 0) - 1 ;
        
        // retrieve the last payee list and details.
        $preDefinedPayeeList            = $this->txn("payeeList") ;
        $preDefinedPayeeDetailList     = $this->txn("payeeDetailList") ;

        // ensure we have a payee selected
        if ($payeeIndexSelected == "MYJMMB" ) {
            if ($this->txn("transTypeSelected")!="TRANSFER") {
                $this->showErrorMessage(Raxan::locale("txn.error.payeeOnlyForTransfer"));
                return 0;
            }
        }
        else {
            $payeeIndexSelected = ($this->post->intVal("payeeList") | 0) - 1;
            if ($payeeIndexSelected < 0 ) {
                $this->showErrorMessage(Raxan::locale("txn.error.selectPayee"));
                return 0;
            }
        }

        // actions for cheque processing 
        if ($this->txn("transTypeSelected")=="CHEQUE") {
            // check for delivery method only if it's not a company
            if ($preDefinedPayeeList[$payeeIndexSelected]["payeeType"] != "C") {
                // delivery method check
                if (empty($deliveryMethod)) {
                    $this->showErrorMessage(Raxan::locale("txn.error.selectDeleveryMethod"));
                    return 0;
                }
                // validate based on the deliever method
                if (strtoupper(trim($deliveryMethod )) == "PICKUP") {
                    // ensure that we have branch
                    if ($branchCode == "") {
                        $this->showErrorMessage(Raxan::locale("txn.error.selectBranch"));
                        return 0;
                    }
                }
                else {
                    // ensure that we a delievery address entered
                    if ($addressIndexSelected != "CUSTOM" ) {
                        $addressIndexSelected = ($this->post->intVal("addressList") | 0) - 1;
                        if (($addressIndexSelected < 0 )|| (!$addressLine1 &&!$addressLine3 && !$addressLine3 && !$addressCountryCode )) {
                            $this->showErrorMessage(Raxan::locale("txn.error.selectAddress"));
                            return 0;
                        }
                    }
                }
            }

            // store the value specific to cheque
            $this->txn("payeeIndexSelected", $payeeIndexSelected) ;
            $this->txn("payeeId", $preDefinedPayeeList[$payeeIndexSelected ]['id']) ;
            $this->txn("payeeName", $preDefinedPayeeList[$payeeIndexSelected ]['payeeName']);
            $this->txn("payeeDescription", $preDefinedPayeeList[$payeeIndexSelected ]['payeeDescription']);
            $this->txn("payeeType", $preDefinedPayeeList[$payeeIndexSelected ]['payeeType']);
            $this->txn("deliveryMethod", $deliveryMethod);
            $this->txn("branchCode", $branchCode);
            $this->txn("addressIndexSelected", $addressIndexSelected);
            $this->txn("addressLine1", $addressLine1);
            $this->txn("addressLine2", $addressLine2);
            $this->txn("addressLine3", $addressLine3);
            $this->txn("addressCountryCode", $addressCountryCode);
            $this->txn("specialInstruction", $specialInstruction);
            // set the transaction type code based the type avaiable
            $transTypeCodesAvailable = $this->txn("transTypeCodesAvailable");
            $this->txn("transTypeCode" , $transTypeCodesAvailable);

        }

        if ($this->txn("transTypeSelected")=="TRANSFER") {

            if ($transferAccountIndexSelected < 0) {
                $this->showErrorMessage(Raxan::locale("txn.error.selectTransferAccount"));
                return 0;
            }

            // store the transactions variables
            if (is_numeric($payeeIndexSelected)) {

                //c()->alert(print_r( $preDefinedPayeeDetailList[$transferAccountIndexSelected], true));
                //return;
                
                $this->txn("payeeId", $preDefinedPayeeList[$payeeIndexSelected ]['id']);
                $this->txn("payeeName", $preDefinedPayeeList[$payeeIndexSelected ]['name']);
                $this->txn("payeeDescription", $preDefinedPayeeList[$payeeIndexSelected ]['description']);
                $this->txn("transferAccountReference", $preDefinedPayeeDetailList[$transferAccountIndexSelected ]['accRefValue']);
                $this->txn("payeeDetailCurrency", $preDefinedPayeeDetailList[$transferAccountIndexSelected ]['accRefCurrency']);

            }
            // these parameter are different for the JMMB Accounts
            else if ($payeeIndexSelected == "MYJMMB" ) {

                $this->txn("payeeId", ""); // set the JMMB payeed it to null
                $this->txn("payeeName", Raxan::locale('txn.payee.myAccounts'));
                $this->txn("payeeDescription", "" );
                $this->txn("transferAccountReference", $preDefinedPayeeDetailList[$transferAccountIndexSelected ]['jmmbAccountNo']);
                $this->txn("payeeDetailCurrency", $preDefinedPayeeDetailList[$transferAccountIndexSelected ]['jmmbAccountCurrency']);

                // if we have a investor account ensure tha a trade was selected
                if (strtoupper($preDefinedPayeeDetailList[$transferAccountIndexSelected ]['jmmbProductType']) == "INVESTOR") {
                    // ensure we have a payee selected
                    if ($transferAccountTradeIndex == "NEW" ) {
                        // set the value for the Investment
                        $maturityIndex = "NEW" ;
                        $maturityDate = date("c");
                        $maturityTradeNo = "NEW";
                    }
                    else {
                        $transferAccountTradeIndex = ($this->post->intVal("transferAccountTradeList") | 0) - 1;
                        if (($transferAccountTradeIndex < 0)) {
                            $this->showErrorMessage(Raxan::locale("txn.error.selectInvestOption"));
                            return 0;
                        }
                        // set the value for the investment
                        $maturityIndex = $transferAccountTradeIndex ;
                        $maturityDate = $preDefinedPayeeDetailList[$transferAccountIndexSelected]["jmmbAssetList"][$transferAccountTradeIndex]->maturityDate;
                        $maturityTradeNo = $preDefinedPayeeDetailList[$transferAccountIndexSelected]["jmmbAssetList"][$transferAccountTradeIndex]->tradeNo;
                    }
                    // validate the trade term
                    if (($transferAccountTradeTradeTerms == "")) {
                        $this->showErrorMessage(Raxan::locale("txn.error.selectInvestTerm"));
                        return 0;
                    }
                    
                    
                    // write them to the session
                    $this->txn("transferAccountTradeIndex", $maturityIndex);
                    $this->txn("transferAccountTradeDate", $maturityDate);
                    $this->txn("transferAccountTradeTradeNo", $maturityTradeNo);
                    $this->txn("transferAccountTradeTradeTerms", $transferAccountTradeTradeTerms);
                }
            }
            // store the general values regardless of My JMMB account or not.
            $this->txn("payeeIndexSelected", $payeeIndexSelected ) ;
            $this->txn("transferAccountIndexSelected", $transferAccountIndexSelected);
            $this->txn("payeeDetailId", $preDefinedPayeeDetailList[$transferAccountIndexSelected ]['id']);
            $this->txn("transferAccountName", $preDefinedPayeeDetailList[$transferAccountIndexSelected ]['alias']);
            // set the transaction type code based the type avaiable
            $transTypeCodesAvailable = $this->txn("transTypeCodesAvailable");
            $this->txn("transTypeCode" , $transTypeCodesAvailable);

        }

        if ($this->txn("transTypeSelected")=="WIRE") {
            
            if ($wireAccountIndexSelected < 0 ) {
                $this->showErrorMessage(Raxan::locale("txn.error.selectWireAccount"));
                return 0;
            }

            // store the transactions variables
            $this->txn("payeeIndexSelected", $payeeIndexSelected ) ;
            $this->txn("payeeId", $preDefinedPayeeList[$payeeIndexSelected ]['id']);
            $this->txn("payeeName", $preDefinedPayeeList[$payeeIndexSelected ]['name']);
            $this->txn("payeeDescription", $preDefinedPayeeList[$payeeIndexSelected ]['description']);

            $this->txn("wireAccountIndexSelected", $wireAccountIndexSelected);
            $this->txn("payeeDetailId", $preDefinedPayeeDetailList[$wireAccountIndexSelected ]['id']);
            $this->txn("payeeDetailCurrency", $preDefinedPayeeDetailList[$wireAccountIndexSelected ]['accRefCurrency']);
            $this->txn("wireAccountReference", $preDefinedPayeeDetailList[$wireAccountIndexSelected ]['accRefValue']);
            $this->txn("wireAccountName", $preDefinedPayeeDetailList[$wireAccountIndexSelected ]['alias']);
            $this->txn("wireAccountBenBankName", $preDefinedPayeeDetailList[$wireAccountIndexSelected ]['benBankName']);

            // set the transaction type code for wire based on the payee selected
            $this->txn("transTypeCode" ,$preDefinedPayeeDetailList[$wireAccountIndexSelected ]['tranTypeCode'] );


        }


        // store the personal note
        $this->txn("personalNote" , $personalNote);

        //c()->alert(print_r( $preDefinedPayeeDetailList[$wireAccountIndexSelected ], true));
        //return 0;

        // determine final action
        if ($this->txn("screenMode") == "EXPERT" ) {
        }
        else {
            // switch the view
            $this->redirectToView("source");
        }

        return 1;
    }

    // process the source account selection
    protected function processSource($e){

        // pick up the account and maturity index
        $accountIndex           = ($this->post->intVal("sourceAccount") | 0) - 1 ;
        $assetIndex             = ($this->post->intVal("sourceMaturity") | 0) - 1 ;
        $amountEntered          = $this->post->value("amountEntered");
        $amountCurrency         = $this->post->value("amountCurrency") ;
        $internationalCheque    = $this->post->value("internationalCheque");
        $universalId             = User::getUniversalId();

        // ensure that we have a source account selected
        if ($accountIndex < 0) {
            $this->showErrorMessage(Raxan::locale("txn.error.selectSourceAccount"));
            return 0;
        }
        // ensure that we have a currency  selected
        if (!$amountCurrency) {
            $this->showErrorMessage(Raxan::locale("txn.error.selectCurrency"));
            return 0;
        }
        // enaure that an amount has bee entered
        if (!$amountEntered) {
            $this->showErrorMessage(Raxan::locale("txn.error.enterAmount"));
            return 0;
        }
        // enaure that an amount has bee entered
        if (!is_numeric($amountEntered)) {
            $this->showErrorMessage(Raxan::locale("txn.error.invalidAmount"));
            return 0;
        }

        // pick up the client accounts
        $clientAccounts = User::getClientAccounts();
        //ensure that the index is within range
        $clientAccountsCount  = count($clientAccounts ) ;
        if ($accountIndex > ($clientAccountsCount-1) ) {
            $this->showErrorMessage("Invalid account index");
            return 0;
        }

        // get the client account information
        $sourceAccount              = $clientAccounts[$accountIndex]['AccountNo'];
        $sourceAccountNoValue       = $clientAccounts[$accountIndex]['AccountNoValue'];
        $sourceAccountName          = $clientAccounts[$accountIndex]['AccountName'];
        $sourceCurrency             = $clientAccounts[$accountIndex]['Currency'] ;
        $sourceAvailableBalance     = $clientAccounts[$accountIndex]['AvailableBalance']  ;
        $productType                = strtoupper(trim($clientAccounts[$accountIndex]['ProductType']));

        // if we have a cross currency transaction, ensur ethat the user has permission.
        if ($this->txn("transTypeSelected") == "CHEQUE")
            $payeeCurrency = $amountCurrency;
        else $payeeCurrency = $this->txn("payeeDetailCurrency");
        if ($payeeCurrency  !=  $sourceCurrency && (!User::getUserTransactionsPreferences(self::ALLOW_CAMBIO))) {
            $this->showErrorMessage(Raxan::locale("txn.error.noCambio"));
            return 0;
        }

        // if the account is an INVESTOR account we shoul dcheck the asset list
        if ($productType == "INVESTOR" ) {
            $assetList = $clientAccounts[$accountIndex]['AssetList'];
            $assetListCount = count($assetList);
            if ($assetListCount <= 0 ) {
                $this->showErrorMessage(Raxan::locale("txn.error.invalidAmount"));
                return 0;
            }
            // ensure that we have an asset selected 
            if ($assetIndex < 0) {
                $this->showErrorMessage(Raxan::locale("txn.error.selectMaturity"));
                return 0;
            }

            // ensure that the asset index select is within range 
            if ($assetIndex > ($assetListCount-1) ) {
                $this->showErrorMessage(Raxan::locale("txn.error.invalidAssetIndex"));
                return 0;
            }

            // get the maturity date
            $maturityDate = $clientAccounts[$accountIndex]['AssetList'][$assetIndex]->maturityDate;
            $maturityTradeNo = $clientAccounts[$accountIndex]['AssetList'][$assetIndex]->tradeNo;
            // ensure that the asset index select is within range
            if (!$maturityDate ) {
                $this->showErrorMessage(Raxan::locale("txn.error.invalidMaturityDate"));
                return 0;
            }

            // set the balance based on the asset selected
            $sourceAvailableBalance  = $clientAccounts[$accountIndex]['AssetList'][$assetIndex]->maturityValue;


        }
        // ensure that source and destination accounts are not the same
//        if ($sourceAccount == $this->txn("payeeSubAccount")) {
//            $this->showErrorMessage("Source and destination accounts cannot be the same.");
//            return 0;
//        }
        // ensure that source account has mooney
        if ($sourceAvailableBalance <= 0) {
            $this->showErrorMessage(Raxan::locale("txn.error.noBalance"));
            return 0;
        }


        // update the currency values
        $conversionRateValue    = 1;
        $conversionRateType     = "";
        $conversionRateDate     = "";
        if (($sourceCurrency  != $amountCurrency) ) {
            // calculate the new amount based on the parameters
            $conversionRate     = Trans::getCurrencyConversionRate($universalId, $amountCurrency, $sourceCurrency);
            $sourceCurrencyImgLink  = "<img src='views/images/flags/jmmbCurrencies/" . $sourceCurrency . ".png' > " ;

            if ( is_object($conversionRate)){
                // currency and rate information
                // we are moving from the amount entered to the amount required from the source account
                $conversionRateValue    = $conversionRate->rate ;
                $conversionRateType     = $conversionRate->rateType;
                $conversionRateDate     = $conversionRate->effectiveDate;
            }
        }
        // calculate the new amount based on the rate type
        if (strtoupper($conversionRateType) == "SELL")
            $convertedAmount = $amountEntered / $conversionRateValue  ;
        else $convertedAmount = $amountEntered * $conversionRateValue  ;



        // get the charges
//        $chargesTax = 0.0;
//        $chargesAmount = 0.0;
//        $totalCharges = 0.0;
//        $charges    = Trans::getChargeAmount($universalId, $sourceAccount, $this->txn("transTypeCode"), $amountEntered, $amountCurrency);
//        if ( is_object($charges)){
//            $chargesTax = $charges->tax;
//            $chargesAmount = $charges->amount;
//            $totalCharges = $charges->tax + $charges->amount;
//        }

        // ensure that when amount currency is converted to the source currency
        // and the charges are added to it, then the balance should cover it
//        $sourceCurrencyTxnAmount = $convertedAmount + $totalCharges ;
        $sourceCurrencyTxnAmount = $convertedAmount ;

        // check if there is enough fund in the sourcer account
        if ($sourceAvailableBalance <= $sourceCurrencyTxnAmount ){
            $this->showErrorMessage(Raxan::locale("txn.error.lowBalance"));
            return 0;
        }


        // @todo: get procedure used to get the charges

        // store the values in session
        $this->txn("sourceIndexSelected", $accountIndex );
        $this->txn("sourceAccount", $sourceAccount );
        $this->txn("sourceAccountNoValue", $sourceAccountNoValue );
        $this->txn("sourceAccountName", $sourceAccountName );
        $this->txn("sourceAccountType", $productType );
        $this->txn("sourceCurrency", $sourceCurrency );
        $this->txn("sourceAvailableBalance" , $sourceAvailableBalance ) ;
        $this->txn("sourceCurrencyTxnAmount" , $sourceCurrencyTxnAmount );
        // get the account maturities
        if ($productType == "INVESTOR" ) {
            $this->txn("sourceMaturityIndex" , $assetIndex);
            $this->txn("sourceMaturityDate" , $maturityDate);
            $this->txn("sourceMaturityTradeNo" , $maturityTradeNo);
        }
        // store the values for the amount and currency
        $this->txn("amountEntered" , $amountEntered );
        $this->txn("amountCurrency" , $amountCurrency );
        $this->txn("conversionRateValue" , $conversionRateValue );
        $this->txn("conversionRateType" , $conversionRateType );
        $this->txn("conversionRateDate" , $conversionRateDate );

        // store the international cheque option
        if ($internationalCheque)$this->txn("internationalChequeRequested" , $internationalCheque );
        else $this->txn("internationalChequeRequested" , "off" );

        // @todo: store the values for the charges and tax

        if ($this->txn("screenMode") == "EXPERT" ) {
        }
        else {
            // switch the view
            $this->redirectToView("schedule");
        }

        return 1;
    }

    // process the source account selection
    protected function processSchedule($e){

        // get the values
        $transFrequencyOption   = $this->post->textVal("transFrequencyOption");
        $transactionDate        = $this->post->textVal("transactionDate");
        $cyclePeriodCode        = $this->post->textVal("cyclePeriod") ;
        $cyclePeriodDays        = $this->post->intVal("cyclePeriodDays") ;
        $cyclePeriodStartDate   = $this->post->textVal("cyclePeriodStartDate") ;
        $cyclePeriodEndDate     = $this->post->textVal("cyclePeriodEndDate") ;
        $businessDayOption     = $this->post->textVal("businessDayOption") ;


        if ($transFrequencyOption == "MULTIPLE") {

            // get the cycle period list to store the period description using the index.
            $cyclePeriodList = SysInfo::getCyclePeriods();
            $cyclePeriodIndex  = $this->getArrayKey($cyclePeriodCode, $cyclePeriodList);

            // validate entry
            if (!$cyclePeriodCode) {
                $this->showErrorMessage(Raxan::locale("txn.error.selectCyclePeriod"));
                return 0;
            }
            if (!$cyclePeriodStartDate) {
                $this->showErrorMessage(Raxan::locale("txn.error.selectCycleStart"));
                return 0;
            }
//            if (!$cyclePeriodEndDate) {
//                $this->showErrorMessage(Raxan::locale("txn.error.selectCycleEnd"));
//                return 0;
//            }
            if (!$businessDayOption) {
                $this->showErrorMessage(Raxan::locale("txn.error.selectBusinessDayOption"));
                return 0;
            }

            // store the values for the sycle period
            $this->txn("cyclePeriodCode" , $cyclePeriodCode);
            $this->txn("cyclePeriodDesc" , $cyclePeriodList[$cyclePeriodIndex]["cyclePeriodDesc"]);
            $this->txn("cyclePeriodDays" , $cyclePeriodDays);
            $this->txn("cyclePeriodStartDate" , $cyclePeriodStartDate);
            $this->txn("cyclePeriodEndDate" , $cyclePeriodEndDate);
            $this->txn("cycleBusinessDayOption" , $businessDayOption);

        }
        else {
            //if ($transFrequencyOption == "ONCE") {

            // enaure that we have a transaction date
            if (!$transactionDate) {
                $this->showErrorMessage(Raxan::locale("txn.error.selectTransactionDate")) ;
                return 0;
            }

            // store the transaction date
            $this->txn("txnEffectiveDate" , $transactionDate);

        }

        //store the frequency option 
        $this->txn("frequencyOption" , $transFrequencyOption );

        return 1;
    }


    // process the source account selection
    protected function processTrans($e){

        // get the posted values 
        $userPin   = $this->post->intVal("userPin");
        $userName  = User::getLoginName() ;
        
        
        if (!$userPin ) {
            $this->showErrorMessage(Raxan::locale("txn.error.processTrans.enterPin"));
            return 0;
        }


        //
        $userPinResults = User:: validatePin_2($userName  , $userPin);
        if (!is_object($userPinResults) ) {
            $this->showErrorMessage(Raxan::locale("txn.error.userNotFound"));
            return 0;
        }

        $userPinStatus = $userPinResults->result->loginStatus ;

        if ($userPinStatus != "OK" ) {

            if ($userPinStatus == User::LOGIN_STATUS_INVALIDLOGIN) {
                $this->showErrorMessage(Raxan::locale("txn.error.processTrans.invalidPin"));
                return 0;
            }
            if ($userPinStatus == User::LOGIN_STAUS_ACCOUNTLOCK) {
                $this->showErrorMessage(Raxan::locale("txn.error.processTrans.accLock"));
                return 0;
            }
            if ($userPinStatus == User::LOGIN_STATUS_LOCKED) {
                $this->showErrorMessage(Raxan::locale("txn.error.processTrans.accLock"));
                return 0;
            }
            // account invalid for undetermined reason.
            $this->showErrorMessage(Raxan::locale("txn.error.processTrans.notOk"));
            return 0;
        }

        // load the language file to handle the error
        Raxan::loadLangFile('errors');

        // do the velocity validations
        $txnVelocityResults = Trans::validateTransactionVelocity($this->txnAll("PENDING"));

        // initialize failure flag
        $txnVelocityFailed = false ;
        // update the trasnactions with the results of the velocity check 
        if (is_array($txnVelocityResults )) {

            // remove all previous erro classes
            c('.reviewTblData' )->removeClass('txnErrorDisplayClass');

            // loop through and update with error classes
            for ($index = 0; $index < count($txnVelocityResults); $index++) {

                if ($txnVelocityResults[$index]->error != "") {
                    // update the velocity failed flag
                    $txnVelocityFailed = true ;
                    c('#txnReviewSummary' . ($index+1) )->addClass('txnErrorDisplayClass');
                }
            }
        }
        // handle any failure
        if ($txnVelocityFailed) {
            $this->showErrorMessage(Raxan::locale("txn.error.processTrans.velocityFailed"));
            return 0 ;
        }
        // log that we are about to send the transaction batch
        //AccessLog::log(AccessLog::ACTION_TRANSACTION_BATCH_SENT);

        // execute function to process transaction
        $txnResults = Trans::processClientTransactions($this->txnAll("PENDING"));

        // update the trasnactions with the results of the processing 
        if (is_array($txnResults )) {
            for ($index = 0; $index < count($txnResults); $index++) {

                if ($txnResults[$index]->error !="") {
                    Raxan::loadLangFile('errors');
                    $this->txnSelect($index, "txnProcessError", $txnResults[$index]->error);
                    $this->txnSelect($index, "txnProcessMessage", Raxan::locale($txnResults[$index]->error));
                    $this->txnSelect($index, "txnErrorDisplayClass", "txnErrorDisplayClass");
                }
                else {
                    $this->txnSelect($index, "txnStatus", 'LOGGED');
                    if (is_object($txnResults->result )){
                        $this->txnSelect($index, "txnProcessRequestId", $txnResults[$index]->result->transactionRequestID);
                        $this->txnSelect($index, "txnProcessMessage", $txnResults[$index]->result->messages);
                    }
                }

            }
        }

        // switch the view
        $this->redirectToView("results");


    }



    // function used to validate the payee parameters set up by an external module
    protected  function setupAutoPayee(){

        // ensure we have the a payee selected
        if (!Shared::data("txnPayeeIndex")) return 0;
        if (!Shared::data("txnType")) return 0;
        //if (!Shared::data("txnPayeeDetailIndex")) return 0;

        // reset the parameter
        Shared::data("autoPayeeSelected" , false);


        // setup the parameters needed for each transaction type
        switch (Shared::data("txnType")) {
            case 'CHEQUE':
                $this->txn("transTypeSelected" , "CHEQUE" );
                $this->txn("transTypeCodesAvailable" , "ENC" );
                $this->txn("payeeIndexSelected" , Shared::data("txnPayeeIndex") );
                break;

            case 'TRANSFER':
                $this->txn("transTypeSelected" , "CHEQUE" );
                $this->txn("transTypeCodesAvailable" , "INT" );
                $this->txn("payeeIndexSelected" , Shared::data("txnPayeeIndex") );
                $this->txn("transferAccountIndexSelected" , Shared::data("txnPayeeDetailIndex") );
                break;

            case 'WIRE':

                // get the transaction type codes available
                $transTypeCodeCheck = $this->getTransTypeCodesAvailable("WIRE");
                // ensure that a tranction type code was determined from the selected type
                if ( $transTypeCodeCheck['transTypeCodesAvailable'] == "") {
                    return 0;
                }
                else{
                    $transTypeCodesAvailable = $transTypeCodeCheck['transTypeCodesAvailable'];
                }
                $this->txn("transTypeSelected" , "CHEQUE" );
                $this->txn("transTypeCodesAvailable" , $transTypeCodesAvailable );
                $this->txn("payeeIndexSelected" , Shared::data("txnPayeeIndex") );
                $this->txn("wireAccountIndexSelected" , Shared::data("txnPayeeDetailIndex") );
                break;

        }

        // if no transTypeSelected was determined return false
        if (!$this->txn("transTypeSelected")) {
            return 0;
        }

        // update status of the transaction to indicate that it has started
        $this->txn("txnStatus", "UNSAVED");
        
        // if we pass through all the checks then we are ok.
        return 1;

    }

    // process the source account selection
    protected function eventPayeeSelect($e){

        // pick up the post values
        $payeeIndexSelected =$this->post->textVal("payeeList");
        $deliverySelected = $this->post->textVal("deliveryMethod")  ;

        // ensure we have a payee selected
        if ($payeeIndexSelected == "MYJMMB" ) {
            // get ooptions for my JMMB accounts
            $this->getPayeeOptions($payeeIndexSelected , null , $deliverySelected);
        }
        else {
            // reduce the post value to get the propper index
            $payeeIndexSelected = ($this->post->intVal("payeeList") | 0) - 1 ;
            // pick up the payee id from the list using the index
            $payeeList = $this->txn("payeeList");

            $payeeId = $payeeList[$payeeIndexSelected]["id"] ;
            if ($this->txn("transTypeSelected")=="CHEQUE")  {
                $payeeType = $payeeList[$payeeIndexSelected]["payeeType"] ; }
            else {
                $payeeType = null; }

            // get options for the payee selected
            $this->getPayeeOptions($payeeId, $payeeType , $deliverySelected);
        }

        return 1;
    }

    // process the source account selection
    protected function eventDeleveryMethod($e){

        // pick up the post values
        $payeeIndexSelected =$this->post->textVal("payeeList");
        $deliverySelected = $this->post->textVal("deliveryMethod")  ;
        // ensure we have a payee selected
        if ($payeeIndexSelected == "" ) {
            $this->showErrorMessage("Please select a payee.");
            return 0;
        }

        if ($payeeIndexSelected == "MYJMMB") {
            // get ooptions for my JMMB accounts
            $this->getPayeeOptions($payeeIndexSelected , null , $deliverySelected);
        }
        else {

            // reduce the post value to get the propper index
            $payeeIndexSelected = ($this->post->intVal("payeeList") | 0) - 1 ;

            // pick up the payee id from the list using the index
            $payeeList = $this->txn("payeeList");


            $payeeId = $payeeList[$payeeIndexSelected]["id"] ;
            if ($this->txn("transTypeSelected")=="CHEQUE")  {
                $payeeType = $payeeList[$payeeIndexSelected]["payeeType"] ; }
            else {
                $payeeType = null; }

            // get options for the payee selected
            $this->getPayeeOptions($payeeId, $payeeType , $deliverySelected);

        }
        return 1;
    }


    // process the source account selection
    protected function eventTransferAccountList($e){

        // pick up the post values
        $transferAccountSelectedIndex = ($this->post->intVal("transferAccountList")|0) -1 ;

        // execute the function to get and show the account information
        $this->getTransferAccountOptions($transferAccountSelectedIndex);

        return 1;
    }


    // process the source account selection
    protected function eventSourceAccount($e){

        // get the values
        $sourceAccount          = $this->post->textVal("sourceAccount") ;
        $amountEntered          = $this->post->floatVal("amountEntered") ;
        $sourceAccountCurrency  = $this->post->textVal("sourceAccountCurrency") ;
        $amountCurrency         = $this->post->textVal("amountCurrency") ;
        $accountIndex           = ($this->post->intVal("sourceAccount") | 0) - 1 ;

        // execute the function to get and show the account information
        $this->getSourceAccountInfo($accountIndex);
        // display the charges
        if($amountEntered != 0) $this->getChargesInfo($sourceAccount, $amountEntered, $amountCurrency);
        // display the exchange rates and new amounts
        if($amountEntered != 0) $this->getCurrencyRatesInfo($amountEntered, $amountCurrency, $sourceAccountCurrency);

        // update the summary
        //$this->txnSummaryDisplay();
        return 1;
    }

    // process the source maturity selection
    protected function eventSourceMaturity($e){

        // pick up the account and maturity index
        $accountIndex = ($this->post->intVal("sourceAccount") | 0) - 1 ;
        $assetIndex = ($this->post->intVal("sourceMaturity") | 0) - 1 ;

        // execute the function to get and show the account information
        $this->getSourceMaturityInfo( $accountIndex , $assetIndex);

        return 1;
    }

    protected function eventAmountCurrency($e){

        // get the values
        $sourceAccount          = $this->post->textVal("sourceAccount") ;
        $sourceAccountCurrency  = $this->post->textVal("sourceAccountCurrency") ;
        $amountEntered          = $this->post->floatVal("amountEntered") ;
        $amountCurrency         = $this->post->textVal("amountCurrency") ;

        // display the exchange rates and new amounts
        if($amountEntered != 0) $this->getCurrencyRatesInfo($amountEntered, $amountCurrency, $sourceAccountCurrency);

    }



    protected function eventAmountEntered($e){

        // get the values
        $sourceAccount          = $this->post->textVal("sourceAccount") ;
        $sourceAccountCurrency  = $this->post->textVal("sourceAccountCurrency") ;
        $amountEntered          = $this->post->floatVal("amountEntered") ;
        $amountCurrency         = $this->post->textVal("amountCurrency") ;

        // display the exchange rates and new amounts
        $this->getCurrencyRatesInfo($amountEntered, $amountCurrency, $sourceAccountCurrency);
    }
    // handles the delete event from the client
    protected function eventEditTxn($e){

        $txnId = ($e->intval()| 0) - 1 ;

        //c()->alert($txnId);

        //return ;
        Shared::data("transIndex" , $txnId );

        Shared::data("transCancel" , "review" );
        // switch the view
        $this->redirectToView("expert");

        return 1;

    }

    // handles the delete event from the client
    protected function eventDeleteTxn($e){

        $txnId = ($e->intval()| 0) - 1 ;

        // execue the function to delete the transaction
        $this->txnDelete($txnId);

        $txnList = $this->txnAll();
        $this->txnReviewList->bind($txnList);

        // update the list
        $this->txnReviewList->updateClient();

        // if no items are in the list, setup up the new record and start over
        if (count($this->trans) == 0) {
            $this->redirectTo("index.php");
        }

        return 1;
    }
    protected function eventCancel(){


        // if the status on the txn is NEW delete it
        if ($this->txn("txnStatus") == "NEW") {
            // Delete the curret transaction
            $this->txnDelete($this->tIndex);
            Shared::data("transIndex" , "");
        }

        // if the status on the txn is UNSAVED delete it as well
        if ($this->txn("txnStatus") == "UNSAVED") {
            // Delete the curret transaction
            $this->txnDelete($this->tIndex);
            Shared::data("transIndex" , "");
        }

        // get the value of the cancel view target
        $cancel = Shared::data("transCancel");
        if ($cancel == 2 ) {
            // reset the cancel view
            Shared::data("transCancel" , 0 );
            // go to the cancel view
            $this->redirectToView("review");
        }
        else {
            // go to the cancel view
            $this->redirectTo("index.php");

        }



        // go to the start of the page
        $this->redirectToView("index");


    }

    protected function eventFequency($e){

        // update the frequency option in the txn 
        $transFrequencyOption   = $this->post->textVal("transFrequencyOption");
        $this->txn("frequencyOption" , $transFrequencyOption );

        //c()->alert(print_r($this->txn("frequencyOption"), true));

        $this->getChargesInfo();
        
    }

    // make the transaction as ready and move to the next one
    protected function eventAddNew($e){

        // save the transaction
        //if(!$this->txnNew($e)) return 0;

        // set flag to ensure cancel takes us back here
        Shared::data("transCancel" , 1);

        // switch the view
        $this->redirectToView("index");

        return 1;
    }

    protected function editFailedTrans(){
        // switch the view
        $this->redirectToView("review");

    }

    protected function getTransTypeCodesAvailable($transType){

        $transTypeCodesAvailable = "";
        $error = "ok";

        if ($transType == "WIRE") {

            if ( User::getUserTransactionsPreferences(self::ALLOW_INTERNATIONAL_WIRES)) {
                $transTypeCodesAvailable = "IWR";
            }
            if ( User::getUserTransactionsPreferences(self::ALLOW_LOCAL_WIRES) ) {
                if($transTypeCodesAvailable) {
                    $transTypeCodesAvailable .= ",LWR" ;}
                else {
                    $transTypeCodesAvailable = "LWR" ;
                }
            }
            if (empty($transTypeCodesAvailable)) {
                $error = Raxan::locale("txn.error.wireNotLocalOrInternational");
            }
        }
        else if ($transType == "CHEQUE")  {
            if ( User::getUserTransactionsPreferences(self::ALLOW_CHEQUES) ) {
                $transTypeCodesAvailable = "ENC";
            }
            else {

                $error = Raxan::locale("txn.error.encashNotEnabled");
            }
        }
        else if ($transType == "TRANSFER")  {
            if ( User::getUserTransactionsPreferences(self::ALLOW_TRANSFERS) ) {
                $transTypeCodesAvailable = "INT";
            }
            else {
                $error = Raxan::locale("txn.error.transferNotEnabled");
            }
        }

        else {
            $error = Raxan::locale("txn.error.noTypeSelected");
        }

        return array("transTypeCodesAvailable" => $transTypeCodesAvailable , "error" => $error);


    }
    
    protected function getChargesInfo(){

        // pick up the charges
        $chargesResponse    = Trans::getChargeAmount($this->txn());
        
        // if we have no error update the charges
        if (is_object($chargesResponse->result)){
            $charges = $chargesResponse->result;
            // update the charges
            $this->chargesAmount->html($charges->currency . " " . number_format($charges->amount, 2, '.', ','))->updateclient();
            $this->chargesTax->html($charges->currency ." " .number_format( $charges->tax , 2, '.', ','))->updateclient();
            $this->chargesTotal->html($charges->currency ." " . number_format($charges->tax + $charges->amount , 2, '.', ','))->updateclient();
        }
    }



    protected function getCurrencyRatesInfo($amount, $amountCurrency, $sourceCurrency){

        if (!is_numeric($amount)) return 0;
        if ($amountCurrency == "") return 0;
        if ($sourceCurrency =="") return 0;

        // update the currency values
        if (($sourceCurrency  != $amountCurrency) ) {
            // calculate the new amount based on the parameters
            $conversionRate     = Trans::getCurrencyConversionRate( $amountCurrency, $sourceCurrency);
            $sourceCurrencyImgLink  = "<img src='views/images/flags/jmmbCurrencies/" . $sourceCurrency . ".png' > " ;

            if ( is_object($conversionRate)){
                // calculate the new amount based on the rate type
                if (strtoupper($conversionRate->rateType) == "SELL")
                    $convertedAmount = $amount / $conversionRate->rate  ;
                else $convertedAmount = $amount * $conversionRate->rate  ;

                // update the view
                $this->amountInSourceCurrency->html($sourceCurrencyImgLink . $sourceCurrency . " " . number_format($convertedAmount, 2, '.', ','))->updateclient();
                $this->exchangeRate->html($conversionRate->rate . " (". strtolower($conversionRate->rateType) . ")" )->updateclient();
                $this->rateDate->html(Raxan::cdate($conversionRate->effectiveDate)->format(Raxan::locale("date.short")) )->updateclient();
            }
        }

    }

    // use to setup the payee view
    protected function getPayees(){

        // Clear the payee section if no transaction type is selected
        // hide the sections
        $this->payeeListSection->hide();
        $this->deliverySection->hide();
        $this->specialInstructionSection->hide();
        $this->transferSection->hide();
        $this->wireSection->hide();

        if($this->txn("transTypeSelected")==""){
            $this->payeeSection->updateclient();
            return 0;
        }

        // turn on the payee master list
        $this->payeeListSection->show();

        // show the sub sections besed on the type selected
        if ($this->txn("transTypeSelected")=="CHEQUE") {
            // show the delivery section for the CHEQUE type
            $this->deliverySection->show();
            // show the special instruction if delivery is allow
            if (User::getUserTransactionsPreferences(self::ONLY_ENCASH_PICKUP) ) {
                $this->specialInstructionSection->hide();
            }
            else {
                $this->specialInstructionSection->show();
            }
        }
        if ($this->txn("transTypeSelected")=="TRANSFER") {
            // show the section for the TRANSFER type
            $this->transferSection->show();
        }
        if ($this->txn("transTypeSelected")=="WIRE") {
            $this->wireSection->show();
        }

        $this->payeeSection->updateclient();
        $this->noteSection->updateclient();

        // if it is an Ajax request we don't need to get the payee again
        //if ($this->isAjaxRequest) return ;

        // get any existing payee listing
        $preDefinedPayeeList = $this->txn("payeeList") ;

        // if the list is empty them rebuild the list.
        if (!is_array($preDefinedPayeeList)) {
            // if the selected type is WIRE OR TRANSFER get these payees
            if ($this->txn("transTypeSelected") =="WIRE" || $this->txn("transTypeSelected") =="TRANSFER"  ) {
                $preDefinedPayeeList = Trans::getMyPreAuthorizedPayee();
            }
            else if ($this->txn("transTypeSelected") =="CHEQUE"){
                $preDefinedPayeeList = Trans::getMyAggregatedPayees();
            }
            // store the payee list being used
            $this->txn("payeeList" , $preDefinedPayeeList);
        }

        // bind the list.
        $this->payeeList->bind($preDefinedPayeeList);
        // prepend the clients own name to the payee list for internal transfers
        if ($this->txn("transTypeSelected") =="TRANSFER" ) {
            $this->payeeList->prepend('<option value="MYJMMB" langid="txn.payee.myAccounts">My JMMB Accounts</option>'); // hard coded "-1" for My JMMB Accounts
        }

        // default the payee selected
        if (is_numeric($this->txn("payeeIndexSelected")))
            $this->payeeList->val($this->txn("payeeIndexSelected")+1);
        else if ($this->txn("payeeIndexSelected") == "MYJMMB" )
            $this->payeeList->val("MYJMMB");
        else $this->payeeList->val("");

        // set the instruction and personal note
        $this->specialInstruction->text($this->txn("specialInstruction"));
        $this->personalNote->text($this->txn("personalNote"));

        // choose the mode to call the payee options in.
        if (is_numeric($this->txn("payeeIndexSelected")) || is_null($this->txn("payeeIndexSelected")) ){
            // set the defaults for the payee section
            $this->getPayeeOptions($this->txn("payeeId") ,$this->txn("payeeType") , $this->txn("deliveryMethod"));
        }
        else if ($this->txn("payeeIndexSelected") == "MYJMMB" ){
            // get ooptions for my JMMB accounts
            $this->getPayeeOptions($this->txn("payeeIndexSelected") , null , null);
        }
        else

        return 1;
    }

    // get the options for the payee selected
    protected function getPayeeOptions($payeeId, $payeeType,  $method  ){

        // defaule the method
        if (!isset($method) ||  (User::getUserTransactionsPreferences(self::ONLY_ENCASH_PICKUP) )) {
            $method = "PICKUP" ;
            //$this->showErrorMessage("Invalid delivery method selected.");
            //return 0;
        }

        if(is_numeric($payeeId)){
        }
        else if ($payeeId =="MYJMMB" ) { // hardcoded value to represent My JMMB accounts
            if ($this->txn("transTypeSelected")!="TRANSFER") {
                //$this->showErrorMessage("This Payee is only valid for transfers.");
                $this->txn("payeeId", null);
                $payeeId = null;
                //return 0;
            }
        }
        if ($this->txn("transTypeSelected")=="CHEQUE") {
            // default the delivery method
            $this->deliveryMethod->val($method);
            // get the transactional branhces
            $brancheList = Sysinfo::getTransactionalBranches(User::getClientType(),false);
            $this->branchList->bind($brancheList);
            $this->branchList->prepend('<option value="" langid="txn.payee.chooseBranch">Choose Branch</option>');
            // default the branch
            if ($this->txn("branchCode") =="")
                $this->branchList->val(User::getUserPreference(self::DEFAULT_BRANCH));
            else $this->branchList->val($this->txn("branchCode"));

            // get the selected payee information
            if (isset($payeeId)) {
                // disable the delivery options if a company is selected
                if ($payeeType == "C") {
                    // disable the delivery section
                    $this->find(".deliveryClass")->attr("disabled", "disabled")->updateClient();
                }
                else {
                    // disable the delivery section
                    $this->find(".deliveryClass")->removeAttr("disabled")->updateClient();

                    // check if this preference is allowed
                    if (User::getUserTransactionsPreferences(self::ONLY_ENCASH_PICKUP) ) {
                        // force the options to reflect pick up .
                        $method == "PICKUP";

                    }
                    else {
                        // present the deliver to address option
                        $this->deliveryMethod->append("<option value ='DELIVER' langid='txn.payee.deliveryMethod.DELIVER'>Delivery to address >></option>");
                        $this->deliveryMethod->val($method);
                        $this->deliveryMethod->updateclient();
                        // get the payees
                        $payeeDetails = Trans::getMyPreAuthorizedPayeeDetails($payeeId, $this->txn("transTypeCodesAvailable"));
                        // extract the delivery addresses
                        $payeeDetailsList = Trans::getInfoFromPayeeDetailsArray($payeeDetails,$this->txn("transTypeCodesAvailable") );
                        $this->addressList->bind($payeeDetailsList);
                        $this->addressList->prepend('<option value="CUSTOM" langid="txn.payee.address.CUSTOM" >Enter Custom Address...</option>');
                        $this->addressList->prepend('<option value="" langid="txn.payee.address.selectLocation" >Select a Location</option>');
                        // default the address selected
                        if (is_numeric($this->txn("addressIndexSelected")))
                            $this->addressList->val($this->txn("addressIndexSelected")+1);
                        else if ($this->txn("addressIndexSelected") == "CUSTOM" )
                            $this->addressList->val("CUSTOM");
                        else $this->addressList->val("");

                        $this->addressList->updateclient();
                        // if the custom address option is selected default the values
                        if ($this->txn("addressIndexSelected") == "CUSTOM" ) {
                            $this->addressLine1->val($this->txn("addressLine1"));
                            $this->addressLine2->val($this->txn("addressLine2"));
                            $this->addressLine3->val($this->txn("addressLine3"));
                        }
                        // get the country codes
                        $countriesList = SysInfo::getCountries();
                        $this->addressCountryCode->bind($countriesList);
                        $this->addressCountryCode->prepend('<option value="" langid="txn.payee.address.country">Country...</option>');
                        // default the country
                        if ($this->txn("addressCountryCode") =="")
                            $this->addressCountryCode->val("");
                        else $this->addressCountryCode->val($this->txn("addressCountryCode"));

                        // store the current detail list
                        $this->txn("payeeDetailList" , $payeeDetailsList);
                    }
                }
            }

            // determine which list to show
            if ($method == "PICKUP") {
                $this->branchListSection->show()->updateclient();
                $this->addressListSection->hide()->updateclient();
            }
            else if ($method == "DELIVER") {
                $this->addressListSection->show()->updateclient();
                $this->specialInstructionSection->show()->updateclient();
            }


        }

        if ($this->txn("transTypeSelected")=="TRANSFER") {

            if(is_numeric($payeeId) || is_null($payeeId) ){
                // get the payees and extract the details
                $payeeDetails = Trans::getMyPreAuthorizedPayeeDetails($payeeId, $this->txn("transTypeCodesAvailable"));
                $payeeDetailList = Trans::getInfoFromPayeeDetailsArray($payeeDetails,$this->txn("transTypeCodesAvailable") );
            }
            else if ($payeeId =="MYJMMB" ) { // hardcoded value to represent My JMMB accounts
                // pick up the client accounts and extract the detail we need
                $payeeDetailList = Trans::getPayeeDetailFromClientAccounts();
            }
            // bind and display the list
            $this->transferAccountList->bind($payeeDetailList);
            // default the transfer account
            if (is_numeric($this->txn("transferAccountIndexSelected")))
                $this->transferAccountList->val($this->txn("transferAccountIndexSelected")+1);
            else $this->transferAccountList->val("");
            $this->transferAccountList->updateclient();

            // store the current detail list
            $this->txn("payeeDetailList" , $payeeDetailList);

            // get the options for the transfer account
            $this ->getTransferAccountOptions($this->txn("transferAccountIndexSelected"));

        }

        if ($this->txn("transTypeSelected")=="WIRE") {
            // get the payees
            $payeeDetails = Trans::getMyPreAuthorizedPayeeDetails($payeeId, $this->txn("transTypeCodesAvailable"));
            // extract the delivery addresses
            $payeeDetailList = Trans::getInfoFromPayeeDetailsArray($payeeDetails,$this->txn("transTypeCodesAvailable") );
            $this->wireAccountList->bind($payeeDetailList);
            // default the wire account
            if ($this->txn("wireAccountIndexSelected") =="")
                $this->wireAccountList->val("");
            else $this->wireAccountList->val($this->txn("wireAccountIndexSelected")+1);
            $this->wireAccountList->updateclient();

            //c()->alert(print_r($payeeDetailList, true));

            // store the current detail list
            $this->txn("payeeDetailList" , $payeeDetailList);

        }

        return 1;
    }

    protected function getTransferAccountOptions($transferAccountSelected){

        if (!is_numeric($transferAccountSelected)|| $transferAccountSelected < 0 ) {
            $this->transferAccountTradeSection->hide()->updateclient();
        }
        else {
            // get the payee information and show the assest list.
            $payeeDetailList = Trans::getPayeeDetailFromClientAccounts() ;
            //c()->alert(print_r($transferAccountsList[$transferAccountSelected], true));
            if (strtoupper($payeeDetailList[$transferAccountSelected]["jmmbProductType"]) == "INVESTOR"   ) {
                if (is_array($payeeDetailList[$transferAccountSelected]["jmmbAssetList"])) {
                    $this->transferAccountTradeList->bind($payeeDetailList[$transferAccountSelected]["jmmbAssetList"]);
                }
                else {
                    $this->transferAccountTradeList->html('');
                }
                $this->transferAccountTradeList->prepend('<option value="NEW" langid="txn.payee.newInvestment" >New Investment</option>');
                $this->transferAccountTradeList->prepend('<option value="" langid="txn.payee.selectInvestment">Select Investment</option>');
                // default the investment selected
                if (is_numeric($this->txn("transferAccountTradeIndex")))
                    $this->transferAccountTradeList->val($this->txn("transferAccountTradeIndex")+1);
                else if ($this->txn("transferAccountTradeIndex") == "NEW" )
                    $this->transferAccountTradeList->val("NEW");
                else $this->transferAccountTradeList->val("");
                $this->transferAccountTradeSection->show()->updateclient();

                // get the trade terms
                $terms = SysInfo::getTradeTerms();
                $this->transferAccountTradeTradeTerms->bind($terms);
                $this->transferAccountTradeTradeTerms->prepend('<option value ="" langid="txn.payee.selectTradeTerms" >Select Trade Term ...</option>');


                // default the Investment term
                if ($this->txn("transferAccountTradeTradeTerms")!="")
                    $this->transferAccountTradeTradeTerms->val($this->txn("transferAccountTradeTradeTerms"));
                else $this->transferAccountTradeTradeTerms->val(User::getUserPreference(self::DEFAULT_TRADE_TERM));

            }
            else {
                $this->transferAccountTradeSection->hide()->updateclient();;
            }

        }
        return 1;
    }


    // process the source account selection
    protected function getSourceAccountInfo($accountIndex){

        // ensure that we have the account number.
        if (!isset($accountIndex)) {
            $this->showErrorMessage(Raxan::locale("txn.error.noAccountNo"));
            return 0;
        }

        if ($accountIndex < 0 ) {
            //$this->sourceAvailableBalance->html("Select account from the list." )->updateClient();
            return 0;
        }

        // get the list of accounts 
        $clientAccounts = User::getClientAccounts();
        
        // show balance - This is being done form the client side
        //$this->sourceAvailableBalance->html($clientAccounts[$accountIndex]['AvailableBalance'] . " Currency : " . $clientAccounts[$accountIndex]['Currency']  )->updateClient();
        // if the product type is investor, populate the investor maturities
        if (strtoupper(trim($clientAccounts[$accountIndex]['ProductType'])) == "INVESTOR" ) {

            // get my account maturities
            $myInvestmentMaturitiesList = $clientAccounts[$accountIndex]['AssetList'];
            if (count($myInvestmentMaturitiesList)==0) {
                $this->sourceMaturity->html("<option value='' langid='txn.source.selectMaturityNone'>Select Maturity ... (NONE)</option>");
                $this->accountMaturities->show()->updateClient();
            }
            else {
                $this->sourceMaturity->bind($myInvestmentMaturitiesList);
                $this->sourceMaturity->prepend("<option value='' langid='txn.source.selectMaturity' >Select Maturity ...</option>");
                $this->accountMaturities->show()->updateClient();
                // default the Maturity
                if (is_numeric($this->txn("sourceMaturityIndex"))&& $accountIndex == $this->txn("sourceIndexSelected") ){
                    $this->sourceMaturity->val($this->txn("sourceMaturityIndex")+1);
                    // get the balance for the first one in the list.
                    $this->getSourceMaturityInfo($accountIndex , $this->txn("sourceMaturityIndex"));
                }
                else {
                    $this->sourceMaturity->val("");
                    // get the balance for the first one in the list.
                    $this->getSourceMaturityInfo($accountIndex , null );
                }

            }

        }
        else {
            $this->accountMaturities->hide()->updateClient();
        }

        return 1;
   }

    // process the source account selection
    protected function getSourceMaturityInfo($accountIndex , $assetIndex){

        // ensure that we have the account number.
        if (!isset($assetIndex)|| $assetIndex < 0 ) {
            $this->sourceAvailableBalance->html(Raxan::locale("txn.source.selectMaturity"))->updateClient();
            $this->sourceMaturity->val("");
            return 0;
        }
        // ensure that we have the account number.
        if (!isset($accountIndex) || $accountIndex < 0 ) {
            //$this->showErrorMessage("No account numebr or type passed in.");
            return 0;
        }

        // pick up the account list stored on the ciient.
        $clientAccounts = User::getClientAccounts();

        if (!is_object($clientAccounts[$accountIndex]['AssetList'][$assetIndex])) {
            $this->sourceAvailableBalance->html(Raxan::locale("txn.source.selectMaturity"))->updateClient();
        }
        else {
            $maturity = $clientAccounts[$accountIndex]['AssetList'][$assetIndex];
            $sourceCurrencyImgLink  = "<img src='views/images/flags/jmmbCurrencies/" . $maturity->currency  . ".png' > " ;

            // get my maturity Value for the index
            $this->sourceAvailableBalance->html($sourceCurrencyImgLink . " " .$maturity->currency . " " . number_format($maturity->maturityValue,2))->updateClient();

        }


        return 1;
    }

    // function used to search array for value and return the key
    protected function getArrayKey($needle, $haystack) {
        foreach ($haystack as $key => $val) {
            if(is_array($val)) {
                $subKey = $this->getArrayKey($needle, $val) ;
                if($subKey  > -1 ) {
                    return $key;
                    break;
                }
            }
            if (is_scalar($val) && is_scalar($needle)) {
                if ($val == $needle) {
                    return $key ;
                }
            }
            

        }
        return -1  ;
   }


    // process outstanding input and update transaction at ready to be processed
    protected function saveTxn($e){

        // reset any error previously set
        $this->txn("txnProcessError" , "");

        // process the input based on the transaction type
        if ($this->txn("screenMode") == "EXPERT" ) {
            // precess all the values of the transction
            if($this->txn("transTypeSelected") == "") {
                if(!$this->processType($e)) return 0; // only execute the type if none was selected
            }
            if(!$this->processPayee($e)) return 0;
            if(!$this->processSource($e)) return 0;
            if(!$this->processSchedule($e)) return 0;
        }
        else {
            // save the schedule entered by the user
            if(!$this->processSchedule($e)) return 0;
        }

        // validate the transaction before saving
        if (!$this->txnValidate()) {
            return 0;
        }

        // get the txn Details
        // initialize details variable.
        $txnDetails = "";
        if ($this->txn("transTypeSelected")=="CHEQUE") {
            if ($this->txn("deliveryMethod")=="PICKUP") {
                $txnDetails = Raxan::locale("txn.review.CHEQUE.pickUpt") . $this->txn("branchCode");
            }
            else if ($this->txn("deliveryMethod")=="DELIVER") {
                $txnDetails = Raxan::locale("txn.review.CHEQUE.deliver");
            }
        }
        else if ($this->txn("transTypeSelected")=="TRANSFER") {
            $txnDetails = Raxan::locale("txn.review.TRANSFER.jmmbAcc"). $this->txn("transferAccountReference")  ;
        }
        else if ($this->txn("transTypeSelected")=="WIRE") {
            $txnDetails = Raxan::locale("txn.review.WIRE.wireTo") . $this->txn("wireAccountName");
        }

        // update the transaction details
        $this->txn("txnDetails" , $txnDetails  );


        // get the schedule
        $txnSchedule = "";
        if ( $this->txn("frequencyOption") == "MULTIPLE" ) {
            if($this->txn("cyclePeriodCode")=="NUMDAYS"){
                $txnSchedule = Raxan::locale("txn.review.cycle.every"). $this->txn("cyclePeriodDays") . Raxan::locale("txn.review.cycle.every");
            }
            else{
                $txnSchedule = $this->txn("cyclePeriodDesc") ;
            }
        }
        else{
            $txnSchedule = $this->txn("txnEffectiveDate");
        }
        // update the transaction schedule
        $this->txn("txnSchedule" , $txnSchedule  );

        //////////////////////////////////////////////////////////////////////
        //////////////////////////////////////////////////////////////////////
        //build the additional Details section 
        $txnMoreDetails = ""; // initialise variable
        // show the delivery Details
        $txnMoreDetails .= "<div class='txnMoreDtlsItem'>";
        $txnMoreDetails .= "<b>". Raxan::locale("txn.review.dtls.delivery").  "</b>";
        if ($this->txn("transTypeSelected")=="CHEQUE") {
            if ($this->txn("deliveryMethod")=="PICKUP") {
                $txnMoreDetails .=  "<br>". Raxan::locale("txn.review.dtls.chequePickUp"). " " . $this->txn("branchCode");
            }
            else if ($this->txn("deliveryMethod")=="DELIVER") {
                $txnMoreDetails .= "<br>". Raxan::locale("txn.review.dtls.chequeDelivery");
                $txnMoreDetails .= "<i> " ;
                if ($this->txn("addressLine1")) $txnMoreDetails .= "<br>" . $this->txn("addressLine1") ;
                if ($this->txn("addressLine2")) $txnMoreDetails .= "<br>" . $this->txn("addressLine2") ;
                if ($this->txn("addressLine3")) $txnMoreDetails .= "<br>" . $this->txn("addressLine3") ;
                if ($this->txn("addressCountryCode")) $txnMoreDetails .= " (" . $this->txn("addressCountryCode"). ")" ;
                $txnMoreDetails .= "</i> " ;
            }
        }
        else if ($this->txn("transTypeSelected")=="TRANSFER") {
            $txnMoreDetails .=  "<br>". Raxan::locale("txn.review.dtls.transferTo"). " " . $this->txn("transferAccountReference")  ;
            $txnMoreDetails .=  "<br>". Raxan::locale("txn.review.dtls.transferTo.name"). " " . $this->txn("transferAccountName")  ;
            $txnMoreDetails .=  "<br>". Raxan::locale("txn.review.dtls.transferTo.payeeId"). " " . $this->txn("payeeDetailId")  ;
        }
        else if ($this->txn("transTypeSelected")=="WIRE") {
            $txnMoreDetails .= "<br>". Raxan::locale("txn.review.dtls.wireTo"). " " . $this->txn("wireAccountName");
            $txnMoreDetails .= "<br>". Raxan::locale("txn.review.dtls.wireTo.bankName"). " " . $this->txn("wireAccountBenBankName");
        }
        $txnMoreDetails .= "<br></div>";

        // show the currency exchange rate
        $txnMoreDetails .= "<div class='txnMoreDtlsItem'>";
        if ($this->txn("sourceCurrency")!= $this->txn("amountCurrency") ) {
            $txnMoreDetails .= "<b>". Raxan::locale("txn.review.dtls.convRate"). "</b><br>";
            $txnMoreDetails .= "<b>" . $this->txn("conversionRateValue") . "</b><i>(" . strtolower($this->txn("conversionRateType")) . ")</i> - " . $this->txn("conversionRateDate");
            $txnMoreDetails .= "<br><br>";
        }
        // show the special instruction
        if ($this->txn("specialInstruction")!= "" ) {
            //$txnMoreDetails .= "<div class='txnMoreDtlsItem'>";
            $txnMoreDetails .= "<b>". Raxan::locale("txn.review.dtls.instruction"). "</b><br>";
            $txnMoreDetails .= $this->txn("specialInstruction") ;
            
        }
        $txnMoreDetails .= "<br></div>";
        // show the Schedule informtion
        $txnMoreDetails .= "<div class='txnMoreDtlsItem'>";
        $txnMoreDetails .= "<b>". Raxan::locale("txn.review.dtls.schedule"). "</b><br>";
        $txnMoreDetails .= Raxan::locale("txn.review.dtls.frequency");
        if ( $this->txn("frequencyOption") == "MULTIPLE" ) {

            if($this->txn("cyclePeriodCode")=="NUMDAYS"){
                $txnMoreDetails .= Raxan::locale("txn.review.cycle.every") . $this->txn("cyclePeriodDays") . Raxan::locale("txn.review.cycle.xDays");
            }
            else{
                $txnMoreDetails .= $this->txn("cyclePeriodDesc") ;
            }
            // show the date range
            $txnMoreDetails .= "<br>";
            $txnMoreDetails .= Raxan::locale("txn.review.dtls.schedule.start") . " ". $this->txn("cyclePeriodStartDate") ;
            $txnMoreDetails .= " " . Raxan::locale("txn.review.dtls.schedule.end"). " ". $this->txn("cyclePeriodEndDate") ;

            // show the business day option
            $txnMoreDetails .= "<br>" .Raxan::locale("txn.review.dtls.schedule.businessDay1") . " ";
            $txnMoreDetails .= ucfirst(strtolower($this->txn("cycleBusinessDayOption")));
            $txnMoreDetails .= " " . Raxan::locale("txn.review.dtls.schedule.businessDay2") ;
        }
        else{
            $txnMoreDetails .= Raxan::locale("txn.review.dtls.schedule.oneTime") ;
            $txnMoreDetails .= "<br>" . Raxan::locale("txn.review.dtls.schedule.effectDate"). " " .$this->txn("txnEffectiveDate");
        }
        $txnMoreDetails .= "<br></div>";
        // show the personal Note
        if ($this->txn("personalNote")!= "" ) {
            $txnMoreDetails .= "<div class='txnMoreDtlsItem'>";
            $txnMoreDetails .= "<b>". Raxan::locale("txn.review.dtls.note"). "</b><br>";
            $txnMoreDetails .= nl2br($this->txn("personalNote")) ;
            $txnMoreDetails .= "<br></div>";
        }

        //Trans::getChargeAmount($universalId, $accountNo, $this->txn("transTypeCode"), $transactionAmount, $transactionCurrency);
        // show the Charges
        $universalId = User::getUniversalId();
//        $charges = Trans::getChargeAmount($universalId, $this->txn("sourceAccount"), $this->txn("transTypeCode"), $this->txn("amountEntered"),  $this->txn("amountCurrency"));
//        $txnMoreDetails .= "<div class='txnMoreDtlsItem'>";
//        $txnMoreDetails .= "<b>". Raxan::locale("txn.review.dtls.charges"). "</b><br>";
//        $txnMoreDetails .= Raxan::locale("txn.review.dtls.charges.amount").  " " . $charges->amount ;
//        $txnMoreDetails .= "<br>" . Raxan::locale("txn.review.dtls.charges.tax").  " " . $charges->tax ;
//        $txnMoreDetails .= "<br>" . Raxan::locale("txn.review.dtls.charges.total").  " " . ($charges->tax + $charges->amount) . " (" . $charges->currency . ")";
//        $txnMoreDetails .= "<br></div>";
//
        // update the transaction additional Details
        $this->txn("txnMoreDetails" , $txnMoreDetails  );

        // mark this transaction as ready for processing.
        $this->txn("txnStatus" , "PENDING" );

        return 1;
    }

   // make the transaction as ready and move to the next one
    protected function saveAndEnterNew($e){

        // save the transaction
        if(!$this->saveTxn($e)) return 0;

        // save the transaction
        if(!$this->txnNew($e)) return 0;

        // switch the view
        $this->redirectToView("index");

        return 1;
    }

    // make the transaction as ready and move to the next one
    protected function saveAndContinue($e){

        // save the schedule entered by the user
        if(!$this->processSchedule($e)) return 0;

        // save the transaction
        if(!$this->saveTxn($e)) return 0;

        // switch the view
        $this->redirectToView("review");

        return 1;
    }


    // use to return the currently active transaction
    protected function txnSummaryDisplay(){

        $html = "" ;
        // display the transaction type selected 
        if ($this->txn("transTypeSelected")) {
            $html .= "<br>";
            $html .= "<div class='left pad'>";
            $html .= "<img src='views\images\yellow_bullet.gif' align=left >";
            $html .= "</div>";
            $html .= "<div class=left>";
            $html .= "<b><label langid='txn.summary.".$this->txn("transTypeSelected") .".title'>" . $this->txn("transTypeSelected"). "</label></b>";
            $html .= "</div><br>";
        }
        //c()->alert(print_r($this->txn(), true));
        // display the payee selected
        if (!is_null($this->txn("payeeIndexSelected"))) {
            $html .= "<br>";
            $html .= "<div class='left pad'>";
            $html .= "<img src='views\images\yellow_bullet.gif' align=left >";
            $html .= "</div>";
            $html .= "<div class=left>";
            $html .= "<b><span langid='txn.summary.payee'>Payee : </span></b>" ;
            $html .= ($this->txn("payeeName"))? " " .$this->txn("payeeName") : "" ;
            $html .= ($this->txn("payeeDescription"))? " (" .$this->txn("payeeDescription") . ")" : "" ;

            // show the delivery options for the payee
            if ($this->txn("transTypeSelected")=="CHEQUE") {
                if ($this->txn("deliveryMethod")=="PICKUP") {
                    $html .= "<br><i><span langid='txn.summary.forPickUpAt'>For Pick Up At : </span></i>" . $this->txn("branchCode");
                }
                else if ($this->txn("deliveryMethod")=="DELIVER") {
                    $html .=  "<br><i><span langid='txn.summary.forDeliveryTo'>For Delivery to Address : </span></i>" ;
                    $html .= ($this->txn("addressLine1"))? "<br>" .$this->txn("addressLine1") : "" ;
                    $html .= ($this->txn("addressLine2"))? ", " .$this->txn("addressLine2") : "" ;
                    $html .= ($this->txn("addressLine3"))? ", " .$this->txn("addressLine3") : "" ;
                    $html .= ($this->txn("addressCountryCode"))? "<br>" .$this->txn("addressCountryCode") : "" ;
                }
            }
            else if($this->txn("transTypeSelected")=="TRANSFER") {
                $html .=  "<br>" ;
                $html .= ($this->txn("transferAccountReference"))? "" .$this->txn("transferAccountReference") : "" ;
                $html .= ($this->txn("transferAccountName"))? " - " .$this->txn("transferAccountName") : "" ;

           }
            else if($this->txn("transTypeSelected")=="WIRE") {
                $html .=  "<br>" ;
                $html .= ($this->txn("wireAccountName"))? "" .$this->txn("wireAccountName") : "" ;
                //$html .= ($this->txn("wireAccountBenBankName"))? " - " .$this->txn("wireAccountBenBankName") : "" ;

           }
           $html .= ($this->txn("payeeDetailCurrency"))? "<br><span langid='txn.summary.payeeCurrency'>Payee Currency : </span>" .$this->txn("payeeDetailCurrency") . "" : "" ;
           $html .= ($this->txn("personalNote"))? "<br><span langid='txn.summary.personalNote'>Personal note : </span><i>" . nl2br($this->txn("personalNote")) . "</i>" : "" ;
           $html .=  "<br>" ;

           $html .= "</div><br>";

        }


        // display the source account selected selected
        if ($this->txn("sourceIndexSelected")!= "") {
            $html .= "<br>";
            $html .= "<br>";
            $html .= "<div class='left pad'>";
            $html .= "<img src='views\images\yellow_bullet.gif' align=left >";
            $html .= "</div>";
            $html .= "<div class=left>";
            $html .= "<b><span langid='txn.summary.fromSourceAccount'>From Source Account : </span></b>" ;
            $html .= ($this->txn("sourceAccount"))? " " .$this->txn("sourceAccount") : "" ;
            $html .= ($this->txn("sourceAccount"))? "<br>" .$this->txn("sourceAccountName") : "" ;
            $html .= ($this->txn("sourceCurrency"))? " (" .$this->txn("sourceCurrency"). "" : "" ;
            $html .= ($this->txn("sourceAccountType"))? " - " .$this->txn("sourceAccountType"). ")" : "" ;

            $html .= "<br>";

            // show the information for INVESTOR accounts
            if ($this->txn("sourceAccountType")=="INVESTOR") {
                $html .=  "<i><span langid='txn.summary.maturity'>Maturity : </span></i>" ;
                $html .= ($this->txn("sourceMaturityDate"))? "" .$this->txn("sourceMaturityDate") ." " : "" ;

            }
            //display the balance
            $html .=  "<i><span langid='txn.summary.balance'>Balance : </span></i>" ;
            $html .= ($this->txn("sourceAvailableBalance"))?  "" . $this->txn("sourceCurrency")." ".number_format($this->txn("sourceAvailableBalance"),2) : "" ;

            $html .= "</div><br><br>";


        }

        // display the amount entered
        if ($this->txn("amountEntered")!= "") {
            $html .= "<br>";
            $html .= "<br>";
            $html .= "<br>";
            $html .= "<div class='left pad'>";
            $html .= "<img src='views\images\yellow_bullet.gif' align=left >";
            $html .= "</div>";
            $html .= "<div class=left>";
            $html .= "<b><span langid='txn.summary.paymentAmount'>Payment Amount : </span></b>" ;
            $html .= ($this->txn("amountEntered"))? "" .$this->txn("amountCurrency")." " . number_format($this->txn("amountEntered"),2) : "" ;
            //$html .= ($this->txn("amountCurrencyRate"))? " (<span langid='txn.summary.fx'>Fx</span> : " .$this->txn("amountCurrencyRate"). ")" : "" ;
        }


        // show the encashment amount  if currency is different
        if ($this->txn("amountCurrency") != $this->txn("sourceCurrency") ) {
            $html .= "<br>";
            $html .= "<i><span langid='txn.summary.encashmentAmount'>Encashment Amount : </span></i>" ;
            $html .= ($this->txn("sourceCurrencyTxnAmount"))? "" . $this->txn("sourceCurrency")." " . number_format($this->txn("sourceCurrencyTxnAmount"),2) : "" ;

            $html .= "<br>";
        }

        // show the international cheque option if selected
        $html .= ($this->txn("internationalChequeRequested") == "off")? " <br><div langid='txn.summary.internationalCheque'>International Cheque Requested</div>" : "<br>" ;

        $html .= "<br></div>";
        $txnCount = Trans::getTxnCount();
        // additional space at the bottom
        $html .= "<br>";
        $html .= "<hr><b><i> $txnCount <span  langid='txn.summary.transPending' >Transaction(s) Pending</span></i></b>";

        //c()->alert($html);
        // update the display

        $this->txnSummary->html($html)->updateclient();

       return 1;

    }

    // use to handle the currently active transaction
    protected function txn($keyName= null,$keyValue = null ){

        // pass the current index to the core function. It will do the work
        return $this->txnSelect($this->tIndex, $keyName, $keyValue);

    }

    // use to return the full list of transactions
    protected function txnAll($txnStatus = null){
        
        // pick up the transactions
        $txnOldList = $this->trans;
        $txnNewList = array();

        // if no status is passed in, return the full list
        if (is_null($txnStatus)) {
            return $txnOldList;
        }
        else {
            // create the new txns list only for the selected status
            for ($index = 0; $index < count($txnOldList); $index++) {
                //c()->alert($index);
                if ($txnOldList[$index]["txnStatus"] == $txnStatus) {
                    $txnNewList[] = $txnOldList[$index];
                }
            }

            return $txnNewList ;
        }
    }

    // use to return a transaction from the list or a value from a transaction 
    protected function txnSelect($txnIndex , $keyName = null , $keyValue = null ){

        // they must pass in a txn index
        if (!array_key_exists($txnIndex, $this->trans)) {
            $this->showErrorMessage("Invalid or Missing Transaction Index [$txnIndex, $keyName].");
            //trigger_error("Moneyline Error: Invalid or Missing Transaction Index. Please ensure an index is specified to access the transcction array.");
            return null;
        }

        // if no key name is passed in send back the transction
        if (!isset($keyName)){
            return $this->trans[$txnIndex] ;
        }
        else {
            // check to see if the key name exist
            if (!array_key_exists($keyName, $this->trans[$txnIndex])) {
                $this->showErrorMessage("Invalid Transaction Key Name [$keyName].");
                //trigger_error("Moneyline Error: Invalid Transaction Key Name [$keyName]. Please ensure that the correct key name is specified to access the transcction array.");
                return null;
            }
            else {
                // if no value is passed in but we have a keyName, return the keynme
                if (!isset($keyValue)) {
                    return $this->trans[$txnIndex][$keyName] ;
                }
                else {
                    // if we have a value set the key name
                    $this->trans[$txnIndex][$keyName] = $keyValue ;
                    return true;
                }

            }
        }

        return null ;
    }

    // used to create a new transaction template
    protected function txnNew(){

        // clear the session of any other new and unsaved transactions
        $this->txnDeleteByStatus("NEW");
        $this->txnDeleteByStatus("UNSAVED");
        // create the new txn 
        $keyIndex = count($this->trans);
        $this->trans[$keyIndex]=$this->txnTemplate();
        $this->tIndex = $keyIndex ;

        // return the value for the index passed
        return $keyIndex;
    }

    // used to call the vlidate routine and handle errors
    protected function txnValidate(){

        $txnResults = Trans::validateTransaction( $this->txn());


        if (is_object($txnResults )) {
            $this->showErrorMessage(Raxan::locale($txnResults->error));
            return 0 ;
        }

        return 1;
    }
    // function defines the transaction array 
    protected function txnTemplate(){
        return array(
            "transTypeSelected" => null,
            "transTypeCodesAvailable" => null,
            "transTypeCode" => null,
            "screenMode" => null,

            "payeeIndexSelected" => null,
            "payeeId" => null,
            "payeeDetailId" => null,
            "payeeDetailCurrency" => null,
            "payeeName" => null,
            "payeeType" => null,
            "payeeDescription" => null,
            "personalNote" => null,

            // cheque
            "deliveryMethod" => null,
            "branchCode" => null,
            "addressIndexSelected" => null,
            "addressLine1" => null,
            "addressLine2" => null,
            "addressLine3" => null,
            "addressCountryCode" => null,
            "specialInstruction" => null,

            //transfer
            "transferAccountIndexSelected" => null,
            "transferAccountReference" => null,
            "transferAccountName" => null,
            "transferAccountTradeIndex" => null,
            "transferAccountTradeTradeNo" => null,
            "transferAccountTradePrevTradeNo" => null,
            "transferAccountTradeDate" => null,
            "transferAccountTradeIssueDate" => null,
            "transferAccountTradeTradeTerms" => null,

            "transferAccountTradeMaturity" => null,
            "transferAccountTradeYield" => null,
            "transferAccountTradeInvestmentCode" => null,
            "transferAccountTradeInvestorRqstNo" => null,

            // wire
            "wireAccountIndexSelected" => null,
            "wireAccountReference" => null,
            "wireAccountName" => null,
            "wireAccountBenBankName" => null, 

            "payeeList" => null , // array
            "payeeDetailList" => null , // array

            "sourceIndexSelected" => null,
            "sourceAccount" => null,
            "sourceAccountNoValue" => null,
            "sourceAccountName" => null,
            "sourceAccountType" => null,
            "sourceCurrency" => null,
            "sourceMaturityIndex" => null,
            "sourceMaturityDate" => null,
            "sourceMaturityTradeNo" => null,
            "sourceMaturityPrevTradeNo" => null,
            "sourceMaturityIssueDate" => null,
            "sourceMaturityTradeTerms" => null,
            "sourceMaturityMaturity" => null,
            "sourceMaturityYield" => null,
            "sourceMaturityInvestmentCode" => null,
            "sourceMaturityInvestorRqstNo" => null,

            "sourceAvailableBalance" => null,
            "sourceCurrencyTxnAmount" => null,

            "amountEntered" => null,
            "amountCurrency" => null,
            
            "conversionRateValue" => null,
            "conversionRateType" => null,
            "conversionRateDate" => null,

            "internationalChequeRequested" => null,

            "txnExchangeRate" => null ,
            "txnDetails" => null ,
            "txnSchedule" => null ,
            "txnEffectiveDate" => Raxan::cdate(date("c"))->format(Raxan::locale("date.short")) ,

            "frequencyOption" => null,
            "cyclePeriodIndex" => null,
            "cyclePeriodCode" => null,
            "cyclePeriodDesc" => null,
            "cyclePeriodDays" => null,
            "cyclePeriodStartDate" => Raxan::cdate(date("c"))->format(Raxan::locale("date.short")),
            "cyclePeriodEndDate" => null,
            "cycleBusinessDayOption" => null,

            "txnStatus" => "NEW" ,
            "txnProcessError" => null,
            "txnErrorDisplayClass" => null,
            "txnProcessMessage" => null,
            "txnProcessRequestId" => null,
            "txnMoreDetails" => null

        );
    }


    // used to delete a item from the transaction array.
    protected function txnDelete($keyIndex){

        // pick up the transactions to process and reset the transaction list
        $txnOldList = $this->txnAll();
        $txnNewList = array();

        // if no index is passed in exit
        if (is_null($keyIndex)) {
            return 0;
        }

        // create the new txns list excluding the deleted items
        for ($index = 0; $index < count($txnOldList); $index++) {
            //c()->alert($index);
            if ($index != $keyIndex) {
                $txnNewList[] = $txnOldList[$index];
            }
        }

        // update the master list with the new list and reset the session index
        $this->trans = $txnNewList ;
        $this->tIndex = count($txnNewList ) - 1;

        return 1 ;
    }

    // used to delete a item from the transaction array.
    protected function txnDeleteByStatus($txnStatus){

        // pick up the transactions to process and reset the transaction list
        $txnOldList = $this->txnAll();
        $txnNewList = array();

        // if no status is passed in, exit
        if (is_null($txnStatus)) {
            return 0;
        }

        // create the new txns list excluding the deleted items
        for ($index = 0; $index < count($txnOldList); $index++) {
            //c()->alert($index);
            if ($txnOldList[$index]["txnStatus"] != $txnStatus) {
                $txnNewList[] = $txnOldList[$index];
            }
        }

        // update the master list with the new list and reset the session index
        $this->trans = $txnNewList ;
        $this->tIndex = count($txnNewList ) - 1;

        return 1 ;
    }

    protected function processExpert($e){
        User::setUserPreference(self::USE_TRANSACTION_WIZARD , 0 );
        $this->redirectToView("expert");
    }
    protected function processWizard($e){
        User::setUserPreference(self::USE_TRANSACTION_WIZARD , 1 );
        if ($this->txn("txnStatus") =="NEW") {
            $this->redirectToView("index");

        }else {
            $this->redirectToView("payee");

        }
    }


/*
        // if no items are in the list, setup up the new record and start over
        if (count($this->trans) == 0) {
            $this->trans = array(0 => $this->txnTemplate());
            Shared::data("transIndex" , 0);
        }

*/
}

?>
