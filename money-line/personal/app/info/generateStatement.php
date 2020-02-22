<?php

require_once '../../includes.php';

use Moneyline\Common\Model\SysInfo;
use Moneyline\Common\Model\AccessLog;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\SecureWebPageController;

/**
 * Generate Account Statement
 */
class GenerateStatement extends SecureWebPageController {

    protected $moduleId = 18; // PRINT STATEMENT

    protected $requestHistory;
    protected $clientAccounts;

    protected function _config(){
        parent::_config();
        Raxan::loadLangFile("info-module");
        $this->mnuItem = "STMT";
        $this->masterTemplate = null; // we don't need a master template for this page
    }

    protected function _load() {
        parent::_load();

        $account_statement = Shared::data("ACCOUNT_STATEMENT");
        if ($account_statement == null) {
            $script =
                '<html><head><script type="text/javascript">
                    alert("' . Raxan::locale("request.none.print") .'");
                    window.close();
                </script></head></html>';
            $this->dump($script);
            return;
        }
        $filename = "statement.pdf";
        $data = base64_decode($account_statement);
        //$this->dump($data, 'application/pdf');
        $this->download($data, "statement.pdf", "application/pdf");
        Shared::data("ACCOUNT_STATEMENT", null);
        return;
    }
}

?> 