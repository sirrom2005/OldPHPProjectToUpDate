<?php
	include_once("../classes/user.class.php");
	include_once("../classes/software.class.php");
	include_once("../js/FCKeditor/fckeditor.php" );
	
	$id			= $_GET['id'];
	$userObj 	= new user();
	$obj 		= new software();
	$tableName  = "odb_product_review";
		
	if($_POST)
	{
		$rs 		= $_POST;
		$name		= trim($rs['name']);
		$comment	= trim($rs['comment']);	
		$_POST['enable']= (empty($rs['enable']))? "0" : "1";
		
		if(empty($name) ){ $err  = "<div class='err'>Name is required.</div>"; unset($_POST);}
		if(empty($comment)){ $err .= "<div class='err'>Comment is required.</div>"; unset($_POST);}
	}
	
	if($_POST)
	{
		$comObj->updateRecord( $_POST, $tableName, $id );
		$comObj->logAdminActions("UPDATE REVIEW [$id]");
		echo "<script> location='index.php?action=list_reviews'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_reviews' />";
	}
	
	if(!empty($id))
	{
		$rs = $comObj->getDataById( $tableName, $id );
	}
	
	$btnTitle 		= (empty($id))? "Add" : "Update";
	$frmTitle		= (empty($id))? "Add" : "Edit";
?>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<?php echo $err;?>
<table>
  <tr><th colspan="2" class="header"><?php echo $frmTitle;?> News</th></tr>
  <tr>
    <th>Name<font class="required">*</font></th> 
    <td><input type="text" name="name" size="50" value="<?php echo cleanString($rs['name']);?>" /></td>
  </tr>
  <tr>
    <th>Detail<font class="required">*</font></th>
    <td><textarea name="comment"><?php echo cleanString($rs['comment']);?></textarea>
	</td>
  </tr>
  <tr>
    <th>Enable</th>
    <td><input type="checkbox" name="enable" value="1" <?php echo empty($rs['enable'])? "" : "checked";?> /></td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" value="<?php echo $btnTitle;?>..." /></td>
  </tr>
</table>
</form>