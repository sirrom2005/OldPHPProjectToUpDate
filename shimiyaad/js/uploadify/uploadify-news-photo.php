<?php
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php> 
*/
// Define a destination
include_once("../../config/config.php"); //session_destroy();
include_once("../../classes/mySqlDB__.class.php");
include_once("../../classes/commonDB.class.php");

$commObj = new commonDB();
$targetFolder = $id = $_POST['folder']; // Relative to the root

if (!empty($_FILES)) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] .'/'. NEWSFOLDER . $targetFolder;
	
	if(!is_dir($targetPath)){mkdir($targetPath,0755);}
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	$img = time().'.'.strtolower($fileParts['extension']);
	$targetFile = rtrim($targetPath,'/') . '/' . $img;
	
	if (in_array(strtolower($fileParts['extension']),$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		$size = getimagesize($targetPath.'/'.$img);
        imageResize($targetPath.'/', $img, 100,  $size[1]/($size[0]/100) );	
		imageResize($targetPath.'/', $img, 250,  $size[1]/($size[0]/250) );
	
		$data['news_id'] 	= $id;
		$data['image_name'] = $img;
		$data['date_added'] = date("Y-m-d H:i:s");
		$commObj->insertRecord($data,'news_articles_images');
		chmod($targetFile,0777);
		chmod($targetPath.'100_'.$img,0777);
		chmod($targetPath.'250_'.$img,0777);
	
		echo 1;
	} else {
		echo 'Invalid file type.';
	}
}

function imageResize($dir, $img, $w=50, $h=50)
{
    $src = $dir.$img;
    $ext = explode('.', $img);
    $newfile = $dir.$w.'_'.$ext[0].'.'.$ext[1];

    if( $ext[1] == "jpg"  ){ $imageSrc = imagecreatefromjpeg($src);}
    if( $ext[1] == "jpeg" ){ $imageSrc = imagecreatefromjpeg($src);}
    if( $ext[1] == "pjpeg"){ $imageSrc = imagecreatefromjpeg($src);}
    if( $ext[1] == "gif"  ){ $imageSrc = imagecreatefromgif($src); }
    if( $ext[1] == "png"  ){ $imageSrc = imagecreatefrompng($src); }

    $srcImgWidth	= imagesx($imageSrc);
    $srcImgHeight	= imagesy($imageSrc);
    $dstImgWidth    = (int)$w;
    $dstImgHeight   = (int)$h;

    $imgdest = imagecreatetruecolor( $dstImgWidth, $dstImgHeight );
    imagecopyresampled( $imgdest, $imageSrc, 0,0,0,0, $dstImgWidth , $dstImgHeight, $srcImgWidth, $srcImgHeight );

    if( $ext[1] == "jpg" || $ext[1] == "jpeg" || $ext[1] == "pjpeg" )
    {
        @imagejpeg($imgdest, $newfile, 85);
    }
    if( $ext[1] == "gif" )
    {
        /*NOt really sure but wen i add the NULL parameter i get an error*/
        @imagegif($imgdest, $newfile);
    }
    if( $ext[1] == "png" )
    {
        @imagepng($imgdest, $newfile);
    }
    @imagedestroy($imgdest);
    @imagedestroy($imageSrc);
    return $newfile;
}
?>