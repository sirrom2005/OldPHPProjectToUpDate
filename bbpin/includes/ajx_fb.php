<?php
/*~~FEEDBACK ADD~~*/
include_once("../config/config.php");
$s = $_GET['s'];
$t = $_GET['t'];
$u = base64_decode($_GET['u']);
$c = (isset($_GET['c'])) ? $_GET['c'] : '';
$d = (isset($_GET['d'])) ? $_GET['d'] : '';
$e = (isset($_GET['e'])) ? $_GET['e'] : '';
if(empty($s) || empty($t)){return false;}

$headers = "From: \"".SITE_NAME."\" <".SITE_EMAIL.">\r\n";
$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$sub      = 'Site-Feedback';
$eMessage = "<p><b>Subject: $s</b></p>".$t."<p><b>Page URL:</b> $u</p><p><b>Content:</b> $c</p><p><b>Design:</b> $d</p><p><b>Easy of use:</b> $e</p>";
$eMessage = cleanString($eMessage);
if(@mail("jusbbmpins@gmail.com", $sub, $eMessage, $headers)){
	echo "Feedback successfully sent...";
}
else{
	echo "Error sending feedback, try again later...";
}

function cleanString($str)
{	
	$str = trim($str);
	$str = stripcslashes($str);
	$str = strip_tags($str,"<b>,<p>");
	return $str;
}
?>