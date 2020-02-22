<?php	
session_start();
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/site.class.php");

$siteObj = new site();
$row = $siteObj->searchMP3(NULL, "mp3.date_added DESC",20);
if(!isset($_SESSION['CARTITEM'])){$_SESSION['CARTITEM'] = array();}
$count = count($row);
$loop  = ceil($count/4);
include_once("templates/home_tpl.html");
?>