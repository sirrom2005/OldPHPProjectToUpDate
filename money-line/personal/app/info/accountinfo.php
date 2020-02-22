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
 * Account Information Page
 * @property RaxanElement $accountDetails
 * @property RaxanElement $clientTotals
 */
class AccountInfoPage extends SecureWebPageController {

    protected $moduleId = 19; // ACCOUNT INFO

    protected $currency;
    protected $sanitizer;
    protected $totals = array();
    
    // set up the menu for the page 
    protected function _config(){
        parent::_config();        
        Raxan::loadLangFile("info-module");
        
        $this->mnuItem = "ACINFO";
    }

    // set the view to be used to display the page data
    protected function _indexView(){
        $this->appendView('accountinfo.view.html');
    }

    // set up the data for presentation
    protected function _load() {
        parent::_load();

        $this->sanitizer = Raxan::dataSanitizer();
        $this->sanitizer->enableDirectInput();
        
        $this->currency = Raxan::config("base-currency");

        $clientAccounts = User::getClientAccounts();
        $cnt = count($clientAccounts);

        $this->totals["NetBalance"] = 0;
        $this->totals["AvailableBalance"] = 0;
        $this->totals["UnclearedBalance"] = 0;
        $this->totals["LiensBalance"] = 0;

        // bind the list of accounts to the template
        $this->accountDetails->bind(
                $clientAccounts,
                array(
                    'callback'=>array($this,'layoutCallback'),
                    'removeUnusedTags'=>true,
                    'format'=>array(
                        'CurrentBalance'=>'number:2',
                        'AvailableBalance'=>'number:2',
                        'UnclearedBalance'=>'number:2',
                        'LiensBalance'=>'number:2',
                        'ConvertedCurrentBalance'=>'number:2',
                        'ConvertedAvailableBalance'=>'number:2',
                        'ConvertedUnclearedBalance'=>'number:2',
                        'ConvertedLiensBalance'=>'number:2',
                        'AssetList'=>'html',    // format asset list as html
                        'LinksList'=>'html'     // format links list as html
                    )
                ))->find("tr.accountRow:even")->addClass("lightgray");

        // bind the list of totals to the template
        $this->clientTotals->bind(
                array($this->totals),
                array(
                    'format'=>array(
                        'NetBalance'=>'number:2',
                        'AvailableBalance'=>'number:2',
                        'UnclearedBalance'=>'number:2',
                        'LiensBalance'=>'number:2'
                    ) ));
    }

    // prepare the data for binding
    public function layoutCallback(&$row, $index, $tpl, $type, &$fmt){
        $assetList = $row['AssetList'];
        $liabilityList = $row['LiabilityList'];

        $row['OwnerShipList'] = null;
        $row['AssetList'] = null;
        $row['LiabilityList'] = null;
        $row['LinksList'] = null;

        $row['AccIdx'] = $index;

        $productType = strtoupper( trim($row["ProductType"]) );
        $accountCategory = strtoupper( trim($row["AccountCategory"]) );
        $accountType = strtoupper( trim($row["AccountType"]) );
        
        // create entries for the converted values
        $row['ConvertedCurrentBalance'] = $this->convertValue($row['Currency'], $row['CurrentBalance']);
        $row['ConvertedAvailableBalance'] = $this->convertValue($row['Currency'], $row['AvailableBalance']);
        $row['ConvertedUnclearedBalance'] = $this->convertValue($row['Currency'], $row['UnclearedBalance']);
        $row['ConvertedLiensBalance'] = $this->convertValue($row['Currency'], $row['LiensBalance']);

        $sign = 1;
        if($accountType=="SELLER")$sign = -1;

        // compute totals
        $this->totals["NetBalance"] += ($this->convertValue($row['Currency'],$row['CurrentBalance']) * $sign);
        $this->totals["AvailableBalance"] += ($this->convertValue($row['Currency'],$row['AvailableBalance']) * $sign);
        $this->totals["UnclearedBalance"] += ($this->convertValue($row['Currency'],$row['UnclearedBalance']) * $sign);
        $this->totals["LiensBalance"] += ($this->convertValue($row['Currency'],$row['LiensBalance']) * $sign);

        // Process EMMA accounts
        if($productType=='FUND' && SysInfo::isEquityFund($row['FundNo']) && count($assetList)>0){
            $this->processEmma($row, $index, $assetList);

        }else if($productType=='INVESTOR' && $accountCategory == 'TRADING ACCOUNT' && count($assetList)>0){
            $this->processTrading($row, $index, $assetList);
            
        } else if($productType=='SELLER' && count($liabilityList)>0){
            $this->processSeller($row, $index, $liabilityList);

        } else if($productType=='INVESTOR' && $accountCategory == 'BOND ACCOUNT' && count($assetList)>0){
            $this->processBond($row, $index, $assetList);
        }
        C()->console($row);
    }

    // converts the specified value to the target currency and formats
    // it as a numerical value
    protected function convertValue($currency, $value, $format=false){
        if(empty($value))$value = 0;
        $result = User::convertAmount($currency, $value);
        if($format==true)$result = $this->sanitizer->formatNumber($result,2);

        return $result;
    }

    // attach necessary data for EMMA accoutns
    protected function processEmma(&$row, $index, $assetList){
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
        $links = array();
        // add link to view fills
        $links[0]['label']="<span>View Fills</span>";
        $links[0]['value']="equityFills.php?accountNo=".$index;
        // add link to view orders
        $links[1]['label']="<span>View Orders</span>";
        $links[1]['value']="equityOrders.php?accountNo=".$index;

        $childTempl = $this->bindChildTemplate(
                "accountinfo.aux.html","#linksContainer", "#listOfLinks", $links,
                array(
                    'format'=>array(
                        'label'=>'html',
                        'value'=>'html'
                     ))
                );
        $row['LinksList'] = $childTempl->html();
        //echo $childTempl->html();

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
        $row['AssetList'] = $childTempl->html();
    }

    // attach necessary data for Trading accoutns
    protected function processTrading(&$row, $index, $assetList){
        $cnt = count($assetList);
        
        // get the asset list totals and do some pre-formatting where necessary
        for($i=0; $i < $cnt; $i++){
            $assetList[$i]->purchaseDate = str_replace(':','-',$assetList[$i]->purchaseDate);
            $assetList[$i]->maturityDate = str_replace(':','-',$assetList[$i]->maturityDate);
        }
        $links = array();
        // add link to view maturities
        $links[0]['label']="View Maturities";
        $links[0]['value']="maturities.php?accountNo=".$index;

        $childTempl = $this->bindChildTemplate("accountinfo.aux.html","#linksContainer", "#listOfLinks", $links);
        $row['LinksList'] = $childTempl->html();

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

        $row['AssetList'] = $childTempl->html();
    }
    
    // View All PNOTE Information
    // attach necessary data for Trading accoutns
    protected function processSeller(&$row, $index, $assetList){
        $cnt = count($assetList);

        // get the asset list totals and do some pre-formatting where necessary
        for($i=0; $i < $cnt; $i++){
            $assetList[$i]->asOfDate = str_replace(':','-',$assetList[$i]->asOfDate);
            $assetList[$i]->renewalDate = str_replace(':','-',$assetList[$i]->renewalDate);
        }
        $links = array();
        // add link to view maturities
        $links[0]['label']="View All PNOTE Information";
        $links[0]['value']="viewSellerMaturities.php?accountNo=".$index;

        $childTempl = $this->bindChildTemplate("accountinfo.aux.html","#linksContainer", "#listOfLinks", $links);
        $row['LinksList'] = $childTempl->html();

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

        $row['AssetList'] = $childTempl->html();
    }

    // attach necessary data for Trading accoutns
    protected function processBond(&$row, $index, $assetList){
        $cnt = count($assetList);

        // get the asset list totals and do some pre-formatting where necessary
        for($i=0; $i < $cnt; $i++){
            $assetList[$i]->asOfDate = str_replace(':','-',$assetList[$i]->asOfDate);
            $assetList[$i]->maturityDate = str_replace(':','-',$assetList[$i]->maturityDate);
        }
        $links = array();
        // add link to view maturities
        $links[0]['label']="View Maturities";
        $links[0]['value']="maturities.php?accountNo=".$index;

        $childTempl = $this->bindChildTemplate("accountinfo.aux.html","#linksContainer", "#listOfLinks", $links);
        $row['LinksList'] = $childTempl->html();

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

        $row['AssetList'] = $childTempl->html();
    }
    
    // clean up the presentation before it's sent off to the user
    protected function _prerender() {
        // set up the target currency for the page
        $this['.baseCurrency']->html($this->currency);
        // remove rows where the values are zero and they are clearable
        $this['tr.clearable td:contains(" 0.00")']->parent()->remove();

        $this['.accountRow']->client->hoverClass("softblue");
    }

}
?>
