<?php
require_once 'raxan/pdi/autostart.php';
class Index extends common{
    protected $id; 
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'changepassword.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $this->delegate("#btn", "click", null, ".changePassword");
        $this->id = $this->get->intVal('id');
    }
    
    protected function _prerender() {
    }
        
    protected function changePassword(){
        try{
            $post = $this->post;
            $data['oldpass']    = $post->textVal("oldpass");
            $data['password']   = $post->textVal("password");
            $data['password2']  = $post->textVal("password2");
            
            $valid = true;
            $msg = "";
            if(empty($data['oldpass'])){
                $valid = false;
                $msg = "Missing/Invalid information.<br>";
                $this->oldpass->css('border','solid 1px #c00');
            }
            if(empty($data['password'])){
                $valid = false;
                $msg = "Missing/Invalid information.<br>";
                $this->password->css('border','solid 1px #c00');
            }
            if(strlen($data['password']) < 6 ){
                $valid = false;
                $msg .= "Password too short 6 or more characters.<br>";
                $this->password->css('border','solid 1px #c00');
            }
            if($data['password'] != $data['password2']){
                $valid = false;
                $msg .= "Password does not match.";
                $this->password->css('border','solid 1px #c00');
                $this->password2->css('border','solid 1px #c00');
            }

            if(!$valid)
            {
                $this->flashmsg($this->icon.$msg,'fade','rax-box error');
                $this->oldpass->updateClient();
                $this->password->updateClient();
                $this->password2->updateClient();
                return false;
            }

            $rt = $this->db->exec("update accounts set `password` = md5('".$data['password']."') where `password` = md5('".$data['oldpass']."')");
            if($rt){
                $this->flashmsg($this->icon.'Password updated','fade','rax-box success');
            }else{
                $this->flashmsg($this->icon.'Invalid password','fade','rax-box error');
            }
        }
        catch(Exception $ex)
        {
            $msg = "System Error";
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
}
?>