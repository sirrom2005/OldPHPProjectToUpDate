<?php
$id 				= $_GET['id'];
$email 				= base64_decode(base64_decode($_GET['ed']));
$data['account_id'] = $_SESSION['BBPINWORLD']['id']; //the user who made the request
$data['user_id'] 	= $id; //user who will get the email
$name 				= $_SESSION['BBPINWORLD']['fname'];

if($obj->insertPinRequest($data)){
	$url = "index.php?action=profile&id={$data['account_id']}&rd=".base64_encode($id);
	$headers = "From: ".SITE_NAME."\r\n";
	$headers .= "Reply-To: no-reply@noreply.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject = "BBM-Pin request - ".SITE_NAME;
	$message = "<p>Hello,</p>
	<p>{$name} would like to be a part of you BBM contact list,</p>
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
<p class="good">Pin request sent...</p>