<?php
session_start();
include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/site.class.php");

$siteObj = new site();

$file 		= $_GET['file'];
$ext  		= $_GET['ext'];
$filesize 	= $_GET['filesize'];

$filename 	= filename($file);
$title 		= fileTitle($file, $ext);

//rename(UPLOADDIR.$file,UPLOADDIR.$filename);
$data['title'] 	  = $title;	
$data['filename'] = $filename;
$data['filesize'] = $filesize; 

$siteObj->addMP3($data);

function filename($str)
{
	$str = str_replace(" ", "_",$str);
	$str = str_replace("-", "",$str);
	$str = str_replace("{", "",$str);
	$str = str_replace("}", "",$str);
	$str = str_replace("(", "",$str);
	$str = str_replace(")", "",$str);
	return $str;
}

function fileTitle($str,$ext)
{
	$str = str_replace("$ext", "",$str);
	$str = str_replace("_", " ",$str);
	$str = str_replace("-", "",$str);
	$str = str_replace("{", "",$str);
	$str = str_replace("}", "",$str);
	$str = str_replace("(", "",$str);
	$str = str_replace(")", "",$str);
	return $str;
}
?>