<?php
	include_once("../classes/software.class.php");
		
	$id			= $_GET['id'];
	$obj 		= new software();
	
	$tableName  = "odb_product_item";
		
	if($_POST['xmlsubmit'])
	{
		$rs 				= $_POST;
		$name				= trim($rs['name'] );
		$category			= trim($rs['category']);
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
		
		if(empty($name)           ){ unset($_POST); echo "<div class='err'>Name is required.</div>";}
		if(empty($category)       ){ unset($_POST); echo "<div class='err'>Category is required.</div>";}
		if(empty($publisher)      ){ unset($_POST); echo "<div class='err'>Publisher is required.</div>";}
		if(empty($publisher_email)){ unset($_POST); echo "<div class='err'>Publisher email is required.</div>";}
		if(empty($os)             ){ unset($_POST); echo "<div class='err'>OS is required.</div>";}
		if(empty($file_size)      ){ unset($_POST); echo "<div class='err'>File size is required.</div>";}
		if(empty($release_date)   ){ unset($_POST); echo "<div class='err'>Release date is required.</div>";}
		if(empty($summary_80)     ){ unset($_POST); echo "<div class='err'>Summary title is required.</div>";} 
		if(empty($summary)        ){ unset($_POST); echo "<div class='err'>Summary is required.</div>";}
		if(empty($description)    ){ unset($_POST); echo "<div class='err'>Description is required.</div>";}
		if(empty($system_requirements)){ unset($_POST); echo "<div class='err'>System requirements is required.</div>";}
		if(empty($download_url)   ){ unset($_POST); echo "<div class='err'>Download url is required.</div>";}
		if(empty($screenshot_url) ){ unset($_POST); echo "<div class='err'>Screenshot url is required.</div>";}
		if(empty($publisher_url)  ){ unset($_POST); echo "<div class='err'>Publisher url is required.</div>";}
		if(empty($application_icon_url)){ unset($_POST); echo "<div class='err'>Application icon url is required.</div>";}
	}

	if($_POST['xmlsubmit'])
	{ 
		$_POST['ceo_url_program_category_class'] = ceo_url_string($category);
		$_POST['ceo_url_name']					 = ceo_url_string($name);
	
		$_POST['enable']	= (empty($rs['enable'])  )? "0" : "1";
		$_POST['featured']	= (empty($rs['featured']))? "0" : "1";
		unset($_POST['xmlsubmit']);
	
		if(empty($id))
		{
			$_POST['date_added'] = date("Y-m-d");
			if( $obj->isPad($rs['xml_file_url']) )
			{
				echo "<font color='red'><b>This is already in the system.</b></font>";
			}
			else
			{
				if($comObj->insertRecord( $_POST, $tableName ))
				{
					include_once("update_rss.php");		
					$comObj->logAdminActions("ADD SOFTWARE [$full_name]");
					echo "<script> location='index.php?action=list_items'; </script>";
					echo "<meta http-equiv='refresh' content='0;index.php?action=list_items' />";
				}
			}
		}
		else
		{
			if($comObj->updateRecord( $_POST, $tableName, $id ))
			{
				include_once("update_rss.php");
				$comObj->logAdminActions("UPDATE SOFTWARE [$full_name]");
				echo "<script> location='index.php?action=list_items'; </script>";
				echo "<meta http-equiv='refresh' content='0;index.php?action=list_items' />";
			}
		}
	}
	
	// Includes
	include_once("pad/padfile.php");
	// Read input
	$URL = @$_POST["URL"];
	if ( $URL == "" ) $URL = "http://";
	// Create PAD file object
	$PAD = new PADFile($URL);

	if(isset($_POST['fill'])) 
	{
		$PAD->Load();
		$name							= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Name");
		$category						= $PAD->XML->GetValue("XML_DIZ_INFO/Program_Info/Program_Specific_Category"); 
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
		$id = NULL;
	}
	
	if(!empty($id))
	{
		$rs 		= $comObj->getDataById( $tableName, $id );
		$PAD->URL	= $rs['xml_file_url'];
		$name							= $rs['name'];
		$ceo_url_name 					= $rs['ceo_url_name'];
		$category						= $rs['category'];
		$ceo_url_category   			= $rs['ceo_url_category'];
		$program_category_class 		= $rs['program_category_class'];
		$ceo_url_program_category_class = $rs['ceo_url_program_category_class'];
		$publisher 						= $rs['publisher'];
		$publisher_email 				= $rs['publisher_email'];
		$os								= $rs['os'];
		$program_type 					= $rs['program_type'];
		$program_version 				= $rs['program_version']; 
		$release_status  				= $rs['release_status'];
		$install_support  				= $rs['install_support'];
		$file_size						= $rs['file_size'];
		$price 							= $rs['price'];
		$release_date 					= $rs['release_date'];
		$keywords 						= $rs['keywords'];
		$summary_80 					= $rs['summary_80'];
		$summary 						= $rs['summary'];
		$description 					= $rs['description'];
		$system_requirements 			= $rs['system_requirements'];
		$download_url 					= $rs['download_url'];
		$buy_url 						= $rs['buy_url'];
		$screenshot_url 				= $rs['screenshot_url'];
		$publisher_url 					= $rs['publisher_url'];
		$application_icon_url 			= $rs['application_icon_url'];
		$xml_file_url 					= $rs['xml_file_url'];
		$regnow 						= $rs['regnow'];
		$shareit 						= $rs['shareit'];
		$plimus 						= $rs['plimus'];
	}
		
	$btnTitle 		= (empty($id))? "Add" : "Update";
	$frmTitle		= (empty($id))? "Add" : "Edit";
	//$btnTitle 	= (empty($id))? "Add" : "Update";
	//$category 	= $obj->getCategory(NULL, 13);
?>
<form name="loadpad" action="#prefill" method="post" enctype="multipart/form-data">
<fieldset><legend>Enter pad url to load form</legend>
<table>
  <tr>
    <th nowrap="nowrap">Pad File</th> 
    <td>
		<input type='text' name='URL' size='60' value='<?php echo $PAD->URL; ?>'>
		<input type='submit' value='Download XML Information!' name="fill">
		<?php
		  // If the form above has been posted, load the PAD file from the entered URL
		  if ( $URL != "http://" )
		  {
			echo "Loading <i>" . $PAD->URL . "</i> ... ";
			switch ( $PAD->LastError )
			{
			  case ERR_NO_ERROR:
				echo "<font color='green'>OK</font>\n";
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
		
		  // Now, we prefill every form field with the data from the PAD file - if available
		  // For program descriptions, we will use the GetBestDescription() method that will
		  // extract the description text from the PAD file that fits best to the given
		  // length and language.
		
		?>
	</td>
  </tr>
</table>
</fieldset>
<br />
</form>
<form name="f" action="" method="post">
<table>
  <tr><th colspan="2" class="header"><?php echo $frmTitle;?> Software</th></tr>
  <tr>
    <th>Name<font class="required">*</font></th> 
    <td><input type="text" name="name" size="50" value="<?php echo $name;?>" /></td>
  </tr>
  <!--tr>
    <th>CEO URL Name</th> 
    <td><input type="text" name="ceo_url_name" size="50" value="<?php echo $ceo_url_name;?>" /></td>
  </tr-->
  <tr>
    <th>Category<font class="required">*</font></th>
    <td><input type="text" name="category" size="50" value="<?php echo $category;?>" /></td>
  </tr> 
  <tr>
    <th>CEO URL Category</th>
    <td><input type="text" name="ceo_url_category" size="50" value="<?php echo $ceo_url_category;?>" /></td>
  </tr>
  <tr>
    <th>Program Category Class</th>
    <td>
		<input type="text" name="program_category_class" size="50" value="<?php echo $program_category_class;?>" /> 
	</td>
  </tr>
  <tr> 
    <th>Publisher<font class="required">*</font></th> 
    <td><input type="text" name="publisher" size="50" value="<?php echo $publisher;?>" /></td> 
  </tr>
  <tr>
    <th>Publisher Email<font class="required">*</font></th> 
    <td><input type="text" name="publisher_email" size="50" value="<?php echo $publisher_email;?>" /> </td>
  </tr>
  <tr>
    <th>os<font class="required">*</font></th> 
    <td><input type="text" name="os" size="50" value="<?php echo $os;?>" /> </td>
  </tr>
    <tr>
    <th>Program Type<font class="required">*</font></th> 
    <td><input type="text" name="program_type" size="20" value="<?php echo $program_type;?>"  /><small>eg Freeware|Shareware</small></td>
  </tr>
  <tr>
    <th>Program Version</th> 
    <td><input type="text" name="program_version" size="50" value="<?php echo $program_version;?>"  /></td>
  </tr>
  <tr>
    <th>Release Status</th> 
    <td><input type="text" name="release_status" size="50" value="<?php echo $release_status;?>"  /></td>
  </tr>
  <tr>
    <th>Install support</th> 
    <td><input type="text" name="install_support" size="50" value="<?php echo $install_support;?>" /> </td>
  </tr>
  <tr>
    <th>File Size (MB)<font class="required">*</font></th>  
    <td><input type="text" name="file_size" size="50" value="<?php echo $file_size;?>" /></td>
  </tr>
  <tr>
    <th>Price ($)</th> 
    <td><input type="text" name="price" size="8" value="<?php echo $price;?>" /> </td>
  </tr>
  <tr>
    <th>Release Date<font class="required">*</font></th> 
    <td><input type="text" name="release_date" size="8" value="<?php echo $release_date;?>" /></td>
  </tr>
  <tr>
    <th>Keywords</th> 
    <td><input type="text" name="keywords" size="50" value="<?php echo $keywords;?>" /></td>
  </tr>
  <tr>
    <th>Summary Title<font class="required">*</font></th> 
    <td><input type="text" name="summary_80" size="50" maxlength="80" value="<?php echo cleanString($summary_80);?>" /></td>
  </tr>
  <tr>
    <th>Summary<font class="required">*</font></th> 
    <td><textarea name="summary" ><?php echo cleanString($summary);?></textarea></td>
  </tr>
  <tr> 
    <th>Description<font class="required">*</font></th>
    <td>
    <textarea name="description" ><?php echo cleanString($description);?></textarea>
	</td>
  </tr>
  <tr>
    <th>System Requirements<font class="required">*</font></th> 
    <td><textarea name="system_requirements" ><?php echo cleanString($system_requirements); ?></textarea></td>
  </tr>
  <tr>
    <th>Download Url<font class="required">*</font></th> 
    <td><input type="text" name="download_url" size="50" value="<?php echo $download_url;?>" /></td>
  </tr>
  <tr>
    <th>Buy Url</th> 
    <td><input type="text" name="buy_url" size="50" value="<?php echo $buy_url;?>" /></td>
  </tr>
  <tr>
    <th>Screenshot Url<font class="required">*</font></th> 
    <td><input type="text" name="screenshot_url" size="50" value="<?php echo $screenshot_url;?>" /></td>
  </tr>
  <tr>
    <th>Publisher Url<font class="required">*</font></th> 
    <td><input type="text" name="publisher_url" size="50" value="<?php echo $publisher_url;?>" /></td>
  </tr>
  <tr>
    <th>Application Icon Url<font class="required">*</font></th> 
    <td><input type="text" name="application_icon_url" size="50" value="<?php echo $application_icon_url;?>" /></td>
  </tr>
  <tr>
    <th>XML File Url</th> 
    <td><input type="text" name="xml_file_url" size="50" value="<?php echo $xml_file_url;?>" /></td>
  </tr>
  <tr>
    <th><a href="http://www.regnow.com/" target="_blank">Regnow</a></th>  
    <td><input type="text" name="regnow" size="12" value="<?php echo $regnow;?>" /></td>
  </tr>
  <tr>
    <th><a href="http://www.shareit.com/" target="_blank">Share-it</a></th> 
    <td><input type="text" name="shareit" size="12" value="<?php echo $shareit;?>" /></td>
  </tr>
  <tr>
    <th><a href="http://home.plimus.com/" target="_blank">Plimus</a></th> 
    <td><input type="text" name="plimus" size="12" value="<?php echo $plimus;?>" /></td>
  </tr>
  <tr>
    <th>Featured</th>
    <td style="background-color:#FF0000;"><input type="checkbox" name="featured" value="1" <?php echo empty($rs['featured'])? "" : "checked";?> /></td>
  </tr>
  <tr>
    <th>Enable</th>
    <td style="background-color:#FF0000;"><input type="checkbox" name="enable" value="1" <?php echo empty($rs['enable'])? "" : "checked";?> /></td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" name="xmlsubmit" value="<?php echo $btnTitle;?>..." /></td>
  </tr>
</table>
</form>