<?php
$errlogin = "";
if(isset($_POST['login']))
{
	$usr 	= $_POST['username'];
	$pass 	= $_POST['password'];
	$rs		= $obj->loginUser($usr, $pass);
	
	if(!empty($rs['username']))
	{ 
		$_SESSION['ADMIN_USER'] = $rs;
		header("location: vci/");
	}
	else
	{
		$errlogin = "<span class='err'>Invalid username/password...</span>";
	}
	unset($_POST);
}

	$pageKeywords	 	= "members login, facebook, twitter sign in";
	$pageDescription 	= "sgin in to videouploader.net with your facebook or twitter account to upload your videos";
?>
<div id="socail_logins">
<a class="tw" href="includes/twitter_login_redirect.php" title="sign in with your twitter account."></a>
<a class='fb' href='https://www.facebook.com/login.php?api_key=136619716380889&cancel_url=http://www.videouploader.net/login.html&display=page&fbconnect=1&next=http://www.videouploader.net/includes/facebook_login.php&return_session=1&session_version=3&v=1.0' title='sign in with your facebook account.'></a>
</div>

<form name="frm" class="formStyle1" method="post" action="" style="width:300px;">
    <h1>Login</h1>
    <p><label for="title">Username:</label><input class="text" type="text" name="username" id="username" /></p>
    <p><label for="title">Password:</label><input class="text" type="password" name="password" id="password" /></p>
    <p align="center"><input type="submit" name="login" value="Submit..." class="btn" /></p>
    <p style="text-align:center;"><a href="<?php echo DOMAIN?>request_login.html">forget password</a></p>
</form>
<p>&nbsp;</p>
<?php echo $errlogin;?>