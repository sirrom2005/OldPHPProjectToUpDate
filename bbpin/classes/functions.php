<?php
	function cleanText($str)
	{
		$str = trim($str);
		return $str;
	}
	
	function isValidEmail($email){ return @eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email); }
	
	function isValidPin($pin){ return @eregi("^[abcdef0-9]{8}$", $pin); }
	
	function cleanString($str)
	{	
		$str = trim($str);
		$str = addslashes($str);
		$str = strip_tags($str);
		return $str;
	}

	function cleanHtml($str)
	{
		$str = trim($str);
		//$str = stripcslashes($str);
		$str = html_entity_decode($str); 
		$str = strip_tags($str, "<a>,<b>,<strong>,<br>,<p>,<small>");
		return $str;
	}
?>