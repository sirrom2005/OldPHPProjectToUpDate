<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/pagination.class.php");
	
	$obj = new software();
		
	$contentPage 	= $obj->getContentPage("banner_payment_canceled");
	$page 			= "content_page.php";
	$pageTitle		= "&raquo; Banner Payment Canceled";
	include_once("page_tmp.php");
?>