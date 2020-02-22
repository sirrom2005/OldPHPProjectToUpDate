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
 * @property RaxanElement $startDate
 * @property RaxanElement $endDate
 * @property RaxanElement $resultsArea
 * @property RaxanElement $productType
 */
class RequestHistoryPage extends SecureWebPageController {

    protected $moduleId = 16; // REQUEST HISTORY

    protected $clientAccounts;

    // set up the menu for the page
    protected function _config(){
        parent::_config();
        Raxan::loadLangFile("info-module");
        $this->mnuItem = "RQHIST";
    }
    
    protected function _indexView(){
        $this->appendView('requesthistory.view.html');        
        $this->loadScript('jquery-ui');     // load the jQuery ui & Scroll To plugin
        $this->loadScript('jquery-scrollto');
    }

    protected function _load() {
        parent::_load();

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

    protected function loadSearchResults(){
        $index = (int)$this->account->val();
        $accountNo = $this->clientAccounts[$index]["AccountNo"];

        $transactions =
            User::getClientTransactions(
                User::getCustomerId(),
                $this->sortBy->textVal(),
                $this->sortOrder->textVal(),
                $this->noOfTransactions->textVal(),
                '%' . $this->details->textVal() . '%',
                $this->status->textVal(),
                $this->startDate->textVal(),
                $this->endDate->textVal(),
                "",
                $accountNo
            );

        // save an empty array in case no results were returned
        Shared::data("REQUEST_HISTORY", array());

        if(count($transactions->clienttransactions)==0)
            $this->searchResults->html("<tr><td colspan='5'>".$this->Raxan->locale("request.no.records")."</td></tr>");
        else {
            $this->searchResults->bind(
                    $transactions->clienttransactions,
                    array(
                        'format'=>array(
                            'effectivedate'=>'date',
                            'requesteddate'=>'date'
                        )
                    ));
            // save the list of results in case they are to be exported
            Shared::data("REQUEST_HISTORY", $transactions->clienttransactions);
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
            $errors[] = $this->Raxan->locale("request.missing.transcount");
        }
        // throw message indicating that this field is date
        if( $this->post->isDate("startDate","Y-m-d" )==false){
            $errors[] = $this->Raxan->locale("request.missing.startdate");
        }
        // throw message indicating that this field is date
        if( $this->post->isDate( "endDate","Y-m-d" )==false ){
            $errors[] = $this->Raxan->locale("request.missing.enddate");
        }

        if(!empty ($errors)) {
            $this->postMessage($errors, "Request History");
        }
        return (count($errors) == 0);
    }

}
?>
