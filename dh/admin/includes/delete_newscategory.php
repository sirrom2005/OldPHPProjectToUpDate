<?php
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/commonDB.class.php");
	
	$comObj = new commonDB();
	
	$id 	= $_GET['id'];
	
	if( $comObj->deleteData( "odb_categories", "id", $id ))
	{
		echo "<script> location='../index.php?action=newscategory'; </script>";
		echo "<meta http-equiv='refresh' content='0;../index.php?action=newscategory' />";
		$comObj->logAdminActions("DELETE NEWS CATEGORY [$id]");
	}
?>