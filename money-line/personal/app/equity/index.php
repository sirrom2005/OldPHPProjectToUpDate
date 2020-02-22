<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;


class EquityPage extends SecureWebPageController {

    protected $moduleId = 3; // EQUITY

    protected function _config() {
        parent::_config();
        $this->mnuItem = 'EQTY';
        Raxan::loadLangFile('equity-module');
    }

    protected function _indexView(){
        $this->appendView('overview.php');
    }

    protected function _load() {
        parent::_load();
        $menus = array(
            array('menuId'=>'buy','menuLink'=>'app/equity/buy.php'),
            array('menuId'=>'sell','menuLink'=>'app/equity/sell.php'),
            array('menuId'=>'neworders','menuLink'=>'app/equity/neworders.php'),
            array('menuId'=>'oldorders','menuLink'=>'app/equity/oldorders.php'),
            array('menuId'=>'fills','menuLink'=>'app/equity/fills.php'),
            array('menuId'=>'portfolio','menuLink'=>'app/equity/portfolio.php')
        );
        $this->menuOvr->bind($menus, array(
            'format'=>array('menuId'=>'lower')
        ));

        $this->help->bind("#click",array(
            "callback"=>".showHelp",
            //"data"=>"login",
            "prefTarget"=>"target@help.php?vuh=equity"
        ));
    }
    
}

?>
