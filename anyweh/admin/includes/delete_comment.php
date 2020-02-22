<?
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/banner.class.php");
	include_once("../../classes/functions.php");

	$bannerObj = new banner();
	
	$file 	= base64_decode($_GET['file']);
	$id 	= $_GET['id'];
	
	if( $bannerObj->deleteComment( $id ) )
	{
		echo "<script> location='../index.php?action=list_comment'; </script>";
		echo "<meta http-equiv='refresh' content='0;../index.php?action=list_comment' />";
	}
?>