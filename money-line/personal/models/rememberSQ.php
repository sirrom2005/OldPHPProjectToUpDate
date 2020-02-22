<?php

// @TODO: Refactor code. Maybe move this into a library

// models
require_once PERSONAL_MODEL_PATH.'user.php';

use Moneyline\Personal\Shared;
use Moneyline\Personal\Model\User;

class rememberSQ
{
    const    IDSALT     = "hK0x-R$90QspFW9$#),]>?";
    const    SALT1      = "koP^zQiU A@rMP$*N)W983";
    const    SALT2      = "iKz32#e1! &8X1yT01^%ox";



    public static function isRegisteredPC($username=null)
    {
        try
        {
           if( !($username = self::validateUsername($username))) return false;
           
        // make sure uid is lower cased
            $uid = strtolower(trim($username));
            $remoteaddr ="";//$_SERVER["REMOTE_ADDR"];
            $key = (isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '') .'/'.
               (isset($_SERVER["HTTP_ACCEPT_ENCODING"]) ? $_SERVER["HTTP_ACCEPT_ENCODING"] : '') .'/'.
               (isset($_SERVER["HTTP_ACCEPT_CHARSET"]) ? $_SERVER["HTTP_ACCEPT_CHARSET"] : '') .'/end'
               ;

            $cookieName = "wurpc".sprintf("%u", crc32( self::IDSALT.$uid));
            $cookieValue = sha1(self::SALT1.md5(self::SALT2.$uid.$key.$remoteaddr));


            return isset($_COOKIE[$cookieName]) && $_COOKIE[$cookieName] == $cookieValue;
        }catch(Exception $e)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level,$label );

        }
        return false;

    }

    public static function registerPC($username=null)
    {
        try
        {
            
           if( !($username = self::validateUsername($username))) return false;
        // make sure uid is lower cased
            $uid = strtolower(trim($username));
            $remoteaddr = "";//$_SERVER["REMOTE_ADDR"];
            $key = (isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '') .'/'.
               (isset($_SERVER["HTTP_ACCEPT_ENCODING"]) ? $_SERVER["HTTP_ACCEPT_ENCODING"] : '') .'/'.
               (isset($_SERVER["HTTP_ACCEPT_CHARSET"]) ? $_SERVER["HTTP_ACCEPT_CHARSET"] : '') .'/end'
               ;

            $cookieName = "wurpc".sprintf("%u", crc32( self::IDSALT.$uid));
            $cookieValue = sha1(self::SALT1.md5(self::SALT2.$uid.$key.$remoteaddr));
            $dt = new DateTime();
            $dt->modify('5 years'); // set expiry date
            $time = $dt->format('U');
            setcookie($cookieName, $cookieValue, $time);

            return true;
        }catch(Exception $e)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level,$label );

        }
        return false;

    }

  

    public static function cookieName($username=null)
    {
        try {
           if( !($username = self::validateUsername($username))) return false;
                $uid = strtolower(trim($username));
                $cookieName = "wurpc".sprintf("%u", crc32(self::IDSALT.$uid));

                return $cookieName;
        }catch(Exception $e)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level,$label );

        }

        return null;
    }

    protected static function validateUsername($username)
    {

          if(!$username) {
                if (! User::isLogin()) return null;
               $username= Shared::data('login-name');
            }

            return $username;

    }
    public static function unRegisterPC($username=null)
    {

        try
        {
           if( !($username = self::validateUsername($username))) return false;
           
            if(self::isRegisteredPC($username))
            {
                $uid = strtolower(trim($username));
                $cookieName = "wurpc".sprintf("%u", crc32(self::IDSALT.$uid));
                $cookieValue = "";

                $time = time()- 3600;
                setcookie($cookieName, $cookieValue, $time);
                return true;
            }


            
        }catch(Exception $e)
        {
            $err = Shared::ERROR_MODE_SYSERR;
            $level = 'ERROR';
            $label = 'Login';

            Shared::logRedirectToErrorPage($err, $e, $level,$label );

        }
        return false;
    }

}
?>
