<?php
	session_start();
	if( empty($_SESSION['account_user']['account_type']) ){ header("location: index.html"); }
	
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/pagination.class.php");
	include_once("classes/user.class.php");
	include_once("classes/commonDB.class.php");
	
	$obj 		= new software();
	$userObj 	= new user();
	$comObj		= new commonDB();
	$_GET['id'] = $_SESSION['account_user']['id'];
		
	$pageTitle		= "&raquo; Change Password";
	$page 			= "change_password.php";
	include_once("page_tmp.php");
?>