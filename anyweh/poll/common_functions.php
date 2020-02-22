<?php

function escape_data ($data) {
	global $dbc;
	$data = htmlentities($data);
	if (get_magic_quotes_gpc()) {
		$data = stripslashes($data);
		}
	return mysql_real_escape_string(trim($data),$dbc);
}	

function strip_slashes($string) {
    if(get_magic_quotes_gpc()) {
        return stripslashes($string);
    } else {
        return $string;
    }
}

function make_safe($variable) {
$variable = addslashes(trim($variable));
return $variable;
} 
		
function datetime($YYYYMMDDHHMMSS,$format) {
   $search = array(":"," ","-");
   $YYYYMMDDHHMMSS = str_replace($search,"",$YYYYMMDDHHMMSS);
   list($year,$month,$day,$hour,$minute,$seconds) = sscanf($YYYYMMDDHHMMSS,'%4s%2s%2s%2s%2s%2s');
   return date($format, mktime($hour,$minute,$seconds,$month,$day,$year));
}	
?>