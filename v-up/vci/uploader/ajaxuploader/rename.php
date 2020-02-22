<?php
	include_once("../../../config/config.php");
	$tmpFileName = VIDEO_TMP_FOLDER.$_GET['id'];
	$ext 		 = explode(".", strtolower($tmpFileName));
	$fileName 	 = date("YmdGis").".".$ext[count($ext)-1];
	$newfilename = VIDEO_TMP_FOLDER."$fileName";
	//chmod($tmpFileName, 0777);
	rename($tmpFileName, $newfilename);
	header("location: ../../vid_converter.php?b64id=".base64_encode($fileName));
?>