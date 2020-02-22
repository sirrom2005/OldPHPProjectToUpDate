<?php
define("DB_SERVER", "mysql4.myregisteredsite.com");
define("DB_USER", "2057122");
define("DB_PASS", "dbh11111");
define("DB_NAME", "201199_users");

/**
 * Cookie Constants - these are the parameters
 * to the setcookie function call, change them
 * if necessary to fit your website. If you need
 * help, visit www.php.net for more info.
 * <http://www.php.net/manual/en/function.setcookie.php>
 */
define("GUEST_NAME", "Guest");
define("COOKIE_EXPIRE", 60*60*24*100);  //100 days by default
define("COOKIE_PATH", "/");  //Avaible in whole domain
/**
 * Email Constants - these specify what goes in
 * the from field in the emails that the script
 * sends to users, and whether to send a
 * welcome email to newly registered users.
 */
define("EMAIL_FROM_NAME", "Baymac Registration");
define("EMAIL_FROM_ADDR", "info@baymac.net");
/**
 * This constant forces all users to have
 * lowercase usernames, capital letters are
 * converted automatically.
 */
define("ALL_LOWERCASE", true);

/**
 *For hashing purposes  
 **/
define("supersecret_hash_padding",'lkjnsdkjfhnslkdjnlksjdfsd89765786529836748927389');
define("supersecret_hash_padding_2",'lkjhsdakljhglkdsjhgiuwerhn0983049809324kjhnlkjhbsd');

/**
 *If you want that the user has to repeat the E-Mail and/or the Password
 *in the registration form , set the following to true or false  
 **/
define("REPEAT_EMAIL",true);
define("REPEAT_PASSWORD",true);


/*
 * the link on your server to the file resetpassword.php and confirm.php
 * these are going to be used in the mail body 
 * */
define("RESETPASSWORDLINK","http://www.baymac.net/resetpassword.php");
define("CONFIRMACCOUNTLINK","http://www.baymac.net/inc/confirm.php");

/*
 * recaptcha keys:
 * */
define("PUBLICKEY","XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
define("PRIVATEKEY","XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX");
?>
