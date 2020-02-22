<?php
###################################SQL CONNECTION#############################################
	error_reporting(E_ALL); // when you finish testing you should change this to E_NONE

	define("DBUSERNAME", "root",  true);
	define("DBPASSWORD", "" ,     true);
	define("DBHOST", "localhost", true);
	define("DBDATABASE", "mp3",  true); 
##############################################################################################
	define("DOMAIN", "http://127.0.0.1/mp3/",  true); 
	define("URL_PATH", $_SERVER['DOCUMENT_ROOT']."mp3/",  true); 
	define("UPLOADDIR", "c:\wamp\www\mp3\mp3store/",  true); 
	define("MP3LOCATION", "http://127.0.0.1/mp3/mp3store/",  true); 
	define("FFMPEG_SCRIPT_PATH", "C:/wamp/bin/",  true); 
	
	define("ARTISTE_IMG_PATH", URL_PATH."images/artise/", true);
	define("ARTISTE_IMG_URL",  DOMAIN."images/artise/", true);
	define("ARTISTE_THUM_FOLDER",  "images/artise/", true);
	define("ARTISTE_SML_TMB",  49, true);
	define("ARTISTE_MED_TMB",  200, true);
	define("ARTISTE_LRG_TMB",  250, true);
?>