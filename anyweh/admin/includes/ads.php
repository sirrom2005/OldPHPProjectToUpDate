<?php
	$id 		= $_GET['id'];
	$tableName 	= "banner";
	
	if($_POST)
	{ 
		if($_FILES)
		{			
			$logo 					= $_FILES['ads_image']['tmp_name'];
			$logo_size 				= $_FILES['ads_image']['size'];
			$logo_type 				= $_FILES['ads_image']['type'];
			
			$fp 					= fopen($logo, "rb");
			$data					= base64_encode(fread($fp, filesize($logo)));
			fclose($fp);
			
			$_POST['banner']			= $data;
			$_POST['banner_size']		= $logo_size;
			$_POST['banner_file_type']	= $logo_type;
		}
		
		if(!empty($id))
		{
			$comObj->updateRecord( $_POST, $tableName, $id );
			$imgId = $id;
		}
		else
		{
			$comObj->insertRecord( $_POST, $tableName );
			$imgId = mysql_insert_id();
		}
		
		$ext 		= str_replace("image/", "", $logo_type);
		$imgname 	= "../images/tmp_ads/{$imgId}_{$logo_size}.$ext";
		$img 		= base64_decode($data);
		$fp 		= fopen($imgname, "wb");
		fwrite($fp, $img, $logo_size);
		fclose($fp);
		
		echo "<script> location='index.php?action=list_ads'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_ads' />";
	}
	
	if(!empty($id)){ $rs = $comObj->getDataById( $tableName, $id ); }else{ $rs['startdate'] = date("Y-m-d"); $rs['enddate'] = date("Y-m-d", strtotime("+ 7 days")); }
	
	$bannerType = $comObj->getHtmlListControlData( "banner_type", "name", "id", "id", "ASC" );
	
?>
<form name="f" method="post" action="" enctype="multipart/form-data">
	<?php echo $err;?>
<table>
  <tr><th colspan="2" class="header"><?=$titleTxt?> Ads</th></tr>
  <tr>
    <th>Banner Type</th>
    <td>
		<select name="banner_type">
			<?php foreach($bannerType as $key => $value){ ?>
			<option value="<?php echo $key;?>" ><?php echo $value;?></option>
			<?php } ?>
		</select>
	</td>
  </tr>
  <tr>
    <th>Ads image</th>
    <td><input type="file" name="ads_image" id="ads_image" value=""></td>
  </tr>
  <tr>
    <th>URL</th>
    <td><input type="text" name="url" value="<?php echo cleanString($rs['url']);?>" class="controlClass1"  ></td>
  </tr>
  <!--th>Start Date</th>
    <td>
    <input type="text" name="startdate" value="<?php echo $rs['startdate'];?>" size="8" />
    <a href="javascript:showCal('startdate')"><img src="images/calendar.jpg"  border="0"/></a><b>[yyyy-mm-dd]</b></td>
  </tr>
  <th>End Date</th>
    <td>
    <input type="text" name="enddate" value="<?php echo $rs['enddate'];?>" size="8" />
    <a href="javascript:showCal('enddate')"><img src="images/calendar.jpg"  border="0"/></a><b>[yyyy-mm-dd]</b></td>
  </tr-->
  <tr>
    <td colspan="2"><input type="submit" value="Submit..."></td>
  </tr>
</table>
</form>