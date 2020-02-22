<?php
session_start();
include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/commonDB.class.php");
include_once("../classes/site.class.php");

$siteObj = new site();
$comObj = new commonDB();

$err 		= "";
if($_POST)
{
	$rs		= $_POST;
	$fname	= trim($rs['fname']);   	
	$email	= trim($rs['email']);
	$country_id	= $rs['country_id'];
			
	if(empty($fname)     ){ $err .= "First name is required.<br>"; unset($_POST);}
	if(!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) 
	{
		$err .= "Invalid email address.<br>"; 
		unset($_POST);
	}
	
	if(empty($country_id)) 
	{
		$err .= "Please sdelect your country.<br>"; 
		unset($_POST);
	}
	if(!empty($err)){echo "<span class='err'>$err</span>";}
}

if(!empty($_POST))
{
	$rs['date_added'] = date("Y-m-d");
	$password   	  = $comObj->get_rand_string(6);
	$rs['password']	  = md5($password);

	if($siteObj->emailLookUp($rs['email']))
	{
		echo "<span class='err'>This email address is already in our system<br>you can click <a href='request_login.html'>here</a> if you have forgotten you login information.</span>";
	}
	else
	{
		if($comObj->insertRecord($rs,"odb_account"))
		{				
			$subject = "New account information";
			$message = "<h3>New account information</h3>
						Username: $email<br>
						Password: $password";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: admin no-reply@downloadhours.com\r\n";
			@mail($email,$subject,$message,$header);
			header("location: login.php?reg=".base64_encode($email));
		}
	}
}
$country = $comObj->getData("odb_country",NULL, NULL,"ASC");
$rs = array('country_id' => NULL);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>One Ppl - Login</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="../images/path/to/file" />

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
	<div id="ContentTop" class="sign-up">
		
		<div class="container">
		
			<div class="lft">
			</div><!-- left -->
		
			<div class="rgt">
				<img alt="" src="../images/logo.jpg" class="logo" />
				
				<div class="textarea">
					<h2>Join the Revolution!</h2>
					<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>	
					<form action="" id="RegistrationForm"  method="post">
						<span class="email">
							<label for="email">E-mail</label>
							<input name="email" type="text" />
						</span>
						<span class="fname">
							<label for="firstname">First Name</label>
							<input name="fname" type="text" />
						</span>
						<span class="lname">
							<label for="lastname">Last Name</label>
							<input name="lname" type="text" />
						</span>
						<span class="country">
							<label for="country">Country</label>
                            <select name="country_id" id="country_id" >
                                <option value="">Select country</option>
                                <?php foreach($country as $row){?>
                                <option value="<?php echo $row['country_id'];?>" <?php echo ($row['country_id']==$rs['country_id'])? "selected" : "";?> ><?php echo cleanstring($row['name']);?></option>
                                <?php }?>
                            </select>
						</span>
						<input class="btn sign-up" type="submit" value="Sign Me Up!" />
					</form>
				</div><!-- textarea -->
				
			</div><!-- right -->
		
			<div class="clearfix"></div>
		
		</div><!-- container -->
	
	</div><!-- contentTop -->


	<div id="ContentBottom" class="sign-up">

		<div class="container">
		
			<div class="lft">
				<a href="../buycredits.html"><img alt="" class="credit info" src="../images/credit-info.jpg" /></a>
			</div><!-- left -->
		
			<div class="rgt">
				<h3>+ Get 25% More Credits on sign up!</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim.</p>
			</div><!-- right -->	
		
			<div class="clearfix"></div>
		
		</div><!-- container -->
	
	</div><!-- ContentBottom -->
	<?php include_once("../includes/tpl_footer.php"); ?></body>
</html>