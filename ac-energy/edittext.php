<?php
//set_time_limit(0);
//ini_set("memory_limit","64M");
require_once 'raxan/pdi/autostart.php';
class Index extends common{
    protected $id;
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'edittext.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $this->id = $this->get->intVal('id');
        $rs = $this->db->table("template_text title, detail","id=?",$this->id);
        $this->frm->inputValues($rs[0]);
        $this->title->html($rs[0]['title']);
        $this->delegate("#btn", "click", array('callback' => '.post'));
    }
        
    protected function post(){
        $data['detail'] = $this->post->htmlVal('detail');
       
        try{
            $rt = $this->db->tableUpdate("template_text", $data, "id=?", $this->id);
            if($rt){
                $this->flashmsg($this->icon.'Template text changed','fade','rax-box success');
            }
        }catch(Exception $ex)
        {
            $msg = "Error in connecting to data server";
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
}
?>