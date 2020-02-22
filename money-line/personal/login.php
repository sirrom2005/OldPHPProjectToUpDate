<?php

require_once 'includes.php';
require_once PERSONAL_MODEL_PATH.'user.php';
require_once PERSONAL_MODEL_PATH.'rememberSQ.php';
//require_once 'models/securityQuestions';  // load security questions model


use Moneyline\Common\Model\AccessLog;
use Moneyline\Personal\Consts;
use Moneyline\Personal\DataKeys;
use Moneyline\Personal\Shared;
use Moneyline\Personal\PublicWebPageController;
use Moneyline\Personal\Model\User;

/*
 * Login Page
 */
class LoginPage extends PublicWebPageController {

    protected $internal;
    
    protected $moduleId = 1; // LOGIN

    const HOME_PAGE                             = 'app/accsum';
    const LOGIN_ACTION_CHANGE_PASSWORD          = "change password";
    const LOGIN_ACTION_CHANGE_PIN               = "change pin";
    const LOGIN_ACTION_NO_SECURITY_QUESTIONS    = "no security questions";
    const LOGIN_ACTION_CHECK_SECURITY_QUESTIONS = "check security questions";
    const LOGIN_ACTION_SECURITY_QUESTIONS       = "security questions";
    const LOGIN_ACTION_VERIFY_PIN               = 'verify pin';

    
    protected function _config() {
        parent::_config();       
        
        Raxan::loadLangFile('login');   // login language file
        $this->preserveFromContent = true;
    }
    
    protected function _init() {
        parent::_init();

        // check if user is already logged in
        if (User::isLogin()) $this->redirectTo(self::HOME_PAGE);
        
        // append view
        if (Shared::isMobileDevice()) $this->appendView('mobile.login.index.php');
        else $this->appendView('login.view.php');

        //$this->appendView('mobile.login.index.php');
        
        //$_SESSION["mobile-user"] = $this->isMobileDevice;
       /// $this->appendView('mobile.login.index.php');

        // register locale for use on client
        if (!$this->isAjaxRequest) {
            $this->registerVar('username-missing', $this->Raxan->locale('username-missing'));
            $this->registerVar('password-missing', $this->Raxan->locale('password-missing'));
            $this->registerVar('old-password-missing', $this->Raxan->locale('old-password-missing'));
            $this->registerVar('pin-missing', $this->Raxan->locale('pin-missing'));
            $this->registerVar('securityans-missing', $this->Raxan->locale('securityans-missing'));
            $this->registerVar('securityans-incorrect', $this->Raxan->locale('securityans-incorrect'));
            $this->registerVar('email-missing', $this->Raxan->locale('email-missing'));
            $this->registerVar('securitycode-missing', $this->Raxan->locale('securitycode-missing'));
            $this->registerVar('invalidate.user', $this->Raxan->locale('invalidate.user'));

            $this->registerVar('retype-password-missing', $this->Raxan->locale('retype-password-missing'));
            $this->registerVar('password-mismatched', $this->Raxan->locale('password-mismatched'));
            $this->registerVar('min-password-length', $this->Raxan->locale('min-password-length'));

            $this->registerVar('select-security-question', $this->Raxan->locale('select-security-question'));
            $this->registerVar('missing-security-question-answer', $this->Raxan->locale('missing-security-question-answer'));
           $this->registerVar('old-pin-missing', $this->Raxan->locale('old-pin-missing'));
           $this->registerVar('min-pin-length', $this->Raxan->locale('min-pin-length'));
            $this->registerVar('retype-pin-missing', $this->Raxan->locale('retype-pin-missing'));
            $this->registerVar('pin-mismatched', $this->Raxan->locale('pin-mismatched'));
            $this->registerVar('pin-not-numeric', $this->Raxan->locale('pin-not-numeric'));
            $this->registerVar('security.confirm.answer-missing', $this->Raxan->locale('security.confirm.answer-missing'));
            $this->registerVar('security.confirm.answer-mismatch', $this->Raxan->locale('security.confirm.answer-mismatch'));
            $this->registerVar('pin-start-zero', $this->Raxan->locale('pin-start-zero'));
            $this->registerVar('pin-in-special-sequence', $this->Raxan->locale('pin-in-special-sequence'));


             User::loadSecurityQuestions();
             //$this->registerEvent('ok','.okChangePassword');
             //$this->registerEvent('cancel','.cancelChangePassword');
             $this["#help"]->bind("#click",array(
            "callback"=>".showHelp",
            //"data"=>"login",
            "prefTarget"=>"target@help.php?vuh=login"
            ));
             



            
       }

 


    }

    protected function _load() {
        parent::_load();

        $this->internal = Raxan::config('use-internal');

        if ($this->internal)  {
            // display internal login - remove external elements
            $this['.external']->remove(); // @todo Convert to ID
        }
        else {
            // display public login - remove internal elements
            $this['.internal']->remove();                   // @todo Convert to ID
            $this['.external']->removeClass('external');    // @todo Convert to ID
        }

        // load default tip
        if (!$this->isAjaxRequest && !Shared::isMobileDevice()) {
            $t = User::getRandomTip();
            $this->setTip($t['type'],$t['tip'],$t['title']);
        }

        // show date
        $dt = Raxan::cDate();
        $this->currentdate->text($dt->format('l, F j, Y'));
//
//        if (!$this->internal && !$this->isPostBack) {
//            $lastuser = User::getLastLoginName();
//            if ($lastuser) {
//                $this->username->val($lastuser);
//                //$this->rememberme->attr('checked','checked');
//            }
//        }

        

    }

    protected function loginActions($action)
    {
        $loginaction = _var($action);
        C()->evaluate("loginActions($loginaction)");
    }


    protected function showCheckSecurityQuestions()
    {
        $user = Raxan::data("user");
        //get security questions
        $securityQuestions =User::getSecurityQuestions($user);
        Raxan::data("securityQuestions", $securityQuestions);
        $this->registerVar('securityQuestions',$securityQuestions);
        $sq = _var($securityQuestions);
            //load security questions in UI
        C()->evaluate("showSecurityQuestions($sq,'checksecurityquestions')");
        //display check security questions
        $this->loginActions(self::LOGIN_ACTION_CHECK_SECURITY_QUESTIONS);
    }

    protected function showSecurityQuestions()
    {
        $user = Raxan::data("user");
        //get security questions
        $securityQuestions =User::getSecurityQuestions($user);
        Raxan::data("securityQuestions", $securityQuestions);
        $this->registerVar('securityQuestions',$securityQuestions);
        $sq = _var($securityQuestions);
            //load security questions in UI
        C()->evaluate("showSecurityQuestions($sq,'securityquestions')");
        //display check security questions
        $this->loginActions(self::LOGIN_ACTION_SECURITY_QUESTIONS);
    }

    /**
     * ok - change password
     * This event is triggered from a login button on the web page
     * @param RaxanEvent $e
     */
     
    protected function confirmOk($e)
    {
         $username="";
        try {
            $user = Raxan::data('user');
            $username = $user->username;

            
            //$this->showCheckSecurityQuestions();
            
//            $selector = 'forcePasswordChangeMessage';
//            Raxan::loadLangFile('login');
//            $msg = Raxan::locale($selector);
//            $this->showMessage($msg);
            //display check security questions
            $this->loginActions(self::LOGIN_ACTION_CHANGE_PASSWORD);
            //AccessLog::log(AccessLog::ACTION_PASSWORD_DAYS_TO_EXPIRY_OK);
        }catch(Exception $ex)
        {
          $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_SYSERR);
            $this->showErrorMessage($msg);
            Shared::logRedirectToErrorPage($err, $ex, $level,$label );

            Accesslog::log(Accesslog::ACTION_INVALID_LOGIN);
            return null;

        }
    }


    /**
     * cancel - change password
     * This event is triggered from a login button on the web page
     * @param RaxanEvent $e
     */

    protected function confirmCancel($e)
    {

        $username="";
        try
        {
         set_time_limit(130);  /* Give sufficient time for dbase connection */
        $user = Raxan::data('user');
        $username = $user->username;
        //redirect to home page
        //AccessLog::log(AccessLog::ACTION_PASSWORD_DAYS_TO_EXPIRY_CANCEL);

        // continue login process

        

            // user password days exipred
            if(User::checkPasswordExpiry($user))
            {
                AccessLog::log(AccessLog::ACTION_PASSWORD_DAYS_TO_EXPIRY_PASS);
                $selector = 'passwordExpireMessage';
                Raxan::data("nextmsg",$selector);
                 
                $this->registerVar('loginaction', '');
                 $this->showCheckSecurityQuestions();
                return;

            }else

            // user are forced to change password
            if(user::checkForcePasswordChange($user))
            {
                AccessLog::log(AccessLog::ACTION_FORCE_PASSWORD_CHANGE_ENABLED);
                $selector = 'forcePasswordChangeMessage';
                Raxan::data("nextmsg",$selector);
//                 Raxan::loadLangFile('login');
//                 $msg = Raxan::locale($selector);
//
//                $this->showMessage($msg);
                //$this->registerVar('loginaction', 'change password');
                 $this->showCheckSecurityQuestions();
                return;

            }else

            // user are forced to change his or her pi

           if(User::checkForcePinChange($user))
            {
                AccessLog::log(AccessLog::ACTION_FORCE_PIN_CHANGE_ENABLED);
                $selector = 'forcePINChangeMessage';
                Raxan::data("nextmsg",$selector);
//                 Raxan::loadLangFile('login');
//                 $msg = Raxan::locale($selector);
//
//                $this->showMessage($msg);
                //$this->registerVar('loginaction', 'change pin');
                 $this->showCheckSecurityQuestions();
                return;

            }

       // check should user allow login with security questions
        if(User::allowSecurityQuestionsCheck($user) && ! User::checkPasswordWarningDays($user))
        {
            $rememberSC = User::allowRememberSecurityQuestions($user);
            $isRegisterPC = rememberSQ::isRegisteredPC($user->username);

            if( ! ($rememberSC &&  $isRegisterPC) )
            {
                
                if(!User::checkSecurityQuestions($user))
                {
                    $selector = 'noSQMessage';
                     Raxan::loadLangFile('login');
                     $msg = Raxan::locale($selector);
                    
                    $this->showErrorMessage($msg);
                    //$this->registerVar('loginaction', 'no security questions');
                    
                    $this->loginActions(self::LOGIN_ACTION_VERIFY_PIN);
                    Accesslog::log(Accesslog::ACTION_NO_SECURITY_QUESTIONS);
                  return;
                }
                if($rememberSC  && !$isRegisterPC)
                {
                  // Show warning message
                    //Raxan::loadLangFile('errors');
                    //$msg = Raxan::locale(Shared::LOGIN_REMEMBERPC);
                   // $this->showErrorMessage($msg);
                }
                //$this->rememberpc->attr('checked','checked');
                //
                if(! $rememberSC)
                {
                    //$this->rememberpc->attr('checked','checked');
                    C("#cntRememberPC")->addClass("hide");
                }
//                $securityQuestions =User::getSecurityQuestions($user);
//
//                Raxan::data('securityQuestions', $securityQuestions);
//
//                $this->registerVar('securityQuestions',$securityQuestions);
                $this->showSecurityQuestions();
                Accesslog::log(Accesslog::ACTION_USER_LOGIN_VALIDATED);
                return ;
            }

        }// login user directly

        
        if(User::login($user))
        {
             Accesslog::log(AccessLog::ACTION_LOGIN_SUCCESSFUL);
             $this->redirectTo(self::HOME_PAGE);
        }else
        {
            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_INVALIDLOGIN);
            $this->showErrorMessage($msg);

            Accesslog::log(Accesslog::ACTION_INVALID_LOGIN);

        }
        }catch(Exception $ex)
        {
           $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_SYSERR);
            $this->showErrorMessage($msg);
            Shared::logRedirectToErrorPage($err, $ex, $level,$label );

            Accesslog::log(Accesslog::ACTION_INVALID_LOGIN);
            return null;

        }

     }



    /**
     * Validatelogin
     * This event is triggered from a login button on the web page
     * @param RaxanExvent $e
     */

    protected function validateLogin($e)
    {

        $username="";
          
        try
        {
         set_time_limit(130);  /* Give sufficient time for dbase connection */

        $username=$this->username->textVal();
        $password =$this->password->val();
        $internal = $this->internal;
        $remember = isset($_POST['rememberme']);
        
        $this->registerVar('securityQuestions',null);
        $this->registerVar('loginaction', '');
        $user = User::validateUser($username, $password);
        $loginStatus = $user->loginStatus;


        
        if(! $this->checkLoginStatus($loginStatus))
        {
            Accesslog::log(Accesslog::ACTION_LOGIN_FAILED);
            return;
        }

        Raxan::data('user', $user); //set user information in session
        $actionType = User::getLoginActionFlow();
            // users with status set as new
            if(User::checkNewUserStatus($user))
            {
                Accesslog::log(AccessLog::ACTION_CHANGE_PASSWORD_NEW_USER);
                if(User::checkForcePinChange($user) && User::checkForcePasswordChange($user)&&
                       ! User::checkSecurityQuestions($user))
                {
                    $selector = 'welcomeMessage';
                    $this->registerVar('loginaction', 'change password');
                    Raxan::data("changeActions",7);
                }else
                if(User::checkForcePinChange($user) && User::checkForcePasswordChange($user)&&
                        User::checkSecurityQuestions($user) )
                {
                    $selector = 'changePasswordnPinMessage';
                    $this->registerVar('loginaction', 'change password');
                    Raxan::data("changeActions",3);
                }else
                if(! User::checkSecurityQuestions($user) && User::checkForcePasswordChange($user))
                {
                    $selector = 'changePasswordnSQMessage';
                    $this->registerVar('loginaction', 'change password');
                    Raxan::data("changeActions",5);
                }else
                if(! User::checkSecurityQuestions($user) && User::checkForcePinChange($user))
                {
                    $selector = 'changePINnSQMessage';
                    $this->registerVar('loginaction', 'change pin');
                    Raxan::data("changeActions", 6);
                }else
                if(! User::checkSecurityQuestions($user) )
                {
                    $selector = 'noSQMessage';
                    $this->registerVar('loginaction', 'set security questions');
                    Raxan::data("changeActions", 4);
                }else
                 if(User::checkForcePinChange($user))
                {
                    $selector = 'forcePINChangeMessage';
                    $this->registerVar('loginaction', 'change pin');
                    Raxan::data("changeActions", 2);
                }else
                if(User::checkForcePasswordChange($user))
                {
                    $selector = 'forcePasswordChangeMessage';
                    $this->registerVar('loginaction', 'change password');
                    Raxan::data("changeActions",1);
                }
                {

                }
                 Raxan::loadLangFile('login');
                 $msg = Raxan::locale($selector);

                $this->showMessage($msg);
                
                return;

            }else
           // This allows the user to change password, pin, or setup security questions
           // in a workflow process
           if($actionType == 3 || $actionType > 4)
           {
               switch ($actionType)
               {
                  case 3:
                  case 5:
                  case 7:
                     if($actionType == 3)
                        Accesslog::log(AccessLog::ACTION_CHANGE_PASSWORD_SETUP_SECURITY_QUESTIONS);
                     else
                     if($actionType == 5)
                        Accesslog::log(AccessLog::ACTION_CHANGE_PASSWORD_PIN);
                     else
                     if($actionType == 7)
                        Accesslog::log(AccessLog::ACTION_CHANGE_PASSWORD_PIN_SETUP_SECURITY_QUESTIONS);

                     $selector = User::showStartActionMessage();
                     

                    
                    if($actionType == 3)
                    {
                        Raxan::data("nextmsg",$selector);
                        $this->showCheckSecurityQuestions();
                    }
                    else
                    {
                        Raxan::loadLangFile('login');
                        $msg = Raxan::locale($selector);
                        $this->showMessage($msg);
                        $this->registerVar('loginaction', 'change password');
                    }
                    return;

                      break;
                  case 6:
                    Accesslog::log(AccessLog::ACTION_CHANGE_PIN_SETUP_SECURITY_QUESTIONS);
                    $selector = User::showStartActionMessage();
                     Raxan::loadLangFile('login');
                     $msg = Raxan::locale($selector);

                    $this->showMessage($msg);
                    $this->registerVar('loginaction', 'change pin');
                    return;

                      break;
               }
           }else
            if(User::checkPasswordWarningDays($user))
            {
                Accesslog::log(AccessLog::ACTION_PASSWORD_DAYS_TO_EXPIRY_ALERT);
               $this->showCheckSecurityQuestions();
//                $selector = 'passwordDaysToExpiryMessage';
//                 Raxan::loadLangFile('login');
//                 $msg = Raxan::locale($selector);
//                 $msg = str_replace("{daysToExpiry}",$user->daysToExpiry,$msg);
//                $this->showConfirmMessage($msg);
               return;
            }else

            // user password days exipred
            if(User::checkPasswordExpiry($user))
            {
                Accesslog::log(AccessLog::ACTION_PASSWORD_DAYS_TO_EXPIRY_PASS);
                $selector = 'passwordExpireMessage';
                Raxan::data("nextmsg",$selector);
//                 Raxan::loadLangFile('login');
//                 $msg = Raxan::locale($selector);
//
//                $this->showMessage($msg);
                $this->showCheckSecurityQuestions();
                return;

            }else

            // user are forced to change password
            if(User::checkForcePasswordChange($user))
            {
                Accesslog::log(AccessLog::ACTION_FORCE_PASSWORD_CHANGE_ENABLED);
                $selector = 'forcePasswordChangeMessage';
                Raxan::data("nextmsg",$selector);
//                 Raxan::loadLangFile('login');
//                 $msg = Raxan::locale($selector);
//
//                $this->showMessage($msg);
                $this->showCheckSecurityQuestions();
                return;

            }else

            // user are forced to change his or her pi

           if(User::checkForcePinChange($user))
            {
                Accesslog::log(AccessLog::ACTION_FORCE_PIN_CHANGE_ENABLED);
                $selector = 'forcePINChangeMessage';
                Raxan::data("nextmsg",$selector);
//                 Raxan::loadLangFile('login');
//                 $msg = Raxan::locale($selector);
//
//                $this->showMessage($msg);
                $this->showCheckSecurityQuestions();
                return;

            }


       // check should user allow login with security questions
       if(User::allowSecurityQuestionsCheck($user))
        {
            $rememberSC = User::allowRememberSecurityQuestions($user);
            $isRegisterPC = rememberSQ::isRegisteredPC($user->username);

           // $this->halt("is Register PC: ".$isRegisterPC." cookie value details: ".rememberSQ::cookieValue());
            if( ! ($rememberSC &&  $isRegisterPC) )
            {
                
                if(!User::checkSecurityQuestions($user))
                {
                    $selector = 'noSQMessage';
                     Raxan::loadLangFile('login');
                     $msg = Raxan::locale($selector);
                    
                    $this->showErrorMessage($msg);
                    ///$this->registerVar('loginaction', 'no security questions');
                    $this->registerVar('loginaction', 'verify pin');
                    Accesslog::log(Accesslog::ACTION_NO_SECURITY_QUESTIONS);
                  return;
                }
                if($rememberSC  && !$isRegisterPC)
                {
                  // Show warning message
                    //Raxan::loadLangFile('errors');
                    //$msg = Raxan::locale(Shared::LOGIN_REMEMBERPC);
                    //$this->showErrorMessage($msg);
                }
                if(! $rememberSC)
                {
                    //$this->rememberpc->attr('checked','checked');
                    C("#cntRememberPC")->addClass("hide");
                }
                $this->showSecurityQuestions();
                Accesslog::log(Accesslog::ACTION_USER_LOGIN_VALIDATED);
                return ;
            }

        }// login user directly

         

//        return;
        {
            //login user all checks are completed
            if(User::login($user))
            {
                 Accesslog::log(AccessLog::ACTION_LOGIN_SUCCESSFUL);
                 $this->redirectTo(self::HOME_PAGE);
            }else
            {
  
                Raxan::loadLangFile('errors');
                $msg = Raxan::locale(Shared::ERROR_MODE_INVALIDLOGIN);
                $this->showErrorMessage($msg);
 
                Accesslog::log(Accesslog::ACTION_INVALID_LOGIN);

            }
        }
        //register the security questions varible for the client to use

        


    }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_SYSERR);
            $this->showMessage($msg);
            Shared::logRedirectToErrorPage($err, $ex, $level,$label );

            Accesslog::log(Accesslog::ACTION_INVALID_LOGIN);
            return null;

        }

    }

    

    private function checkLoginStatus($loginStatus)
    {

        $loginStatus = trim(strtoupper($loginStatus));
        
        if ($loginStatus == User::LOGIN_STATUS_TOOMANYDAYS) {
            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_TOOMANYDAYS);
            $this->showErrorMessage($msg);

            return false;
        }

        if ($loginStatus == User::LOGIN_STAUS_ACCOUNTLOCK
                || $loginStatus == User::LOGIN_STATUS_LOCKED) {
            if ($loginStatus == "ACCOUNTLOCK") {
                $remoteaddr = $_SERVER["REMOTE_ADDR"];
                $remotehost = gethostbyaddr($remoteaddr);
                $email = Raxan::config('site.email');
            }
            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_LOCKED);
            $this->showErrorMessage($msg);
            return false;
        }

        if ($loginStatus == User::LOGIN_STATUS_INVALIDLOGIN) {
            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_INVALIDLOGIN);
            $this->showErrorMessage($msg);
            return false;
        }

        // check if login status was successful
        if (!($loginStatus == User::LOGIN_STATUS_OK ||
                $loginStatus == User::LOGIN_STATUS_PWDEXPIRE)) {
            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_NETWORKDOWN);
            $this->showErrorMessage($msg);
            return false;
        }

        return true;
    }

    private function setRememberMe($username)
    {
          try
          {    // set remember me
             if(Raxan::data('rememberme') != null)   {
                 if(Raxan::data('rememberme')){
                        $one_week_in_seconds = 60*60*24*7;
                        $cookie_life = time() + $one_week_in_seconds;
                        setcookie("login_id",$username, $cookie_life);
                    }else {
                        setcookie("login_id","", time() - 3600);
                    }
                    Raxan::data('rememberme',null);
             }

       }catch(Exception $ex)
            {
                $err = Shared::ERROR_MODE_SYSERR;
                $level = 'ERROR';
                $label = 'Login';

                Shared::logRedirectToErrorPage($err, $ex, $level,$label );
                return null;

            }

    }

    
    /***
     *
     * @param
     *
     */

    /**
     * This validates user security questions
     * @param RaxanEvent $e
     */
    protected function checkAnswers($e)
    {
        $username="";
        try
        {
            set_time_limit(130);  /* Give sufficient time for dbase connection */


            $user                  = Raxan::data('user');
        
            $username = $user->username;
            $rememberpc = isset($_POST['rememberpc']);
         

            $sqAnswer1              = $this->questans1->textVal();
            $sqAnswer2              = $this->questans2->textVal();
            $sqAnswers              = array();
            $sqAnswers[]            = $sqAnswer1;
            $sqAnswers[]            = $sqAnswer2;

            
         if(User::validateSecurityQuestionsAnswers($user, $sqAnswers))
         {
             //set cookie for rememberme
                //

              if(User::login($user))
              {
                  //self::setRememberMe($user->username);
                  Raxan::data('securityQuestions',null);
                  
                  if($rememberpc)
                  {
                      //set remember  pc cookie
                      rememberSQ::registerPC($user->username);
                      //set user preferences to rememberSecurityQuestions
                      
                      //$this->halt(print_r($user,true));
                  }

                  Accesslog::log(AccessLog::ACTION_LOGIN_SUCCESSFUL);
                    // redirect to home page module
                  $this->redirectTo(self::HOME_PAGE);
              }else

               {
                    $err = Shared::ERROR_MODE_INVALIDLOGIN;
                    $level = 'ERROR';
                    $label = 'Login';
                    Raxan::loadLangFile('errors');
                    $msg = Raxan::locale(Shared::ERROR_MODE_INVALIDLOGIN);

                    //$this->showMessage($msg);

                    Accesslog::log(Accesslog::ACTION_LOGIN_FAILED);

                }


         }else{

              //$this->halt(print_r($securityQuestions,true));
 
                Raxan::loadLangFile('errors');
                $msg = Raxan::locale(Shared::ERROR_MODE_INCORRECTSECURITYANSWERS);
                $this->showErrorMessage($msg);
                AccessLog::log(AccessLog::ACTION_INCORRECT_SECURITY_ANSWERS);
                return;
                 // self::clearRememberMe();
   
         }


        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
           AccessLog::log(AccessLog::ACTION_LOGIN_FAILED);
            return null;

        }
    }

    

    /**
     * This validates user security questions
     * @param RaxanEvent $e
     */
    protected function checkSecurityAnswers($e)
    {
        $username="";
        try
        {
            set_time_limit(130);  /* Give sufficient time for dbase connection */


            $user                  = Raxan::data('user');

            $username = $user->username;
            $actionType = User::getLoginActionFlow();


            $sqAnswer1              = $this->checkquestans1->textVal();
            $sqAnswer2              = $this->checkquestans2->textVal();
            $sqAnswers              = array();
            $sqAnswers[]            = $sqAnswer1;
            $sqAnswers[]            = $sqAnswer2;


         if(User::validateSecurityQuestionsAnswers($user, $sqAnswers))
         {
             //set cookie for rememberme
                //

             Accesslog::log(AccessLog::ACTION_SECURITY_ANSWERS_VALIDATED);
             if(User::checkPasswordWarningDays($user))
             {
                $selector = 'passwordDaysToExpiryMessage';
                 Raxan::loadLangFile('login');
                 $msg = Raxan::locale($selector);
                 $msg = str_replace("{daysToExpiry}",$user->daysToExpiry,$msg);
                $this->showConfirmMessage($msg);
                return ;

             }else
             if($actionType == 1 || $actionType == 3)
              {
                  $this->registerVar('loginaction', 'change password');

              }else
                {
                  $this->registerVar('loginaction', 'change pin');
                }

                Raxan::loadLangFile('login');
                $selector =  Raxan::data("nextmsg");
                 $msg = Raxan::locale($selector);

                $this->showMessage($msg);

         }else{


                Raxan::loadLangFile('errors');
                $msg = Raxan::locale(Shared::ERROR_MODE_INCORRECTSECURITYANSWERS);
                $this->showErrorMessage($msg);
                AccessLog::log(AccessLog::ACTION_INCORRECT_SECURITY_ANSWERS);
                return;

         }


        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
           AccessLog::log(AccessLog::ACTION_LOGIN_FAILED);
            return null;

        }
    }


/**
     * This varify a username chooses to chanage his or her password/PIN
     * @param RaxanEvent $e
     */

    protected function validateUser($e)
    {
        $username="";
     try
        {
         set_time_limit(130);  /* Give sufficient time for dbase connection */

        $username=$this->fpusername->textVal();
        $pwd ='';

        $pinNo=$this->fppin->val();
        $this->registerVar('securityQuestions',null);

        $user = User::validateUserByPin($username, $pinNo);
        $loginStatus = $user->loginStatus;
        $this->registerVar('loginActions',"");

        if(! $this->checkLoginStatus($loginStatus))
        {
            $this->registerVar('securityQuestions',"");
            AccessLog::log(AccessLog::ACTION_INVALID_LOGIN);
            return null;
        }




        if(!User::checkSecurityQuestions($user))
        {

            // no security questions force user to setup security questions
            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_NOSECURITYQUESTIONS);
            $this->showErrorMessage($msg);
            $this->registerVar('securityQuestions',"");
            AccessLog::log(AccessLog::ACTION_NO_SECURITY_QUESTIONS);
            return;
        }
        //register the security questions varible for the client to use

        $securityQuestions =User::getSecurityQuestions($user);
        Raxan::data('user', $user);
        Raxan::data("securityQuestions", $securityQuestions);



        $this->registerVar('securityQuestions',$securityQuestions);
        $this->registerVar('loginaction',"security questions forget password");
         AccessLog::log(AccessLog::ACTION_USER_LOGIN_VALIDATED);

    }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
            AccessLog::log(AccessLog::ACTION_INVALID_LOGIN);

            return null;

        }
    }

    /**
     * This varify a username chooses to chanage his or her password/PIN
     * @param RaxanEvent $e
     */

    protected function verifyPIN($e)
    {
        $username="";
     try
        {
         set_time_limit(130);  /* Give sufficient time for dbase connection */

        $user = Raxan::data("user");
        $username=$user->username;//$this->vpusername->textVal();
        $pwd ='';

        $pinNo=$this->vppin->val();
        $this->registerVar('securityQuestions',null);

        $actionType = User::getLoginActionFlow();
        $user1 = User::validateUserByPin($username, $pinNo);
        $loginStatus = $user1->loginStatus;
        $this->registerVar('loginaction',"");

        // check if login status was successful
        if (!($loginStatus == User::LOGIN_STATUS_OK ||
                $loginStatus == User::LOGIN_STATUS_PWDEXPIRE)) {
            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_INVALIDPIN);
            $this->showErrorMessage($msg);

            $this->registerVar('securityQuestions',"");
            AccessLog::log(AccessLog::ACTION_INVALID_PIN);
            return null;
        }

        if($actionType == 4 )
         {
            $this->registerVar('loginaction', 'set security questions');

         }
        
 
    }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
            AccessLog::log(AccessLog::ACTION_INVALID_LOGIN);

            return null;

        }
    }

    /**
     *
     * @param RaxanEvent $e
     * @return <type>
     *
     */
    protected function checkAnswersFP($e)
    {
        $username="";
         try
        {
            set_time_limit(130);  /* Give sufficient time for dbase connection */


            $user                  = Raxan::data('user');
            $username = $user->username;


           $sqAnswer1              = $this->questans1FP->textVal();
            $sqAnswer2              = $this->questans2FP->textVal();
            $sqAnswers              = array();
            $sqAnswers[]            = $sqAnswer1;
            $sqAnswers[]            = $sqAnswer2;
            $this->registerVar('loginaction', "");

          if(User::validateSecurityQuestionsAnswers($user, $sqAnswers))
         {
              AccessLog::log(AccessLog::ACTION_SECURITY_ANSWERS_VALIDATED);
                //
              //unset($_SESSION['securityQuestions']);
              Raxan::data("securityQuestions", null);
              $this->registerVar('securityans-incorrect', '');

              $verificationKey = $this->getEmailVerificationKey($user);
              if($verificationKey)
              {
                  Raxan::data("verificationKey", $verificationKey);
                  $msg="<h3>Security Code</h3><br><p>This security code is display only for development & testing purpose.<br/>Security code:<strong>$verificationKey</strong></p>";
                  $this->showMessage($msg);
                  $this->registerVar('loginaction', "security verification");
                  AccessLog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_SENT);
              }else
              {
                Raxan::loadLangFile('errors');
                $msg =  Raxan::locale(Shared::ERROR_MODE_EMAILSECUIRTYKEY);
                $this->showErrorMessage($msg);
                AccessLog::log(AccessLog::ACTION_EMAIL_VERIFICATION_KEY_NOT_SENT);
                return;
              }

         }else
         {
                Raxan::loadLangFile('errors');
                $msg = Raxan::locale(Shared::ERROR_MODE_INCORRECTSECURITYANSWERS);
                $this->showErrorMessage($msg);
               AccessLog::log(AccessLog::ACTION_INCORRECT_SECURITY_ANSWERS);
               return;

         }


        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
            AccessLog::log(AccessLog::ACTION_INVALID_LOGIN);

            return null;

        }
    }

    /**
     *
     * @param RaxanEvent $e
     * @return <type>
     */
    protected function verifySecurityCode($e)
    {
        $username ="";
            try
        {
            set_time_limit(130);  /* Give sufficient time for dbase connection */


            $user                   = Raxan::data('user');
            $username               = $user->username;
            $seccode                = $this->seccode->textVal();
            $verificationKey        = Raxan::data("verificationKey");
            $this->registerVar('verifySecurityCode','no');
            if($verificationKey != $seccode )
            {
               Raxan::loadLangFile('errors');
               $msg = Raxan::locale(Shared::ERROR_MODE_INVALIDSECURITYCODE);
               $this->showErrorMessage($msg);
               AccessLog::log(AccessLog::ACTION_INVALID_SECURITY_CODE);

                return ;
             }
              $this->registerVar('verifySecurityCode','yes');
               AccessLog::log(AccessLog::ACTION_SECURITY_CODE_VERIFIED);

        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
            AccessLog::log(AccessLog::ACTION_LOGIN_FAILED);
         return null;
        }
    }

    /**
     *
     * @param RaxanEvent $e
     * @return <type>
     */
    protected function setPassword($e)
    {
        $username = "";
            try
        {
            set_time_limit(130);  /* Give sufficient time for dbase connection */

            $user           = Raxan::data('user');
            $customerId     = $user->customerID;
            $username       = $user->username;
            $password       = $this->post->pwd;
            $securityToken  = $user->securityToken;

            if(!User::setUserPassword($customerId, $securityToken, $password) )
            {
               Raxan::loadLangFile('errors');
               $msg = Raxan::locale(Shared::ERROR_MODE_PASSWORDNOTCHANGED);
               $syserrmsg = Raxan::data("SYSERRMSG");
               if($syserrmsg)
               {
                   $msg = $syserrmsg;
               }
               $this->showErrorMessage($msg);
               $this->registerVar('pwdchanged','no');
               AccessLog::log(AccessLog::ACTION_PASSWORD_NOT_CHANGED);

                return ;
             }
              AccessLog::log(AccessLog::ACTION_PASSWORD_CHANGED);
             $this->registerVar('pwdchanged','yes');

        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
           AccessLog::log(AccessLog::ACTION_LOGIN_FAILED);
            return null;
        }
    }
 /**
     * Login Event - this event is triggered from a button on the web page
     * @param RaxanEvent $e
     */
    protected function loginUser($e)
    {

        $username="";
        try
        {
            set_time_limit(130);  /* Give sufficient time for dbase connection */


            $user                   = Raxan::data('user');
            $username               = $user->username;
            if(User::login($user))
            {
              AccessLog::log(AccessLog::ACTION_LOGIN_SUCCESSFUL);

            //redirect to home  page
            $this->redirectTo(self::HOME_PAGE);
            }else

              if(User::login($user))
              {
                  self::setRememberMe($user->username);
                  //unset($_SESSION['securityQuestions']);

                  Raxan::data("securityQuestions",null);
                  AccessLog::log(AccessLog::ACTION_LOGIN_SUCCESSFUL);
                    // redirect to home page module
                  $this->redirectTo(self::HOME_PAGE);
              }else
               {
                    $err = Shared::ERROR_MODE_INVALIDLOGIN;
                    $level = 'ERROR';
                    $label = 'Login';

                    Shared::logRedirectToErrorPage($err, $e, $level,$label );
                    Raxan::loadLangFile('errors');
                    $msg = Raxan::locale(Shared::ERROR_MODE_INVALIDLOGIN);
                    $this->showErrorMessage($msg);

                    Accesslog::log(Accesslog::ACTION_LOGIN_FAILED);

                }

        }catch(Exception $ex)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
           AccessLog::log(AccessLog::ACTION_LOGIN_FAILED);
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

    /**
     *
     * @param RaxanEvent $e
     * @return return void
     */
    protected function logout($e)
    {
        try {
            User::logout();
            $this->redirectTo("login.php");
        }
        catch(Exception $ex) {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';
            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
        }
        return;
    }

    
  /**
     * saveSecurityQuestionAnswers Event - this event is triggered from a button on the web page
     * @param RaxanEvent $e
     */
    protected function saveSecurityQuestionAnswers($e)
    {
        $username =null;

        try
        {
           
            $user           = Raxan::data("user");
            $username       = $user->username;
            $actionType     = User::getLoginActionFlow();

           if(User::saveSecurityQuestions($user ))
           {
               AccessLog::log(Accesslog::ACTION_SECURITY_QUESTIONS_SETUP);
               if( $actionType == 4)
                {
                   $selector = "SQChangedMessage";
                     Raxan::loadLangFile('login');
                     $msg = Raxan::locale($selector);
                   
                    $this->showSuccessMessage($msg);
                    

                }else
                {
                    Raxan::loadLangFile('login');
                    $msg="";
                    if(User::checkNewUserStatus($user) )
                    {
                        $selector = "signupProcessCompleteMessage";
                         $msg = Raxan::locale($selector);
                     }else
                    if($actionType >= 5)
                     {
                         $selector = User::showEndActionMessage();
                         $msg = Raxan::locale($selector);

                     } 
                     
                    $this->showSuccessMessage($msg);

                }

                if(User::checkNewUserStatus($user))
                {
                    User::activateAccount($user);
                }
                $this->registerVar('loginaction', 'login');
                User::logout();
           }else
           {
               $selector = "SQNotChangedMessage";
                  Raxan::loadLangFile('login');
                 $msg = Raxan::locale($selector);
              
                $this->showErrorMessage($msg, false);
                AccessLog::log(Accesslog::ACTION_SECURITY_QUESTIONS_NOT_SETUP);

           }
         }catch(Exception $ex)
            {
                $err = Shared::ERROR_MODE_SYSERR;
                $level = 'ERROR';
                $label = 'User';

                $selector = "SQNotChangedMessage";
                Raxan::loadLangFile('login');
                $msg = Raxan::locale($selector);

                $this->showErrorMessage($msg, false);
                AccessLog::log(Accesslog::ACTION_SECURITY_QUESTIONS_NOT_SETUP);
                Shared::logRedirectToErrorPage($err, $ex, $level,$label );
 

            }
    }

     /**
     * chnagePassword Event - this event is triggered from a button on the web page
     * @param RaxanEvent $e
     */
    protected function changePassword($e)
    {
        try
        {
            $user = Raxan::data('user');
            $customerId     = $user->customerID;
            $username       = $user->username;
            $securityToken  = $user->securityToken;

            $oldPassword = $this->post->pwdOld;
            $newPassword = $this->post->pwdNew;
            $actionType = User::getLoginActionFlow();
            
            if(User::changePassword($username, $customerId, $securityToken, $oldPassword, $newPassword ))
            {
                AccessLog::log(Accesslog::ACTION_PASSWORD_CHANGED);

                if(!(User::checkNewUserStatus($user) ||
                        User::checkForcePinChange($user) ) &&
                       User::checkSecurityQuestions($user) ||
                        $actionType == 1)
                {
                    // show confirmation message and allow the user to login
                    $selector = 'passwordChangedMessage';
                    Raxan::loadLangFile('login');
                    $msg = Raxan::locale($selector);
                   
                    $this->showSuccessMessage($msg);
                    $this->registerVar('loginaction', 'login');
                    User::logout();
                 }else
                 {

                     if($actionType == 5  )
                     {
                        $this->registerVar('loginaction', 'set security questions');

                     }  else {

                         // show the change PIN the next step for new user's to setup their password,pin, and security questions
//                         $selector = 'forcePINChangeMessage';
//                         Raxan::loadLangFile('login');
//                         $msg = Raxan::locale($selector);

                         //$this->showMessage($msg);
                         $this->registerVar('loginaction', 'change pin');
                     }

                      
                  }
          }else
            {
                     $selector = 'passwordNotChangedMessage';
                     Raxan::loadLangFile('login');
                     $msg = Raxan::locale($selector);
                     $syserrmsg = Raxan::data("SYSERRMSG");
                     $msg = $syserrmsg;
                     Raxan::data("SYSERRMSG","");
                     //$msg = str_replace("{SYSMESSAGE}",$syserrmsg,$msg);
                    $this->showErrorMessage($msg);
                    AccessLog::log(Accesslog::ACTION_PASSWORD_NOT_CHANGED);

            }
        }catch(Exception $ex)
        {

           $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $ex, $level,$label );
            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_SYSERR);
            $this->showErrorMessage($msg);

            AccessLog::log(Accesslog::ACTION_PASSWORD_NOT_CHANGED);
            return null;       }

    }

     /**
     * chnagePIN Event - this event is triggered from a button on the web page
     * @param RaxanEvent $e
     */
    protected function changePIN($e)
    {
      try
        {
            $user = Raxan::data('user');
            $customerId     = $user->customerID;
            $username       = $user->username;
            $securityToken  = $user->securityToken;

            $oldPIN = $this->post->pinOld;
            $newPIN = $this->post->pinNew;
            $actionType = User::getLoginActionFlow();

            //$this->registerVar('signup', 'no');
            if(User::changePIN($username, $customerId, $securityToken, $oldPIN, $newPIN))
            {
                AccessLog::log(Accesslog::ACTION_PIN_CHANGED);

                if((!  User::checkNewUserStatus($user) && User::checkSecurityQuestions($user)) ||
                       $actionType == 2 )
                {
                     Raxan::loadLangFile('login');
                     $selector ="";
                     if($actionType == 3)
                     {
                         $selector = User::showEndActionMessage();
                     } else {
                        // show confirmation message and allow the user to login
                        $selector = 'pinChangedMessage';
                     }
                     $msg = Raxan::locale($selector);
                     $this->showSuccessMessage($msg);
                    $this->registerVar('loginaction', 'login');
                    User::logout();
                 }
                 else
                 {

                     // show the change Security Questions the next step for new user's to setup their password,pin, and security questions
//                     $selector = 'noSQMessage';
//                     Raxan::loadLangFile('login');
//                     $msg = Raxan::locale($selector);
                   
                     //$this->showErrorMessage($msg);
                     $this->registerVar('loginaction', 'set security questions');
                      //$this->registerVar('signup', 'yes');
                  }
            }else
            {
                 $selector = 'pinNotChangedMessage';
                 Raxan::loadLangFile('login');
                 $msg = Raxan::locale($selector);
                 $syserrmsg = Raxan::data("SYSERRMSG");
                 Raxan::data("SYSERRMSG","");
                 $msg = str_replace("{SYSMESSAGE}",$syserrmsg,$msg);

                 $this->showErrorMessage($msg);
                 AccessLog::log(Accesslog::ACTION_PIN_NOT_CHANGED);

            }
        }catch(Exception $ex)
        {

           $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Raxan::loadLangFile('errors');
            $msg = Raxan::locale(Shared::ERROR_MODE_SYSERR);
            $this->showErrorMessage($msg);
           Shared::logRedirectToErrorPage($err, $ex, $level,$label );
 
            AccessLog::log(Accesslog::ACTION_PIN_NOT_CHANGED);
            return null;

        }

    
    }




   


    /**
     * Next tip Event
     * This event is triggered from a button on the web page
     * @param RaxanEvent $e
     */
    protected function nextTip($e) {
        $tip = User::getRandomTip();
        $this->setTip($tip['type'],$tip['tip'],$tip['title']);
        $this->tipcontainer->updateClient();
        C('#tiptitle,#tipcontent')->hide()->fadeIn();
    }


    protected function setTip($type,$tip,$title) {
      /*  $this->tiptitle->text($title);
        $this->tipcontent->html($tip);
        if ($type=='tip') {
            $this->tipheader->text('Security Tips');
            $this->tipheader->attr('langid','security.tips');
        }
        else{
            $this->tipheader
                ->text('Announcement')
                ->attr('langid','announcement')
                ->addClass('announce');
            $this->tipbtn->remove();
        }
       * */
      
    }
    /**
     * Set User Locale Event
     * @param RaxanEvent $e
     */
    protected function setLocale($e) {
        $l = $e->value;
        if (in_array($l, array('en','es','fr','zh'))) {
            User::setLocaleCode($l);
            $this->redirectTo('login.php');
        }
    }



  

}

?>