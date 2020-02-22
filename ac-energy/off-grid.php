<?php
//set_time_limit(0);
//ini_set("memory_limit","64M");
require_once 'raxan/pdi/autostart.php';
class Index extends common{
    protected $usdToJmdValue;
    protected $kWhJmdValue;
    protected $kWhUsdValue;
    protected $derateFactor;
    protected $cost;
    protected $postKey;
    protected $dcRatingTotal = 0;
    protected $sect = 2;
    protected $solarcost;
    protected $montlypayment;
    protected $avgPower;
    protected $fullname;
    protected $address;
    protected $annualIncreaseINkwhRate; 
    protected $annualInflationRate;
    protected $kwhTotal;
    protected $repaymentYear;

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'offgrid.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $this->loadRoofType();
        $rs = $this->db->table("app_options opt_key, opt_value","id IN (1,2,3,4,5,6,7,8)");
        $opt = array();
        foreach($rs as $k => $v){
            $opt[$v['opt_key']] = $v['opt_value'];
        }

        $this->usdToJmdValue    = $opt['exchange_rate'];
        $this->kWhJmdValue      = $opt['kwh_rate_jmd'];
        $this->kWhUsdValue      = $opt['kwh_rate_usd'];
        $this->derateFactor     = $opt['derate_factor'];
        //$this->solarcost        = $opt['solar_power_cost_usd']; 
        //$this->montlypayment    = $opt['montly_payments_jmd'];
        $this->annualIncreaseINkwhRate = $opt['annual_increase_in_kwh_rate']; 
        $this->annualInflationRate     = $opt['annual_inflation_of_jamaican_dollar'];
        $this->cost = 40;
        $this->delegate("#btn", "click", array('callback' => '.post', 'autoToggle' => '#imgloader'));
        $this->findname->bind('#keyup',array(
                'callback' => '.ajaxNameSearch',
                'delay' => false,
                'autoToggle' => '',
                'serialize' => '#findname',
                'inputCache' => true
            ));
        $this->delegate("a.clientidlink", "#click", null,'.addSelectedClient');
    }
    
    protected function _prerender() {
        parent::_prerender();
        $this->loadClients();
    }
            
    protected function loadRoofType(){
         $rs = $this->db->table("roof_type");
         //$t[]= array('id' => 0, 'name' => 'None');
         //$rs = array_merge($t,$rs);
         $this['#rooftype']->bind($rs);
    }
            
    protected function post(){
        $post                 = $this->post;
        $this->postKey        = date("Ymds").rand(100,999);        
        $section              = $post->intVal("section");
        $findname             = $post->textVal("findname");
        $data['clientid']     = $post->textVal("clientid");
        $data['placetype']    = $post->textVal("placetype");
        $data['notes']        = $post->textVal("notes");
        $data['filename']     = $this->postKey;      
        $data['length']       = $post->intVal("length");
        $data['width']        = $post->intVal("width");
        $data['layout2x3columns'] = $post->textVal("layout2x3columns");
        $data['rooftype']     = $post->intVal("rooftype");
        $data['wire_between_arrary_inverter']      = $post->textVal("wire_between_arrary_inverter");
        $data['where_will_the_inverter_be_placed'] = $post->textVal("where_will_the_inverter_be_placed");
	$data['total_cost_of_system']              = $post->floatVal("total_cost_of_system");
        $data['date_added']   = date("Y-m-d H:i:s");
         
        $dc_rating  = $post->floatVal("dc_rating");
        $pitch      = $post->floatVal("pitch");
        $bearing    = $post->floatVal("bearing");
        $inverter   = $post->textVal("inverter");
        $roofwiresection = $post->textVal("roofwiresection");
       
        $valid = true;
        if(empty($findname)        ){$valid = false;$this->findname->css('border','solid 1px #c00');}
        if(empty($data['clientid'])){$valid = false;$this->clientid->css('border','solid 1px #c00');}
	if(empty($data['total_cost_of_system'])){$valid = false;$this->total_cost_of_system->css('border','solid 1px #c00');}
		
        if(!$valid)
        {
           $msg = "Missing information.";
           $this->flashmsg($this->icon.$msg,'fade','rax-box error','flashfrm');
           $this->clientid->updateClient();
           $this->findname->updateClient();
           $this->total_cost_of_system->updateClient();
           return false;
        }
        
        $this->solarcost = $data['total_cost_of_system'];
        
        if(!is_dir(dirname(__FILE__)."/tmp/$this->postKey/")){
            mkdir('tmp/'.$this->postKey, 0755);
        }
        
        for($i=1;$i<=3;$i++){
            $ext = explode('.', $this->post->fileOrigName("img_upload{$i}"));
            if(!empty($ext[0])){
                try {
                    $filename = 'PHOTO_'.rand(10001,99999).'.'.$ext[count($ext)-1];
                    $imgFile = dirname(__FILE__)."/tmp/$this->postKey/".$filename;
                    $this->post->fileMove("img_upload{$i}",$imgFile);
                }catch (Exception $err) {
                    $msg = 'Unable to process image file.';
                    $this->flashmsg($msg.$err,'fade','pad softred');
                }
            }
        }

        $exData = array();
        try{
            foreach($section as $k => $arrKey){
                $url = "http://rredc.nrel.gov/solar/calculators/pvwatts/version1/International/pvwattsv1_intl.cgi?wban=785830&city=Belize+Intl+Airport&state=BLZ&lat=17.53&lng=-88.3&lngdir=W&elv=5&origin=SWERA&tz=-6&dcrate=".$dc_rating[$k]."&derate=".$this->derateFactor."&mode=0&tilt=".$pitch[$k]."&sazm=".$bearing[$k]."&cost=".$this->cost."&currency=0";
                $searchPage = new RaxanWebPage($url);
                $titles = $searchPage->find('table');

                $html = P($titles->get(3))->html();
                $html = str_replace("</font>", "", $html);
                $html = explode('<font size="3">', $html);
                unset($html[count($html)-1]);
                unset($html[count($html)-1]);
                unset($html[count($html)-1]);
                unset($html[count($html)-1]);
                unset($html[0]);
                unset($html[1]);
                unset($html[2]);
                unset($html[3]);
                unset($html[4]);
                $i=1;
                $step=7;
                foreach($html as $row){
                    $exData[$arrKey][$i] = (float)trim(strip_tags($html[$step]));
                    $step+=4;
                    if($i==12){break;}
                    $i++;
                }
                $this->dcRatingTotal += $dc_rating[$k];
                
                $inputs[$k]['dc_rating']      = $dc_rating[$k];  
                $inputs[$k]['array_title']    = $pitch[$k];
                $inputs[$k]['array_azzimuth'] = $bearing[$k];
                $inputs[$k]['roof_to_inverter'] = $inverter[$k];
                $inputs[$k]['wire_between_roof_section'] = $roofwiresection[$k];
            }

            /*$exData[0] = array(271,280,343,331,317,286,313,312,296,292,270,271);
            $exData[1] = array(299,421,644,331,317,122,221,324,296,292,270,299);
            $exData[2] = array(271,121,343,555,317,286,313,121,296,292,270,271);
            $exData[3] = array(100,180,243,331,22,286,333,312,221,292,270,100);*/
                        
            $rt = $this->db->table("clients CONCAT(title,' ',firstname,' ',lastname) AS fullname,address",'id=?',$data['clientid']);
            $this->fullname = $rt[0]['fullname'];
            $this->address  = str_replace("\r\n", "<br>", $rt[0]['address']);

            $table = $this->calculatePowerUsage($exData);
            $this->calculateROIvalues();
            $this->getTemplateText($data,$table,$inputs);         
            Raxan::removeData('clientId');
            $this->pvFromInputs($findname,$inputs,$data);
        }catch(Exception $ex)
        {
            $msg = $ex;
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
    protected function getTemplateText($data,$table,$inputs){
        $rs = $this->db->execQuery("select detail from template_text where id in (8,10,11,12)");
        $this->dcRatingTotal = number_format($this->dcRatingTotal, 2, '.', ',');
        $date  = date("j")."<sup>".date("S")."</sup> ".date("F, Y").".<br>";
        $data['text0'] = '  <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <p align="center"><img src="views/images/page-logo.jpg" /></p>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <h1 align="center">Off Grid Solar Power System Proposal</h1>
                            <h1 align="center">For</h1>
                            <h1 align="center">'.trim($this->fullname).'</h1>
                            <p>&nbsp;</p>
                            <p>&nbsp;</p>
                            <h3 align="center">Date: '.$date.'</h3>';
        $text1 = str_replace('_CLIENTADDRESS_', trim($this->address), $rs[0]['detail']);
        $text1 = str_replace('_CLIENTNAME_', trim($this->fullname), $text1);
        $text1 = str_replace('_RESIDENTTYPE_', $data['placetype'], $text1);
        $text1 = str_replace("_AVGPOWER_", $this->avgPower, $text1);
        $data['text1'] = str_replace('_DCRATING_',$this->dcRatingTotal, $date.$text1); 
              
        $text5 = str_replace('_PLATECAP_',$this->dcRatingTotal,$rs[2]['detail']);
        $text5 = str_replace('_PLATECAPKILO_',number_format($this->dcRatingTotal*1000,0,'.',','),$text5);
        $text5 = str_replace('_COSTOFSYSTEMUNIT_',number_format($this->solarcost,2,'.',','),$text5);
        $text5 = str_replace('_AVGPRODUCTIONRATE_',number_format($this->kwhTotal,0,'.',','),$text5);
        $text5 = str_replace('_AVGKWHRATEUSD_',number_format($this->kWhUsdValue,2,'.',','),$text5);
        $text5 = str_replace('_ANNUALINCREASERATE_',$this->annualIncreaseINkwhRate.'%',$text5);
        $text5 = str_replace('_REPAYMENT_',$this->repaymentYear,$text5);
        $data['text5'] = str_replace('_ANNUALINFLATION_',$this->annualInflationRate.'%',$text5);
        $data['text6'] = '<p align="center"><img src="tmp/'.$this->postKey.'/pv-cash-flow.jpg" border="1" /></p>';
        
        $text2 = str_replace('_DCRATING_', $this->dcRatingTotal, $rs[1]['detail']);
        $text2 = str_replace('_SOLARCOST_', '$'.number_format($this->solarcost,2,'.',','), $text2);
        $data['text2'] = str_replace('_SOLARMONTLTYPAYMENT_', $this->montlypayment, $text2);
        $data['text3'] = str_replace('_SYSUSERNAME_', Raxan::data('loginFullname').'<br>'.Raxan::data('loginPosition'), $rs[3]['detail']);
        
        $data['text4'] = '<p align="center">
                          <p><img src="tmp/'.$this->postKey.'/g2'.$this->postKey.'.jpg" border="1" /></p>
                          <img src="tmp/'.$this->postKey.'/g1'.$this->postKey.'.jpg" border="1" />
                          <br>'.$table.'<br>';
        
        try{
            $notes = $data['notes'];
            unset($data['notes']);
            $this->db->tableInsert("off_grid_quote_list",$data);
        }catch(Exception $err) {
            $msg = 'Error adding quote.';
            $this->flashmsg($msg.$err,'fade','pad softred');
        }
           
        try{
            $id = $this->db->lastInsertId();
            foreach($inputs as $key => $values){
                $values['quote_id'] = $id;
                $values['`key`'] = $key+1;
                $values['`notes`'] = $notes;
                $this->db->tableInsert("off_grid_section_quote",$values);
            } 
        }catch(Exception $err) {
            $msg = 'Error adding quote.';
            $this->flashmsg($msg.$err,'fade','pad softred');
        }
    }
    
    protected function calculatePowerUsage($exData){
        $this->kwhTotal = 0;
        $idx = 0;
        foreach($exData as $row){
            $i=0;
            foreach($row as $key => $value){
                $jmdPowerValue[$idx][$i] = $value * $this->kWhJmdValue;
                $kwhProd[$idx][$i] = $value;
                $i++;
            }
            $idx++;
        }
        
        $b1Query = array();
        $b2Query = array();
        $jmdPowerValueTotal = 0;
        $usdPowerValueTotal = 0;
        $dataTable = "<tr>
                        <th>Month</th>
                        <th>kWh Production</th>
                        <th>Estimated Dollar Value of Power Produced @ JMD $".$this->kWhJmdValue."/kWh</th>
                        <th>Estimated Dollar Value of Power Produced (USD) ".$this->kWhUsdValue."/kWh</th>
                      </tr>";
        for($i=0;$i<12;$i++){
           $jaSum1 = isset($jmdPowerValue[0][$i])? $jmdPowerValue[0][$i]:0;
           $jaSum2 = isset($jmdPowerValue[1][$i])? $jmdPowerValue[1][$i]:0;
           $jaSum3 = isset($jmdPowerValue[2][$i])? $jmdPowerValue[2][$i]:0;
           $jaSum4 = isset($jmdPowerValue[3][$i])? $jmdPowerValue[3][$i]:0;
           $jmdPowerTotalValue = $jaSum1 + $jaSum2 + $jaSum3 + $jaSum4;
           $b1Query[$i] = $jmdPowerTotalValue;
                     
           $kwhProd1 = isset($kwhProd[0][$i])? $kwhProd[0][$i]:0;
           $kwhProd2 = isset($kwhProd[1][$i])? $kwhProd[1][$i]:0;
           $kwhProd3 = isset($kwhProd[2][$i])? $kwhProd[2][$i]:0;
           $kwhProd4 = isset($kwhProd[3][$i])? $kwhProd[3][$i]:0;
           $kwhProdTotalValue = $kwhProd1 + $kwhProd2 + $kwhProd3 + $kwhProd4;
           $b2Query[$i] = $kwhProdTotalValue;

           $jmdPowerTableValue = $kwhProdTotalValue * $this->kWhJmdValue;
           $usdPowerTableValue = $kwhProdTotalValue * $this->kWhUsdValue;
           $this->kwhTotal += $kwhProdTotalValue;
           $jmdPowerValueTotal += $jmdPowerTableValue;
           $usdPowerValueTotal += $usdPowerTableValue;
           $dataTable .= "<tr>
                        <td width='25%'>".date("M",mktime(0, 0, 0, $i+1, 1, 2012))."</td>
                        <td width='25%'>".$kwhProdTotalValue."</td>
                        <td width='25%'>$".number_format($jmdPowerTableValue, 0, '.', ',')."</td>
                        <td width='25%'>$".number_format($usdPowerTableValue, 0, '.', ',')."</td>
                     </tr>";
        }
        $this->avgPower = number_format($this->kwhTotal/12,0,'.',',');
        $dataTableFtr = "<tr><td width='25%'><b>AVG</b></td><td width='25%'><b>".$this->avgPower."</b></td><td width='25%'><b>$".number_format($jmdPowerTableValue/12,0,'.',',')."</b></td><td width='25%'><b>$".number_format($usdPowerTableValue/12,0,'.',',')."</b></td></tr>";
        $dataTableFtr .= "<tr><td width='25%'><b>TOTAL</b></td width='25%'><td><b>".$this->kwhTotal."</b></td><td width='25%'><b>$".number_format($jmdPowerValueTotal,0,'.',',')."</b></td><td width='25%'><b>$".number_format($usdPowerValueTotal,0,'.',',')."</b></td></tr>";
        $dataTable  = "<style>
                            table,td,th{ border:solid 1px #000; text-align:center;}
                            th{font-weight:bold; font-size:0.8pt;}
                       </style>
                       <br/>
                       <table width='100%'>$dataTable</table>
                       <br/>
                       <table width='100%'>$dataTableFtr</table>
                       <br/>
                       <p align='left'>Simple analysis that does not take into account inflation and assumes a constant kWh rate of JMD $".number_format($this->kWhJmdValue,2,'.',',')."</p>";

        include_once("bargrade1.php");
        include_once("bargrade2.php");
        return $dataTable;
    }
   
    protected function calculateROIvalues(){
        $val = array();
        $step = 95;//loop to run
        $pmul = $mul = 0;
        $DegFac = 0.005; // Annual Degredation Factor %
        $inflationRate = $this->annualInflationRate/100;//Annual Inflation Rate
        $kwhTotal = 4045;//$this->kwhTotal;
        $avgKwhRate = $this->kWhUsdValue;//Avg kWh Rate (USD)
        $aIR = $this->annualIncreaseINkwhRate/100;
        //$avgProdInf = 0;//Avg $ Value of Annual Power Production Adjusted for Inflation (USD)
        $pccf = 0;//Previous Cumualtive Cash Flow (USD)
        $year = 1;
        $yearStep = 0.2;
        $TmpKwhTotal = $kwhTotal;
        $TmpAvgKwhRate = $avgKwhRate;
        for($i=0;$i<=$step;$i++){
            $val[$i]['yr'] = $year;
            $year = $year+$yearStep;
            $val[$i]['kwhProd'] = round($kwhTotal);
            $aPp  = $TmpKwhTotal*$TmpAvgKwhRate;
            $val[$i]['aPp']  = round($aPp,2);
            $TmpKwhTotal = $kwhTotal = $kwhTotal-($kwhTotal*($DegFac/5));
            $val[$i]['avgKwhRate'] = round($avgKwhRate,2);
            $TmpAvgKwhRate = $avgKwhRate = $avgKwhRate+($avgKwhRate*($aIR/5));
            $val[$i]['aPpI'] = ($i==0)? $aPp : $aPp+($aPp*($inflationRate/5));  
            if($i%5==0){
                $val[$i]['ccf'] = $pccf = round($pccf+$val[$i]['aPpI']);
            }
        }
        /*~~~~ANNUAL DIFFERENCE~~~~*/
        for($i=0;$i<20-1;$i++){           
            $mul+=5;
            $val[$pmul]['annDiff']   = $val[$mul]['ccf'] - $val[$pmul]['ccf'];
            $val[$pmul]['annDiff_5'] = $val[$pmul]['annDiff']/5;
            $pmul = $mul;
        }
        /*~~~~REMAINNG CUMUALTIVE CASH FLOW~~~~*/
        $annDiffFive = $key = 0;
        for($i=0;$i<=$step;$i++){
            if($i%5==0){
                $annDiffFive = (isset($val[$i]['annDiff_5']))? $val[$i]['annDiff_5'].' - ' : 0;
            }
            if($i%5!=0){
                $val[$i]['ccf'] = $val[$i-1]['ccf'] + $annDiffFive;
            }
            if($this->solarcost >= $val[$i]['ccf']){
                $key = $i;
            }
        }
        $this->repaymentYear = $val[$key]['yr'];
        /*var_dump($key);
        echo "<pre>";
        print_r($val);
        exit();*/
        include_once("bargrade-pv-system-cash-flow.php");
    }
    
    protected function pvFromInputs($clientname,$inputs,$data){
        $roof = $this->db->table('roof_type','id=?',$data['rooftype']);
        $html = "";
        foreach($inputs as $k => $values){
            $c = $k+1;
            $html .= "<tr><th colspan='2'><center><b>Roof Section {$c}</b></center></th></tr>    
            <tr>
                <td>DC Rating/DC Array Size(Kw)</td>
                <td>{$inputs[$k]['dc_rating']}</td>
            </tr>
            <tr>
                <td>Array Title/Pitch</td>
                <td>{$inputs[$k]['array_title']}</td>
            </tr>
            <tr>
                <td>Array Azzimuth/Bearing of Roof</td>
                <td>{$inputs[$k]['array_azzimuth']}</td>
            </tr>
            <tr>
                <td>Wire Run from Roof to Inverter</td>
                <td>{$inputs[$k]['roof_to_inverter']}</td>
            </tr>
            <tr>
                <td>Wire Run between Roof Section 1 and 2</td>
                <td>{$inputs[$k]['wire_between_roof_section']}</td>
            </tr>";
        }
        
        $table = "<style>
                      table,td,th{ border:solid 1px #000;}
                      th{font-weight:bold;text-align:center;font-size:0.8pt;}
                </style><h3>Off Grid PV Form Inputs</h3>
                <table width='100%'>
                  <tr>
                      <td>Client Name</td>
                      <td>{$clientname}</td>
                  </tr>
                  <tr>
                      <td>Place of Visit</td>
                      <td>{$data['placetype']}</td>
                  </tr>
                  $html
                  <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                  </tr>
                  <tr>
                      <td>Length</td>
                      <td>{$data['length']}</td>
                  </tr>
                  <tr>
                      <td>Width</td>
                      <td>{$data['width']}</td>
                  </tr>
                  <tr>
                      <td>layout (2 x 3) columns by rows</td>
                      <td>{$data['layout2x3columns']}</td>
                  </tr>
                  <tr>
                      <td>Type of roofing material</td>
                      <td>{$roof[0]['name']}</td>
                  </tr>
                  <tr>
                      <td>Wire run between solar arrary and inverter (ft)</td>
                      <td>{$data['wire_between_arrary_inverter']}</td>
                  </tr>
                  <tr>
                      <td>Where will the inverter be placed?</td>
                      <td>{$data['where_will_the_inverter_be_placed']}</td>
                  </tr>
                  <tr>
                      <td>Notes/Comments</td>
                      <td>{$data['notes']}</td>
                  </tr>
                  <tr>
                      <td>Total Installed Cost of System (USD)</td>
                      <td>{$data['total_cost_of_system']}</td>
                  </tr>
                </table>";
 
        $_SESSION['offgridtable']     = $table;
        $_SESSION['s']['siteaddress'] = SITEADDRESS;
        $_SESSION['s']['sitename']    = SITE_NAME;
        $_SESSION['s']['siteemail']   = SITE_EMAIL;

        $this->redirectTo("createoffgridpdf.php?id=$this->postKey");
    }
}
?>