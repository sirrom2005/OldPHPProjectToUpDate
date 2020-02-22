<script type="text/javascript" src="../js/tiny_mce/tiny_mce.js"></script>
<!-- TinyMCE -->
<script type="text/javascript">
    tinyMCE.init({
        mode : "exact",
        theme : "advanced",
		plugins : "emotions,spellchecker,advhr,insertdatetime,preview", 
		elements : "description",
		
		// Theme options - button# indicated the row# only
        theme_advanced_buttons1 : "bold,italic,underline,|,spellchecker,removeformat,|,sub,sup,|,emotions",
        theme_advanced_buttons2 : "cut,copy,paste,|,bullist,numlist,|,outdent,indent,|,undo,redo,|,link,unlink,anchor,image,|,code",
        theme_advanced_buttons3 : "",      
        theme_advanced_toolbar_location : "top",
        theme_advanced_toolbar_align : "left",
        theme_advanced_statusbar_location : "bottom",
        theme_advanced_resizing : true
    });
</script>
<!-- /TinyMCE -->
<?php
	$videoId 	= base64_decode($_GET['id']);
	$err="";
	if($_POST)
	{
		$rs['title'] 		 = trim($_POST['title']);
		$rs['description'] 	 = trim($_POST['description']);
		$rs['url_title'] 	 = trim($_POST['url_title']);
		$rs['meta_desc'] 	 = trim($_POST['meta_desc']);
		$rs['tags']			 = trim($_POST['tags']);
		$rs['category_id'] 	 = $_POST['category_id'];
		
		$_POST['title'] 	 = addslashes($_POST['title']);
		$_POST['description']= addslashes($rs['description']);
		$_POST['url_title']  = addslashes($rs['url_title']);
		$_POST['meta_desc']  = addslashes($rs['meta_desc']);
		$_POST['tags']  	 = addslashes($rs['tags']);
		
		if(empty($rs['title'])      ){ $err.="Title is required.<br>";}
		if(empty($rs['tags'])       ){ $err.="Tags is required.<br>";}
		if(empty($rs['category_id'])){ $err.="Category is required.<br>";}
		if(empty($rs['description'])){ $err.="Description is required.<br>";}
		if(!empty($err)             ){ $err ="<span class='err'>$err</span>"; unset($_POST);}
	}
	else{$rs = $obj->getVideoRecord($videoId);}
	if(!empty($_POST))
	{
		$_POST['user_id'] 	= $_SESSION['ADMIN_USER']['id'];
		$_POST['id'] 		= $videoId;
		$_POST['explicit']  = (empty($_POST['explicit']))? 0 : 1;
		$_POST['enable']  = 1;
		if($obj->updateVideoInfo($_POST))
		{			
			include_once("../classes/image_resize.php");
			$path = VIDEO_DEST_FOLDER."$videoId/";
			$img['image'] = "thumbnail1.jpg";	
			@$tn1 = new thumbNail( $img, $path, $path, 120, "thumbnail1sml.jpg");
			@$tn2 = new thumbNail( $img, $path, $path, 300, "thumbnail1med.jpg");
			
			//header("location: index.php?action=my_videos");
			header("location: publish_videos.php?id=$videoId");
		}
	}
?>
<div class="leftside">
<?php echo $err;?>
<form name="frm" class="formStyle1" method="post" action=""> 
    <h1>Edit Video</h1>
    <div align="center" style="font-size:12px;" class="required">required fields in red.</div>
    <p><label for="title">Title:<font class="required">*</font></label><input type="text" class="text" name="title" id="title" maxlength="90" value="<?php echo textBoxFix($rs['title']);?>" /></p>
    <p><label for="tagss">Tags:<font class="required">*</font> <small>separated by commas (,)</small></label><input type="text" class="text" name="tags" id="tagss" value="<?php echo textBoxFix($rs['tags']);?>" /></p>
    <?php if(!empty($category)){?>
    <p><label for="category_id">Category:<font class="required">*</font></label></label>
        <select name="category_id" id="category_id" class="text">
        <option value="">Select category</option>
        <?php foreach($category as $row){?>
            <option value="<?php echo $row['id'];?>" <?php echo ($rs['category_id']==$row['id'])? "selected" : "";?> ><?php echo cleanString($row['category']);?></option>
        <?php }?>
        </select>
    </p>
    <?php }?>
    <p><label for="description">Description:<font class="required">*</font></label></label><textarea name="description" id="description"><?php echo cleanHTML($rs['description']);?></textarea></p>
    <!--p><label style="float:left;" for="publish">Publish video</label><input type="checkbox" checked="checked" name="publish" id="publish" /></p-->
    <p>
    	<input type="checkbox" name="explicit" id="explicit" value="1" <?php echo (!empty($rs['explicit']))? "checked" :"";?> />
    	<small style="color:#FF0000;font-weight:bold;font-size:12px;">This video contain violence, gore or strong sexual content</small>
    </p>
    <?php if($_SESSION['ADMIN_USER']['account_type']==1){ ?>
    <div id="advance">
        <p><label for="url_title">URL Title:</label><input type="text" class="text" name="url_title" id="url_title" maxlength="90" value="<?php echo cleanString($rs['url_title']);?>" /></p>
        <p><label for="meta_desc">Meta Desc:</label><textarea name="meta_desc" id="meta_desc"><?php echo cleanString($rs['meta_desc']);?></textarea></p>
    </div>
    <?php } ?>
    <p align="center"><input type="submit" value="Submit..." class="btn" /></p>
</form>
</div>
<div class="rightside">
	<p><img src="<?php echo VIDEO_PATH_URL."$videoId/thumbnail1.jpg";?>" width="300" /></p>
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