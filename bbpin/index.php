<?php
/*if(isset($_SESSION['BBPINWORLD'])){
	$sesionStr = "<b>".$locale['hello']." {$_SESSION['BBPINWORLD']['fname']}!,</b> <a href='".DOMAIN."change-password.html'>".$locale['change.password']."</a> &bull; <a href='logout.php'>".$locale['logout']."</a>"; 
}else{
	$sesionStr = "<a href='".DOMAIN."login.php'>".$locale['login']."</a>";
}*/
include_once("config/config.php");
include_once("includes/languages/$lang.php");
include_once("classes/mySQlDB__.class.php");
include_once("classes/site.class.php");
$obj = new site();
$page = (isset($_GET['action']) && file_exists('includes/'.$_GET['action'].'.php'))? $_GET['action'].'.php' : 'home.php';
$pageTitle = SITE_NAME.' | The blackberry pin yellow page';
$pageDesc = "Find blackberry pin for your blackberry messenger, find blackberry groups/chat room and connect with users that share your similar interest, pin exchange with user around the world.";
$pageKeyWords = "blackberry,messenger,pin,exchange,bbm,swap,pinshare";
ob_start();
?>
<?php if($page!="profile.php" && $page!="group.php"){ ?>
<div class="right-bar">
	<script type="text/javascript"><!--
	google_ad_client = "ca-pub-9222115009045453";
	/* 300x600_media */
	google_ad_slot = "8099564237";
	google_ad_width = 300;
	google_ad_height = 600;
	//-->
	</script>
	<script type="text/javascript"
	src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
	</script>
</div>
<?php } ?>
<?php
	include_once("includes/$page");
	$pageContent=ob_get_contents();
	if(!isset($_SESSION['BBPINWORLD']) && $pageOpen!=true){
		ob_end_clean();
		ob_start();
		include_once("includes/logintxt.php");
		$pageContent=ob_get_contents();
	}
ob_end_clean();
$warnings = "";
if(isset($_SESSION['BBPINWORLD']['hasImage']) && empty($_SESSION['BBPINWORLD']['hasImage'])){ $warnings .= "<li>".$locale['pro.missing.photo']."</li>";}
if(isset($_SESSION['BBPINWORLD']['hasImage']) && empty($_SESSION['BBPINWORLD']['complete'])){ $warnings .= "<li>".$locale['pro.incomplete']."</li>";}

include_once("includes/HTML_LAYOUT_VER-2.php");
?>