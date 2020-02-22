<?php
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/commonDB.class.php");
	
	$comObj 	= new commonDB();
	$obj 		= new software();
	
	$cat			= $_GET['cat'];
	$id				= $_GET['id']; 
	$result			= $obj->getNews($cat, $id);
	$comments		= $obj->getProductReviews($id, 2);
	$classNews 		= "selected";
	$page 			= "read_news.php";
	$pageTitle		= "&raquo; News ";
	$errName		= "Name";
	$errEmail		= "Email";
	
	if($_POST)
	{
		$rs 		= $_POST;
		$name 		= trim($_POST['name']   );
		$email 		= trim($_POST['email']  );
	 	$comment	= trim($_POST['comment']); 
		
		if(empty($name)    ){ $errName    = "<font class='err'>&laquo; Name is required.</font>"; unset($_POST); }
		if(empty($comment) ){ $errComment = "<font class='err'>Comment is required.</font>"; unset($_POST); }
		if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)) 
		{
			$errEmail = "<font class='err'>&laquo; Invalid email address.</font>";
			unset($_POST); 
		}
		if($rs['code'] != $_SESSION['CAP_CODE']){ $errCode = "<font class='err'>Invalid code.</font>"; unset($_POST); }
	}

	if($_POST)
	{
		$_POST['date_added'] 	= date("Y-m-d");
		$_POST['item_id'] 		= $id;
		$_POST['section'] 		= 2; 
		$_POST['notify_email'] 	= (empty($_POST['notify_email']))? "0" : "1"; 
		
		if($_POST['remember']==1)
		{
			setcookie("news_cook_name" , "{$_POST['name']}" , time()*3600*365, "/");
			setcookie("news_cook_email", "{$_POST['email']}", time()*3600*365, "/");
		} 
			
		unset($_POST['code']);
		unset($_POST['remember']); 
		 
		if($comObj->insertRecord($_POST, "odb_product_review"))
		{
			$subject = "DownloadHours.com software review submited.";
			$message = "New news review submited, please login in the CMS to verify and enable review.";
			$msg	 = "<li class='msg'>News review added, and will be moderated.</li>";
			@mail(EMAIL_ADDRESS, $subject, $message);
			unset($rs);
		}
	}

	if(isset($_COOKIE['news_cook_name']) ){$rs['name']  = $_COOKIE['news_cook_name'];  } 
	if(isset($_COOKIE['news_cook_email'])){$rs['email'] = $_COOKIE['news_cook_email']; }
	
	if(!empty($cat))
	{
		$pageTitle	.= "&raquo; {$rs[cat_name]} &raquo; {$rs[title]}";
	}

	include_once("page_tmp.php");
?>