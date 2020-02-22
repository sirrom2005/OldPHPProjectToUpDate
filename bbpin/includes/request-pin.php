<?php
$id 				= $_GET['id'];
$email 				= base64_decode(base64_decode($_GET['ed']));
$data['account_id'] = $_SESSION['BBPINWORLD']['id']; //the user who made the request
$data['user_id'] 	= $id; //user who will get the email
$name 				= $_SESSION['BBPINWORLD']['fname'];
$msg				= "";

if($obj->insertPinRequest($data)){
	$profileUrl = DOMAIN."profile_{$data['account_id']}.html";
	$requestUrl = DOMAIN."pin-request.html";
	$headers = "From: ".SITE_NAME." <no-reply@no-reply.com>\r\n";
	$headers .= "Reply-To: no-reply@noreply.com\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$subject = "BBM-Pin request - ".SITE_NAME;
	$message = "<p>Hello,</p>
	<p>{$name} would like to be a part of you BBM contact list,</p>
	<p>To view {$name}’s profile click <a href='$profileUrl'>here</a>.</p>
	<p>To view the BBM-PINS of all your request click <a href='$requestUrl'>here</a>.</p>";
	
	if(isValidEmail($email)){			
		if(@mail($email, $subject, $message, $headers))
		{
			$msg = "<p class='good'>".$locale['pin.requ.sent']."</p>";
		}else{
			$msg = "<span class='error'><li>".$locale['pin.requ.error']."</li></span>";
		}
	}
}
else{
	$msg = "<p class='good'>".$locale['pin.requ.resent']."</p>";
}
?>
<?php echo $msg;?>