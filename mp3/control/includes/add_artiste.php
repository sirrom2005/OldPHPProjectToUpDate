<?php
	$id		= (isset($_GET['id']))? $_GET['id'] : 0;
	$err	= "";	
	$rs	= array("stagename" => "",
				"fname"  => "",
				"mname"  => "",
				"lname"  => "",
				"gender" => "",
				"bio"    => "");
		
	if($_POST)
	{
		$rs 	= $_POST;
		$fname	= trim($rs['fname']);
		$detail	= trim($rs['bio']);
		$stagename	= trim($rs['stagename']);
				
		if(empty($stagename)){ $err .= "Stage name is required.<br>"; unset($_POST);}
		//if(empty($fname)    ){ $err .= "First name is required.<br>"; unset($_POST);}
		if(empty($detail)   ){ $err .= "Content detail is required.<br>"; unset($_POST);}
		if(!empty($err)     ){echo "<span class='err'>$err</span>";}
	}
	
	if(!empty($_POST))
	{
		include_once("../classes/image_resize.php");
		$tmpPath  		= $_FILES['photo']['tmp_name'];
		$filename 		= $_FILES['photo']['name'];
		if(!empty($tmpPath))
		{
			$filePath = ARTISTE_IMG_PATH;
			$rs['photo'] 	= $comObj->uploadFile( $filename, $tmpPath, $filePath, array('jpeg','jpg') );
			$img['image']	= $rs['photo'];
			$img['h']		= 50;
			@$tn1 			= new thumbNail($img, $filePath, $filePath, ARTISTE_SML_TMB, true);
			$img['h']		= NULL;
			@$tn2 			= new thumbNail($img, $filePath, $filePath, ARTISTE_MED_TMB);
			@$tn3 			= new thumbNail($img, $filePath, $filePath, ARTISTE_LRG_TMB);
		}
		
		if(empty($id))
		{
			$rs['date_added'] = date("Y-m-d");
			$rs['producer_id'] = $_SESSION['USER']['id'];
			$comObj->insertRecord($rs,"odb_artistes");
		}
		else
		{
			$comObj->updateRecord($rs,"odb_artistes",$id);
		}
		
		if(!empty($filename))
		{
			header("location: ../images/artise/thumbnail.php?f={$rs['photo']}");
		}
		else
		{
			header("location: index.php?action=list_artiste");
		}
	}
	
	if(!empty($id))
	{
		$rs = $comObj->getDataById("odb_artistes",$id);
	}

	
	$btnTitle 	= (empty($id))? "Add" : "Update";
	$frmTitle	= (empty($id))? "Add" : "Edit";
?>
<form name="f" action="" method="post" enctype="multipart/form-data" >
<h1><?php echo $frmTitle;?> artiste</h1>
<p><label for="stagename">Stage name<font class="required">*</font></label><input type="text" name="stagename" id="stagename" value="<?php echo cleanString($rs['stagename']);?>" /></p>
<p><label for="fname">First name</label><input type="text" name="fname" id="fname" value="<?php echo cleanString($rs['fname']);?>" /></p>
<p><label for="mname">Middle name</label><input type="text" name="mname" id="mname" value="<?php echo cleanString($rs['mname']);?>" /></p>
<p><label for="lname">Last name</label><input type="text" name="lname" id="lname" value="<?php echo cleanString($rs['lname']);?>" /></p>
<p>
	<?php if(empty($rs['photo'])){ ?>
		<label for="photo">Photo</label><input type="file" name="photo" id="photo" /> For best reasult artiste image must be square
    <?php }else{ ?>
    	<img src="<?php echo ARTISTE_IMG_URL.ARTISTE_SML_TMB."_".$rs['photo'];?>" /><a href="#" onclick="removeimage(<?php echo $id;?>);" class="remove_imge">Remove</a>
    <?php } ?>
</p>
<p>
    <input type="radio" name="gender" id="g1" value="male" checked="checked" /><label for="g1">Male</label>
	<input type="radio" name="gender" id="g2" value="female" <?php echo (($rs['gender']) == "female")? "checked" :"";?> /><label for="g2">Female</label>
</p>
<p><textarea id="bio" name="bio"><?php echo cleanHtml($rs['bio']);?></textarea></p>
<p><input type="submit" value="<?php echo $btnTitle;?>..." /> </p>
</form>

<script>
function removeimage(id)
{
	if(confirm("Delete this image?"))
	{
		window.location = "index.php?action=delete_artise_imge&id=" + id;
	}	
}
</script>