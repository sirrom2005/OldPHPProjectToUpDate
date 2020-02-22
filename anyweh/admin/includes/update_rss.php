<?
	$latestEvents     = $eventsObj->getLatestEvent(20);
	
	$url = DOMAIN;

	$eventsFeed = "";
	if(!empty($latestEvents))
	{
		foreach( $latestEvents as $row )
		{
			$eventsFeed .= "<item>\n";
			$eventsFeed .= "\t<title>".cleanString($row['title'])." - ".date("l, F d Y.", strtotime($row['date']))."</title>\n";
			$eventsFeed .= "\t<link>".$url."includes/event_win.php?id={$row[id]}.html</link>\n";
			$eventsFeed .= "\t<description><![CDATA[".cleanRssString($row['intro_text'])."]]></description>\n";
			$eventsFeed .= "</item>\n";
		}
	}
	
	function rssBase($title, $rssFeed, $file)
	{
		global $url;
		$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$content .= "<rss version=\"2.0\">\n";
		$content .= "<channel>\n";
		$content .= "<title>www.anyweh.com - $title</title>\n";
		$content .= "<link>".$url."</link>\n";
		$content .= "<description>www.anyweh.com - $title</description>\n";
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
	
   	rssBase("Calendar Events feed.", $eventsFeed, "events.rss");
?>