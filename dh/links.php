<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	
	$obj = new software();
	
	$contentPage 	= $obj->getContentPage("links");
	$classLinks 	= "selected";
	$page 			= "content_page.php";
	$pageTitle		= "&raquo; Links ";
	include_once("page_tmp.php");
?>