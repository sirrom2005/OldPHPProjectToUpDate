/*
SQLyog Community v8.4 RC2
MySQL - 5.5.20-log : Database - rochelle
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`rochelle` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `rochelle`;

/*Table structure for table `accounts` */

DROP TABLE IF EXISTS `accounts`;

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `firstname` tinytext NOT NULL,
  `middlename` tinytext,
  `lastname` tinytext,
  `email` tinytext NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1231349653 DEFAULT CHARSET=utf8;

/*Data for the table `accounts` */

LOCK TABLES `accounts` WRITE;

insert  into `accounts`(`id`,`username`,`password`,`firstname`,`middlename`,`lastname`,`email`,`date_added`) values (1231349652,'admin','5f4dcc3b5aa765d61d8327deb882cf99','ttt','mmm','rose','yaniquemalcolm@ymail.com','2012-02-12 00:00:00');

UNLOCK TABLES;

/*Table structure for table `articles` */

DROP TABLE IF EXISTS `articles`;

CREATE TABLE `articles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext NOT NULL,
  `summary` tinytext,
  `detail` longtext NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2000018 DEFAULT CHARSET=utf8;

/*Data for the table `articles` */

LOCK TABLES `articles` WRITE;

insert  into `articles`(`id`,`title`,`summary`,`detail`,`user_id`,`date_added`) values (2000013,'56t4t34ffc sdfsfsd',NULL,'tytre',1231349652,'2012-03-03 00:00:00'),(2000014,'assdsa sad sad sa dsadsadasdasdas dasdsadasd sadasdsadas dsadsa',NULL,'<p>\r\n	sdfdfddgfd</p>',1231349652,'2012-03-23 03:51:01'),(2000015,'rrrr',NULL,'<p>\r\n	<u><strong><em>rrrrr</em></strong></u><strong><em>   <span style=\"display: none;\"> </span></em></strong><u><strong><em><span style=\"background-color:#00ff00;\">rrrrrrrrrrrrrrrrrrrrxcvdxc</span></em></strong></u><span style=\"display: none;\"> </span></p>',1231349652,'2012-03-23 03:57:10'),(2000017,'asdsa',NULL,'<p>\r\n	dasdas</p>',1231349652,'2012-03-23 03:55:51');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
