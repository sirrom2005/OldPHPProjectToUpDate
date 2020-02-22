<?php	
	function cleanString($str, $len=NULL)
	{
		$str = trim($str);
		$str = stripslashes($str);
		$str = strip_tags($str, "<a>");
		if(!empty($len))
		{
			$a = explode(' ', $str); 
			$str = implode(' ', array_slice($a,0,$len));
		}
		return $str;
	}
	
	function cleanHTML($str)
	{
		$str = trim($str);
		$str = stripslashes($str);
		$str = strip_tags($str, "<a>, <img>, <p>, <br>, <b>, <strong>, <i>, <ul>, <sub>, <sup>, <ol>, <ul>");
		return $str;
	}
	
	function textBoxFix($str)
	{
		$str = stripslashes($str);
		$str = htmlspecialchars($str);
		return $str;
	}
	
	function formateTags($str, $limit=10)
	{
		$str = strtolower(cleanString($str));
		$str = explode(",", $str);
		$keywords = "";
		if(!empty($str))
		{
			$i=0;
			foreach($str as $key => $value)
			{
				if($i == $limit){break;}
				$value = trim($value);
				if(strlen($value) >= 3)
				{
					$keywords .= "<a href='".DOMAIN."video_tags/".urlFix($value).".html' title=\"$value\" class=\"tags\" target='_top' >$value</a> ";
				}
				$i++;
			}
		}
		return $keywords;
	}
	
	function urlFix($str)
	{
		$str = trim($str);
		$str = strtolower(str_replace(" ", "_",$str));
		return $str;
	}
	
	function urlUnFix($str)
	{
		$str = strtolower(str_replace("_", " ",$str));
		return $str;
	}
	
	function cleanText($str)
	{
		$str = strip_tags($str);
		$str = preg_replace('([^a-zA-Z0-9_, ])', '', $str);
		return $str;
	}
	
	function smallVideoList($data)
	{
		echo "<ul class='small_video'>";
		if(!empty($data))
        {
			foreach($data as $row)
			{
				$url = (empty($row['explicit']))? DOMAIN.urlFix($row['category'])."/{$row['url_title']}.html" : DOMAIN."restricted/".base64_encode($row['video'])."/index.html";
				echo "<li>
						<a href='$url' title=\"".cleanText($row['title'])."\"><img src='/videos/{$row['video']}/thumbnail1.jpg' alt='".cleanText(strtolower($row['title']))."' /></a>
						<h2><a href='$url' title=\"".cleanText($row['title'])."\">".substr($row['title'], 0, 44)."</a></h2>
					 </li>";
			}
			echo "</ul><br class='clearleft'>";
		}
	}
	function largeVideoList($data)
	{
		echo "<ul class='featured_video'>";
		$i=0;
		if(!empty($data))
        {
			foreach($data as $row)
			{	$i++;
				$noStyle = ($i%3==0)? "noStyle" : "";
				$url = (empty($row['explicit']))? DOMAIN.urlFix($row['category'])."/{$row['url_title']}.html" : DOMAIN."restricted/".base64_encode($row['video'])."/index.html";
				echo "<li class='$noStyle'>
						<a href='$url' title='".cleanText(strtolower($row['title']))."'><img src='/videos/{$row['video']}/thumbnail1med.jpg' width='213' alt='image of ".cleanText(strtolower($row['title']))."' /></a>
						<font><h2><a href='$url' title='".cleanText(strtolower($row['title']))."'>".substr($row['title'], 0, 44)."</a></h2></font>
					 </li>";
			}
			echo "</ul><br class='clearleft'>";
		}
	}
	function mediumVideoList($data)
	{
		echo "<ul class='latest_video'>";
		$i=0;
		if(!empty($data))
        {
			foreach($data as $row)
			{
				$i++;
				$noStyle = ($i%2==0)? "noStyle" : "";
				$tags = formateTags($row['tags'], 3);
				$duration = "";
				if(!empty($row['duration']))
				{
					$duration = substr($row['duration'],3,5);
					$duration = "<b title='video duration'>$duration</b> | ";
				}
				$url = (empty($row['explicit']))? DOMAIN.urlFix($row['category'])."/{$row['url_title']}.html" : DOMAIN."restricted/".base64_encode($row['video'])."/index.html";
				
				echo "<li class='$noStyle'><h2><a href='$url' title=\"".cleanText($row['title'])."\">".substr($row['title'], 0, 42)."...</a></h2>
						<a href='$url' title='".cleanText(strtolower($row['title']))."'><img src='/videos/{$row['video']}/thumbnail1sml.jpg' alt='image of ".cleanText(strtolower($row['title']))."' /></a>
						<font><b></b></font>
						<font class='tags'>$tags</font>
						<font>{$duration}views: {$row['viewed']}</font>
						<font>Added: ".date("M-d-y", strtotime($row['date_added']))." by <a href='".DOMAIN."{$row['username']}.htm'>{$row['username']}</a></font>
						<font><a href='$url#disqus_thread'>&nbsp;</a></font>
					 </li>";
			}
			echo "</ul><br class='clearleft'>";
		}
	}
?>