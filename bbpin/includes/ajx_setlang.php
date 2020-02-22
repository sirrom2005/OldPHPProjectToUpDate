<?php
/*~~SET Language~~*/
if(isset($_GET['l'])){ 	
	$l = array('en','es','fr');
	if(in_array($_GET['l'],$l)){ 
		setcookie('bbm_language',$_GET['l'],time()+60*60*24*30,'/');
	}
}
$loc = (isset($_SERVER['HTTP_REFERER']))? $_SERVER['HTTP_REFERER'] : '../index.php';
header('location: '.$loc);
?>