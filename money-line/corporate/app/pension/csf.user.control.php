<?php
/**
 * Render Pension User data information
 * Used by CSF edit screens
 * @author: Raymond Irving
 * 
 */

require_once __DIR__.'/../../includes.php';
require_once CORPORATE_MODEL_PATH.'user.php';

use Moneyline\Common\DataModelException;
use Moneyline\Common\PublicWebPageController;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;

// check for admin feature
$features = array('CSF_Create_User','CSF_Update_User','CSF_View_User','CSF_Delete_User');
if (!User::isValidUser() || !User::hasFeature($features)){    
    Shared::showErrorPage(Consts::ERROR_MODE_NOACCESS); // send error page 
}

class PensionControl extends PublicWebPageController {

    protected $code = 'pension';    // applet code

    protected $memno;
    protected $properties;

    protected function _config(){
        parent::_config();
        $this->masterTemplate = null;        
        $this->resetDataOnFirstLoad = false; // prevent this applet from reseting previous page state
    }
    
    protected function _init() {
        parent::_init();

        Raxan::loadLangFile('pension-module');
        
        // load in properties from caller
        global $_APPLET_PROPERTIES;
        $this->properties = $_APPLET_PROPERTIES;

        $this->content($this->htmlSource());

        // get memno
        if(isset($this->properties[$this->code.'.memno'])) {
            $this->memno = $this->properties[$this->code.'.memno'];
        }

    }

    protected function _load() {
        $url = Raxan::config('site.url');
        
        // bind to ajax event
        // event to handle auto search
        $this['#'.$this->code.'-query']->bind('#keydown',array(
            'callback' => '.searchPensionEvent',
            'delay' => 600,
            'prefTarget' => $this->code.'-query@'.$url.'app/'.$this->code.'/csf.user.control.php',
            'autoToggle' => 'img#'.$this->code.'-pre',
            'serialize' => '#'.$this->code.'-query',
            'inputCache' => 2
        ));

        if (!$this->isAjaxRequest) {
            $this['#'.$this->code.'-memno']->val($this->memno);  // set memno
            $this['.'.$this->code.'-result']->html(''); // clear search box tpl
            // javascipt - toggle searchbox
            C('.'.$this->code.'-search-button')->click(_fn('
                $(".'.$this->code.'-searchbox").toggle();
            '));

            C('.'.$this->code.'-result a')->live('click',_fn('function($e){
                var ssValidate = ".'.$this->code.'-validate";
                var ssSrchBox = ".'.$this->code.'-searchbox";
                var $hideBox = true ,$user,$info,$memno = $(this).attr("href");
                // validate pension & user info
                $pname = $.trim($(this).find(".name").text());
                $pname = $pname.replace(/\s+/g," ");
                $pemail= $.trim($(this).find(".email").text());
                $uname = $.trim($("form [name=\'first_name\']").val())+" "+
                         $.trim($("form [name=\'last_name\']").val())
                $uemail= $.trim($("form [name=\'email\']").val());
                $(ssValidate).hide();
                $(ssValidate + " input").attr("checked",true)
                if ($pname!=$uname || ($pemail && $pemail!=$uemail)) {
                    $(ssValidate).fadeIn();
                    $(ssValidate + " input").attr("checked",false).click(function(){
                        if (this.checked) {
                            $(ssValidate+","+ssSrchBox).hide();
                        }
                    })
                }
                $memno = $memno.split("#"); $memno = $memno[1];
                $("#'.$this->code.'-memno").val($memno);
                $(ssSrchBox).hide();
                $e.preventDefault();
                return false;
            }'));
        }

    }

    protected function searchPensionEvent($e) {
        
        $post = $this->post;
        $q = str_replace('%','',$post->textVal($this->code.'-query'));

        try {
            $members = User::findDomainMembers($q);
            c()->console('ddd');
            $tpl = $this['.'.$this->code.'-result']->html();
            if (isset($members)) {
                if (!is_array($members)) $members = array($members);
                $result = Raxan::bindTemplate($members, $tpl);
                c('.'.$this->code.'-result')->html($result)->show();
            }
            else {
                c('.'.$this->code.'-result')->html(Raxan::locale('record.not.found'))->show();
            }
        }
        catch(DataModelException $ex) {
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code,$params);
            $msg = '<strong>'.Raxan::locale('request.failed').'</strong>:<br />'.$msg;
            c('.'.$this->code.'-result')->html($msg)->fadeIn();
        }
        catch(Exception $ex) {
            // general exception
            $err = $ex->getMessage().": \n".$ex->getTraceAsString();
            $msg = Raxan::locale(Consts::ERROR_MODE_SYSERR);
            Raxan::log($err,'ERROR','CSF Pension Control');
            c('.'.$this->code.'-result')->html($msg)->fadeIn();
        }


    }

    protected function htmlSource() {
        $url = Raxan::config('site.url');
        return '
            <style type="text/css">
                #'.$this->code.'-pre { position:absolute; margin:4px 0 0 295px; }
                .'.$this->code.'-query {width:100%}
                .'.$this->code.'-result {max-height:100px;}
                .'.$this->code.'-result a {color:#333;}
                .icon {vertical-align:middle; }
            </style>
            <label>
                <span class="bold">Pension Member #:</span><br />
            </label>
            <input id="'.$this->code.'-memno" class="textbox" type="text" name="'.$this->code.'_memno" size="40" autocomplete="off" readonly="readonly" />
            <input class="c1 button '.$this->code.'-search-button" type="button" value="..." style="vertical-align:top" title="Search" /><br />
            <div class="rax-box infobox c16 hide '.$this->code.'-searchbox">
                <img class="above hide" id="'.$this->code.'-pre" src="'.$url.'views/images/preloader.gif" width="15" height="15" alt="loading"/>
                <div><input id="'.$this->code.'-query" name="'.$this->code.'-query" class="textbox" type="text" size="47" autocomplete="off" /></div>
                <div class="'.$this->code.'-result scrollable hide bmb hlf-pad white">
                    <div class="tpb">
                        <a href="#{memNo}"><strong>TRN</strong>: {trn}<br />
                        {memNo} - <span class="name">{firstName} {lastName}</span> <span class="email hide">{email}</span></a>
                    </div>
                </div>
                <div>Enter user name or TRN to display Pension ID</div>
            </div>
            <div class="alert infobox c16 '.$this->code.'-validate hide"><input type="checkbox" name="validate" checked="checked" /><span class="bold">'.Raxan::locale('confirm.pension.no').'</span><br />'.Raxan::locale('pension.validate.msg').'</div>
        ';
    }

    // render
    public function render($type='html'){
        $c = parent::render();
        if (!$this->isCallback) {
            // remove unused html tags
            $c = preg_replace('#<(html|head|title|meta|body)\b[^>]*>|</(html|head|title|body)>#is','',$c);
            $c = preg_replace('#<script[^>]*></script>#is','',$c);
        }
        return $c;
    }
}

// initize class
RaxanWebPage::Init('PensionControl');

?>
