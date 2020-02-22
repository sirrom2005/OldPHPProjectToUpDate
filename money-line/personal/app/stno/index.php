<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\AccessLog;
use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;

class StandingOrderPage extends SecureWebPageController {

    protected $moduleId = 5; //RECURRING TRANS
    
    protected function _config() {
        parent::_config();
        $this->mnuItem = 'STNO';
    }

}

?>
