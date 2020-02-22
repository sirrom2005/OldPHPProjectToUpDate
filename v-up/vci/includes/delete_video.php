<?php
$rs = $obj->getVideoRecord(base64_decode($_GET['id']));
if(!empty($rs['video']))
{ 
	$current_dir = VIDEO_DEST_FOLDER."{$rs['video']}/";
	if(is_dir($current_dir))
	{			
		$dir = opendir($current_dir);
		while(($f = readdir($dir)) !== false)
		{
			chmod($current_dir.$f, 0777);
			@unlink($current_dir.$f);
		}
		chmod($current_dir, 0777);
		@closedir($current_dir);
		@rmdir($current_dir);
	}
	$result = $obj->deleteVideo($rs['id']);
	if(!empty($result))
	{
		echo "<meta http-equiv=\"refresh\" content=\"2;index.php?action=my_videos\" />";
		echo "<span class='msg'>Video deleted...</span>";
		return true;
	}
}
else
{echo "<span class='err'>Error trying to delete video...</span>";}
?>