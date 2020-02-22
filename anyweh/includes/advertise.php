<?php
	include_once("config/global.php");	
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php" );
	include_once("classes/blog.class.php");
	include_once("classes/banner.class.php");
	
	$blogObj 	  = new blog();	
	$bannerObj 	  = new banner();
	$showFlashBanner = true;
	
	$err 	= NULL;
	$errStr = NULL;
	$rs 	= NULL;
	
	if($_POST)
	{
		$rs		 = $_POST;
		$name    = trim($_POST['name']); 
		$email   = trim($_POST['email']); 
		$tel     = trim($_POST['tel']); 
		$comment = $rs['comment'];
	
		if(empty($name))
		{
			$err .= "<div>Your fullname is required.</div>";
			unset($_POST);
		} 
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
		{
			$err = "<div>Invalid email address.</div>";
			unset($_POST); 
		}
		if(empty($comment))
		{
			$err .= "<div>Your comment is required.</div>";
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
		$subject = "Anyweh.com - Advertise With Us-Contact Us"; 
		$message = "NAME: $name<br>TEL: $tel<br><br>".$comment;
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= "From: $name ($email)\r\n";
		$header .= "Reply-To: $email\r\n";
		$header .= "TO: philglen25@yahoo.com\r\n";
		$header .= "BCC: sirrom2005@gmail.com\r\n";
		
		if(@mail(EMAIL_ADDRESS, $subject, $message, $header))
		{
			$errStr = "<div class='message'>Message sent...</div>";	
			unset($rs);
		}
	}
?>
<h1>Advertise With Us/Contact Us</h1>
<ol>
	<li class="nostyle"><h3>Home page and content pages</h3></li>
	<li>Large Rotating Banner Ads <strong>(836 x 295)</strong></li>
	<li>Rotating Banner Ads (Beside T.V.) <strong>(330 x 375)</strong></li>
	<li>Top banner (small) <strong>(468 x 60)</strong></li>
	<li>Leaderboard <strong>(728 x 90)</strong></li> 
	<li>Wide Skyscraper <strong>(160 x 600)</strong></li>
    <li>TV Ads</li>
	<li class="nostyle"><h3>Miscellaneous Ads</h3></li>
	<li>Floating Advertisement on home page <strong>(250 x 250)</strong></li>
	<li>We also offer advertisement on our welcome page, which can be customized to suit your needs (Disclaimer page.)</li>
 </ol>
 
 <p class="note">
	<a name="contact"></a>
	Contact our advertising department @
	<b>(876)-579-9583 or (876)-398-3620</b> or e-mail us at <strong><em>anywehdotcom@gmail.com</em></strong><br style="clear:left;" />
  For more information or use the form provided below to contact us. 
 </p>
<form name="f" method="post" class="forms" action="#contact">
	<?php echo $errStr?>
	<table>
		<tr><td colspan="2"><h1>Contact Us</h1></td></tr>
		<tr><td><label for="name">Full name <font class="erro">*</font></label></td><td><input type="text" name="name" id="name" class="input" value="<?=$rs['name']?>"  /></td></tr>
		<tr><td><label for="email">Email <font class="erro">*</font></label></td><td><input type="text" name="email" id="email" class="input" value="<?=$rs['email']?>" /></td></tr>
		<tr><td><label for="tel">Phone number</label></td><td><input type="text" name="tel" id="tel" class="input" value="<?=$rs['tel']?>"     /></td></tr>
		<tr><td valign="top"><label for="comment">Question/Query <font class="erro">*</font></label></td><td><textarea name="comment" id="comment"><?=$rs['comment']?></textarea></td></tr>
		<tr><td><img src="captcha/button.php" class="captcha" /></td><td> <input type="text" name="code" id="code" size="8" maxlength="8" /> <small>Enter characters code you see in the picture.</small></td></tr>
        <tr><td colspan="2"><input type="submit" value="Submit..." class="btn" /></td></tr>
	</table>
</form>