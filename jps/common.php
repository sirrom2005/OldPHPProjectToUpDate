<?php
session_start();
class common extends RaxanWebPage
{
    public $db, $pageSize;

    protected function _config() {
        $this->pageSize = (isset($_SESSION['PAGESIZE']))? $_SESSION['PAGESIZE'] : 20;
        $this->masterTemplate = "views/master_layout.html";
        $this->degradable = true;
        $this->preserveFormContent = true;
        // enable or disable debugging
        $this->Raxan->config('debug', false);
        $this->icon = '<span title="Close" class="right close ui-icon ui-icon-close click-cursor"></span>';
    }

    protected function _init(){
        $this->loadCSS('master');   // load css framework and default theme
        $this->loadTheme('default'); // load default/theme.css
        $this->connectToBD();
    }

    protected function _load(){ }

    protected function _prerender(){}

    protected function _authorize()
    {
        
        if(!isset($_SESSION['USER']) || empty($_SESSION['USER'])){$this->redirectTo('login.php');}
        else
        {
            if($_SESSION['USER']['admin_user_level'] != 1){$this->submenu->remove();}
            $this->delegate('#logout', 'click', NULL, '.logOut');
            $this->username->html($_SESSION['USER']['username']);
            return true;
        }
    }

    protected function connectToBD()
    {
        $this->db = $this->Raxan->connect('sqlite:'.__DIR__.'\data\jps.sqlite');
    }

    protected function logOut()
    {
        unset($_SESSION['USER']);
        $this->flashmsg($this->icon.'loggin you out of system.','fade','rax-box alert');
        $this->append('<meta http-equiv="refresh" content="3;index.php" />'); 
    }
}
?>