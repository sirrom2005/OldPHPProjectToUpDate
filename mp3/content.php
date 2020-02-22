<?php	
session_start();
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/site.class.php");

$siteObj = new site();

if(!isset($_SESSION['CARTITEM'])){$_SESSION['CARTITEM'] = array();}

ob_start(); 
include_once("includes/content.php");
$content = ob_get_contents();
ob_end_clean();
include_once("templates/page_layout.html");
?>