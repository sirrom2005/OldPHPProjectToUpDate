<?php
//if(!isset($_COOKIE["VIDEO_{$_GET['id']}"]))
//{
	//setcookie("VIDEO_{$_GET['id']}", true, time()+3600*24);
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php");
	include_once("../classes/site.class.php");
	$obj = new site();
	$obj->addVideoCount($_GET['id']);
//}
?>