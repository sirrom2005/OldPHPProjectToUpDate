<?php     
	include_once("config/config.php");
	include_once("classes/mySqlDB__.class.php");
	include_once("classes/software.class.php");
	include_once("classes/pagination.class.php");
	include_once("classes/commonDB.class.php");
	
	if( empty($_SESSION['account_user']['account_type']) || $_SESSION['account_user']['account_type'] != 4 ){ header("location: index.html"); }
	
	$obj 			= new software();
	$comObj 		= new commonDB();
	$category 		= $obj->getCategory();
				
	if($_POST['xmlsubmit'])
	{
		$rs 				= $_POST;
		$name				= trim($rs['name'] );
		$xml_category		= trim($rs['category']);
		$publisher			= trim($rs['publisher']);
		$publisher_email	= trim($rs['publisher_email']);
		$os					= trim($rs['os']);
		$file_size			= trim($rs['file_size']);
		$release_date		= trim($rs['release_date']);
		$summary_80			= trim($rs['summary_80']);	 
		$summary			= trim($rs['summary']);	
		$description		= trim($rs['description']);	
		$system_requirements= trim($rs['system_requirements']);	
		$download_url		= trim($rs['download_url']);	
		$xml_file_url		= trim($rs['xml_file_url']);	
		$publisher_url 		= trim($rs['publisher_url']);	
		$application_icon_url = trim($rs['application_icon_url']);
		$screenshot_url 	= trim($rs['screenshot_url']);	
		$plimus 			= trim($rs['plimus']);
		$regnow 			= trim($rs['regnow']);
		$shareit 			= trim($rs['shareit']);

		$msg = "";
		if(empty($name)           ){ unset($_POST); $msg .= "<div class='err'>Name is required.</div>";}
		if(empty($xml_category)   ){ unset($_POST); $msg .= "<div class='err'>Category is required.</div>";}
		if(empty($publisher)      ){ unset($_POST); $msg .= "<div class='err'>Publisher is required.</div>";}
		if(empty($publisher_email)){ unset($_POST); $msg .= "<div class='err'>Publisher email is required.</div>";}
		if(empty($os)             ){ unset($_POST); $msg .= "<div class='err'>OS is required.</div>";}
		if(empty($file_size)      ){ unset($_POST); $msg .= "<div class='err'>File size is required.</div>";}
		if(empty($release_date)   ){ unset($_POST); $msg .= "<div class='err'>Release date is required.</div>";}
		if(empty($summary_80)     ){ unset($_POST); $msg .= "<div class='err'>Summary title is required.</div>";} 
		if(empty($summary)        ){ unset($_POST); $msg .= "<div class='err'>Summary is required.</div>";}
		if(empty($description)    ){ unset($_POST); $msg .= "<div class='err'>Description is required.</div>";}
		if(empty($system_requirements)){ unset($_POST); $msg .= "<div class='err'>System requirements is required.</div>";}
		if(empty($download_url)   ){ unset($_POST);$msg .= "<div class='err'>Download url is required.</div>";}
		if(empty($screenshot_url) ){ unset($_POST); $msg .= "<div class='err'>Screenshot url is required.</div>";}
		if(empty($publisher_url)  ){ unset($_POST); $msg .= "<div class='err'>Publisher url is required.</div>";}
		if(empty($application_icon_url)){ unset($_POST); $msg .= "<div class='err'>Application icon url is required.</div>";}
	}

	if($_POST['xmlsubmit'])
	{
		$_POST['enable']	= "0";
		$_POST['featured']	= "0";
		
		unset($_POST['xmlsubmit']);
	
		$_POST['date_added'] = date("Y-m-d");
		if( $obj->isPad($rs['xml_file_url']) )
		{
			$msg = "<div class='err'>This is already in our system.</div>";
		}
		else
		{
			if($comObj->insertRecord( $_POST, "odb_product_item" ))
			{ 
				$msg = "<h3>Software added for review. Thank you.<p>&nbsp;</p></h3>";
				
				if($rs)
				{
					$subject 	= "DownloadHoures.com - New software submited";
					$message 	= "New software submitted [$name].<br>Please login to the CMS to review.";
					$header  	= 'MIME-Version: 1.0' . "\r\n";
					$header 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
					$header 	.= "From: downloadhours-admin no-reply@downloadhours.com\r\n";
		
					@mail(EMAIL_ADDRESS, $subject, $message, $header);
				}
			}
		}
	}
	
	// Includes
	include_once("admin/pad/padfile.php");
	// Read input
	$URL = @$_POST["URL"];
	if ( $URL == "" ) $URL = "http://";
	// Create PAD file object
	$PAD = new PADFile($URL);
	
	if(isset($_POST['fill']))
	{
		$PAD->Load();
		$name							= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Name");
		$ceo_url_name 					= ceo_url_string($name);
		$xml_category					= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Specific_Category"); 
		$ceo_url_category   			= ceo_url_string($xml_category);
		$program_category_class 		= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Category_Class"); 
		$ceo_url_program_category_class = url_string_encode_for_category_class($program_category_class);
		$publisher 						= $PAD->XML->GetValue("XML_DIZ_INFO/Company_Info/Company_Name"); 
		$publisher_email 				= $PAD->XML->GetValue("XML_DIZ_INFO/Company_Info/Contact_Info/Author_Email");
		$os								= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_OS_Support");
		$program_type 					= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Type");
		$program_version 				= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Version"); 
		$release_status  				= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Status");
		$install_support  				= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Install_Support");
		$file_size						= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/File_Info/File_Size_MB");
		$price 							= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Cost_Dollars");
		$release_date 					= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Year")."-".$PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Month")."-".$PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Day");
		$keywords 						= preFixString($PAD->XML->GetValue("XML_DIZ_INFO/Program_Descriptions/English/Keywords"));
		$summary_80 					= preFixString($PAD->GetBestDescription(80, "English")); 
		$summary 						= $PAD->GetBestDescription(250, "English"); 
		$description 					= $PAD->GetBestDescription(2000, "English");
		$system_requirements 			= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_System_Requirements");
		$download_url 					= $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Download_URLs/Primary_Download_URL");
		$buy_url 						= $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Order_URL");
		$screenshot_url 				= $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Screenshot_URL");
		$publisher_url 					= $PAD->XML->GetValue("XML_DIZ_INFO/Company_Info/Company_WebSite_URL"); 
		$application_icon_url 			= $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Icon_URL");
		$xml_file_url 					= $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_XML_File_URL");
	}
		
	$classPublisher = "selected";
	$page 			= "publisher.php";
	$pageTitle		= "&raquo; Publisher\Developer";
		
	include_once("page_tmp.php");
?>