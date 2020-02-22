<?php
require_once 'raxan/pdi/autostart.php';
class Index extends common{
    protected $id; 
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'adduser.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
        $this->delegate("#btn", "click", null, ".post");
        $this->id = $this->get->intVal('id');
    }
    
    protected function _prerender() {
        if(!$this->isCallback) {            
            if(!empty($this->id)){
                $this['legend']->html("Edit User");
                $this->loadUser($this->id);
            }
        }
    }
    
    protected function loadUser($id){
        $rt = $this->db->table('accounts firstname,lastname,email,position,acc_level','id=?',$id);
        $this->frmquote->inputValues($rt[0]);
    }
        
    protected function post(){
        try{
            $post = $this->post;
            $data['firstname']= trim($post->textVal("firstname"));
			$data['lastname'] = trim($post->textVal("lastname"));
			$data['position'] = trim($post->textVal("position"));
            $data['email']    = trim($post->textVal("email"));
            $data['acc_level']= trim($post->textVal("acc_level"));
            
            $valid = true;
            if(empty($data['firstname'])){$valid = false; $this->firstname->css('border','solid 1px #c00');}
			if(empty($data['position'])){$valid = false; $this->position->css('border','solid 1px #c00');}
            if(empty($data['email'])){$valid = false; $this->email->css('border','solid 1px #c00');}else{
                if(!$post->isEmail('email')){
                    $valid = false; $this->email->css('border','solid 1px #c00');
                }
            }

            if(!$valid)
            {
                $msg = "Missing/Invalid information.";
                $this->flashmsg($this->icon.$msg,'fade','rax-box error');
                $this->firstname->updateClient();
                $this->email->updateClient();
				$this->position->updateClient();
                return false;
            }

            if(empty($this->id)){
                $rt = $this->db->table('template_text detail','id=5');
                $exp = explode(' ', $data['firstname'].' '.$data['lastname']);
                $data['username'] = substr($exp[0], 0, 1).$exp[count($exp)-1];
                $pass = rand(10000001, 99000099);
                $data['password'] = md5($pass);
            
                $text = str_replace("_USERNAME_", $data['username'], $rt[0]['detail']);
                $message = str_replace("_PASSWORD_", $pass, $text);

                $data['date_added'] = date("Y-m-d H:i:s");
                $rs = $this->db->tableInsert('accounts',$data);  
                if($rs){    
                    $headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
                    $headers .= "Reply-To: ".SITE_EMAIL."\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    if(@mail($data['email'] , "New account created", $message, $headers)){
                        $this->flashmsg($this->icon.'Email sent to '.$data['email'],'fade','rax-box success');
                        $this->redirectTo("users.php");
                    }               
                }          
            }
            else{
                $rs = $this->db->tableUpdate('accounts',$data,'id=?',$this->id);  
                if($rs){    
                    $this->redirectTo("users.php");                                  
                }   
            }
        }
        catch(Exception $ex)
        {
            $msg = $ex."System Error";
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
}
?>