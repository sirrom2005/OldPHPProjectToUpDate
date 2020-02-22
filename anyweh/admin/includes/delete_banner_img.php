<?
	include_once( "../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("../../classes/banner.class.php");
	include_once("../../classes/functions.php");

	$bannerObj = new banner();
	
	$file 	= base64_decode($_GET['file']);
	$type 	= $_GET['type'];
	$id 	= $_GET['id'];
	
	if( $bannerObj->deleteBannerImage( $file, $id ) )
	{
		echo "<script> location='../index.php?action=add_banner&type=$type&id=$id'; </script>";
		echo "<meta http-equiv='refresh' content='0;../index.php?action=add_banner&type=$type&id=$id' />";
	}
?>