<?php 
$id = $_GET['id'];
$rs = $obj->getMessage($id);
$userId = $_SESSION['BBPINWORLD']['id'];
$msg = $message = "";
if($_POST){
	$pt = $_POST;
	$data['subject'] = $subject = $pt['subject'];
	$data['message'] = $message = cleanString($pt['message']);
	$data['sender_id'] = $_SESSION['BBPINWORLD']['id'];
	$data['receiver_id'] = $rs['account_id'];
	$data['date_added']  = date("Y-m-d H:i:s");
	$valid = true;
	
	if(empty($subject)){ $msg .= "<li>Subject is required.</li>"; $valid = false; }
	if(empty($message)){ $msg .= "<li>Message is required.</li>"; $valid = false; }
	
	if($valid)
	{
		include_once(DOCROOT."classes/commonDB.class.php");
		$commObj = new commonDB();
		$e = $obj->getProfileInfo($rs['account_id']);
		
		$data['subject'] = "RE: ".$data['subject'];
		$data['message'] = "<li>{$data['message']}<p><small><span class='right'>".date($locale['date.long'], strtotime($data['date_added']))."</span>".$_SESSION['BBPINWORLD']['fname'].' '.$_SESSION['BBPINWORLD']['lname']."</small></p><hr></li>".$rs['message'];
		
		if($commObj->insertRecord($data,'messages')){
			$headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
			$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$subject = "New Message";
			$message = "<p>".$_SESSION['BBPINWORLD']['fname'].' '.$_SESSION['BBPINWORLD']['lname']." has sent you a new private message to view this or any other message click <a href='".DOMAIN."messages.html'>here</a>.</p>";
			@mail($e['email'], $subject, $message, $headers);
			echo "<div class='boxStyle1'><span class='good'>Message sent...</span></div>";
			return;
		}
	}
	else{
		$msg = "<div class='boxStyle1'><span class='error'>$msg</span></div>";
	}
	
}
?>
<div class="boxStyle1">
    <h2><?php echo $locale['menu.messages'];?></h2>
    <h3><?php echo $rs['subject'];?></h3>
    <div id="userMessage"><?php echo str_replace("\r\n", '<br>', $rs['message']);?></div>
</div> 
<?php
	if($userId != $rs['account_id']){
		echo $msg;
		if(empty($rs['is_read'])){
			include_once(DOCROOT."classes/commonDB.class.php");
			$com = new commonDB();
			$isRead['is_read'] = 1;
			$com->updateRecord($isRead,'messages',$id);
		}
?> 
        <div class="boxStyle1">
            <form name="coomentfrm" id="comentfrm" method="post" action="">
                <h3>Reply to message</h3>
                <input type="hidden" name="subject" value="<?php echo $rs['subject'];?>" />
                <input type="hidden" name="account_id" value="<?php echo $rs['account_id'];?>" />
                <textarea name="message" id="message"><?php echo $message;?></textarea></p>
                <p align="right"><input type="submit" id="sendcomment" class="button" value="Send message..." /></p>
            </form>
        </div>
<?php } ?>
   