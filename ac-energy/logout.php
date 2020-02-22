<?php
require_once 'raxan/pdi/autostart.php';
class Logour extends common{
 
    protected function _config() {
        session_destroy();
        $this->redirectTo('index.php');
    }

    protected function _init(){}
}
?>