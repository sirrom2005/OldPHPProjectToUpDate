<?php 
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/commonDB.class.php");
	
	$comObj 	= new commonDB();
	
	$apsData['product_id'] 	= $_GET['id'];
	$apsData['ip_address'] 	= $_SERVER['REMOTE_ADDR'];
	$apsData['date_viewed']	= date("Y-m-d G:i:s");
	if($comObj->insertRecord( $apsData, "odb_product_downloads" ))
	{
		header( "location: ".base64_decode($_GET['file'])."" );
	}
?>