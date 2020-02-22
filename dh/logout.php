<?php 
	include_once("config/config.php");
	session_start(); 
	unset($_SESSION['account_user']); 
	header("location:".DOMAIN); 
?>