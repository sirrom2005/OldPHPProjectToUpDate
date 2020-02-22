<?php
$groupid 			= $_GET['groupid'];
$email 				= base64_decode(base64_decode($_GET['ge']));//group user email address
$data['group_Id'] 	= $groupid; //the user who made the request
$data['account_id'] = $_SESSION['BBPINWORLD']['id']; //the user who made the request
$name 				= $_SESSION['BBPINWORLD']['fname'];

if($obj->insertGroupRequest($data)){
	$url = "index.php?action=profile&id={$data['account_id']}&gid=".base64_encode($groupid);
	$headers = "From: ".SITE_NAME."\r\n";
	$headers .= "Reply-To: no-reply@noreply.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject = "BBM Group request - ".SITE_NAME;
	$message = "<p>Hello,</p>
	<p>{$name} would like to be a part of you BBM group list,</p>
	<p>To view {$name}’s profile including BBM-Pin click <a href='$url'>here</a> or copy and paste the link below in your browser.</p>
	<p>$url</p>";
	
	if(isValidEmail($email)){			
		@mail($email, $subject, $message, $headers);
	}
}
else{
	//header("location: profile.html");
}
?>
<p class="good">Group request sent...</p>