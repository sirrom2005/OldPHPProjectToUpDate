<?php
require_once 'raxan/pdi/autostart.php';
class Settimgs extends common{
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'settings.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $this->delegate("#btn", "click", null, ".saveSetting");
    }
    
    protected function _prerender() {
        if (!$this->isCallback) {
            $this->loadSettings();
        }
    }
    
    protected function loadSettings(){
        $rs = $this->db->table("app_options opt_key, opt_name, opt_value",'id!=? AND id!=?',5,6);  
        $this['#controls']->bind($rs);
    } 
  
    protected function saveSetting(){
        $opt1['opt_value'] = number_format($this->post->floatVal('exchange_rate'), 2, '.', '');
        $opt2['opt_value'] = number_format($this->post->floatVal('kwh_rate_jmd'),  2, '.', '');
        $opt3['opt_value'] = number_format($this->post->floatVal('kwh_rate_usd'),  2, '.', '');
        $opt4['opt_value'] = number_format($this->post->floatVal('derate_factor'), 2, '.', '');
        //$opt5['opt_value'] = number_format($this->post->floatVal('solar_power_cost_usd'), 2, '.', '');
        //$opt6['opt_value'] = number_format($this->post->floatVal('montly_payments_jmd'), 2, '.', '');
        $opt7['opt_value'] = number_format($this->post->floatVal('annual_increase_in_kwh_rate'), 2, '.', '');
        $opt8['opt_value'] = number_format($this->post->floatVal('annual_inflation_of_jamaican_dollar'), 2, '.', '');
        
        try{
            $rt1 = $this->db->tableUpdate('app_options',$opt1,'opt_key=?',"exchange_rate");
            $rt2 = $this->db->tableUpdate('app_options',$opt2,'opt_key=?',"kwh_rate_jmd");
            $rt3 = $this->db->tableUpdate('app_options',$opt3,'opt_key=?',"kwh_rate_usd");
            $rt4 = $this->db->tableUpdate('app_options',$opt4,'opt_key=?',"derate_factor"); 
            $rt7 = $this->db->tableUpdate('app_options',$opt7,'opt_key=?',"annual_increase_in_kwh_rate"); 
            $rt8 = $this->db->tableUpdate('app_options',$opt8,'opt_key=?',"annual_inflation_of_jamaican_dollar"); 
            $this->flashmsg($this->icon.'Settings saved','fade','rax-box success');
        }
        catch(Exception $ex)
        {
            $msg = $ex;
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    } 
}
?>