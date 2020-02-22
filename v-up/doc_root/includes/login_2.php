<?php 
	require_once('classes/twitteroauth/twitteroauth.php');
	$errlogin = "";
	$user  = "";
	$email = "";
	if(isset($_POST['login']))
	{
		$usr 	= $_POST['username'];
		$pass 	= $_POST['password'];
		$rs		= $obj->loginUser($usr, $pass);
		
		if(!empty($rs['username']))
		{ 
			$_SESSION['ADMIN_USER'] = $rs;
			header("location: /vci/");
		}
		else
		{
			$errlogin = "<span class='err'>Invalid username/password...</span>";
		}
		unset($_POST);
	}
	
	if(isset($_SESSION['access_token']))
	{
		/*TWITTER SECTION*/
		$access_token = $_SESSION['access_token'];
		/* Create a TwitterOauth object with consumer/user tokens. */
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		/* If method is set change API call made. Test is called by default.*/
		//$content = $connection->get('account/verify_credentials');
		if(!empty($access_token))
		{
			$_SESSION['ADMIN_USER'] = $obj->OAuthConnetion($access_token['user_id'], $access_token['screen_name']);
			header("location: /vci/");
		}
	}
?>
<div id="socail_logins">
<a class="tw" href="includes/twitter_login_redirect.php" title="sign in with your twitter account."></a>
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