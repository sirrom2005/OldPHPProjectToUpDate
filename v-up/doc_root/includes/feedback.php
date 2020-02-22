<?php 
	$err 		= "";
	$subject 	= "";  
	$feedback 	= "";
	if($_POST)
	{
		$subject 	= trim($_POST['subject']);
		$feedback	= trim($_POST['feedback']);
		
		if(empty($subject) ){$err .= "Please select an option.<br>"; $reqSubject = "required";}
		if(empty($feedback)){$err .= "Feedback is required.<br>"; $reqFeedback = "required";}
		if($_POST['code'] != $_SESSION['CAP_CODE']){ $err .= "Invalid code..."; $reqCaptcha = "required";}
		if(!empty($err)){ $err ="<span class='err'>$err</span>"; unset($_POST);}
	}
		
	if(!empty($_POST))
	{			
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$sub 	= "Feedback :: $subject";
		$msg 	= "$feedback";
			
		if(@mail("admin@videouploader.net", $sub, $msg, $header))
		{
			echo "<span class='msg'>Feedback form submited. Thank you for your feedback.</span>";
			$subject 	= "";
			$feedback	= "";
		}
	}

	$pageKeywords	 	= "feedback, experiences";
	$pageDescription 	= "Tell us about your experiences, give us your feedback in using videouploader.net";
?>
<?php //echo $err;?>
<h2>Tell us about your experience</h2>
<p>Send us your ideas, requests or comments about <a href="<?php echo DOMAIN;?>">videouploader.net</a></p>
<p>Your feedback will be used it to improve our site experience.<br />Please provide the details about your suggestion below.</p>
<p><b>Please do not provide any personal information such as names, phone numbers, or addresses.</b></p>

<form name="f" class="formStyle1" method="post" action="">
    <h1>Feedback</h1> 
    <p>
    	<label for="subject">Feedback section</label>
        <select name="subject" id="subject" class="text <?php echo @$reqSubject;?>">
        	<option value="">PLEASE SELECT AN OPTION</option>
        	<option value="General comment" <?php echo ($subject == "General comment")? "selected" : "";?> >General comment</option>
            <option value="Feedback on a feature" <?php echo ($subject == "Feedback on a feature")? "selected" : "";?>>Feedback on a feature</option>
            <option value="Suggest a feature" <?php echo ($subject == "Suggest a feature")? "selected" : "";?>>Suggest a feature</option>
            <option value="Report a bug" <?php echo ($subject == "Report a bug")? "selected" : "";?>>Report a bug</option>
            <option value="Didn't find what I was looking for" <?php echo ($subject == "Didn't find what I was looking for")? "selected" : "";?>>Didn't find what I was looking for</option>
        </select>
    </p>
    <p><label for="feedback">Please type your feedback here</label><textarea name="feedback" id="feedback" class="<?php echo @$reqFeedback;?>"><?php echo $this->cleanString($feedback);?></textarea></p>
    <p style="width:260px;"><img style="float:right;" src="apps/captcha/button.php" border="1" alt="captcha" /><small>Enter image code</small> <input type="text" name="code" size="8" maxlength="8" class="<?php echo @$reqCaptcha;?> /> </p>
    <p align="center"><input type="submit" value="Submit..." /></p>
</form>