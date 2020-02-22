<?php
$rs = printRotatingBannerList();
header ("Content-type: text/xml");
echo ("<?xml version=\"1.0\" encoding=\"utf-8\"?>\n");
echo '<playlist version="1" xmlns="http://xspf.org/ns/0/">'."\n";
echo "<trackList>\n"; 
if(!empty($rs))
{
	foreach($rs as $key => $value)
	{
		echo "\t<track>";
		echo "\t\t<title>".strip_tags($value['title'])."</title>";
		echo "\t\t<creator>Partyaad.com</creator>";
		echo "\t\t\t<location>albums/".$value['folder'].'/'.urlencode($value['filename'])."</location>";
		echo "\t\t<info></info>";
		echo "\t</track>"; 
	}
}       
echo "</trackList>\n";
echo "</playlist>";
?>
