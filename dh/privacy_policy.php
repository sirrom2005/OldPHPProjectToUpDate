<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	
	$obj = new software();
	
	$contentPage 	= $obj->getContentPage("privacy_policy");
	$page 			= "content_page.php";
	$pageTitle		= "&raquo; Privacy Policy";
	include_once("page_tmp.php");
?>