<?
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/commonDB.class.php");
	
	$comObj = new commonDB();

	$id = $_GET['id'];
	
	if( $comObj->deleteData( "admin_users", "id", $id ) )
	{
		header("location: ../index.php?action=list_users");
	}
?>