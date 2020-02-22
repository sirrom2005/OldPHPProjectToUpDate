<?php
	include_once("../classes/events.class.php");
	include_once("../classes/image_resize.php");
	include_once("../classes/commonDB.class.php");
	
	$eventsObj = new events();
	$comObj    = new commonDB();
	
	$id 			= $_GET['id'];
	$filePath 	    = EVENTS_IMG_PATH;
	$btnTxt 		= (empty($id))? "Add" : "Save";
	$titleTxt 		= (empty($id))? "Add" : "Edit";
	
	if($_POST)
	{ 
		$rs 			= $_POST;
		$date 			= trim($_POST['date']); 
		$title 			= trim($_POST['title']);
		$description	= trim($_POST['description']);
		$venue			= trim($_POST['venue']);
		
		if($_FILES)
		{
			$tmpPath  = $_FILES['news_image']['tmp_name'];
			$filename = $_FILES['news_image']['name'];
			
			$uploadImage = $comObj->uploadFile( $filename, $tmpPath, $filePath, array('jpeg', 'jpg', 'gif') );
			if( !empty($uploadImage) ){ $img['image'] = $uploadImage; }
			$_POST['banner'] = $uploadImage;
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
		if(empty($description))
		{
			$error .= "Description is required.<br>";
			unset($_POST);
		}
		if(empty($venue))
		{
			$error .= "Venue is required.<br>";
			unset($_POST);
		}
		echo "<div class='error'>$error</div>";
	}

	if($_POST)
	{	
		$_POST['enable'] = (empty($_POST['enable']))? 0 : 1 ;
		if(empty($id))
		{
			//add
			$_POST['date_added'] = date("Y-m-d");
			$comObj->insertRecord( $_POST, "events" );
		}
		else
		{
			//edit
			$comObj->updateRecord( $_POST, "events", $id );
		}
		
		//include_once("update_rss.php");
		echo "<script> location='index.php?action=list_events'; </script>";
		echo "<meta http-equiv='refresh' content='0;index.php?action=list_events' />";
	}
	
	if(isset($id))
	{
		$rs = $comObj->getDataById( "events", $id );
	}
	else
	{
		$rs['date'] = date("Y-m-d");
	}
?>

<form name="f" action="" method="post" enctype="multipart/form-data" >
<table>
  <tr><th colspan="2" class="header"><?=$titleTxt?> Events</th></tr>
  <tr>
    <th>Email</th>
    <td><input type="text" name="promoter_email" value="<?=cleanString($rs['promoter_email'])?>" class="controlClass1" /></td>
  </tr>
  <tr>
    <th>Promoter</th>
    <td><input type="text" name="promoter" value="<?=cleanString($rs['promoter'])?>" class="controlClass1" /></td>
  </tr>
  <tr>
    <th>Event Name<font class="required">*</font></th>
    <td><input type="text" name="title" value="<?=cleanString($rs['title'])?>" class="controlClass1" /></td>
  </tr>
  <tr>
  <th>Event Date</th>
    <td>
    <input type="text" name="date" value="<?=$rs['date']?>" size="8" />
    <a href="javascript:showCal('date')"><img src="images/calendar.jpg"  border="0"/></a><b>[yyyy-mm-dd]</b></td>
  </tr>
    <tr>
    <th>Event time</th>
    <td><input type="text" name="time" value="<?=cleanString($rs['time'])?>" class="controlClass1" /></td>
  </tr>
  <tr>
    <th>Admission</th>
    <td><input type="text" name="admission" value="<?=cleanString($rs['admission'])?>" class="controlClass1" /></td>
  </tr>
  <tr>
    <th>Venue<font class="required">*</font></th>
    <td><input type="text" name="venue" value="<?=cleanString($rs['venue'])?>" class="controlClass1" /></td>
  </tr>
  <tr>
    <th valign="top">Description<font class="required">*</font></th>
    <td><textarea name="description" cols="80" rows="4"><?=cleanString($rs['description'])?></textarea></td>
  </tr>
  <tr>
    <th valign="top">Banner</th>
    <td>
    	<? if( fileExists($filePath.$rs['banner']) ){  ?> 
        	<img src="../classes/thumbnail.class.php?image=<?=EVENTS_THUM_FOLDER.$rs['banner']?>&w=200" /><br />
            [<a href="javascript:removeImg('<?=base64_encode($rs['banner'])?>');">Remove</a>]
            <input type="hidden" name="banner" value="<?=$rs['banner']?>" />
        <? }else{ ?>
    		<input type="file" name="news_image" />
        <? } ?> 
	</td>
  </tr>
 <tr>
    <td colspan="2">Enable <input type="checkbox" name="enable" <?php echo (!empty($rs['enable']))? "checked" : "" ;?> /></td>
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