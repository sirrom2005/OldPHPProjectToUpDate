<?
	include_once("../classes/user.class.php");
	include_once("../js/FCKeditor/fckeditor.php" );
	
	$userObj = new user();
	
	$id 			= $_GET['id'];
	$filePath 	    = NEWS_IMG_PATH;
	$btnTxt 		= (empty($id))? "Add" : "Edit";
	
	if($_POST)
	{
		$rs 			= $_POST;
		$user_name 		= trim($_POST['user_name']);
		$country_id		= trim($_POST['country_id']);
		$pass			= trim($_POST['pass']);
		$pass2			= trim($_POST['pass2']);
		
		$error = "";
		if(empty($user_name))
		{
			$error .= "Username is required.<br>";
			unset($_POST);
		}
		if(empty($country_id))
		{
			$error .= "Please select country.<br>";
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
		if(empty($id))
		{
			//add
			if($userObj->addUser( $_POST ))
			{
				echo "<h3>User added...</h3>";
				return true;
			}
		}
		else
		{
			//edit
			if($userObj->updateUser( $_POST, $id ))
			{
				echo "<h3>User updated...</h3>";
				return true;
			}
		}
		/*echo "<script> location='index.php?action=list_users'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_users' />";*/
	}
	
	if(isset($id))
	{
		$rs = $userObj->getUserById($id);
		$rs = $rs[0]; 
	}
	
	$userLevel 			= $comObj->getHtmlListControlData( "user_level", "name", "id", "id", "DESC" );
	$caribbeanCountries = $comObj->getHtmlListControlData( "countries", "name", "id", "name", "ASC" );
?>

<form name="f" action="" method="post" enctype="multipart/form-data" >
<table>
  <tr><th colspan="2" class="header"><?=$btnTxt?> CMS User</th></tr>
  <tr>
    <th>User Level</th>
    <td>
    	<select name="user_level">
        	<? foreach( $userLevel as $key => $value ){ ?>
        	<option value="<?=$key?>" <?=( $rs['user_level'] == $key )? "selected" : "" ?>  ><?=$value?></option>
            <? } ?>
        </select>    </td>
  </tr>
  <? if(!empty($caribbeanCountries)){ ?>
  <tr>
    <th>Country <font class="required">*</font></th>
    <td>
    	<select name="country_id">
        	<option value="" >-- Select country --</option>
        	<? foreach( $caribbeanCountries as $key => $value ){ ?>
        	<option value="<?=$key?>" <?=( $rs['country_id'] == $key )? "selected" : "" ?>  ><?=$value?></option>
            <? } ?>
        </select>    </td>
  </tr>
  <? } ?>
  <tr>
    <th>User Name<font class="required">*</font></th>
    <td><input type="text" name="user_name" value="<?=cleanString($rs['user_name'])?>" /></td>
  </tr>
  <tr>
    <th>Password<font class="required">*</font></th>
    <td><input type="password" name="pass" /></td>
  </tr>
  <tr>
    <th>Re-type Password<font class="required">*</font></th>
    <td><input type="password" name="pass2" /></td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" value="<?=$btnTxt?>..." />&nbsp;<input type="reset" /></td>
  </tr>
</table>
</form>