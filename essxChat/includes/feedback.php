<?php
$subject = $feedback = $msg = "";
if($_POST)
{
	$rs = $_POST;
	$subject  = $rs['subject'];
	$feedback = $rs['feedback'];
	$valid = true;
	
	if(empty($subject))
	{
		$msg .= '<li>Please select a section from the dropdown list.</li>';
		$valid = false;
	}

	if(empty($feedback))
	{
		$msg .= '<li>feedback canot be empty.</li>';
		$valid = false;
	}

	if($valid){
		if(@mail(SITE_EMAIL,'Feedback '.$subject,$feedback)){
			
		}
		echo '<span class="good">Feedback submitted. Thank you...</span>';
		return;
	}
	else{ $msg = "<span class='error'>$msg</span>"; }
}
?>
<h2>Tell us about your experience</h2>
<p>Send us your ideas, requests or comments about <a href="<?php echo DOMAIN;?>"><?php echo SITE_NAME;?></a></p>
<p>Your feedback will be used it to improve our site experience.<br />Please provide the details about your suggestion below.</p>
<p>Please do not provide any personal information such as names, phone numbers, or addresses.</p>
<form name="f" class="frmStyle" id="frmStyle" method="post" action="">
    <h2>Feedback</h2>
    <?php echo $msg;?>
    <p>
        <label for="subject">Feedback Option</label>
        <select name="subject" id="subject" class="textbox">
            <option value="">Please select an option</option>
            <option value="General comment" >General comment</option>
            <option value="Feedback on a feature">Feedback on a feature</option>
            <option value="Suggest a feature">Suggest a feature</option>
            <option value="Report a bug">Report a bug</option>
            <option value="Didn't find what I was looking for">Didn't find what I was looking for</option>
        </select>
    </p>
    <p>
        <label for="feedback">Feedback\Suggestion</label><br>
        <textarea name="feedback" id="feedback"><?php echo cleanText($feedback); ?></textarea>
    </p>
    <p align="center"><input type="submit" id="btn" value="Submit" /></p>
    <p id="winMsgStr">&nbsp;</p>
</form>