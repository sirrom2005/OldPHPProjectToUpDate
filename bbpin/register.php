<?php
date_default_timezone_set('Europe/Bucharest');
include_once("config/config.php");
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
include_once("classes/commonDB.class.php");
include_once("includes/languages/{$lang}_login.php");

$commObj= new commonDB();
$obj 	= new site();
$rs 	= array('fname'=>'','email'=>'','bbmpin'=>'','country_id'=>'');
$err 	= '';
$bbCnt  = NULL;
if($_POST)
{
	$rs = $_POST;
	$fname	= cleanText($rs['fname']);
	$bbmpin	= cleanText(str_replace('pin:','',$rs['bbmpin']));
	$country_id	= cleanText($rs['country_id']);
	$email	= cleanText($rs['email']);
	$pass 	= cleanText($rs['pass']);
	$pass2 	= cleanText($rs['pass2']);
	$rs['fb_id'] = NULL;
	$valid  = true;
	
	if(empty($fname)){
		$err .= "<span>Full name is required.</span>";
		$valid  = false;
	}
	
	if(!isValidEmail($email)){
		$err .= "<span>invalid email address.</span>";
		$valid  = false;
	}
	
	if(!isValidPin($bbmpin)){
		$err .= "<span>Your BBM-PIN is not valid..</span>";
		$valid  = false;
	}else{
		$bbCnt = $obj->bbmPinRegLookUp($bbmpin);
		$bbCnt = $bbCnt['cnt']; 
	}
	
	if($bbCnt){
		$err .= "<span>This BBM-PIN is already in use by another user,<br>Please report this to the <a href='contact-us.html' style='color:#000;'>admin</a>.</span>";
		$valid  = false;
	}
	if( strlen($pass)<6){
		$err .= "<span>password too short or empty.</span>";
		$valid  = false;
	}
	if($pass != $pass2){
		$err .= "<span>password does not match.</span>";
		$valid  = false;
	}
	
	if($valid){
		$name = explode(' ',$fname);
		$rs['fname'] = $name[0];
		$rs['lname'] = trim(str_replace($name[0],'',$fname));
			
		$rt = $obj->emailLookUp($email);
		if(!$rt['cnt']){
			unset($rs['bbmpin']);
			$uId = $obj->createNewAccount($rs);
			if($uId){
				$pin['account_id'] 	= $uId;  
				$pin['bbmpin'] 		= $bbmpin;
								
				if($commObj->insertRecord($pin,'bbm_pin')){
					$s['id'] 	= $uId;
					$s['fname'] = $rs['fname'];
					$s['lname'] = $rs['lname'];
					$s['email'] = $email;
					$s['time']  = time();
					$s['bbm']   = 1;
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
				}
			}
			else{
				die("DB ERROR");
			}
		}
		else{
			$err .= "<span class='error'><span>email already in system.</span></span>";
		}
	}
	else{
		$err = "<span class='error'>$err</span>";
	}
}
$country = $commObj->getHtmlListControlData('odb_country','name','country_id',NULL,NULL);

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
		if($editPage){header('location: m/profile.html'); return true;}
		header('location: m/');
	}
	else{
		if($editPage){header('location: profile.html'); return true;}
		header('location: index.php');
	}
}
?>
<!DOCTYPE html>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>">
<head>
<meta name="language" content="<?php echo $locale['lang'];?>" />
<meta name="title" content="JusBBmPins.com :: blackBerry pin yellow page">
<meta name="description" content="Find blackberry pins for your BBM messenger, find contacts and BBM chat groups from around the world.">
<meta name="google-site-verification" content="ktkh5PEUpjuCtlcYpxuDxz1A6YFFjACSEuzeOlAIvlE" />
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $locale['content.type'];?>" />
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>The Yellow page for blackberry pin, register your blackberry pin now, find bbm pins and bbm chat groups :: JusBBmPins.com</title>
<style>
@import url("styles/login2013.css");
</style>
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
<body id="register">
<p class="errmsg"><?php echo $err;?></p>
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
<br>
<img src="images/mini-promo.jpg" title="jusbbmpin.com the blackberry yellow page" alt="jusbbmpin.com the blackberry yellow page" width="0" />
<h1>JusBBmPins.com</h1>
<div class="gallery">
	<div class="content">
        <form name="frm" method="post" action="">
            <p>
                <a href="<?php echo DOMAIN;?>" class="reset" title="<?php echo DOMAIN;?>" >&laquo; Back to login</a>
            </p>
            <h2>Create Your New JusBBmPins.com Account</h2>
            <p><label for="fname">Full name <font>*</font></label><input type="text" name="fname" id="fname" autocomplete="off" value="<?php echo $rs['fname'];?>" class="textbox" /></p>
            <p><label for="bbmpin">BBM-PIN <font>*</font></label><input type="text" name="bbmpin" id="bbmpin" autocomplete="off" value="<?php echo $rs['bbmpin'];?>" class="textbox" /></p>
            <p><label for="email">Email <font>*</font></label><input type="text" name="email" id="email" autocomplete="off" value="<?php echo $rs['email'];?>" class="textbox" /></p>
            <p>
                <label for="country_id">Country <font>*</font></label>
                <select name="country_id" id="country_id" class="textbox">
                    <?php foreach($country as $key => $value){ ?>
                    <option value="<?php echo $key;?>" <?php if($rs['country_id']==$key){ echo "selected";} ?> ><?php echo $value;?></option>
                    <?php } ?>
                </select>
            </p>
            <p><label for="pass">Password <font>*</font> <small>(Minimum 6 characters)</small></label><input type="password" name="pass" id="pass" autocomplete="off" value="" class="textbox" /></p>
            <p><label for="pass2">Retype Password <font>*</font></label><input type="password" name="pass2" id="pass2" autocomplete="off" value="" class="textbox" /></p>
            <p align="center"><input type="submit" value="Enter" class="btn" /></p>
        </form>
    </div>
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
</body>
</html>