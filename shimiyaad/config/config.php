<?php
###################################SQL CONNECTION#############################################
	session_start();
	error_reporting(E_ALL); // when you finish testing you should change this to E_NONE
	define("DBUSERNAME", "root",  true);
	define("DBPASSWORD", "" ,     true);
	define("DBHOST", "localhost", true);
	define("DBDATABASE", "fimiyaad",  true); 
##############################################################################################
	define("DOMAIN", 'http://'.$_SERVER['HTTP_HOST']."/shimiyaad/",  true);	
	define("DOCROOT", $_SERVER['DOCUMENT_ROOT'].'shimiyaad/',  true);
	define("CLASSIFIEDPHOTO", "shimiyaad/images/content/classified/",  true);
	define("EVENTSPHOTO", "shimiyaad/images/content/events/",  true);
	define("NEWSFOLDER", "shimiyaad/images/content/news/",  true);		
	define("SITE_NAME", "FIMIYAAD.COM",  true);
	define("SITE_EMAIL", "fimiyaad@gmail.com",  true);
	define("NEEDTOLOGIN", "To view this area <a href='".DOMAIN."includes/login.php' rel='facebox'>click</a> here to login...",  true);
?>