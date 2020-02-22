<?
	include_once("../classes/events.class.php");
	include_once("../classes/image_resize.php");
	include_once("../classes/commonDB.class.php");
	include_once("../js/FCKeditor/fckeditor.php" );
	
	$eventsObj = new events();
	$comObj    = new commonDB();
	
	$id 			= $_GET['id'];
	$filePath 	    = VIDEO_IMG_PATH;
	$btnTxt 		= (empty($id))? "Add" : "Save";
	$titleTxt 		= (empty($id))? "Add" : "Edit";
	
	if($_POST)
	{ 
		$rs 			= $_POST;
		$date 			= trim($_POST['date']); 
		$title 			= trim($_POST['title']);
		$intro_text		= trim($_POST['intro_text']);
		
		if($_FILES)
		{
			$tmpPath  = $_FILES['video']['tmp_name'];
			$filename = $_FILES['video']['name'];
		print_r( $_FILES);	
			$video = $comObj->uploadFile( $filename, $tmpPath, $filePath, array('flv') );

			$_POST['video'] = $video;
			exit($video);
		}

		$error = "";
		if(empty($date))
		{
			$error .= "Date is required.<br>";
			unset($_POST);
		}
		if(empty($title))
		{
			$error .= "Title is required.<br>";
			unset($_POST);
		}
		if(empty($video))
		{
			$error .= "Video file is required.<br>";
			unset($_POST);
		}
		echo "<div class='error'>$error</div>";
	}

	if($_POST)
	{		
		if(empty($id))
		{
			//add
			$_POST['date_added'] = date("Y-m-d");
			$comObj->insertRecord( $_POST, "videos" );
		}
		else
		{
			//edit
			$comObj->updateRecord( $_POST, "videos", $id );
		}
		echo "<script> location='index.php?action=list_video'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_video' />";
	}
	
	if(isset($id))
	{
		$rs = $comObj->getDataById( "videos", $id );
	}
	else
	{
		$rs['date'] = date("Y-m-d");
	}
?>

<form name="f" action="" method="post" enctype="multipart/form-data" >
<table>
  <tr><th colspan="2" class="header"><?=$titleTxt?> Video</th></tr>
  <tr>
    <th>Name<font class="required">*</font></th>
    <td><input type="text" name="title" value="<?=cleanString($rs['title'])?>" class="controlClass1" /></td>
  </tr>
  <tr>
    <th>Promoters</th>
    <td><input type="text" name="promoter" value="<?=$rs['promoter']?>"  /></td>
  </tr>
  <tr>
    <th>Venue</th>
    <td><input type="text" name="venue" value="<?=$rs['venue']?>" /></td>
  </tr>
  <tr>
    <th>Date</th>
    <td><input type="text" name="date" value="<?=$rs['date']?>" size="8" />
    <a href="javascript:showCal('date')"><img src="images/calendar.jpg"  border="0"/></a><b>[yyyy-mm-dd]</b></td>
  </tr>
  <tr>
    <th valign="top">Video<font class="required">*</font></th>
    <td>
    	<? if( fileExists($filePath.$rs['banner']) ){  ?> 
        	<img src="../classes/thumbnail.class.php?image=<?=EVENTS_THUM_FOLDER.$rs['banner']?>&w=200" /><br />
            [<a href="javascript:removeImg('<?=base64_encode($rs['banner'])?>');">Remove</a>]
            <input type="hidden" name="banner" value="<?=$rs['banner']?>" />
        <? }else{ ?>
    		<input type="file" name="video" />
        <? } ?>
     </td>
  </tr>
  <tr>
    <td colspan="2" class="btnCell"><input type="submit" value="<?=$btnTxt?>..." /></td>
  </tr>
</table>
</form>

<script>
function removeImg(file)
{
	if(confirm("Are you sure you want to delete this file?"))
	{
		window.location = "includes/delete_event_img.php?file=" + file + "&id=<?=$id?>";
	}	
}
</script>