<?php
date_default_timezone_set('Europe/Bucharest');
//include_once("classes/facebook/fbaccess.php"); 
$user=null;
include_once("config/config.php"); 
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
include_once("includes/languages/{$lang}_login.php");

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
		if($rt['hasImage']){header('location: index.php');exit();}
		pageLanding();
	}
	$err = '<span class="error"><span>'.$locale['invalid.attempt'].'</span></span>';
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
		header('location: m/profile.html');
	}
	else{
		if($editPage){ header('location: edit-profile.html'); return true; }
		header('location: profile.html');
	}
}
?>
<!DOCTYPE html>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>">
<head>
<meta name="language" content="<?php echo $locale['lang'];?>" />
<meta name="title" content="JusBBmPins.com The BlackBerry Pin Yellow Page">
<meta name="description" content="The Yellow page for blackberry pin, register your blackberry pin now, find bbm pins and bbm chat groups.">
<meta name="google-site-verification" content="ktkh5PEUpjuCtlcYpxuDxz1A6YFFjACSEuzeOlAIvlE" />
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $locale['content.type'];?>" />
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>The Yellow page for blackberry pin, register your blackberry pin now, find bbm pins and bbm chat groups :: JusBBmPins.com</title>
<style>
@import url("styles/login2013.css");
</style>
<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="styles/IE.css" />
<![endif]-->
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5039d3134bebc572"></script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31035193-4']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body>
<span class="topbar">
    <a class="en" title="view in website english" href="javaScript:setLang('en');">en</a><a class="es" title="view in website spanish" href="javaScript:setLang('es');">es</a><a class="fr" title="view in website french" href="javaScript:setLang('fr');">fr</a>    
    <span class="left">
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
        <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
        <a class="addthis_button_tweet"></a>
        <a class="addthis_counter addthis_pill_style"></a>
        </div>
        <!-- AddThis Button END -->
    </span>
</span>
<div style="clear:both;"></div>
<div class="gallery"></div>
<div class="content">
    <h1>JusBBmPins.com</h1>
    <p class="errmsg"><?php echo $err;?></p>
    <form name="frm" id="loginfrm" method="post" action="" >
        <p>
            <a href="forget-login.php" class="reset" title="<?php echo $locale['forget.password'];?>" ><?php echo $locale['forget.password'];?></a>
            <a href="register.php" class="su" title="<?php echo $locale['new.account'];?>"><?php echo $locale['new.account'];?></a>
            <a href="<?=$loginUrl?>" class="fblogin" title="<?php echo $locale['signin.fb'];?>"><?php echo $locale['signin.fb'];?></a>
        </p>
        <h2><?php echo $locale['member'];?></h2>
        <p><label for="username"><?php echo $locale['username'];?></label><input type="text" name="username" id="username" autocomplete="off" value="" class="textbox" tabindex="1" /></p>
        <p><label for="pass"><?php echo $locale['password'];?></label><input type="password" name="pass" id="pass" autocomplete="off" value="" class="textbox" tabindex="2" /></p>
        <p class="btncel"><input type="submit" value="<?php echo $locale['signin'];?>" class="signin" tabindex="3" /></p>
        <div class="intro"><?php echo $locale['intro.text'];?></div>
        <center>
            <a href="http://www.facebook.com/jusbbmpins" target="_blank" title="follow jusbbmpins.com on facebook"><img src="images/followonfacebook.jpg"/></a><br>
            <a href="https://twitter.com/jusbbmpins" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @jusbbmpins</a>
        </center>
    </form> 
</div>
<div class="footer">
    <a href="<?php echo DOMAIN;?>about-us.htm" title="<?php echo $locale['about'];?>" ><?php echo $locale['about'];?></a> &bull;
    <a href="<?php echo DOMAIN;?>faqs.htm" title="<?php echo $locale['faqs'];?>" ><?php echo $locale['faqs'];?></a> &bull;
    <a href="<?php echo DOMAIN;?>privacy-policy.htm" title="<?php echo $locale['privacy'];?>" ><?php echo $locale['privacy'];?></a> &bull;
    <a href="<?php echo DOMAIN;?>terms.htm" title="<?php echo $locale['terms'];?>"><?php echo $locale['terms'];?></a> &bull;
    <a href="<?php echo DOMAIN;?>feedback.htm" title="<?php echo $locale['feedback'];?>"><?php echo $locale['feedback'];?></a> &bull;
    <a href="<?php echo DOMAIN;?>contact-us.htm" title="<?php echo $locale['contact'];?>"><?php echo $locale['contact'];?></a>
    <br><a href="<?php echo DOMAIN;?>" title="jusbbmpin.com">JusBBMPin.com</a> Copyright &copy; <?php echo date('Y');?>
</div>
<img src="images/mini-promo.jpg" title="jusbbmpin.com the blackberry yellow page" alt="jusbbmpin.com the blackberry yellow page" width="0" />
<script type="text/javascript" src="js/global.js"></script>
<!-- To my beloved rose [@}~%~~~] missing you like crazy, love you always xoxo wether your near or far, beside me or not 2012/08/08 -->
</body>
</html>
