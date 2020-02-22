<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/commonDB.class.php");
	include_once("classes/user.class.php");
	
	$obj 		= new software();
	$comObj 	= new commonDB();
	$userObj 	= new user();
	
	$page 		= "registration.php";
	$pageTitle	= "&raquo; Registration";
	$mess  		= "";
	$mess2 		= "";
	
	$emailheader  = 'MIME-Version: 1.0' . "\r\n";
	$emailheader .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$emailheader .= "From: downloadhours-admin no-reply@downloadhours.com\r\n";
	
	if($_POST['forget_pass'])
	{
		$e_mail = trim($_POST['email_reminder']);
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $e_mail)) 
		{
			$errEmail2 = "<span class='err'>Email address is invalid or required.</span>";
		}
		else
		{
			$emailEncode= base64_encode(urlencode($e_mail));
			$url		= "<a href=\"http://downloadhours.com/new_password.html?user=$emailEncode\">http://downloadhours.com/new_password.html?user=$emailEncode</a>";
			$to			= $e_mail;
			$subject	= "DownloadHours.com - request for a new password";
			$message	= "A request for a new password was made, to confirm click the link below.<br>$url";
	
			if(@mail($to, $subject, $message, $emailheader))
			{
				$mess	= "<div class='msg'>An email was sent to your inbox.</div>";
				unset($e_mail);
			}
		}
	}
	else
	{
		if($_POST)
		{
			$rs = $_POST;
			$user_name 	= $rs['user_name'];   
			$full_name 	= $rs['full_name'];
			$email 		= $rs['email'];
			
			if(empty($full_name)){ $errName = "<span class='err'>Full name is required.</span>"; unset($_POST);}
			if(empty($user_name)){ $errUser = "<span class='err'>User name is required.</span>"; unset($_POST);}
			if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
			{
				$errEmail = "<span class='err'>Email address is invalid or required.</span>";
				unset($_POST);
			}
		}
		
		if($_POST)
		{
			$_POST['date_added'] 	= date("Y-m-d");
			$_POST['enable'] 		= 1;
			$_POST['account_type']  = ($_POST['developer']==1)? 4 : 3;
			$_POST['no_time_limit'] = 1;
			$password				= $comObj->get_rand_string(8);
			$_POST['password'] 		= md5($password);
			unset($_POST['developer']);
			unset($_POST['registration']); 
			
			if($comObj->insertRecord( $_POST, "odb_account" ))
			{ 
				if($userObj->updateLoginDate(mysql_insert_id()))
				{
					$to			= trim($_POST['email']);
					$subject	= "DownloadHours.com - User registration";
					$message	= "DownloadHours.com user registration.<br><b>Username:</b> $user_name<br><b>Password:</b> $password";
					
					if(@mail($to, $subject, $message, $emailheader))
					{
						$mess2 = "<div class='msg'>Registration complete, an email was sent to your inbox.</div>";
						unset($full_name);
						unset($user_name);
						unset($email);
					}
				}
			}
		}
	}
		
	include_once("page_tmp.php");
?>