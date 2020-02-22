<?php

require_once 'includes.php';
require_once CORPORATE_MODEL_PATH.'user.php';

// custom widgets
require_once CORPORATE_LIBS_PATH.'password.input.php';
require_once CORPORATE_LIBS_PATH.'admin.gadget.php';

use Moneyline\Common\DataModelException;
use Moneyline\Common\SecureWebPageController;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;


class AdminPage extends SecureWebPageController {

    protected $moduleId = 31; // ADMIN

    protected $users, $query;
    protected $page, $pageSize;
    protected $passwordInput;

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'admin.dashboard.view.php';
    }
    protected function _init() {
        parent::_init();        
        Raxan::loadLangFile('csf.admin');
    }

    // check authorization
    protected function _authorize(){
        $rt = parent::_authorize();
        // check for admin features
        $features = array('CSF_Create_User','CSF_Update_User','CSF_View_User','CSF_Delete_User');
        if ($rt && !User::hasFeature($features)){
            return false;
        }
        return $rt;
    }

    protected function _load(){
        parent::_load();

        // load admin input widgets
        $this->passwordInput = new PasswordInput();
        $this->passwordInput->onPasswordChange('.adminRequestCallback');

        // create admin gadget button
        $this->adminGadget = new AdminGadget();
        $this->adminGadget->prependTo('.admin-bar');

        // bind events
        $this->findById('pagesize')->bind('change','.change_pagesize');
        $this->findById('pager')->delegate('a','click','.change_page');
        $this->findById('tblUsersBody')->delegate('.delete','#click',array(
            'callback' => '.adminRequestForDelete',
            'autoDisable' => true
        ));
        $this->findById('tblUsersBody')->delegate('.resetpwd','#click',array(
            'callback' => '.adminRequestForPasswordReset',
            'autoDisable' => true
        ));

        // bind to search button (non-ajax)
        $this->findById('btnsearch')->bind('click',array(
            'callback'=>'.searchUser',
            'serialize'=>'#query',
            'autoDisable'=>true
        ));

        // get last page number
        $this->page = & $this->data('page',1,true);
        $this->pageSize = & Raxan::data(DataKeys::ADMIN_PAGESIZE,20,true);
        if ($this->pageSize<=0) $this->pageSize = 20;
        $this->query = & $this->data('query') || $this->data('query','');
        $this->users = & $this->data('users') || $this->data('users',array());

        $this->registerEvent('delete_user','.deleteUser');

        // remove add/edit/delete links based on access
        if (!User::hasFeature('CSF_Update_User'))
            $this['.users a.edit']->remove();
        if (!User::hasFeature('CSF_Delete_User'))
            $this['.users a.delete']->remove();
        if (!User::hasFeature('CSF_Password_Reset'))
            $this['.users a.resetpwd']->remove();

        if (!User::hasFeature('CSF_Create_User')) {
            $this->findById('btnadd')->remove(); // remnove add button
        }
        else {
            // bind client side click to add button
            if (!$this->isAjaxRequest)
                c('#btnadd')->click(_fn('window.location.href="manage-user.php";'));
        }

    }

    protected function _prerender() {
        // set page size on control
        $this['#pagesize']->val($this->pageSize);
        $this->loadUsers(); // load users
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

    /**
     * Display admin request box for delete
     */
    protected function adminRequestForDelete($e){
        $id = $e->value;
        $tag = 'delete:'.$id;
        $this->passwordInput->showBox($tag);
    }


    /**
     * Display admin request box for password reset
     */
    protected function adminRequestForPasswordReset($e){
        $id = $e->value;
        $tag = 'resetpwd:'.$id;
        $this->passwordInput->showBox($tag);
    }

    /**
     * Admin Request Callback
     */
    protected function adminRequestCallback($e,$data){
        // get id and mode from tag
        $id = explode(':',$data['tag'],2);
        $mode = $id[0];
        $id = isset($id[1]) ? $id[1] : '';
        if ($mode=='delete') $this->deleteUser($id);
        else if ($mode=='resetpwd') $this->resetUserPwd($id);
    }

    /**
     * Delete user
     */
    protected function deleteUser($id){

        try {
            // check if user can delete
            if (!User::hasFeature('CSF_Delete_User')) {
                $msg = Raxan::locale('update.failed')." - ".
                       Raxan::locale('unauth_access');
                C()->alert($msg);
                return;
            }

            // sanitize post input
            $idv = explode(',',$id);
            $id = (int)$idv[0];     // get id and version from $id
            $versionNbr = isset($idv[1]) ? (int)$idv[1] : 0;

            User::deleteUser($id, $versionNbr);
            // reset cache
            $this->users = null;
            $this->removeData('users');
            $this->redirectTo('admin.php');
        }
        catch(DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>'.Raxan::locale('request.failed').'</strong>:<br />'.$msg.
                   '<div class="tpm" align="right"><a href="#" class="button close">Close</a></div>';
            $this->flashmsg($msg,'fade','rax-box error','msgbox'); // flash to msgbox
            return;
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }

    }

    /**
     * Reset user password
     */
    protected function resetUserPwd($id) {

        try {
             if (!User::hasFeature('CSF_Password_Reset')) {
                $msg = Raxan::locale('request.failed')." - ".
                       Raxan::locale('unauth_access');
                c()->alert($msg);
                return;
            }

            $id = (int)$id;

            User::resetPasswordByAdmin($id);
            $msg = Raxan::locale('pwd.reset.successful').
                  '<div class="tpm" align="right"><a href="#" class="button close">'.Raxan::locale('close').'</a></div>';
            $this->flashmsg($msg,'fade','rax-box success','msgbox'); // flash to msgbox
        }
        catch(DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>'.Raxan::locale('update.failed').'</strong>:<br />'.$msg;
            $this->flashmsg($msg,'fade','rax-box error','msgbox'); // flash to msgbox
            return;
        }
        catch(Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }
    }

    /**
     * Search user
     */
    protected function searchUser($e) {
        $this->page = 1;
        $this->users = null;
        $this->query = str_replace('%','',$this->post->textVal('query'));
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
                $rows = User::findUsersByDomain($this->query);
                // render rows
                $users = array();
                $subjects = is_array($rows) ? $rows: array();
                foreach ($subjects as $user) {
                    $user->version = (int)$user->versionNbr;
                    $user->lastAccessDate = ($dt = strtotime($user->lastAccessDate)) ? date('d-M-Y h:i A',$dt) : '';
                    switch ($user->status) {
                        case 'A': $user->status = 'Active'; break;
                        case 'I': $user->status = 'Inactive'; break;
                        case 'L': $user->status = 'Locked'; break;
                    }
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

        $this['.users tbody']->bind($users,array(
            'altClass' => 'even'
        ));

        // setup pager
        $tpl = $this->findById('pager')->html();
        $pager = 'Page: '.Raxan::paginate($maxpage,$this->page,array(
            'tpl' => $tpl,
            'tplFirst' => '<a href="#{FIRST}" title="First">First</a> .'.$tpl,
            'tplLast' => $tpl.' . <a href="#{LAST}" title="Last">Last</a>',
            'tplSelected' =>'<span class="lightgray hlf-pad">{VALUE}</span>', 'delimiter'=>'.',
        ));
        $this->findById('pager')->html($maxpage ? $pager : '');

        // add hover effect to table rows
        c('.users tbody tr')->hoverClass('hover');

        // save page and query
        $this->data('page', $this->page);
        $this->data('query', $this->query);
        Raxan::data(DataKeys::ADMIN_PAGESIZE,$this->pageSize);

    }

}

?>