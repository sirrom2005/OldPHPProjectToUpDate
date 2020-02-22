<?php

namespace Moneyline\Personal\Model;

// web services
require_once \COMMON_SERVICE_PATH.'CIServiceWS.php';

use Moneyline\Personal\Shared;


// @TODO: Refactor Moneyline\Common\Model\AccountInfo and Moneyline\Personal\Model\AccountInfo code
// For now they are the same

/**
 * Account Data Model
 * This model contains commonly used functions for the account information
 */
class AccountInfo extends \Moneyline\Common\DataModel {

    /* Get account information from array - User::getClientAccounts()
     *
     */
    public static function getAccountFromArry($account, $accountArray) {
        $accountInfo = array();
        $cnt = count($accountArray);

        for ($i = 0; $i < $cnt; $i++) {
            if ($account == $accountArray[$i]["AccountNo"])
                return $accountArray[$i];
        }
        return $accountInfo;
    }

    public static function getInvestorMaturities($AccountNo){

        $accountNo = (double)$AccountNo;

	$dataTypes = array();
	$dataTypes[0]		= 'long';

        /** @var $client \CIServiceWS\CIServiceWS */
        $client = self::getWebService('CIServiceWS');
            $param = new \CIServiceWS\getInvestorMaturity();
            $param->accountNo = $accountNo;
        $rt = $client->getInvestorMaturity($param);
        $service_result = $rt->return;


        /*
	for ($i = 0; $i < count($service_result) && is_array($service_result); $i++){
		$MaturityDetails[$i][0]         = $service_result[$i]['matured'];
		$MaturityDetails[$i][1]         = date('d-M-Y', strtotime($service_result[$i]['issueDate']));
		$MaturityDetails[$i][2]         = date('d-M-Y', strtotime($service_result[$i]['maturityDate']));
		$MaturityDetails[$i][3]         = $service_result[$i]['days'];
		$MaturityDetails[$i][4]         = $service_result[$i]['currency'];
		$MaturityDetails[$i][5]         = number_format($service_result[$i]['amountInvested'],2);
		$MaturityDetails[$i][6]         = $service_result[$i]['yield'];
		$MaturityDetails[$i][7]         = number_format($service_result[$i]['amountDueAtMaturity'],2);
		$MaturityDetails[$i][8]         = number_format($service_result[$i]['netInterest'],2);
		$MaturityDetails[$i][9]         = number_format($service_result[$i]['netAmountDue'],2);
		$MaturityDetails[$i][10]        = number_format($service_result[$i]['taxWithHeld'],2);
		$MaturityDetails[$i][11]        = number_format($service_result[$i]['taxRate'],2)."%";
		$MaturityDetails[$i][12]        = number_format($service_result[$i]['grossInterest'],2);
		$MaturityDetails[$i][13]        = $service_result[$i]['taxStatus'];

		$MaturityDetails[$i]['tradeNo']     = $service_result[$i]['tradeNo'];
		$MaturityDetails[$i]['prevTradeNo'] = $service_result[$i]['previousTradeNo'];
		$MaturityDetails[$i]['issueDate']	= date('m/d/Y', strtotime($service_result[$i]['issueDate']));
	}
         * */

        //
        $MaturityDetails = $service_result ;

	return $MaturityDetails;
    }
}

// @TODO: Refactor code - Prefix classes with "Account"

/**
 *@property double accountNo
 *
 */
class fundEncashmentDTO {
    public $requestNo = 0;
    public $cyclePeriod	= "";
    public $startDate = "NULL";
    public $endDate = "NULL";
    public $accountNo;
    public $amount;
    public $amountType = "FIXED";
    public $payee = "";
    public $address1 = "";
    public $address2 = "";
    public $parish = "";
    public $country = "";
    public $abaNo = "";
    public $routingNo = "";
    public $transferBankName = "";
    public $transferBankAccount	= "";
    public $transferDetails = "";
    public $paymentMethod = "";
    public $deliveryMethod = "";
    public $securityKey	= "";
    public $branchAssigned = "";
    public $chargeCommission = "true";
    public $authorized	= "false";
    public $description = "";
    public $assignedTo	= "";
    public $loggedBy = "";
    public $actionDate;

    public function createXML() {
        $dom = new DOMDocument();
        $dom->loadXML('<?xml version="1.0" encoding="UTF-8"?>
            <cs:FundEncashment xmlns:cs="http://www.dtinc.com" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.ibm.com FundEncashment.xsd">
                <requestNo></requestNo>
                <cycle>
                    <cycleperiod></cycleperiod>
                    <startDate></startDate>
                    <endDate></endDate>
                </cycle>
                <account>
                    <accountNo></accountNo>
                    <amount></amount>
                </account>
                <amountType></amountType>
                <payee>
                    <name></name>
                    <address1></address1>
                    <address2></address2>
                    <parish></parish>
                    <country></country>
                    <abaNo></abaNo>
                    <rountingNo></rountingNo>
                    <transferBankName></transferBankName>
                    <transferBrankAccount></transferBrankAccount>
                    <transferDetails></transferDetails>
                    <paymentMethod></paymentMethod>
                    <deliveryOption></deliveryOption>
                </payee>
                <securityKey></securityKey>
                <branchAssigned></branchAssigned>
                <chargeCommission></chargeCommission>
                <authorized></authorized>
                <description></description>
                <assignedTo></assignedTo>
                <loggedby></loggedby>
                <actionDate></actionDate>
            </cs:FundEncashment>');

        $dom->getElementsByTagName('requestNo')->item(0)->nodeValue = $this->requestNo;
        $dom->getElementsByTagName('cycleperiod')->item(0)->nodeValue = $this->cyclePeriod;
        $dom->getElementsByTagName('startDate')->item(0)->nodeValue = $this->startDate;
        $dom->getElementsByTagName('endDate')->item(0)->nodeValue = $this->endDate;
        $dom->getElementsByTagName('accountNo')->item(0)->nodeValue = $this->accountNo;
        $dom->getElementsByTagName('amount')->item(0)->nodeValue = $this->amount;
        $dom->getElementsByTagName('amountType')->item(0)->nodeValue = $this->amountType;
        $dom->getElementsByTagName('name')->item(0)->nodeValue = $this->payee;
        $dom->getElementsByTagName('address1')->item(0)->nodeValue = $this->address1;
        $dom->getElementsByTagName('address2')->item(0)->nodeValue = $this->address2;
        $dom->getElementsByTagName('parish')->item(0)->nodeValue = $this->parish;

        $dom->getElementsByTagName('paymentMethod')->item(0)->nodeValue = $this->paymentMethod;
        $dom->getElementsByTagName('deliveryOption')->item(0)->nodeValue = $this->deliveryMethod;

        $dom->getElementsByTagName('securityKey')->item(0)->nodeValue = $this->securityKey;
        $dom->getElementsByTagName('branchAssigned')->item(0)->nodeValue = $this->branchAssigned;
        $dom->getElementsByTagName('chargeCommission')->item(0)->nodeValue = $this->chargeCommission ? 'true' : 'false';
        $dom->getElementsByTagName('authorized')->item(0)->nodeValue = $this->authorized ? 'true' : 'false';
        $dom->getElementsByTagName('assignedTo')->item(0)->nodeValue = $this->assignedTo;
        $dom->getElementsByTagName('loggedby')->item(0)->nodeValue = $this->loggedBy;
        $dom->getElementsByTagName('actionDate')->item(0)->nodeValue = date('m/d/Y', strtotime($this->actionDate));

        return $dom->saveXML();
    }
}

class AccountStatementDTO {
    public $accountType = "Fund";
    public $accountNo = "";
    public $investorRequestNo = "";
    public $tradeNo = "";
    public $prevTradeNo = "";
    public $issueDate = "";
    public $startDate = "";
    public $endDate = "";
    public $outputFormat = "PDF";

    public function createXML() {
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<Statements>' ;
        $xml .= '   <Statement type="' . $this->accountType . '">';
        if ($this->accountNo != '')
            $xml .= '   <accountNo>' . $this->accountNo . '</accountNo>';
        if ($this->investorRequestNo != '')
            $xml .= '   <investorRequestNo>' . $this->investorRequestNo . '</investorRequestNo>';
        if ($this->tradeNo != '')
            $xml .= '   <tradeNo>'. $this->tradeNo . '</tradeNo>';
        if ($this->prevTradeNo)
            $xml .= '   <prevTradeNo>' . $this->prevTradeNo . '</prevTradeNo>';
        if ($this->issueDate != '')
            $xml .= '   <issueDate>'. $this->issueDate . '</issueDate>';
        if ($this->startDate != '' || $this->endDate != '') {
            $xml .= '   <Period>';
            $xml .= '       <start>' . $this->startDate . '</start>';
            $xml .= '       <end>' . $this->endDate . '</end>';
            $xml .= '   </Period>';
        }
        $xml .= '   <outputFormat>' . $this->outputFormat . '</outputFormat>';
        $xml .= '   </Statement>';
        $xml .= '</Statements>';

        return $xml;
    }
}


class InvestorStatementDTO {
    public $tradeNo = "";
    public $accountNo = "";
    public $startDate = "";
    public $endDate = "";
    public $branch = "";
    public $mailCode = "";
    public $currentAddress = "";

    public function createXML() {
	$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
	$xml .= "<reports:reports xmlns:reports=\"http://www.dtinc.com\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.dtinc.com reports.xsd \">";
        if ($this->startDate != "")
            $xml .= "<Start-Date>" . $this->startDate . "</Start-Date>";
        if ($this->endDate != "")
            $xml .= "<End-Date>" . $this->endDate . "</End-Date>";
        if ($this->tradeNo != "")
            $xml .= "<Trade-No>" .  $this->tradeNo . "</Trade-No>";
        if ($this->accountNo != "")
            $xml .= "<Account-No>" . $this->accountNo . "</Account-No>";
        if ($this->branch != "")
            $xml .= "<Branch>" . $this->branch . "</Branch>";
        if ($this->mailCode != "")
            $xml .= "<Mail-Code>" . $this->mailCode . "</Mail-Code>";
        if ($this->currentAddress != "")
            $xml .= "<Current-Address>" . $this->currentAddress . "</Current-Address>";
	$xml .= "</reports:reports>";

        return $xml;
    }
}
?>
