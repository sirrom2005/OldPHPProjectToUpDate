<?php
session_start();
include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/site.class.php");
$siteObj = new site();
if(empty($_SESSION['CARTITEM']))
{
	$_SESSION['CARTITEM'][$_GET['id']] = $_GET['id'];
}
else
{
	$_SESSION['CARTITEM'][$_GET['id']] = $_GET['id'];
	$_SESSION['CARTITEM'] = array_unique($_SESSION['CARTITEM']);
}
if(!empty($_SESSION['USER']))
{
	$siteObj->saveCartItems();
}
echo (count($_SESSION['CARTITEM'])<=1)? "(".count($_SESSION['CARTITEM']).")&nbsp;" : "(".count($_SESSION['CARTITEM']).")&nbsp;";
?>