/*
SQLyog Enterprise - MySQL GUI v7.02 
MySQL - 5.5.8-log : Database - iree_solar
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*Table structure for table `acc_level` */

CREATE TABLE `acc_level` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `acc_level` */

insert  into `acc_level`(`id`,`name`) values (1,'System Admin');
insert  into `acc_level`(`id`,`name`) values (2,'System User');

/*Table structure for table `accounts` */

CREATE TABLE `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` tinytext NOT NULL,
  `username` tinytext,
  `email` tinytext NOT NULL,
  `password` tinytext NOT NULL,
  `acc_level` int(11) NOT NULL DEFAULT '0',
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

/*Data for the table `accounts` */

insert  into `accounts`(`id`,`fullname`,`username`,`email`,`password`,`acc_level`,`date_added`) values (1,'iceman','admin','sirrom2005@gmail.com','5f4dcc3b5aa765d61d8327deb882cf99',1,'0000-00-00 00:00:00');
insert  into `accounts`(`id`,`fullname`,`username`,`email`,`password`,`acc_level`,`date_added`) values (20,'admin2','admin2','example@example.com','5f4dcc3b5aa765d61d8327deb882cf99',2,'2012-12-09 08:50:55');

/*Table structure for table `app_options` */

CREATE TABLE `app_options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `opt_key` tinytext NOT NULL,
  `opt_name` tinytext NOT NULL,
  `opt_value` tinytext NOT NULL,
  `comment` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `app_options` */

insert  into `app_options`(`id`,`opt_key`,`opt_name`,`opt_value`,`comment`) values (1,'exchange_rate','Exchange Rate JMD:USD','91.00',NULL);
insert  into `app_options`(`id`,`opt_key`,`opt_name`,`opt_value`,`comment`) values (2,'kwh_rate_jmd','kWh Rate (JMD)','40.00',NULL);
insert  into `app_options`(`id`,`opt_key`,`opt_name`,`opt_value`,`comment`) values (3,'kwh_rate_usd','kWh Rate (USD)','0.44',NULL);
insert  into `app_options`(`id`,`opt_key`,`opt_name`,`opt_value`,`comment`) values (4,'derate_factor','DC to AC Derate Factor','0.77',NULL);

/*Table structure for table `quote_list` */

CREATE TABLE `quote_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fullname` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `placetype` tinytext NOT NULL,
  `filename` tinytext NOT NULL,
  `adminUserId` int(11) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

/*Data for the table `quote_list` */

insert  into `quote_list`(`id`,`fullname`,`email`,`placetype`,`filename`,`adminUserId`,`date_added`) values (17,'Mrs. Rohan Davdison','rohan_dalova@hotmail.com','Residence','2012120951302',1,'2012-12-09 08:35:53');
insert  into `quote_list`(`id`,`fullname`,`email`,`placetype`,`filename`,`adminUserId`,`date_added`) values (18,'Mr. jhgjhg ','','Residence','2012120939545',1,'2012-12-09 08:46:41');

/*Table structure for table `template_text` */

CREATE TABLE `template_text` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `detail` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `template_text` */

insert  into `template_text`(`id`,`title`,`detail`) values (1,'Quote Intro','<p>After conducting a site inspection at your residence we were able to design a grid-tied solar power system that will provide, on average, _AVGPOWER_ kWh of power a month.</p>\r\n<p>Based upon the usable roof space at your residence and your current usage of electricity on a  monthly basis, we would recommend installing a _DCRATING_ Kw solar power system.</p>\r\n<p>Please find attached an estimate to install a _DCRATING_ Kw monocrystalline grid-tied solar  power solution. We can provide you with an estimate for a polycrystalline  system should you require it.</p>\r\n<p>Please note that the system can accept more solar modules if you choose to increase  the size of the solar array and consequently, your monthly electricity  production.</p>\r\n<p>A solar array (multiple solar  modules) will generate a certain amount of power for every month of the year  given:</p>\r\n<ul>\r\n  <li>Average solar radiation for the intended installation site for the year (Jamaica)</li>\r\n  <li>Pitch of the roof or intended installation stand</li>\r\n  <li>Bearing of the roof or intended installation stand</li>\r\n  <li>Efficiency of the solar module and inverter being used</li>\r\n</ul>\r\n<p>During our site inspection we gathered this necessary data and based on the aforementioned inputs we have arrived at the following annual electricity production figures (averages) for the _DCRATING_ Kw installed on the usable section/s of  your roof:</p>\r\n');
insert  into `template_text`(`id`,`title`,`detail`) values (2,'Battery based system text','<p>Should you choose to install a hybrid  solar power system that has a 450AH battery back-up bank but is still able to  sell excess electricity back to the public electricity grid.</p>\r\n<p>This system can  also accept a generator to charge the batteries if insufficient solar energy is available and the public electricity grid is down.</p>\r\n<p>This system is the most  versatile solar power system on the market today and ensures that you will  never be without power at your residence (Please review page 14 of the  Schneider Electric Solar Document that is attached).</p>\r\n<p>If you were to purchase the 2Kw hybrid solar power system using cash the total installed cost of the system would be  USD $15.862.76. If you were to make a 10% equity investment towards the system,  NationGrowth Micro Finance could finance the system for a period of 5 years.</p>\r\n<p>The monthly payment for the system would work out to be approximately JMD $26,631  (This figure represents a rough calculation and not a final figure). </p>\r\n');
insert  into `template_text`(`id`,`title`,`detail`) values (3,'Pricing text','<h2>Pricing</h2>\r\n<p>If you were to purchase the _DCRATING_ Kw grid-tied solar power system using  cash the total installed cost of the system would be USD [[$10,945.58]]</p>\r\n<p>If you were to make a 10% equity  investment towards the system, NationGrowth Micro Finance could finance the  system for a period of 5 years.</p> \r\n<p>The monthly payment for the system would work  out to be approximately JMD [[$18,376]] (This figure represents a rough calculation and not a final figure).</p>\r\n');
insert  into `template_text`(`id`,`title`,`detail`) values (4,'Component Parts text','<h2>Component Parts</h2>\r\n<p>\r\nIREE Solar will take care of filing  the standard offer contract (SOC) documentation necessary to be granted a \r\nlicense to interconnect to the national electricity grid in order to be able to  sell any excess power your system generates back to the grid.\r\n<p/>\r\n<p>\r\n  <h3>Solar Modules/Panels:</h3>\r\n  IREE Solar is committed to offering  the highest quality products to our clients and as a direct result of this  philosophy we utilize Suniva solar modules/panels. \r\n  Suniva is an American  manufacturer of high efficiency crystalline silicone photovoltaic solar cells  and high power solar modules. Suniva cells are able to operate at conversion  efficiencies of 19% (monocrystalline) which put them in a class of their own  while still remaining affordable. All Suniva modules/panels are backed by a 10  year workmanship warranty and 25 year linear performance warranty ensuring high  performance for the lifetime of the module/panel. All modules/panel frames are  made from non-corrosive marine grade aluminium.\r\n</p>\r\n<p>\r\n  <h3>Racking &amp;  Hurricanes:</h3>\r\n  All our systems are installed using  SnapNrack aluminium racking systems which guarantee that your solar panels are  securely attached to your roof. \r\n  This racking system is wind tested for severe  wind speeds up to 150 mph. That being said, the beauty of the SnapNrack system \r\n  is that it allows one to easily mount solar panels due to the easy to use  clamps that hold the panels to the rails. \r\n  This also means that it is very easy  to remove the solar panels from the rails if necessary, all one needs to  release the panels from the rail system is a socket set.\r\n</p>\r\n<p>\r\n  <h3><em>SnapNrack Rail with L-Bracket Roof  Attachment &amp; Solar Panel Mid Clamp</em></h3>\r\n  Other racking systems are cumbersome and time  consuming to operate which make taking down your panels in the case of a fast \r\n  approaching hurricane a daunting and time consuming affair. Some installers  actually drill holes into your solar panels to mount them to your roof which is \r\n  not recommend as damage to the solar panels is quite likely to occur during the  process and drilling holes into a solar panel\'s frame will normally void the warranty from the manufacturer.\r\n</p>\r\n<p align=\"center\">Should you require any additional information or wish to view our demo system, please contact us and we would more than happy to assist you.</p>\r\n<p>Please let us know if you require any additional information.</p>\r\n<p>We look forward to your favourable response.</p>\r\n<p>Regards,\r\n<p>Alex Hill<br />\r\nManaging Director</p>');
insert  into `template_text`(`id`,`title`,`detail`) values (5,'New account','Your account for IREE SOLAR has bing created.<br />\r\nyour login information is below.<br /><br />\r\nUsername: _USERNAME_<br />\r\nPassword: _PASSWORD_');
insert  into `template_text`(`id`,`title`,`detail`) values (6,'Email Quote','Hello _CLIENTNAME_<br>\r\ndownload you quote from the link below</p>\r\n\r\n_DOWNLOADLINK_');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;