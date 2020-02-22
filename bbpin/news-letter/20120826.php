<?php 
/*
*NOTE: crash at 279 count
*
*/
ini_set('max_execution_time',0);
ob_implicit_flush(true); 
ob_end_flush();

$filename   = 'index.html';
$fp         = fopen($filename,'r');
$content    = fread($fp, filesize($filename));
fclose($fp);

include_once("../config/config.php");
$con = mysql_connect(DBHOST,DBUSERNAME,DBPASSWORD) || die('Counld not connect...');
if(mysql_select_db(DBDATABASE))
{
    $query = "SELECT p.id 
			,p.fname
			,p.lname
			,p.email
			FROM people p 
			WHERE 0=0 
			AND p.id NOT IN (select account_id from bbm_pin) 
			OR p.id not in (select account_id from account_gallery)
			GROUP BY p.id";			
			
    function isValidEmail($email){
		return @eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
    }
	
	$headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
	$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
	$headers .= "Return-Path: bounce@my-schools.com\r\n";
	$headers .= "Return-Receipt-To: bounce@my-schools.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	
    $data = array();   
    $rs = mysql_query($query);
	echo str_repeat(" ", 1024*64); //because of FF buffer	
	while( $row = mysql_fetch_assoc($rs) ){
		if(isValidEmail($row['email'])){
			$email = $row['email'];			
			$n = $row['fname'].' '.$row['lname'];			
			$message = str_replace('_NAME_',$n,$content);
			/*if(@mail($email,'Email update',$message,$headers)){
				echo "email send too $email<br>";
				echo $message.'<br>';
			}*/
		}
    }
	echo "<br>THE END";				
}
?>