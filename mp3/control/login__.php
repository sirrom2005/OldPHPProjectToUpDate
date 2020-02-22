<?php	
session_start();
$loginError = NULL;
if( $_POST )
{
	include_once("../config/config.php");
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
		$loginError = "Invalid user name or password.";
	}
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Members Login</title>
<style>
body{ margin:0; padding:0;}
center{color:#FF0000; font-weight:bold;}
a{ color:#0000FF;}
a:hover{ text-decoration:none;}
form{ margin:150px 0 50px 0;}
table{border:solid 1px #c25208;}
table th{ background-image:url(images/sub_menu_strip.jpg);  height:30px; padding:0 5px 0 10px; color:#FFFFFF; font-size:20px}
table td{ padding:5px; font-weight:bold;}
</style>
</head>
<body>
    <form name="f" method="post">
    <table align="center" cellpadding="0" cellspacing="0" border="0" class="tableStyle1" bgcolor="#FFFFFF">
      <tr>
        <th colspan="2">login</th>
      </tr>
      <tr>
        <td><span>Email</span></td>
        <td class="controlBg"><input type="text" name="username" size="25" /></td>
      </tr>
      <tr>
        <td><span>Password</span></td>
        <td class="controlBg"><input type="password" name="password" size="25" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="submit" class="btnStyle" value="Login" /></td>
      </tr>
    </table>
    <p align="center" style="font-size:11pt;">[ <a class="link1" href="../index.html">Main site</a> ]<!--[ <a class="link1" href="#">Forget password</a> ]--></p>
    </form>
    <center><?php echo $loginError; ?></center>
</body>
</html>