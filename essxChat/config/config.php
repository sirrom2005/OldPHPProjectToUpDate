<?php
###################################SQL CONNECTION#############################################
	session_start();
	error_reporting(E_ALL); // when you finish testing you should change this to E_NONE
	define("DBUSERNAME", "root",  true);
	define("DBPASSWORD", "" ,     true);
	define("DBHOST", "localhost", true);
	define("DBDATABASE", "sex_chat",  true); 
##############################################################################################
	define("DOMAIN", "http://127.0.0.1/sexChat/",  true);	
	define("PORFILEPHOTO", "sexChat/images/profile/",  true);	
	define("SITE_NAME", "sChat Online",  true);
	define("SITE_EMAIL", "admin@somewhere.com",  true);
?>