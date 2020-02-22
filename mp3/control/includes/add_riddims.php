<?php
	$id		= (isset($_GET['id']))?$_GET['id']:"";
	$err	= "";	
	$rs		= array("name"   => "",
					"detail" => "");
	
	if($_POST)
	{
		$rs		= $_POST;
		$name	= trim($rs['name']);	
				
		if(empty($name)  ){$err  = "Riddim name is required.<br>"; unset($_POST);}
		if(!empty($err)  ){echo "<span class='err'>$err</span>";}
	}

	if(!empty($_POST))
	{
		if(empty($id))
		{
			$rs['date_added'] = date("Y-m-d");
			$rs['producer_id'] = $_SESSION['USER']['id'];
			$comObj->insertRecord($rs,"odb_riddims");
		}
		else
		{
			$comObj->updateRecord($rs,"odb_riddims",$id);
		} 
		header("location: index.php?action=list_riddims");
	}
	
	if(!empty($id))
	{
		$rs = $comObj->getDataById("odb_riddims",$id);
	}
	
	$btnTitle 	= (empty($id))? "Add" : "Update";
	$frmTitle	= (empty($id))? "Add" : "Edit";
?>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<h1><?php echo $frmTitle;?> riddims</h1>
<p><label for="title">Riddim name<font class="required">*</font></label><input type="text" name="name" id="name" size="50" value="<?php echo cleanString($rs['name']);?>" /></p>
<p>
<textarea name="detail"><?php echo cleanString($rs['detail']);?></textarea>
</p>
<p><input type="submit" value="<?php echo $btnTitle;?>..." /></p>
</form>