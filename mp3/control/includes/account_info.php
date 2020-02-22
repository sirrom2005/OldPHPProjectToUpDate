<?php
	$id = $_GET['id'];
	$rs = $comObj->getDataById("odb_account",$id);
	$country = $comObj->getData("odb_country",NULL, NULL,"ASC");
?>
<form name="f" action="" method="post"> 
<h1>Account Info</h1>
<p><label for="fname">First name<font class="required">*</font></label><?php echo cleanString($rs['fname']);?></p>
<p><label for="mname">Middle name</label><?php echo cleanString($rs['mname']);?></p>
<p><label for="lname">Last name</label><?php echo cleanString($rs['lname']);?></p>
<p><label for="dob">Date of birth</label><?php echo cleanString($rs['dob']);?></p>
<p><label for="email">Email<font class="required">*</font></label><?php echo cleanString($rs['email']);?></p>
<p><label for="occupation">Occupation</label><?php echo cleanString($rs['occupation']);?></p>
<p><label for="address1">Address 1</label><?php echo cleanString($rs['address1']);?></p>
<p><label for="address2">Address 2</label><?php echo cleanString($rs['address2']);?></p>
<p><label for="city">City</label><?php echo cleanString($rs['city']);?></p>
<p><label for="state">State</label><?php echo cleanString($rs['state']);?></p>
<p><label for="zip_code">Zip code</label><?php echo cleanString($rs['zip_code']);?></p>
<p>
<label for="country_id">Country</label>
    <?php foreach($country as $row){?>
    <?php echo ($row['country_id']==$rs['country_id'])? "{$row['name']}" : "";?>
    <?php }?>
</p>
<p><?php echo cleanString($rs['bio']);?></p>
</form>