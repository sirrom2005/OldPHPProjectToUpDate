<?php

namespace Moneyline\Personal\Model;

// models
require_once \PERSONAL_MODEL_PATH.'user.php';

// web services
require_once \COMMON_SERVICE_PATH.'PayeeManagementWS.php';
require_once \COMMON_SERVICE_PATH.'TransactionGatewayWS.php';

use Raxan;
use Moneyline\Personal\Shared;
use Moneyline\Personal\Model\User;

/**
 * Transaction Data Model
 * This model contains commonly used functions for the transaction screen
 */
class Trans extends \Moneyline\Common\DataModel {

    public static function getMyPreAuthorizedPayee(){
        $universalId = User::getUniversalId();

        $payees = self::getWebService('PayeeManagementWS');
            $param = new \PayeeManagementWS\getPreAuthorizedPayees();
            $param->uid = $universalId;
        $rt = $payees->getPreAuthorizedPayees($param);


        $payeeList = $rt->return->result;
        $payeeListFiltered = array();
        if ($payeeList ) foreach($payeeList as $detail) {
            if ($detail->approvedCompanyNo == 0) {
                $payeeListFiltered[]= array(
                    'allowInstructions' => trim($detail->allowInstructions),
                    'approvedCompanyNo' => trim($detail->approvedCompanyNo),
                    'uid'               => trim($detail->uid),
                    'description'       => trim($detail->description),
                    'id'                => trim($detail->id),
                    'name'              => trim($detail->name),
                    'updateDtime'       => trim($detail->updateDtime),
                    'versionNbr'        => trim($detail->versionNbr),
                );
            }
            
        }
        return $payeeListFiltered ;

    }
   /**

     */
    public static function getMyAggregatedPayees(){
        $universalId = User::getUniversalId();

        $payees = self::getWebService('PayeeManagementWS');
            $param = new \PayeeManagementWS\getAggregatedPayees();
            $param->uid = $universalId;
        $rt = $payees->getAggregatedPayees($param);

        $payeeList = $rt->return->result;
        $payeeListFiltered = array();
        if ($payeeList ) foreach($payeeList as $detail) {
            $payeeListFiltered[]= array(
                'id'                => trim($detail->id),
                'payeeDescription'  => trim($detail->payeeDescription),
                'payeeName'         => trim($detail->payeeName),
                'payeeType'         => trim($detail->payeeType),
                'subID'             => trim($detail->subID),
            );

        }
        return $payeeListFiltered ;

    }

   /**

     */
    public static function getMyPreAuthorizedPayeeDetails($payeeId, $transTypeCode){
        // ensure that we have the parameters
        if (!$transTypeCode) {
            return ;
        }
        if (!$payeeId) {
            return ;
        }

        $client = self::getWebService('PayeeManagementWS');
            $param = new \PayeeManagementWS\getPreAuthorizedPayeeDetails();
            $param->payeeID = $payeeId;
            $param->tranTypeCode = $transTypeCode; // supports comma delimited list of transaction types
        $rt = $client->getPreAuthorizedPayeeDetails($param);
        $result = $rt->return->result;
        //c()->alert(print_r($result , true));
        return $result;

    }


    
    /**
     * function returns clients predefined payees
     *
     */



    public static function getInfoFromPayeeDetailsArray($payeeDetails, $type){

        $payees = array();

        //c()->alert(print_r($payeeDetails[1], true));
        //return;
        // get the details for the ENC type (address, shortName and acountRef)
        if ($payeeDetails && $type == "ENC") foreach($payeeDetails as $detail) {
            $payees[]= array(
                'payeeId'           => trim($detail->payeeId),
                'id'                => trim($detail->id),
                'alias'             => trim($detail->alias),
                'tranTypeCode'      => trim($detail->tranTypeCode),
                'versionNbr'        => trim($detail->versionNbr),
                // company name 
                'cpnyShortName'     => trim($detail->accountDetails->shortName),
                // accountRef details
                'accRefType'        => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->type):""),
                'accRefCurrency'    => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->currency):""),
                'accRefValue'       => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->value):""),
                // address details
                'addressLine1'      => (is_object($detail->accountDetails->address)?trim($detail->accountDetails->address->line1):""),
                'addressLine2'      => (is_object($detail->accountDetails->address)?trim($detail->accountDetails->address->line2):""),
                'addressLine3'      => (is_object($detail->accountDetails->address)?trim($detail->accountDetails->address->line3):""),
                'addressCountryCode'=> (is_object($detail->accountDetails->address)?trim($detail->accountDetails->address->countryCode):""),
            );
        }
        // get the details for the INT type (acountRef)
        if ($payeeDetails && $type == "INT") foreach($payeeDetails as $detail) {
            $payees[]= array(
                'payeeId'           => trim($detail->payeeId),
                'id'                => trim($detail->id),
                'alias'             => trim($detail->alias),
                'tranTypeCode'      => trim($detail->tranTypeCode),
                'versionNbr'        => trim($detail->versionNbr),
                // accountRef details
                'accRefType'        => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->type):""),
                'accRefCurrency'    => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->currency):""),
                'accRefValue'       => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->value):""),
            );

        }
        // get the details for the LWR type (acountRef and benBank )
        if ($payeeDetails && $type == "LWR") foreach($payeeDetails as $detail) {
            $payees[]= array(
                'payeeId'           => trim($detail->payeeId),
                'id'                => trim($detail->id),
                'alias'             => trim($detail->alias),
                'tranTypeCode'      => trim($detail->tranTypeCode),
                'versionNbr'        => trim($detail->versionNbr),
                // accountRef details
                'accRefType'        => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->type):""),
                'accRefCurrency'    => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->currency):""),
                'accRefValue'       => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->value):""),
                // benificiary bank information
                'benBankName'               => (is_object($detail->accountDetails->benBank)?trim($detail->accountDetails->benBank->name):""),
                'benBankAddressLine1'       => (is_object($detail->accountDetails->benBank->address)?trim($detail->accountDetails->benBank->address->line1):""),
                'benBankAddressLine2'       => (is_object($detail->accountDetails->benBank->address)?trim($detail->accountDetails->benBank->address->line2):""),
                'benBankAddressLine3'       => (is_object($detail->accountDetails->benBank->address)?trim($detail->accountDetails->benBank->address->line3):""),
                'benBankAddressCountryCode' => (is_object($detail->accountDetails->benBank->address)?trim($detail->accountDetails->benBank->address->countryCode):""),
                'benBankVrCode'             => (is_object($detail->accountDetails->benBank->vrouting)?trim($detail->accountDetails->benBank->vrouting->code):""),
                'benBankVrMethod'           => (is_object($detail->accountDetails->benBank->vrouting)?trim($detail->accountDetails->benBank->vrouting->method):""),
            );
        }
        // get the details for the IWR type (acountRef, address, details,benBank and interBank  )
        if ($payeeDetails && ($type == "IWR" || $type == "IWR,LWR")) foreach($payeeDetails as $detail) {
            $payees[]= array(
                'payeeId'           => trim($detail->payeeId),
                'id'                => trim($detail->id),
                'alias'             => trim($detail->alias),
                'tranTypeCode'      => trim($detail->tranTypeCode),
                'versionNbr'        => trim($detail->versionNbr),
                // accountRef details
                'accRefType'        => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->type):""),
                'accRefCurrency'    => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->currency):""),
                'accRefValue'       => (is_object($detail->accountDetails->accountRef)?trim($detail->accountDetails->accountRef->value):""),
                // address details
                'addressLine1'      => (is_object($detail->accountDetails->address)?trim($detail->accountDetails->address->line1):""),
                'addressLine2'      => (is_object($detail->accountDetails->address)?trim($detail->accountDetails->address->line2):""),
                'addressLine3'      => (is_object($detail->accountDetails->address)?trim($detail->accountDetails->address->line3):""),
                'addressCountryCode'=> (is_object($detail->accountDetails->address)?trim($detail->accountDetails->address->countryCode):""),
                // details information
                'detailsLine1'      => (is_object($detail->accountDetails->details)?trim($detail->accountDetails->details->line1):""),
                'detailsLine2'      => (is_object($detail->accountDetails->details)?trim($detail->accountDetails->details->line2):""),
                'detailsLine3'      => (is_object($detail->accountDetails->details)?trim($detail->accountDetails->details->line3):""),
                'detailsLine4'      => (is_object($detail->accountDetails->details)?trim($detail->accountDetails->details->line4):""),
                // benificiary bank information
                'benBankName'               => (is_object($detail->accountDetails->benBank)?trim($detail->accountDetails->benBank->name):""),
                'benBankAddressLine1'       => (is_object($detail->accountDetails->benBank->address)?trim($detail->accountDetails->benBank->address->line1):""),
                'benBankAddressLine2'       => (is_object($detail->accountDetails->benBank->address)?trim($detail->accountDetails->benBank->address->line2):""),
                'benBankAddressLine3'       => (is_object($detail->accountDetails->benBank->address)?trim($detail->accountDetails->benBank->address->line3):""),
                'benBankAddressCountryCode' => (is_object($detail->accountDetails->benBank->address)?trim($detail->accountDetails->benBank->address->countryCode):""),
                'benBankVrCode'             => (is_object($detail->accountDetails->benBank->vrouting)?trim($detail->accountDetails->benBank->vrouting->code):""),
                'benBankVrMethod'           => (is_object($detail->accountDetails->benBank->vrouting)?trim($detail->accountDetails->benBank->vrouting->number):""),
                // inter bank information 
                'interBankName'               => (is_object($detail->accountDetails->interBank)?trim($detail->accountDetails->interBank->name):""),
                'interBankAddressLine1'       => (is_object($detail->accountDetails->interBank)?trim($detail->accountDetails->interBank->address->line1):""),
                'interBankAddressLine2'       => (is_object($detail->accountDetails->interBank)?trim($detail->accountDetails->interBank->address->line2):""),
                'interBankAddressLine3'       => (is_object($detail->accountDetails->interBank)?trim($detail->accountDetails->interBank->address->line3):""),
                'interBankAddressCountryCode' => (is_object($detail->accountDetails->interBank)?trim($detail->accountDetails->interBank->address->countryCode):""),
                'interBankVrCode'             => (is_object($detail->accountDetails->interBank)?trim($detail->accountDetails->interBank->vrouting->code):""),
                'interBankVrMethod'           => (is_object($detail->accountDetails->interBank)?trim($detail->accountDetails->interBank->vrouting->number):"")
            );

        }


        // send back the results
        return $payees;
    }


    public static function getPayeeDetailFromClientAccounts(){

        // get the client accounts
        $clientAccounts  = User::getClientAccounts();

        $payees = array();
        // get the details for the INT type (acountRef)
        if ($clientAccounts ) foreach($clientAccounts as $detail) {
            $payees[]= array(
                'payeeId'           => NULL,
                'id'                => NULL ,
                'alias'             => trim($detail["AccountName"]),
                'tranTypeCode'      => "INT" ,
                'versionNbr'        => NULL ,
                // My JMMB account detials details
                'jmmbAccountNo'         => trim($detail["AccountNo"]),
                'jmmbProductType'       => trim($detail["ProductType"]) ,
                'jmmbAccountCurrency'   => trim($detail["Currency"]),
                'accRefCurrency'   => trim($detail["Currency"]),
                'jmmbAssetList'         => $detail["AssetList"]
            );
        }

        // send back the results
        return $payees;
    }

    // list all assets list for client accounts
    public static function getAssetsListFromClientAccounts($accountId){

        // ensure that we have the parameters
        if (!$accountId) {
            return ;
        }

        // get the client accounts
        $clientAccounts  = User::getClientAccounts();
        
        $payees = array();

        // get the details for the INT type (acountRef)
        if ($clientAccounts ) foreach($clientAccounts as $detail) {
            if (is_array($detail["AssetList"]) && $accountId ==$detail["AccountNo"] ) foreach($detail["AssetList"] as $assetList) {
                $payees[]= array(
                    // My JMMB account detials details
                    'jmmbAccountNo'         => $detail["AccountNo"],
                    'jmmbProductType'       => $detail["ProductType"],
                    'jmmbAccountCurrency'   => $detail["Currency"],
                    'maturityDate'          => $assetList->maturityDate,
                    'maturityValue'         => $assetList->maturityValue
                );
            }
        }

        // send back the results
        return $payees;
    }

    public static function buildTxnRequest($txn){

        $universalId = User::getUniversalId();


        // create a request object for this trans
        $request                                                = new \TransactionGatewayWS\transactionRequest();

        $request->transactionType                               = $txn["transTypeCode"] ; 
        $request->amount                                        = $txn["amountEntered"] ;
        $request->amountTypeCode                                = NULL;
        $request->sourceAccountNo                               = $txn["sourceAccountNoValue"] ; 
        $request->destinationAccountno                          = $txn["transferAccountReference"] ;
        // assign the parameters
        if ($txn["payeeType"]=="A")
            $request->internalCustomerID                        = $txn["payeeId"] ; 
        else $request->preAuthorizedPayeeID                     = $txn["payeeId"] ;

        $request->payeeDetailID                                 = $txn["payeeDetailId"] ; 

        // setup the trade object for the source account
        $request->sourceAccountTrade                            = new \TransactionGatewayWS\tradeDetail();
        $request->sourceAccountTrade->tradeNo                   = $txn["sourceMaturityTradeNo"] ; 
        $request->sourceAccountTrade->previousTradeNo           = $txn["sourceMaturityPrevTradeNo"] ; 
        $request->sourceAccountTrade->issueDate                 = $txn["sourceMaturityIssueDate"] ; 
        $request->sourceAccountTrade->tradeTerms                = $txn["sourceMaturityTradeTerms"] ; 
        $request->sourceAccountTrade->maturity                  = $txn["sourceMaturityMaturity"] ; 
        $request->sourceAccountTrade->yield                     = $txn["sourceMaturityYield"] ; 
        $request->sourceAccountTrade->investmentCode            = $txn["sourceMaturityInvestmentCode"] ; 
        $request->sourceAccountTrade->investorRequestNo         = $txn["sourceMaturityInvestorRqstNo"] ;

        // setup the trade object for the destination
        $request->destinationAccountTrade                       = new \TransactionGatewayWS\tradeDetail();
        $request->destinationAccountTrade->tradeNo              = $txn["transferAccountTradeTradeNo"] ;
        $request->destinationAccountTrade->previousTradeNo      = $txn["transferAccountTradePrevTradeNo"] ;
        $request->destinationAccountTrade->issueDate            = $txn["transferAccountTradeIssueDate"] ;
        $request->destinationAccountTrade->tradeTerms           = $txn["transferAccountTradeTradeTerms"] ;
        $request->destinationAccountTrade->maturity             = $txn["transferAccountTradeMaturity"] ;
        $request->destinationAccountTrade->yield                = $txn["transferAccountTradeYield"] ;
        $request->destinationAccountTrade->investmentCode       = $txn["transferAccountTradeInvestmentCode"] ;
        $request->destinationAccountTrade->investorRequestNo    = $txn["transferAccountTradeInvestorRqstNo"] ;

        // delivery options
        if ($txn["transTypeSelected"] == "CHEQUE")
            $request->pickUpBranch                              = $txn["branchCode"] ; 
        else $request->pickUpBranch                             = "HO" ;// @todo: get correct pickup branch.  value now hardcoded to until Steven complete research
        $request->instructions                                  = $txn["specialInstruction"] ;
        $request->internationalCheck                            = $txn["internationalChequeRequested"] ; 

        // set upd the schdule object or the effective date based on the fequency selected
        if ($txn["frequencyOption"] == "MULTIPLE") {
            $request->schedule                                  = new \TransactionGatewayWS\accountDetail();
            $request->schedule->cyclePeriod                     = $txn["cyclePeriodCode"] ;
            $request->schedule->day                             = $txn["cyclePeriodDays"] ;
            $request->schedule->startDate                       = $txn["cyclePeriodStartDate"] ;
            $request->schedule->endDate                         = $txn["cyclePeriodEndDate"] ;
            $request->schedule->previousOrNextBusinessDay       = $txn["cycleBusinessDayOption"] ;
            $request->effectiveDate                             = NULL; // ensure that the effective date is not set
        }
        else {
            $request->effectiveDate                             = $txn["txnEffectiveDate"] ; // date('Y-m-d');
            $request->schedule                                  = NULL ; // ensure that the schedule object is not set
        }

        // set up the address object
        $request->address                                       = new \TransactionGatewayWS\addressType();
        $request->address->line1                                = $txn["addressLine1"] ; 
        $request->address->line2                                = $txn["addressLine2"] ; 
        $request->address->line3                                = $txn["addressLine3"] ; 
        $request->address->countryCode                          = $txn["addressCountryCode"] ; 

        // other parameter
        $request->transactionCurrency                           = $txn["amountCurrency"] ; 
        $request->loggedBy                                      = $universalId ;
        $request->internalRequest                               = NULL ;
        $request->personalNote                                  = $txn["personalNote"] ;


        return $request;
    }

    
    // process the source account selection
    public static function processClientTransactions($txnList, $validate = null ){

        $universalId    = User::getUniversalId();
        // setup the gateway
        $ws = new \Moneyline\Common\DataModel();
        $client = $ws->getWebService('TransactionGatewayWS');
            $param = new \TransactionGatewayWS\processTransactions();
            $param->universalId = $universalId;
            $param->token = 'dev_mode_x01000_ff23';
            $param->loggedBy = $universalId; // CROs will not be able to do transaction for ML users
            $param->internalRequest = false; // CROs will not be able to do transaction for ML users

        // inistialize the array for the transactios requests
        $requests = array();
        // loop through the txn a list and add each request to the request object
        foreach($txnList as $txn){
            // only add the ones that have not been processed.
            if ($txn["txnProcessRequestId"] == ""){
                // add add this trans to the txn request list
                $requests[] = Trans::buildTxnRequest($txn);
            }

        }

        // add the requests to the param object
        $param->batch = new \TransactionGatewayWS\transactionRequestBatch();
        $param->batch->requests = $requests;

        // execute the requests and capture the return values
        $rt = $client->processTransactions($param);
        $result = $rt->return;

        return $result;
    }


    public static function getChargeAmount($txn ){
        $universalId = User::getUniversalId();

        $client = self::getWebService('TransactionGatewayWS');
            $param = new \TransactionGatewayWS\getChargeAmount();
            $param->uid = $universalId;
            $param->batch = new \TransactionGatewayWS\transactionRequestBatch();
            $param->batch->requests = self::buildTxnRequest($txn);

            $rt = $client->getChargeAmount($param);
        $result = $rt->return;

        return $result;
    }


    public static function validateTransaction( $txn ){

        $universalId = User::getUniversalId();
        $client = self::getWebService('TransactionGatewayWS');
            $param = new TransactionGatewayWS\validateTransaction();
            $param->uid = $universalId;
            $param->batch = new \TransactionGatewayWS\transactionRequestBatch();
            $param->batch->requests = self::buildTxnRequest($txn);

            $rt = $client->validateTransaction($param);
        $result = $rt->return;

        return $result;
    }

    public static function validateTransactionVelocity( $txnList){

        $universalId = User::getUniversalId();
        $client = self::getWebService('TransactionGatewayWS');
            $param = new TransactionGatewayWS\validateTransactionVelocity();
            $param->uid = $universalId;

        // inistialize the array for the transactios requests
        $requests = array();
        // loop through the txn a list and add each request to the request object
        foreach($txnList as $txn){
            // only add the ones that have not been processed.
            if ($txn["txnProcessRequestId"] == ""){
                // add add this trans to the txn request list
                $requests[] = Trans::buildTxnRequest($txn);
            }
        }

        // add the requests to the param object
        $param->batch = new \TransactionGatewayWS\transactionRequestBatch();
        $param->batch->requests = $requests;
            $rt = $client->validateTransactionVelocity($param);
        $result = $rt->return;

        return $result;
    }

    // process the currency conversions
    public static function getCurrencyConversionRate($sourceCurrency, $targetCurrency){
        $universalId = User::getUniversalId();
        // setup the gateway
        $client = self::getWebService('TransactionGatewayWS');
            $param = new \TransactionGatewayWS\getConversionRate();
            $param->uid = $universalId;
            $param->sourceCurrency = $sourceCurrency;
            $param->targetCurrency = $targetCurrency;

        $rt = $client->getConversionRate($param);
        $result = $rt->return;

        return $result->result;

    }

    // get the count of the transactoin in the session 
    public static function getTxnCount(){

        // pick up the transactions
        $txnOldList =  Shared::data("trans");
        $txnNewList = array();

        // create the new txns list only for the selected status
        for ($index = 0; $index < count($txnOldList); $index++) {
            //c()->alert($index);
            if ($txnOldList[$index]["txnStatus"] == "PENDING") {
                $txnNewList[] = $txnOldList[$index];
            }
        }

        return count($txnNewList) ;

    }


    public static function autoSelectTxnPayee($txnType, $txnPayeeIndex, $txnPayeeDetailIndex){
        // ensure we have the a payee selected
        Shared::data("autoPayeeSelected" , true);
        Shared::data("txnType", $txnType) ;
        Shared::data("txnPayeeIndex" , $txnPayeeIndex) ;
        Shared::data("txnPayeeDetailIndex" , $txnPayeeDetailIndex) ;

        return 1;
    }
    protected function updateQuertString($key, $value){

        $ar = parse_str($_SERVER['QUERY_STRING']);
        $ar[$key] = $value ;
        $qyuery = !empty($ar) ? http_build_query($ar)  : '';
        return $query ;
    }






}

?>
