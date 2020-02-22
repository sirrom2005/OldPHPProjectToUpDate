<?php
	$err 	= "";
	$email 	= "";
	if($_POST)
	{
		$email 	= trim($_POST['email']);
		
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
		{
			$err .= "Invalid email address entered.<br>";
		}
		if(!empty($err)){ $err ="<span class='err'>$err</span>"; unset($_POST);}
	}
	
	if(!empty($_POST))
	{
		include_once("classes/commonDB.class.php");
		$comObj = new commonDB();
		
		$pass = $comObj->get_rand_string(6);
		$rs = $obj->getAcountInfoByEmail($email, $pass);
				
		if(!empty($rs))
		{
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: videouploader.net admin@videouploader.net\r\n";
			$sub = "videouploader.net :: Login information requested";
			$msg = "Login information requested.<br> 
					You can change your password any time after you login into the <a href='http://www.videouploader.net/vci/'>control panel</a>.<br><br><br>
					<b>Username: </b>{$rs['username']}<br>
					<b>Password: </b>$pass<br>";

			if(@mail($rs['email'], $sub, $msg, $header))
			{
				echo "<span class='msg'>login information was sent to your inbox.<br>Message may also be in your junk mail section.</span>";
			}
		}
	}
?>
<?php echo $err;?>
<form name="register" class="formStyle1" method="post" action="">
    <h1>Request login</h1>
    <p>
    	Enter you registration email<br />
        <input class="text" type="text" name="email" id="email" value="<?php echo cleanString($email);?>" />
    </p>
    <p><input type="submit" value="Submit..." class="btn" /></p>
    
</form>