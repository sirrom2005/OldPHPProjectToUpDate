<?php
//set_time_limit(0);
//ini_set("memory_limit","64M");
require_once 'raxan/pdi/autostart.php';
class Index extends common{
    protected $id;
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'preview.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $this->id = $this->get->intVal('id');
        $rs = $this->db->table("off_grid_quote_list","id=?",$this->id);
        
        $this->sec1->html("<a class='editsec' href='editoffgridsectiontext.php?id={$this->id}&s=1'>Edit this section</a>".$rs[0]['text1']);
        $this->sec2->html($rs[0]['text4']);
        $this->sec3->html("<a class='editsec' href='editoffgridsectiontext.php?id={$this->id}&s=2'>Edit this section</a>".$rs[0]['text2']);
        $this->sec5->html("<a class='editsec' href='editoffgridsectiontext.php?id={$this->id}&s=5'>Edit this section</a>".$rs[0]['text5']);
        $this->sec4->html("<a class='editsec' href='editoffgridsectiontext.php?id={$this->id}&s=3'>Edit this section</a>".$rs[0]['text3']);
    }
        
    /*protected function post(){
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
    }*/
    
}
?>