<?
	include_once("../classes/user.class.php");
	include_once("../js/FCKeditor/fckeditor.php" );
	
	$userObj = new user();
	$filePath 	    = NEWS_IMG_PATH;
		
	if($_POST)
	{
		$rs 			= $_POST;
		$pass			= trim($_POST['pass']);
		$pass2			= trim($_POST['pass2']);
		
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
		echo "<div class='error'>$error</div>";
	}
	
	if($_POST)
	{				
		$id = (!empty($_GET['id']))? $_GET['id'] : $_SESSION['admin']['id'];
		$rs = $userObj->changePassword( $_POST['pass'], $id );
		if($rs['usCount'] > 0)
		{
			echo "<h3>Password changed...</h3>";
			return true;
		}
	}
?>

<form name="f" action="" method="post" enctype="multipart/form-data" >
<table>
  <tr><th colspan="2" class="header">Change Your Password</th></tr>
  <? if(!empty($caribbeanCountries)){ ?>
  <? } ?>
  <tr>
    <th>Password<font class="required">*</font></th>
    <td><input type="password" name="pass" value="" /></td>
  </tr>
  <tr>
    <th>Re-type Password<font class="required">*</font></th>
    <td><input type="password" name="pass2" value="" /></td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" value="Update..." /></td>
  </tr>
</table>
</form>