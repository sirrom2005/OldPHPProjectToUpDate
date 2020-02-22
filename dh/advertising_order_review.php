<?php
	session_start();
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/commonDB.class.php");
	
	$obj = new software();
	$comObj = new commonDB();

	if($_GET['order']=="aprove")
	{
		$data['banner_type_id'] = $_SESSION['advertising_order']['ads'];
		$data['advertiser'] 	= $_SESSION['advertising_order']['name'];
		$data['website'] 		= $_SESSION['advertising_order']['website'];
		$data['email'] 			= $_SESSION['advertising_order']['email'];
		$data['paypal_email'] 	= $_SESSION['advertising_order']['paypal_email'];
		$data['banner_code'] 	= $_SESSION['advertising_order']['banner_code'];
		
		if($comObj->insertRecord( $data, "od_banner_ads" ))
		{
			$msg = "<div class='msg'>Banner purchased, banner will be place on site within 24 hours.</div>";
			
			$subject = "DownloadHours.com banner purchase made.";
			$message = "New banner purchase made, please login in the CMS to verify and enable banner ads.";
			@mail(EMAIL_ADDRESS, $subject, $message);
		}
	}
	else
	{
		$rs = $comObj->getDataById("odb_ads_type", $_SESSION['advertising_order']['ads']);
	}
	
	$classAdvertising= "selected";
	$page 			= "advertising_order_review.php";
	$pageTitle		= "&raquo; Advertising Order Review";
	include_once("page_tmp.php");
?>