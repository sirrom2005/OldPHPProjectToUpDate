<?
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/commonDB.class.php");
	
	$comObj = new commonDB();
	
	$id 	= $_GET['id'];
	
	if( $comObj->deleteData( "odb_account", "id", $id ))
	{
		echo "<script> location='../index.php?action=list_users'; </script>";
		echo "<meta http-equiv='refresh' content='0;../index.php?action=list_users' />";
	}
?>