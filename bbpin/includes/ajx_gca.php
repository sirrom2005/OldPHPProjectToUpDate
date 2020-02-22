<?php
/*~~PROFILE COMMENT ADD~~*/
include_once("../config/config.php");
if(!isset($_SESSION['BBPINWORLD'])){return false;}
$con = mysql_connect(DBHOST,DBUSERNAME,DBPASSWORD);
mysql_select_db(DBDATABASE);
$s = $_SESSION['BBPINWORLD']['id'];
$g = $_GET['g'];
$txt = addslashes(cleanString($_GET['ti']));
$d = date('l, F d Y. h:i a');
$sql = "INSERT INTO group_comment (sender_id,group_id,`comment`,date_added) VALUES ($s,$g,\"$txt\",NOW())";
$rs  = mysql_query($sql);
/*$url = DOMAIN."profile_{$p}.html#com";
$headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
$subject = 'New profile comment added';
$message = "{$_SESSION['BBPINWORLD']['fname']} posted a comment on your profile click <a href='$url'>here</a> to view comment.";
@mail($e, $subject, $message, $headers);*/
$fname = $_SESSION['BBPINWORLD']['fname'];
$lname = (isset($_SESSION['BBPINWORLD']['lname']))? $_SESSION['BBPINWORLD']['lname'] : '';
echo "<li>".stripslashes($txt)."<hr /><small><a href='profile_{$s}.html'>$fname $lname</a> $d</small></li>";
function cleanString($str)
{	
	$str = trim($str);
	$str = stripslashes($str);
	$str = strip_tags($str);
	return $str;
}
?>