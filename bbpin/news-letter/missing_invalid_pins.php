<?php 
include_once("../config/config.php");
ini_set('max_execution_time',0);
ob_implicit_flush(true); 
ob_end_flush();

$filename   = 'missing_invalid_pins.html';
$fp         = fopen($filename,'r');
$content    = fread($fp, filesize($filename));
fclose($fp);
$bcc = '';

$con = mysql_connect(DBHOST,DBUSERNAME,DBPASSWORD) || die('Counld not connect...');
if(mysql_select_db(DBDATABASE))
{
    $query = "select p.fname,p.email, '' as bbmpin from people p where id not in ( select account_id from bbm_pin) and id != 44 and id != 45 and id != 35
			  UNION
			  select a.fname,a.email,p.bbmpin from bbm_pin p
			  INNER JOIN people a ON a.id = p.account_id 
			  where LENGTH(p.bbmpin)!=8";			
	$rs = mysql_query($query);	
	
	$headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
	$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
	$headers .= "Return-Path: bounce@my-schools.com\r\n";
	$headers .= "Return-Receipt-To: bounce@my-schools.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
	while( $row = mysql_fetch_assoc($rs) ){
		$email = $row['email'];
		if(isValidEmail($email)){
			$message = str_replace("_PIN_",$row['bbmpin'],$content);
			$message = str_replace("__NAME__",$row['fname'],$message); 
			if(@mail($email,'Invalid BBM-PIN',$message,$headers)){
				echo "email send too $email<br>";
			}
		}
	}
	echo $message.'<br>';				
}

function isValidEmail($email){
	return @eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}
?>