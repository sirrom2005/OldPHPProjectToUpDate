<?php 
include_once("../config/config.php");
ini_set('max_execution_time',0);
ob_implicit_flush(true); 
ob_end_flush();

$filename   = 'meet_new_male_member.html';
$fp         = fopen($filename,'r');
$content    = fread($fp, filesize($filename));
fclose($fp);
$bcc = '';


$con = mysql_connect(DBHOST,DBUSERNAME,DBPASSWORD) || die('Counld not connect...');
if(mysql_select_db(DBDATABASE))
{
    $query = "SELECT fname, email FROM people WHERE gender_prefrence ='M' OR gender_prefrence is null";			
	$rs = mysql_query($query);	
	while( $row = mysql_fetch_assoc($rs) ){
		if(isValidEmail($row['email'])){
			$bcc .="{$row['email']}, ";
		}
	}	
    	
	$headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
	$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
	$headers .= "Return-Path: bounce@my-schools.com\r\n";
	$headers .= "Return-Receipt-To: bounce@my-schools.com\r\n";
	$headers .= "Bcc: ".$bcc."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
  	
	if(@mail(NULL,'Newest Member',$content,$headers)){
		echo "email send too $bcc<br>";
		echo $content;
	}				
}

function isValidEmail($email){
	return @eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}
?>