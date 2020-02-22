<?php
$msg = "";
if($_POST){
    $rs   	= $_POST;
	$old_password   = cleanText($rs['old_password']);
	$password   	= cleanText($rs['password']);
	$password2   	= cleanText($rs['password2']);
	$valid = true;

	if(empty($old_password)){
		$msg .= '<li>Old Password is required.</li>';
		$valid = false;
	}
	
	if($password != $password2){
		$msg .= '<li>Password does not match.</li>';
		$valid = false;
	}

	if(strlen($password) < 6){		
		$msg .= '<li>Password must be 6 characters or more.</li>';
		$valid = false;
	}

	if($valid){
		if($obj->updatePassword($old_password,$password)){
			echo "<span class='good'>Password successfully changed...</span>";
			return;
		}
		else{
			$msg = "<span class='error'><li>Your password was incorrect.</li></span><br>";
		}
	}
	else{
		$msg = "<span class='error'>$msg</span><br>";
	}
}
?>
<div class="boxStyle1">
<?php echo $msg;?>
<h2 class="frmhdr">Change Password</h2>
<form name="frm" id="frm" class="frmStyle1" method="post" action=""> 
    <p><label class="lbl" for="old_password">Old Password<font style="color:#FF0000;">*</font></label><input type="password" name="old_password" id="old_password" class="textbox" /></p>
    <p><label class="lbl" for="password">Password<font style="color:#FF0000;">*</font></label><input type="password" name="password" id="password" class="textbox" /></p>
    <p><label class="lbl" for="password2">Confirm Password</label><input type="password" name="password2" id="password2" class="textbox" /></p>
    <p align="center"><input type="submit" class="button" id="btn" value="Send"></p>
</form>
</div>