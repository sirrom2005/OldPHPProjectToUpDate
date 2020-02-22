<?php
$err = "";
$current = "";
if($_POST)
{
	$rs		= $_POST;
	$fname	= trim($rs['fname']);   	
	$email	= trim($rs['email']);
	$country_id	= $rs['country_id'];
			
	if(empty($fname)     ){ $err .= "First name is required.<br>"; unset($_POST);}
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
	{
		$err .= "Invalid email address.<br>"; 
		unset($_POST);
	}
	if(!empty($err)){echo "<span class='err'>$err</span>";}
}

if(!empty($_POST))
{
	$rs['date_added'] = date("Y-m-d");
	$password   	  = $comObj->get_rand_string(6);
	$rs['password']	  = md5($password);

	if($siteObj->emailLookUp($rs['email']))
	{
		echo "<span class='err'>This email address is already in our system<br>you can click <a href='request_login.html'>here</a> if you have forgotten you login information.</span>";
	}
	else
	{
		if($comObj->insertRecord($rs,"odb_account"))
		{				
			$subject = "New account information";
			$message = "<h3>New account information</h3>
						Username: $email<br>
						Password: $password";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: admin no-reply@downloadhours.com\r\n";
			@mail($email,$subject,$message,$header);
			header("location: control/login.html?reg=".base64_encode($email));
		}
	}
}
$country = $comObj->getData("odb_country",NULL, NULL,"ASC");
$rs = array("country_id" => NULL);
?>
<h2>Join the Revolution!</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>

<form action="" id="RegistrationForm"  method="post">
    <span class="email">
        <label for="email">E-mail</label>
        <input name="email" type="text" />
    </span>
    <span class="fname">
        <label for="firstname">First Name</label>
        <input name="fname" type="text" />
    </span>
    <span class="lname">
        <label for="lastname">Last Name</label>
        <input name="lname" type="text" />
    </span>
    <span class="country">
        <label for="country_id">Country</label>
        <select name="country_id" id="country_id">
            <option value="">Select country</option>
            <?php foreach($country as $row){?>
            <option value="<?php echo $row['country_id'];?>" <?php echo ($row['country_id']==$rs['country_id'])? "selected" : "";?> ><?php echo cleanstring($row['name']);?></option>
            <?php }?>
        </select>
    </span>
    <input class="btn sign-up" type="submit" value="Sign Me Up!" />
</form>