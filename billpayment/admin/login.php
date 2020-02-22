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
		
		if( !empty($rs) )
		{
			$_SESSION['admin'] = $rs;
			echo "<script>location='index.php';</script>";
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
<title>Telstar Cable Ltd. | Bill Payment | Login</title>
	
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="../css/blueprint/src/reset.css" />
	<link rel="stylesheet" type="text/css" href="../css/blueprint/src/grid.css" />
	<link rel="stylesheet" type="text/css" href="../css/blueprint/src/forms.css" />
	<link rel="stylesheet" type="text/css" href="../css/blueprint/src/ie.css" />
	<link rel="stylesheet" type="text/css" href="../css/blueprint/src/typography.css" />
	<link rel="stylesheet" type="text/css" href="../css/style.login.css" />


</head>
<body>

	<div id="Container">
	
	<div class="logo">
		<img src="../images/logo.jpg" alt="Telstar Cable Ltd."/>
	</div>

    <form name="f" method="post">
    <table>
      <tr>
        <th colspan="2">Login</th>
      </tr>
      <tr>
        <td><span>Username:</span></td>
        <td class="controlBg"><input type="text" name="username" size="25" /></td>
      </tr>
      <tr>
        <td><span>Password:</span></td>
        <td class="controlBg"><input type="password" name="password" size="25" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="buttons"><input type="submit" class="btnStyle login" value="login" /></td>
      </tr>
    </table>
    </form>
    <div class="output"><?php echo $loginError; ?></div>
	
	</div><!-- Container -->

</body>
</html>