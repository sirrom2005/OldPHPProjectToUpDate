<?
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/events.class.php");
	include_once("../../classes/functions.php");

	$eventsObj = new events();
	
	$file 	= base64_decode($_GET['file']);
	$id 	= $_GET['id'];
	
	if( $eventsObj->deleteEvents( $id, $file ) )
	{
		echo "<script> location='../index.php?action=list_events'; </script>";
		echo "<meta http-equiv='refresh' content='0;../index.php?action=list_events' />";
	}
?>