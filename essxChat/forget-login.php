<?php
include_once("config/config.php"); 
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
$obj = new site();
$err = '';
if($_POST)
{	
	$rs = $_POST;	
	$email = $rs['email'];
	
	if(!isValidEmail($email)){
		$err = '<span class="error"><li>Invalid email address.</li></span>';
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
				$err = "<span class='good'>Reset instruction will be sent your inbox...</span>";
			}
			else{
				$err = "<span class='error'><li><b>Server error:</b> email not sent...</li></span>";
			}                
		}
		else{
			$err = "<span class='error'><li>Email ($email) not found in system...</li></span>";
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
		$err = "<span class='error'><li>Error password not changed, please try again...</li></span>";	
	}
}

if(isset($_GET['n'])){		
	$err = "<span class='good'>New login information sent to your inbox<br>click <a href='index.php' style='color:#00f;'>here</a> to continue...</span>";
}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="images/favicon.png" />
<meta name="title" content="video chat live with sexy hot girl from around the world">
<meta name="keywords" content="video,chat,room,live,girls,pron,single">
<meta name="description" content="video chat live with sexy hot naked girl from around the world">
<title><?php echo SITE_NAME;?> :: chat live with sexy hot girl from around the world</title>
<style>
@import url("styles/front-page.css");
</style>
</head>
<body>
	<div id="container">
        <h1><a href="<?php echo DOMAIN;?>"><?php echo SITE_NAME;?></a></h1>
        <p>Have live video chat with sexy hot naked girl from around the world.</p>
		<?php echo $err;?>
        <form name="frm" method="post" action="">
            <p><b>Enter your email to receive password reset instruction.</b></p>
            <p><input type="text" name="email" id="email" autocomplete="off" value="" class="textbox" /></p>
            <p><input type="submit" value="Enter" class="btn" /></p>
        </form>
    </div>
</body>
</html>
