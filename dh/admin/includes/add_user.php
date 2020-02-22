<?php
	include_once("../classes/user.class.php");
	
	$id			= $_GET['id'];
	$userObj 	= new user();
	$tableName 	= "odb_account";
		
	if($_POST)
	{
		$rs 					= $_POST;
		$full_name				= trim($rs['full_name']);
		$user_name				= trim($rs['user_name']);	
		$email					= trim($rs['email']);
		$_POST['enable']		= (empty($rs['enable']))? "0" : "1";
		$_POST['no_time_limit']	= (empty($rs['no_time_limit']))? "0" : "1"; 
		
		if(empty($full_name) ){ $err  = "<div class='err'>Full name is required.</div>"; unset($_POST);}
		if(empty($user_name) ){ $err .= "<div class='err'>Username is required.</div>"; unset($_POST);}
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){$err .= "<div class='err'>Email address is invalid.</div>"; unset($_POST);}
	}
	
	if($_POST)
	{
		if(empty($id))
		{	
			$password 				= $comObj->get_rand_string(8);
			$new_password 			= md5($password); 
			$_POST['password'] 		= $new_password;
			$_POST['date_added']	= date("Y-m-d g:i:s");
			if($comObj->insertRecord( $_POST, $tableName ))
			{
				$subject	= "DownloadHours.com :new login information";
				$message	= "Login information at downloadhours.com<br><b>Username:</b> $user_name<br><br><b>Password:</b> $password";
				$header  	= 'MIME-Version: 1.0' . "\r\n";
				$header 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$header 	.= "From: downloadhours-admin no-reply@downloadhours.com\r\n";
				@mail($email, $subject, $message, $header);
				$comObj->logAdminActions("ADD USER [user_name]");
			}
		}
		else
		{
			$comObj->updateRecord( $_POST, $tableName, $id );
			$comObj->logAdminActions("UPDATE USER [$id]");
		}
		echo "<script> location='index.php?action=list_users'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_users' />";
	}
	
	if(!empty($id))
	{
		$rs = $comObj->getDataById( $tableName, $id );
	}
	else
	{
		$rs['end_date'] = date("Y-m-d");
	}
	
	$btnTitle 		= (empty($id))? "Add" : "Update";
	$frmTitle		= (empty($id))? "Add" : "Edit";
	$accountType = $comObj->getData( "odb_account_type", NULL, "id", NULL);
?>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<?php echo $err;?>
<table>
  <tr><th colspan="2" class="header"><?php echo $frmTitle;?> User</th></tr>
  <tr>
    <th>Account Type</th>
    <td>
		<select name="account_type">
		<?php foreach($accountType as $row){?> 
			<option value="<?php echo $row['id'];?>" <?php echo ($rs['account_type']==$row['id'])? "selected" : "";?> ><?php echo $row['title'];?></option>
		<?php } ?> 
		</select>	</td>
  </tr>
  <tr>
    <th>Full Name<font class="required">*</font></th> 
    <td><input type="text" name="full_name" value="<?php echo cleanString($rs['full_name']);?>" /></td>
  </tr>
  <tr>
    <th>Username<font class="required">*</font></th>
    <td><input type="text" name="user_name" value="<?php echo cleanString($rs['user_name']);?>" /></td>
  </tr>
  <tr>
    <th>Email<font class="required">*</font></th>
    <td><input type="text" name="email" value="<?php echo cleanString($rs['email']);?>" /> <small>Password will be sent to this address</small></td>
  </tr>
  <tr>
    <th>Paypal Account</th>
    <td><input type="text" name="paypal_email" value="<?php echo cleanString($rs['paypal_email']);?>" /></td>
  </tr>
  <tr>
    <th>Access Limit<br /><small>(Only for writers)</small></th>
    <td>
		<input type="checkbox" name="no_time_limit" id="no_time_limit" value="1" <?php echo empty($rs['no_time_limit'])? "" : "checked";?> /> <label for="no_time_limit">No limit</label><hr />
		<input type="text" name="end_date" value="<?=$rs['end_date']?>" size="8" />
		<a href="javascript:showCal('end_date')"><img src="images/calendar.jpg"  border="0"/></a><b>[<a href="javascript:showCal('end_date')">open calendar</a>] End Period</b>	</td>
  </tr>
  <tr>
    <th>Enable</th>
    <td><input type="checkbox" name="enable" value="1" <?php echo empty($rs['enable'])? "" : "checked";?> /></td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" value="<?php echo $btnTitle;?>..." /></td>
  </tr>
</table>
</form>