<?php
/**
 * Provides a menu for accessing custom admin screens for loaded applets.
 * @author Stephen Williams
 * @date 27-July-2009
 * 
 */

if (!defined('RAXANPDI')) exit();

use Moneyline\Common\DataModelException;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;


class AdminGadget extends RaxanElement {

    public function __construct($id=null) {
        $this->id = $id ? $id : 'admgadg-'.(self::$mObjId++);
        $html = $this->sourceHTML();
        parent::__construct($html);
        $this->find('a.gadget')
            ->bind('click',array($this,'appletSelected'))
            ->end();

        if (!$this->page->isAjaxRequest) {
            $this->loadAppletControls();

            //$this->page->loadScript('jquery-tools');
            _var(0,'tOut');
            c('.admin-tools')->hover(
                _fn('
                    clearTimeout(tOut);
                    $("#'.$this->id.'").show();
                '),

                _fn('
                    tOut =
                    setTimeout(function(){
                        $("#'.$this->id.'").hide();
                    }, 500);
                    
                ')
            );
            C('.menu-item')->hoverClass('menu-item-hover');
        }

    }

    // load applet controls
    protected function loadAppletControls($properties = array()) {
        try {
            global $_APPLET_PROPERTIES;
            $_APPLET_PROPERTIES = $properties;
            $applets = User::getDomainApplets();
            $controls = array();
            $appletCodes = array();
            if (!is_array($applets)) $applets = array($applets);
            $appletMenuItems = array();

            foreach ($applets as $applet){
                $appletCode = $applet->code;
                $appletCodes[] = $appletCode;
                // call csf user control applet.
                if (file_exists('app/'.$appletCode.'/' . $appletCode .'.menu.link.php')){
                    include_once 'app/'.$appletCode.'/' . $appletCode .'.menu.link.php';
                    $className = ucfirst($appletCode) .'MenuLink';
                    if( class_exists($className)){
                        $renderer = new $className;
                        $renderer->configureMenu($appletMenuItems);

                    }
                }
            }

            $this->bind( $appletMenuItems );
        }
        catch(DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>'.Raxan::locale('request.failed').'</strong>:<br />'.$msg.
                   '<div class="tpm" align="right"><a href="#" class="button close">'.Raxan::locale('close').'</a></div>';
            $this->flashmsg($msg,'fade','rax-box error','msgbox'); // flash to msgbox
            return;
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }

    }

// source html
protected function sourceHTML() {
$id = $this->id;
return <<<EOD
<div class="admin-tools right lightgray " style="z-index:99">
    <style type="text/css">
        .menu-item-hover{
            background-color: #b9b9b9;
        }
    </style>
    <div >
        <a class="button ok click-cursor "><strong>Administration Tools</strong></a>
    </div>

    <div id="$id" class="hide lightgray border " style="position:absolute;width:300px;right:0px" >
        <a href="{link}">
        <div class="menu-item">
            <div class="left rtm ltm" style="padding-top:5px"><img src="{icon}" alt="{title} icon"/></div>
            <div  >
                <strong>{title}</strong><br/>{description}
            </div>
            <div class="clear" style="height:1px;display:block"></div>
        </div>
        </a>
    </form>
</div>
EOD;
}

}

?>