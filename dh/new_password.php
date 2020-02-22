<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/commonDB.class.php");
	include_once("classes/user.class.php");
	
	$obj 		= new software();
	$comObj 	= new commonDB();
	$userObj	= new user();
	
	$page 		= "new_password.php";
	$pageTitle	= "&raquo; New Password Request";
	
	$email 		= urldecode(base64_decode($_GET['user']));
	$password	= $comObj->get_rand_string(8);
	
	$username = $userObj->getUserByEmail( $email );
	
	if( $userObj->updateUserPassword($password, $email) )
	{
		$header  	= 'MIME-Version: 1.0' . "\r\n";
		$header 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header 	.= "From: no-reply@downloadhours.com\r\n";
		$to			= $email;
		$subject	= "DownloadHours.com - password changed";
		$message	= "New login information for downalodhours.com is below.<br><b>Username:</b> {$username[user_name]}<br><b>Password:</b> $password";

		if(mail($to, $subject, $message, $header))
		{
			$mess = "<p align='center'>New login information was send to your inbox.</p><p>&nbsp;</p>";
		}
	}
	
	include_once("page_tmp.php");
?>