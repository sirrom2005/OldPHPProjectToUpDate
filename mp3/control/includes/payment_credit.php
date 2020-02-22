<?php
	$err = "";
	$rs = array("credit" => "", "cost" => "");
	if($_POST)
	{
		$rs['credit'] 	= trim($_POST['credit']);
		$rs['cost'] 	= trim($_POST['cost']);
		
		if(empty($rs['credit'])){$err = "Credit amount required<br>"; unset($_POST);}
		if(empty($rs['cost'])  ){$err .= "Cost amount required<br>"; unset($_POST);}
		if(!empty($err)         ){echo "<span class='err'>$err</span>";}
	}
	if(!empty($_POST))
	{
		if($comObj->insertRecord($rs,"odb_credit_cost"))
		{
			$rs['credit'] 	= "";
			$rs['cost'] 	= "";
		}
	}
	$result = $comObj-> getData("odb_credit_cost", NULL, "credit", "ASC");
?>
<?php if(!empty($result)){ ?>
<table>
	<tr>
    	<th>&nbsp;</th>
    	<th>Credit</th>
        <th>Cost</th>
    </tr>
	<?php 
		$alt = true;
		foreach($result as $row){ 
		$alt 	= ($alt)? false : true;
		$style 	= ($alt)? "rowStyle1" : "rowStyle2";
	?>
	<tr class="<?php echo $style;?>">
    	<td><a href="javascript:deleteItem('<?php echo base64_encode($row['id']);?>');"><img src="../images/icon-delete.gif"></a></td>
        <td><?php echo $row['credit'];?></td>
        <td>$<?php echo number_format($row['cost'], 2, ".", ",");?></td>
    </tr>
    <?php } ?>
</table>
<?php } ?>
<form name="f" action="" method="post">
<p><h1>Add Credit</h1></p>
<p><label for="credit">Credit amount</label><input type="text" name="credit" id="credit" value="<?php echo cleanString($rs['credit']);?>" size="5" maxlength="5" onkeypress="return numbersOnly(event, false)"></p>
<p><label for="cost">Cost</label><input type="text" name="cost" id="cost" value="<?php echo cleanString($rs['cost']);?>" size="5" maxlength="7" onkeypress="return priceOnly(event, false)"></p>
<p><input type="submit" value="Add..."></p>
</form>
<script language="javascript" type="text/javascript">
function deleteItem(id)
{
	if(confirm("Are you sure you want to delete this record."))
	{
		window.location = "index.php?action=delete_payment_credit&id=" + id;
	}
}
</script>