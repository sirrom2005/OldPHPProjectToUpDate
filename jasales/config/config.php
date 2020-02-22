<?php
###################################SQL CONNECTION#############################################
	session_start();
	error_reporting(E_ALL); // when you finish testing you should change this to E_NONE
	define("DBUSERNAME", "root",  true);
	define("DBPASSWORD", "" ,     true);
	define("DBHOST", "localhost", true);
	define("DBDATABASE", "bbpinworld",  true); 
##############################################################################################
	define("DOMAIN", "http://127.0.0.1/jasales/",  true);	
	define("DOCROOT", $_SERVER['DOCUMENT_ROOT'].'jasales/',  true);	
	define("SITE_EMAIL", "admin@somewhere.com",  true);

	include_once(DOCROOT."languages/en.php");
	require_once DOCROOT.'classes/mobile_detect/Mobile_Detect.php';
	$detect = new Mobile_Detect();
	$layout = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'mobile') : 'desktop');
?>