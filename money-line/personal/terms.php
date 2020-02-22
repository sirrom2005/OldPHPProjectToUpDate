<?php
/**
 * Terms Page
 */

require_once 'includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';


use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Shared;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;


class TermsPage extends SecureWebPageController {

    protected $moduleId = 12; // TERMS

    // Setup master template.
    // The view for this page can be located at views/terms.php

    protected function _config() {
        parent::_config();
        $type = (Shared::isMobileDevice()) ? 'mobile.' : '';
        $this->masterTemplate = 'views/'.$type.'master.public.php'; // override master template
    }


    protected function _init() {
        parent::_init(); // initilize shared master page

        // load language file
        Raxan::loadLangFile('terms');

        // check if user is already logged in
        if (!User::requireTermsAndConditions() && User::isLogin()) {
            $this->redirectTo('app/accsum');
        }

    }

    protected function _indexView() {
        $this->appendView('terms.view.php');
    }

    protected function accept($e) {
        $st = User::setTermsCondition('ACCEPTED');
        if (!$st) $this->msgbox->showMessage(Raxan::locale('terms-fail'));
        else {
            $this->redirectTo('app/accsum');
        }
    }

    // decline event
    protected function decline($e) {
        $st = User::setTermsCondition('DECLINED');
        if (!$st) $this->msgbox->showMessage(Raxan::locale('terms-fail'));
        else $this->redirectTo('logout.php');
    }
}

?>