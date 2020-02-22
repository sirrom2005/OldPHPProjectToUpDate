<?
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/news.class.php");
	include_once("../../classes/functions.php");

	$newsObj = new news();
	
	$file 	= base64_decode($_GET['file']);
	$id 	= $_GET['id'];
	
	if( $newsObj->deleteNews( $id ) )
	{
		echo "<script> location='../index.php?action=list_news'; </script>";
		echo "<meta http-equiv='refresh' content='0;../index.php?action=list_news' />";
	}
?>