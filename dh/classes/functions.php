<?php
	function ceo_url_string($str)
	{
		$str = strtolower($str);
		$str = str_replace(" ", "_", $str);
		$str = preg_replace("/[^a-z0-9_]/i", "", $str);
		return $str;
	}	
	
	function url_string_encode_for_category_class($str)
	{
		$str = explode("::", $str);
		$str = $str[1];
		$str = str_replace("&", "and", $str);
		$str = ceo_url_string($str);
		return $str;
	}
	
	function preFixString($str)
	{
		$str = trim($str);
		//$str = addslashes($str);
		$str = htmlentities($str);
		//$str = strip_tags($str);
		return $str;
	}
	
	function cleanText($str)
	{
		$str = trim($str);
		$str = stripslashes($str);
		$str = strip_tags($str);
		return $str;
	}
	
	function cleanString($str, $len=NULL)
	{	
		$str = trim($str);
		$str = stripslashes($str);
		$str = strip_tags($str, "<a>, <b>, <strong>");
		if(!empty($len))
		{
			$a = explode(' ', $str); 
			$str = implode(' ', array_slice($a,0,$len));
		}
		return $str;
	}
	
	function cleanXmlString($str)
	{	
		/* format string from PAD xml file*/
		$str = strip_tags($str, "<a>, <b>, <strong>");
		$str = trim($str);
		$str = stripslashes($str);
		$str = str_replace("\n", "<br>", $str);		
		return $str;
	}
	
	function keyWordsFornat($str)
	{	
		$str = cleanText($str);
		/* format keywords from PAD xml file*/
		$str = explode(",", $str);
		$ouput = "";
		foreach( $str as $key => $value )
		{
			if(!empty($value))
			{
				$ouput .= "&bull;<a href='".DOMAIN."search.php?keyword=".trim($value)."'>$value</a> ";
			}
		}
		echo $ouput;
	}

	function osFornat($str)
	{	
		$str = cleanText($str);
		/* format OS from PAD xml file*/
		$str = explode(",", $str);
		$ouput = "";
		foreach( $str as $key => $value )
		{
			if(!empty($value))
			{
				$ouput .= "$value ";
			}
		}
		echo $ouput;
	}

	function cleanHtml($str)
	{
		$str = stripslashes($str);
		$str = trim($str);
		$str = strip_tags($str, "<a>, <b>, <strong>, <center>, <i>, <em>, <u>, <ul>, <li>, <ol>, <img>, <p>, <br>, <div>, <span>, <form>, <input>, <textarea>");
		return $str;
	}
	
	function ceo_url($str)
	{
		$str = stripslashes($str);
		$str = trim($str);
		$str = strtolower($str);
		$str = str_replace(" ", "_", $str);
		$str = urlencode($str);
		return $str;
	}
	
	function fileExists($file)
	{
		if( is_file($file) )
			return true;
		return false;
	}
?>