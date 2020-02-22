<?php
	include_once("../js/FCKeditor/fckeditor.php" );
	include_once("../classes/software.class.php");
	
	$obj 		= new software();
	$tableName  = "odb_news";
	$err		= NULL;	
		
	if($_POST)
	{
		$rs 			= $_POST;
		$title			= trim($rs['title']);
		$detail			= trim($rs['detail']);	
		$_POST['enable']= (empty($rs['enable']))? "0" : "1";
		
		if(empty($title) ){ $err  = "<div class='err'>Subject is required.</div>"; unset($_POST);}
		if(empty($detail)){ $err .= "<div class='err'>Message is required.</div>"; unset($_POST);}
	}
	
	if($_POST)
	{
		//$_POST['date_added'] = date("Y-m-d g:i:s");
		$results = $obj->getEmailList();
		$emails = "";
		foreach($results as $row)
		{
			$emails .= $row['email'].", ";
		}
		
		$subject = $title; 
		$message = $detail;
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$header .= "From: downloadhours-admin no-reply@downloadhours.com\r\n";
		$header .= "Bcc: $emails" . "\r\n";
		
		if(mail("users@downloadhours.com", $subject, $message, $header))
		{
			echo "<p align='center'><b>Message sent...</b></p>";
		}
		
	}
	if(empty($rs['title'])){ $rs['title'] = "Downloadhours newsletter";}
?>
<script type="text/javascript" src="scripts/wysiwyg.js"></script>
<script type="text/javascript" src="scripts/wysiwyg-settings.js"></script>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<?php echo $err;?>
<table>
  <tr><th colspan="2" class="header">News Letter</th></tr>
  <tr>
    <th>Subject<font class="required">*</font></th> 
    <td><input type="text" name="title" size="50" value="<?php echo cleanString($rs['title']);?>" /></td>
  </tr>
  <tr>
    <th>Message<font class="required">*</font></th>
    <td>
	<?php
	/*$sBasePath = "../js/FCKeditor/";
	$oFCKeditor = new FCKeditor('detail') ;
	$oFCKeditor->BasePath	= $sBasePath ;
	$oFCKeditor->PluginTest = 'Default';
	$oFCKeditor->ToolbarSet = 'Default';
	$oFCKeditor->Width 	    = '600';
	$oFCKeditor->Height 	= '400';
	$oFCKeditor->Value		= cleanHtml($rs['detail']);
	$oFCKeditor->Create() ;*/
	?> 
    <textarea id="textarea1" name="detail" style="width:50%;height:400px;"><?php echo $rs['detail'];?></textarea>
	</td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" value="Send..." /></td>
  </tr>
</table>
</form>
<script type="text/javascript">
	// Use it to attach the editor to all textareas with full featured setup
	//WYSIWYG.attach('all', full);
	
	// Use it to attach the editor directly to a defined textarea
	WYSIWYG.attach('textarea1', full); // default setup
	//WYSIWYG.attach('textarea2', full); // full featured setup
	//WYSIWYG.attach('textarea3', small); // small setup
	
	// Use it to display an iframes instead of a textareas
	//WYSIWYG.display('all', full);  
</script>