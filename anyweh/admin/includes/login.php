<?php
	if( $_POST )
	{
		include_once("../classes/user.class.php");
		
		$userObj = new user();
		
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		$rs = $userObj->userLogin( $username, $password );
		
		if( !empty($rs) )
		{
			$_SESSION['admin'] = $rs;
			echo "<script>location='index.php?action=home'</script>";
		}
		else
		{ 
			$loginError = "Invalid user name or password.";
		}
	}
?>
<br /><br /><br /><br />
<form name="f" method="post">
<table align="center" width="200" cellpadding="0" cellspacing="0" border="0" class="tableStyle1" bgcolor="#FFFFFF">
  <tr>
    <th colspan="2" class="header">Admin login</th>
  </tr>
  <tr>
    <th>Username</th>
    <td class="controlBg"><input type="text" name="username" size="22" /></td>
  </tr>
  <tr>
    <th>Password</th>
    <td class="controlBg"><input type="password" name="password" size="22" /></td>
  </tr>
  <tr>
  	<td colspan="2" align="center"><input type="submit" class="btnStyle" value="Login" /></td>
  </tr>
</table>
<p align="center" style="font-size:11pt;">[ <a class="link1" href="../index.html">Main site</a> ]<!--[ <a class="link1" href="#">Forget password</a> ]--></p>
</form>
<br />
<div class="errorMessage">&nbsp;<?=$loginError?>&nbsp;</div>
<br /><br />