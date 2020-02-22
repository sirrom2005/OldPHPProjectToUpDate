<?php
session_start();
include_once('config/db_connection.php');
class common extends RaxanWebPage {   
    public $db;
    protected $X_username;
    protected $X_acclevel;
    
    protected function _config(){ 
        $this->X_username = Raxan::data('loginUsername');  
        $this->X_acclevel = Raxan::data('loginAccLevel');
        $sysEmail = Raxan::data('sysEmail');
        if(empty($this->X_username)){
            $this->redirectTo('login.php');
        }
               
        define('SITEADDRESS', 'http://127.0.0.1/ac-energy/');
        define('SITE_NAME', 'IREE SOLAR');
        define('SITE_EMAIL',$sysEmail);
        $this->masterTemplate = 'views/MASTER-TEMPLATE.php'; // set master template
        $this->degradable = true;
        $this->preserveFormContent = true;
        $this->Raxan->config('debug', false);
        $this->icon = '<span title="Close" class="right close  ui-icon-close click-cursor"><b>[close]</b></span>';
    }

    protected function _init(){
        $this->connectToBD();
        if($this->X_acclevel!=1){
            $this['.adm']->remove();
        }
    }

    protected function _load(){
        $this['#username']->html("Hello ".$this->X_username);
        if($this->X_acclevel != 1){
            $this['.adm']->remove();
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
    
    protected function loadClients(){
        $id = Raxan::data('clientId') | 0;
        $rt = $this->db->table("clients CONCAT(firstname,' ',lastname) AS clientname",'id=?',$id);
        if(!empty($rt)){
            $this["#findname"]->val($rt[0]['clientname']);
            $this["#clientid"]->val($id);
        }
    }
    
    protected function ajaxNameSearch()
    {
        $txt = $this->post->textVal('findname'); 
        $txt = trim($txt);
        if(strlen($txt)<1){ c('#frmsearch div')->html(''); return false; }
        try
        {
            $html = '';
            $rs = $this->db->execQuery("SELECT id AS clientid, CONCAT(firstname,' ',lastname) AS clientname 
                                        FROM clients 
                                        WHERE firstname LIKE '%".$txt."%' OR lastname LIKE '%".$txt."%'
                                        GROUP BY id ORDER BY title, firstname, lastname");
            if($rs)
            {
                $html .= "<ul id='name_list'>";
                $alt = true;
                foreach($rs as $key => $value)
                {
                   $sty = ($alt)? '': 'even';
                   $alt = ($alt)? false : true;
                   $q = base64_encode($value['clientid'].'_'.$value['clientname']);
                   $html .= "<li class='$sty'><a href='#$q' id='clientidlink{$value['clientid']}' class='clientidlink'>{$value['clientname']}</a></li>";
                }
                $html .= "</ul>";
                $this['#namelist']->html($html)->updateClient();
            }
            else{c('#namelist')->html('');}
        }
        catch(Exception $ex)
        {
            $msg = SYS_ERROR;
            $this->flashmsg($msg);
            $this->Raxan->debug($msg.' '.$ex);
        }
    }
    
    protected function addSelectedClient($e)
    {
        $id = $e->value;
        $val = base64_decode($id);
        $val = explode('_', $val);
        C("#findname")->val($val[1]);
        C("#clientid")->val($val[0]);
    }
}
?>