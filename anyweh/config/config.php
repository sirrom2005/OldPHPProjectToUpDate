<?php
###################################SQL CONNECTION#############################################
	error_reporting(1); // when you finish testing you should change this to E_NONE

	define("RM_DBUSERNAME", "root",  true);
	define("RM_DBPASSWORD", "",  true);
	define("RM_DBHOST", "localhost", true);
	define("RM_DBDATABASE", "anyweh",  true);
	
	define("EMAIL_ADDRESS", "anywehdotcom@gmail.com", true); 
############################################################################################## 
	define("URL_PATH", $_SERVER['DOCUMENT_ROOT']."/", true);
	
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
	define("META_KEY", "anyweh, events, party, parties, goout, club, dance, sessions, fashionista, ochi, negril, mas camp", true);
	define("META_DESC", "anyweh.com party and photo gallery, anyweh events, anyweh party, parties pictures, photo gallery, party videos, fashionista for week, snapshot of the week, news and information", true);
###############################################################################################

	$showFlashBanner = true; // show or hide flash banner
	$showFlashMenu   = false; // show or hide flash menu
	$tmpFolder 		= URL_PATH."tmp_images/";
	$imageFolder	= URL_PATH."gallery/albums/";
	$galleryDomain 	= DOMAIN."gallery/index.php?album=";
?>