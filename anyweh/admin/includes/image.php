<?php
	include_once("../../config/config.php");
	include_once("../../classes/mySqlDB__.class.php");
	include_once("classes/banner.class.php");
	
	/*$bannerObj 	= new banner();
	$ads		= $bannerObj->getBanner($_GET['id']);
	$img 		= base64_decode($ads['banner']);
	$logo_type 	= $ads['banner_file_type'];*/
	
	
	$img 		= base64_decode($_GET['n']);
	$$logo_type = $_GET['t'];
	
	$img = imagecreatefromstring($img);
	
	header("Expires: Mon, 23 Jul 1993 05:00:00 GMT");
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	header("Cache-Control: no-store, no-cache, must-revalidate");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Content-type: $logo_type");
	
	if( $logo_type == "image/jpeg" ){ imagejpeg($img, NULL, 75); }
	if( $logo_type == "image/gif"  ){ imagegif($img); }
	if( $logo_type == "image/png"  ){ imagepng($img); }
	imagedestroy($img);
?>