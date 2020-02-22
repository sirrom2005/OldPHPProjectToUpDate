<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	
	$obj = new software();
	
	$contentPage 	= $obj->getContentPage("terms_and_conditions");
	$page 			= "content_page.php";
	$pageTitle		= "&raquo; Terms and Conditions";
	include_once("page_tmp.php");
?>