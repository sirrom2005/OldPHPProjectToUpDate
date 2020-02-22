<?php	
session_start();
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/commonDB.class.php");
include_once("classes/site.class.php");

$siteObj = new site();
$comObj = new commonDB();

if(isset($_GET['action']))
{
	$action = (file_exists("includes/{$_GET['action']}.php"))? "{$_GET['action']}.php" : "home.php";
}
else
{
	$action = "home.php";
}

if(!isset($_SESSION['CARTITEM'])){$_SESSION['CARTITEM'] = array();}

ob_start(); 
include_once("includes/$action");
$content = ob_get_contents();
ob_end_clean();
include_once("templates/page_layout.html");
?>