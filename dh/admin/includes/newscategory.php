<?php
	include_once("../classes/pagination.class.php");
	include_once("../classes/commonDB.class.php");
	
	$comObj = new commonDB();
	
	$tableName  = "odb_categories";
	$err  		= "";
	
	if($_POST)
	{
		$rs 			= $_POST;
		$cat_name		= trim($rs['cat_name']);
		
		if(empty($cat_name) ){ $err  = "<div class='err'>Category name is required.</div>"; unset($_POST);}
	}
	
	if($_POST)
	{
		$_POST['cat_url_title'] = ceo_url_string($_POST['cat_name']);
		if(empty($id))
		{
			$comObj->insertRecord( $_POST, $tableName );
			$comObj->logAdminActions("ADD NEWS CATEGORY [$cat_name]"); 
		}
		else
		{
			$comObj->updateRecord( $_POST, $tableName, $id );
			$comObj->logAdminActions("UPDATE NEWS CATEGORY [$cat_name]");
			$err  = "<div><b>Category updated.</b></div>";
		}
		
		unset($_POST);
		unset($rs);
	}
		
	$frmTitle = (empty($id))? "Add" : "Edit";
	$btnTitle = (empty($id))? "Add" : "Update";
	
	if(!empty($id))
	{
		$rs = $comObj->getDataById( $tableName, $id );
	}
	
	$result = $comObj->getData( "odb_categories", NULL, "cat_name", "ASC" );
?>
<form name="frm" method="post" action="">
<?php echo $err;?>
<table>
	<tr><th colspan="2" class="header"><?php echo $frmTitle;?> Category</th></tr>
    <tr><th>Category</th><td><input type="text" name="cat_name" value="<?php echo cleanString($rs['cat_name']);?>" /></td></tr>
    <tr><td colspan="2" class="btnCell"><input type="submit" value="<?php echo $btnTitle;?>..." /></td></tr>
</table>
<input type="hidden" name="section" value="1" />
</form>
<p>&nbsp;</p>
<table>
	<tr><th colspan="2" class="header">News Category</th></tr>
    <?php
	if(!empty($result))
	{
    	foreach($result as $row)
		{
	?>
    <tr><td>[<a href="javascript:deleteThis(<?php echo $row['id'];?>);">Delete</a>] [<a href="index.php?action=newscategory&id=<?php echo $row['id'];?>">Edit</a>]</td><td class="header"><?php echo $row['cat_name'];?></td></tr>
   <?php
    	}
	}
	?>
</table>
<script>
function deleteThis(id)
{
	if(confirm("Delete this item?"))
	{
		window.location = "includes/delete_newscategory.php?id=" + id;
	}	
}
</script>
<?php $comObj->logAdminActions("View Reviews Listing"); ?>