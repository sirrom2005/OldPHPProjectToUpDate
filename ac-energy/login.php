<?php
include_once('config/db_connection.php');
require_once 'raxan/pdi/autostart.php';
class Index extends RaxanWebPage{
   public $db;
    protected function _config() {
        $this->masterTemplate = 'views/LOGIN-TEMPLATE.php'; // set master template
        $this->icon = '<span title="Close" class="right close  ui-icon-close click-cursor"><b>[close]</b></span>';
    }

    protected function _init(){}

    protected function _load(){
         $this->delegate("#btn", "click", null, ".login");
    }
    
    protected function login(){
        $this->connectToBD();
        $username = addslashes($this->post->textVal('username'));
        $password = addslashes($this->post->textVal('password'));
        
        //$rs = $this->db->execQuery("select a.id,username,CONCAT(a.firstname,' ',a.lastname) AS fullname,a.position,a.acc_level from accounts a where a.username = '$username' and a.password = md5('$password')");
        $rs = $this->db->table("accounts id,username,CONCAT(firstname,' ',lastname) AS fullname,position,acc_level","username=? and password=md5(?)",$username,$password);
        $rt = $this->db->table("accounts email","id=1");
        if(!empty($rs) && !empty($rt)){
            Raxan::data('loginUserId',   $rs[0]['id']); 
            Raxan::data('loginUsername', $rs[0]['username']);  
            Raxan::data('loginAccLevel', $rs[0]['acc_level']);
            Raxan::data('loginFullname', trim($rs[0]['fullname']));
			Raxan::data('loginPosition', $rs[0]['position']);
            Raxan::data('sysEmail', $rt[0]['email']);
            $this->redirectTo('index.php');
        }
        else{
            $this->flashmsg($this->icon.'Invalid login attempt','fade','rax-box alert','flashfrm');
        }
    }
    
    public function connectToBD()
    {
        global $db_host,$db_database,$db_username,$db_password;
        /*DB CONNECTION*/
        try
        {
            $this->db = $this->Raxan->connect('mysql:host='.$db_host.'; dbname='.$db_database,$db_username,$db_password,true);
            return $this->db;
        }
        catch(Exception $ex)
        {
            $msg = "DB connection error";
            $this->flashmsg($this->icon.$msg,'fade','rax-box error');
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
}
?>