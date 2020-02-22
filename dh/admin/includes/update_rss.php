<?php
	include_once("../classes/user.class.php");
	include_once("../js/FCKeditor/fckeditor.php" );
	include_once("../classes/software.class.php");


	$softobj = new software();
	
	$xmlfeed = $softobj->getLatestSoftware(20);
	
	$feed = "";
	if(!empty($xmlfeed))
	{
		foreach( $xmlfeed as $row )
		{
			$feed .= "<item>\n";
			$feed .= "\t<title>".cleanString($row['title'])."</title>\n";
			$feed .= "\t<link>http://downloadhours.com/software/{$row['ceo_url_category']}/{$row['url_title']}.html</link>\n";
			$feed .= "\t<description>". htmlspecialchars(cleanString($row['app_summary']))."</description>\n";
			$feed .= "</item>\n";
		}
	}
	
	function rssBase($title, $rssFeed, $file)
	{
		global $url;
		$content = "<?xml version=\"1.0\"?>\n";
		$content .= "<rss version=\"2.0\">\n";
		$content .= "<channel>\n";
		$content .= "<title>Downloadhours.com software feed</title>\n";
		$content .= "<link>www.downloadhours.com</link>\n";
		$content .= "<description>downloadhours.com best download websites.</description>\n";
		$content .= "$rssFeed";
		$content .= "</channel>\n";
		$content .= "</rss>\n";
		
		$handle = fopen("../$file", 'w');
		if(fwrite($handle, $content) === FALSE)
		{
			echo "Rss Write failed";
		}
		fclose($handle);
	}

	rssBase("News feed.", $feed, "rss.xml");
?>