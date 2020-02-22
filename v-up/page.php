<?php
include_once('_nova_core_/loader.php');
class contentPages extends Core
{
    public $db = NULL;

    protected function _init() {
        parent::_init();
    }

    protected function _config(){
        parent::_config();
        $this->DBconnect();
        $this->setTemplate = 'page.html';
        $this->setThemeFolder = THEME;
    }

    protected function  _load() {
        parent::_load();
        $this->loadCategory();
        $this->getVideoTags();

        ob_start();
	include_once("/doc_root/includes/{$_GET['action']}.php");
	$content = ob_get_contents();
        ob_end_clean();
        $this->buffer = str_replace("{CONTENTHERE}", $content, $this->buffer);
    }
    
    public function __construct() {
        //parent::__construct();
        $this->_init();
        $this->_config();
        $this->_load();
        $this->_render();
    }
}

$obj = new contentPages();
?>