<?php
ob_implicit_flush(true);
set_time_limit(0);
session_start();
if(empty($_SESSION['ADMIN_USER'])){header("location: ../login.html");}
include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/site.class.php");

$obj = new site(); 

$data['latest'] = 1;
$rs = $obj->getSearchVideo($data);
echo "GENERATING VIDEO PAGES";
echo "<ol>";
foreach($rs as $row)
{
	writeVideoFile($row['video']);
	sleep(0);
	ob_flush();
	flush();
}
echo "</ol>";
echo "COMPLETE";

function writeVideoFile($id)
{
	/***********WRITE VIDEO PAGE HTML******************/
	global  $obj;
	$category 	= $obj->getCategory();
	$videoTags 	= $obj->getVideoTags();
	$result   	= $obj->getVideoRecord($id, true);
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
		$taglists = array_unique($taglists);
		foreach($taglists as $key => $value)
		{
			$tags .= $value.",";
		}
	}
	
	$HTMLfolder = SERVER_ROOT.urlFix($result['category'])."/";
	@mkdir($HTMLfolder, 0775);
	@chmod($HTMLfolder, 0775);
	//Get html content.	
	ob_start();
	include("../templates/video.html");
	$content = ob_get_contents();
	ob_end_clean();
	//Write html content.
	$cacheHTML = $HTMLfolder."/{$result['url_title']}.html"; 
	$fp = fopen($cacheHTML, "wb");
	fwrite($fp, $content, strlen($content));
	fclose($fp);
	/********END WRITE VIDEO PAGE HTML*************/
	echo "<li><a href='".DOMAIN.urlFix($result['category'])."/{$result['url_title']}.html' target='_blank' >{$result['title']}</a></li>";
}
?>