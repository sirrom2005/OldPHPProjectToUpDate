<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	
	$obj = new software();
	
	if($_POST)
	{
		$name 			= trim($_POST['name']);
		$email 			= trim($_POST['email']);
		$paypal_email 	= trim($_POST['paypal_email']);
		$banner_code	= trim($_POST['banner_code']);
		$ads			= trim($_POST['ads']);
		
		if(empty($name)           ){$errName        = "<span class='err'>Fullname is required.</span>"; unset($_POST); }
		if(empty($paypal_email)   ){$errpaypal_email= "<span class='err'>PayPal email is required.</span>"; unset($_POST);  }
		if(empty($banner_code)    ){$errbanner_code = "<span class='err'>Banner code is required.</span>"; unset($_POST); }
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
		{
			$errEmail       = "<span class='err'>Invalid email address.</span>"; unset($_POST);
			unset($_POST); 
		}
	}
	
	if($_POST)
	{
		$_SESSION['advertising_order'] = $_POST;
		header("location:".DOMAIN."advertising_order_review.html");
	}
	
	$classAdvertising= "selected";
	$page 			= "advertising_order.php";
	$pageTitle		= "&raquo; Advertising Order";
	include_once("page_tmp.php");
?>