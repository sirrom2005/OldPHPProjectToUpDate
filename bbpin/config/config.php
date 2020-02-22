<?php
###################################SQL CONNECTION#############################################
	session_start();
	error_reporting(E_ALL); // when you finish testing you should change this to E_NONE
	define("DBUSERNAME", "root",  true);
	define("DBPASSWORD", "" ,     true);
	define("DBHOST", "localhost", true);
	define("DBDATABASE", "bbpinworld",  true); 
	
	/*define("DBUSERNAME","sirrom",true);
	define("DBPASSWORD","tyrone",true);
	define("DBHOST", "instance4886.db.xeround.com.:3881", true);*/
##############################################################################################
	define("DOMAIN", 'http://'.$_SERVER['HTTP_HOST']."/bbpin2/",  true);	
	define("DOCROOT", $_SERVER['DOCUMENT_ROOT'].'/bbpin2/',  true);	
	define("PORFILEPHOTO", "bbpin2/images/profile/",  true);	
	define("SITE_NAME", "jusbbmpins.com",  true);
	define("SITE_EMAIL", "admin@somewhere.com",  true);

	$lang = isset($_COOKIE['bbm_language'])? $_COOKIE['bbm_language'] : 'en';
	require_once DOCROOT.'classes/mobile_detect/Mobile_Detect.php';
	$detect = new Mobile_Detect();
	$layout = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');
?>