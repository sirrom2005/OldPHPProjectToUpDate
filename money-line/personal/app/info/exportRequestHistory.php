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
 * Request History Exporter
 */
class RequestHistoryExporter extends SecureWebPageController {

    protected $moduleId = 16; // REQUEST HISTORY

    protected $requestHistory;
    protected $clientAccounts;

    protected function _config(){
        parent::_config();        
        Raxan::loadLangFile("info-module");
        $this->masterTemplate = null; // we don't need a master template for this page
    }

     protected function _load() {
         parent::_load();

        $this->requestHistory = Shared::data("REQUEST_HISTORY");
        $this->clientAccounts = User::getClientAccounts();

        if (isset($this->requestHistory) && count($this->requestHistory) > 0 ) {
            $account = $this->get->textVal("account");
            $downloadType = "csv"; //$data->textVal("downloadType");
            $productType = $this->clientAccounts[$account]["ProductType"];

            // set up the data for export
            $filename = "requestHistory.csv";
            $data = $this->export_ofx_data($downloadType, "moneyline", $this->requestHistory, $productType, $productType, User::getLoginName() );
            $this->send_file_to_client($filename, $data, $downloadType, $account);
            
        } else {
            $script =
                '<html><head><script type="text/javascript">
                    alert("' . Raxan::locale("request.none.print") .'");
                    window.close();
                </script></head></html>';
            $this->dump($script);
        }
    }

    protected function export_ofx_data($style, $actid, $tarray, $productType, $act="PAYPAL", $merchid="COMPANYNAME") {
        if ($style == "csv") {
            $sendback = "\"REQUEST DATE\",\"ACTION DATE\",\"REQUEST TYPE\",\"DETAILS\",\"AMOUNT\",\"STATUS\"\r\n";
            while (list ($key, $val) = each ($tarray)) {
                $val = (array)$val;
                $details = $message =  addslashes(str_replace("\n", '', $val['description']));
                $sendback .= "\"". $val['requesteddate'] ."\",\"". $val['effectivedate']."\",\"". $val['categoryname'] ."\",\"". $details ."\",\"". $val['amount'] ."\",\"". $val['status'] ."\"\r\n";
            }//wend
        }// fi
        return $sendback;
    }//end function export_ofx_data


    //*******************************************************************************//
    // send the file to the client.. pretty simple.
    // usage : send_file_to_client("data.csv", export_to_csv($data));
    //*******************************************************************************//
    protected function send_file_to_client($filename, $data, $downloadType, $account) {
        $this->download($data, $filename);
    }

}

?> 