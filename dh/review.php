<?php		
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/pagination.class.php");
	include_once("classes/commonDB.class.php");
	
	$obj 		= new software();
	$comObj 	= new commonDB();
		
	$name 		= $_GET['name'];
	$cat		= $_GET['cat'];
	$result 	= $obj->getSoftware($name, $cat);
	$downloads	= $obj->getDownloadCount($result['id']);
	$viewCount	= $obj->getViewCount($result['id']); 
	$latest 	= $obj->getLatestSoftware(10);
	$popular 	= $obj->getPopularDownload(10);
	$pubList 	= $obj->getSoftwareForPublisher($result['app_developer']);
	$comments	= $obj->getProductReviews($result['id'], 1);
	$errName	= "Name";
	$errEmail	= "Email";	
	
	$downloadcount 	=(empty($downloads['downloadcount']))? 1 : (int)$downloads['downloadcount'];
	$viewcount 		=(empty($viewCount['viewcount'])    )? 1 : (int)$viewCount['viewcount'];
	
	if($downloadcount > $viewcount)
	{
		$popularity = floor(($viewcount/$downloadcount)*100);
	}
	else
	{
		$popularity = floor(($downloadcount/$viewcount)*100);
	}
	
	$barWidth = floor(105*($popularity/100));
	if( $barWidth > 100){$barWidth=100;}
	
	if($_POST['rating'])
	{
		$_POST['product_id'] = $result['id'];
		$comObj->insertRecord( $_POST, "odb_product_rate" );
		unset($_POST);
	}
	
	$rate		= $obj->getProductRating($result['id']);
	$sum 		= $rate['sum'];
	$count 		= $rate['count'];
	$downloadMenuList = true;
		
	if( empty($sum)   ){ $sum = 0;   }
	if( empty($count) ){ $count = 1; }
	$rating = ($sum/$count)/5;
	$rating = round($rating * 120);
		
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
		$_POST['item_id'] 		= $result['id'];
		$_POST['section'] 		= 1; 
		$_POST['notify_email'] 	= (empty($_POST['notify_email']))? "0" : "1"; 
		
		if($_POST['remember']==1)
		{
			setcookie("cook_name" , "{$_POST['name']}" , time()*3600*365, "/");
			setcookie("cook_email", "{$_POST['email']}", time()*3600*365, "/");
		} 
			
		unset($_POST['code']);
		unset($_POST['remember']); 
		 
		if($comObj->insertRecord($_POST, "odb_product_review"))
		{
			$subject = "DownloadHours.com software review submited.";
			$message = "New software review submited, please login in the CMS to verify and enable review.";
			$msg	 = "<li class='msg'>Software review added, and will be moderated.</li>";
			@mail(EMAIL_ADDRESS, $subject, $message);
			unset($rs);
		}
	}
	
	if(isset($_COOKIE['cook_name']) ){$rs['name']  = $_COOKIE['cook_name'];  } 
	if(isset($_COOKIE['cook_email'])){$rs['email'] = $_COOKIE['cook_email']; }
	
	$META_DESC = $result['summary_80'];
	$META_KEY  = $result['keywords'];

	$classSoftware	= "selected";
	$page 			= "review.php";
	$pageTitle		= "&raquo; Software &raquo; {$result[category]} &raquo; {$result[title]}";
	
	if(empty($_COOKIE['thisUser']))
	{
		$apsData['product_id'] 	= $result['id'];
		$apsData['ip_address'] 	= $_SERVER['REMOTE_ADDR'];
		$apsData['date_viewed']	= date("Y-m-d G:i:s");
		$comObj->insertRecord( $apsData, "odb_product_view" );
		setcookie("thisUser", "{$result['id']}", time()+3600*24*7);
	}
		
	include_once("page_tmp.php");
?>