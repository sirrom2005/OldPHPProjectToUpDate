<?php
include_once("../config/config.php");
include_once("../includes/languages/$lang.php");
include_once("../classes/mySQlDB__.class.php");
include_once("../classes/site.class.php");
$obj = new site();
$page = (isset($_GET['action']) && file_exists('../includes/'.$_GET['action'].'.php'))? $_GET['action'].'.php' : 'home.php';
$pageTitle = SITE_NAME.' - Mobile | The blackberry pin yellow page';
$pageDesc = "Find blackberry pin for your blackberry messenger, find blackberry groups/chat room and connect with users that share your similar interest, pin exchange with user around the world.";
$pageKeyWords = "blackberry,messenger,pin,exchange,bbm,swap,pinshare";
ob_start();
	include_once("../includes/$page");
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

include_once("../includes/HTML_MOBILE_LAYOUT_VER-2.php");
?>