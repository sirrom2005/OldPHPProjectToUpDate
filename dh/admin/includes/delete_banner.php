<?php
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/commonDB.class.php");
	
	$comObj = new commonDB();
	
	$id 	= $_GET['id'];
	
	if( $comObj->deleteData( "od_banner_ads", "id", $id ))
	{
		echo "<script> location='../index.php?action=list_banners';</script>";
		echo "<meta http-equiv='refresh' content='0;../index.php?action=list_banners' />";
		$comObj->logAdminActions("DELETE BANNER [$id]");
	}
?>