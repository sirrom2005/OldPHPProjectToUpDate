<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';
require_once PERSONAL_MODEL_PATH.'accountinfo.php';

// @todo: move data code to model
require_once COMMON_SERVICE_PATH.'AccountStatementWSService.php';
use Moneyline\Personal\Model\AccountInfo;
use Moneyline\Personal\Model\AccountStatementDTO;

use Moneyline\Common\Model\SysInfo;
use Moneyline\Common\Model\AccessLog;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;

// @Todo: refactor code.

/**
 * Account Statement
 * @property RaxanElement $account

 * @property RaxanElement $startDate
 * @property RaxanElement $endDate
 */
class StatementPage extends SecureWebPageController {

    protected $moduleId = 17; // STATEMENT
    
    protected $clientAccounts;
    protected $totals = array();
    protected $sanitizer;

    // set up the menu for the page
    protected function _config(){
        parent::_config();
        Raxan::loadLangFile("info-module");
        $this->mnuItem = "STAT";
    }
    
    protected function _indexView(){
        $this->appendView('statement.view.html');
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

            $date = new DateTime();
            $day = $date->format("j");
            
            date_sub($date, new DateInterval("P". $day . "D"));
            $this->endDate->val($date->format("Y-m-d"));

            date_sub($date, new DateInterval("P" . ($date->format("j") - 1) . "D"));
            $this->startDate->val($date->format("Y-m-d"));

            $this->accountInformation();
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

    protected function accountInformation() {
        $index = (int)$this->account->val();
        $accountNo = $this->clientAccounts[$index]["AccountNo"];

        $this->getAccountDetails($accountNo);
    }

    protected function generateStatement($e){
        if($this->validate())
            $this->generate();
    }

    protected function generate(){
        $index = (int)$this->account->val();

        $accountNo = $this->clientAccounts[$index]["AccountNo"];

        $startDate = new DateTime($this->startDate->textVal());
        $startDate = $startDate->format("m/d/Y");

        $endDate = new dateTime($this->endDate->textVal());
        $endDate = $endDate->format("m/d/Y");

        $productType = $this->clientAccounts[$index]["ProductType"];

        Shared::data("ACCOUNT_STATEMENT", null);

        if (strtoupper($productType) == 'FUND') {
            $statementService = Moneyline\Common\DataModel::getWebService('AccountStatementWSService');
 
            $statementDTO = new AccountStatementDTO();
            $statementDTO->accountNo = $accountNo;//1244740;
            $statementDTO->startDate = $startDate;
            $statementDTO->endDate = $endDate;
            $statementDTO->accountType = "Fund"; 
  
            $param = new \AccountStatementWSService\getStatements();
            //$param = new \AccountStatementWSService\getPDFStatement();
            $param->xmlString = $statementDTO->createXML();

            $return = $statementService->getStatements($param);
            //$return = $statementService->getPDFStatement($param);
            $result = $return->return[0];
        }
        else if (strtoupper($productType) == 'INVESTOR'){
            $statementService = Moneyline\Common\DataModel::getWebService('ReportsWSService');

            $statementDTO = new InvestorStatementDTO();
            $statementDTO->accountNo = $accountNo;//23606586;//
            $statementDTO->startDate = $startDate;
            $statementDTO->endDate = $endDate;

            $param = new \ReportsWSService\getInvestorReport();
            $param->xmlString = $statementDTO->createXML();

            $return = $statementService->getInvestorReport($param);
            $result = $return->return[0];
        }
        if ($result->errorCode != 0) { 
            $this->showErrorMessage($result->message);
            return;
        }
        Shared::data("ACCOUNT_STATEMENT", $result->pdfStatement);

        $url = "app/info/generateStatement.php?accountIdx=" . $index . "&start=" . $startDate . "&end=" . $endDate;
        $html = '<iframe src="'.$url.'" width="1" height="1" style="position:absolute;"></iframe>';
        $this->downloadFrame->html($html);
        $this->downloadFrame->updateClient();
    }


    // validates the user input. If any errors are detected
    // a message is thrown back to the user.
    function validate(){
        $errors = array();

        // throw message indicating that this field is date
        if( $this->post->isDate("startDate","Y-m-d" )==false){
            $errors[] = $this->Raxan->locale("trans.missing.startdate");
        }
        // throw message indicating that this field is date
        if( $this->post->isDate( "endDate","Y-m-d" )==false ){
            $errors[] = $this->Raxan->locale("trans.missing.enddate");
        }

        if(!empty ($errors)) {
            $this->postMessage($errors, "My Statement");
        }
        return (count($errors) == 0);
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
        //$msg = print_r($clientAccounts,true);
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
