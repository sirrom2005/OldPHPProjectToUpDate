<?php

require_once 'includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Shared;
use Moneyline\Personal\PublicWebPageController;
use Moneyline\Personal\Model\User;


class IndexPage extends PublicWebPageController {

    protected $moduleId = 11; // SYSTEM

    protected function _init() {
        parent::_init();

        if (User::isLogin()) $link = 'app/accsum';
        else $link = 'login.php';

        // redirect to link
        $siteurl = $this->Raxan->config('site.url');
        $this->redirectTo($siteurl.$link);
    }

}

?>