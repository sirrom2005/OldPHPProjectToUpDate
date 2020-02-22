<?php
include_once( str_replace('doc_root\includes', '_nova_core_/classes/', __DIR__).'core.class.php');
class addToNewsLetter extends Core
{
    public $db = NULL;

    protected function _init() {parent::_init();}

    protected function _config() {
        parent::_config();
        $this->DBconnect();
    }

    protected function  _load() {
        parent::_load();
        $email = $_GET['email'];
        if(@!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
        {
            echo "Invalide e-mail address.";
            return false;
        }
       
        $rs = $this->sqliteQuery("select count(*) as cnt from accounts where email = '$email'");
        $cnt = $rs->fetchColumn(0);
        if($cnt)
        {
            echo "Email is already in our system.";
        }
        else
        {
            //$data['email']          = $email;
            //$data['account_type']   = 3;
            //$data['newsletter']     = 1;
            //$data['reg_date']       = date("Y-m-d H:i:s");
            $rs = $this->sqliteQuery("insert into accounts (email) values('$email')");
            if($rs){ echo "Email address added, Thank you."; }
        }
    }

    public function __construct(){
        $this->_init();
        $this->_config();
        $this->_load();
    }
}
$obj = new addToNewsLetter();
?>