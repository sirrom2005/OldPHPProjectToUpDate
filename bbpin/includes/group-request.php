<?php
$groupid 			= $_GET['groupid'];
$email 				= base64_decode(base64_decode($_GET['ge']));//group user email address
$data['group_Id'] 	= $groupid;
$data['account_id'] = $_SESSION['BBPINWORLD']['id']; //the user who made the request
$name 				= $_SESSION['BBPINWORLD']['fname'];

if($obj->insertGroupRequest($data)){
	$url = DOMAIN."profile_{$data['account_id']}.html";
	$headers = "From: ".SITE_NAME." <no-reply@no-reply.com>\r\n";
	$headers .= "Reply-To: no-reply@noreply.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject = "BBM Group request - ".SITE_NAME;
	$message = "<p>Hello,</p>
	<p>{$name} would like to be a part of you BBM group list,</p>
	<p>To view {$name}’s profile click <a href='$url'>here</a> to view all request click <a href='".DOMAIN."pin-request.html'>here</a>.</p>";
	
	if(isValidEmail($email)){			
		@mail($email, $subject, $message, $headers);
	}
}
?>
<div class="boxStyle1">
<p class="good">Group request sent...</p>
</div>