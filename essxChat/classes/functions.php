<?php
	function cleanText($str)
	{
		$str = trim($str);
		return $str;
	}
	
	function isValidEmail($email){
		return @eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
	}
	
	function cleanString($str, $len=NULL)
	{	
		$str = trim($str);
		$str = stripslashes($str);
		$str = strip_tags($str);
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