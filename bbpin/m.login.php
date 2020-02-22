<?php
date_default_timezone_set('Europe/Bucharest');
//include_once("classes/facebook/fbaccess.php"); 
$user=null;
include_once("config/config.php"); 
include_once("includes/languages/{$lang}_login.php");
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");

$obj = new site();
	
if(!empty($user))
{
	$me = $user_profile;
	$fb = $obj->getUserFbId($me['id'],$me['email']);
	if($fb){
		$rt['time'] = time();
		$_SESSION['BBPINWORLD'] = $fb;
		pageLanding();
	}else{
		//new account
		$name = explode(' ', $me['name']);
		$data['fname']	= $name[0];
		$data['lname']	= trim(str_replace($name[0],'',$me['name']));
		$data['email']	= $me['email'];
		$data['about_me'] = $me['bio'];
		$data['fb_id'] 	  = $me['id'];
		$data['country_id'] = 1;
		$data['pass'] 	  = 'password';
		
		$uId = $obj->createNewAccount($data);
		if($uId){
			$s['id'] = $uId;
			$s['fname'] = $data['fname'];
			$s['lname'] = $data['lname'];
			$s['email'] = $data['email'];
			$s['time']  = time();
			$s['bbm']   = 0;
			$_SESSION['BBPINWORLD'] = $s;
			
			$headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
			$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$subject = 'Welcome to '.SITE_NAME;
			$message = "<b>Thank you for signing up with ".SITE_NAME."!</b>
						<p>Our aim at <a href='".DOMAIN."'>".SITE_NAME."</a> is to create a BBM network where you and other can easily find people outside of your normal realm, to meet and shear with new people and even old one too, and to find BBM chartroom group that shear you interest.</p>
						<p>We encourage you add your BBM groups and also to share this web site with you current friends and help us create the largest BBM online network possible.</p>
						<p>Thank you.</p>";						
			@mail($email, $subject, $message, $headers);
			pageLanding(true);
		}else{die("DB ERROR");}
	}
}

$err = '';
if($_POST)
{	
	$rs = $_POST;
	$rt = $obj->userLogin($rs['username'],$rs['pass']);
	if($rt){
		$rt['time'] = time();
		$_SESSION['BBPINWORLD'] = $rt;
		if($rt['hasImage']){header('location: m/index.php');exit();}
		pageLanding();
	}
	else{
		$err = '<span class="error">Invalid login attempt...</span>';
	}
}

function writeToFile($file, $content){
    if (!$handle = fopen($file, 'a')) {
            echo "Cannot open file ($file)";
            exit;
    }
    if (fwrite($handle, $content) === FALSE) {
            echo "Cannot write to file ($file)";
            exit;
    }
    fclose($handle);
}
function getHttpHeaders() { 
    $out = array();
    foreach($_SERVER as $key=>$value) { 
		if (substr($key,0,5)=="HTTP_" || in_array($key, array('REMOTE_ADDR', 'REQUEST_TIME'))) {  
			$out[$key]=($key=='REQUEST_TIME' ? date('d-m-Y H:i', $value) : $value); 
		} 
    } 
    return $out; 
} 

function pageLanding($editPage=false){ 
	// Debug.
	writeToFile('classes/mobile_detect/ua.txt', print_r(getHttpHeaders(),true));
	// Check for mobile device.
	require_once 'classes/mobile_detect/Mobile_Detect.php';
	$detect = new Mobile_Detect();
	$layout = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');
	
	if($detect->isMobile()){
		if($editPage){ header('location: m/edit-profile.html'); return true; }
		header('location: m/');
	}
	else{
		if($editPage){ header('location: edit-profile.html'); return true; }
		header('location: index.php');
	}
}
?>
<!DOCTYPE html>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>">
<head>  
<meta name="language" content="<?php echo $locale['lang'];?>" />
<meta name="title" content="JusBBmPins.com :: blackBerry pin yellow page">
<meta name="description" content="find blackberry pins for your bbm messenger, find contacts and bbm groups that share similar interest with you from around the world">
<meta name="google-site-verification" content="ktkh5PEUpjuCtlcYpxuDxz1A6YFFjACSEuzeOlAIvlE" />
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $locale['content.type'];?>" />
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>JusBBmPins.com - Mobile :: blackberry pin yellow page, find bbm pins and new friends, find bbm chat groups, find individuals and groups that share your similar interest, connecting blackberry messengers arround the world</title>
<style>
@import url("styles/mobile_login2013.css");
</style>
</head>
<body>
<div id="container">
    <h1>JusBBmPins.com</h1>
	<form name="frm" method="post" action="">
    	<h2><?php echo $locale['member'];?></h2>
        <p>
        	<div><b class="label"><?php echo $locale['username'];?></b></div>
        	<input type="text" name="username" id="username" autocomplete="off" value="" class="textbox" tabindex="1" />
        </p>
        <p>
        	<div><b class="label"><?php echo $locale['password'];?></b></div>
            <input type="password" name="pass" id="pass" autocomplete="off" value="" class="textbox" tabindex="2" />
        </p>
        <p class="btncel"><input type="submit" value="<?php echo $locale['signin'];?>" class="signin" tabindex="3" /></p>
        <p class="links" align="center">
            <?php echo $err;?>
            <a style="display:block;" href="<?=$loginUrl?>" class="fblogin" title="Connect to your Facebook Account"><?php echo $locale['signin.fb'];?></a>
        	<a style="display:block;" href="register.php" class="su" title="create new account"><?php echo $locale['new.account'];?></a>
            <a style="display:block;" href="forget-login.php" class="forget"><?php echo $locale['forget.password'];?></a>
        </p>
    </form> 
    <div class="intro"><?php echo $locale['intro.text'];?></div>
    <p class="lang" align="center">
        (<a class="en" title="view in website english" href="javaScript:setLang('en');">english</a>)
        (<a class="es" title="view in website spanish" href="javaScript:setLang('es');">spanish</a>)
        (<a class="fr" title="view in website french" href="javaScript:setLang('fr');">french</a>)    
    </p>
</div>
<script type="text/javascript" src="js/global.js"></script>
<!-- To my beloved rose [@}~%~~~] missing you like crazy, love you always xoxo wether your near or far, beside me or not 2012/08/08 -->
</body>
</html>