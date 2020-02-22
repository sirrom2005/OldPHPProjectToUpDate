<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	
	$obj = new software();
	
	$cat			= (!empty($_GET['cat']))? $_GET['cat'] : NULL;
	$latestNews 	= $obj->getLatestNews();
	$classNews 		= "selected";
	$page 			= "news_list.php";
	$pageTitle		= "&raquo; News ";
	
	include_once("page_tmp.php");
?>