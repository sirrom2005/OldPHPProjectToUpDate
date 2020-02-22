<?php
	include_once("../classes/software.class.php");
	include_once("../js/FCKeditor/fckeditor.php" );
	
	$id			= $_GET['id'];
	$obj 		= new software();
	$tableName  = "odb_content";
		
	if($_POST)
	{
		$rs				= $_POST;
		
		$title			= trim($rs['title']);
		$detail			= trim($rs['detail']);	
		
		if(empty($title) ){ $err  = "<div class='err'>Title is required.</div>"; unset($_POST);}
		if(empty($detail)){ $err .= "<div class='err'>Content detail is required.</div>"; unset($_POST);}
	}
	
	if($_POST)
	{
		if(empty($id))
		{ $comObj->insertRecord( $_POST, $tableName );  $comObj->logAdminActions("ADD NEW PAGE [$title]");     }
		else
		{ $comObj->updateRecord( $_POST, $tableName, $id ); $comObj->logAdminActions("UPDATE PAGE [$title]"); }
		echo "<script> location='index.php?action=list_pages'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_pages' />";
	}
	
	if(!empty($id))
	{ $rs = $comObj->getDataById( $tableName, $id ); }
	
	$btnTitle 		= (empty($id))? "Add" : "Update";
	$frmTitle		= (empty($id))? "Add" : "Edit";
?>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<?php echo $err;?>
<table>
  <tr><th colspan="2" class="header"><?php echo $frmTitle;?> News</th></tr>
  <tr>
    <th>Title<font class="required">*</font></th> 
    <td><input type="text" name="title" size="50" value="<?php echo cleanString($rs['title']);?>" /></td>
  </tr>
  <tr>
    <th>Detail<font class="required">*</font></th>
    <td>
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
	</td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" value="<?php echo $btnTitle;?>..." /></td>
  </tr>
</table>
</form>