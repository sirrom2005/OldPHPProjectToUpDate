<?php
	function cleanString($str)
	{	
		$str = trim($str);
		$str = stripslashes($str);
		$str = strip_tags($str, "<a>, <b>, <strong>");
		return $str;
	}

	function cleanHTML($str)
	{
		$str = trim($str);
		$str = stripcslashes($str);
		$str = html_entity_decode($str); 
		$str = strip_tags($str, "<a>, <b>, <strong>, <center>, <i>, <em>, <u>, <ul>, <li>, <ol>, <img>, <p>, <br>, <div>, <span>, <form>, <input>, <textarea>");
		return $str;
	}
?>