<?php
	include_once("../classes/banner.class.php");
	include_once("../classes/image_resize.php");
	include_once("../classes/events.class.php");
	
	$bannerObj = new banner();
	$eventsObj = new events();

	$type 		= $_GET['type'];
	$id 		= $_GET['id'];
	$filePath 	= BANNER_IMG_PATH;
	$btnTxt 	= (empty($id))? "Add banner" : "Update...";
	
	if($_POST)
	{
		$rs 			= $_POST;
		$title 			= trim($_POST['title']);
		$intro_text		= trim($_POST['intro_text']);
		$detail			= trim($_POST['detail']);
		$url			= trim($_POST['url']);
		
		if($_FILES)
		{
			$tmpPath  = $_FILES['banner']['tmp_name'];
			$filename = $_FILES['banner']['name'];
			
			$image = $comObj->uploadFile( $filename, $tmpPath, $filePath, array('jpeg', 'jpg', 'gif') );
			
			if(!empty($image))
			{
				/*$img['image'] = $image;
				@$tn1 = new thumbNail( $img, $filePath, $filePath, 100 );
				@$tn2 = new thumbNail( $img, $filePath, $filePath, 200 );
				@unlink($filePath.$image);*/
			}
			$_POST['banner'] = $image;
		}
		
		$error = "";
		
		if(empty($_POST['banner']))
		{
			$error .= "Banner image is required.<br>";
			unset($_POST);
		}
		if($rs['action_id']==2)
		{
			if(empty($rs['event_id']))
			{
				$error .= "An event must be selected.<br>";
				unset($_POST);
			}
		}
		if($rs['action_id']==3)
		{
			if(empty($url))
			{
				$error .= "URL is required.<br>";
				unset($_POST);
			}
		}		
		echo "<div class='error'>$error</div>";
	}

	if($_POST)
	{		
		if(empty($id))
		{
			//add
			$bannerObj->addBanner( $_POST );
		}
		else
		{
			//edit
			$bannerObj->updateBanner( $_POST, $id );
		}
		echo "<script> location='index.php?action=list_banners'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_banners' />";
	}
	
	if(!empty($id))
	{
		$rs = $bannerObj->getBannerById($id);
	}
	else
	{
		//set one to have Yes select when a new banner is added.
		$rs['show_banner'] = 1;
		$rs['url'] = "#";
	}
	
	$bannerTypeInfo = $bannerObj->getBannerTypeInfo($type);
	$latestEvent    = $eventsObj->getLatestEvent();
	$bannerAction   = $comObj->getHtmlListControlData( "banner_action", "name", "id", "id", "DESC" );
?>
<div class="notes"><?=$bannerTypeInfo['detail']?></div>
<form name="f" method="post" enctype="multipart/form-data">
<table>
  <tr>
    <th valign="top">Image Banner</th>
    <td>
    	<?php if( fileExists($filePath.$rs['banner']) ){   ?> 
        	<img src="../<?=BANNER_THUM_FOLDER.$rs['banner']?>" width="100" /><br />
            [<a href="javascript:removeImg('<?php echo base64_encode($rs['banner'])?>');">Remove</a>]
            <input type="hidden" name="banner" value="<?=$rs['banner']?>" />
        <?php }else{ ?>
    		<input type="file" name="banner" />
        <?php } ?>
     </td>
  </tr>
 <tr>
    <th>Caption</th><td><input type="text" name="caption" size="70" maxlength="200" value="<?php echo cleanString($rs['caption'])?>" /></td>
  </tr>
  <tr>
    <th>Show Banner</th>
    <td>
    	<input type="radio" name="show_banner" id="show_banner_1" value="1" checked="checked" /> <label for="show_banner_1">Yes</label>
        <input type="radio" name="show_banner" id="show_banner_0" value="0" <?php echo (empty($rs['show_banner']))? "checked" : ""?> /> <label for="show_banner_0">No</label>
    </td>
  </tr>
  <tr>
    <th>Click Action</th>
    <td>
    	<select name="action_id">
          <?php foreach($bannerAction as $key => $value){ ?>
            <option value="<?php echo $key?>" <?php echo ($key==$rs['action_id'])? "selected" : ""?> ><?php echo cleanString($value)?></option>
          <?php } ?>
        </select>
    </td>
  </tr>
  <tr>
    <th>Events</th>
    <td>
    	<select name="event_id">
        	<option value="">------EVENTS------</option>
            <?php foreach($latestEvent as $row){ ?>
            <option value="<?php echo $row['id']?>" <?php echo ($row['id']==$rs['event_id'])? "selected" : ""?>><?php echo cleanString( substr($row['title'], 0, 50) )?></option>
            <?php } ?>
        </select>
    </td>
  </tr>
  <tr>
    <th>Site Url</th>
    <td><input type="text" name="url" size="50" value="<?php echo cleanString($rs['url'])?>" />&nbsp;eg. www.somewhere.com</td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" value="<?php echo $btnTxt?>" /><input type="hidden" name="banner_type_id" value="<?php echo $bannerTypeInfo['id']?>" /></td>
  </tr>
</table>
</form>

<script>
function removeImg(file)
{
	if(confirm("Are you sure you want to delete this file?"))
	{
		window.location = "includes/delete_banner_img.php?file=" + file + "&id=<?=$id?>&type=<?=$_GET['type']?>";
	}	
}
</script>