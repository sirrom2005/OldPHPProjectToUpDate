<?php 
session_start();
if(empty($_SESSION['USER']['id']))
{
	exit("<span class='fberr'>You must first <a href='control/'>login</a> to make purchase.</span>");
}

include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/site.class.php");

$siteObj = new site();
$id = $_GET['id'];
$siteObj->buyMp3($id);
?>