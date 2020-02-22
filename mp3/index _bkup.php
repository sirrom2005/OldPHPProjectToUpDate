<?php	
session_start();
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/commonDB.class.php");
include_once("classes/site.class.php");

$siteObj = new site();
$comObj = new commonDB();

$action = (empty($_GET['action']))? "home.php" : "{$_GET['action']}.php";
ob_start(); 
include_once("includes/$action");
$content = ob_get_contents();
ob_end_clean();
include_once("templates/main_layout.html");
?>