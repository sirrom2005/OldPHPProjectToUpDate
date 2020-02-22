<?php
require_once 'raxan/pdi/autostart.php';
class Settimgs extends common{
    
    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'texttemplate.view.php';  // set page view file name
    }

    protected function _init(){
        parent::_init();
    }

    protected function _load(){
        parent::_load();
    }
    
    protected function _prerender() {
        if (!$this->isCallback) {
            $this->loadSettings();
        }
    }
    
    protected function loadSettings(){
        $rs = $this->db->table("template_text");  
        $this['#list']->bind($rs);
    } 
}
?>