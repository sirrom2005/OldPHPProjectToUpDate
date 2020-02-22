<?
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/news.class.php");
	include_once("../../classes/functions.php");

	$newsObj = new news();
	
	$file 	= base64_decode($_GET['file']);
	$id 	= $_GET['id'];
	
	if( $newsObj->deleteNewsImage( $file, $id ) )
	{
		header("location: ../index.php?action=add_news&id=$id ");
	}
?>