<?php
/**
 * Password Input plugin
 * @author Raymond Irving
 * @date 22-July-2009
 * 
 */

if (!defined('RAXANPDI')) exit();

use Moneyline\Common\DataModelException;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;

class PasswordInput extends RaxanElement {

    public function __construct($id=null) {
        $this->id = $id ? $id : 'pwdinp-'.(self::$mObjId++);
        $html = $this->sourceHTML();
        parent::__construct($html);
        $this->find('form')
            ->submit(array($this,'passwordChange'))
            ->end();

        $this->page['body']->append($this);

        if (!$this->page->isCallback) {
            $this->page->loadScript('jquery-tools');
            $this->page->addScript('$("#'.$this->id.'").overlay({expose:"#777"})','ready');
            C('#'.$this->id.' a')->click(_fn('function(e) {
                $("#'.$this->id.'").overlay({api:true}).close();
                e.preventDefault();
            }'));
        }

    }

    public function onPasswordChange($callback) {
        $this->bind('passwordchange@local',$callback);
    }
    
    /**
     * Trigger Password Change event
     * Pass an array to the event
     */
    public function passwordChange($e = null) {
        $pwd = $this->page->post->textVal('pwd-password');
        $tag = $this->page->post->textVal('pwd-tag');
        $pwd = $pwd ? $pwd : '';
        $tag = $tag ? $tag : '';

        try {
            $uid = User::getUserId();
            $sessid = User::getSessionId();

            // valdiate admin user
            if (!User::validateUserPass($uid, $pwd)) {
                c()->alert(Raxan::locale('invalid.pwd'));
                return;
            }

            $this->trigger('passwordchange',array(
                'tag'=>$tag,
                'password'=>$pwd
            ));

            // hide control
            C('#'.$this->id)
                ->find('input[name*="pwd"]')->val('')->end()
                ->overlay(array('api'=>true))->close();
        }
        catch(DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            if ($code=='ERR010') $msg = Raxan::locale('admin.validation.failed');
            $msg = '<strong>'.Raxan::locale('request.failed').'</strong>:<br />'.$msg;
            $this->page->flashmsg($msg,'blink','rax-box alert','pwdInputMsg'); // flash to msgbox
            return;
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }

    }

    /**
     * Shows the Admin password box
     */
    public function showBox($tag = '') {
       c('#'.$this->id)
        ->find('[name="pwd-password"]')->val('')->end()
        ->find('[name="pwd-tag"]')->val($tag)->end()
        ->overlay(array('api'=>true))->load();
    }

// source html
protected function sourceHTML() {
$id = $this->id;
return <<<EOD
<div id="$id" overlay="views/images/spacer.gif" class="container rax-box success" style="position:absolute;top:0;left:0;width:350px;display:none">
    <form class="password-input-plugin">
        <div class="right close"><a href="#">Close</a></div>
        <h3 class="bottom">Admin Password:</h3>
        <div style="padding: 2px 0">You're trying to execute a process that requires admin access. Please enter your admin password to continue.</div>
        <input type="hidden" name="pwd-tag" class="left c13 rtm" />
        <input type="password" name="pwd-password" class="left c13 rtm" />
        <input type="submit" value="Submit" class="left" /><br />
    </form>
    <br />
    <div id="pwdInputMsg" class="flashmsg"></div>
</div>
EOD;
}

}

?>