<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\SysInfo;
use Moneyline\Common\Model\AccessLog;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;

/**
 * Request History Page
 * @property RaxanElement $account
 * @property RaxanElement $noOfTransactions
 * @property RaxanElement $fundDate
 * @property RaxanElement $endDate
 * @property RaxanElement $resultsArea
 * @property RaxanElement $productType
 */
class InvestmentInfoPage extends SecureWebPageController {

    protected $moduleId = 21; // INVESTMENTINFO

    protected $clientAccounts;

// set up the menu for the page
    protected function _config(){
        parent::_config();
        Raxan::loadLangFile("info-module");
        $this->mnuItem = "ACINFO";
    }
    
    protected function _indexView(){
        $this->appendView('investmentinfo.view.html');
        $this->loadScript('jquery-ui');     // load the jQuery ui & Scroll To plugin
        $this->loadScript('jquery-scrollto');
    }

    protected function _load() {
        parent::_load();

        if (!$this->isPostBack) {
            $fundNo = $this->get->textVal('FundNo');
            $accountNo = $this->get->textVal('AccountNo');
            $accountBal = $this->get->textVal('AccountBalance');

            //$fundDate = GetLastFundRunDate($fundNo);
            
            //$this->fundType->text('Test');

            $date = new DateTime();
            $this->fundDate->val($date->format("Y-m-d"));
        }
        else {
            $fundNo = $this->post->textVal('FundNo');
            $accountNo = $this->post->textVal('accountNumber');
            $accountBal = $this->post->textVal('AccountBalance');
        }
        $this->accountNo->text($accountNo);
        $this->accountNumber->val($accountNo);
        $this->accountBalance->val($accountBal);
        $this->fundNo->val($fundNo);

        $this->loadInvestments();
    }

    private function CreateXMLFA($fundNo, $fundDate) {
        $dom = new DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="UTF-8"?>
            <FundInvestment:FundInvestment xmlns:FundInvestment="http://www.dtinc.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.dtinc.com FundInvestment.xsd">
            <Value-Date></Value-Date>
            <Fund-No></Fund-No>
            </FundInvestment:FundInvestment>');

        $dom->getElementsByTagName('Value-Date')->item(0)->nodeValue = $fundDate;
        $dom->getElementsByTagName('Fund-No')->item(0)->nodeValue = $fundNo;

        return $dom->saveXML();
    }
    
    private function GetFundAssets($fundNo, $fundDate) {

        $xml = $this->CreateXMLFA($fundNo, $fundDate);

        $clientService = SharedDataModel::getWebService('CIServiceWS');
        $param = new \CIServiceWS\GetFundInvestments();
        $param->xml = $xml;
        $return = $clientService->GetFundInvestments($param);

        return $return->return;
    }

    protected function loadInvestments() {
        $FundInvest = $this->GetFundAssets($this->fundNo->val(), $this->fundDate->val());
        if (count($FundInvest) > 0 && trim($FundInvest[0]['FundDescription']) != "")
            $this->fundType->text($FundInvest[0]['fundDescription']." - ".$FundInvest[0]['stockCurrency']);
        else
            $this->fundType->text($this->Raxan->locale("fund.type.notavailable"));

        // save an empty array in case no results were returned
        Shared::data("FUND_INVESTMENT", array());
        $investments = array();
        
        if(count($FundInvest)==0)
            $this->searchResults->html("<tr><td colspan='5'>".$this->Raxan->locale("fund.no.records")."</td></tr>");
        else {
            $accountBal = $this->accountBalance->val();
            foreach ($FundInvest as $investment) {
                $row = array();
                $interestNoted = (float)str_replace(',','',$investment['interestNoted']);
                $fundTotal = (float)str_replace(',','',$investment['fundTotal']);

                $row['investedIn'] = $investment['stockDescription'];
                $row['interestNoted'] = $investment['stockCurrency']." ".$this->sanitizer->formatNumber(($accountBal * $interestNoted) / $fundTotal, 2);

                $investments[] = $row;
            }
            $this->searchResults->bind($investments);
            // save the list of results in case they are to be exported
            Shared::data("FUND_INVESTMENT", $investments);
        }
    }


    protected function findTransactions($e){
        if($this->validate())
            $this->loadInvestments();
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

        // throw message indicating that this field is date
        if( $this->post->isDate("fundDate","Y-m-d" )==false){
            $errors[] = $this->Raxan->locale("fund.missing.funddate");
        }
        // throw message indicating that this field is date

        if(!empty ($errors)) {
            $this->postMessage($errors, "Fund Investments");
        }
        return (count($errors) == 0);
    }

}
?>
