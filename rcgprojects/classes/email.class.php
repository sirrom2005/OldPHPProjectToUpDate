<?php

	class email
	{
		function email()
		{
			return true;
		}
		
		function sendEmail( $emailAddress, $subject="", $message="",  $name="", $sendTo="" )
		{
			require_once("phpmailer/class.phpmailer.php");
	
			$mail = new PHPMailer();
	
			$mail->Host     = "localhost"; // SMTP servers
			$mail->SMTPAuth = false;     // turn on SMTP authentication
			$mail->Username = "";  // SMTP username
			$mail->Password = ""; // SMTP password
			
			$mail->From     = $emailAddress;
			$mail->FromName = $name;
			$mail->AddReplyTo( $emailAddress, $name );
			
			if( !empty($sendTo) )
			{ 
				$mail->AddBCC( $sendTo );
			}
			else
			{   
				$mail->AddBCC( "amahmood@rcgprojects.com" );
				$mail->AddBCC( "mmcnally@rcgprojects.com" );
			}
			
			$mail->WordWrap = 50;                              // set word wrap
			$mail->IsHTML(true);                               // send as HTML
			
			$mail->Subject  =  $subject;
			$mail->Body     =  $message;

			if($mail->Send())
			{
				return true;
			}
			else
			{
				echo( "<center>Email error.<center><br><br><br>");
				return false;
			}
		}
	}

?>