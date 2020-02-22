<?
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/events.class.php");
	include_once("../../classes/functions.php");

	$eventsObj = new events();
	
	$file 	= base64_decode($_GET['file']);
	$id 	= $_GET['id'];
	
	if( $eventsObj->deleteEventImage( $file, $id ) )
	{
		echo "<script> location='../index.php?action=add_events&id=$id'; </script>";
		echo "<meta http-equiv='refresh' content='0;../index.php?action=add_events&id=$id' />";
	}
?>