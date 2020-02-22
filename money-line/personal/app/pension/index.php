<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;


/**
 * Presents Pension information to moneyline users
 * who have pension accounts @ JMMB.
 * 
 * @property RaxanElement $masterSection
 */
class PensionPage extends SecureWebPageController {

    protected $moduleId = 7; // PENSION

    // set up the menu for the page
    protected function _config(){
        parent::_config();
        $this->mnuItem = "PENS";
    }

    protected function _indexView(){
        $this->appendView('pension.view.html');
    }

    protected function _load() {
        parent::_load();

        Raxan::loadLangFile("pension");

        // load the jQuery ui & Scroll To plugin
        $this->loadScript('jquery-ui');
        $this->loadScript('jquery-scrollto');
        // get the user's default account so that it can be set
        $preferences = User::getUserPreferences();

        $getValues = Raxan::dataSanitizer($_GET);
        $pensionMenuId = $getValues->intVal("pensionMenuId");

        // determine which views are to be applied
        if(empty($pensionMenuId))$pensionMenuId = 0;
        $detailsViewList = array(0=>null, 1=>"fundInfo", 2=>"historyInfo");
        $detailsView = $detailsViewList[$pensionMenuId];
        if($pensionMenuId == 0) $mastView = "allInfo";
        else $mastView = "summaryInfo";
        
        $viewTmpl = $this->getView("pension.aux.html", "#$mastView");
        $this->masterSection->html($viewTmpl);
        
        $detailsTmpl = $this->getView("pension.aux.html", "#$detailsView");
        $this->detailSection->html($detailsTmpl);
        $this["#help"]->bind("#click",array(
        "callback"=>".showHelp",
        //"data"=>"login",
        "prefTarget"=>"target@help.php?vuh=pension"
        ));

    }

    protected function findTransactions($e){
        if($this->validate())$this->loadSearchResults();
    }

    // validates the user input. If any errors are detected
    // a message is thrown back to the user.
    function validate(){
        $data = Raxan::dataSanitizer();
        $data->enableDirectInput();
        $errors = array();

        // throw message indicating that this field is date
        $startDate = $this->startDate->textVal();
        if( !empty ($startDate) && !$data->isDate( $startDate,"Y-m-d" ) ){
            $errors[] = "startdate.date";
        }
        // throw message indicating that this field is date
        $endDate = $this->endDate->textVal();
        if( !empty ($endDate) && !$data->isDate( $endDate,"Y-m-d" ) ){
            $errors[] = "enddate.date";
        }

        if(!empty ($errors))$this->postMessage($errors);
        return (count($errors) == 0);
    }

}
?>
