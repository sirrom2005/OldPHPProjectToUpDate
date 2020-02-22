<?php
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/commonDB.class.php");

	$comObj = new commonDB(); 
	
	$file 	= base64_decode($_GET['file']);
	$id 	= $_GET['id'];
	
	if( $comObj->deleteData("banner", "id", $id) )
	{
		unlink("../".$file);
		echo "<script> location='../index.php?action=list_ads'; </script>";
		echo "<meta http-equiv='refresh' content='0;../index.php?action=list_ads' />";
	}
?>