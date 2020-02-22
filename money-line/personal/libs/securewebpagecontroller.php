<?php

namespace Moneyline\Personal;

use Raxan;
use Moneyline\Personal\Shared;
use Moneyline\Personal\Model\User;

abstract class SecureWebPageController extends \Moneyline\Personal\PublicWebPageController {
    
    protected $mnuItem;
    protected static $loadedChildTemplates = array();

    protected function _config() {
        parent::_config(); // call parent

        // setup secure master page
        if (Shared::isMobileDevice()) $tpl = 'mobile.master.secure.php';
        else $tpl = 'master.secure.php';
        $this->masterTemplate = Raxan::config('site.path') . 'views/' . $tpl;

        // set page name
        //self::pageName(get_class($this));
    }

    protected function _init() {
        parent::_init();

        // check if page property module is empty - see AccessLog
        if (!$this->moduleId) {
            $err = 'Page or Module Id not defined. Please declare and set the $moduleId page property';
            throw new \Exception ($err);
        }
        
        $this->loadScript('jquery-tools');  // include jQuery Tools
        // check if we should show the terms and condition web page
        if (!User::isInternalUser() && User::requireTermsAndConditions()) {
            if (get_class($this) != 'TermsPage') {
                $url = Raxan::config('site.url');
                Raxan::redirectTo($url . 'terms.php');
            }
        }

        // we have manually loaded the theme so
        // let's manually set the theme flag
        $this->isThemeLoaded = true;
    }

    protected function _authorize() {
        // check if user is logged in
        if (User::isLogin())
            return true;
        else {
            Shared::showErrorPage(Shared::ERROR_MODE_NOACCESS);
        }
    }

    protected function _load() {
        parent::_load();

        // show date
        if ($this->getElementById('currentdate')) {
            $dt = Raxan::cDate();
            $this->currentdate->text($dt->format('l, F j, Y'));
        }

        // show user name
        if ($this->getElementById('logininfo')) {
            $login = Raxan::locale('welcome-user', htmlspecialchars(User::getLoginName()));
            $html = $login . '<img src="views/images/vcard.png" alt="."/>&nbsp;&nbsp;|&nbsp;&nbsp;' .
                    '<a href="logout.php">' . Raxan::locale('logout') . '</a>' .
                    '<img src="views/images/logout-icon.png" alt="." />';
            $this->logininfo->html($html);
        }


        // setup client-side javascript date variables
        $dt = getdate(time());
        $this->registerVar('srvDatetimeStr', date('Y/m/d h:i:s A', time()));
        $this->registerVar('srvHour', $dt['hours']);
        $this->registerVar('srvMinute', $dt['minutes']);
        $this->registerVar('srvSecond', $dt['seconds']);
        $this->registerVar('_cutOffTime', $this->Raxan->config('ho-cutoff-hour'));
        $this->registerVar('_cutOffTimeDesc', $this->Raxan->config('ho-cutoff-time-desc'));

        // set session timeout warning variable
        $timeout = (((int) $this->Raxan->config('session.timeout')) - 2);
        if ($timeout < 1)
            $timeout = 1;
        $this->registerVar('timeoutMinutes', $timeout);

        //set up the menu system
        $this->selectMenu($this->mnuItem);
    }

    /**
     * Select Top Menu
     * @param string $id Menu id
     */
    protected function selectMenu($id) {

        //show user menus
        $selMnu = $selTopMnu = '';
        $mnuItemLnk = '';
        $menus = User::getUserMenus();
        $l = count($menus);
        $mnuArray = array();
        for ($i = 0; $i < $l; $i++) {
            $menu = $menus[$i];
            $pid = $menu['parentMenuId'];
            $mnuId = $menu['menuId'];
            if (!$pid)
                $pid = 'TOP';
            if ($id == $mnuId) {
                $selMnu = $mnuId;
                $selTopMnu = $pid;
            }
            $mnuItemLnk = $menu['menuLink'];
            //if (stripos($menu['menuLink'], '?')==false)$mnuItemLnk .= "?pid=$pid&mnuId=$mnuId";
            //else $mnuItemLnk .= "&pid=$pid&mnuId=$mnuId";

            $mnuLink = '<li><a id="mnu' .
                    $menu['menuId'] . '" href="' .
                    $mnuItemLnk . '" target="' .
                    $menu['menuTarget'] . '" rel="' .
                    $menu['menuId'] . '">' . $menu['menuName'] . '</a>' .
                    '</li>';
            if (!isset($mnuArray[$pid]))
                $mnuArray[$pid] = '';
            $mnuArray[$pid].= $mnuLink;
        }

        if ($this->getElementById('menuTop')) {
            $this->menuTop->html($mnuArray['TOP']); // setup top menus
            if (!$selTopMnu || $selTopMnu == 'TOP')
                $this->menuSub->remove();
            else {  // setup sub-menus
                $this->menuSub->html($mnuArray[$selTopMnu]);
                $this->findById('mnu' . $selTopMnu)->parent()->addClass('selected-tab'); // select top menu
            }
            $this->findById('mnu' . $selMnu)->parent()->addClass('selected-tab');
        }
    }

    /**
     * Returns the menu id of the parent object. If the
     * menuid has no parent then the same menu id will be
     * returned.
     * @param string $menuId
     * @return string
     */
    protected function getTopLevelMenuId($menuId) {
        $menus = User::getUserMenus();
        $cnt = count($menus);
        $parentMenuId = $menuId;

        for ($i = 0; $i < $cnt; $i++) {
            if ($menus[$i]['menuId'] == $menuId) {
                if ($menus[$i]['parentMenuId'] != null
                    )$parentMenuId = $menus[$i]['parentMenuId'];
            }
        }
        return $parentMenuId;
    }

    /**
     * Binds an element in a parent template to a child
     * template defined in another file
     * @param <type> $templateName
     * @param <type> $containerSelector CSS selector for the container to populate
     * @param <type> $bindSelector CSS selector for the section to populate
     * @param <type> $values
     * @param <type> $options
     */
    protected function bindChildTemplate($templateName, $containerSelector, $bindSelector, $values, $options=null) {
        $tmpl = isset(self::$loadedChildTemplates[$templateName]) ? self::$loadedChildTemplates[$templateName] : null;
        $result = null;
        // if the template has not yet been loaded then load it
        if ($tmpl == null) {
            $pth = Raxan::config('views.path');
            $tmpl = file_get_contents($pth . $templateName);
            if ($tmpl == null
                )self::$loadedChildTemplates[$templateName] = $tmpl;
        }
        // if a template was found then do the binding
        if ($tmpl != null) {
            $raxElm = $this[$tmpl];
            if ($containerSelector != null) {
                //C()->console("Conatiner Selector is " . $containerSelector);
                $raxElm = $raxElm->find($containerSelector);
            }
            //C()->console($raxElm->html());
            $result = $raxElm->find($bindSelector)->bind($values, $options)->end();
        }
        return $result;
    }
}

?>