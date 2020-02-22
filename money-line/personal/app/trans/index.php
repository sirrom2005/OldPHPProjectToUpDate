<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';
require_once PERSONAL_MODEL_PATH.'transMod.php';

use Moneyline\Common\Model\AccessLog;
use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\Model\Trans;
use Moneyline\Personal\SecureWebPageController;

class TransactionOverviewPage extends SecureWebPageController {

    protected $moduleId = 22; // TRANSACTIONS

    protected function _config() {
        parent::_config();
        $this->mnuItem = 'TOVR';
        Raxan::loadLangFile("trans-module");
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

            $this["#help"]->bind("#click",array(
            "callback"=>".showHelp",
            //"data"=>"login",
            "prefTarget"=>"target@help.php?vuh=trans"
            ));

    }

    protected  function testAutoPayee(){
        Trans::autoSelectTxnPayee("TRANSFER", 3, 0);
        $this->redirectTo(Raxan::config("site.url").'app/trans/trans.php');
    }
}


?>
