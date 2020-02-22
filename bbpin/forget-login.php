<?php
include_once("config/config.php"); 
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
include_once("includes/languages/{$lang}_login.php");
$obj = new site();
$err = '';
if($_POST)
{	
	$rs = $_POST;	
	$email = $rs['email'];
	
	if(!isValidEmail($email)){
		$err = '<span class="error"><span>Invalid email address.</span></span><br>';
	}
	else{
		$rt = $obj->emailLookUp($email);
		if($rt['cnt']){
			$url = DOMAIN."forget-login.php?lg=".base64_encode(base64_encode($email));
			$headers = "From: ".SITE_NAME." <no-reply@no-reply.com>\r\n";
			$headers .= "Reply-To: no-reply@noreply.com\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$subject = 'Login Reminder :: '.SITE_NAME;
			$message = "You have requested a password reset.
						<p>If you have forgotten your password click the link below to reset it now.</p><a href='$url'>$url</a>";
									
			if(@mail($email, $subject, $message, $headers)){
				$err = "<span class='good'>Reset instruction will be sent your inbox...</span><br>";
			}
			else{
				$err = "<span class='error'><span><b>Server error:</b> email not sent...</span></span><br>";
			}                
		}
		else{
			$err = "<span class='error'><span>Email ($email) not found in system...</span></span><br>";
		}
	}
}

if(isset($_GET['lg'])){
	$email  = base64_decode(base64_decode($_GET['lg']));
	$pass   = rand(100001,999999);
	$rt     = $obj->passwordReset($pass,$email);
	if($rt){
		$headers = "From: ".SITE_NAME." <no-reply@no-reply.com>\r\n";
		$headers .= "Reply-To: no-reply@noreply.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$subject = 'Password Reset :: '.SITE_NAME;
		$message = "Your password was successfully reset.
		<p>Password: $pass</p>";
		@mail($email, $subject, $message, $headers);
		header('location: '.DOMAIN.'forget-login.php?n=pass');	
	}
	else{
		$err = "<span class='error'><span>Error password not changed, please try again...</span></span><br>";	
	}
}
?>
<!DOCTYPE html>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>">
<head>  
<meta name="language" content="<?php echo $locale['lang'];?>" />
<meta name="title" content="JusBBmPins.com :: blackBerry pin yellow page">
<meta name="description" content="Find blackberry pins for your BBM messenger, find contacts and BBM chat groups from around the world.">
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $locale['content.type'];?>" />
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>The Yellow page for blackberry pin, register your blackberry pin now, find bbm pins and bbm chat groups :: JusBBmPins.com</title>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5039d3134bebc572"></script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<style>
@import url("styles/login2013.css");
</style>
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
    <br>
    <img src="images/mini-promo.jpg" title="jusbbmpin.com the blackberry yellow page" alt="jusbbmpin.com the blackberry yellow page" width="0" />
    <h1>JusBBmPins.com</h1>
    <div class="gallery">
    	<div class="content">
        	<p>
                <a href="<?php echo DOMAIN;?>" class="reset" title="<?php echo DOMAIN;?>" >&laquo; Back to login</a>
            </p>
            <form name="frm" method="post" action="">
            	<h2><?php echo $locale['password.reset'];?></h2>
                <p><label for="email">Email</label><input type="text" name="email" id="email" autocomplete="off" value="" class="textbox" /></p>
                <p class="btncel"><input type="submit" value="<?php echo $locale['submit'];?>" class="signin" /></p>
            </form>
            <p class="intro">Connect with new BBM individuals and groups that share your similar interest.</p>
            <center>
                <a href="http://www.facebook.com/jusbbmpins" target="_blank" title="follow jusbbmpins.com on facebook"><img src="images/followonfacebook.jpg"/></a><br>
                <a href="https://twitter.com/jusbbmpins" class="twitter-follow-button" data-show-count="false" data-size="large">Follow @jusbbmpins</a>
            </center>
        </div>
    </div>
    <p class="errmsg">
		<?php echo $err;?>
        <?php
        	if(isset($_GET['n'])){		
				echo "<span class='good'>New login information sent to your inbox<br>click <a href='index.php' style='color:#00f;'>here</a> to continue...</span>";
				return;
			}
		?>
    </p>
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
