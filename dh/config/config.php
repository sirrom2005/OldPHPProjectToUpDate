<?php
###################################SQL CONNECTION#############################################
	session_start();
	error_reporting(3); // when you finish testing you should change this to E_NONE

	/*define("DBUSERNAME", "shahidah_dh",  true);
	define("DBPASSWORD", "sritaman107" ,     true);
	define("DBHOST", "174.120.169.158", true);
	define("DBDATABASE", "shahidah_dh",  true);*/
	define("DBUSERNAME", "root",  true);
	define("DBPASSWORD", "" ,     true);
	define("DBHOST", "localhost", true);
	define("DBDATABASE", "dh",  true);
	define("EMAIL_ADDRESS", "sirrom2005@gmail.com", true); 
##############################################################################################
	define("DOMAIN", "http://".$_SERVER['SERVER_NAME']."/dh/", true); 
	define("URL_PATH", "C:/wamp/www/dh/", true);
	
	
	define("NEWS_IMG_PATH", URL_PATH."images/news/", true);
	define("NEWS_IMG_URL",  DOMAIN."images/news/", true);
	define("NEWS_THUM_FOLDER",  "images/news/", true);
	
	define("EVENTS_IMG_PATH", URL_PATH."images/events/", true);
	define("EVENTS_IMG_URL",  DOMAIN."images/events/", true);
	define("EVENTS_THUM_FOLDER",  "images/events/", true);
	
	define("BANNER_IMG_PATH", URL_PATH."images/banners/", true);
	define("BANNER_IMG_URL",  DOMAIN."images/banners/", true);
	define("BANNER_THUM_FOLDER",  "images/banners/", true);	
###############################################################################################
	$META_KEY  = "windows, mac, linux, mobile, pda, wallpaper,software, online file storage";
	$META_DESC = "One of the best download websites in the world for Windows, download site, Mac, Linux, Mobile and PDA software., online file storage";
###############################################################################################

	function logMemberActions()
	{		
		$action = $_SERVER['REQUEST_URI'];
		$time   = date("h:i:s a");
		$str    = $_SESSION['account_user']['id'].",".$_SESSION['account_user']['user_name'].",$time,$action\n";
		$str2   = $str;
		$filename = "member_".date("Ymd").".csv";
		
		if(!file_exists(URL_PATH."admin/logs/$filename"))
		{
			$hder = "USER ID,USERNAME,TIME,PAGE VIEWED\n";
			$str  = $hder.$str;
		}
		
		$f = fopen(URL_PATH."admin/logs/$filename", "a");
		fwrite($f, $str, strlen($str));
		fclose($f);
		
		/*FULL LOG*/	
		$ff = fopen(URL_PATH."admin/logs/memberlogs.csv", "a");
		fwrite($ff, $str2, strlen($str2));
		fclose($ff);
	}
?>