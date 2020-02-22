<?php 
	$errlogin= "";
	$user  = "";
	$email = "";
	if(isset($_POST['login']))
	{
		$usr 	= $_POST['username'];
		$pass 	= $_POST['password'];
		$rs		= $obj->loginUser($usr, $pass);
		
		if(!empty($rs['username']))
		{ 
			$_SESSION['ADMIN_USER'] = $rs;
			exit("<script>window.location='index.php?action=my_videos';</script>");
		}
		else
		{
			$errlogin = "<span class='err'>Invalid username/password...</span>";
		}
		unset($_POST);
	}
	
	include_once("../classes/commonDB.class.php");
	$comObj = new commonDB();
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
		$pass = $comObj->get_rand_string(6);
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
	
	$country = $comObj->getHtmlListControlData( "country", "name", "country_id", NULL,"ASC"); 
?>
<div class="leftside">
<?php echo $err;?>
    <form name="register" class="formStyle1" method="post" action="">
        <h1>Register new account</h1>
        <p><label for="title">Username:</label><input class="text" type="text" name="username" id="username" value="<?php echo cleanString($user);?>" /></p>
        <p><label for="email">Email:</label><input class="text" type="text" name="email" id="email" value="<?php echo cleanString($email);?>" /></p>
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
                <?php foreach($country as $key => $value){ ?>
                <option value="<?php echo $key;?>"  <?php echo ($key==$country_id)? "selected" : "";?> ><?php echo $value;?></option>
                <?php } ?>
            </select>
        </p>
        <p>Gender: <input type="radio" checked="checked" name="gender" value="male" />Male <input type="radio" name="gender" value="female" />Female</p>
        <p>Receive newsletter:<input type="radio" checked="checked" name="newsletter" value="1" />Yes <input type="radio" name="newsletter" value="0" />No</p>
        <p align="center"><input type="submit" value="Submit..." name="reg" class="btn" /></p>
    </form>
</div>
<div class="rightside">
    <form name="frm" class="formStyle1" method="post" action="">
        <h1>Login</h1>
        <p><label for="title">Username:</label><input class="text" type="text" name="username" id="username" /></p>
        <p><label for="title">Password:</label><input class="text" type="password" name="password" id="password" /></p>
        <p align="center"><input type="submit" name="login" value="Submit..." class="btn" /></p>
        <p style="text-align:center;"><a href="<?php echo DOMAIN?>request_login.html">forget password</a></p>
    </form>
    <p>&nbsp;</p>
    <?php echo $errlogin;?>
</div>