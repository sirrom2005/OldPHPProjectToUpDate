<?php
	$id 	= base64_decode($_GET['id']);
	$err="";
	if($_POST)
	{
		$rs['category'] 	= trim($_POST['category']);
		$rs['keywords'] 	= trim($_POST['keywords']);
		$rs['description'] 	= trim($_POST['description']);
		
		if(empty($rs['category'])   ){ $err.="Category is required.<br>";}
		if(empty($rs['keywords'])   ){ $err.="keywords is required.<br>";}
		if(empty($rs['description'])){ $err.="Description is required.<br>";}
		if(!empty($err)             ){ $err ="<span class='err'>$err</span>"; unset($_POST);}
	}
	else{$rs = $obj->getCategory(NULL,$id); $rs=$rs[0];}
	if(!empty($_POST))
	{
		if($obj->updateCategory($_POST))
		{			
			header("location: index.php?action=list_categories");
		}
	}
?>
<div class="leftside">
<?php echo $err;?>
<form name="frm" class="formStyle1" method="post" action=""> 
    <h1>Edit Category</h1>
    <div align="center" style="font-size:12px;" class="required">required fields in red.</div>
    <p><label for="category">Category:<font class="required">*</font></label><input type="text" class="text" name="category" id="category" maxlength="90" value="<?php echo cleanString($rs['category']);?>" /></p>
    <p><label for="keywords">Keywords:<font class="required">*</font> <small>separated by commas (,)</small></label><input type="text" class="text" name="keywords" id="keywords" value="<?php echo cleanString($rs['keywords']);?>" maxlength="80" /></p>
    <p><label for="description">Description:<font class="required">*</font></label></label><textarea name="description" id="description" ><?php echo cleanHTML($rs['description']);?></textarea></p>
    <p align="center"><input type="submit" value="Submit..." class="btn" /></p>
    <p><input type="hidden" name="id" value="<?php echo $rs['id'];?>" /></p>
</form>
</div>
<div class="rightside">
    <script type="text/javascript"><!--
    google_ad_client = "pub-7769573252573851";
    /* 300x250_txt_img */
    google_ad_slot = "6699070243";
    google_ad_width = 300;
    google_ad_height = 250;
    //-->
    </script>
    <script type="text/javascript"
    src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
    </script>
</div>