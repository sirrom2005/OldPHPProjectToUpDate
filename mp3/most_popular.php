<?php	
session_start();
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/site.class.php");

$siteObj = new site();
$new 			= $siteObj->searchMP3(NULL, "mp3.date_added DESC",20);
$topDownload 	= $siteObj->searchMP3(NULL, "mp3.date_added ASC",20);
$trends			= $siteObj->searchMP3(NULL, "mp3.date_added DESC",20);
if(!isset($_SESSION['CARTITEM'])){$_SESSION['CARTITEM'] = array();}
ob_start(); 
$content = ob_get_contents();
ob_end_clean(); 
include_once("templates/featured_layout.html");
?>