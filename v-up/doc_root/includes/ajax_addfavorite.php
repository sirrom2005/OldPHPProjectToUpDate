<?php
session_start(); 
if(empty($_SESSION['ADMIN_USER'])){
	echo "<span class='err'>You need to <a href='/vci/'>login</a> first...</span>";
}
else
{
	include_once("../config/config.php");
	include_once("../classes/mySqlDB__.class.php");
	include_once("../classes/site.class.php");
	$obj = new site();
	$data['user_id']  = $_SESSION['ADMIN_USER']['id'];
	$data['video_id'] = $_GET['id'];
	if($obj->addFavorites($data))
	{
		echo "<span class='msg'>Video added to your favorite list...</span>";
	}
	else
	{
		echo "<span class='err'>You already have this video in your favorite list...</span>";
	}
}
?>