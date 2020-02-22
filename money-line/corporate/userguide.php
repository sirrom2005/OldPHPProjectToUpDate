<?php
/**
 * User Guides
 * The naming convension for to use with user guides should be: {code}-user-guide.pdf
 */

require_once 'includes.php';
require_once CORPORATE_MODEL_PATH.'user.php';

use Moneyline\Common\DataModelException;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Common\SecureWebPageController;
use Moneyline\Corporate\Model\User;

class UserGuidePage extends SecureWebPageController {

    protected $moduleId = 34; // USER GUIDE

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'csf-user-guide.view.php';
    }
    
    protected function _load() {
        parent::_load();
        $this->loadUserGuidesFromApplets();
    }

    protected function loadUserGuidesFromApplets(){

        // get applets
        try {
            $applets = array();
            $applets[] =  array(
                'code' => 'csf.admin',
                'name' => 'Corporate Moneyline',
                'description' => 'Corporate Moneyline',
                'url'  => 'csf-user-guide.pdf'
            );
            $wsapplets = User::getUserApplets();
            if (!empty($wsapplets)) {
                if (!is_array($wsapplets)) $wsapplets = array($wsapplets);
                foreach ($wsapplets as $applet) {
                    $ap = array(
                        'code' => $applet->code,
                        'name' => $applet->name,
                        'description' => $applet->description,
                        'url'  => (!isset($applet->url)) ? 'app/'.$applet->code.'/' .$applet->code.'-user-guide.pdf' : $applet->url
                    );
                    $applets[] = $ap;
                }
            }
            $this->findById('user-guides')->bind($applets);
        }
        catch (DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>' . Raxan::locale('update.failed') . '</strong>:<br />' . $msg;
            $this->flashmsg($msg, 'fade', 'rax-box error', 'msgbox'); // flash to msgbox
            return;
        }
        catch (Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }

  
    }

}


?>