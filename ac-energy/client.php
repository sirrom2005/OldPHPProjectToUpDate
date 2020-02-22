<?php
require_once 'raxan/pdi/autostart.php';
class Index extends common{
    protected $id,$rtType;
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'client.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $this->id = $this->get->intVal('id');
        $this->rtType = $this->get->textVal('n');
        if(!empty($this->id)){
            $this->loadClient();
        }
        
        $this->delegate("#btn", "click", array('callback' => '.post', 'autoToggle' => '#imgloader'));
    }
        
    protected function post(){
        $post               = $this->post;
        $data['title']      = $post->textVal("title");
        $data['firstname']  = $post->textVal("firstname");
        $data['lastname']   = $post->textVal("lastname");
        $data['address']    = $post->textVal("address");
        $data['email']      = $post->textVal("email");
        $data['telephone']  = $post->textVal("telephone");
        $data['date_added'] = date("Y-m-d H:i:s");      

        $valid = true;
        if(empty($data['firstname'])){$valid = false;$this->firstname->css('border','solid 1px #c00');}
        if(empty($data['address'])  ){$valid = false;$this->address->css('border','solid 1px #c00');  }

        if(!$valid)
        {
           $msg = "Missing information.";
           $this->flashmsg($this->icon.$msg,'fade','rax-box error','flashfrm');
           $this->firstname->updateClient();
           $this->address->updateClient();
           return false;
        }
        
        try{
            if(empty($this->id)){
                $this->db->tableInsert("clients",$data);
                $id = $this->db->lastInsertId();
                if($this->rtType == 'sq'){
                    Raxan::data('clientId', $id);
                    $this->redirectTo("index.php");
                    exit();
                }
                if($this->rtType == 'led'){
                    Raxan::data('clientId', $id);
                    $this->redirectTo("ledsform.php");
                    exit();
                }
                if($this->rtType == 'wh'){
                    Raxan::data('clientId', $id);
                    $this->redirectTo("form1.php");
                    exit();
                }
                $this->redirectTo("clients.php");
            }else{
                $this->db->tableUpdate("clients",$data,'id=?',$this->id);
                $this->redirectTo("clients.php");
            }
            
        }catch(Exception $ex)
        {
            $msg = $ex;
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
    protected function loadClient(){
        try{
            $rs = $this->db->table("clients","id=?",$this->id); 
            $this->frm->inputValues($rs[0]);
        }catch(Exception $ex)
        {
            $msg = $ex;
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
}
?>