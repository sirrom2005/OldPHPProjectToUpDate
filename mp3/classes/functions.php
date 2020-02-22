<?php
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
	function textBoxFix($str)
	{
		$str = trim($str);
		$str = stripslashes($str);
		$str = htmlspecialchars($str);
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
				$ouput .= "&bull;<a>$value</a> ";
			}
		}
		echo $ouput;
	}
	function cleanHtml($str)
	{
		$str = trim($str);
		$str = stripcslashes($str);
		$str = html_entity_decode($str); 
		$str = strip_tags($str, "<a>, <b>, <strong>, <center>, <i>, <em>, <u>, <ul>, <li>, <ol>, <img>, <p>, <br>, <div>, <span>, <form>, <input>, <textarea>");
		return $str;
	}
?>