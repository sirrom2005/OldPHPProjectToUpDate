<?php
set_time_limit(1800);
ob_start(); 
	include_once("../newsletter/index.html"); 
	$content = ob_get_contents();
	$content = trim($content);
ob_end_clean();
ob_implicit_flush(true);
include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/site.class.php");
$obj = new site();
echo $content;
?>
<?php
include_once('PHPMailer___/class.phpmailer.php');
$mail	= new PHPMailer();
$body	= eregi_replace("[\]",'',$content);

//$mail->IsSendmail(); // telling the class to use SendMail transport
$mail->From       = "videouploader@videouploader.net";
$mail->FromName   = "videouploader.net";
$mail->Subject    = "videouploader.net - newsletter";
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->MsgHTML($body);


for($i=0;$i<36;$i++)
{
	$amt= $i*30;
	$rs = $obj->runEmailList($amt);	
	foreach($rs as $row)
	{ 
		$mail->AddAddress($row['email']);

		if(!$mail->Send()) {
		  echo "<br>Mailer Error: - {$row['email']}" . $mail->ErrorInfo;
		} else {
		  echo "<br>Message sent! - {$row['email']}";
		}
		ob_flush();
		flush();
	}
	echo "<p>Please wait....</p>";
	sleep(5);
}
?>