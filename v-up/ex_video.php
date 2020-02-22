<?php
session_start();
include_once("config/config.php");
include_once("classes/mySqlDB__.class.php");
include_once("classes/site.class.php");

if(empty($_SESSION['ADMIN_USER']))
{
	header("location:".DOMAIN."restricted_content.html");
}

$obj = new site();
$id = base64_decode($_GET['id']);
  
$category 	= $obj->getCategory();
$videoTags 	= $obj->getVideoTags();
$result   	= $obj->getVideoRecord($id,true,true);
$id			= $result['video'];
$userList 	= $obj->getUserVideoList($result['user_id'],6,$id);
$cat 		= urlFix($result['category']);

$taglists 	= "";
$tags 		= "";

$keywords 	= $result['tags'];
$description= (!empty($result['meta_desc']))? $result['meta_desc'] : cleanString($result['description']);

if(!empty($videoTags))
{
	foreach($videoTags as $row)
	{
		$taglists .= $row['tags'].",";
	}
	$taglists = explode(",", $taglists);  
	$taglist  = array_unique($taglists);
	foreach($taglist as $key => $value)
	{
		$tags .= $value.",";
	}
}

ob_start(); 
	include_once("templates/video.html");
	$content = ob_get_contents();
ob_end_clean();
echo $content;
?>