<?php
	include '../config/config.php';
	$tempFile 		= $_GET['file'];
	$videoFile 		= $tempFile;
	$ext 			= explode(".", strtolower($videoFile));
	$fileName 		= date("YmdGis").".".$ext[count($ext)-1];
	$videoFilePath	= VIDEO_TMP_FOLDER."$fileName";
	
	rename(VIDEO_TMP_FOLDER.$tempFile,$videoFilePath);
	echo "vid_converter.php?b64id=".base64_encode($fileName);
?>