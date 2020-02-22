<?php
	include_once("../classes/user.class.php");
	include_once("../classes/software.class.php");
		
	$id			= $_GET['id'];
	$userObj 	= new user();
	$obj 		= new software();
	$tableName  = "odb_news";
	$err		= NULL;	
		
	if($_POST)
	{
		$rs 			= $_POST;
		$title			= trim($rs['title']);
		$detail			= trim($rs['detail']);	
		$_POST['enable']= (empty($rs['enable']))? "0" : "1";
		
		if(empty($title) ){ $err  = "<div class='err'>Title is required.</div>"; unset($_POST);}
		if(empty($detail)){ $err .= "<div class='err'>Content detail is required.</div>"; unset($_POST);}
	}
	
	if($_POST)
	{
		if(empty($id))
		{	$_POST['date_added'] = date("Y-m-d g:i:s");
			$comObj->insertRecord( $_POST, $tableName );
			$comObj->logAdminActions("ADD NEWS [$title]"); 
		}
		else
		{
			$comObj->updateRecord( $_POST, $tableName, $id );
			$comObj->logAdminActions("UPDATE NEWS [$title]");
		}
		echo "<script> location='index.php?action=list_news'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_news' />";
	}
	
	if(!empty($id))
	{
		$rs = $comObj->getDataById( $tableName, $id );
	}
	
	$btnTitle 		= (empty($id))? "Add" : "Update";
	$frmTitle		= (empty($id))? "Add" : "Edit";
	$btnTitle 		= (empty($id))? "Add" : "Update";
	$category_id 	= $obj->getNewsCategory(8);
?>
<!--link rel="stylesheet" href="docs/style.css" type="text/css"-->
<script type="text/javascript" src="scripts/wysiwyg.js"></script>
<script type="text/javascript" src="scripts/wysiwyg-settings.js"></script>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<?php echo $err;?>
<table>
  <tr><th colspan="2" class="header"><?php echo $frmTitle;?> News</th></tr>
  <tr>
    <th>Category</th>
    <td>
		<select name="category_id">
		<?php foreach($category_id as $row){?> 
			<option value="<?php echo $row['id'];?>" <?php echo ($rs['category_id']==$row['id'])? "selected" : "";?> ><?php echo $row['cat_name'];?></option>
		<?php } ?> 
		</select>
	</td>
  </tr>
  <tr>
    <th>Title<font class="required">*</font></th> 
    <td><input type="text" name="title" size="50" value="<?php echo cleanString($rs['title']);?>" /></td>
  </tr>
  <tr>
    <th>Detail<font class="required">*</font></th>
    <td>
    <textarea id="textarea1" name="detail" style="width:50%;height:400px;"><?php echo cleanHtml($rs['detail']);?></textarea>
	<input type="hidden" name="account_id" value="<?php echo $_SESSION['admin']['id'];?>" />
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
<!-- 
	Attach the editor on the textareas
-->
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