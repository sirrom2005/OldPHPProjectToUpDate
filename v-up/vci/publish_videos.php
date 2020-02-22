<?php 
session_start();
if(empty($_SESSION['ADMIN_USER'])){header("location: ../login.html");}
include_once("../config/config.php");
include_once("../classes/mySqlDB__.class.php");
include_once("../classes/site.class.php");

/***********WRITE VIDEO PAGE HTML******************/
$id 		= $_GET['id'];
$obj 		= new site();  
$category 	= $obj->getCategory();
$videoTags 	= $obj->getVideoTags();
$result   	= $obj->getVideoRecord($id, true);
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
include_once("../templates/video.html");
$content = ob_get_contents();
ob_end_clean();
//Write html content.
$cacheHTML = $HTMLfolder."/{$result['url_title']}.html"; 
$fp = fopen($cacheHTML, "wb");
fwrite($fp, $content, strlen($content));
/********END WRITE VIDEO PAGE HTML*************/

/***********WRITE USER XML FILE***************/
$latestUser = $obj->getUserVideoList($result['user_id'], 20);
$xmlStr = "";
if(!empty($latestUser))
{
	foreach($latestUser as $row)
	{
		$url = (empty($row['explicit']))? DOMAIN.urlFix($result['category'])."/{$row['url_title']}.html" : DOMAIN."restricted/".base64_encode($row['video'])."/index.html";
		$description = cleanString($row['description']);
		$description = str_replace("\"", "'",$description);
		$description = str_replace("\n", "" ,$description);
		$description = str_replace("\r", "" ,$description);
		$description = stripslashes($description);
		$xmlStr .= "<item>\n";
		$xmlStr .= "\t<title>".htmlspecialchars($row['title'])."</title>\n";
		$xmlStr .= "\t<link>$url</link>\n";
		$xmlStr .= "\t<linkcode>{$row['video']}</linkcode>\n";
		$xmlStr .= "\t<description><![CDATA[".htmlspecialchars($description)."]]></description>\n";
		$xmlStr .= "</item>\r";
	}
}
ob_start();
include_once("../users/xml_temp.xml");
$xmlContent = ob_get_contents();
ob_end_clean();

$xmlContent = str_replace("TMP_XML_VER","<?xml version=\"1.0\" encoding=\"UTF-8\"?>",$xmlContent);
$xmlContent = str_replace("TMP_XML_LIST",$xmlStr,$xmlContent);
$xmlContent = str_replace("TMP_USER_NAME",$latestUser[0]['username'],$xmlContent);

$fp = fopen("../users/{$result['user_id']}.xml", "wb");
fwrite($fp, $xmlContent, strlen($xmlContent));
/***********END WRITE USER XML FILE***********/

/***********WRITE MAIN XML FILE***************/
$latestUser = $obj->getLatestVideo(100);
$xmlStr = "";
if(!empty($latestUser))
{
	foreach($latestUser as $row)
	{
		$url = (empty($row['explicit']))? DOMAIN.urlFix($result['category'])."/{$row['url_title']}.html" : DOMAIN."restricted/".base64_encode($row['video'])."/index.html";
		$description = cleanString($row['description']);
		$description = str_replace("\"", "'",$description);
		$description = str_replace("\n", "" ,$description);
		$description = str_replace("\r", "" ,$description);
		$description = stripslashes($description);
		$xmlStr .= "<item>\n";
		$xmlStr .= "\t<title>".htmlspecialchars($row['title'])."</title>\n";
		$xmlStr .= "\t<link>$url</link>\n";
		$xmlStr .= "\t<pubDate>".date("l, F j Y", strtotime($row['date_added']))."</pubDate>\n";
		$xmlStr .= "\t<linkcode>{$row['video']}</linkcode>\n";
		$xmlStr .= "\t<description><![CDATA[".htmlspecialchars($description)."]]></description>\n";
		$xmlStr .= "</item>\r";
	}
}
ob_start();
include_once("../users/main_temp.xml");
$xmlContent = ob_get_contents();
ob_end_clean();

$xmlContent = str_replace("TMP_XML_VER","<?xml version=\"1.0\" encoding=\"UTF-8\"?>",$xmlContent);
$xmlContent = str_replace("TMP_XML_LIST",$xmlStr,$xmlContent);

$fp = fopen("../rss.xml", "wb");
fwrite($fp, $xmlContent, strlen($xmlContent));
/***********END WRITE MAIN XML FILE***********/

/***********WRITE XML SITEMAP***************/
##################TAGS#######################
$videoTagList = $obj->getVideoTags(2000);
$pTaglist 	= "";
$pTag 		= "";
if(!empty($videoTagList))
{
	foreach($videoTagList as $row)
	{
		$pTaglist .= $row['tags'].",";
	
	}
	$pTaglist = explode(",", $pTaglist);  
	$pTaglist = array_unique($pTaglist); 
}
##################TAGS#######################
$xmlStr = "";
$category 	= $obj->getCategory();
foreach($category as $cat)
{
	$catLink = urlFix($cat['category'])."/";
	getSiteMapList($catLink);
	$categoryList = $obj->getVideoByCategory(str_replace("_", " ", $cat['category']),20);
	if(!empty($categoryList))
	{
		foreach($categoryList as $row)
		{
			$videoLink = urlFix($catLink).$row['url_title'].".html";
			getSiteMapList($videoLink);
		}
	}
}

foreach($pTaglist as $key => $value)
{ 
	$tagLink = "video_tags/".urlFix($value).".html";
    getSiteMapList($tagLink);      
} 

function getSiteMapList($str)
{
	global $xmlStr;
	if(!empty($str))
	{
		$xmlStr .= "<url>\n";
		$xmlStr .= "\t<loc>".DOMAIN."$str</loc>\n";
		$xmlStr .= "</url>\n";
	}
}

ob_start();
include_once("../users/sitemap_temp.xml");
$xmlContent = ob_get_contents();
ob_end_clean();

$xmlContent = str_replace("TMP_XML_VER","<?xml version=\"1.0\" encoding=\"UTF-8\"?>",$xmlContent);
$xmlContent = str_replace("SITE_LIST",$xmlStr,$xmlContent);

$fp = fopen("../sitemap.xml", "wb");
fwrite($fp, $xmlContent, strlen($xmlContent));
/***********END WRITE XML SITEMAP***********/
fclose($fp);
header("location: index.php?action=my_videos");
?>