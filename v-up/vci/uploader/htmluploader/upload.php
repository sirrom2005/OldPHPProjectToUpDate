<?php
	// encodeing may take a few minutes.
	set_time_limit(1800);
	// disable output buffering so we can send the encoding progress to the browser.
	ob_implicit_flush(true);
	
	$videoFile		= $_FILES['video']['name'];
	$tmpName 		= $_FILES['video']['tmp_name'];
	$fileSize		= $_FILES['video']['size']; 
	$error			= $_FILES['video']['error'];
	
	if(empty($tmpName) || $fileSize<=0  || $error==1 )
	{
		echo "Video file not found or file size may be too large (Video file must be 200MB or less than ).<br/><a href='index.php'>Try again</a>";
		ob_flush();
		flush();
		exit();
	}
	
	include_once("../../../config/config.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Upload video</title>
<link href="../css/css.css" rel="stylesheet" type="text/css" />
</head>
<body id="upload">
    <span class="text1">Uploading video, Please wait...</span><br /><p>&nbsp;</p>
    <span class="text1"><small>This may take a while depending on file size.</small></span>
    <p>&nbsp;</p>
    <div id="loader"></div>
    
</body>
</html>
<?php
 	ob_flush();
	flush();

	if(!empty($tmpName))
	{
		$ext 			= explode(".", strtolower($videoFile));
		$fileName 		= date("YmdGis").".".$ext[count($ext)-1];
		$newFilePath	= VIDEO_TMP_FOLDER."$fileName";
	}

	if(is_uploaded_file($tmpName))
	{
		if(!move_uploaded_file($tmpName, $newFilePath))
		{
			echo "Server error, file could not be uploaded.<br>Error code ($error)<br/><a href='index.php'>Try again</a>";
		}
		else
		{ 
			echo "<script>window.location='../../vid_converter.php?b64id=".base64_encode($fileName)."';</script>"; 
		}
	}
?>