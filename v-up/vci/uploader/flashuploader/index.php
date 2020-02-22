<?php
// === Include main Uploader class
include '../../../config/config.php'; 
include 'SolmetraUploader.php';

// === Instantiate the class
$solmetraUploader = new SolmetraUploader(
  './',           // a base path to Flash Uploader's directory (relative to the page)
  'upload.php',       // path to a file that handles file uploads (relative to uploader.swf) [optional]
  'config.php'  // path to a server-side config file (relative to the page) [optional]
);

// === Gather uploaded files
// Flash Uploader populates PHP's own $_FILE global variable 
// with the information about uploaded files 
$solmetraUploader->gatherUploadedFiles();
if (isset($_FILES) && sizeof($_FILES))
{
	$tempFile = $_FILES['videofiles']['tmp_name'];
	$videoFile = str_replace(VIDEO_TMP_FOLDER,"",$tempFile);
	$ext 			= explode(".", strtolower($videoFile));
	$fileName 		= date("YmdGis").".".$ext[count($ext)-1];
	$videoFilePath	= VIDEO_TMP_FOLDER."$fileName";
	
	rename($tempFile,$videoFilePath);
	echo "<script>window.top.location='".DOMAIN."/vci/vid_converter.php?b64id=".base64_encode($fileName)."';</script>";
}
?>
<style>
body    { background-color: #ffffff; font-family: Verdana; font-size: 10pt; }
.info   { border: 1px solid #aaaaaa; padding: 5px; }
h3      { margin: 20px 0px 5px 0px; }
</style>
<script type="text/javascript" src="SolmetraUploader.js"></script>
<script type="text/javascript">
SolmetraUploader.setErrorHandler('test');
function test (id, str) { alert('ERROR: ' + str); }
SolmetraUploader.setEventHandler('testEvent');
function testEvent (id, str, data) { /*alert('EVENT: ' + str);*/ }
</script>

<form action="index.php" method="post">
<p align="center">
<?php
echo $solmetraUploader->getInstance('videofiles',      // name of the field 
                                    400,              // width
                                    35,               // height
                                    true              // yes - it's required
                                                      // the rest of the parameters are taken from config file
                                    );
?>
</p>
<p align="center"><input type="submit" value="Submit Form" /></p>
</form>