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
		pageLanding();
	}
	else{
		$err = '<span class="error"><li>'.$locale['invalid.attempt'].'</li></span>';
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
<title>JusBBmPins.com :: blackberry pin yellow page, find bbm pins and new friends, find bbm chat groups, find individuals and groups that share your similar interest, connecting blackberry messengers arround the world</title>
<style>
@import url("styles/front-page.css");
#info{text-align:left;}
#info li{background:url(images/tick-bullet.png) no-repeat 0 5px;padding-left:15px;list-style:none;}
#container{width:750px; margin:9% auto; border:solid 0px #00FF33;}
form{float:right;}
#user li{float:right;margin-right:5px; list-style:none;}
#user li a{display:block;width:80px;height:80px; padding:5px;border:solid 1px #999999;}
#user li a.u1{ background:url(images/80_1344648568.jpg) no-repeat 5px 5px;}
#user li a.u2{ background:url(images/80_1346102956.jpg) no-repeat 5px 5px;}
#user li a.u3{ background:url(images/80_1346161009.jpg) no-repeat 5px 5px;}
#user li a.u4{ background:url(images/80_1344648568.jpg) no-repeat 5px 5px;}
#user li a.u5{ background:url(images/80_1346102956.jpg) no-repeat 5px 5px;}
#user li a.u6{ background:url(images/80_1346161009.jpg) no-repeat 5px 5px;}
#user li a.u7{ background:url(images/80_1346161009.jpg) no-repeat 5px 5px;}
#footer{ font-size:0.8em;}
.en,.es,.fr{background:no-repeat 0 5px;display:inline-block;padding-left:18px;margin:5px 5px 0 5px;}
.en{background-image:url(images/flags/us.png);}
.es{background-image:url(images/flags/es.png);}
.fr{background-image:url(images/flags/fr.png);}
</style>
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
<div id="container">
    <form name="frm" id="loginfrm" method="post" action="" style="width:320px;">
    	<p>
            <a href="<?=$loginUrl?>" class="fblogin" title="<?php echo $locale['signin.fb'];?>"><?php echo $locale['signin.fb'];?></a>
        	<a href="register.php" class="su" title="<?php echo $locale['new.account'];?>"><?php echo $locale['new.account'];?></a>
        </p>
    	<h2><?php echo $locale['member'];?></h2><?php echo $err;?>
        <p><label for="username"><?php echo $locale['username'];?></label><input type="text" name="username" id="username" autocomplete="off" value="" class="textbox" tabindex="1" /></p>
        <p><label for="pass"><?php echo $locale['password'];?></label><input type="password" name="pass" id="pass" autocomplete="off" value="" class="textbox" tabindex="2" /></p>
        <p align="right"><input type="submit" value="<?php echo $locale['signin'];?>" class="signin" tabindex="3" /></p>
        <p>
        	<a href="forget-login.php" style="float:right; font-size:0.8em;color:#000000;"><?php echo $locale['forget.password'];?></a>
          	<!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style ">
                    <a class="addthis_button_facebook_like"></a>
                    <a class="addthis_button_preferred_2"></a>
                    <a class="addthis_button_preferred_3"></a>
                    <a class="addthis_button_preferred_4"></a>
                    <a class="addthis_button_compact"></a>
                    <a class="addthis_counter addthis_bubble_style"></a>
          	</div>
            <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5039d3134bebc572"></script>
            <!-- AddThis Button END -->
        </p>
    </form> 
    <div id="info">
        <h1>JusBBmPins.com</h1>
        <p class="title">
      		<ul><?php echo $locale['intro.text'];?></ul>
        </p>
    </div>
    <!--br clear="all">
    <ul id="user">
    	<li><a class="u1"></a></li>
        <li><a class="u2"></a></li>
        <li><a class="u3"></a></li>
    	<li><a class="u4"></a></li>
        <li><a class="u5"></a></li>
        <li><a class="u6"></a></li>
        <li><a class="u7"></a></li>
    </ul-->
    <br clear="all">
  <img src="images/bbmchat.jpg" />
  <br>
 	<div id="footer">        
        <a href="<?php echo DOMAIN;?>about-us.htm"><?php echo $locale['about'];?></a> &bull;
        <a href="<?php echo DOMAIN;?>faqs.htm"><?php echo $locale['faqs'];?></a> &bull;
        <a href="<?php echo DOMAIN;?>privacy-policy.htm"><?php echo $locale['privacy'];?></a> &bull;
        <a href="<?php echo DOMAIN;?>terms.htm"><?php echo $locale['terms'];?></a> &bull;
        <a href="<?php echo DOMAIN;?>feedback.htm"><?php echo $locale['feedback'];?></a> &bull;
        <a href="<?php echo DOMAIN;?>contact-us.htm"><?php echo $locale['contact'];?></a>
        <p><a class="en" title="view in website english" href="javaScript:setLang('en');">en</a><a class="es" title="view in website spanish" href="javaScript:setLang('es');">es</a><a class="fr" title="view in website french" href="javaScript:setLang('fr');">fr</a></p>
    </div>
</div>
<script type="text/javascript" src="js/global.js"></script>
<!-- To my beloved rose [@}~%~~~] missing you like crazy, love you always xoxo wether your near or far, beside me or not 2012/08/08 -->
</body>
</html>