<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;

class CommunicationOverviewPage extends SecureWebPageController {

    protected $moduleId = 14; // COMMUNICATION

    protected function _config() {
        parent::_config();
        $this->mnuItem = 'COVR';
        Raxan::loadLangFile("comm-module");
    }

    protected function _indexView(){
        $this->appendView('overview.php');
    }

    protected function _load() {
        parent::_load();        
        $topMenu = $this->getTopLevelMenuId($this->mnuItem);
        $menus = User::getUserMenus($topMenu);
        if (isset($menus[0]) && $menus[0]['menuId']==$this->mnuItem) {
            array_shift($menus); // remove overview menu
        }
        $this->menuOvr->bind($menus, array(
            'format'=>array('menuId'=>'lower')
        ));

        // @TODO: move help code to public page controller
        $this["#help"]->bind("#click",array(
        "callback"=>".showHelp",
        //"data"=>"login",
        "prefTarget"=>"target@help.php?vuh=comm"
        ));

       
    }

}


?>
