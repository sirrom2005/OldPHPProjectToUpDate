<?php 
include_once("../config/config.php");
include_once("../classes/mySQlDB__.class.php");
include_once("../classes/site.class.php");
$obj = new site();

$list = $obj->getUserList();
$pageCount = 0;
ob_start();

foreach($list as $row){
	$lang = 'es';
	$_GET['id'] = $row['id'];
	include('../profile.php');
	$pageCount++;
}

$s = ob_get_contents();
ob_get_clean();
echo $pageCount.' pages';
?>