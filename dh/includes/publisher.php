<div id="products">
    <div class="bg">
        <h2>Publisher-Developer</h2>
<?php echo $msg;?>
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
</form>
<form name="f" action="" method="post">
<table width="100%">
  <tr>
    <th>Name<font class="required">*</font></th> 
    <td>
    	<input type="text" name="name" size="50" value="<?php echo $name;?>" />
        <input type="hidden" name="ceo_url_name" value="<?php echo $ceo_url_name;?>" />
    </td>
  </tr>
  <tr>
    <th>Category<font class="required">*</font></th>
    <td>
    	<input type="text" name="category" size="50" value="<?php echo $xml_category;?>" />
        <input type="hidden" name="ceo_url_category" value="<?php echo $ceo_url_category;?>" />
    </td>
  </tr> 
  <tr>
    <th>Program Category Class</th>
    <td>
		<input type="text" name="program_category_class" size="50" value="<?php echo $program_category_class;?>" /> 
		<input type="hidden" name="ceo_url_program_category_class" value="<?php echo $ceo_url_program_category_class;?>" />
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
    <th>OS<font class="required">*</font></th> 
    <td><input type="text" name="os" size="50" value="<?php echo $os;?>" /> </td>
  </tr>
    <tr>
    <th>Program Type<font class="required">*</font></th> 
    <td><input type="text" name="program_type" size="20" value="<?php echo $program_type;?>"  /> <small>eg Freeware|Shareware</small></td>
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
    <th valign="top">Summary<font class="required">*</font></th> 
    <td><textarea name="summary" style="width:100%; height:120px;"><?php echo cleanString($summary);?></textarea></td>
  </tr>
  <tr> 
    <th valign="top">Description<font class="required">*</font></th>
    <td>
    <textarea name="description" style="width:100%; height:120px;"><?php echo cleanString($description);?></textarea>
	</td>
  </tr>
  <tr>
    <th width="30px" nowrap="nowrap" valign="top">System Requirements<font class="required">*</font></th> 
    <td><textarea name="system_requirements" style="width:100%; height:120px;"><?php echo cleanString($system_requirements); ?></textarea></td>
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
    <td colspan="2" class="btnCell"><input type="submit" name="xmlsubmit" value="Submit..." /></td>
  </tr>
</table>
</form>

		<p>&nbsp;</p>
    </div>
</div>