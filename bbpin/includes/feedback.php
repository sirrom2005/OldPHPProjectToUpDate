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
		if(@mail("jusbbmpins@gmail.com",SITE_NAME.' Feedback '.$subject,$feedback)){
			echo '<span class="good">Feedback submitted. Thank you...<a href="index.php">continue</a></span>';
			return;
		}
	}
	else{ $msg = "<span class='error'>$msg</span>"; }
}
?>
<h1>Tell us about your experience</h1>
<div class="contentText">
    <p>Send us your ideas, requests or comments about <a href="<?php echo DOMAIN;?>"><?php echo SITE_NAME;?></a></p>
    <p>Your feedback will be used it to improve our site experience.<br />Please provide the details about your suggestion below.</p>
    <p>Please do not provide any personal information such as names, phone numbers, or addresses.</p>
    <form name="f" class="frmStyle" id="frmStyle" method="post" action="">
        <h2>Feedback</h2>
        <?php echo $msg;?>
        <ul class="ulFrmStyle">
        <li>
            <label class="lbl" for="subject">Feedback Option</label>
            <select name="subject" id="subject" class="textbox">
                <option value="">Please select an option</option>
                <option value="General comment" >General comment</option>
                <option value="Feedback on a feature">Feedback on a feature</option>
                <option value="Suggest a feature">Suggest a feature</option>
                <option value="Report a bug">Report a bug</option>
                <option value="Didn't find what I was looking for">Didn't find what I was looking for</option>
            </select>
        </li>
        <li>
            <label class="lbl" for="feedback">Feedback\Suggestion</label><br>
            <textarea name="feedback" id="feedback"><?php echo cleanText($feedback); ?></textarea>
        </li>
        <li><input type="submit" id="btn" class="button" value="Submit" /></li>
        </ul>
    </form>
</div>