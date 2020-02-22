<?php

namespace Moneyline\Corporate;

require_once \CORPORATE_MODEL_PATH.'user.php';  // load user data model

use Raxan, Exception;
use Moneyline\Common\IWebPageDelegate;
use Moneyline\Common\DataModelException;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;

/***
 * Public Web Page Delegate
 * @property \RaxanWebPage $page
 */
class PublicWebPageDelegate implements IWebPageDelegate {
    protected $page;

    /**
     * @param \RaxanWebPage $page
     */
    public function __construct($page) {
        $this->page = $page;
    }

    public function config() {        
        User::initLocale(); // initalize user locale
        // setup public master page
        $this->page->masterTemplate = Raxan::config('site.path') . 'views/master.public.php';
    }
    
    public function init() {
        // setup base user
        $url = Raxan::config('site.url');
        $this->page->findByXPath('//base[1]')->attr('href', $url); // set url for <base> element
        $this->page->loadScript('jquery-ui-effects');
    }
    
    public function authorize() {
        return true;
    }
    
    public function load() {
        ;
    }
}

/***
 * Secure Web Page Delegate
 */
class SecureWebPageDelegate extends PublicWebPageDelegate {
    
    public function config() {
        parent::config();
        // setup secure master page
        $this->page->masterTemplate = Raxan::config('site.path') . 'views/master.secure.php';
    }

    public function init() {
        parent::init();
        // check if page property module is empty - see AccessLog
        $moduleId = \Moneyline\Common\WebPageController::getModuleId();
        if (!$moduleId) {
            $err = 'Page or Module Id not defined. Please declare and set the $moduleId page property';
            throw new Exception ($err);
        }
    }
    
    public function authorize() {
        $rt = parent::authorize();
        if ($rt) {
            // check authentification
            Shared::checkAuthentication();
            // remove admin menu button
            $features = array('CSF_Create_User','CSF_Update_User','CSF_View_User','CSF_Delete_User');
            if (!User::hasFeature($features)) $this->page['.administrator']->remove();
            return true;
        }
        return $rt;
    }

    public function load() {
        parent::load();
        $this->updateUserBar();
    }

    protected function updateUserBar() {
        $info = User::getUserInfo();
        if (!$info) return;
        $dt = isset($info->lastAccessDate) ? $info->lastAccessDate : '';
        $user = isset($info->userName) ? $info->userName : '';
        if ($dt) {
            $dt = strtotime($dt);
            if ($dt) $dt = date('d-M-Y h:i A',$dt);
        }
        if ($user) {
            $content = $user.'&nbsp; - &nbsp;Last Access: '.$dt.'&nbsp;';
            $this->page->findById('userbar')->html($content);
        }
    }
    
}



?>
