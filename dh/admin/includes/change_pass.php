<?php
	if(!$userObj)
	{
		include_once("../classes/user.class.php");
		$userObj = new user();
	}
			
	$id = $_GET['id'];
			
	if($_POST)
	{
		$rs 			= $_POST;
		$pass			= trim($_POST['password']);
		$pass2			= trim($_POST['password2']);
		
		$error = "";
		if(empty($pass))
		{
			$error .= "Password is required.<br>";
			unset($_POST);
		}
		if($pass != $pass2)
		{
			$error .= "Password do not match.<br>";
			unset($_POST);
		}
		if( strlen($pass)<6 )
		{
			$error .= "6 or more character is required for password.<br>";
			unset($_POST);
		}
		echo "<div class='err'>$error</div>";
	}
	
	if($_POST)
	{		
		unset($_POST['password2']);	
		$_POST['password'] = md5($pass);
		if( $comObj->updateRecord($_POST, "odb_account", $id ) )
		{
			echo "<div class='msg'>Password changed...</div>";
			return true;
		}
	}
?>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<table>
  <tr><th colspan="2" class="header">Change Your Password</th></tr>
  <tr>
    <th>Password<font class="required">*</font></th>
    <td><input type="password" name="password" value="" /></td>
  </tr>
  <tr>
    <th>Re-type Password<font class="required">*</font></th>
    <td><input type="password" name="password2" value="" /></td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" value="Update..." /></td>
  </tr>
</table>
</form>
<?php $comObj->logAdminActions("CHANGE PASSWORD FOR USER [$id]"); ?>