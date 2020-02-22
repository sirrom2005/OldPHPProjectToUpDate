<?php
session_start(); 
include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/site.class.php");
$siteObj = new site();
unset($_SESSION['CARTITEM'][(int)$_GET['id']]);
if(!empty($_SESSION['USER']))
{
	$siteObj->saveCartItems();
}
?>