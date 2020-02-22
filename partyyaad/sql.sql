/*
SQLyog Community v8.4 RC2
MySQL - 5.5.20-log : Database - partyyaad
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`partyyaad` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `partyyaad`;

/*Table structure for table `partyyaad_admin_to_object` */

DROP TABLE IF EXISTS `partyyaad_admin_to_object`;

CREATE TABLE `partyyaad_admin_to_object` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `adminid` int(11) unsigned NOT NULL,
  `objectid` int(11) unsigned NOT NULL,
  `type` varchar(32) COLLATE utf8_unicode_ci DEFAULT 'album',
  `edit` int(11) DEFAULT '32767',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_admin_to_object` */

LOCK TABLES `partyyaad_admin_to_object` WRITE;

UNLOCK TABLES;

/*Table structure for table `partyyaad_administrators` */

DROP TABLE IF EXISTS `partyyaad_administrators`;

CREATE TABLE `partyyaad_administrators` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `pass` text COLLATE utf8_unicode_ci,
  `name` text COLLATE utf8_unicode_ci,
  `email` text COLLATE utf8_unicode_ci,
  `rights` int(11) DEFAULT NULL,
  `custom_data` text COLLATE utf8_unicode_ci,
  `valid` int(1) DEFAULT '1',
  `group` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `loggedin` datetime DEFAULT NULL,
  `lastloggedin` datetime DEFAULT NULL,
  `quota` int(11) DEFAULT NULL,
  `language` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `prime_album` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `other_credentials` text COLLATE utf8_unicode_ci,
  `challenge_phrase` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `valid` (`valid`,`user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_administrators` */

LOCK TABLES `partyyaad_administrators` WRITE;

insert  into `partyyaad_administrators`(`id`,`user`,`pass`,`name`,`email`,`rights`,`custom_data`,`valid`,`group`,`date`,`loggedin`,`lastloggedin`,`quota`,`language`,`prime_album`,`other_credentials`,`challenge_phrase`) values (1,'administrators',NULL,'group',NULL,1961343989,'Users with full privileges',0,NULL,'2012-02-09 18:49:12',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'viewers',NULL,'group',NULL,2945,'Users allowed only to view zenphoto objects',0,NULL,'2012-02-09 18:49:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'bozos',NULL,'group',NULL,0,'Banned users',0,NULL,'2012-02-09 18:49:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'album managers',NULL,'template',NULL,67386245,'Managers of one or more albums',0,NULL,'2012-02-09 18:49:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,'default',NULL,'template',NULL,945,'Default user settings',0,NULL,'2012-02-09 18:49:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,'newuser',NULL,'template',NULL,1,'Newly registered and verified users',0,NULL,'2012-02-09 18:49:13',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(7,'admin','f23217ebc069bc2453d3c959e890ee57386879de',NULL,NULL,1961343989,NULL,1,NULL,'2012-02-09 18:51:46','2012-02-09 18:52:05',NULL,NULL,NULL,NULL,NULL,NULL);

UNLOCK TABLES;

/*Table structure for table `partyyaad_albums` */

DROP TABLE IF EXISTS `partyyaad_albums`;

CREATE TABLE `partyyaad_albums` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) unsigned DEFAULT NULL,
  `folder` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` text COLLATE utf8_unicode_ci,
  `desc` text COLLATE utf8_unicode_ci,
  `date` datetime DEFAULT NULL,
  `updateddate` datetime DEFAULT NULL,
  `location` text COLLATE utf8_unicode_ci,
  `show` int(1) unsigned NOT NULL DEFAULT '1',
  `closecomments` int(1) unsigned NOT NULL DEFAULT '0',
  `commentson` int(1) unsigned NOT NULL DEFAULT '1',
  `thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mtime` int(32) DEFAULT NULL,
  `sort_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `subalbum_sort_type` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sort_order` int(11) unsigned DEFAULT NULL,
  `image_sortdirection` int(1) unsigned DEFAULT '0',
  `album_sortdirection` int(1) unsigned DEFAULT '0',
  `hitcounter` int(11) unsigned DEFAULT '0',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password_hint` text COLLATE utf8_unicode_ci,
  `publishdate` datetime DEFAULT NULL,
  `expiredate` datetime DEFAULT NULL,
  `total_value` int(11) DEFAULT '0',
  `total_votes` int(11) DEFAULT '0',
  `used_ips` longtext COLLATE utf8_unicode_ci,
  `custom_data` text COLLATE utf8_unicode_ci,
  `dynamic` int(1) DEFAULT '0',
  `search_params` text COLLATE utf8_unicode_ci,
  `album_theme` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `rating_status` int(1) DEFAULT '3',
  `watermark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `watermark_thumb` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codeblock` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `folder` (`folder`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_albums` */

LOCK TABLES `partyyaad_albums` WRITE;

insert  into `partyyaad_albums`(`id`,`parentid`,`folder`,`title`,`desc`,`date`,`updateddate`,`location`,`show`,`closecomments`,`commentson`,`thumb`,`mtime`,`sort_type`,`subalbum_sort_type`,`sort_order`,`image_sortdirection`,`album_sortdirection`,`hitcounter`,`password`,`password_hint`,`publishdate`,`expiredate`,`total_value`,`total_votes`,`used_ips`,`custom_data`,`dynamic`,`search_params`,`album_theme`,`user`,`rating`,`rating_status`,`watermark`,`watermark_thumb`,`owner`,`codeblock`) values (2,NULL,'gallery1','gallery1','','2012-02-09 18:52:55','2008-03-14 13:59:26','',1,0,1,'1',1328813575,'','',NULL,0,0,0,'','',NULL,NULL,0,0,NULL,'',0,NULL,'',NULL,NULL,3,'','','admin','a:3:{i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";}');

UNLOCK TABLES;

/*Table structure for table `partyyaad_captcha` */

DROP TABLE IF EXISTS `partyyaad_captcha`;

CREATE TABLE `partyyaad_captcha` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ptime` int(32) unsigned NOT NULL,
  `hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_captcha` */

LOCK TABLES `partyyaad_captcha` WRITE;

insert  into `partyyaad_captcha`(`id`,`ptime`,`hash`) values (77,1328833910,'35c1ae30b4981d61055cd5307d890f67a92c38ff'),(78,1328833929,'a15ba0d9c4b05fb0a6bb584a17cd68ba4e3a73b6'),(79,1328833992,'0a0c961e4ed61e6dd8b1a4ea57d5faf836da1aab'),(80,1328834090,'f9185a0559618f7e727e0eea2fd4a67af5d8e296'),(81,1328834116,'b6010e03ad6cf78c2e75de131868dfeeb3569970'),(82,1328834207,'7c30791f829402230cb6ce4b655f9662c9d9b000'),(83,1328834216,'e5d4db01f130690cbaef3de1d42e05ccc5e89581'),(84,1328834233,'89f89ecf32345698a64fb57262e6fa56f6a978fe'),(85,1328834274,'b665766e013e785b0f557cf5aebf66465753a7ce'),(86,1328834340,'b28c93b439b6255ba1ce31dcab37857e33f54e14'),(87,1328834352,'d39bd736fd184c41c8cd6502daba005b265858c9'),(88,1328834370,'e15ad6117d234f8073ad764e51edbef5c4be81a6'),(89,1328834397,'a6c362056e2c17224c5e0c8194a935b3ae3322da'),(90,1328834408,'fe7f64fef8ab2e52667d12d203c8c9aef31f11ee'),(91,1328834420,'2fb93eea1516726f7580df706bde2a07df56f364'),(92,1328834428,'c958e4f75ecd6d27d9081b13e69384d366291f68'),(93,1328834436,'3f10852e02fe72844ed4a2b190b72be0ef80f115'),(94,1328834443,'f021f17963cf2431aa7b47c8f505199d90ae5d70'),(95,1328834462,'f72a449b2b08db5fbad2bedf2f1d3d2dfdd56a5d'),(96,1328834467,'16b52ceaac40f8d8a280a25fde1e2d96121168e9'),(97,1328834685,'74826f183a263ec7397a2fb27067377aa304f6fe'),(98,1328834775,'f1aed14d139b15f4f9cae8a17a10dc2777cc027e'),(99,1328834803,'1747c168dde51bf8e7e5d391be9ff030a30f3858');

UNLOCK TABLES;

/*Table structure for table `partyyaad_comments` */

DROP TABLE IF EXISTS `partyyaad_comments`;

CREATE TABLE `partyyaad_comments` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ownerid` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `website` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `comment` text COLLATE utf8_unicode_ci,
  `inmoderation` int(1) unsigned NOT NULL DEFAULT '0',
  `type` varchar(52) COLLATE utf8_unicode_ci DEFAULT 'images',
  `IP` text COLLATE utf8_unicode_ci,
  `private` int(1) DEFAULT '0',
  `anon` int(1) DEFAULT '0',
  `custom_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `ownerid` (`ownerid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_comments` */

LOCK TABLES `partyyaad_comments` WRITE;

UNLOCK TABLES;

/*Table structure for table `partyyaad_images` */

DROP TABLE IF EXISTS `partyyaad_images`;

CREATE TABLE `partyyaad_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `albumid` int(11) unsigned DEFAULT NULL,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `title` text COLLATE utf8_unicode_ci,
  `desc` text COLLATE utf8_unicode_ci,
  `location` text COLLATE utf8_unicode_ci,
  `city` tinytext COLLATE utf8_unicode_ci,
  `state` tinytext COLLATE utf8_unicode_ci,
  `country` tinytext COLLATE utf8_unicode_ci,
  `credit` text COLLATE utf8_unicode_ci,
  `copyright` text COLLATE utf8_unicode_ci,
  `commentson` int(1) unsigned NOT NULL DEFAULT '1',
  `show` int(1) NOT NULL DEFAULT '1',
  `date` datetime DEFAULT NULL,
  `sort_order` int(11) unsigned DEFAULT NULL,
  `height` int(10) unsigned DEFAULT NULL,
  `width` int(10) unsigned DEFAULT NULL,
  `thumbX` int(10) unsigned DEFAULT NULL,
  `thumbY` int(10) unsigned DEFAULT NULL,
  `thumbW` int(10) unsigned DEFAULT NULL,
  `thumbH` int(10) unsigned DEFAULT NULL,
  `mtime` int(32) DEFAULT NULL,
  `publishdate` datetime DEFAULT NULL,
  `expiredate` datetime DEFAULT NULL,
  `hitcounter` int(11) unsigned DEFAULT '0',
  `total_value` int(11) unsigned DEFAULT '0',
  `total_votes` int(11) unsigned DEFAULT '0',
  `used_ips` longtext COLLATE utf8_unicode_ci,
  `custom_data` text COLLATE utf8_unicode_ci,
  `rating` float DEFAULT NULL,
  `rating_status` int(1) DEFAULT '3',
  `hasMetadata` int(1) DEFAULT '0',
  `watermark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `watermark_use` int(1) DEFAULT '7',
  `owner` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `codeblock` text COLLATE utf8_unicode_ci,
  `user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hint` text COLLATE utf8_unicode_ci,
  `EXIFMake` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFModel` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFDescription` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCObjectName` mediumtext COLLATE utf8_unicode_ci,
  `IPTCImageHeadline` mediumtext COLLATE utf8_unicode_ci,
  `IPTCImageCaption` mediumtext COLLATE utf8_unicode_ci,
  `IPTCImageCaptionWriter` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFDateTime` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFDateTimeOriginal` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFDateTimeDigitized` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCDateCreated` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCTimeCreated` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCDigitizeDate` varchar(8) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCDigitizeTime` varchar(11) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFArtist` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCImageCredit` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCByLine` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCByLineTitle` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCSource` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCContact` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFCopyright` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCCopyright` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFExposureTime` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFFNumber` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFISOSpeedRatings` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFExposureBiasValue` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFMeteringMode` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFFlash` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFImageWidth` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFImageHeight` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFOrientation` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFContrast` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFSharpness` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFSaturation` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFWhiteBalance` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFSubjectDistance` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFFocalLength` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFLensType` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFLensInfo` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFFocalLengthIn35mmFilm` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCCity` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCSubLocation` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCState` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCLocationCode` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCLocationName` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSLatitude` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSLatitudeRef` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSLongitude` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSLongitudeRef` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSAltitude` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `EXIFGPSAltitudeRef` varchar(52) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCOriginatingProgram` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `IPTCProgramVersion` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoFormat` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoSize` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoArtist` mediumtext COLLATE utf8_unicode_ci,
  `VideoTitle` mediumtext COLLATE utf8_unicode_ci,
  `VideoBitrate` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoBitrate_mode` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoBits_per_sample` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoCodec` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoCompression_ratio` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoDataformat` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoEncoder` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoSamplerate` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoChannelmode` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoChannels` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoFramerate` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoResolution_x` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoResolution_y` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoAspect_ratio` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `VideoPlaytime` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `filename` (`filename`,`albumid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_images` */

LOCK TABLES `partyyaad_images` WRITE;

insert  into `partyyaad_images`(`id`,`albumid`,`filename`,`title`,`desc`,`location`,`city`,`state`,`country`,`credit`,`copyright`,`commentson`,`show`,`date`,`sort_order`,`height`,`width`,`thumbX`,`thumbY`,`thumbW`,`thumbH`,`mtime`,`publishdate`,`expiredate`,`hitcounter`,`total_value`,`total_votes`,`used_ips`,`custom_data`,`rating`,`rating_status`,`hasMetadata`,`watermark`,`watermark_use`,`owner`,`filesize`,`codeblock`,`user`,`password`,`password_hint`,`EXIFMake`,`EXIFModel`,`EXIFDescription`,`IPTCObjectName`,`IPTCImageHeadline`,`IPTCImageCaption`,`IPTCImageCaptionWriter`,`EXIFDateTime`,`EXIFDateTimeOriginal`,`EXIFDateTimeDigitized`,`IPTCDateCreated`,`IPTCTimeCreated`,`IPTCDigitizeDate`,`IPTCDigitizeTime`,`EXIFArtist`,`IPTCImageCredit`,`IPTCByLine`,`IPTCByLineTitle`,`IPTCSource`,`IPTCContact`,`EXIFCopyright`,`IPTCCopyright`,`EXIFExposureTime`,`EXIFFNumber`,`EXIFISOSpeedRatings`,`EXIFExposureBiasValue`,`EXIFMeteringMode`,`EXIFFlash`,`EXIFImageWidth`,`EXIFImageHeight`,`EXIFOrientation`,`EXIFContrast`,`EXIFSharpness`,`EXIFSaturation`,`EXIFWhiteBalance`,`EXIFSubjectDistance`,`EXIFFocalLength`,`EXIFLensType`,`EXIFLensInfo`,`EXIFFocalLengthIn35mmFilm`,`IPTCCity`,`IPTCSubLocation`,`IPTCState`,`IPTCLocationCode`,`IPTCLocationName`,`EXIFGPSLatitude`,`EXIFGPSLatitudeRef`,`EXIFGPSLongitude`,`EXIFGPSLongitudeRef`,`EXIFGPSAltitude`,`EXIFGPSAltitudeRef`,`IPTCOriginatingProgram`,`IPTCProgramVersion`,`VideoFormat`,`VideoSize`,`VideoArtist`,`VideoTitle`,`VideoBitrate`,`VideoBitrate_mode`,`VideoBits_per_sample`,`VideoCodec`,`VideoCompression_ratio`,`VideoDataformat`,`VideoEncoder`,`VideoSamplerate`,`VideoChannelmode`,`VideoChannels`,`VideoFramerate`,`VideoResolution_x`,`VideoResolution_y`,`VideoAspect_ratio`,`VideoPlaytime`) values (1,2,'desert.jpg','Desert.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2008-03-14 13:59:26',NULL,768,1024,NULL,NULL,NULL,NULL,1328813575,NULL,NULL,0,0,0,NULL,NULL,NULL,3,1,NULL,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2008:03:14 13:59:26','2008:03:14 13:59:26',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,2,'jellyfish.jpg','Jellyfish.jpg',NULL,NULL,NULL,NULL,NULL,'Hang Quan','© Microsoft Corporation',1,1,'2008-02-11 11:32:24',NULL,768,1024,NULL,NULL,NULL,NULL,1328813575,NULL,NULL,0,0,0,NULL,NULL,NULL,3,1,NULL,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','',NULL,'2008:02:11 11:32:24','2008:02:11 11:32:24','','','','',NULL,'','Hang Quan','','','','Microsoft Corporation','© Microsoft Corporation',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,2,'tulips.jpg','Tulips.jpg',NULL,NULL,NULL,NULL,NULL,'David Nadalin','© Microsoft Corporation',1,1,'2008-02-07 11:33:11',NULL,768,1024,NULL,NULL,NULL,NULL,1328813575,NULL,NULL,0,0,0,NULL,NULL,NULL,3,1,NULL,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','',NULL,'2008:02:07 11:33:11','2008:02:07 11:33:11','','','','',NULL,'','David Nadalin','','','','Microsoft Corporation','© Microsoft Corporation',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,2,'koala.jpg','Koala.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2008-02-11 11:32:43',NULL,768,1024,NULL,NULL,NULL,NULL,1328813575,NULL,NULL,0,0,0,NULL,NULL,NULL,3,1,NULL,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2008:02:11 11:32:43','2008:02:11 11:32:43',NULL,NULL,NULL,NULL,'Corbis',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(5,2,'lighthouse.jpg','Lighthouse.jpg',NULL,NULL,NULL,NULL,NULL,'Tom Alphin','© Microsoft Corporation',1,1,'2008-02-11 11:32:51',NULL,768,1024,NULL,NULL,NULL,NULL,1328815599,NULL,NULL,0,0,0,NULL,NULL,NULL,3,1,NULL,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','',NULL,'2008:02:11 11:32:51','2008:02:11 11:32:51','','','','','Tom Alphin','','Tom Alphin','','','','Microsoft Corporation','© Microsoft Corporation',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',NULL,NULL,NULL,NULL,NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(6,2,'penguins.jpg','Penguins.jpg',NULL,NULL,NULL,NULL,NULL,NULL,NULL,1,1,'2008-02-18 05:07:31',NULL,768,1024,NULL,NULL,NULL,NULL,1328815599,NULL,NULL,0,0,0,NULL,NULL,NULL,3,1,NULL,7,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2008:02:18 05:07:31','2008:02:18 05:07:31',NULL,NULL,NULL,NULL,'Corbis',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

UNLOCK TABLES;

/*Table structure for table `partyyaad_menu` */

DROP TABLE IF EXISTS `partyyaad_menu`;

CREATE TABLE `partyyaad_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) unsigned DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `link` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `include_li` int(1) unsigned DEFAULT '1',
  `type` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `sort_order` varchar(48) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `show` int(1) unsigned NOT NULL DEFAULT '1',
  `menuset` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `span_class` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `span_id` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_menu` */

LOCK TABLES `partyyaad_menu` WRITE;

UNLOCK TABLES;

/*Table structure for table `partyyaad_news` */

DROP TABLE IF EXISTS `partyyaad_news`;

CREATE TABLE `partyyaad_news` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `extracontent` text COLLATE utf8_unicode_ci,
  `show` int(1) unsigned NOT NULL DEFAULT '1',
  `date` datetime DEFAULT NULL,
  `titlelink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commentson` int(1) unsigned DEFAULT '0',
  `codeblock` text COLLATE utf8_unicode_ci,
  `author` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `lastchange` datetime DEFAULT NULL,
  `lastchangeauthor` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `hitcounter` int(11) unsigned DEFAULT '0',
  `permalink` int(1) unsigned NOT NULL DEFAULT '0',
  `locked` int(1) unsigned NOT NULL DEFAULT '0',
  `expiredate` datetime DEFAULT NULL,
  `total_value` int(11) unsigned DEFAULT '0',
  `total_votes` int(11) unsigned DEFAULT '0',
  `used_ips` longtext COLLATE utf8_unicode_ci,
  `rating` float DEFAULT NULL,
  `rating_status` int(1) DEFAULT '3',
  `sticky` int(1) DEFAULT '0',
  `custom_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titlelink` (`titlelink`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_news` */

LOCK TABLES `partyyaad_news` WRITE;

UNLOCK TABLES;

/*Table structure for table `partyyaad_news2cat` */

DROP TABLE IF EXISTS `partyyaad_news2cat`;

CREATE TABLE `partyyaad_news2cat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cat_id` int(11) unsigned NOT NULL,
  `news_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_news2cat` */

LOCK TABLES `partyyaad_news2cat` WRITE;

UNLOCK TABLES;

/*Table structure for table `partyyaad_news_categories` */

DROP TABLE IF EXISTS `partyyaad_news_categories`;

CREATE TABLE `partyyaad_news_categories` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci,
  `titlelink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `permalink` int(1) unsigned NOT NULL DEFAULT '0',
  `hitcounter` int(11) unsigned DEFAULT '0',
  `user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hint` text COLLATE utf8_unicode_ci,
  `parentid` int(11) DEFAULT NULL,
  `sort_order` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8_unicode_ci,
  `custom_data` text COLLATE utf8_unicode_ci,
  `show` int(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `titlelink` (`titlelink`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_news_categories` */

LOCK TABLES `partyyaad_news_categories` WRITE;

UNLOCK TABLES;

/*Table structure for table `partyyaad_obj_to_tag` */

DROP TABLE IF EXISTS `partyyaad_obj_to_tag`;

CREATE TABLE `partyyaad_obj_to_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tagid` int(11) unsigned NOT NULL,
  `type` tinytext COLLATE utf8_unicode_ci,
  `objectid` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tagid` (`tagid`),
  KEY `objectid` (`objectid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_obj_to_tag` */

LOCK TABLES `partyyaad_obj_to_tag` WRITE;

UNLOCK TABLES;

/*Table structure for table `partyyaad_options` */

DROP TABLE IF EXISTS `partyyaad_options`;

CREATE TABLE `partyyaad_options` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ownerid` int(11) unsigned NOT NULL DEFAULT '0',
  `name` varchar(191) COLLATE utf8_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `theme` varchar(127) COLLATE utf8_unicode_ci DEFAULT NULL,
  `creator` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_option` (`name`,`ownerid`,`theme`)
) ENGINE=InnoDB AUTO_INCREMENT=456 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_options` */

LOCK TABLES `partyyaad_options` WRITE;

insert  into `partyyaad_options`(`id`,`ownerid`,`name`,`value`,`theme`,`creator`) values (1,0,'zenphoto_version','1.4.2.1 [9138]',NULL,NULL),(2,0,'zenphoto_install','{5c29bedd-3132-d52a-a904-70e546ae2032}',NULL,NULL),(4,0,'libauth_version','3',NULL,NULL),(5,0,'time_offset','0',NULL,'zp-core/setup/setup-option-defaults.php'),(6,0,'mod_rewrite_image_suffix','.php',NULL,'zp-core/setup/setup-option-defaults.php'),(7,0,'server_protocol','http',NULL,'zp-core/setup/setup-option-defaults.php'),(8,0,'charset','UTF-8',NULL,'zp-core/setup/setup-option-defaults.php'),(9,0,'image_quality','85',NULL,'zp-core/setup/setup-option-defaults.php'),(10,0,'thumb_quality','75',NULL,'zp-core/setup/setup-option-defaults.php'),(11,0,'image_size','595',NULL,'zp-core/setup/setup-option-defaults.php'),(12,0,'image_use_side','longest',NULL,'zp-core/setup/setup-option-defaults.php'),(13,0,'image_allow_upscale','0',NULL,'zp-core/setup/setup-option-defaults.php'),(14,0,'thumb_size','100',NULL,'zp-core/setup/setup-option-defaults.php'),(15,0,'thumb_crop','1',NULL,'zp-core/setup/setup-option-defaults.php'),(16,0,'thumb_crop_width','85',NULL,'zp-core/setup/setup-option-defaults.php'),(17,0,'thumb_crop_height','85',NULL,'zp-core/setup/setup-option-defaults.php'),(18,0,'thumb_sharpen','0',NULL,'zp-core/setup/setup-option-defaults.php'),(19,0,'image_sharpen','0',NULL,'zp-core/setup/setup-option-defaults.php'),(20,0,'albums_per_page','5',NULL,'zp-core/setup/setup-option-defaults.php'),(21,0,'images_per_page','15',NULL,'zp-core/setup/setup-option-defaults.php'),(22,0,'search_password','',NULL,'zp-core/setup/setup-option-defaults.php'),(23,0,'search_hint',NULL,NULL,'zp-core/setup/setup-option-defaults.php'),(24,0,'album_session','0',NULL,'zp-core/setup/setup-option-defaults.php'),(25,0,'watermark_h_offset','90',NULL,'zp-core/setup/setup-option-defaults.php'),(26,0,'watermark_w_offset','90',NULL,'zp-core/setup/setup-option-defaults.php'),(27,0,'watermark_scale','5',NULL,'zp-core/setup/setup-option-defaults.php'),(28,0,'watermark_allow_upscale','1',NULL,'zp-core/setup/setup-option-defaults.php'),(29,0,'perform_video_watermark','0',NULL,'zp-core/setup/setup-option-defaults.php'),(30,0,'spam_filter','none',NULL,'zp-core/setup/setup-option-defaults.php'),(31,0,'email_new_comments','1',NULL,'zp-core/setup/setup-option-defaults.php'),(32,0,'image_sorttype','Filename',NULL,'zp-core/setup/setup-option-defaults.php'),(33,0,'image_sortdirection','0',NULL,'zp-core/setup/setup-option-defaults.php'),(34,0,'hotlink_protection','1',NULL,'zp-core/setup/setup-option-defaults.php'),(35,0,'feed_items','10',NULL,'zp-core/setup/setup-option-defaults.php'),(36,0,'feed_imagesize','240',NULL,'zp-core/setup/setup-option-defaults.php'),(37,0,'feed_sortorder','latest',NULL,'zp-core/setup/setup-option-defaults.php'),(38,0,'feed_items_albums','10',NULL,'zp-core/setup/setup-option-defaults.php'),(39,0,'feed_imagesize_albums','240',NULL,'zp-core/setup/setup-option-defaults.php'),(40,0,'feed_sortorder_albums','latest',NULL,'zp-core/setup/setup-option-defaults.php'),(41,0,'feed_enclosure','0',NULL,'zp-core/setup/setup-option-defaults.php'),(42,0,'feed_mediarss','0',NULL,'zp-core/setup/setup-option-defaults.php'),(43,0,'feed_cache','1',NULL,'zp-core/setup/setup-option-defaults.php'),(44,0,'feed_cache_expire','86400',NULL,'zp-core/setup/setup-option-defaults.php'),(45,0,'feed_hitcounter','1',NULL,'zp-core/setup/setup-option-defaults.php'),(46,0,'feed_title','both',NULL,'zp-core/setup/setup-option-defaults.php'),(47,0,'search_fields','title,desc,tags,file,location,city,state,country,content,author',NULL,'zp-core/setup/setup-option-defaults.php'),(48,0,'allowed_tags_default','a => (href =>() title =>() target=>() class=>() id=>())\nabbr =>(class=>() id=>() title =>())\nacronym =>(class=>() id=>() title =>())\nb => (class=>() id=>() )\nblockquote =>(class=>() id=>() cite =>())\nbr => (class=>() id=>() )\ncode => (class=>() id=>() )\nem => (class=>() id=>() )\ni => (class=>() id=>() ) \nstrike => (class=>() id=>() )\nstrong => (class=>() id=>() )\nul => (class=>() id=>())\nol => (class=>() id=>())\nli => (class=>() id=>())\np => (class=>() id=>() style=>())\nh1=>(class=>() id=>() style=>())\nh2=>(class=>() id=>() style=>())\nh3=>(class=>() id=>() style=>())\nh4=>(class=>() id=>() style=>())\nh5=>(class=>() id=>() style=>())\nh6=>(class=>() id=>() style=>())\npre=>(class=>() id=>() style=>())\naddress=>(class=>() id=>() style=>())\nspan=>(class=>() id=>() style=>())\ndiv=>(class=>() id=>() style=>())\nimg=>(class=>() id=>() style=>() src=>() title=>() alt=>() width=>() height=>())\n',NULL,NULL),(49,0,'allowed_tags','a => (href =>() title =>() target=>() class=>() id=>())\nabbr =>(class=>() id=>() title =>())\nacronym =>(class=>() id=>() title =>())\nb => (class=>() id=>() )\nblockquote =>(class=>() id=>() cite =>())\nbr => (class=>() id=>() )\ncode => (class=>() id=>() )\nem => (class=>() id=>() )\ni => (class=>() id=>() ) \nstrike => (class=>() id=>() )\nstrong => (class=>() id=>() )\nul => (class=>() id=>())\nol => (class=>() id=>())\nli => (class=>() id=>())\np => (class=>() id=>() style=>())\nh1=>(class=>() id=>() style=>())\nh2=>(class=>() id=>() style=>())\nh3=>(class=>() id=>() style=>())\nh4=>(class=>() id=>() style=>())\nh5=>(class=>() id=>() style=>())\nh6=>(class=>() id=>() style=>())\npre=>(class=>() id=>() style=>())\naddress=>(class=>() id=>() style=>())\nspan=>(class=>() id=>() style=>())\ndiv=>(class=>() id=>() style=>())\nimg=>(class=>() id=>() style=>() src=>() title=>() alt=>() width=>() height=>())\n',NULL,'zp-core/setup/setup-option-defaults.php'),(50,0,'style_tags','abbr => (title => ())\nacronym => (title => ())\nb => ()\nem => ()\ni => () \nstrike => ()\nstrong => ()\n',NULL,'zp-core/setup/setup-option-defaults.php'),(51,0,'comment_name_required','required',NULL,'zp-core/setup/setup-option-defaults.php'),(52,0,'comment_email_required','required',NULL,'zp-core/setup/setup-option-defaults.php'),(53,0,'comment_web_required','show',NULL,'zp-core/setup/setup-option-defaults.php'),(54,0,'Use_Captcha','',NULL,'zp-core/setup/setup-option-defaults.php'),(55,0,'full_image_quality','75',NULL,'zp-core/setup/setup-option-defaults.php'),(56,0,'protect_full_image','Protected view',NULL,'zp-core/setup/setup-option-defaults.php'),(57,0,'locale','',NULL,'zp-core/setup/setup-option-defaults.php'),(58,0,'date_format','%x',NULL,'zp-core/setup/setup-option-defaults.php'),(59,0,'zp_plugin_class-video','4105',NULL,'zp-core/setup/setup-option-defaults.php'),(60,0,'use_lock_image','1',NULL,'zp-core/setup/setup-option-defaults.php'),(61,0,'search_user','',NULL,'zp-core/setup/setup-option-defaults.php'),(62,0,'multi_lingual','0',NULL,'zp-core/setup/setup-option-defaults.php'),(63,0,'tagsort','0',NULL,'zp-core/setup/setup-option-defaults.php'),(64,0,'albumimagesort','ID',NULL,'zp-core/setup/setup-option-defaults.php'),(65,0,'albumimagedirection','DESC',NULL,'zp-core/setup/setup-option-defaults.php'),(66,0,'cache_full_image','0',NULL,'zp-core/setup/setup-option-defaults.php'),(67,0,'custom_index_page','',NULL,'zp-core/setup/setup-option-defaults.php'),(68,0,'picture_of_the_day','a:3:{s:3:\"day\";N;s:6:\"folder\";N;s:8:\"filename\";N;}',NULL,'zp-core/setup/setup-option-defaults.php'),(69,0,'exact_tag_match','0',NULL,'zp-core/setup/setup-option-defaults.php'),(70,0,'EXIFMake','1',NULL,'zp-core/setup/setup-option-defaults.php'),(71,0,'EXIFModel','1',NULL,'zp-core/setup/setup-option-defaults.php'),(72,0,'EXIFExposureTime','1',NULL,'zp-core/setup/setup-option-defaults.php'),(73,0,'EXIFFNumber','1',NULL,'zp-core/setup/setup-option-defaults.php'),(74,0,'EXIFFocalLength','1',NULL,'zp-core/setup/setup-option-defaults.php'),(75,0,'EXIFISOSpeedRatings','1',NULL,'zp-core/setup/setup-option-defaults.php'),(76,0,'EXIFDateTimeOriginal','1',NULL,'zp-core/setup/setup-option-defaults.php'),(77,0,'EXIFExposureBiasValue','1',NULL,'zp-core/setup/setup-option-defaults.php'),(78,0,'EXIFMeteringMode','1',NULL,'zp-core/setup/setup-option-defaults.php'),(79,0,'EXIFFlash','1',NULL,'zp-core/setup/setup-option-defaults.php'),(80,0,'EXIFDescription','0',NULL,'zp-core/setup/setup-option-defaults.php'),(81,0,'IPTCObjectName','0',NULL,'zp-core/setup/setup-option-defaults.php'),(82,0,'IPTCImageHeadline','0',NULL,'zp-core/setup/setup-option-defaults.php'),(83,0,'IPTCImageCaption','0',NULL,'zp-core/setup/setup-option-defaults.php'),(84,0,'IPTCImageCaptionWriter','0',NULL,'zp-core/setup/setup-option-defaults.php'),(85,0,'EXIFDateTime','0',NULL,'zp-core/setup/setup-option-defaults.php'),(86,0,'EXIFDateTimeDigitized','0',NULL,'zp-core/setup/setup-option-defaults.php'),(87,0,'IPTCDateCreated','0',NULL,'zp-core/setup/setup-option-defaults.php'),(88,0,'IPTCTimeCreated','0',NULL,'zp-core/setup/setup-option-defaults.php'),(89,0,'IPTCDigitizeDate','0',NULL,'zp-core/setup/setup-option-defaults.php'),(90,0,'IPTCDigitizeTime','0',NULL,'zp-core/setup/setup-option-defaults.php'),(91,0,'EXIFArtist','0',NULL,'zp-core/setup/setup-option-defaults.php'),(92,0,'IPTCImageCredit','0',NULL,'zp-core/setup/setup-option-defaults.php'),(93,0,'IPTCByLine','0',NULL,'zp-core/setup/setup-option-defaults.php'),(94,0,'IPTCByLineTitle','0',NULL,'zp-core/setup/setup-option-defaults.php'),(95,0,'IPTCSource','0',NULL,'zp-core/setup/setup-option-defaults.php'),(96,0,'IPTCContact','0',NULL,'zp-core/setup/setup-option-defaults.php'),(97,0,'EXIFCopyright','0',NULL,'zp-core/setup/setup-option-defaults.php'),(98,0,'IPTCCopyright','0',NULL,'zp-core/setup/setup-option-defaults.php'),(99,0,'EXIFImageWidth','0',NULL,'zp-core/setup/setup-option-defaults.php'),(100,0,'EXIFImageHeight','0',NULL,'zp-core/setup/setup-option-defaults.php'),(101,0,'EXIFOrientation','0',NULL,'zp-core/setup/setup-option-defaults.php'),(102,0,'EXIFContrast','0',NULL,'zp-core/setup/setup-option-defaults.php'),(103,0,'EXIFSharpness','0',NULL,'zp-core/setup/setup-option-defaults.php'),(104,0,'EXIFSaturation','0',NULL,'zp-core/setup/setup-option-defaults.php'),(105,0,'EXIFWhiteBalance','0',NULL,'zp-core/setup/setup-option-defaults.php'),(106,0,'EXIFSubjectDistance','0',NULL,'zp-core/setup/setup-option-defaults.php'),(107,0,'EXIFLensType','0',NULL,'zp-core/setup/setup-option-defaults.php'),(108,0,'EXIFLensInfo','0',NULL,'zp-core/setup/setup-option-defaults.php'),(109,0,'EXIFFocalLengthIn35mmFilm','0',NULL,'zp-core/setup/setup-option-defaults.php'),(110,0,'IPTCCity','0',NULL,'zp-core/setup/setup-option-defaults.php'),(111,0,'IPTCSubLocation','0',NULL,'zp-core/setup/setup-option-defaults.php'),(112,0,'IPTCState','0',NULL,'zp-core/setup/setup-option-defaults.php'),(113,0,'IPTCLocationCode','0',NULL,'zp-core/setup/setup-option-defaults.php'),(114,0,'IPTCLocationName','0',NULL,'zp-core/setup/setup-option-defaults.php'),(115,0,'EXIFGPSLatitude','0',NULL,'zp-core/setup/setup-option-defaults.php'),(116,0,'EXIFGPSLatitudeRef','0',NULL,'zp-core/setup/setup-option-defaults.php'),(117,0,'EXIFGPSLongitude','0',NULL,'zp-core/setup/setup-option-defaults.php'),(118,0,'EXIFGPSLongitudeRef','0',NULL,'zp-core/setup/setup-option-defaults.php'),(119,0,'EXIFGPSAltitude','0',NULL,'zp-core/setup/setup-option-defaults.php'),(120,0,'EXIFGPSAltitudeRef','0',NULL,'zp-core/setup/setup-option-defaults.php'),(121,0,'IPTCOriginatingProgram','0',NULL,'zp-core/setup/setup-option-defaults.php'),(122,0,'IPTCProgramVersion','0',NULL,'zp-core/setup/setup-option-defaults.php'),(123,0,'VideoFormat','0',NULL,'zp-core/setup/setup-option-defaults.php'),(124,0,'VideoSize','0',NULL,'zp-core/setup/setup-option-defaults.php'),(125,0,'VideoArtist','0',NULL,'zp-core/setup/setup-option-defaults.php'),(126,0,'VideoTitle','0',NULL,'zp-core/setup/setup-option-defaults.php'),(127,0,'VideoBitrate','0',NULL,'zp-core/setup/setup-option-defaults.php'),(128,0,'VideoBitrate_mode','0',NULL,'zp-core/setup/setup-option-defaults.php'),(129,0,'VideoBits_per_sample','0',NULL,'zp-core/setup/setup-option-defaults.php'),(130,0,'VideoCodec','0',NULL,'zp-core/setup/setup-option-defaults.php'),(131,0,'VideoCompression_ratio','0',NULL,'zp-core/setup/setup-option-defaults.php'),(132,0,'VideoDataformat','0',NULL,'zp-core/setup/setup-option-defaults.php'),(133,0,'VideoEncoder','0',NULL,'zp-core/setup/setup-option-defaults.php'),(134,0,'VideoSamplerate','0',NULL,'zp-core/setup/setup-option-defaults.php'),(135,0,'VideoChannelmode','0',NULL,'zp-core/setup/setup-option-defaults.php'),(136,0,'VideoChannels','0',NULL,'zp-core/setup/setup-option-defaults.php'),(137,0,'VideoFramerate','0',NULL,'zp-core/setup/setup-option-defaults.php'),(138,0,'VideoResolution_x','0',NULL,'zp-core/setup/setup-option-defaults.php'),(139,0,'VideoResolution_y','0',NULL,'zp-core/setup/setup-option-defaults.php'),(140,0,'VideoAspect_ratio','0',NULL,'zp-core/setup/setup-option-defaults.php'),(141,0,'VideoPlaytime','0',NULL,'zp-core/setup/setup-option-defaults.php'),(142,0,'auto_rotate','0',NULL,'zp-core/setup/setup-option-defaults.php'),(143,0,'IPTC_encoding','ISO-8859-1',NULL,'zp-core/setup/setup-option-defaults.php'),(144,0,'UTF8_image_URI','0',NULL,'zp-core/setup/setup-option-defaults.php'),(145,0,'captcha','zenphoto',NULL,'zp-core/setup/setup-option-defaults.php'),(146,0,'sharpen_amount','40',NULL,'zp-core/setup/setup-option-defaults.php'),(147,0,'sharpen_radius','0.5',NULL,'zp-core/setup/setup-option-defaults.php'),(148,0,'sharpen_threshold','3',NULL,'zp-core/setup/setup-option-defaults.php'),(149,0,'thumb_gray','0',NULL,'zp-core/setup/setup-option-defaults.php'),(150,0,'image_gray','0',NULL,'zp-core/setup/setup-option-defaults.php'),(152,0,'search_no_albums','0',NULL,'zp-core/setup/setup-option-defaults.php'),(153,0,'strong_hash','1',NULL,'zp-core/lib-auth.php'),(154,0,'defined_groups','a:6:{i:0;s:14:\"administrators\";i:1;s:7:\"viewers\";i:2;s:5:\"bozos\";i:3;s:14:\"album managers\";i:4;s:7:\"default\";i:5;s:7:\"newuser\";}',NULL,NULL),(155,0,'comment_body_requiired','1',NULL,'zp-core/setup/setup-option-defaults.php'),(156,0,'zp_plugin_zenphoto_sendmail','4101',NULL,'zp-core/setup/setup-option-defaults.php'),(157,0,'RSS_album_image','1',NULL,'zp-core/setup/setup-option-defaults.php'),(158,0,'RSS_comments','1',NULL,'zp-core/setup/setup-option-defaults.php'),(159,0,'RSS_articles','1',NULL,'zp-core/setup/setup-option-defaults.php'),(160,0,'RSS_article_comments','1',NULL,'zp-core/setup/setup-option-defaults.php'),(161,0,'tinyMCEPresent','0',NULL,'zp-core/setup/setup-option-defaults.php'),(162,0,'AlbumThumbSelect','1',NULL,'zp-core/setup/setup-option-defaults.php'),(163,0,'site_email','zenphoto@127.0.0.1',NULL,'zp-core/setup/setup-option-defaults.php'),(164,0,'Zenphoto_theme_list','a:5:{i:0;s:7:\"default\";i:25;s:18:\"effervescence_plus\";i:95;s:7:\"garland\";i:130;s:10:\"stopdesign\";i:200;s:7:\"zenpage\";}',NULL,NULL),(165,0,'zp_plugin_deprecated-functions','4105',NULL,NULL),(166,0,'zp_plugin_zenphoto_news','2053',NULL,'zp-core/setup/setup-option-defaults.php'),(167,0,'zp_plugin_hitcounter','129',NULL,'zp-core/setup/setup-option-defaults.php'),(168,0,'zp_plugin_tiny_mce','2053',NULL,'zp-core/setup/setup-option-defaults.php'),(169,0,'zp_plugin_security-logger','4105',NULL,'zp-core/setup/setup-option-defaults.php'),(170,0,'zp_plugin_zenphoto_seo','2053',NULL,'zp-core/setup/setup-option-defaults.php'),(171,0,'default_copyright','Copyright 2012: 127.0.0.1:8080',NULL,'zp-core/setup/setup-option-defaults.php'),(172,0,'fullsizeimage_watermark',NULL,NULL,'zp-core/setup/setup-option-defaults.php'),(173,0,'gallery_page_unprotected_register','1',NULL,'zp-core/setup/setup-option-defaults.php'),(174,0,'gallery_page_unprotected_contact','1',NULL,'zp-core/setup/setup-option-defaults.php'),(175,0,'gallery_data','a:19:{s:21:\"gallery_sortdirection\";i:0;s:16:\"gallery_sorttype\";s:2:\"ID\";s:13:\"gallery_title\";s:7:\"Gallery\";s:19:\"Gallery_description\";s:73:\"You can insert your Gallery description on the Admin Options Gallery tab.\";s:16:\"gallery_password\";N;s:12:\"gallery_user\";N;s:12:\"gallery_hint\";N;s:10:\"hitcounter\";N;s:13:\"current_theme\";s:7:\"default\";s:13:\"website_title\";N;s:11:\"website_url\";N;s:16:\"gallery_security\";s:6:\"public\";s:16:\"login_user_field\";N;s:24:\"album_use_new_image_date\";N;s:19:\"thumb_select_images\";N;s:18:\"persistent_archive\";N;s:17:\"unprotected_pages\";s:80:\"a:4:{i:0;s:8:\"register\";i:1;s:7:\"contact\";i:2;s:8:\"register\";i:3;s:7:\"contact\";}\";s:13:\"album_publish\";i:1;s:13:\"image_publish\";i:1;}',NULL,NULL),(176,0,'search_cache_duration','30',NULL,'zp-core/setup/setup-option-defaults.php'),(177,0,'zp_plugin_class-video_mov_w','520',NULL,'zp-core/zp-extensions/class-video.php'),(178,0,'zp_plugin_class-video_mov_h','390',NULL,'zp-core/zp-extensions/class-video.php'),(179,0,'zp_plugin_class-video_3gp_w','520',NULL,'zp-core/zp-extensions/class-video.php'),(180,0,'zp_plugin_class-video_3gp_h','390',NULL,'zp-core/zp-extensions/class-video.php'),(181,0,'logger_log_guests','1',NULL,'zp-core/zp-extensions/security-logger.php'),(182,0,'logger_log_admin','1',NULL,'zp-core/zp-extensions/security-logger.php'),(183,0,'logger_log_type','all',NULL,'zp-core/zp-extensions/security-logger.php'),(184,0,'zenphoto_captcha_length','5',NULL,'zp-core/zp-extensions/captcha/zenphoto.php'),(185,0,'zenphoto_captcha_length','5',NULL,'zp-core/zp-extensions/captcha/zenphoto.php'),(186,0,'zenphoto_captcha_length','5',NULL,'zp-core/zp-extensions/captcha/zenphoto.php'),(187,0,'zenphoto_captcha_key','39cb2c3a7d799672b4ab170c342ceaa937378b4d',NULL,'zp-core/zp-extensions/captcha/zenphoto.php'),(188,0,'zenphoto_captcha_key','39cb2c3a7d799672b4ab170c342ceaa937378b4d',NULL,'zp-core/zp-extensions/captcha/zenphoto.php'),(189,0,'zenphoto_captcha_key','39cb2c3a7d799672b4ab170c342ceaa937378b4d',NULL,'zp-core/zp-extensions/captcha/zenphoto.php'),(190,0,'zenphoto_captcha_string','abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ',NULL,'zp-core/zp-extensions/captcha/zenphoto.php'),(191,0,'zenphoto_captcha_string','abcdefghijkmnpqrstuvwxyz23456789ABCDEFGHJKLMNPQRSTUVWXYZ',NULL,'zp-core/zp-extensions/captcha/zenphoto.php'),(192,0,'extra_auth_hash_text','4do1=haJ</QTG(p;zkIgEs|u&m#wKC',NULL,'zp-core/lib-auth.php'),(193,0,'min_password_lenght','6',NULL,'zp-core/lib-auth.php'),(194,0,'min_password_lenght','6',NULL,'zp-core/lib-auth.php'),(195,0,'password_pattern','A-Za-z0-9   |   ~!@#$%&*_+`-(),.\\^\'\"/[]{}=:;?\\|',NULL,'zp-core/lib-auth.php'),(196,0,'password_pattern','A-Za-z0-9   |   ~!@#$%&*_+`-(),.\\^\'\"/[]{}=:;?\\|',NULL,'zp-core/lib-auth.php'),(197,0,'user_album_edit_default','1',NULL,'zp-core/lib-auth.php'),(198,0,'user_album_edit_default','1',NULL,'zp-core/lib-auth.php'),(199,0,'user_album_edit_default','1',NULL,'zp-core/lib-auth.php'),(200,0,'user_album_edit_default','1',NULL,'zp-core/lib-auth.php'),(201,0,'Theme_logo','','effervescence_plus','themes/effervescence_plus'),(202,0,'zenpage_zp_index_news','','zenpage','themes/zenpage'),(203,0,'Allow_search','1','default','themes/default'),(204,0,'Allow_search','1','stopdesign','themes/stopdesign'),(205,0,'Allow_search','1','effervescence_plus','themes/effervescence_plus'),(206,0,'Allow_search','1','garland','themes/garland'),(207,0,'Mini_slide_selector','Recent images','stopdesign','themes/stopdesign'),(208,0,'Allow_search','1','zenpage','themes/zenpage'),(209,0,'Theme_colors','light','default','themes/default'),(210,0,'enable_album_zipfile','','effervescence_plus','themes/effervescence_plus'),(211,0,'Use_thickbox','1','zenpage','themes/zenpage'),(212,0,'Allow_cloud','1','garland','themes/garland'),(213,0,'albums_per_row','2','default','themes/default'),(214,0,'albums_per_row','3','stopdesign','themes/stopdesign'),(215,0,'albums_per_row','2','garland','themes/garland'),(216,0,'Slideshow','1','effervescence_plus','themes/effervescence_plus'),(217,0,'images_per_row','5','default','themes/default'),(218,0,'zenpage_homepage','none','zenpage','themes/zenpage'),(219,0,'thumb_transition','1','default','themes/default'),(220,0,'images_per_row','6','stopdesign','themes/stopdesign'),(221,0,'images_per_row','5','garland','themes/garland'),(222,0,'Graphic_logo','*','effervescence_plus','themes/effervescence_plus'),(223,0,'zenpage_contactpage','1','zenpage','themes/zenpage'),(224,0,'zenpage_custommenu','','zenpage','themes/zenpage'),(225,0,'colorbox_default_album','1',NULL,'themes/default/themeoptions.php'),(226,0,'thumb_transition','1','garland','themes/garland'),(227,0,'Watermark_head_image','1','effervescence_plus','themes/effervescence_plus'),(228,0,'thumb_transition','1','stopdesign','themes/stopdesign'),(229,0,'albums_per_row','2','zenpage','themes/zenpage'),(230,0,'colorbox_default_image','1',NULL,'themes/default/themeoptions.php'),(231,0,'thumb_size','85','garland','themes/garland'),(232,0,'Theme_personality','Image page','effervescence_plus','themes/effervescence_plus'),(233,0,'colorbox_stopdesign_album','1',NULL,'themes/stopdesign/themeoptions.php'),(234,0,'images_per_row','5','zenpage','themes/zenpage'),(235,0,'Theme_colors','light','effervescence_plus','themes/effervescence_plus'),(236,0,'colorbox_default_search','1',NULL,'themes/default/themeoptions.php'),(237,0,'colorbox_stopdesign_image','1',NULL,'themes/stopdesign/themeoptions.php'),(238,0,'colorbox_garland_image','1',NULL,'themes/garland/themeoptions.php'),(239,0,'effervescence_menu','','effervescence_plus','themes/effervescence_plus'),(240,0,'thumb_transition','1','zenpage','themes/zenpage'),(241,0,'colorbox_stopdesign_search','1',NULL,'themes/stopdesign/themeoptions.php'),(242,0,'colorbox_garland_album','1',NULL,'themes/garland/themeoptions.php'),(243,0,'albums_per_row','3','effervescence_plus','themes/effervescence_plus'),(244,0,'colorbox_zenpage_album','1',NULL,'themes/zenpage/themeoptions.php'),(245,0,'colorbox_garland_search','1',NULL,'themes/garland/themeoptions.php'),(246,0,'garland_menu','','garland','themes/garland'),(247,0,'images_per_row','4','effervescence_plus','themes/effervescence_plus'),(248,0,'colorbox_zenpage_image','1',NULL,'themes/zenpage/themeoptions.php'),(249,0,'colorbox_zenpage_search','1',NULL,'themes/zenpage/themeoptions.php'),(250,0,'thumb_transition','1','effervescence_plus','themes/effervescence_plus'),(251,0,'custom_index_page','','default','themes/default'),(253,0,'effervescence_daily_album_image','1','effervescence_plus','themes/effervescence_plus'),(254,0,'effervescence_daily_album_image_effect','','effervescence_plus','themes/effervescence_plus'),(255,0,'colorbox_effervescence_plus_album','1',NULL,'themes/effervescence_plus/themeoptions.php'),(256,0,'colorbox_effervescence_plus_image','1',NULL,'themes/effervescence_plus/themeoptions.php'),(257,0,'colorbox_effervescence_plus_search','1',NULL,'themes/effervescence_plus/themeoptions.php'),(259,0,'deprecated_getZenpageHitcounter','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(260,0,'deprecated_printImageRating','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(261,0,'deprecated_printAlbumRating','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(262,0,'deprecated_printImageEXIFData','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(263,0,'deprecated_printCustomSizedImageMaxHeight','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(264,0,'deprecated_getCommentDate','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(265,0,'deprecated_getCommentTime','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(266,0,'deprecated_hitcounter','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(267,0,'deprecated_my_truncate_string','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(268,0,'deprecated_getImageEXIFData','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(269,0,'deprecated_getAlbumPlace','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(270,0,'deprecated_printAlbumPlace','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(271,0,'deprecated_printEditable','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(272,0,'deprecated_zenpageHitcounter','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(273,0,'deprecated_rewrite_path_zenpage','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(274,0,'deprecated_getNewsImageTags','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(275,0,'deprecated_printNewsImageTags','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(276,0,'deprecated_getNumSubalbums','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(277,0,'deprecated_getAllSubalbums','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(278,0,'deprecated_addPluginScript','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(279,0,'deprecated_zenJavascript','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(280,0,'deprecated_normalizeColumns','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(281,0,'deprecated_printParentPagesBreadcrumb','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(282,0,'deprecated_isMyAlbum','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(283,0,'deprecated_getSubCategories','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(284,0,'deprecated_inProtectedNewsCategory','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(285,0,'deprecated_isProtectedNewsCategory','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(286,0,'deprecated_getParentNewsCategories','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(287,0,'deprecated_getCategoryTitle','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(288,0,'deprecated_getCategoryID','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(289,0,'deprecated_getCategoryParentID','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(290,0,'deprecated_getCategorySortOrder','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(291,0,'deprecated_getParentPages','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(292,0,'deprecated_isProtectedPage','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(293,0,'deprecated_isMyPage','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(294,0,'deprecated_checkPagePassword','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(295,0,'deprecated_isMyNews','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(296,0,'deprecated_checkNewsAccess','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(297,0,'deprecated_checkNewsCategoryPassword','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(298,0,'deprecated_getCurrentNewsCategory','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(299,0,'deprecated_getCurrentNewsCategoryID','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(300,0,'deprecated_getCurrentNewsCategoryParentID','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(301,0,'deprecated_inNewsCategory','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(302,0,'deprecated_inSubNewsCategoryOf','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(303,0,'deprecated_isSubNewsCategoryOf','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(304,0,'deprecated_printNewsReadMoreLink','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(305,0,'deprecated_getNewsContentShorten','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(306,0,'deprecated_checkForPassword','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(307,0,'deprecated_printAlbumMap','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(308,0,'deprecated_printImageMap','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(309,0,'deprecated_setupAllowedMaps','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(310,0,'deprecated_printPreloadScript','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(311,0,'deprecated_processExpired','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(312,0,'deprecated_getParentItems','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(313,0,'deprecated_getPages','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(314,0,'deprecated_getArticles','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(315,0,'deprecated_countArticles','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(316,0,'deprecated_getLimitAndOffset','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(317,0,'deprecated_getTotalArticles','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(318,0,'deprecated_getAllArticleDates','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(319,0,'deprecated_getCurrentNewsPage','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(320,0,'deprecated_getCurrentAdminNewsPage','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(321,0,'deprecated_getCombiNews','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(322,0,'deprecated_countCombiNews','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(323,0,'deprecated_getCategoryLink','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(324,0,'deprecated_getCategory','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(325,0,'deprecated_getAllCategories','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(326,0,'deprecated_isProtectedAlbum','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(327,0,'deprecated_getRSSHeaderLink','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(328,0,'deprecated_getZenpageRSSHeaderLink','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(329,0,'deprecated_generateCaptcha','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(330,0,'deprecated_getSearchURL','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(331,0,'deprecated_printPasswordForm','1',NULL,'zp-core/zp-extensions/deprecated-functions.php'),(332,0,'tinymce_zenphoto','zenphoto-default.js.php',NULL,'zp-core/zp-extensions/tiny_mce.php'),(333,0,'tinymce_zenpage','zenpage-default-full.js.php',NULL,'zp-core/zp-extensions/tiny_mce.php'),(334,0,'tinymce_tinyzenpage_customimagesize','400',NULL,'zp-core/zp-extensions/tiny_mce.php'),(335,0,'tinymce_tinyzenpage_customthumb_size','120',NULL,'zp-core/zp-extensions/tiny_mce.php'),(336,0,'tinymce_tinyzenpage_customthumb_cropwidth','120',NULL,'zp-core/zp-extensions/tiny_mce.php'),(337,0,'tinymce_tinyzenpage_customthumb_cropheight','120',NULL,'zp-core/zp-extensions/tiny_mce.php'),(338,0,'tinymce_tinyzenpage_flowplayer_width','320',NULL,'zp-core/zp-extensions/tiny_mce.php'),(339,0,'tinymce_tinyzenpage_flowplayer_height','240',NULL,'zp-core/zp-extensions/tiny_mce.php'),(340,0,'zenphoto_seo_lowercase','1',NULL,'zp-core/zp-extensions/zenphoto_seo.php'),(341,0,'hitcounter_ignoreIPList_enable','0',NULL,'zp-core/zp-extensions/hitcounter.php'),(342,0,'hitcounter_ignoreSearchCrawlers_enable','0',NULL,'zp-core/zp-extensions/hitcounter.php'),(343,0,'hitcounter_ignoreIPList','',NULL,'zp-core/zp-extensions/hitcounter.php'),(344,0,'hitcounter_searchCrawlerList','Teoma,alexa, froogle, Gigabot,inktomi, looksmart, URL_Spider_SQL,Firefly, NationalDirectory, Ask Jeeves,TECNOSEEK, InfoSeek, WebFindBot, girafabot, crawler,www.galaxy.com, Googlebot, Scooter, Slurp, msnbot, appie, FAST, WebBug, Spade, ZyBorg, rabaz ,Baiduspider, Feedfetcher-Google, TechnoratiSnoop, Rankivabot, Mediapartners-Google, Sogou web spider, WebAlta Crawler',NULL,'zp-core/zp-extensions/hitcounter.php'),(345,0,'last_garbage_collect','1328813577',NULL,NULL),(346,0,'gallery_sortdirection','0',NULL,NULL),(347,0,'gallery_sorttype','ID',NULL,NULL),(348,0,'gallery_title','Gallery',NULL,NULL),(349,0,'Gallery_description','You can insert your Gallery description on the Admin Options Gallery tab.',NULL,NULL),(350,0,'gallery_password',NULL,NULL,NULL),(351,0,'gallery_user',NULL,NULL,NULL),(352,0,'gallery_hint',NULL,NULL,NULL),(353,0,'hitcounter',NULL,NULL,NULL),(354,0,'current_theme','default',NULL,NULL),(355,0,'website_title',NULL,NULL,NULL),(356,0,'website_url',NULL,NULL,NULL),(357,0,'gallery_security','public',NULL,NULL),(358,0,'login_user_field',NULL,NULL,NULL),(359,0,'album_use_new_image_date',NULL,NULL,NULL),(360,0,'thumb_select_images',NULL,NULL,NULL),(361,0,'persistent_archive',NULL,NULL,NULL),(362,0,'unprotected_pages','a:4:{i:0;s:8:\"register\";i:1;s:7:\"contact\";i:2;s:8:\"register\";i:3;s:7:\"contact\";}',NULL,NULL),(363,0,'album_publish','1',NULL,NULL),(364,0,'image_publish','1',NULL,NULL),(365,0,'picture_of_the_day','a:3:{s:3:\"day\";i:1328813598;s:6:\"folder\";s:8:\"gallery1\";s:8:\"filename\";s:9:\"koala.jpg\";}','effervescence_plus','themes/effervescence_plus'),(366,0,'custom_index_page','','effervescence_plus','themes/effervescence_plus'),(367,0,'custom_index_page','','garland','themes/garland'),(368,0,'custom_index_page','','stopdesign','themes/stopdesign'),(369,0,'zp_plugin_federated_logon','0',NULL,NULL),(370,0,'zp_plugin_seo_locale','0',NULL,NULL),(371,0,'zp_plugin_tweet_news','0',NULL,NULL),(372,0,'zp_plugin_GoogleMap','0',NULL,NULL),(373,0,'zp_plugin_PHPMailer','0',NULL,NULL),(374,0,'zp_plugin_admin-approval','0',NULL,NULL),(375,0,'zp_plugin_ajaxFilemanager','0',NULL,NULL),(376,0,'zp_plugin_auto_backup','0',NULL,NULL),(377,0,'zp_plugin_class-AnyFile','0',NULL,NULL),(378,0,'zp_plugin_class-WEBdocs','0',NULL,NULL),(379,0,'zp_plugin_class-textobject','0',NULL,NULL),(380,0,'zp_plugin_colorbox','0',NULL,NULL),(381,0,'zp_plugin_comment_form','0',NULL,NULL),(382,0,'contactform_introtext','<p>Fields with <strong>*</strong> are required. HTML or any other code is not allowed.</p>',NULL,'zp-core/zp-extensions/contact_form.php'),(383,0,'contactform_confirmtext','<p>Please confirm that you really want to send this email. Thanks.</p>',NULL,'zp-core/zp-extensions/contact_form.php'),(384,0,'contactform_thankstext','<p>Thanks for your message.</p>',NULL,'zp-core/zp-extensions/contact_form.php'),(385,0,'contactform_newmessagelink','Send another message.',NULL,'zp-core/zp-extensions/contact_form.php'),(386,0,'contactform_title','omitted',NULL,'zp-core/zp-extensions/contact_form.php'),(387,0,'contactform_name','required',NULL,'zp-core/zp-extensions/contact_form.php'),(388,0,'contactform_company','omitted',NULL,'zp-core/zp-extensions/contact_form.php'),(389,0,'contactform_street','omitted',NULL,'zp-core/zp-extensions/contact_form.php'),(390,0,'contactform_city','omitted',NULL,'zp-core/zp-extensions/contact_form.php'),(391,0,'contactform_state','omitted',NULL,'zp-core/zp-extensions/contact_form.php'),(392,0,'contactform_postal','omitted',NULL,'zp-core/zp-extensions/contact_form.php'),(393,0,'contactform_country','omitted',NULL,'zp-core/zp-extensions/contact_form.php'),(394,0,'contactform_email','required',NULL,'zp-core/zp-extensions/contact_form.php'),(395,0,'contactform_website','show',NULL,'zp-core/zp-extensions/contact_form.php'),(396,0,'contactform_phone','show',NULL,'zp-core/zp-extensions/contact_form.php'),(397,0,'contactform_captcha','1',NULL,'zp-core/zp-extensions/contact_form.php'),(398,0,'contactform_subject','show',NULL,'zp-core/zp-extensions/contact_form.php'),(399,0,'contactform_message','required',NULL,'zp-core/zp-extensions/contact_form.php'),(400,0,'contactform_confirm','1',NULL,'zp-core/zp-extensions/contact_form.php'),(401,0,'contactform_sendcopy','0',NULL,'zp-core/zp-extensions/contact_form.php'),(402,0,'contactform_sendcopy_text','<p>A copy of your e-mail will automatically be sent to the address you provided for your own records.</p>',NULL,'zp-core/zp-extensions/contact_form.php'),(403,0,'contactform_mailaddress','',NULL,'zp-core/zp-extensions/contact_form.php'),(404,0,'zp_plugin_contact_form','129',NULL,NULL),(405,0,'zp_plugin_crop_image','0',NULL,NULL),(406,0,'zp_plugin_downloadList','0',NULL,NULL),(407,0,'zp_plugin_dynamic-locale','0',NULL,NULL),(408,0,'zp_plugin_email-newuser','0',NULL,NULL),(409,0,'zp_plugin_failed_access_blocker','0',NULL,NULL),(410,0,'zp_plugin_flag_thumbnail','0',NULL,NULL),(411,0,'zp_plugin_flowplayer3','0',NULL,NULL),(412,0,'zp_plugin_googleVerify','0',NULL,NULL),(413,0,'zp_plugin_html_meta_tags','0',NULL,NULL),(414,0,'zp_plugin_http_auth','0',NULL,NULL),(415,0,'zp_plugin_image_album_statistics','0',NULL,NULL),(416,0,'zp_plugin_image_effects','0',NULL,NULL),(417,0,'zp_plugin_image_upload_limiter','0',NULL,NULL),(418,0,'zp_plugin_jcarousel_thumb_nav','0',NULL,NULL),(419,0,'zp_plugin_jplayer','0',NULL,NULL),(420,0,'zp_plugin_menu_manager','0',NULL,NULL),(421,0,'zp_plugin_multiple_layouts','0',NULL,NULL),(422,0,'zp_plugin_paged_thumbs_nav','0',NULL,NULL),(423,0,'zp_plugin_print_album_menu','0',NULL,NULL),(424,0,'zp_plugin_quota_manager','0',NULL,NULL),(425,0,'zp_plugin_rating','0',NULL,NULL),(426,0,'zp_plugin_register_user','0',NULL,NULL),(427,0,'zp_plugin_search_statistics','0',NULL,NULL),(428,0,'zp_plugin_seo_cleanup','0',NULL,NULL),(429,0,'zp_plugin_show_not_logged-in','0',NULL,NULL),(430,0,'zp_plugin_sitemap-extended','0',NULL,NULL),(431,0,'zp_plugin_slideshow','0',NULL,NULL),(432,0,'zp_plugin_static_html_cache','0',NULL,NULL),(433,0,'zp_plugin_tag_extras','0',NULL,NULL),(434,0,'zp_plugin_tag_suggest','0',NULL,NULL),(435,0,'zp_plugin_user-expiry','0',NULL,NULL),(436,0,'zp_plugin_user_groups','0',NULL,NULL),(437,0,'zp_plugin_user_login-out','0',NULL,NULL),(438,0,'zp_plugin_user_mailing_list','0',NULL,NULL),(439,0,'zp_plugin_viewer_size_image','0',NULL,NULL),(440,0,'zp_plugin_wordpress_import','0',NULL,NULL),(441,0,'zp_plugin_xmpMetadata','0',NULL,NULL),(442,0,'zp_plugin_zenpage','0',NULL,NULL),(443,0,'video_watermark_default_images','0',NULL,NULL),(444,0,'hitcounter_set_defaults','',NULL,NULL),(445,0,'use_embedded_thumb','0',NULL,NULL),(446,0,'image_size','595','default','themes/default'),(447,0,'image_use_side','longest','default','themes/default'),(448,0,'thumb_crop','1','default','themes/default'),(449,0,'thumb_size','150','default','themes/default'),(450,0,'thumb_crop_width','150','default','themes/default'),(451,0,'thumb_crop_height','150','default','themes/default'),(452,0,'albums_per_page','6','default','themes/default'),(453,0,'images_per_page','15','default','themes/default'),(454,0,'thumb_gray','0','default','themes/default'),(455,0,'image_gray','0','default','themes/default');

UNLOCK TABLES;

/*Table structure for table `partyyaad_pages` */

DROP TABLE IF EXISTS `partyyaad_pages`;

CREATE TABLE `partyyaad_pages` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` int(11) unsigned DEFAULT NULL,
  `title` text COLLATE utf8_unicode_ci,
  `content` text COLLATE utf8_unicode_ci,
  `extracontent` text COLLATE utf8_unicode_ci,
  `sort_order` varchar(48) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `show` int(1) unsigned NOT NULL DEFAULT '1',
  `titlelink` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commentson` int(1) unsigned DEFAULT '0',
  `codeblock` text COLLATE utf8_unicode_ci,
  `author` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `date` datetime DEFAULT NULL,
  `lastchange` datetime DEFAULT NULL,
  `lastchangeauthor` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `hitcounter` int(11) unsigned DEFAULT '0',
  `permalink` int(1) unsigned NOT NULL DEFAULT '0',
  `locked` int(1) unsigned NOT NULL DEFAULT '0',
  `expiredate` datetime DEFAULT NULL,
  `total_value` int(11) unsigned DEFAULT '0',
  `total_votes` int(11) unsigned DEFAULT '0',
  `used_ips` longtext COLLATE utf8_unicode_ci,
  `rating` float DEFAULT NULL,
  `rating_status` int(1) DEFAULT '3',
  `user` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_hint` text COLLATE utf8_unicode_ci,
  `custom_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `titlelink` (`titlelink`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_pages` */

LOCK TABLES `partyyaad_pages` WRITE;

UNLOCK TABLES;

/*Table structure for table `partyyaad_plugin_storage` */

DROP TABLE IF EXISTS `partyyaad_plugin_storage`;

CREATE TABLE `partyyaad_plugin_storage` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `aux` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `type` (`type`),
  KEY `aux` (`aux`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_plugin_storage` */

LOCK TABLES `partyyaad_plugin_storage` WRITE;

UNLOCK TABLES;

/*Table structure for table `partyyaad_search_cache` */

DROP TABLE IF EXISTS `partyyaad_search_cache`;

CREATE TABLE `partyyaad_search_cache` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `criteria` text COLLATE utf8_unicode_ci,
  `date` datetime DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `criteria` (`criteria`(255))
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_search_cache` */

LOCK TABLES `partyyaad_search_cache` WRITE;

UNLOCK TABLES;

/*Table structure for table `partyyaad_tags` */

DROP TABLE IF EXISTS `partyyaad_tags`;

CREATE TABLE `partyyaad_tags` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `partyyaad_tags` */

LOCK TABLES `partyyaad_tags` WRITE;

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
