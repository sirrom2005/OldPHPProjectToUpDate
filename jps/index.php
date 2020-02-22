<?php
require_once('raxan/pdi/autostart.php');
class index extends common
{
    protected $updateList = false;

    protected function _config() {
        parent::_config();
    }

    protected function _init(){
        parent::_init();
        $this->appendView("home.html");
    }

    protected function _load() {
        parent::_load();
    }

    protected function _prerender() {
        parent::_prerender();
    }

    protected function _authorize() {
        $rt = parent::_authorize();
        return $rt;
    }
}
?>