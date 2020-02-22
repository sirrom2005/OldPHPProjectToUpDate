/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.5.8-log : Database - iree_solar
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `roof_type` */

CREATE TABLE `roof_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

/*Data for the table `roof_type` */

insert  into `roof_type`(`id`,`name`) values (1,'Concrete slab');
insert  into `roof_type`(`id`,`name`) values (2,'Concrete slab with foam');
insert  into `roof_type`(`id`,`name`) values (3,'Dera mastic metal shingles');
insert  into `roof_type`(`id`,`name`) values (4,'Cedar shingles');
insert  into `roof_type`(`id`,`name`) values (5,'Corrugated zinc sheet');
insert  into `roof_type`(`id`,`name`) values (6,'Flat zinc sheet with ridges');
insert  into `roof_type`(`id`,`name`) values (7,'Clay tile shingles');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;