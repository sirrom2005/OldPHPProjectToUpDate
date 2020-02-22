<?php	
	if(empty($obj))
	{
		include_once("../classes/software.class.php");
		$obj = new software();
	}
	
	include_once("pad/padfile.php");
	
	$URL = empty($_POST['xml'])? NULL : $_POST['xml'];
	if ( $URL == "" ) $URL = "http://";
	// Create PAD file object
	$PAD = new PADFile($URL);
	// If the form above has been posted, load the PAD file from the entered URL
	if ( $URL != "http://" )
	{
		echo "Loading <i>".$PAD->URL."</i> ... ";
		$PAD->Load();
		switch ( $PAD->LastError )
		{
			case ERR_NO_ERROR:
				insertInfo();
			break;
			case ERR_NO_URL_SPECIFIED:
				echo "<br><font color='red'>No URL specified.</font>";
			break;
			case ERR_READ_FROM_URL_FAILED:
				echo "<br><font color='red'>Cannot open URL.";
			if ($PADFile->LastErrorMsg != "")
				echo " (" . $PADFile->LastErrorMsg . ")";
				echo "</font>";
			break;
			case ERR_PARSE_ERROR:
				echo "<br><font color='red'>Parse Error: " . $PAD->ParseError . "</font>";
			break;
		}
	}
	
	function insertInfo()
  	{
		global $data, $comObj,$obj,$PAD;
		$data['category'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Specific_Category");
		$data['ceo_url_category'] = ceo_url_string($data['category']);
		$data['program_category_class'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Category_Class");
		$data['ceo_url_program_category_class'] = url_string_encode_for_category_class($data['program_category_class']);;
		$data['name'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Name");
		$data['ceo_url_name'] = ceo_url_string($data['name']);
		$data['publisher'] = $PAD->XML->GetValue("XML_DIZ_INFO/Company_Info/Company_Name");
		$data['os'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_OS_Support");
		$data['program_type'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Type/Program_Type"); 
		$data['program_version'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Version");
		$data['release_status'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Status");
		$data['install_support'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Install_Support");
		$data['file_size'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/File_Info/File_Size_MB");
		$data['price'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Cost_Dollars");
		$data['release_date'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Year")."-".$PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Month")."-".$PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Release_Day");
		$data['summary_80'] = cleanString($PAD->GetBestDescription(80, "English"));
		$data['summary'] = cleanString($PAD->GetBestDescription(250, "English"));
		$data['description'] = cleanString($PAD->GetBestDescription(2000, "English"));
		$data['system_requirements'] = $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_System_Requirements");
		$data['download_url'] = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Download_URLs/Primary_Download_URL");
		$data['buy_url'] = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Order_URL");
		$data['screenshot_url'] = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Screenshot_URL");
		$data['publisher_url'] = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Company_Info/Company_WebSite_URL");
		$data['application_icon_url'] = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Icon_URL");
		$data['xml_file_url'] = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_XML_File_URL");
		$data['application_icon_url'] = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Icon_URL");
		$data['application_icon_url'] = $PAD->XML->GetValue("XML_DIZ_INFO/Web_Info/Application_URLs/Application_Icon_URL");
		$data['date_added'] = date("Y-m-d");
		$data['enable']	= "1";	

		if( $obj->isPad($PAD->URL) )
		{ 
			echo "<font color='red'><b>This is already in the system.</b></font>"; 
		}
		else
		{
			$rs = $comObj->insertRecord( $data, "odb_product_item"); 
		}
		
		if($rs)
		{
			echo "<b>OK!! Information added.</b>";
			if( $_SESSION['account_user'])
			{
				$subject 	= "DownloadHoures.com - software subited";
				$message 	= "New software submitted [{$data['name']}].<br>Please login to the CMS to review.";
				$header  	= 'MIME-Version: 1.0' . "\r\n";
				$header 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
				$header 	.= "From: downloadhours-admin no-reply@downloadhours.com\r\n";
	
				@mail(EMAIL_ADDRESS, $subject, $message, $header);
			}
		}
  	}
?>
<form method="post" name="f" action="">
<b>Enter Pad file url</b> <input type="text" name="xml" size="45" /> <input type="submit" value="Submit" />
</form>