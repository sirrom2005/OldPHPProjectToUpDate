<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';
require_once PERSONAL_MODEL_PATH.'payeemodel.php';

use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\Model\PayeeModel;
use Moneyline\Personal\SecureWebPageController;


class PayeeMaintenacePage extends SecureWebPageController {

    protected $moduleId = 4; // PAYEE

    const ERROR_MSG_USER_PREFERENCES_NOT_SAVED      ="USERPREFERENCESNOTSAVED";
    const SAVED_MSG_USER_PREFERENCES_SAVED          ="UserPreferencesSavedMessage";
    const ERROR_MSG_USER_PREFERENCES_SV_FAILED       ="USERPREFERENCESVFAILED";
    const EMAIL_MSG_EMAIL_VERIFICATION_SENT         ="EMAILSECUIRTYKEY";
    const ERROR_MSG_EMAIL_SECUIRTY_KEY_UP              ="EMAILSECUIRTYKEYUP";

    const LANG_FILE_NAME                                ="PayeeMaintenance";
    const ERROR_FILE_NAME                               ="errors";
    const DATA_USER                                     ="user";
    const DATA_PAYEE_DETAILS                            ="payeedetails";
    const DATA_PAYEE                                    ="payee";
    const DATA_LOGIN_NAME                               ="login-name";
    const DATA_PAYEE_DETAILS_KEY                        ="payee-details-key";

    const TRANSACTION_TYPE_INT                          ="INT";
    const TRANSACTION_TYPE_ENC                          ="ENC";
    const TRANSACTION_TYPE_LWR                          ="LWR";
    const TRANSACTION_TYPE_IWR                          ="IWR";

    const ACL_ALLOW_CHEQUE_ENCHASEMENT                  ="aclAllowCheques";
    const ACL_ALLOW_LOCAL_WIRES                         ="aclAllowLocalWires";
    const ACL_ALLOW_INTERNATIONAL_WIRES                 ="aclAllowInternationalWires";
    const ACL_ALLOW_INTERNAL_TRANSFERS                  ="aclAllowInternalTransfers";

    const PAYEE_SESSION_KEY                             = "payeeTempData";

    protected function _config()
    {
        parent::_config();
        $this->mnuItem = "PAYE";
    }

    protected function _init() {
        parent::_init();

        $this->loadScript("jquery-ui");     // load the jQuery ui & Scroll To plugin
        $this->loadScript("jquery-scrollto");

        $this->loadScript("app/payee/views/payee.js", true);
        $this->loadCSS("app/payee/views/payee.css", true);
    }

    protected function _load()
    {
        parent::_load();

        // @todo: Refactor code. Events should not be registered as @global
        $this->sanitizer = Raxan::dataSanitizer();
        $this->sanitizer->enableDirectInput();
        $this->registerEvent("edit-payee-details@global",".editPayeeDetails");
        $this->registerEvent("show-bank-branches@global", ".showBankBranches");
        $this->registerEvent("edit-payee@global", ".editPayee");
        $this->registerEvent("delete-payee@global", ".deletePayee");
        $this->registerEvent("show-payee-details@global", ".showPayeeDetails");

        if(! $this->isAjaxRequest)
        {
            //$this->loadData();
        }
    }

    protected function _indexView()
    {
        $this->appendView('payee.view.php');

        //clear out this session if present
        //Shared::removeData(PAYEE_SESSION_KEY, $tempData);
        
        $payees = $this->buildPayees();
        $payeeID="";

        if($payees)
        {
            foreach($payees as $mypayee)
            {
                $payeeID = $mypayee->id;
                $payeeListDetails = $this->buildPreAuthorizedPayeeDetails($payeeID);
                $this->callScriptFn("buildPayeeDetailsList", $payeeID, $payeeListDetails);
            }

            $this->payeeList->bind($payees);
        }

        if(!$this->hasUserPreferences(self::ACL_ALLOW_INTERNATIONAL_WIRES) ||
           !$this->hasUserPreferences(self::ACL_ALLOW_CHEQUE_ENCHASEMENT) ||
           !$this->hasUserPreferences(self::ACL_ALLOW_INTERNAL_TRANSFERS) ||
           !$this->hasUserPreferences(self::ACL_ALLOW_LOCAL_WIRES)
           )
        {
           //prevent the user from add, remove or edit payee information
           $this["#addpayee"]->hide();
           $this["#modifyoptions"]->hide();
        }
    }

    protected function _addNewPayeeView()
    {
        $this->appendView('payeeNew.view.php');


        if(!$this->hasUserPreferences(self::ACL_ALLOW_INTERNAL_TRANSFERS) ||
           !$this->hasUserPreferences(self::ACL_ALLOW_LOCAL_WIRES)
           )
        {
           //prevent the user from add, remove or edit payee information
           $this[".accvalidate"]->hide();
           $this[".accvalidate"]->hide();
        }
    }

    protected function _approvedCompanyView()
    {
        $this->appendView('approvedCompany.view.php');

        $companies = SysInfo::getApprovedCompanys();
        $companies[]= Array ( "AppCompanyNo" => "-1", "AppCompanyCode" => "", "AppCompanyName" => " All Companies" ,"PayeeAddress1" => "", "PayeeAddress2" => "", "PayeeParish" => "", "PayeeCountry" => "", "Currency" =>"", "PaymentMethod" =>"", "RefInternalAccountNo" => -1 ,"TransferBankName" => "","TransferBankAccount" => "", "ABANo" => "", "RoutingNo" =>"" );

        uasort($companies,"companiesCMP");

        $this->selNewPreDefinedCompany->bind($companies);
    }

    protected function _payeeSetupVerficationView()
    {
        $this->appendView('payeeSetupVerfication.view.php');
    }

    protected function _jmmbAccountView()
    {
        $this->appendView('jmmbAccount.view.php');
    }

    protected function addNewPayee()
    {
        $this->redirectToView("addNewPayee");
    }

    protected function payeeSetupVerfication()
    {
        //save the information on this page before redirecting
        //$tempData = Array("postedView"=>"approvedCompany","data"=>$this->post);

        //$this->data(PAYEE_SESSION_KEY, $tempData);

        $this->redirectToView("payeeSetupVerfication");
    }

    protected function addApprovedCompany()
    {
        $this->redirectToView("approvedCompany");
    }

    protected function saveNewPayeeSetup()
    {
        //save the information on this page before redirecting
        $tempData = Array("postedView"=>"newPayeeSetup","data"=>$this->post);

        Shared::data(PAYEE_SESSION_KEY, $tempData);
        
        switch($this->post->textVal("rdAddNewAcInfo"))
        {
            case "chequeEncashment":
                break;

            case "otherjmmbaccount":
                $this->redirectToView("jmmbAccount");
                break;

            case "rdAddNewAcInfo":
                break;

            case "rdAddNewAcInfo":
                break;

        }
    }
    
    protected function hasUserPreferences($pref)
    {
        try
        {
            $userpreference =   User::getUserPreferences();

             return $userpreference->{$pref} == 1 || $userpreference->{$pref} = 3;
        }
        catch(Exception $e1)
        {
            return false;
        }
    }

    protected function buildPayees()
    {
        $payees = PayeeModel::getPayees();

        if($payees)
        {
            $companies = SysInfo::getApprovedCompanys();

            foreach($payees as $payee)
            {
                if($payee->approvedCompanyNo)
                { // find company information
                    foreach($companies as $company)
                    {
                        if($payee->approvedCompanyNo == $company["AppCompanyNo"])
                        {
                            $payee->name        = $company["AppCompanyName"];
                            $payee->description = $company["AppCompanyName"];

                            break;
                        }
                    }
                }
            }
        }
        
        return $payees;
    }

    protected function buildPreAuthorizedPayeeDetails($payeeID)
    {
        $payeeDetails = PayeeModel::getPreAuthorizedPayeeDetails($payeeID);

        if($payeeDetails)
        {
            uasort($payeeDetails,"preAuthorizedDetailsCMP");

            $pdetails="";
            foreach($payeeDetails as $payeeDetail)
            {
                $pdetails.='<div class="dotted-border-bottom detail-row clear " style=""><span class="policy-col left" style="width:500px;">'.$payeeDetail->alias.'</span>';
                if(     ($payeeDetail->tranTypeCode == self::TRANSACTION_TYPE_INT && $this->hasUserPreferences(self::ACL_ALLOW_INTERNAL_TRANSFERS)) ||
                        ($payeeDetail->tranTypeCode == self::TRANSACTION_TYPE_IWR && $this->hasUserPreferences(self::ACL_ALLOW_INTERNATIONAL_WIRES)) ||
                        ($payeeDetail->tranTypeCode == self::TRANSACTION_TYPE_ENC && $this->hasUserPreferences(self::ACL_ALLOW_CHEQUE_ENCHASEMENT))  ||
                        ($payeeDetail->tranTypeCode == self::TRANSACTION_TYPE_LWR && $this->hasUserPreferences(self::ACL_ALLOW_LOCAL_WIRES))
                        )
                $pdetails.='<span class="policy-col right" style="width:80px; text-align: right;"><a  data-event-value="'.$payeeID.'_'.$payeeDetail->id.'"  class="edit bold redcolor">edit</a> <input type="checkbox" class="chkpayeedetails" data-event-value="'.$payeeID.'_'.$payeeDetail->id.'"></span>';
                $pdetails .='</div>';
            }
        }
        return $pdetails;
    }
}

function companiesCMP($a, $b)
{

    if($a["AppCompanyName"] == $b["AppCompanyName"])
        return 0;
   return ($a["AppCompanyName"] < $b["AppCompanyName"]? -1:1);

}

function countriesCMP($a, $b)
{

    if($a["name"] == $b["name"])
        return 0;
   return ($a["name"] < $b["name"]? -1:1);

}

function banksCMP($a, $b)
{

    if($a["description"] == $b["description"])
        return 0;
   return ($a["description"] < $b["description"]? -1:1);

}

function preAuthorizedDetailsCMP($a, $b)
{

    if($a->alias == $b->alias)
        return 0;
   return ($a->alias < $b->alias ? -1:1);

}
?>
