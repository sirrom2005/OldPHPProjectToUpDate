<?php	
session_start();
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/site.class.php");

$siteObj = new site();
$current = "new";
$newReleases = $siteObj->searchMP3(NULL, "mp3.date_added DESC",12);
$topDownload = $siteObj->searchMP3(NULL, "mp3.downloaded DESC",12);
$trending 	= $siteObj->searchMP3(NULL, "mp3.riddim_id DESC",12);
 
include_once("templates/featred_tpl.html");
?>