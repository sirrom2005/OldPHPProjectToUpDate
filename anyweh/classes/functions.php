<?php
	
	function preFixString($str)
	{
		$str = trim($str);
		$str = addslashes($str);
		$str = htmlentities($str);
		$str = strip_tags($str);
		return $str;
	}
	
	function cleanRssString($str)
	{
		$str = trim($str);
		$str = stripslashes($str);
		$str = str_replace("\n", "", $str);
		$str = str_replace("\r", "", $str);
		return $str;
	}

	function cleanString($str, $len=NULL)
	{
		$str = trim($str);
		$str = stripslashes($str);
		$str = str_replace("[/caption]", "", $str);
		$str = str_replace("]", "/>", $str);
		$str = str_replace("[caption", "<img", $str);
		$str = strip_tags($str);
		if(!empty($len))
		{
			$a = explode(' ', $str); 
			$str = implode(' ', array_slice($a,0,$len));
			//$str = substr($str, 0, $len);
		}
		return $str;
	}
	
	function pageKeywords($str)
	{
		$str = strtolower(cleanString($str));
		$str = explode(" ", preg_replace("/[^a-z0-9. ]/i", "", $str));
		
		$keywords = "";
		if(!empty($str))
		{
			foreach($str as $row)
			{
				if(strlen($row) >= 3)
				{
					$keywords .= $row.", ";
				}
			}
		}
		return $keywords;
	}
	
	function cleanText($str)
	{
		$str = trim($str);
		$str = str_replace("\n", "<br>", $str);
		$str = stripslashes($str);
		return $str;
	}

	function removeHtmlTags($str)
	{
		$str = trim($str);
		$str = addslashes($str);
		$str = strip_tags($str);
		return $str;
	}
	
	function fileExists($file)
	{
		if( is_file($file) )
			return true;
		return false;
	}

	function img_attr($text)
	{
		preg_match_all('/<[^>]+>/s',$text,$tags);
	
		foreach (array("img") as $starter) {
		   foreach ($tags[0] as $link) {
				   $gotten = preg_match('/^<\s*'.$starter.'\s*(.*)>/i',$link,$alist);
				   if ($gotten) {
						   //print "<b>$alist[1]</b><br />";
						   $cleaned = preg_replace('/\s+=\s+/','=',$alist[1]);
						   preg_match_all('/(?:^|\s)(\w+)="([^">]+)"/',$cleaned,$qatts);
						   preg_match_all('/(?:^|\s)(\w+)=([^"\s>]+)/',$cleaned,$patts);
						   $allatts = array_merge($patts[1],$qatts[1]);
						   $allvals = array_merge($patts[2],$qatts[2]);
						   
				  
					  	for($k=0; $k<count($allatts); $k++) {
								  //  print ("$k $allatts[$k] = $allvals[$k]<br />");
						}
				
					}
			}
		}
		
		$src = NULL;
		for($k=0; $k<count($allatts); $k++) 
		{
			if( $allatts[$k] == "src" )
			{ 
				$src = $allvals[$k];
				break;
			}
		}
	
		return $src;
	}
?>