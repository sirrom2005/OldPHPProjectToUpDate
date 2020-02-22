<?php
	include_once("classes/commonDB.class.php");
	
	$comObj    = new commonDB();
	
	if($_POST)
	{ 
		$rs 			= $_POST;
		$promoter 		= trim($_POST['promoter']); 
		$promoter_email = trim($_POST['promoter_email']); 
		$date 			= trim($_POST['date']); 
		$time 			= trim($_POST['time']); 
		$title 			= trim($_POST['title']);
		$venue 			= trim($_POST['venue']);
		$description	= trim($_POST['description']);
		
		$err = "";
		if(empty($promoter))
		{
			$err .= "<div>Your name is required.</div>";
			unset($_POST);
		}
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $promoter_email)) 
		{
			$err .= "<div>Invalid email address.</div>";
			unset($_POST); 
		}
		if(empty($title))
		{
			$err .= "<div>Event name is required.</div>";
			unset($_POST);
		}
		if(empty($date))
		{
			$err .= "<div>Event date is required.</div>";
			unset($_POST);
		}
		if(empty($time))
		{
			$err .= "<div>Time is required.</div>";
			unset($_POST);
		}	
		if(empty($venue))
		{
			$err .= "<div>Venue is required.</div>";
			unset($_POST);
		}
		if($rs['code'] != $_SESSION['CAP_CODE'])
		{
			$err .= "<div>Invalid characters code.</div>";
			unset($_POST);
		}
		if(empty($_POST))
		{
			$errStr = "<span class='erro'>$err</span>";
		}
	}

	if($_POST)
	{		
		unset($_POST['code']);
		$_POST['date_added'] = date("Y-m-d");
		$_POST['free_post']  = 1; 
		if($comObj->insertRecord( $_POST, "events" ))
		{
			$subject = "Anyweh.com - New event posted"; 
			$message = "New event added for calendar, login into the Admin area to enable.";
			$header  = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= "From: $promoter ($promoter_email)\r\n";
			$header .= "Reply-To: $promoter_email\r\n";
			$header .= "TO: philglen25@yahoo.com\r\n";
			$header .= "BCC: sirrom2005@gmail.com\r\n";
			
			if(@mail(EMAIL_ADDRESS, $subject, $message, $header))
			{
				$errStr = "<div class='message'>Event added and will be reviewed by our adminrator within 24 hr...</div>";	
				unset($rs);
			}
		}
		//include_once("update_rss.php");
	}
	
	$rs['date'] = date("Y-m-d");
?>
<script language="javascript" type="text/javascript" src="js/calendar/cal2.js">
/*
Xin's Popup calendar script-  Xin Yang (http://www.yxscripts.com/)
Script featured on/available at http://www.dynamicdrive.com/
This notice must stay intact for use
*/
</script>
<script language="javascript" type="text/javascript" src="js/calendar/cal_conf2.js"></script>
<form name="f" action="" method="post" class="forms" enctype="multipart/form-data" >
	<?php echo $errStr?>
	<table>
	  <tr><td colspan="2"><h1>Post Your Upcoming Events For FREE</h1></td></tr>
	  <tr>
		<td><label for="promoter">Your Name <font class="erro">*</font></label></td>
		<td><input type="text" name="promoter" id="promoter" class="input" value="<?=cleanString($rs['promoter'])?>" /></td>
	  </tr>
	  <tr>
		<td><label for="promoter_email">Your Email <font class="erro">*</font></label></td>
		<td><input type="text" name="promoter_email" id="promoter_email" class="input" value="<?=cleanString($rs['promoter_email'])?>" /></td>
	  </tr>
	  <tr>
		<td><label for="title">Event Name <font class="erro">*</font></label></td>
		<td><input type="text" name="title" id="title" class="input" value="<?=cleanString($rs['title'])?>" /></td>
	  </tr>
	  <tr>
		<td><label for="date">Event Date <font class="erro">*</font></label></td>
		<td>
		<input type="text" name="date" id="date" value="<?=$rs['date']?>" size="8" />
		<a href="javascript:showCal('date')"><img src="images/calendar.jpg"  border="0"/></a><b>[yyyy-mm-dd]</b></td>
	  </tr>
      <tr>
		<td><label for="time">Event Time <font class="erro">*</font></label></td>
		<td>
		<input type="text" name="time" id="time" class="input" value="<?=$rs['time']?>" /></td>
	  </tr>
      <tr>
		<td><label for="admission">Admission</label></td>
		<td><input type="text" name="admission" id="admission" value="<?=cleanString($rs['admission'])?>" size="8" class="input" /></td>
	  </tr>
      <tr>
		<td><label for="venue">Venue <font class="erro">*</font></label></td>
		<td><input type="text" name="venue" id="venue" class="input" value="<?=cleanString($rs['venue'])?>" /></td>
	  </tr>
	  <tr>
		<td valign="top"><label for="description">Description</label></td>
		<td><textarea name="description" id="description"><?=cleanString($rs['description'])?></textarea></td>
	  </tr>
	  <tr><td><img src="captcha/button.php" class="captcha" /></td><td> <input type="text" name="code" id="code" size="8" maxlength="8" /> <small>Enter characters code you see in the picture.</small></td></tr>
	  <tr>
		<td colspan="2"><input type="submit" value="Submit..." /></td>
	  </tr>
	</table>
</form>