<?php
require_once('raxan/pdi/autostart.php');
class index extends RaxanWebPage
{
    protected $db;

    protected function _config() {
        $this->pageSize = 10;
        $this->masterTemplate = "views/admin.html";
        $this->degradable = true;;
        // enable or disable debugging
        $this->Raxan->config('debug', true);
        $this->icon = '<span title="Close" class="right close ui-icon ui-icon-close click-cursor"></span>';
    }

    protected function _init(){
        $this->appendView("upload.html");
        $this->loadCSS('views/css/admin.css', true);
        $this->loadCSS('master');   // load css framework and default theme
        $this->loadTheme('default'); // load default/theme.css
        $this->connectToBD();
    }

    protected function _load() {}

    protected function _prerender() {
    }

    protected function _authorize() {
        return true;
    }

    protected function connectToBD()
    {
       $this->db = $this->Raxan->connect('sqlite:../_nova_core_/data/videouploader.sqlite');
    }
}
?>