<?php	
session_start();
include_once("../config/config.php");
	
$loginError = NULL;
if( $_POST )
{
	include_once("../classes/mySqlDB__.class.php");
	include_once("../classes/user.class.php");
	
	$userObj = new user();
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$rs = $userObj->userLogin( $username, $password );
	
	if(!empty($rs))
	{			
		$_SESSION['USER'] = $rs; 
		header("location: ../");
		exit();
	}
	else
	{ 
		$loginError = "<p><span class='err'>Invalid user name or password.</span></p>";
	}
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>One Ppl - Login</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="images/path/to/file" />

	<!-- JavaScript -->
	<script type="text/javascript" src="../js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="../js/ie-check.js"></script>
	<script type="text/javascript" src="../js/facebox.js"></script>
	
	<!-- Facebox -->
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('a[rel*=facebox]').facebox()
		})
	</script>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../css/reset.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<link rel="stylesheet" type="text/css" href="../css/ie-check.css" />
	<link rel="stylesheet" type="text/css" href="../css/facebox.css" />
	
	<!-- Meta Tags -->
	<meta name="robots" content="index, follow" />
	<meta name="description" content="SEO Description (30 chracters)" />
	<meta name="keywords" content="SEO Keyword List (30 keywords unique phrase)" />
	<meta name="author" content="Gabre Cameron" />
	
</head>
<body>
	<?php include_once("../includes/tpl_menu.php");?>
	<div id="ContentTop" class="login">
		
		<div class="container">
		
			<div class="lft">
			</div><!-- left -->
		
			<div class="rgt">
				<img alt="" src="images/logo.jpg" class="logo" />
				
				<div class="textarea">
                    <?php if(isset($_GET['reg'])){ ?>
						<h2>Your Account has been created!</h2>
						<p>A temporary password has been sent to <?php echo base64_decode($_GET['reg']);?>. Please retrieve the email to activate your account.</p>
                    <?php }else{ ?>
                    	<p>&nbsp;</p>
                    	<p>&nbsp;</p>	
                    <?php } ?>		
                    <?php echo $loginError;?>	
                    <form action="login.php" id="LoginForm"  method="post">
						<span class="email">
							<label for="username">E-mail</label>
							<input name="username" type="text" />
						</span>
						<span class="password">
							<label for="password">Password</label>
							<input name="password" type="password" />
						</span>
						<input class="btn login" type="submit" value="Log Me In" />
					</form>
				</div><!-- textarea -->
				
			</div><!-- right -->
		
			<div class="clearfix"></div>
		
		</div><!-- container -->
	
	</div><!-- contentTop -->


	<div id="ContentBottom" class="login">

		<div class="container">
		
			<div class="lft">
				<img alt="" class="credit info" src="images/credit-info.jpg" />
				
			</div><!-- left -->
		
			<div class="rgt">
				<h3>+ Get 25% More Credits on sign up!</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
			</div><!-- right -->	
		
			<div class="clearfix"></div>
		
		</div><!-- container -->
	
	</div><!-- ContentBottom -->
	<?php include_once("../includes/tpl_footer.php"); ?>
</body>
</html>