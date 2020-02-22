<?php
include_once("config/config.php");
include_once(DOCROOT."includes/languages/$lang.php");
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
$obj = new site();

if(isset($_SESSION['BBPINWORLD'])){
	$sesionStr = "<b>".$locale['hello']." {$_SESSION['BBPINWORLD']['fname']}!,</b> <a href='".DOMAIN."change-password.html'>".$locale['change.password']."</a> &bull; <a href='logout.php'>".$locale['logout']."</a>"; 
}else{
	$sesionStr = "<a href='".DOMAIN."login.php'>".$locale['login']."</a>";
}

$img 	= $_GET['img'];
$userId = $_GET['id'];
$rs 	= $obj->getProfileInfo($userId);
$proImg = $obj->getProfilePhotos($userId);
$fullname = trim($rs['fname'].' '.$rs['lname']);
$loggedInUser = isset($_SESSION['BBPINWORLD']['id']) ? $_SESSION['BBPINWORLD']['id'] : NULL;
$imgLoc = 'images/profile/'.$userId.'/';

$err 	= '';
if($_POST){
	if(!isset($_SESSION['BBPINWORLD'])){ header('location: index.php'); exit();}
	$message = cleanString(trim($_POST['message']));
	if(empty($message)){
		$err = "<span class='error'>Photo comment empty</span>";
	}else{
		if($obj->addPhotoComment($_SESSION['BBPINWORLD']['id'],$userId,$img,$message)){
			$url = DOMAIN."profile-photo-$userId-$img.html#com";
			$headers = "From: ".SITE_NAME." <".SITE_EMAIL.">\r\n";
			$headers .= "Reply-To: ".SITE_EMAIL."\r\n";
			$headers .= "MIME-Version: 1.0\r\n";
			$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			$subject = 'Photo comment added';
			$message = "{$_SESSION['BBPINWORLD']['fname']} posted a photo comment on your profile click <a href='$url'>here</a> to view comment.";
			@mail($rs['email'], $subject, $message, $headers);
		}
	}
}

$comments = $obj->getProfilePhotoComments($userId,$img);
?>
<!DOCTYPE html>
<html dir="<?php echo $locale['lang.dir'];?>" lang="<?php echo $locale['php.locale'];?>"> 
<head>  
<meta name="language" content="<?php echo $locale['lang'];?>" />
<meta name="title" content="<?php echo strtolower($fullname);?> photo gallery on jusbbmpins.com">
<meta name="description" content="view <?php echo strtolower($fullname);?> photo gallery on JusBBmPins.com">
<meta name="keywords" content="<?php echo strtolower($fullname);?>,photo,gallery,picture,jusbbmpins,jusbbmpin,blackberry,messenger,bbm,pinshare,connect,facebook,twitter,groups,black,berry,pin,request">
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $locale['content.type'];?>" />
<link rel="icon" type="image/png" href="images/bbm_icon.png" />
<title>JusBBmPins.com :: <?php echo strtolower($fullname);?> photo gallery</title>
<link href="styles/layout1.1.css" rel="stylesheet" type="text/css">
<link href="styles/profile.css" rel="stylesheet" type="text/css">
<!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css" href="styles/IE6.css" />
<![endif]-->
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-5039d3134bebc572"></script>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-31035193-4']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body>
<div id="header">
	<div>
    	<span id="topLink">
			<a href="<?php echo DOMAIN;?>index.php" title="<?php echo $locale['goto.home'];?>" class="logo"></a>
			<?php echo $sesionStr;?>
        </span>
        <div id="menu">           
            <li class="mhome" style="border-left:solid 1px #FFFFFF;"><a title="<?php echo $locale['goto.home'];?>" href="<?php echo DOMAIN;?>"><?php echo $locale['menu.home'];?></a></li>
            <li class="mfindpins"><a title="<?php echo strtolower($locale['menu.find.people']);?>" href="<?php echo DOMAIN;?>find-bbm-contact.html"><?php echo $locale['menu.find.people'];?></a></li>
            <li><a title="<?php echo strtolower($locale['menu.find.groups']);?>" href="<?php echo DOMAIN;?>find-bbm-groups.html"><?php echo $locale['menu.find.groups'];?></a></li>
            <li><a title="<?php echo strtolower($locale['menu.messages']);?>" href="<?php echo DOMAIN;?>messages.html" class="<?php echo (isset($_SESSION['BBPINWORLD']['newMessage']) && $_SESSION['BBPINWORLD']['newMessage']=='yes')? 'highlight' : '' ;?>" ><?php echo $locale['menu.messages'];?></a></li>
            <li><a title="<?php echo strtolower($locale['menu.pin.request']);?>" href="<?php echo DOMAIN;?>pin-request.html"><?php echo $locale['menu.pin.request'];?></a></li>
            <li><a title="<?php echo strtolower($locale['menu.my.profile']);?>" href="<?php echo DOMAIN;?>profile.html"><?php echo $locale['menu.my.profile'];?></a></li>
        </div>
    </div>
</div>
<div id="container">
    <div id="infobar" class="boxStyle1">
        <!-- AddThis Button BEGIN -->
        <div class="addthis_toolbox addthis_default_style ">
        <a class="addthis_button_facebook_like"></a>
        <a class="addthis_button_tweet"></a>
        </div>
        <!-- AddThis Button END -->
		<script type="text/javascript"><!--
        google_ad_client = "ca-pub-9222115009045453";
        /* 250x250_ads */
        google_ad_slot = "7923102952";
        google_ad_width = 250;
        google_ad_height = 250;
        //-->
        </script>
        <script type="text/javascript"
        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
	</div>
    <div id="content"><?php include_once('includes/profile-photo.php'); ?></div>
	<?php include_once('includes/footer.php'); ?>
</div>
<?php echo "<style>.$lang{background-color:#aecdff; color:#000;}</style>"; ?>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script language="javascript">
function removePost(id){
	if(confirm('You are about to delete this photo comment')){
		$.get("includes/ajx_pcd.php",{i:id},
		function(data){
				$('#cmm' + id).remove();
			}
		);
	}
} 
</script>
<!-- To my beloved rose [@}~%~~~] missing you like crazy, love you always xoxo wether your near or far, beside me or not 2012/08/08 -->
</body>
</html>
