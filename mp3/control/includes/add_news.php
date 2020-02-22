<?php
	include_once("../js/FCKeditor/fckeditor.php" );
	
	$id			= (isset($_GET['id']))? $_GET['id'] : 0;
	$err		= "";	
	$rs = array("title" => "", "detail"  => "");
		
	if($_POST)
	{
		$rs		= $_POST;
		$title	= trim($rs['title']);
		$detail	= trim($rs['detail']);		
				
		if(empty($title)  ){ $err  = "Title is required.<br>"; unset($_POST);}
		if(empty($detail) ){ $err .= "Content detail is required.<br>"; unset($_POST);}
		if(!empty($err)    ){echo "<span class='err'>$err</span>";}
	}
	
	if(!empty($_POST))
	{
		if(empty($id))
		{
			$rs['date_added'] = date("Y-m-d");
			$comObj->insertRecord($rs,"odb_news");
		}
		else
		{
			$comObj->updateRecord($rs,"odb_news",$id);
		} 
		header("location: index.php?action=list_news");
	}
	
	if(!empty($id))
	{
		$rs = $comObj->getDataById("odb_news",$id);
	}
	
	$btnTitle 	= (empty($id))? "Add" : "Update";
	$frmTitle	= (empty($id))? "Add" : "Edit";
?>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<h1><?php echo $frmTitle;?> news</h1>
<p><label for="title">Title<font class="required">*</font></label><input type="text" name="title" id="title" size="50" value="<?php echo cleanString($rs['title']);?>" /></p>
<p>
<?php
$sBasePath = "../js/FCKeditor/";
$oFCKeditor = new FCKeditor('detail') ;
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->PluginTest = 'Default';
$oFCKeditor->ToolbarSet = 'Default';
$oFCKeditor->Width 	    = '600';
$oFCKeditor->Height 	= '400';
$oFCKeditor->Value		= cleanHtml($rs['detail']);
$oFCKeditor->Create() ;
?> 
</p>
<p><input type="submit" value="<?php echo $btnTitle;?>..." /></p>
</form>