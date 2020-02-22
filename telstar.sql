/*
SQLyog Community v8.4 RC2
MySQL - 5.1.36-community-log : Database - telstar_cms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`telstar_cms` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `telstar_cms`;

/*Table structure for table `admin_users` */

DROP TABLE IF EXISTS `admin_users`;

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  `user_name` tinytext NOT NULL,
  `email` tinytext,
  `password` tinytext NOT NULL,
  `register_date` datetime DEFAULT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `user_level` int(11) NOT NULL DEFAULT '0',
  `enable` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `admin_users` */

LOCK TABLES `admin_users` WRITE;

insert  into `admin_users`(`id`,`name`,`user_name`,`email`,`password`,`register_date`,`last_login_date`,`user_level`,`enable`) values (1,'admin','admin',NULL,'5f4dcc3b5aa765d61d8327deb882cf99',NULL,'2009-11-16 11:47:43',0,1);

UNLOCK TABLES;

/*Table structure for table `odb_transaction` */

DROP TABLE IF EXISTS `odb_transaction`;

CREATE TABLE `odb_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_date` datetime DEFAULT NULL,
  `trans_states` tinytext,
  `client_id` tinytext,
  `telstar_account_name` tinytext NOT NULL,
  `amount` double DEFAULT NULL,
  `ipaddress` tinytext,
  `transaction_code` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=utf8;

/*Data for the table `odb_transaction` */

LOCK TABLES `odb_transaction` WRITE;

insert  into `odb_transaction`(`id`,`trans_date`,`trans_states`,`client_id`,`telstar_account_name`,`amount`,`ipaddress`,`transaction_code`) values (1,'2009-11-20 08:25:02','Fraudulent payment','435435','',2000,'66.54.115.112',''),(2,'2009-11-20 08:25:16','Fraudulent payment','435435','',5000,'66.54.115.112',''),(3,'2009-11-20 08:25:23','System error','435435','',5000,'66.54.115.112',''),(4,'2009-11-20 08:25:32','Badcard','435435','',1200,'66.54.115.112',''),(5,'2009-11-20 08:25:37','Badcard','435435','',1200,'66.54.115.112',''),(6,'2009-11-20 08:25:43','Successful payment','435435','',200,'66.54.115.112',''),(7,'2009-11-19 08:25:49','Successful payment','435435','',800,'66.54.115.112',''),(8,'2009-11-18 08:25:54','Successful payment','435435','',800,'66.54.115.112',''),(9,'2009-11-20 08:26:09','Successful payment','123456','',950.66,'66.54.115.112',''),(10,'2009-11-20 08:26:21','Badcard','113456','',1950,'66.54.115.112',''),(11,'2009-11-20 08:26:26','Fraudulent payment','113456','',1950,'66.54.115.112',''),(12,'2009-11-20 08:27:37','Fraudulent payment','client_id','',0,'66.54.115.112',''),(13,'2009-11-20 08:28:03','Successful payment','565445','',555,'66.54.115.112',''),(14,'2009-11-20 08:28:09','Fraudulent payment','565445','',555,'66.54.115.112',''),(15,'2009-11-25 08:30:24','System error','544354','',555555,'66.54.115.112',''),(16,'2009-11-25 08:30:33','Successful payment','544354','',1000,'66.54.115.112',''),(17,'2009-11-26 10:34:13','Successful payment','443456','',55.77,'66.54.115.112',''),(18,'2009-12-01 00:13:08','System error','001-02','',3,'72.27.175.59',''),(19,'2009-12-01 00:13:21','System error','001-02','',3,'72.27.175.59',''),(20,'2009-12-01 10:45:52','System error','23367','',2250,'72.27.145.229',''),(21,'2009-12-02 22:11:18','System error','103770','',2097,'72.27.104.197',''),(22,'2009-12-02 22:12:35','System error','103770','',2097,'72.27.104.197',''),(23,'2009-12-11 20:00:24','System error','25270','',2097,'208.131.191.77',''),(24,'2009-12-11 20:05:11','System error','025270','',2069.99,'208.131.191.77',''),(25,'2009-12-11 20:13:48','Fraudulent payment','25270','',2096.99,'208.131.191.77',''),(26,'2009-12-17 18:23:10','System error','026289','',2500,'72.27.88.129',''),(27,'2009-12-29 09:44:50','Badcard','026883','',1075.01,'208.163.49.139',''),(28,'2009-12-29 09:45:31','Badcard','026883','',1075.01,'208.163.49.139',''),(29,'2009-12-29 09:49:35','Badcard','26883','',1075.01,'208.163.49.139',''),(30,'2009-12-29 09:50:19','Fraudulent payment','26883','',1075.01,'208.163.49.139',''),(31,'2010-01-08 15:53:31','Successful payment','45646','',120,'65.183.14.86',''),(32,'2010-01-08 16:57:42','System error','4567','',5000,'65.183.14.86',''),(33,'2010-01-08 16:58:38','System error','4567','',5000,'65.183.14.86',''),(34,'2010-01-08 16:59:18','System error','45678','',5000,'65.183.14.86',''),(35,'2010-01-08 16:59:42','System error','45678','',5000,'65.183.14.86',''),(36,'2010-01-08 17:00:02','Successful payment','45678','',100,'65.183.14.86',''),(37,'2010-01-19 09:21:27','Successful payment','123456','',1,'208.163.53.146',''),(38,'2010-01-26 09:13:10','Fraudulent payment','client_id','',0,'66.54.115.112',''),(39,'2010-02-03 10:30:49','System error','client_id','',55,'66.54.115.112',''),(40,'2010-02-03 10:31:30','System error','client_id','',773,'66.54.115.112',''),(41,'2010-02-16 08:05:54','System error','123456','',2000,'208.163.53.146',''),(42,'2010-02-16 08:09:20','Badcard','123456','',2000,'208.163.53.146',''),(43,'2010-02-16 08:14:47','System error','123456','',1,'208.163.53.146',''),(44,'2010-02-16 08:16:08','Successful payment','123456','',1,'208.163.53.146',''),(45,'2010-02-16 08:17:39','Successful payment','123456','',1,'208.163.53.146',''),(46,'2010-02-16 08:18:09','Successful payment','123456','',1,'208.163.53.146',''),(47,'2010-02-16 09:24:23','Badcard','123456','',1,'208.163.53.146',''),(48,'2010-02-16 10:12:19','System error','client_id','',55,'66.54.115.112',''),(49,'2010-02-16 10:13:24','System error','client_id','',55,'66.54.115.112',''),(50,'2010-02-16 11:59:26','Successful payment','12345','',1,'208.163.53.146',''),(51,'2010-02-16 12:00:25','Successful payment','12345','',1,'208.163.53.146',''),(52,'2010-02-22 09:11:29','Fraudulent payment','client_id','',0,'66.54.115.112','Invalid Credit Card Number.|Credit Card Expiration Date Expired.|'),(53,'2010-02-22 09:13:43','Fraudulent payment','client_id','',0,'66.54.115.112','Invalid Credit Card Number.|Credit Card Expiration Date Expired.|'),(54,'2010-02-22 09:14:01','Fraudulent payment','client_id','',0,'66.54.115.112','Invalid Credit Card Number.|'),(55,'2010-02-22 09:14:21','Fraudulent payment','client_id','',0,'66.54.115.112','Invalid Credit Card Number.|Invalid Credit Card CVV2/CVC2 Number.|'),(56,'2010-02-22 09:14:54','Fraudulent payment','client_id','',0,'66.54.115.112','Invalid Credit Card Number.|'),(57,'2010-02-22 09:15:16','Badcard','client_id','',0,'66.54.115.112','Amount must be greater than 0.00'),(58,'2010-02-22 09:15:57','System error','client_id','',500,'66.54.115.112','92: InvalidIssuer'),(59,'2010-02-22 09:16:55','System error','113456','',100,'66.54.115.112','92: InvalidIssuer'),(60,'2010-02-22 09:18:47','Successful payment','113456','',100,'66.54.115.112',''),(61,'2010-02-22 09:24:03','Fraudulent payment','client_id','',0,'66.54.115.112','Invalid Credit Card Number.|Credit Card Expiration Date Expired.|'),(62,'2010-02-22 09:35:20','Fraudulent payment','','',0,'66.54.115.112','Invalid Credit Card Number.|Credit Card Expiration Date Expired.|'),(63,'2010-02-22 10:33:36','Fraudulent payment','client_id','',0,'66.54.115.112','Invalid Credit Card Number.|Credit Card Expiration Date Expired.|'),(64,'2010-02-22 10:34:10','Successful payment','113456','',100,'66.54.115.112',''),(65,'2010-02-22 10:37:10','Successful payment','565445','',766,'66.54.115.112',''),(66,'2010-02-22 10:39:17','System error','client_id','',459,'66.54.115.112','92: InvalidIssuer'),(67,'2010-02-22 10:43:30','System error','544354','',500,'66.54.115.112','92: InvalidIssuer'),(68,'2010-02-22 10:44:49','System error','565445','',100,'66.54.115.112','92: InvalidIssuer'),(69,'2010-02-22 10:45:57','Successful payment','565445','',100,'66.54.115.112',''),(70,'2010-02-23 11:12:23','Successful payment','447774','',1,'208.163.53.146','00: '),(71,'2010-02-23 11:17:08','Successful payment','12345','',1,'208.163.53.146','00: '),(72,'2010-02-23 11:18:55','Badcard','014580','',1,'208.163.53.146','05: UnableToProcess'),(73,'2010-02-24 09:40:14','Successful payment','007','',555,'66.54.115.112',''),(74,'2010-02-24 09:54:07','Successful payment','client_id','',455,'66.54.115.112',''),(75,'2010-02-24 10:19:01','Successful payment','5656','',555,'66.54.115.112',''),(76,'2010-02-24 10:20:26','Successful payment','client_id','',66,'66.54.115.112',''),(77,'2010-02-24 10:22:17','Successful payment','66666','',34,'66.54.115.112',''),(78,'2010-02-24 10:23:24','Fraudulent payment','client_id','',0,'66.54.115.112','Invalid Credit Card Number.|Credit Card Expiration Date Expired.|'),(79,'2010-02-24 10:24:31','Successful payment','76767','',44,'66.54.115.112',''),(80,'2010-03-02 12:19:25','Successful payment','12345','',1,'208.163.53.146','00: '),(81,'2010-03-02 12:28:52','Badcard','121231','',1,'208.163.53.146','05: UnableToProcess'),(82,'2010-03-02 12:31:03','Successful payment','123456','',1,'208.163.53.146','00: '),(83,'2010-03-02 12:33:58','Successful payment','222333','',1,'208.163.53.146','00: '),(84,'2010-03-02 12:35:31','Successful payment','444222','',2,'208.163.53.146','00: '),(85,'2010-03-05 11:00:03','Fraudulent payment','client_id','',0,'66.54.115.112','Invalid Credit Card Number.|Credit Card Expiration Date Expired.|'),(86,'2010-03-05 11:33:09','Fraudulent payment','client_id','',0,'66.54.115.112','Invalid Credit Card Number.|Invalid Credit Card CVV2/CVC2 Number.|Credit Card Expiration Date Expired.|'),(87,'2010-03-11 14:29:01','Successful payment','123456','',1,'208.163.53.146','00: '),(88,'2010-03-11 14:31:01','Successful payment','100000','',1,'208.163.53.146','00: '),(89,'2010-03-11 14:32:41','Fraudulent payment','123456','',1,'208.163.53.146','Invalid Credit Card CVV2/CVC2 Number.|'),(90,'2010-03-11 14:34:00','Successful payment','123456','',1,'208.163.53.146','00: '),(91,'2010-03-11 14:39:59','Badcard','123456','',1,'208.163.53.146','05: UnableToProcess'),(92,'2010-03-11 14:41:51','Badcard','454563','',1,'208.163.53.146','51: NoFunds'),(93,'2010-03-11 14:44:17','Badcard','123456','',1.05,'208.163.53.146','51: NoFunds'),(94,'2010-03-11 14:46:17','Badcard','456789','',1,'208.163.53.146','51: NoFunds'),(95,'2010-03-11 15:53:17','Badcard','123000','',1.05,'208.163.53.146','51: NoFunds'),(96,'2010-03-11 15:57:06','Badcard','123123','',1,'208.163.53.146','51: NoFunds'),(97,'2010-03-11 16:46:23','Badcard','123456','',1.02,'208.163.53.146','51: NoFunds'),(98,'2010-03-11 16:48:47','Badcard','123456','',1,'208.163.53.146','05: UnableToProcess'),(99,'2010-03-11 16:50:02','Successful payment','123456','',1,'208.163.53.146','00: '),(100,'2010-03-12 08:19:41','Successful payment','123456','',1,'208.163.53.146','00: '),(101,'2010-03-16 13:19:02','Successful payment','987654','',500,'65.183.14.86','00: '),(102,'2010-03-16 13:54:32','Successful payment','456789','',350,'65.183.14.86','00: '),(103,'2010-03-24 10:47:23','Successful payment','435435','telstar_account_name',700,'66.54.115.112','92: InvalidIssuer'),(104,'2010-04-01 10:48:12','Successful payment','456789','John Doe',350,'65.183.14.86','00: '),(105,'2010-04-07 12:02:49','Successful payment','11345','Brendan Dunn',100,'65.183.11.50','00: '),(106,'2010-04-09 11:05:46','System error','client_id','55555',555,'66.54.115.112','92: InvalidIssuer'),(107,'2010-04-09 11:08:24','System error','client_id','555',223,'66.54.115.112','92: InvalidIssuer'),(108,'2010-04-09 11:09:39','Successful payment','554','telstar_account_name',500,'66.54.115.112',''),(109,'2010-04-09 13:57:45','System error','client_id','telstar_account_name',555,'66.54.115.112','92: InvalidIssuer'),(110,'2010-04-12 10:47:10','Successful payment','11345','Brendan Dr Dunn',100,'65.183.11.50','00: '),(111,'2010-04-13 22:34:46','Successful payment','234','Test',50,'72.27.25.2','00: '),(112,'2010-04-14 09:03:06','Successful payment','123','telstar_account_name',500,'66.54.115.112',''),(113,'2010-04-14 09:06:00','Successful payment','344','telstar_account_name',4.19,'66.54.115.112',''),(114,'2010-04-14 09:14:54','Successful payment','56','telstar account name',100,'66.54.115.112','');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
