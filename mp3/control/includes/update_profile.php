<?php
	$err = "";
	$rs = array("fname" => "",
				"mname" => "",
				"lname" => "",
				"dob" => "",
				"email" => "",
				"occupation" => "",
				"password" => "",
				"password2" => "",
				"address1" => "",
				"address2" => "",
				"city" => "",
				"state" => "",
				"zip_code" => "",
				"country_id" => "");
	
	if($_POST)
	{
		$rs			= $_POST;
		$fname		= trim($rs['fname']);
		$dob		= trim($rs['dob']);	   	
		$email	  	= trim($rs['email']);
				
		if(empty($fname)  ){ $err .= "First name is required.<br>"; unset($_POST);}
		if(empty($dob)    ){ $err .= "Date of birth is required.<br>"; unset($_POST);}
		if(empty($email)  ){ $err .= "Email address is required.<br>"; unset($_POST);}
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
		{
			$err .= "Invalid email address.<br>"; 
			unset($_POST);
		}
		if(!empty($err)){echo "<span class='err'>$err</span>";}
	}
	
	if(!empty($_POST))
	{
			$comObj->updateRecord($rs,"odb_account",$id);
			echo "<span class='err'>Account updated..</span>";
	}
	
	if(!empty($id))
	{
		$rs = $comObj->getDataById("odb_account",$id);
	}
	$country = $comObj->getData("odb_country",NULL, NULL,"ASC");
?>
<form name="f" action="" method="post"> 
<p><label for="fname">First name<font class="required">*</font></label><input type="text" name="fname" id="fname" value="<?php echo cleanString($rs['fname']);?>" /></p>
<p><label for="mname">Middle name</label><input type="text" name="mname" id="mname" value="<?php echo cleanString($rs['mname']);?>" /></p>
<p><label for="lname">Last name</label><input type="text" name="lname" id="lname" value="<?php echo cleanString($rs['lname']);?>" /></p>
<p><label for="dob">Date of birth<font class="required">*</font></label><input type="text" name="dob" id="dob" size="8" value="<?php echo cleanString($rs['dob']);?>" /> [yyyy-mm-dd]</p>
<p><label for="email">Email<font class="required">*</font></label><input type="text" name="email" id="email" <?php if(isset($id)){ echo "readonly";}?> value="<?php echo cleanString($rs['email']);?>" /> <?php if(empty($id)){ ?>Password will be email to you.<?php } ?></p>
<p><label for="occupation">Occupation</label><input type="text" name="occupation" id="occupation" value="<?php echo cleanString($rs['occupation']);?>" /></p>
<p><label for="address1">Address 1</label><input type="text" name="address1" id="address1" value="<?php echo cleanString($rs['address1']);?>" /></p>
<p><label for="address2">Address 2</label><input type="text" name="address2" id="address2" value="<?php echo cleanString($rs['address2']);?>" /></p>
<p><label for="city">City</label><input type="text" name="city" id="city" value="<?php echo cleanString($rs['city']);?>" /></p>
<p><label for="state">State</label><input type="text" name="state" id="state" value="<?php echo cleanString($rs['state']);?>" /></p>
<p><label for="zip_code">Zip code</label><input type="text" name="zip_code" id="zip_code" value="<?php echo cleanString($rs['zip_code']);?>" /></p>
<p>
	<label for="country_id">Country</label>
    <select name="country_id" id="country_id">
    	<option value="">Select country</option>
		<?php foreach($country as $row){?>
    	<option value="<?php echo $row['country_id'];?>" <?php echo ($row['country_id']==$rs['country_id'])? "selected" : "";?> ><?php echo cleanstring($row['name']);?></option>
        <?php }?>
    </select>
</p>
<?php if(isset($showProducerOption)){ ?>
<p><label>I'm a music producer?</label><input type="checkbox" name="account_type" value="2" /></p>
<?php }else{ ?>
<p><textarea name="bio"><?php echo cleanString($rs['bio']);?></textarea></p>
<?php } ?>
<p><input type="submit" value="Submit..." /></p>
</form>