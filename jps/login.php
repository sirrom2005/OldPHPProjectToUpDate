<?php
require_once('raxan/pdi/autostart.php');
class login extends common
{
    protected $updateList = false;
    protected $pgNumber;
    public $pageSize;

    protected function _config() {
        parent::_config();
        $this->masterTemplate = "views/login.html";
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load() {
        parent::_load();
        $this->delegate('#login', 'click', NULL, '.loginUser');
    }

    protected function _prerender() {
        parent::_prerender();
    }

    protected function _authorize() {
        //$rt = parent::_authorize();
        return true;
    }

    protected function loginUser()
    {
        $post = $this->post;
        $username = $post->textVal('username');
        $password = $post->textVal('password');
        $rs = $this->db->table('viewAdminList username,admin_user_level,parish_id','username=? AND password=?',$username,$password);

        if($rs)
        {
            $_SESSION['USER'] = $rs[0];
            $this->redirectTo('index.php');
        }
        else
        {
            $this->flashmsg($this->icon.'Invalid username/password','fade','rax-box error');
        }
    }
}
?>