<?php 
$userId = $_GET['id'];
$msg = $subject = $message = "";
$rs = $obj->getProfileInfo($userId);
$fullname = trim($rs['fname'].' '.$rs['lname']);
if($_POST)
{
	$rs 				= $_POST;
	$rs['email'] 		= $_POST['e'];
	$data['subject'] 	= $subject = cleanString($rs['subject']);
	$data['message'] 	= $message = cleanString($rs['message']);
	$data['sender_id']	= $_SESSION['BBPINWORLD']['id'];
	$data['receiver_id']= $userId;
	$data['date_added']	= date("Y-m-d H:i:s");
	$valid = true;
	
	if(empty($subject)){ $msg .= "<li>Subject is required.</li>"; $valid = false; }
	if(empty($message)){ $msg .= "<li>Message is required.</li>"; $valid = false; }
	
	if($valid)
	{
		include_once(DOCROOT."classes/commonDB.class.php");
		$commObj = new commonDB();
		
		$data['message'] = "<li>{$data['message']}<p><small><span class='right'>".date('l, F d Y.', strtotime($data['date_added']))."</span>".$_SESSION['BBPINWORLD']['fname'].' '.$_SESSION['BBPINWORLD']['lname']."</small></p><hr></li>";
		
		if($commObj->insertRecord($data,'messages')){
			$headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
			$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$subject = "New Message";
			$message = "<p>".$_SESSION['BBPINWORLD']['fname'].' '.$_SESSION['BBPINWORLD']['lname']." has sent you a new private message to view this or any other message click <a href='".DOMAIN."messages.html'>here</a>.</p>";
			$email = base64_decode($rs['e']);
			@mail($email, $subject, $message, $headers);
			echo "<span class='good'>Message sent<br>&laquo; back to $fullname <a href='profile_$userId.html'>(profile)</a></span>";
			return;
		}
	}
	else{ $msg = "<span class='error'>$msg</span>"; }
}
?>
<div class="boxStyle1">
	<?php echo $msg;?> 
    <h2 class="frmhdr">Send a message to <?php echo $fullname;?></h2>
    <form name="coomentfrm" class="frmStyle1" method="post" action="">
        <p><label for="subject">Subject</label><input type="text" name="subject" id="subject" class="textbox" value="<?php echo $subject;?>" /></p>
        <p><label for="message" style="display:block;">Message</label>
        <textarea name="message" id="message"><?php echo $message;?></textarea></p>
        <p align="right"><input type="submit" id="sendcomment" class="button" value="Send..." /></p>
        <input type="hidden" name="e" value="<?php echo base64_encode($rs['email']);?>" />
    </form>       
</div>