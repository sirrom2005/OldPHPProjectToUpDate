<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;

// @todo: move code to model

/**
 * Request History Page
 * @property RaxanElement $account
 * @property RaxanElement $noOfTransactions
 * @property RaxanElement $startDate
 * @property RaxanElement $endDate
 * @property RaxanElement $resultsArea
 * @property RaxanElement $details
 */
class RequestHistoryPage extends SecureWebPageController {

    protected $moduleId = 20; // ACCOUNT DETAILS

    protected $clientAccounts;
    protected $totals = array();
    protected $sanitizer;

    // set up the menu for the page
    protected function _config(){
        parent::_config();
        Raxan::loadLangFile("info-module");
        $this->mnuItem = "RQHIST";
    }
    
    protected function _indexView(){
        $this->appendView('accountdetails.view.html');
        $this->loadScript('jquery-ui');     // load the jQuery ui & Scroll To plugin
        $this->loadScript('jquery-scrollto');
    }

    protected function _load() {
        parent::_load();

        $this->sanitizer = Raxan::dataSanitizer();
        $this->sanitizer->enableDirectInput();
        
        $this->clientAccounts = User::getClientAccounts();
        $cnt = count($this->clientAccounts);
         
        // get the user's default account so that it can be set
        $preferences = User::getUserPreferences();
        $defaultAccount = $preferences->defaultAccountNo;
        $defaultAccountIndex = -1;
        
        $selectableAccounts = array(); 
        for($i=0; $i < $cnt; $i++){
            $selectableAccounts[$i]["AccountIndex"]=$i;
            $selectableAccounts[$i]["AccountName"]=$this->clientAccounts[$i]["AccountName"];
            $selectableAccounts[$i]["AccountNo"]=$this->clientAccounts[$i]["AccountNo"];

            if( $this->clientAccounts[$i]["AccountNo"] == $defaultAccount){
                $defaultAccountIndex = $i;
            }
        }  
        $this->account->bind($selectableAccounts);

        //C()->console(User::getUserPreferences());
        if(!$this->isPostBack){
            $this->account->val($defaultAccountIndex);

            if (isset($_GET['AccNo'])){
                if (isset($_GET['AccType']))
                    $this->account->val($this->getAccountPosByType($_GET['AccNo'], $_GET['AccType']));
                else
                    $this->account->val($_GET['AccNo']);
            }

            $this->noOfTransactions->val($preferences->noOfTxns);

            $date = new DateTime();
            $this->endDate->val($date->format("Y-m-d"));

            date_sub($date, new DateInterval("P1M"));
            $this->startDate->val($date->format("Y-m-d"));
            $this->sortBy->val('srtdate');
            $this->sortOrder->val('DESC');

            // load up the initial result set
            $this->loadSearchResults();
        }
    }

    private function getAccountPosByType($AccNo, $AccType) {
        $accPos = 0;
        $accTypes = SysInfo::getAccountDetails();

        // setup filters
        $AccType = ($AccType > 0 )?  $AccType - 1 : $AccType;
        if ($accTypes[$AccType]['productType'] == $accTypes[$AccType]['accountCategory'])
            return $AccNo;

        for ($i = 0; $i< count($this->clientAccounts); $i++) {
            if (strtoupper(trim($this->clientAccounts[$i]['ProductType'])) == $accTypes[$AccType]['productType']
             && strtoupper(trim($this->clientAccounts[$i]['AccountCategory'])) == $accTypes[$AccType]['accountCategory'])
                if ($accPos == $AccNo)
                    return $i;
                else
                    $accPos++;
        }
        return $AccNo;
    }

    protected function findTransactions($e){
        if($this->validate())$this->loadSearchResults();
    }

    protected function getAccountDetails($_accountNo) {
        $clientAccounts = User::getClientAccounts();

        for ($i = 0; $i < count($clientAccounts); $i++) {
            if ($_accountNo == $clientAccounts[$i]['AccountNo']) {

                $this->accountDetails->bind(
                        $clientAccounts[$i],
                        array(
                            'removeUnusedTags'=>true,
                            'format'=>array(
                                'CurrentBalance'=>'number:2',
                                'AvailableBalance'=>'number:2',
                                'UnclearedBalance'=>'number:2',
                                'LiensBalance'=>'number:2',
                            )
                        ));

                $productType = strtoupper(trim($clientAccounts[$i]["ProductType"]) );
                $accountCategory = strtoupper( trim($clientAccounts[$i]["AccountCategory"]) );
                $accountType = strtoupper( trim($clientAccounts[$i]["AccountType"]) );

                $assetList = $clientAccounts[$i]['AssetList'];
                $liabilityList = $clientAccounts[$i]['LiabilityList'];

                if($productType=='FUND' && SysInfo::isEquityFund($clientAccounts[$i]['FundNo']) && count($assetList)>0){
                    $this->processEmma($clientAccounts[$i]);

                }else if($productType=='INVESTOR' && $accountCategory == 'TRADING ACCOUNT' && count($assetList)>0){
                    $this->processTrading($clientAccounts[$i]);

                }else if($productType=='SELLER'&& count($liabilityList)>0){
                    $this->processSeller($clientAccounts[$i]);

                } else if($productType=='INVESTOR' && $accountCategory == 'BOND ACCOUNT' && count($assetList)>0){
                    $this->processBond($clientAccounts[$i]);
                }
            }
        }
        $msg = print_r($clientAccounts,true);
        //$this->showMessage($msg);
    }

    protected function processEmma($row){
        $assetList = $row['AssetList'];

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
                "accountinfo.aux.html","#emmaContainer", "#emmaDetails", $assetList,
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
        $this->AssetList->html($childTempl->html()); 
    }

    protected function processTrading($row){
        $assetList = $row['AssetList'];
 
        $cnt = count($assetList);

        // get the asset list totals and do some pre-formatting where necessary
        for($i=0; $i < $cnt; $i++){
            $assetList[$i]->purchaseDate = str_replace(':','-',$assetList[$i]->purchaseDate);
            $assetList[$i]->maturityDate = str_replace(':','-',$assetList[$i]->maturityDate);
        }
        $links = array();
        // add link to view maturities
        $links[0]['label']="View Maturities";
        //$links[0]['value']="maturities.php?accountNo=".$index;

        //$childTempl = $this->bindChildTemplate("accountinfo.aux.html","#linksContainer", "#listOfLinks", $links);
        //$row['LinksList'] = $childTempl->html();

        // bind the asset list to the emma template
        $childTempl = $this->bindChildTemplate(
                "accountinfo.aux.html", "#tradeContainer", "#tradeDetails", $assetList,
                array(
                    'format'=>array(
                        'maturityDate'=>'date',
                        'netAmountDue'=>'money:2',
                        'purchaseDate'=>'date'
                    ))
                );

        $this->AssetList->html($childTempl->html());
    }

    // View All PNOTE Information
    // attach necessary data for Trading accoutns
    protected function processSeller($row){
        $assetList = $row['LiabilityList'];
        $cnt = count($assetList);

        // get the asset list totals and do some pre-formatting where necessary
        for($i=0; $i < $cnt; $i++){
            $assetList[$i]->asOfDate = str_replace(':','-',$assetList[$i]->asOfDate);
            $assetList[$i]->renewalDate = str_replace(':','-',$assetList[$i]->renewalDate);
        }

        // bind the asset list to the emma template
        $childTempl = $this->bindChildTemplate(
                "accountinfo.aux.html","#sellerContainer", "#tradeDetails", $assetList,
                array(
                    'format'=>array(
                        'asOfDate'=>'date',
                        'renewalAmount'=>'money:2',
                        'renewalDate'=>'date'
                    ))
                );

        $this->AssetList->html($childTempl->html());
    }

    // attach necessary data for Trading accoutns
    protected function processBond($row){
        $assetList = $row['AssetList'];
        $cnt = count($assetList);

        // get the asset list totals and do some pre-formatting where necessary
        for($i=0; $i < $cnt; $i++){
            $assetList[$i]->asOfDate = str_replace(':','-',$assetList[$i]->asOfDate);
            $assetList[$i]->maturityDate = str_replace(':','-',$assetList[$i]->maturityDate);
        }

        // bind the asset list to the emma template
        $childTempl = $this->bindChildTemplate(
                "accountinfo.aux.html","#bondContainer", "#bondDetails", $assetList,
                array(
                    'format'=>array(
                        'asOfDate'=>'date',
                        'maturityValue'=>'money:2',
                        'maturityDate'=>'date'
                    ))
                );

        $this->AssetList->html($childTempl->html());
    }
    

    protected function loadSearchResults(){
        $index = (int)$this->account->val();
        $accountNo = $this->clientAccounts[$index]["AccountNo"];

        $this->getAccountDetails($accountNo);

        $clientService = Moneyline\Common\DataModel::getWebService('CIServiceWS');
        $param = new \CIServiceWS\getAccountTransactions();
        $param->accountNo = $accountNo;
        $param->startDate   = $this->startDate->textVal();
        $param->endDate     = $this->endDate->textVal();
        $param->selObject   = '%' . $this->details->textVal() . '%';
        $param->sortBy     = $this->sortBy->textVal();
        $param->sortOrder   = $this->sortOrder->textVal();
        $param->noOfRows    = $this->noOfTransactions->textVal();

        $return = $clientService->getAccountTransactions($param);

        $result = $return->return;

        // save an empty array in case no results were returned
        Shared::data("REQUEST_HISTORY", array());

        if(count($result)==0)
            $this->searchResults->html("<tr><td colspan='5'>".$this->Raxan->locale("trans.no.records")."</td></tr>");
        else {
            $this->searchResults->bind(
                    $result,
                    array(
                        'format'=>array(
                            'transactionDate'=>'date',
                            'checkAmount'=>'money:2',
                            'commission'=>'money:2',
                            'GCTAmount'=>'money:2',
                            'transactionAmount'=>'money:2'
                        )
                    ));
            // save the list of results in case they are to be exported
            Shared::data("REQUEST_HISTORY", $result);
        }
        return;
    }

    // execute the downloading of the search results
    function executeDownload($e){
        $url = "app/info/exportRequestHistory.php?account=" . $this->account->intVal();
        $html = '<iframe src="'.$url.'" width="1" height="1" style="position:absolute;visibility:hidden;"></iframe>';
        $this->downloadFrame->html($html);
        $this->downloadFrame->updateClient();
    }

    // validates the user input. If any errors are detected
    // a message is thrown back to the user.
    function validate(){
        $errors = array();

        // throw message indicating that this field is numeric
        if( $this->post->isNumeric('noOfTransactions')==false){
            $errors[] = $this->Raxan->locale("trans.missing.transcount");
        }
        // throw message indicating that this field is date
        if( $this->post->isDate("startDate","Y-m-d" )==false){
            $errors[] = $this->Raxan->locale("trans.missing.startdate");
        }
        // throw message indicating that this field is date
        if( $this->post->isDate( "endDate","Y-m-d" )==false ){
            $errors[] = $this->Raxan->locale("trans.missing.enddate");
        }

        if(!empty ($errors)) {
            $this->postMessage($errors, "Request History");
        }
        return (count($errors) == 0);
    }


    // clean up the presentation before it's sent off to the user
    protected function _prerender() {
        // set up the target currency for the page
        //$this['.baseCurrency']->html($this->currency);
        // remove rows where the values are zero and they are clearable
        $this['tr.clearable td:contains(" 0.00")']->parent()->remove();

        //$this['.accountRow']->client->hoverClass("softblue");
    }
}
?>
