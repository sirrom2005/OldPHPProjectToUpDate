<?php

namespace Moneyline\Personal;

require_once __DIR__.'/../models/user.php';  // load user data model

use Raxan;
use Moneyline\Personal\Shared;
use Moneyline\Personal\Model\User;

abstract class PublicWebPageController extends \Moneyline\Common\WebPageController {

    protected function _config() {
        parent::_config();

        // initalize user locale
        User::initLocale();

        // load essential scrips and widgets
        $this->loadScript('jquery-1.4.3');
        $this->loadScript("Util");  // load utility javascript
        $this->loadcss('ui-lightness/jquery-ui-1.8.4.custom');
        $this->loadScript('jquery-ui');
        $this->loadScript('jquery.pstrength-min.1.2');
        $this->loadWidget('moneyline/messagebox');
        
        // check for mobile access
        if (!Shared::isMobileDevice()) $tpl = 'master.public.php';
        else {
            $tpl = 'mobile.master.public.php';
            $this->degradable = true;   // make page degradable when device is mobile
        }
        
        // setup public master page
        $this->masterTemplate = $this->Raxan->config('site.path') . 'views/' . $tpl;
    }

    protected function _init() {
        parent::_init();
        $url = Raxan::config('site.url');
        $this->findByXPath('//base[1]')->attr('href', $url); // set url for <base> element
    }

    /**
     * Displays a message at the top of the screen
     * @param mixed $msg Takes either a string or an array of messages to be displayed.
     * @param string $id Optional CSS selector for DOM Element container
     */
    protected function postMessage($msg, $title = null, $containerId = null, $effect = null) {
        if (empty($msg)
            )return;
        if (!is_array($msg))
            $html = $msg;
        else {
            $html = "<ul>";
            foreach ($msg as $m) {
                $html.= "<li>$m</li>";
            }
            $html .= "</ul>";
        }

        $this->loadScript('jquery-tools');
        $title = $title ? "<h3>$title</h3>" : '';
        $html = '<a href="#" class="right ui-icon ui-icon-close close round"></a>' . $title . $html;
        $this->flashmsg($html, $effect ? $effect : 'slide-up', null, null, array(
            'color' => '#420000',
            'loadspeed' => 'fast',
            'closeOnClick' => false,
            'closeOnEsc' => false
        ));
        $this->flashbar->updateClient();
    }

    /**
     * This plays messge using jQuery UI Popup
     * @param <type> $message
     * @param <type> $continuebtn
     *
     */
    protected function showMessage($message, $continuebtn=true) {
        $var = _var($message);
        C()->evaluate("showMessage($var,$continuebtn)");
    }

    protected function showSuccessMessage($message, $continuebtn=true) {
        $var = _var($message);
        C()->evaluate("showSuccessMessage($var,$continuebtn)");
    }

    protected function showErrorMessage($message) {
        $var = _var($message);
        C()->evaluate("showErrorMessage($var)");
    }

    protected function showConfirmMessage($message) {
        $var = _var($message);
        C()->evaluate("showConfirmMessage($var)");
    }
}

?>