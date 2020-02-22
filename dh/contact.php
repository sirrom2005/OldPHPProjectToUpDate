<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	
	$obj = new software();
	
	$contentPage 	= $obj->getContentPage("contact_us");
	$classContact 	= "selected";
	$page 			= "content_page.php";
	$pageTitle		= "&raquo; Contact us";
	$name 			= NULL;
	$email 			= NULL;
	$comment		= NULL;
	$mess 			= NULL;
	$errName		= NULL;
	$errEmail		= NULL;
	$errComment		= NULL;
		
	if($_POST)
	{
		$name 		= trim($_POST['name']);
		$email 		= trim($_POST['email']);
		$comment	= trim($_POST['comment']);
		
		if(empty($name)    ){ $errName    = "<span class='err'>Name is required.</span>"; unset($_POST); }
		if(empty($comment) ){ $errComment = "<span class='err'>Comment is required.</span>"; unset($_POST); }
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
		{
			$errEmail = "<span class='err'>Invalid email address.</span>";
			unset($_POST); 
		}
	}
	
	if(!empty($_POST))
	{
		$subject = "DownloadHours.com - Contact form"; 
		$message = "NAME: $name<br>EMAIL: $email<br><br>$comment";
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= "From: downloadhours-admin no-reply@downloadhours.com\r\n";
		
		if(@mail(EMAIL_ADDRESS, $subject, $message, $header))
		{
			$mess = "<div class='msg'>Message sent...</div><meta http-equiv='refresh' content='4;index.html' />";	
			$name 		= "";
			$email 		= "";
			$comment	= "";
		}
	}
	
	$str ="<form name='f' action='' method='post'>
			$mess
			<ul class=\"table\">
				<li class=\"title\">Full Name</li><li><input type=\"text\" name=\"name\" value=\"$name\" class='inputbox' />$errName</li>
				<li class=\"title\">Email</li><li><input type=\"text\" name=\"email\" value=\"$email\" class='inputbox' />$errEmail</li>
				<li class=\"title\">Comments/Query</li><li><textarea name=\"comment\">$comment</textarea> $errComment</li>
				<li class=\"title\"></li><li><input type=\"submit\" value=\"Submit\" /><p>&nbsp;</p></li>
  			</ul>
		  </form>";
	
	$contentPage['detail'] = $str.$contentPage['detail'];
	
	include_once("page_tmp.php");
?>