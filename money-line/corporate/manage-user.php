<?php
/**
 *  Create Edit User accounts
 */

require_once 'includes.php';
require_once CORPORATE_MODEL_PATH . 'user.php';

use Moneyline\Common\DataModelException;
use Moneyline\Common\SecureWebPageController;
use Moneyline\Corporate\Consts;
use Moneyline\Corporate\DataKeys;
use Moneyline\Corporate\Shared;
use Moneyline\Corporate\Model\User;

class ManagePage extends SecureWebPageController {

    protected $moduleId = 36; // MANAGE USER
    protected $uid;

    protected function _config() {
        parent::_config();
        $this->autoAppendView = 'user.form.view.php';
    }

    protected function _init() {
        parent::_init();
        Raxan::loadLangFile('csf.admin');
        Raxan::loadLangFile('login');
    }

    // check authorization
    protected function _authorize() {
        $rt = parent::_authorize();
        // check for admin features
        $features = array('CSF_Create_User', 'CSF_Update_User', 'CSF_View_User', 'CSF_Delete_User');
        if ($rt && !User::hasFeature($features)) {
            return false;
        }
        return $rt;
    }

    protected function _load() {
        parent::_load();
        $this->uid = $this->get->intVal('id');
        $title = $this->uid ? Raxan::locale('edit.user') : Raxan::locale('create.user');
        $this['.title']->prepend($title);

        // check if ajax request
        if (!$this->isAjaxRequest) {
            $this->loadRoles();
            if (!$this->uid) $this->loadAppletControls(); // new user
            if ($this->uid) $this->loadUserData();        // existing user
                // remove submit button
            if (!User::hasFeature(array('CSF_Update_User', 'CSF_Create_User'))) {
                $this->findById('btnsave')->remove();
            }
        }

        // bind events
        $jsValidate = '$("form input[name=\'validate\']").each(function(){ if (!this.checked) preventPostback = true;}); if (preventPostback) $("#msgbox").html("<div class=\'rax-box alert\'><span class=\'bold\'>' . Raxan::locale('validation') . ':</span><br />' . Raxan::locale('validation.msg') . '</div>").fadeIn();';
        $btn = $this->findById('btnsave');
        if ($btn->length)
            $btn->bind('#click', array(
                'callback' => '.btnSaveEvent',
                'autoDisable' => '.webform, #btnsave',
                'script' => $jsValidate, // check if controls have been validated. Each CSF contraol can have it's own validate checkbox
                'serialize' => '.webform'
            ));
    }

    // Save button click
    protected function btnSaveEvent($e) {

        // check if user can save
        if (!User::hasFeature('CSF_Update_User')) {
            $msg = '<strong>' . Raxan::locale('update.failed') . '</strong><br />' .
                    Raxan::locale('unauth_access');
            $this->flashmsg($msg, 'fade', 'rax-box alert', 'msgbox');
            return;
        }

        // sanitize post input
        $post = $this->post;

        // get the id of the record if in edit mode
        $id = $this->data('record_id');
        $versionNbr = $this->data('record_version');
        $pid = $post->intVal('userid');
        if ($pid && $pid != $id) {
            // this is not the record we attempt to edit
            c()->alert(Raxan::locale('record.nofound'));
            return;
        }

        $username = $post->textVal('username');
        $email = $post->emailVal('email');
        $email2 = $post->emailVal('email2');
        $firstname = $post->textVal('first_name');
        $lastname = $post->textVal('last_name');
        $status = $post->textVal('status');
        $adminPass = $post->value('password');
        $roles = $post->value('roles');
        if (!$roles) $roles = array();

        // validate postback
        $msg = array();
        if (!$id && empty($username)) $msg[] = Raxan::locale('username');
        if (empty($firstname)) $msg[] = Raxan::locale('firstname');
        if (empty($lastname)) $msg[] = Raxan::locale('lastname');
        if (empty($email)) $msg[] = Raxan::locale('email.address');
        else if ($email != $email2) $msg[] = Raxan::locale('email.address') . ' - ' . Raxan::locale('type.mismatch');
        else if (!$post->isEmail('email')) $msg[] = Raxan::locale('email.address') . ' - ' . Raxan::locale('invalid.email');
        if (!empty($msg)) {
            // show message
            $msg = implode(', ', $msg);
            $msg = '<strong>' . Raxan::locale('missing.fields') . '</strong>:<br />' . $msg;
            $this->flashmsg($msg, 'fade', 'rax-box alert', 'msgbox');
            return;
        }

        $sessid = Raxan::data('csf-session-id');

        try {
            // valdiate admin user
            $userId = User::getUserId();
            $validUser = User::validateUserPass($userId, $adminPass);
            if (!$validUser) {
                $msg = '<strong>' . Raxan::locale('update.failed') . '</strong>:<br />' .
                       Raxan::locale('admin.validation.failed');
                $this->flashmsg($msg, 'bounce', 'rax-box alert', 'msgbox');
                return;
            }

            // build applet properties
            $newprops = array();
            $props = $this->data('applet.codes');
            if (is_array($props)) {
                foreach ($_POST as $n => $v) {
                    $n = str_replace('_', '.', trim($n));
                    $a = explode('.', $n);
                    $a = $a[0];
                    if (in_array($a, $props)) {
                        $entry = new \CSFAdminWSService\entry();
                        $entry->key = $n;
                        $entry->value = strip_tags($v);
                        $newprops[] = $entry;
                    }
                }
            }

            $subject = new \CSFAdminWSService\subject();
            $subject->id = $id;
            $subject->domainID = User::getUserInfo()->domainID; // set user domain to the same domain as the admin
            $subject->userName = $username;
            $subject->email = $email;
            $subject->firstName = $firstname;
            $subject->lastName = $lastname;
            $subject->status = $status;
            $subject->properties = $newprops;
            $subject->versionNbr = $versionNbr;

            if ($id) User::updateUser($subject,$roles);
            else User::createUser($subject, $roles);
            $this->redirectTo('admin.php');
        }
        catch (DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            if ($code=='ERR010') $msg = Raxan::locale('admin.validation.failed');
            $msg = '<strong>' . Raxan::locale('update.failed') . '</strong>:<br />' . $msg;
            $this->flashmsg($msg, 'fade', 'rax-box error', 'msgbox'); // flash to msgbox
            return;
        }
        catch (Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }
    }

    // load Roles
    protected function loadRoles() {
        try {
            $roles = User::getDomainRoles();
            if (empty($roles)) $this['.roles']->html(''); // clear roles template
            else {
                $arr = array();
                if (!is_array($roles)) $roles = array($roles); // make sure it's an array
                foreach ($roles as $role) {
                    $arr[] = (array)$role;
                }
                $this['.roles']->bind($arr);
            }
        }
        catch (DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>' . Raxan::locale('request.failed') . '</strong>:<br />' . $msg;
            $this->flashmsg($msg, 'fade', 'rax-box error', 'msgbox'); // flash to msgbox
            return;
        }
        catch (Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }
    }

    // load applet controls
    protected function loadAppletControls($properties = array()) {

        global $_APPLET_PROPERTIES;

        try {
            $applets = User::getDomainApplets();
            $_APPLET_PROPERTIES = $properties;
            $controls = array();
            $appletCodes = array();
            if (!is_array($applets))
                $applets = array($applets);
            foreach ($applets as $applet) {
                $appletCode = $applet->code;
                $appletCodes[] = $appletCode;
                // call csf user control applet.
                if (file_exists('app/' . $appletCode . '/csf.user.control.php')) {
                    ob_start();
                    include 'app/' . $appletCode . '/csf.user.control.php';
                    $controls[] = ob_get_clean();
                }
            }
            $controls = implode('<hr />', $controls);
            $this['.applets']->html($controls);
            $this->data('applet.codes', $appletCodes);
        }
        catch (DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>' . Raxan::locale('request.failed') . '</strong>:<br />' . $msg;
            $this->flashmsg($msg, 'fade', 'rax-box error', 'msgbox'); // flash to msgbox
            return;
        }
        catch (Exception $ex) {
            // general exception
            Shared::logRedirectToErrorPage(Consts::ERROR_MODE_SYSERR, $ex);
        }
    }

    /**
     * Load user data
     */
    protected function loadUserData() {

        try {
            $user = User::getUserInfoWithRoles($this->uid);
            if ($user) {
                $data = array();
                $data['userid'] = $user->id;
                $data['username'] = $user->userName;
                $data['first_name'] = $user->firstName;
                $data['last_name'] = $user->lastName;
                $data['email'] = $user->email;
                $data['email2'] = $user->email;
                $data['status'] = $user->status;
                $data['roles'] = isset($user->roles) ? $user->roles : array();
                $this['.webform input, .webform select']->val($data);
                // lock user name field
                $this['#username']->attr('disabled', 'disabled');
                // load applets
                if (isset($user->properties)) {
                    // convert properties to hash-array
                    $props = array();
                    if (isset($user->properties->entry)) {
                        $entries = is_array($user->properties->entry) ? $user->properties->entry : array($user->properties->entry);
                        foreach ($entries as $entry) {
                            $props[$entry->key] = $entry->value;
                        }
                    }
                }
                $this->loadAppletControls($props);
                $this->data('applet_properites', $props); // applet properies
                $this->data('record_id', $this->uid); // store the id of the record that's being edited
                $this->data('record_version', $user->versionNbr); // store record version
            } else {
                $msg = Raxan::locale('record.notfound');
                c()->alert($msg)->redirectTo('admin.php');
            }
        }
        catch (DataModelException $ex) {
            // data model exception
            $code = $ex->getLastErrorCode();
            $params = $ex->getLastErrorCodeParams();
            $msg = Shared::getErrorMessage($code, $params);
            $msg = '<strong>' . Raxan::locale('request.failed') . '</strong>:<br />' . $msg;
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