<?php
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/site.class.php");
$siteObj = new site();
 
$file = base64_decode($_GET['f']);
$id = base64_decode($_GET['i']);
$siteObj->addDownloadCount($id);
// set the header values
header("Content-Type: application/force-download\n");
header("Content-Disposition: attachment; filename=$file");
//set the value of the fields in Opened dailog box
header("Content-Disposition: attachment; filename=$file");
// echo the content to the client browser
readfile("mp3store/$file");
?>