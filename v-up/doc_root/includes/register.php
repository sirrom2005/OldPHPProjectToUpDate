<?php
	$user  = "";
	$email = "";
	$country_id = "";
	/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/ 
	$err = "";
	if(isset($_POST['reg']))
	{
		$user 	= trim($_POST['username']);
		$email 	= trim($_POST['email']);
		$email2	= trim($_POST['email2']);
		$country_id= $_POST['country_id'];
		
		if(empty($user)     ){$err .= "username is required.<br>";}
		if($email != $email2){$err .= "Email does not match.<br>";}
		if(@!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){$err .= "Valid email address required.<br>";}
		if(empty($country_id)){$err .= "Country is required.<br>";} 
		
		if(!empty($err)){ $err ="<span class='err'>$err</span>"; unset($_POST);}
	}
	
	if(!empty($_POST))
	{
		$rs1 = $obj->emailLookUp($email); 
		$rs2 = $obj->userLookUp($user);
		
		$err .= (!empty($rs1['email'])   )? "This email address is already in our system<br>" : "";
		$err .= (!empty($rs2['username']))? "This username is already in our system"      : "";
		if(!empty($err)){ $err = "<span class='err'>$err</span>"; unset($_POST);}
	}

	if(!empty($_POST))
	{				
		$pass = $this->get_rand_string(6);
		unset($_POST['reg']);
		$_POST['password'] = $pass;
		$_POST['dob'] = $_POST['year']."-".$_POST['month']."-".$_POST['day']; 

		if($obj->addUser($_POST))
		{
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: videouploader.net admin@videouploader.net\r\n";
			$sub = "videouploader.net :: account registration";
			$msg = "Thank you for registering at <a href='http://www.videouploader.net'>www.videouploader.net</a>, you can start shearing your 
					videos with the world.<br>
					To upload videos login into the <a href='http://www.videouploader.net/vci/'>video control panel</a> with the information provided below.<br><br><br>
					<b>Username: </b>$user<br>
					<b>Password: </b>$pass<br>";
				
			if(mail($email, $sub, $msg, $header))
			{
				echo "<span class='msg'>Registration complete, your password was sent to your inbox.<br>Message may also be in your junk mail section.</span>";
			}
		}
	}
	
	$country = $this->getCountryList();
	$pageKeywords	 	= "register, signup, membership";
	$pageDescription 	= "videouploader registration form, register now to get full access to all video and downloads, videouploader membership form";
?>
<?php echo $err;?>
<form name="register" class="formStyle1" method="post" action="">
    <h1>Register new account</h1>
    <p><label for="title">Username:</label><input class="text" type="text" name="username" id="username" value="<?php echo $this->cleanString($user);?>" /></p>
    <p><label for="email">Email:</label><input class="text" type="text" name="email" id="email" value="<?php echo $this->cleanString($email);?>" /></p>
    <p><label for="email2">Confirm Email:</label><input class="text" type="text" name="email2" id="email2" /></p>
    <p>
        <label for="title">Date of birth:</label><br />    
        <select name="day">
            <?php for($d=1; $d<=31; $d++){ ?>
            <option value="<?php echo $d;?>"><?php echo $d;?></option>
            <?php } ?>
        </select> /   
        <select name="month">
            <?php $m =1; while($m<=12){ ?>
            <option value="<?php echo $m;?>"><?php echo date("M",mktime(0,0,0,$m+1,0,0));?></option>
            <?php $m++; } ?>
        </select> /  
        <select name="year">
            <?php for($y=5; $y<=70; $y++){ ?>
            <option value="<?php echo date("Y",strtotime("-$y year"));?>"><?php echo date("Y",strtotime("-$y year"));?></option>
            <?php } ?>
        </select>
    </p>
    <p>
        <label for="title">Country:</label>
        <select class="text" name="country_id">
            <option value="">Select your country</option>
            <?php foreach($country as $row){ ?>
            <option value="<?php echo $row['id'];?>"  <?php echo ($row['id']==$country_id)? 'selected' : '';?> ><?php echo $row['name'];?></option>
            <?php } ?>
        </select>
    </p>
    <p>Gender: <input type="radio" checked="checked" name="gender" value="male" />Male <input type="radio" name="gender" value="female" />Female</p>
    <p>Receive newsletter:<input type="radio" checked="checked" name="newsletter" value="1" />Yes <input type="radio" name="newsletter" value="0" />No</p>
    <p align="center"><input type="submit" value="Submit..." name="reg" /></p>
</form>