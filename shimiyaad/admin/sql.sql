/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.5.8-log : Database - fimiyaad
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`fimiyaad` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `fimiyaad`;

/*Table structure for table `category` */

DROP TABLE IF EXISTS `category`;

CREATE TABLE `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `url_name` tinytext NOT NULL,
  `cat_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

/*Data for the table `category` */

insert  into `category`(`id`,`name`,`url_name`,`cat_type`) values (1,'Events','events',1),(2,'Products For Sale','products-for-sale',1),(3,'Business','business',1),(16,'Selectors','selectors',2),(17,'Promotors','promotors',2),(18,'DJs & Singers','djs-and-singers',2),(19,'Dancers','dancers',2),(20,'Girls','girls',2),(21,'Jamaica','jamaica',3),(22,'USA','usa',3),(23,'England','england',3),(24,'Canada','canada',3),(25,'Magnum','magnum',3),(26,'Hapilos','hapilos',3);

/*Table structure for table `classified` */

DROP TABLE IF EXISTS `classified`;

CREATE TABLE `classified` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `date_needed` datetime NOT NULL,
  `detail` mediumtext NOT NULL,
  `category_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `classified` */

insert  into `classified`(`id`,`title`,`date_needed`,`detail`,`category_id`,`account_id`,`date_added`) values (3,'the test','2013-03-27 00:00:00','hello world this is a test \"sdfdsfs\" \'dfgdfg\' fgdfgfdgfdggdfgfd',3,5,'2013-02-27 19:14:07');

/*Table structure for table `classified_gallery` */

DROP TABLE IF EXISTS `classified_gallery`;

CREATE TABLE `classified_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classified_id` int(11) NOT NULL,
  `image_name` tinytext NOT NULL,
  `description` mediumtext,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`,`classified_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;

/*Data for the table `classified_gallery` */

insert  into `classified_gallery`(`id`,`classified_id`,`image_name`,`description`,`date_added`) values (28,9,'1345315570.jpg',NULL,'2012-08-18 18:46:10'),(29,0,'1345605094.jpg',NULL,'2012-08-22 03:11:34'),(30,3,'1361991233.jpg',NULL,'2013-02-27 18:53:53');

/*Table structure for table `event` */

DROP TABLE IF EXISTS `event`;

CREATE TABLE `event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `desc` tinytext NOT NULL,
  `image_name` tinytext,
  `event_date` datetime NOT NULL,
  `account_id` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=171 DEFAULT CHARSET=latin1;

/*Data for the table `event` */

insert  into `event`(`id`,`title`,`desc`,`image_name`,`event_date`,`account_id`,`date_added`,`start_date`,`end_date`,`category_id`) values (25,'CHOCOLATE BUNNIES','','1359732247.jpg','2013-12-29 00:00:00',0,'2013-12-27 00:00:00','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(28,'YELLOW AND WHITE','','1359732599.jpg','2013-12-27 00:00:00',0,'2013-12-27 00:00:00','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(40,'EAST SWAGG (VOGUE EDITION PT2)','','1361366331.jpg','2013-04-12 00:00:00',0,'2013-02-20 08:18:52','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(41,'EASTER FIESTA ANNIVERSARY','','1361366368.jpg','2013-04-13 00:00:00',0,'2013-02-20 08:19:28','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(44,'GABREE STAIN BIRTHDAY CELEBRATION','','1361366531.jpg','2013-03-29 00:00:00',0,'2013-02-20 08:22:11','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(50,'WEAR WEH YUH WEAR ALREADY','','1361382015.jpg','2013-04-06 00:00:00',0,'2013-02-20 12:40:15','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(59,'G STRING DANCEHALL BACCHANAL','','1361750830.jpg','2013-03-30 00:00:00',0,'2013-02-24 19:07:10','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(60,'SEA FOOD EXTRAVAGANZA','','1361750892.jpg','2013-03-29 00:00:00',0,'2013-02-24 19:08:12','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(61,'SEA FOOD EXTRAVAGANZA','','1361750939.jpg','2013-03-29 00:00:00',0,'2013-02-24 19:09:01','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(64,'ANYWHERE WE GO (PART8)','','1362004240.jpg','2013-05-25 00:00:00',0,'2013-02-27 17:30:41','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(65,'NAKED KISS (LIPS N BOOZE)','','1362004350.jpg','2013-04-27 00:00:00',0,'2013-02-27 17:32:30','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(66,'(BANDIT ENT PRESENTS) SKYFALL FASHION SUPREMACY','','1362004491.jpg','2013-04-06 00:00:00',0,'2013-02-27 17:34:51','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(67,'INDEPENDENT LADIES','','1362004729.jpg','2013-03-30 00:00:00',0,'2013-02-27 17:38:49','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(68,'INDEPENDENT LADIES','','1362004780.jpg','2013-03-30 00:00:00',0,'2013-02-27 17:39:40','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(74,'FIVE STAR (SIMPLY ELEGANT)','','1362005346.jpg','2013-03-29 00:00:00',0,'2013-02-27 17:49:06','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(75,'FIVE STAR (SIMPLY ELEGANT)','','1362005372.jpg','2013-03-29 00:00:00',0,'2013-02-27 17:49:33','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(76,'MAGNUM ST CATHRINE DANCEHALL QUEEN','','1362005491.jpg','2013-04-06 00:00:00',0,'2013-02-27 17:51:31','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(77,'CHANGE CLOTHES AND POSE','','1362005568.jpg','2013-04-05 00:00:00',0,'2013-02-27 17:52:48','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(78,'CHANGE CLOTHES AND POSE','','1362005597.jpg','2013-04-05 00:00:00',0,'2013-02-27 17:53:17','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(80,'HENNESSY VS MOET','','1362005681.jpg','2013-04-03 00:00:00',0,'2013-02-27 17:54:41','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(81,'HENNESSY VS MOET','','1362005707.jpg','2013-04-03 00:00:00',0,'2013-02-27 17:55:08','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(82,'YELLOW AND WHITE PT3 SEMI FORMAL EDITION','','1362005835.jpg','2013-05-11 00:00:00',0,'2013-02-27 17:57:15','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(83,'YELLOW AND WHITE PT3 SEMI FORMAL EDITION','','1362005868.jpg','2013-05-11 00:00:00',0,'2013-02-27 17:57:48','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(84,'THE RETURN OF CELDIN ON THE BEACH','','1362008432.jpg','2013-03-31 00:00:00',0,'2013-02-27 18:40:32','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(86,'ALL STARS BEACH PARTY','','1362013706.jpg','2013-06-08 00:00:00',0,'2013-02-27 20:08:26','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(87,'CHOCOLATE BUNNIES','','1362461102.jpg','2013-03-29 00:00:00',0,'2013-03-05 00:25:02','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(88,'NICKFOTO DARING POOL PARTY','','1362461191.jpg','2013-04-07 00:00:00',0,'2013-03-05 00:26:32','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(90,'G STRING DANCEHALL BACCHANAL','','1362461524.jpg','2013-03-30 00:00:00',0,'2013-03-05 00:32:04','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(91,'JUNCTION DAWG ALL WHITE AFFAIR','','1362461584.jpg','2013-04-13 00:00:00',0,'2013-03-05 00:33:04','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(92,'LEON COOKOUT AND PARTY','','1362461650.jpg','2013-04-05 00:00:00',0,'2013-03-05 00:34:10','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(93,'WET WET (THE SWIMSUIT EDITION)','','1362461749.jpg','2013-03-31 00:00:00',0,'2013-03-05 00:35:49','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(94,'GOD A DI REAL BIG MAN','','1362461841.jpg','2013-04-19 00:00:00',0,'2013-03-05 00:37:21','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(95,'GOD A DI REAL BIG MAN','','1362461867.jpg','2013-04-19 00:00:00',0,'2013-03-05 00:37:47','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(97,'LUKI FABULOUS (YELLOW & WHITE)','','1362462006.jpg','2013-04-02 00:00:00',0,'2013-03-05 00:40:07','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(100,'THE ULTIMATE GLOW PARTY (ILLUMINA) The College Edition','','1362462398.jpg','2013-03-28 00:00:00',0,'2013-03-05 00:46:38','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(103,'GAL FARM MEETS SEXY IN BLACK','','1362462723.jpg','2013-03-30 00:00:00',0,'2013-03-05 00:52:03','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(104,'SHIZZLE (PICTURE PERFECT VOL2)','','1362463352.jpg','2013-04-03 00:00:00',0,'2013-03-05 01:02:32','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(105,'MARK COOK OUT','','1362522060.jpg','2013-03-30 00:00:00',0,'2013-03-05 17:21:00','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(106,'MARK COOK OUT.','','1362522283.jpg','2013-03-30 00:00:00',0,'2013-03-05 17:24:43','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(107,'SWAGG ANNIVERSARY PT4 (IMAGE EDITION)','','1362522479.jpg','2013-04-12 00:00:00',0,'2013-03-05 17:27:59','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(108,'SWAGG ANNIVERSARY PT4 (IMAGE EDITION)','','1362522537.jpg','2013-04-12 00:00:00',0,'2013-03-05 17:28:57','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(109,'LUKI FABULOUS (YELLOW & WHITE) . X1','','1362522853.jpg','2013-04-02 00:00:00',0,'2013-03-05 17:34:13','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(110,'NEW JERSEY LINK UP (HENNESSY VS CIROC EDITION)','','1362526096.jpg','2013-05-11 00:00:00',0,'2013-03-05 18:28:17','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(111,'NEW JERSEY LINK UP (HENNESSY VS CIROC EDITION) ....','','1362526127.jpg','2013-05-11 00:00:00',0,'2013-03-05 18:28:47','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(112,'RUM BAR RUM SPRING BREAK','','1362526197.jpg','2013-03-30 00:00:00',0,'2013-03-05 18:29:57','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(113,'CELEBRATING NAGE SHERLOCK BDAY','','1362667125.jpg','2013-03-28 00:00:00',0,'2013-03-07 09:38:46','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(114,'GQ MEETS VOGUE .','','1362667335.jpg','2013-04-04 00:00:00',0,'2013-03-07 09:42:15','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(115,'GQ MEETS VOGUE ..','','1362667387.jpg','2013-04-04 00:00:00',0,'2013-03-07 09:43:07','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(116,'RUM BAR RUM LINSTEAD CARNIVAL','','1362668062.jpg','2013-04-21 00:00:00',0,'2013-03-07 09:54:23','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(117,'RUM BAR RUM LINSTEAD CARNIVAL','','1362668109.jpg','2013-04-21 00:00:00',0,'2013-03-07 09:55:09','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(118,'FLASHY LIFE PT2','','1362759674.jpg','2013-05-18 00:00:00',0,'2013-03-08 11:21:14','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(121,'HOUSE OF LADIES (BOTTLES EDITION)','','1363107025.jpg','2013-03-27 00:00:00',0,'2013-03-12 12:50:25','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(122,'HOUSE OF LADIES (BOTTLES EDITION)','','1363107118.jpg','2013-03-27 00:00:00',0,'2013-03-12 12:51:59','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(123,'SUMMER IS HERE','','1363141575.jpg','2013-07-06 00:00:00',0,'2013-03-12 22:26:16','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(124,'GRAMPS DRINK OUT (CLUB KHAOTIK)','','1363141675.jpg','2013-04-27 00:00:00',0,'2013-03-12 22:27:55','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(125,'2013 ARIES BALL','','1363176941.jpg','2013-04-13 00:00:00',0,'2013-03-13 08:15:42','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(126,'CHANDOR','','1363177183.jpg','2013-05-04 00:00:00',0,'2013-03-13 08:19:43','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(127,'WATER PARTY (CARNIVAL EDITION)','','1363177618.jpg','2013-04-14 00:00:00',0,'2013-03-13 08:26:58','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(128,'WATER PARTY (CARNIVAL EDITION)','','1363177640.jpg','2013-04-14 00:00:00',0,'2013-03-13 08:27:20','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(129,'FIMIYAAD BEACH COUTURE','','1363177824.jpg','2013-04-28 00:00:00',0,'2013-03-13 08:30:24','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(133,'LET ME LOVE YOU WITH MY HEELS ON','','1363274109.jpg','2013-04-07 00:00:00',0,'2013-03-14 11:15:09','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(136,'MOVADO','','1363362060.jpg','2013-03-31 00:00:00',0,'2013-03-15 11:41:00','2013-12-07 00:00:00','2014-12-27 00:00:00',22),(140,'MIKEY SPENG BLUE AND WHITE AFFAIR','','1363362498.jpg','2013-04-11 00:00:00',0,'2013-03-15 11:48:19','2013-12-07 00:00:00','2014-12-27 00:00:00',22),(141,'CANDICE POSH BIRTHDAY BASH','','1363362541.jpg','2013-04-14 00:00:00',0,'2013-03-15 11:49:01','2013-12-07 00:00:00','2014-12-27 00:00:00',22),(142,'MIGHTY JOE YOUNG 11TH ANNIVERSARY (MY SCHEME)','','1363362601.jpg','2013-03-30 00:00:00',0,'2013-03-15 11:50:01','2013-12-07 00:00:00','2014-12-27 00:00:00',22),(143,'LALA POSH PARTY','','1363362639.jpg','2013-07-05 00:00:00',0,'2013-03-15 11:50:40','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(144,'SHERLY JUICE (SWEATS & ANYTHING)','','1363362688.jpg','2013-03-28 00:00:00',0,'2013-03-15 11:51:28','2013-12-07 00:00:00','2014-12-27 00:00:00',22),(146,'MAGNUM OVERDOSE DRINK INCLUSIVE POOL PARTY','','1363542617.jpg','2013-03-31 00:00:00',0,'2013-03-17 13:50:17','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(148,'EASTER JAM BOAT RIDE','','1363542930.jpg','2013-03-30 00:00:00',0,'2013-03-17 13:55:31','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(149,'EASTER JAM BOAT RIDE.','','1363542953.jpg','2013-03-30 00:00:00',0,'2013-03-17 13:55:53','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(150,'GIRLS RUSH','','1363542986.jpg','2013-04-01 00:00:00',0,'2013-03-17 13:56:26','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(151,'GIRLS RUSH.','','1363543015.jpg','2013-04-01 00:00:00',0,'2013-03-17 13:56:55','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(152,'SASSY IN BLACK','','1363543160.jpg','2013-05-04 00:00:00',0,'2013-03-17 13:59:21','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(153,'DD BIRTHNITE RAVE (THE FASHION AVANT GARDE) MAY 24. 2013','','1363543317.jpg','2013-05-24 00:00:00',0,'2013-03-17 14:01:57','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(154,'DD BIRTHNITE RAVE (THE FASHION AVANT GARDE) MAY 24. 2013 ,','','1363543349.jpg','2013-05-24 00:00:00',0,'2013-03-17 14:02:30','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(155,'WATER PARTY (CARNIVAL EDITION)','','1363543490.jpg','2013-04-06 00:00:00',0,'2013-03-17 14:04:51','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(156,'WATER PARTY (CARNIVAL EDITION).','','1363543519.jpg','2013-04-06 00:00:00',0,'2013-03-17 14:05:19','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(159,'SHIZZLE (PICTURE PERFECT) VOL2','','1364410086.jpg','2013-04-03 00:00:00',0,'2013-03-27 14:48:06','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(160,'MR COOKOUT BIRTHDAY BASH','','1364411743.jpg','2013-05-10 00:00:00',0,'2013-03-27 15:15:44','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(161,'MR COOKOUT BIRTHDAY BASH.','','1364411789.jpg','2013-05-10 00:00:00',0,'2013-03-27 15:16:29','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(162,'WORTHY GOLD FROLIK (PLAYFUL DESIRES)','','1364412015.jpeg','2013-03-30 00:00:00',0,'2013-03-27 15:20:15','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(163,'WORTHY GOLD FROLIK (PLAYFUL DESIRES).','','1364412047.jpeg','2013-03-30 00:00:00',0,'2013-03-27 15:20:47','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(164,'MI NAH STOP SHINE, DEM BETTA KNO SEH MI NAH','','1364412386.jpg','2013-04-20 00:00:00',0,'2013-03-27 15:26:26','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(165,'SHANNA FLAVOUR (BIRTHDAY STYLE COOKOUT)','','1364412451.jpg','2013-05-10 00:00:00',0,'2013-03-27 15:27:31','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(166,'FLOSS & FASHION','','1364412788.jpg','2013-04-20 00:00:00',0,'2013-03-27 15:33:09','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(167,'CONQUERING LION EXTREME WET','','1364412949.jpg','2013-04-21 00:00:00',0,'2013-03-27 15:35:49','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(168,'MEMORIAL STYLE (IN HONOUR OF WILLY HAGGART)','','1364413136.jpg','2013-04-19 00:00:00',0,'2013-03-27 15:38:56','2013-12-07 00:00:00','2014-12-27 00:00:00',21),(169,'hhfhfghhfg','','1387345287.jpg','2013-12-20 00:00:00',0,'2013-12-18 05:41:27','2013-12-01 00:00:00','2013-12-31 00:00:00',21),(170,'tttt','','1387345356.jpg','2013-12-20 00:00:00',0,'2013-12-18 05:42:37','2013-12-01 00:00:00','2013-12-31 00:00:00',22);

/*Table structure for table `news-category` */

DROP TABLE IF EXISTS `news-category`;

CREATE TABLE `news-category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `url_name` tinytext NOT NULL,
  `sort_order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `news-category` */

insert  into `news-category`(`id`,`name`,`url_name`,`sort_order`) values (1,'My Views','my-views',3),(2,'About Jamaica','about-jamaica',4),(3,'Profiles','profiles',2),(4,'Reviews','reviews',1);

/*Table structure for table `news_articles` */

DROP TABLE IF EXISTS `news_articles`;

CREATE TABLE `news_articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `summary` tinytext NOT NULL,
  `detail` mediumtext NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT '1',
  `video` tinytext,
  `audio` tinytext,
  `news_date` datetime NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `news_articles` */

insert  into `news_articles`(`id`,`title`,`summary`,`detail`,`category_id`,`video`,`audio`,`news_date`,`date_added`) values (2,'x-men 5','war aginst the world war aginst the world war aginst the world war ','<p>Tamil <span data-scayt_word=\"Nadu\" data-scaytid=\"1\">Nadu</span>, a state known for its model teacher-student relation, went chillon Thursday, Feb 9, 2012 when a 15-year-old schoolboy murdered his Hindi teacher in the class room in front of his classmates.</p>\r\n<p>Thirty-nine year old <span data-scayt_word=\"Uma\" data-scaytid=\"2\">Uma</span> <span data-scayt_word=\"Maheswari\" data-scaytid=\"3\">Maheswari</span>, the Hindi teacher of the St Mary&rsquo;sAnglo Indian School, situated just opposite to Madras High Court, was stabbed in the neck, stomach and back by the student (name withheld as he is a minor).</p>\r\n<p>Father A <span data-scayt_word=\"Bosco\" data-scaytid=\"44\">Bosco</span>, the school administrator, told reporters that the incident took place at 10 50 in the morning. Though <span data-scayt_word=\"Uma\" data-scaytid=\"36\">Uma</span> <span data-scayt_word=\"Maheswari\" data-scaytid=\"39\">Maheswari</span> was rushed to General Hospital, she had succumbed to the wounds.</p>\r\n<p>The boy, who rushed out of the classroom was overpowered by the school staff and handed over to the police. He had been sent to the juvenile home. According to Father <span data-scayt_word=\"Bosco\" data-scaytid=\"45\">Bosco</span>, <span data-scayt_word=\"Uma\" data-scaytid=\"37\">Uma</span> <span data-scayt_word=\"Maheswari\" data-scaytid=\"40\">Maheswari</span> used to write in the school diary about the not so satisfactory performance of the student in his studies and he got enraged over this. The administrator also said that the boy had come to the class with the knife hidden in his bag.</p>\r\n<p>\"He ran ahead of the rest of the class mates to enter the classroom, to see the teacher sitting on her chair. He went up to her, drew out the knife and began stabbing her,\" said <span data-scayt_word=\"Bosco\" data-scaytid=\"46\">Bosco</span>. The few students in the classroom were so dazed and shocked that they could not believe what they were seeing. Soon they raised an alarm that brought the teachers from other classes, who rushed the bleeding <span data-scayt_word=\"Maheswari\" data-scaytid=\"41\">Maheswari</span> to the government hospital, where she was declared brought dead.</p>\r\n<p>Most of the students described the teacher as an affable person. Students, parents and teachers were yet to come out of the shock over such a ghastly killing inside a school, described as the first of its kind in the state, according to police officials.</p>',1,NULL,NULL,'2012-09-09 00:00:00','2012-08-06 00:00:00'),(8,'Street Vybz rum is back....','After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum. After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum. After disap','<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.<br /><br />In 2011, the rum was discontinued after a falling-out with the business partners. According to Todd, because of the overwhelming demand for the rum, they were obligated to supply it.<br /><br />Although it has been off the market for months, Todd believes that nothing needs to be different this time around.<br /><br />\"Nothing needs to be different about Street Vybz rum. The fans of Vybz Kartel loved it just the way it was. It was the rum that changed the rum market in Jamaica for dancehall patrons. We made rum cool and no longer for rum heads. No one can take that accomplishment from us. The only thing is that we will now explore the export opportunities that were passed on because of the split, so Street Vybz will become a international brand shortly,\" Todd told THE STAR.<br /><br />With Kartel\'s incarceration, Todd stated that there was only so much the artiste could do in terms of marketing.<br /><br />\"The name of the rum is Street \'Vybz\', so \'Vybz\' Kartel will always be the face of the product. Other artistes in the Gaza will hold some of the weight until he returns. Tommy Lee is the hottest \'un-incarcerated\' artiste right now so he\'s a very appropriate representative for the product,\" he said.<br /><br />There are also plans to diversify the rum by adding new flavours.<br /><br />\"Right now all the major wholesales have placed their orders so fans can check every chiney man,\" Todd said.\"<br /><br />Todd\'s other rum, Yaad Swag, which was introduced shortly after the discontinuation of Street Vybz is now no longer on the market.<br /><br />\"No Yaad Swag. The people say Street Vybz rum,\" Todd said. <br /><br /></p>',3,'',NULL,'2012-02-01 00:00:00','2012-08-23 19:48:26'),(9,'Todd\'s has officially relaunched Street Vybz rum. shelves following a split with Vybz Karte\'sl','After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum. After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum. After disap','<table class=\"newspaperlayout\" style=\"width: 98%;\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tr>\r\n<td class=\"lay_l\" valign=\"top\" width=\"50%\" height=\"300\"><img style=\"float: left;\" src=\"../images/content/news/9/250_1359148272.jpg\" alt=\"\" width=\"250\" height=\"197\" />\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n</td>\r\n<td class=\"lay_l\" valign=\"top\" width=\"50%\">\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n</td>\r\n</tr>\r\n\r\n</table>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.</p>\r\n<p>lay_l</p>',1,NULL,NULL,'2012-11-01 00:00:00','2012-11-01 12:06:57'),(10,'my review 111','the revi1','<p>dfdsf dsf fd fsdf sd</p>',4,NULL,NULL,'2013-03-01 00:00:00','2013-03-01 02:01:44'),(11,'Gaza tugs','The real gaza tugs, a gaza dem fi life know dat puss hole.','<table class=\"newspaperlayout\" style=\"width: 98%;\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">\r\n\r\n<tr>\r\n<td class=\"lay_l\" valign=\"top\" width=\"50%\" height=\"300\">After disappearing from shelves following a split with Vybz Kartel, Corey Todd has officially relaunched Street Vybz rum.<br /><br />In 2011, the rum was discontinued after a falling-out with the business partners. According to Todd, because of the overwhelming demand for the rum, they were obligated to supply it.<br /><br />Although it has been off the market for months, Todd believes that nothing needs to be different this time around.<br /><br />\"Nothing needs to be different about Street Vybz rum. The fans of Vybz Kartel loved it just the way it was. It was the rum that changed the rum market in Jamaica for dancehall patrons. We made rum cool and no longer for rum heads. No one can take that accomplishment from us. The only thing is that we will now explore the export opportunities that were passed on because of the split, so Street Vybz will become a international brand shortly,\" Todd told THE STAR.<br /><br />With Kartel\'s incarceration, Todd stated that there was only so much the artiste could do in terms of marketing.</td>\r\n<td class=\"lay_r\" valign=\"top\" width=\"50%\">\"The name of the rum is Street \'Vybz\', so \'Vybz\' Kartel will always be the face of the product. Other artistes in the Gaza will hold some of the weight until he returns. Tommy Lee is the hottest \'un-incarcerated\' artiste right now so he\'s a very appropriate representative for the product,\" he said.<br /><br />There are also plans to diversify the rum by adding new flavours.<br /><br />\"Right now all the major wholesales have placed their orders so fans can check every chiney man,\" Todd said.\"<br /><br />Todd\'s other rum, Yaad Swag, which was introduced shortly after the discontinuation of Street Vybz is now no longer on the market.<br /><br />\"No Yaad Swag. The people say Street Vybz rum,\" Todd said.</td>\r\n</tr>\r\n\r\n</table>',3,'','1363040055.mp3','2013-03-11 00:00:00','2013-03-11 22:05:36');

/*Table structure for table `news_articles_images` */

DROP TABLE IF EXISTS `news_articles_images`;

CREATE TABLE `news_articles_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `image_name` tinytext NOT NULL,
  `description` tinytext,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `news_articles_images` */

insert  into `news_articles_images`(`id`,`news_id`,`image_name`,`description`,`date_added`) values (5,1,'1345750908.jpg',NULL,'2012-08-23 19:41:48'),(6,1,'1345750915.jpg',NULL,'2012-08-23 19:41:55'),(7,3,'1345751047.jpg',NULL,'2012-08-23 19:44:07'),(8,3,'1345751053.png',NULL,'2012-08-23 19:44:13'),(9,8,'1345753136.jpg',NULL,'2012-08-23 20:18:56'),(12,2,'1358794763.jpg',NULL,'2013-01-21 18:59:23'),(14,9,'1359148272.jpg',NULL,'2013-01-25 21:11:12'),(15,9,'1359148650.gif',NULL,'2013-01-25 21:17:30'),(16,9,'1359148667.jpg',NULL,'2013-01-25 21:17:47'),(17,11,'1363039974.jpg',NULL,'2013-03-11 22:12:55'),(18,11,'1363039980.jpg',NULL,'2013-03-11 22:13:01'),(19,11,'1363039988.jpg',NULL,'2013-03-11 22:13:08'),(20,11,'1363039993.jpg',NULL,'2013-03-11 22:13:13');

/*Table structure for table `news_gallery_tags` */

DROP TABLE IF EXISTS `news_gallery_tags`;

CREATE TABLE `news_gallery_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `gallery_tag` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;

/*Data for the table `news_gallery_tags` */

insert  into `news_gallery_tags`(`id`,`news_id`,`gallery_tag`) values (15,2,1),(21,8,1),(24,11,2),(25,11,1);

/*Table structure for table `people` */

DROP TABLE IF EXISTS `people`;

CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` tinytext NOT NULL,
  `lname` tinytext,
  `username` tinytext,
  `email` tinytext,
  `pass` tinytext,
  `fb_id` double DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `people` */

insert  into `people`(`id`,`fname`,`lname`,`username`,`email`,`pass`,`fb_id`,`date_added`) values (1,'admin',NULL,'admin',NULL,'5f4dcc3b5aa765d61d8327deb882cf99',NULL,'2012-09-08 00:00:00');

/*Table structure for table `profile` */

DROP TABLE IF EXISTS `profile`;

CREATE TABLE `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `summary` tinytext NOT NULL,
  `detail` mediumtext NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `profile` */

insert  into `profile`(`id`,`title`,`summary`,`detail`,`category_id`,`date_added`) values (1,'buffy the buddy slayer ','buffy the buddy slayer from kingston buffy the buddy slayer from kingston buffy the buddy slayer from kingston buffy the buddy slayer from kingston ','buffy the buddy slayer from kingston buffy the buddy slayer from kingston  buffy the buddy slayer from kingston buffy the buddy slayer from kingston ',20,'2012-02-02 00:00:00'),(2,'chin chin','dfdasf adsf dsfdsf dfaadsf fdf fsdf','mmmmmmmm mgmghgh dfgfdgf fffffff fddddd er ttttttttttt dfffffd fffffffff g\r\nfdg\r\nfdgf d\r\ngdfg',20,'2013-03-03 00:00:00'),(3,'nxt dancer','fdgfdg fdgfd','fd gfdg fdgfdgfdgfdg',20,'2013-03-04 00:00:00'),(4,'dj rush','ziping','more zipping',20,'2012-03-04 00:00:00');

/*Table structure for table `profile_gallery` */

DROP TABLE IF EXISTS `profile_gallery`;

CREATE TABLE `profile_gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `profile_id` int(11) NOT NULL,
  `image_name` tinytext NOT NULL,
  `description` mediumtext,
  `default_img` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`,`profile_id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `profile_gallery` */

insert  into `profile_gallery`(`id`,`profile_id`,`image_name`,`description`,`default_img`,`date_added`) values (1,1,'1345315570.jpg',NULL,0,'2013-01-22 00:00:00');

/*Table structure for table `site_search_tags` */

DROP TABLE IF EXISTS `site_search_tags`;

CREATE TABLE `site_search_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `tags` tinytext,
  `url` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `site_search_tags` */

insert  into `site_search_tags`(`id`,`title`,`tags`,`url`) values (2,'Contact us','contact\r\nadvertise','contact-us.htm'),(4,'Photo Gallery','photo\r\ngallery\r\npictures\r\nalbums\r\nimages','photo-gallery/'),(7,'Upcoming Events','events','events/'),(8,'Latest News','news\r\narticles\r\nreviews','news-articles/'),(9,'Profiles','profiles\r\ndancers\r\ndjs\r\nsingers\r\ngirls\r\npromotors\r\nselectors\r\n\r\n','profiles/'),(10,'Classifieds','classifieds\r\ncomputers\r\njob \r\nvacancy\r\nland\r\nproperty\r\nmotor\r\nvehicle\r\nphones \r\nfor sale\r\nwanted\r\nproduct\r\nproduct\r\nservices\r\n','classifieds/');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
