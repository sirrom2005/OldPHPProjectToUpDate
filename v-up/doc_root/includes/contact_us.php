<?php
	$email 		= "";
	$name 		= "";
	$subject 	= ""; 
	$message 	= "";
	$pageTitle      = "Contact Us";
	if($_POST)
	{
		$email 		= trim($_POST['email']);
		$name 		= trim($_POST['name']);
		$subject 	= trim($_POST['subject']); 
		$message 	= trim($_POST['message']);
                $code           = $_POST['code'];//captcha code
                $captcha        = $_SESSION['CAP_CODE'];
		$err		= "";
		
		if(!@eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){/*$err .= "Email is required.<br>";*/ $reqEmail = "required"; unset($_POST);}
		if(empty($name)){ /*$err .= "Subject is required.<br>";*/ $reqName = "required"; unset($_POST);}
                if(empty($subject)){ /*$err .= "Subject is required.<br>";*/ $reqSubject = "required"; unset($_POST);}
		if(empty($message)){ /*$err .= "Message is required.<br>";*/ $reqMessage = "required"; unset($_POST);}
		
		if($code != $captcha)
		{ 
			//$err .= "Invalid image code...";
                        $reqCaptcha = "required";
			unset($_POST);
		}
                
		//if(!empty($err)){echo "<span class='err'>$err</span>";}
	}
	if(!empty($_POST))
	{
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= 'From: '.$name.' <'.$email.'>' . "\r\n";
		if(@mail("videouploaderdotnet@gmail.com", "Contact form videouploader.net :: $subject", $message, $header))
		{
			echo "<span class='msg'>Message sent...</span>";
			$email 		= "";
			$name		= "";
			$subject 	= ""; 
			$message 	= "";
		}
	}
	
	$pageKeywords	 	= "contact form, contact page";
	$pageDescription 	= "videouploader.net contact form, how to get in contact with video uploader";
?>
<form name="f" action="" method="post" class="formStyle1" >
    <h1>Contact Us</h1>
    <p><label for="email">Your email:</label><input class="text <?php echo @$reqEmail;?>" type="text" id="email" name="email" value="<?php echo $this->cleanString($email);?>" /></p>
    <p><label for="name">Your name:</label><input class="text <?php echo @$reqName;?>" type="text" id="name" name="name" value="<?php echo $this->cleanString($name);?>" /></p>
    <p><label for="subject">Subject:</label><input class="text <?php echo @$reqSubject;?>" type="text" id="subject" name="subject" value="<?php echo $this->cleanString($subject);?>" /></p>
    <p><label for="message">Message:</label><textarea id="message" name="message" cols="33" rows="7" class="<?php echo @$reqMessage;?>" ><?php echo $this->cleanString($message);?></textarea></p>
    <p style="width:260px;"><img style="float:right;" src="apps/captcha/button.php" border="1" alt="captcha code" /><small>Enter image code</small> <input type="text" name="code" size="8" maxlength="8" class="<?php echo @$reqCaptcha;?>" /> </p>
    <p align="center"><input type="submit" value="Send..." /></p>
</form> 