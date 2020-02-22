<?php
/**
 * Pension Admin screen
 */

require_once __DIR__.'/../../includes.php';
require_once CORPORATE_MODEL_PATH.'user.php';

// custom widgets
require_once CORPORATE_LIBS_PATH.'password.input.php';

use Moneyline\Common\DataModelException;
use Moneyline\Common\SecureWebPageController;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;

class PensionAdminPage extends SecureWebPageController {

    const DATA_PAGE_SIZE = 'pension.admin.pageSize';

    protected $moduleId = 38; // PENSION ADMIN
    
    protected $mode = '';
    protected $users,$query;
    protected $page,$pageSize;
    protected $updateFormOnPostback = true;
    protected $passwordInput;

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'pension.admin.view.php';
    }
    
    // check authorization
    protected function _authorize(){
        $rt = parent::_authorize();
        // call authorize on parent and check for features
        $features = array('CSF_Create_User');
        if ($rt && !User::hasFeature($features)){
            return false;
        }
        return $rt;
    }

    protected function _load(){
        parent::_load();

        $this->passwordInput = new PasswordInput();
        $this->passwordInput->onPasswordChange('.importUsers');

        // bind events
        $this->findById('pagesize')->bind('change','.change_pagesize');
        $this->findById('pager')->delegate('a','click','.change_page');


        // get last page number
        $this->page = & $this->data('page') || $this->data('page',1);
        $this->pageSize = & Raxan::data(self::DATA_PAGE_SIZE,20,true);
        if ($this->pageSize<=0) $this->pageSize = 20;

        $this->users = & $this->data('users',array(),true);

        // bind client side click to add button
        if (!$this->isAjaxRequest)
            C('#btnadd')->click(_fn('window.location.href="manage-user.php";'));


        // bind to button import
        $this['#webform']->bind('#submit', array(
            'callback' => '.show_adminbox',
            'autoDisable' => true
        ));

    }

    protected function _prerender() {
        parent::_prerender();
        // set page size on control
        $this->findById('pagesize')->val($this->pageSize);
        if (!$this->mode)
            $this->loadUsers(); // load users if we are not inside results mode
    }

    // change page size event
    protected function change_pagesize($e){
        $this->pageSize = (int)$e->value;
        if ($this->pageSize <= 0) $this->pageSize = 20;
    }

    // change page event
    protected function change_page($e){
        $this->page = (int)$e->value;
        if ($this->page <= 0) $this->page = 1;
    }

    // showAdminBox
    protected function show_adminbox($e) {
        $data = array();
        $post = $this->post;
        $data['role'] = $post->textVal('role');
        $data['memNos'] = $post->value('selected');

        $this->data('pension.import.data',$data);

        if (empty($data['memNos'])) {
            C()->alert('Please select a valid Pension Member');
            return;
        }
        $this->passwordInput->showBox();

    }

    // import users event
    public function importUsers(){

        $data = $this->data('pension.import.data');
        
        $role = isset($data['role']) ? $data['role'] : null;
        $memNos = isset($data['memNos']) ? $data['memNos'] : null;
        $url = Raxan::config('site.url').'app/pension/';

        if (empty($memNos)) {
            C()->alert('Please select a valid Pension Member');
            return;
        }

        //
        $log = array();
        foreach($memNos as $memNo) {
            $a = explode('|',$memNo);
            $memNo     = isset($a[0]) ? strip_tags($a[0]) : '';
            $username  = isset($a[1]) ? strip_tags($a[1]) : '';
            $firstname = isset($a[2]) ? strip_tags($a[2]) : '';
            $lastname  = isset($a[3]) ? strip_tags($a[3]) : '';
            $email     = isset($a[4]) ? strip_tags($a[4]) : '';
            
            $msg = array(); // validate postback
            if (empty($username))$msg[] = Raxan::locale('username');
            if (empty($firstname)) $msg[]= Raxan::locale('firstname');
            if (empty($lastname)) $msg[]= Raxan::locale('lastname');
            if (empty($email)) $msg[]= Raxan::locale('email.address');

            if (!empty($msg)) {
                // log validation errors
                $log[$username] = implode(', ',$msg);
            }
            else {
                // build applet properties
                $props = array();
                $entry = new \CSFAdminWSService\entry();
                $entry->key = 'pension.memno';
                $entry->value = $memNo;
                $props[] = $entry;

                $subject = new \CSFAdminWSService\subject();
                $subject->id = 0;
                $subject->domainID = User::getUserInfo()->domainID; // set user domain to the same domain as the admin
                $subject->userName = $username;
                $subject->email = $email;
                $subject->firstName = $firstname;
                $subject->lastName = $lastname;
                $subject->status = 'A';
                $subject->properties = $props;
                $subject->versionNbr = 0;

                try {
                    // save pension user
                    $roles = array($role);
                    User::createUser($subject,$roles);
                    $log[$username] = 'Import successful';
                }
                catch (DataModelException $ex) {
                    // data model exception
                    $code = $ex->getLastErrorCode();
                    $params = $ex->getLastErrorCodeParams();
                    $msg = Shared::getErrorMessage($code, $params);
                    $msg = Raxan::locale('update.failed').': ' . $msg;
                    $log[$username] = $msg;
                }
                catch (Exception $ex) {
                    // general exception
                    $msg = "Pension import: \n".$ex->getTraceAsString();
                    Raxan::log($msg,'ERROR','Pension User import');
                    $log[$username] = 'Error while importing record';
                }
            }

            // generate result
            $html = '<h3 class="bottom">Pension User Import results</h3><hr />';
            foreach($log as $user=>$msg) {
                $color = $msg=='Import successful' ? 'green' : 'red';
                $html.= '<div class="column c7 bold '.$color.'">'.$user.'</div><div> - '.$msg.'</div>';
            }
            $html.= '<hr /><a href="'.$url.'pension.admin.php" class="bold">Go Back</a>';

            C('.master-content')->html($html);
            
        }
    }

    // load Roles
    protected function loadRoles() {

        try {
            $roles = User::getDomainRoles();
            if (empty($roles)) $this->findById('role')->html(''); // clear roles template
            else {
                $arr = array();
                if (!is_array($roles)) $roles = array($roles); // make sure it's an array
                foreach($roles as $role) {
                    $arr[] = (array)$role;
                }
                $this->findById('role')->bind($arr);
            }

        }
        catch(DataModelException $ex) {
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code,$params);
            $this->flashmsg($msg,'fade','rax-box error','msgbox');  // flash msg to msgbox
            $this['.applets']->remove();
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }

    }

    /**
     * Load users
     */
    protected function loadUsers() {

        // get domain users
        if ($this->users) {
             // use cached results
            $users = $this->users;
        }
        else  {

            try {
                $subjects = User::getAllDomainUserAccounts();
                // render rows
                $users = array();
                if (!is_array($subjects)) $subjects = array($subjects); // make sure it's an array
                foreach ($subjects as $subject) {
                    $user = (array)$subject;
                    $user['memNo'] = (int)$user['memNo'];
                    $users[] = $user;
                }
                $this->users = $this->data('users',$users);

            }
            catch(DataModelException $ex) {
                // data model exception
                $code = $ex->getLastErrorCode();
                $params = $ex->getLastErrorCodeParams();
                $msg = Shared::getErrorMessage($code, $params);
                $msg = '<strong>'.Raxan::locale('request.failed').'</strong>:<br />'.$msg;
                $this->flashmsg($msg,'fade','rax-box error','msgbox'); // flash to msgbox
                return;
            }
            catch(Exception $ex) {
                // general exception
                Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
            }
            
        }

        $total = count($users);
        $pageSize = $this->pageSize;
        $maxpage = ceil($total/$pageSize);
        if ($this->page > $maxpage) $this->page = $maxpage;
        $offset = ($this->page-1) * $pageSize;
        $users = array_slice($users, $offset, $pageSize);

        $this['.users tbody']->bind($users);
        $this['.users tbody tr:even']->addClass('even');
        // setup pager
        $tpl = $this['#pager']->html();
        $pager = 'Page: '.Raxan::paginate($maxpage,$this->page,array(
            'tpl' => $tpl,
            'tplFirst' => '<a href="#{FIRST}" title="First">First</a> .'.$tpl,
            'tplLast' => $tpl.' . <a href="#{LAST}" title="Last">Last</a>',
            'tplSelected' =>'<span class="lightgray hlf-pad">{VALUE}</span>', 'delimiter'=>'.',
        ));
        $this->findById('pager')->html($maxpage ? $pager : '');

        // add hover effect to table rows
        C('.users tbody tr')->hoverClass('hover');
        C('.users thead input')->click(_fn('function(e){
            var checked = this.checked;
            var inp = $(".users tbody input");
            var tr = $(".users tbody tr");
            if (checked) {
                inp.attr("checked","checked");
                tr.addClass("select");
            }
            else {
                inp.removeAttr("checked");
                tr.removeClass("select");
            }
        }'));
        C('.users tbody input')->click(_fn('function(e){
            var checked = this.checked;
            var tr = $(this).parents("tr");
            if (checked) tr.addClass("select");
            else tr.removeClass("select");
        }'));

        // load domain roles
        $this->loadRoles();

        // save page and query
        $this->data('page', $this->page);
        $this->data('query', $this->query);
        Raxan::data(self::DATA_PAGE_SIZE,$this->pageSize);

    }


}


?>