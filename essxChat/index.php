<?php
include_once("config/config.php");
if(!isset($_SESSION['SEXXCHAT']) || empty($_SESSION['SEXXCHAT'])){ header("location: login.php"); }
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");

$obj = new site();
@$page = (file_exists('includes/'.$_GET['action'].'.php') )? $_GET['action'].'.php' : 'home.php';
?>
<!DOCTYPE html>
<html>
<head>  
<meta name="title" content="<?php echo SITE_NAME;?> | find new blackberry messenger individuals and BBM groups">
<meta name="description" content="Connect with new blackberry messenger individuals find BBM groups that shear your similar interest">
<meta name="language" content="english" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>BBPIN-Connect.com :: Connect with new BBM individuals and groups that shear your similar interest</title>
<style>
body,h1,p,ol,ul,li,h2,h3{margin:0;padding:0;list-style:none;}
body{color:#39414a; background-color:#e6e7e8;}
img{border:0;}
h2{ font-size:1.3em;}
table{ border-collapse:collapse;}
td, th{padding:3px 0;}
hr{border:0;margin:0;line-height:0; border-top:solid 1px #FFFFFF; clear:left;}
a{color:#36579b;}
a:hover{}
#header{background:#000000;color:#FFFFFF; height:62px; border-bottom:3px solid #90abe2;}
#header div{width:795px; margin:0 auto;}
#header h1{font-size:2em; margin-bottom:1px;}
#header h1 a{text-decoration:none;background:url(images/bbm.png) no-repeat 0 3px; padding-left:32px;}
#header a{color:#FFF;text-decoration:none;}
#header a:hover{color:#f00; }
#container{width:795px;margin:0 auto;border:solid 1px #cccccc;border-top:0; background-color:#FFFFFF;}
#topLinks{float:right;display:inline-block;width:468px;height:60px; padding-top:2px; border:solid 0px #FF0000;}
#topLinks a{border:solid 1px #FF0000; font-size:0.8em; display:inline-block; margin-top:-5px; position:relative;}
#menu li{float:left;}
#menu li a{display:block;padding:3px 5px;background-color:#90abe2;color:#fff;margin-right:2px;font-size:0.9em; font-weight:bold;text-decoration:none;}
#menu li a:hover{background-color:#b7c6ec;color:#000;}
#sebMenu{ background-color:#afc1ce;}
#content{padding:5px 0; min-height:400px;padding:3px 5px 3px 5px;}
.largeProfile .gallery{ 
	padding-right:5px;
	float:left;
	width:250px;
}
.largeProfile .info{ 
	width:530px;
	float:left;
}
#footer{margin-top:20px;padding:0px 5px 3px 5px;}
#footer a{font-size:0.75em;}
#footer a:hover{text-decoration:none;}

.userlist li{float:left;width:230px;margin:0 5px 5px 0; line-height:1.05em;}
.userlist li a,.grouplist li a{display:block;padding:5px;border:solid 1px #afc1ce;text-decoration:none;}
.userlist li a:hover,.grouplist li a:hover{border:solid 1px #6b86be;}
.userlist li .proImg{float:left; margin:0 5px 0 0; width:80px;height:60px; border:solid 1px #666666; padding:2px;}
.userlist li span{display:block;}
ol li{width:164px;margin:0 4px 4px 0; float:left; padding:3px; border:solid 1px #808080; white-space:nowrap;}
ol li a{display:block;text-decoration:none; font-size:0.85em;}
ol li a:hover{color:#90abe2;}
.frmStyle{display:inline-block;}
.frmStyle p{margin-bottom:5px;}
.frmStyle p label{border:solid 0px #FF0000;width:150px;display:inline-block;}
.textbox,.dob{width:200px; border:solid 1px #999; padding:5px;}
.dob{width:70px;}
select{border:solid 1px #999; padding:3px 5px;font-size:0.8em;font-weight:bold;}
textarea{width:550px; height:100px;}
.error{display:inline-block; padding:5px; margin:5px;border:solid 1px #FF3300;color:#300; background:#FFFF99;}
.error li{background:url(images/tick-bullet.png) no-repeat 0 5px; padding-left:15px; text-align:left;}
.good{padding:5px;border:solid 1px #b7c6ec;background-color:#e1e1e1;color:#00f;display:inline-block;margin:5px;}
.verified{background:url(images/tick-bullet.png) no-repeat 0 3px;padding-left:13px; color:#4f982d;}
.notverified{background:url(images/yellow_bullet.gif) no-repeat 0 4px;padding-left:12px;color:#FF0000;}
.required{color:#FF0000; font-size:0.9em;}
</style>
<!--[if IE]>
    <link rel="stylesheet" type="text/css" href="styles/IE.css" />
<![endif]-->
</head>
<body>
<div id="header">
	<div>
    <span id="topLinks">
    	<img src="images/468x60.jpg">
    </span>
    <h1><a href="<?php echo DOMAIN;?>" title="<?php echo SITE_NAME;?>"><?php echo SITE_NAME;?></a></h1>
    <ul id="menu">
        <li><a href="<?php echo DOMAIN;?>">Home</a></li>
        <li><a href="find-bbm-contact.html">Find People</a></li>
        <li><a href="find-bbm-groups.html">Find Groups</a></li>
        <li><a href="profile.html">My Profile</a></li>
    </ul>
    </div>
    <br clear="all">
</div>
<div id="container">
	<!--div id="sebMenu">
    	<a href="change-password.html">change password</a> &bull; <a href="logout.php">logout</a>
    </div-->
    <div id="content">
		<?php include_once('includes/'.$page); ?>
    </div>
    <hr style="visibility:hidden;">
    <div id="footer">
    	<a href="about-us.html">About</a> &bull;
        <a href="privacy-policy.html">Privacy Policy</a> &bull;
        <a href="terms.html">Terms & Conditions</a> &bull;
        <a href="feedback.html">Feedback/Suggestion</a> &bull;
        <a href="contact-us.html">Contact Us</a> &bull;
        <a href="change-password.html">Change Password</a> &bull; <a href="logout.php">Logout</a>
        <br>
        <a><?php echo SITE_NAME;?> &copy; <?php echo date('Y');?></a>
    </div>
</div>
<!-- To my beloved rose [@}~%~~~] wish i had paid more attention, love you always 2012/08/08 xoxo -->
</body>
</html>
