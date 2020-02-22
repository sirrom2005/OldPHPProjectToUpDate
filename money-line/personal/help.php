<?php

require_once 'includes.php';
require_once PERSONAL_MODEL_PATH . 'user.php';

use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Shared;
use Moneyline\Personal\PublicWebPageController;
use Moneyline\Personal\Model\User;

// @todo: Refactor help system

/**
 * Description of help
 * @author lloydj
 */
class HelpPage extends PublicWebPageController {
    //put your code here

    const PATH ="app/help/views/";
    const FILETYPE ="php";

    protected function _init() {
        parent::_init();
        ///$this->registerEvent('show','.showHelp');

        $this->showHelp(null);
        // $this->
    }

    /**
     *
     * @param RaxanEvent $e
     *
     */
    protected function showHelp($e) {
        try {
            $viewName = $this->get->vuh;
            $locale = User::getLocaleCode();
            if (!isset($viewName) || trim($viewName) == "")
                $viewName = "index";

            $viewName = self::PATH . $locale . "/" . $viewName . "." . self::FILETYPE;

            if (!file_exists($viewName))
                return "failed";

            $view = _var(file_get_contents($viewName));

            $this->callScriptFn('showHelp',$view);
            
            return "success";
        } catch (Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_SYSERR);
            $this->showMessage($msg);
            Shared::logRedirectToErrorPage($err, $ex, $level, $label);
        }

        return "failed";
    }

}

?>
