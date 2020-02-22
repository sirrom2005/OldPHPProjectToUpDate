<?php
include_once("../config/global.php");
include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php" );
include_once("../classes/banner.class.php");

$bannerObj = new banner();	
$rs = $bannerObj->getLatestPicture();

$str = "";
foreach($rs as $row)
{
	$file = re_size($row, 290, NULL);
	$url = "http://www.anyweh.com/gallery/".urlencode($row['folder'])."/".urlencode($row['filename']);
	$str .= "<div><a href='$url'><img width='290' src='$file' /><span>{$row['albumTitle']}</span></a></div>";
}

$str = "var galleryList = \"$str\";";

$handle = fopen("../js/gallery_cron.js", 'w');
if(fwrite($handle, $str) === FALSE)
{
	echo "JS Write failed";
}
fclose($handle);
echo "<h3 align='center'>gallery slideshow list updated...</h3>";

function re_size($file, $wsize=80, $hsize=NULL)
{
	global $tmpFolder, $imageFolder;
	
	include_once("../classes/image_resize_custom.php");
	$imgData['image'] 	= $file['filename'];
	$imgData['h'] 		= $hsize;	
	$thumb = new thumbNail( $imgData, $tmpFolder, $imageFolder.$file['folder']."/", $wsize );
	return "tmp_images/".$thumb->fileName;
} 
?>