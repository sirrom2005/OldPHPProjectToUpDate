<?php
require_once 'raxan/pdi/autostart.php';
class Index extends common{
    protected $id;
    protected $key;
    protected $section;
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'editsectiontext.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $this->id = $this->get->intVal('id');
        $this->section = $this->get->intVal('s');
        $rs = $this->db->table("quote_list filename,text{$this->section}","id=?",$this->id); 
        $this->key = $rs[0]["filename"];
        $this->frm->inputValues($rs[0]["text{$this->section}"]);
        $this->delegate("#btn", "click", array('callback' => '.post'));
    }
        
    protected function post(){
        $data["text{$this->section}"] = $this->post->htmlVal('detail');
        try{
            $rt = $this->db->tableUpdate("quote_list", $data, "id=?", $this->id);
            if($rt){
                @unlink('tmp/'.$this->key.'/quote.pdf');
                $this->flashmsg($this->icon.'Template text changed','fade','rax-box success');
                $this->redirectTo("preview.php?id={$this->id}");
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