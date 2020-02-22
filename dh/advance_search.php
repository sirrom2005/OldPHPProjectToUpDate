<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	
	$obj = new software();
	
	$page 			= "advance_search.php";
	$pageTitle		= "&raquo; Advance Search";
	include_once("page_tmp.php");
?>