<?
	include_once("../classes/banner.class.php");
	include_once("../classes/image_resize.php");
	
	$bannerObj = new banner();

	$type = $_GET['type'];
	$filePath = HOTTGIRL_IMG_PATH;
	
	if($_POST)
	{
		$rs 			= $_POST;
		$caption_1 		= trim($_POST['caption_1']);
		$caption_2 		= trim($_POST['caption_2']);
		
		if($_FILES)
		{
			$tmpPath  = $_FILES['girl_1']['tmp_name'];
			$filename = $_FILES['girl_1']['name'];
			
			$image = $comObj->uploadFile( $filename, $tmpPath, $filePath, array('jpeg', 'jpg', 'gif') );
			
			if(!empty($image))
			{
				$img['image'] = $image;
				@$tn1 = new thumbNail( $img, $filePath, $filePath, 135 );
				@$tn2 = new thumbNail( $img, $filePath, $filePath, 200 );
				@unlink($filePath.$image);
			}
			$_POST['girl_1'] = $image;
			############################################################################################
			$tmpPath  = $_FILES['girl_2']['tmp_name'];
			$filename = $_FILES['girl_2']['name'];
			
			$image = $comObj->uploadFile( $filename, $tmpPath, $filePath, array('jpeg', 'jpg', 'gif') );
			
			if(!empty($image))
			{
				$img['image'] = $image;
				@$tn1 = new thumbNail( $img, $filePath, $filePath, 135 );
				@$tn2 = new thumbNail( $img, $filePath, $filePath, 200 );
				@unlink($filePath.$image);
			}
			$_POST['girl_2'] = $image;
		}
		
		$error = "";
		if(empty($_POST['girl_1']))
		{
			$error .= "Image one is required.<br>";
			unset($_POST);
		}
		if(empty($_POST['girl_2']))
		{
			$error .= "Image two is required.<br>";
			unset($_POST);
		}
		if(empty($caption_1))
		{
			$error .= "Caption one is required.<br>";
			unset($_POST);
		}
		if(empty($caption_1))
		{
			$error .= "Caption two is required.<br>";
			unset($_POST);
		}
		echo "<div class='error'>$error</div>";
	}

	if($_POST)
	{		
		if(empty($id))
		{
			//add
			$bannerObj->addHottGirl( $_POST );
		}
		else
		{
			//edit
			$bannerObj->updateNews( $_POST, $id );
		}
		echo "<script> location='index.php?action=list_hottgirls'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_hottgirls' />";
	}
	
	$bannerTypeInfo = $bannerObj->getBannerTypeInfo($type);
?>
<div class="notes">Upload a pair of females for voting. For best result upload images with dimension of [200x307].</div>
<form name="f" method="post" enctype="multipart/form-data">
<table>
  <tr>
    <th>Hott Girl 1</th>
    <td><input type="file" name="girl_1" /></td>
  </tr>
  <tr>
    <th>Caption 1</th>
    <td><input type="text" name="caption_1" size="100" maxlength="250" /></td>
  </tr>
    <tr>
    <th>Hott Girl 2</th>
    <td><input type="file" name="girl_2" /></td>
  </tr>
  <tr>
    <th>Caption 2</th>
    <td><input type="text" name="caption_2" size="100" maxlength="250" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" value="Upload..." /></td>
  </tr>
</table>
</form>
