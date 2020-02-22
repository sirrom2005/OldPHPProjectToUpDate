<?php
$pageOpen=true;
$name = $email = $tel = $subject = $message = $msg = "";
if($_POST){
    $rs   	= $_POST;
	$name   = cleanText($rs['name']);
	$email  = cleanText($rs['email']);
	$tel 	= cleanText($rs['tel']);
	$subject= cleanText($rs['subject']);
	$message= cleanText($rs['message']);
	$valid	= true;    
	        
	if(empty($name)         ){ $msg .= '<li>Name is required.</li>'; $valid = false;}
	if(!isValidEmail($email)){ $msg .= '<li>Valid email address is required.</li>'; $valid = false;}
	if(empty($message)      ){ $msg .= '<li>Message/Query is required.</li>'; $valid = false;}
		
	if($valid)
	{ 
		$headers = "From: \"$name\" <$email>\r\n";
		$headers .= "Reply-To: $email\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		$sub      = 'Contact form :: '.SITE_NAME;
		$eMessage = "<p><b>Name: </b>$name</p>
					 <p><b>Email: </b>$email</p>
					 <p><b>Tel: </b>$tel</p>
					 <p><b>Subject: </b>$subject</p>
					 <p>$message</p>";
		if(@mail("jusbbmpins@gmail.com", $sub, $eMessage, $headers)){
			echo "<span class='good'>Message successfully sent...</span>";
			return;
		}
	}
	else{
    	$msg = "<span class='error'>$msg</span><br>";
	}
}
?>
<h1>Contact Us</h1>
<div class="contentText">
    <p>Submit any queries or comment you have using this form.</p>
    <?php echo $msg;?>
    <form name="frm" id="frm" class="frmStyle1" method="post" action=""> 
    <ul class="ulFrmStyle">
        <li><label class="lbl" for="name">Your Name <font style="color:#FF0000;">*</font></label><input type="text" name="name" id="name" value="<?php echo $name;?>" class="textbox" /></li>
        <li><label class="lbl" for="email">Your Email <font style="color:#FF0000;">*</font></label><input type="text" name="email" id="email" value="<?php echo $email;?>" class="textbox" /></li>
        <li><label class="lbl" for="tel">Contact #</label><input type="text" name="tel" id="tel" value="<?php echo $tel;?>" class="textbox"/></li>
        <li><label class="lbl" for="subject">Subject</label><input type="text" name="subject" id="subject" value="<?php echo $subject;?>" class="textbox" /></li>
        <li><label class="lbl" for="message">Message/Query<font style="color:#FF0000;">*</font></label><br><textarea cols="50" rows="8" name="message" id="message"><?php echo $message;?></textarea></li>
        <li><input type="submit" class="button" id="btn" value="Send"></li>
    </ul>    
    </form>
</div>