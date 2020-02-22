<?php
//set_time_limit(0);
//ini_set("memory_limit","64M");
require_once 'raxan/pdi/autostart.php';
class Index extends common{

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'solarquoteinputs.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $this->loadRoofType();
        
        $id = $this->get->intVal('id');
        $rs = $this->db->execQuery("SELECT CONCAT(c.title,' ',c.firstname,' ',c.lastname) AS fullname, c.telephone, c.email,c.address,q.placetype,
                                    length,width,layout2x3columns,img_upload,rooftype,wire_between_arrary_inverter,where_will_the_inverter_be_placed,total_cost_of_system
                                    FROM off_grid_quote_list q
                                    INNER JOIN clients c on c.id = q.clientid
                                    WHERE q.id=$id");
        $rt = $this->db->table("off_grid_section_quote","quote_id=?",$id);
        $name = explode(' ', $rs[0]['fullname']);
    
        $rs[0]['title']     = $name[0];
        $rs[0]['firstname'] = $name[1];
        $lastname = str_replace($name[1], "", $rs[0]['fullname']);
        $lastname = str_replace($name[0], "", $lastname);
        $rs[0]['lastname']  = trim($lastname);
        $rs[0]['address']   = str_replace('<br>', "\n", $rs[0]['address']);
        $rs[0]['notes']     = $rt[0]['notes'];
   
        $this->frmquote->inputValues($rs[0]);
        
        foreach($rt as $row){
            $this["#dc_rating".$row['key']]->val($row['dc_rating']);
            $this["#pitch".$row['key']]->val($row['array_title']);
            $this["#bearing".$row['key']]->val($row['array_azzimuth']);
            $this["#inverter".$row['key']]->val($row['roof_to_inverter']);
            $this["#roofwiresection".$row['key']]->val($row['wire_between_roof_section']); 
            $this["#divsec".$row['key']]->show();
        }
        $this["#frmquote input, select, textarea"]->attr('disabled',true);
        $this["legend"]->html("Off Grid PV Info");
    }
    
    protected function loadRoofType(){
         $rs = $this->db->table("roof_type");
         $t[]= array('id' => 0, 'name' => 'None');
         $rs = array_merge($t,$rs);
         $this['#rooftype']->bind($rs);
    }
}
?>