<?php
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
		foreach($pTaglist as $key => $value)
		{
			$pTag .= $value.",";
		}
	}	
	$pageKeywords	 	= "video tags, keyword page, top video tags, jamaica";
	$pageDescription 	= "video tag page show all the keywords for all videos on videouploader.net";
?>
<h1>Video tags</h1>
<div id="popular_tags"><?php echo formateTags($pTag, 1000);?></div>