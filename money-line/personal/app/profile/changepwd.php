<?php

require_once '../../includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Common\Model\SysInfo;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Model\User;
use Moneyline\Personal\SecureWebPageController;

/**
 * Description of Changepwd
 * @author lloydj
 */
class Changepwd extends SecureWebPageController{

    protected $moduleId = 6; // USER PROFILE
    
    const ERROR_MSG_PASSWORD_NOT_SAVED              ="PASSWORDNOTCHANGED";
    const SAVED_MSG_USER_PREFERENCES_SAVED          ="UserPreferencesSavedMessage";
    const ERROR_MSG_USER_PREFERENCES_SV_FAILED       ="USERPREFERENCESVFAILED";
    const EMAIL_MSG_EMAIL_VERIFICATION_SENT         ="EMAILSECUIRTYKEY";
    const ERROR_MSG_EMAIL_SECUIRTY_KEY_UP              ="EMAILSECUIRTYKEYUP";

    const LANG_FILE_NAME                                ="Changepwd";
    const ERROR_FILE_NAME                               ="errors";
    const DATA_USER                                     ="user";
//    const DATA_USERPREFERENCES                          ="userpreferences";
    const DATA_LOGIN_NAME                               ="login-name";


      protected function _config() {
        parent::_config();
        Raxan::loadLangFile(self::LANG_FILE_NAME);
        $this->mnuItem = 'CPWD';
        $this->preserveFromContent = true;
    }

 protected function _indexView(){
        $this->appendView('changepwd.view.php');
    }

     protected function _load() {
        parent::_load();

         // register locale for use on client
        if (!$this->isAjaxRequest) {

            $topMenu = $this->getTopLevelMenuId($this->mnuItem);
            $menus = User::getUserMenus($topMenu);
            if (isset($menus[0]) && $menus[0]['menuId']==$this->mnuItem) {
                array_shift($menus); // remove overview menu
            }

            $this["#help"]->bind("#click",array(
            "callback"=>".showHelp",
            //"data"=>"login",
            "prefTarget"=>"target@help.php?vuh=profile"
            ));

            //
            $this->registerVar('password-missing', $this->Raxan->locale('password-missing'));
            $this->registerVar('old-password-missing', $this->Raxan->locale('old-password-missing'));
            $this->registerVar('retype-password-missing', $this->Raxan->locale('retype-password-missing'));
            $this->registerVar('password-mismatched', $this->Raxan->locale('password-mismatched'));
            $this->registerVar('min-password-length', $this->Raxan->locale('min-password-length'));

            $this->sanitizer = Raxan::dataSanitizer();
            $this->sanitizer->enableDirectInput();
            


        }
    }


    protected function showSecurityQuestions()
    {
        $user = Raxan::data(self::DATA_USER);
        //get security questions
        $securityQuestions =User::getSecurityQuestions($user);
        Raxan::data("securityQuestions", $securityQuestions);
        C('#question1')->html($securityQuestions["ques1"]["question"]);
        C('#question2')->html($securityQuestions["ques2"]["question"]);

    }


    /*
     *
     * @param RaxanEvent $e
     */
    protected function sendVerificationCode($e)
    {
        $username="";
        try
        {
            $user = Raxan::data(self::DATA_USER);
            $username = $user->username;
            $verificationKey = $this->getEmailVerificationKey($user);
              if($verificationKey)
              {
                  Raxan::data("verificationKey", $verificationKey);
                  Raxan::loadLangFile(self::LANG_FILE_NAME);
                  $msg =  Raxan::locale(self::EMAIL_MSG_EMAIL_VERIFICATION_SENT);
                  $msg.="<br><h3 class='clear'>Security Code</h3><br><p>This security code is display only for development & testing purpose.<br/>Security code:<strong>$verificationKey</strong></p>";
                  $this->showMessage($msg);

                  AccessLog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_SENT);
              }else
              {
                Raxan::loadLangFile(self::ERROR_FILE_NAME);
                $msg =  Raxan::locale(self::ERROR_MSG_EMAIL_SECUIRTY_KEY_UP);
                $this->showErrorMessage($msg);
                AccessLog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_NOT_SENT);
                return;
              }
        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
            AccessLog::log(AccessLog::ACTION_CANNOT_RESEND_VERIFICATION_KEY);

            return null;

        }

    }

    private function collectUserData()
    {
        $username=Shared::data(self::DATA_LOGIN_NAME);
        try
        {
            $oldPassword = $this->post->pwdOld;
            $newPassword = $this->post->pwdNew;
            Raxan::data("oldpwd", $oldPassword);
            Raxan::data("newpwd",$newPassword);
            return true;
        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
            AccessLog::log(AccessLog::ACTION_CANNOT_RESEND_VERIFICATION_KEY);

        }
        return false;
    }

    private function saveUserData()
    {
        $username=Shared::data(self::DATA_LOGIN_NAME);
        try
        {


            $customerId     = User::getCustomerId();
            $securityToken  = User::getSecurityToken();

            $oldPassword = Raxan::data("oldpwd");
            $newPassword = Raxan::data("newpwd");
            Raxan::data("SYSERRMSG","");


            if(User::changePassword($username, $customerId, $securityToken, $oldPassword, $newPassword ))
            {
                $selector = 'passwordChangedMessage';
                Raxan::loadLangFile(self::LANG_FILE_NAME);
                $msg = Raxan::locale($selector);
                $this->showSuccessMessage($msg);

                Accesslog::log(Accesslog::ACTION_PASSWORD_CHANGED);

                Raxan::data("oldpwd", "");
                Raxan::data("newpwd","");

            }else
            {
                     $selector = 'passwordNotChangedMessage';
                     Raxan::loadLangFile(self::LANG_FILE_NAME);
                     $msg = Raxan::locale($selector);
                     $this->showErrorMessage($msg);
                    Accesslog::log(Accesslog::ACTION_PASSWORD_NOT_CHANGED);

                    return false;
            }

            return true;
        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
            AccessLog::log(AccessLog::ACTION_PASSWORD_NOT_CHANGED);

        }
        return false;
    }


    /*
     *
     * @param RaxanEvent $e
     */

    protected function showSecurityVerification($e)
    {
        $username = Shared::data(self::DATA_LOGIN_NAME);

        try
        {


            if($this->collectUserData())
            {
                $user = Raxan::data(self::DATA_USER);

                $verificationKey = $this->getEmailVerificationKey($user);
              if($verificationKey)
              {
                  Raxan::data("verificationKey", $verificationKey);
                  Raxan::loadLangFile(self::LANG_FILE_NAME);
                  $msg =  Raxan::locale(self::EMAIL_MSG_EMAIL_VERIFICATION_SENT);
                  $msg.="<br><h3 class='clear'>Security Code</h3><br><p>This security code is display only for development & testing purpose.<br/>Security code:<strong>$verificationKey</strong></p>";
                  $this->showMessage($msg);

                  AccessLog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_SENT);

                     
                    $sv = _var("upsecurityVerification");
                    C()->evaluate("showUPSection($sv,true)");
                    $this->showSecurityQuestions();
                    AccessLog::log(AccessLog::ACTION_SHOW_SECURITY_VERIFICATION );
                    return;

              }else
              {
                Raxan::loadLangFile(self::ERROR_FILE_NAME);
                $msg =  Raxan::locale(self::ERROR_MSG_EMAIL_SECUIRTY_KEY_UP);
                $this->showErrorMessage($msg);
                AccessLog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_NOT_SENT);
                return;
              }
            }
            {

                Raxan::loadLangFile(self::ERROR_FILE_NAME);
                $msg = Raxan::locale(self::ERROR_MSG_PASSWORD_NOT_SAVED);
                $this->showErrorMessage($msg);
                Accesslog::log(Accesslog::ACTION_PASSWORD_NOT_CHANGED);

            }



        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
            AccessLog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_NOT_SENT);

            return null;

        }
    }

     /*
     * @param RaxanEvent $e
     *
     */

    protected function verifySecurity($e)
    {
        $username=Shared::data(self::DATA_LOGIN_NAME);
        $this->registerVar('verify',"failed");
        try
        {
            //verify security code
            $seccode                = $this->post->emVerifyCode;
            $pinNo                  = $this->post->secPIN;
            $sqAnswer1              = $this->post->questans1;
            $sqAnswer2              = $this->post->questans2;

            $verificationKey        = Raxan::data("verificationKey");

            if($verificationKey != $seccode )
            {
               Raxan::loadLangFile(self::ERROR_FILE_NAME);
               $msg = Raxan::locale(self::ERROR_MSG_USER_PREFERENCES_SV_FAILED);
               $msg .= "<br><strong>security code</strong>";
               $this->showErrorMessage($msg);
               AccessLog::log(AccessLog::ACTION_INVALID_SECURITY_CODE);

                return ;
             }

            $user1 = User::validateUserByPin($username, $pinNo);
            $loginStatus = $user1->loginStatus;


            // check if login status was successful
            if (!($loginStatus == User::LOGIN_STATUS_OK ||
                    $loginStatus == User::LOGIN_STATUS_PWDEXPIRE ||
                    $loginStatus == User::LOGIN_STATUS_LOCKED)) {
                Raxan::loadLangFile(self::ERROR_FILE_NAME);
                $msg = Raxan::locale(self::ERROR_MSG_USER_PREFERENCES_SV_FAILED);
                $msg .= "<br><strong>security PIN</strong><br><strong>$loginStatus</strong>";
                $this->showErrorMessage($msg);


                AccessLog::log(AccessLog::ACTION_INVALID_PIN);
                return null;
            }


            $sqAnswers              = array();
            $sqAnswers[]            = $sqAnswer1;
            $sqAnswers[]            = $sqAnswer2;
             $user                  = Raxan::data(self::DATA_USER);

         if(!User::validateSecurityQuestionsAnswers($user, $sqAnswers))
         {

                Raxan::loadLangFile(self::ERROR_FILE_NAME);
                $msg = Raxan::locale(self::ERROR_MSG_USER_PREFERENCES_SV_FAILED);
                $msg .= "<br><strong>security questions</strong>";
                $this->showErrorMessage($msg);
                AccessLog::log(AccessLog::ACTION_INCORRECT_SECURITY_ANSWERS);
                return;

         }



          if($this->saveUserData())
          {
             
             //show save button

          }
          $sv = _var("upPreferences");
          C()->evaluate("showUPSection($sv,true)");
          C()->evaluate("clearValues()");

          $this->registerVar('verify',"success");
        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
            AccessLog::log(AccessLog::ACTION_CANNOT_SAVE_USER_PREFERENCES);

            return null;

        }
    }

    private function getEmailVerificationKey($user)
    {

       try
        {

            return User::EmailVerificationKey($user);

        }catch(Exception $e)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level,$label );
            return null;
        }
    }
}
?>
