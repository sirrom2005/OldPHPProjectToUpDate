/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.1.30-community-log : Database - dh
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `newsletterlist` */

DROP TABLE IF EXISTS `newsletterlist`;

CREATE TABLE `newsletterlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `newsletterlist` */

insert  into `newsletterlist`(`id`,`email`) values (1,'test@test.com');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
