<?php
	$err = "";
	$id = (isset($_GET['id']))? $_GET['id'] : NULL;
	$rs = array("title" => "", "detail" => "");
	if($_POST)
	{
		$rs['title'] 	= trim($_POST['title']);
		$rs['detail']	= trim($_POST['detail']);
		
		if(empty($rs['title']) ){$err = "Title is required<br>"; unset($_POST);}
		if(empty($rs['detail'])){$err .= "Detail is required<br>"; unset($_POST);}
		if(!empty($err)        ){echo "<span class='err'>$err</span>";}
	}
	if(!empty($_POST))
	{
		if($comObj->updateRecord($rs,"odb_content",$id))
		{
			$rs['title'] 	= "";
			$rs['detail']	= "";
			echo "<span class='err'>Page updated.</span>";
		}
	}
	$result = $comObj-> getData("odb_content", NULL, "id", "ASC");
	
	
	if(!empty($id))
	{
		$rs = $comObj->getDataById("odb_content",$id);
	}
?>
<table>
	<tr>
    	<th>Page key</th>
        <th>Page title</th>
    </tr>
	<?php 
		$alt = true;
		foreach($result as $row){ 
		$alt 	= ($alt)? false : true;
		$style 	= ($alt)? "rowStyle1" : "rowStyle2";
	?>
	<tr class="<?php echo $style;?>">
    	<td>[<?php echo $row['page'];?>]</td>
        <td><a href="index.php?action=contentpages&id=<?php echo $row['id'];?>"><?php echo $row['title'];?></a></td>
    </tr>
    <?php } ?>
</table>
<?php 
	if(isset($_GET['id']))
	{
?>
<form name="f" action="" method="post">
<p><h1>Content page</h1></p>
<p><label for="title">Credit amount</label><input type="text" name="title" id="title" value="<?php echo cleanString($rs['title']);?>"></p>
<p><textarea name="detail" id="detail"><?php echo cleanHTML($rs['detail']);?></textarea></p>
<p><input type="submit" value="Update..."></p>
</form>
<?php 
	} 
?>
<script language="javascript" type="text/javascript">
function deleteItem(id)
{
	if(confirm("Are you sure you want to delete this record."))
	{
		window.location = "index.php?action=delete_payment_credit&id=" + id;
	}
}
</script>