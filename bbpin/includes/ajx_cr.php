<?php
/*~~PROFILE COMMENT REPLY~~*/
include_once("../config/config.php");
if(!isset($_SESSION['BBPINWORLD'])){return false;}
$con = mysql_connect(DBHOST,DBUSERNAME,DBPASSWORD);
mysql_select_db(DBDATABASE);
$cid = $_GET['cid'];
$id  = $_SESSION['BBPINWORLD']['id'];
$txt = addslashes(cleanString($_GET['ti']));
$d = date('l, F d Y. h:i a');
$sql = "INSERT INTO profile_comment (sender_id,profile_id,`comment`,date_added) VALUES ($id,$id,\"$txt\",NOW())";
if(mysql_query($sql)){
	$in = mysql_insert_id();
	$sql1 = "SELECT email FROM people p
			 INNER JOIN profile_comment c ON c.sender_id = p.id
			 WHERE c.id = '$cid'";
	$rs  = mysql_query($sql1);
	$data = mysql_fetch_assoc($rs);

	$url = DOMAIN."profile_{$id}.html#com".$in;
	$headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
	$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject = 'New profile comment added';
	$message = "{$_SESSION['BBPINWORLD']['fname']} replied to your comment, click <a href='$url'>here</a> to view.";
	@mail($data['email'], $subject, $message, $headers);
	$fname = $_SESSION['BBPINWORLD']['fname'];
	$lname = (isset($_SESSION['BBPINWORLD']['lname']))? $_SESSION['BBPINWORLD']['lname'] : '';
	echo "<li>".stripslashes($txt)."<hr /><small><a href='profile_{$id}.html'>$fname $lname</a> $d</small></li>";
}
function cleanString($str)
{	
	$str = trim($str);
	$str = stripslashes($str);
	$str = strip_tags($str);
	return $str;
}
@unlink("../cache/$lang/profile_{$_SESSION['BBPINWORLD']['id']}.html");
?>