-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 27, 2011 at 09:52 AM
-- Server version: 5.5.8
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mp3`
--

-- --------------------------------------------------------

--
-- Table structure for table `odb_account`
--

DROP TABLE IF EXISTS `odb_account`;
CREATE TABLE IF NOT EXISTS `odb_account` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` tinytext,
  `mname` tinytext,
  `lname` tinytext,
  `dob` date DEFAULT NULL,
  `email` tinytext,
  `occupation` tinytext,
  `password` tinytext,
  `address1` tinytext,
  `address2` tinytext,
  `city` tinytext,
  `state` tinytext,
  `zip_code` tinytext,
  `country_id` tinytext,
  `date_added` date DEFAULT NULL,
  `account_type` int(11) DEFAULT '3',
  `enable` int(11) DEFAULT '1',
  `credit_amount` int(11) DEFAULT '0',
  `bio` longtext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `odb_account`
--

INSERT INTO `odb_account` (`id`, `fname`, `mname`, `lname`, `dob`, `email`, `occupation`, `password`, `address1`, `address2`, `city`, `state`, `zip_code`, `country_id`, `date_added`, `account_type`, `enable`, `credit_amount`, `bio`) VALUES
(49, 'admin', '', '', '1988-02-23', 'test@test.com', 'admin for this site', '5f4dcc3b5aa765d61d8327deb882cf99', '10 part lane', 'kng 12', 'portmore', '', '', '106', '2010-05-17', 1, 1, 2198, 'The admin of the world'),
(55, 'sirrom', 'm', 'rose', '1990-03-22', 'sirrom2005@gmail.com', 'music man', '5f4dcc3b5aa765d61d8327deb882cf99', 'address1', 'address2', 'city', 'state', 'zip_code', '223', '2010-07-07', 2, 1, 536, 'The 1st producer');

-- --------------------------------------------------------

--
-- Table structure for table `odb_account_type`
--

DROP TABLE IF EXISTS `odb_account_type`;
CREATE TABLE IF NOT EXISTS `odb_account_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `odb_account_type`
--

INSERT INTO `odb_account_type` (`id`, `name`) VALUES
(1, 'Administrator'),
(2, 'Producer'),
(3, 'Member');

-- --------------------------------------------------------

--
-- Table structure for table `odb_album_art`
--

DROP TABLE IF EXISTS `odb_album_art`;
CREATE TABLE IF NOT EXISTS `odb_album_art` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mp3_id` int(11) DEFAULT NULL,
  `image_name` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `odb_album_art`
--


-- --------------------------------------------------------

--
-- Table structure for table `odb_artistes`
--

DROP TABLE IF EXISTS `odb_artistes`;
CREATE TABLE IF NOT EXISTS `odb_artistes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `stagename` tinytext,
  `fname` tinytext,
  `mname` tinytext,
  `lname` tinytext,
  `gender` tinytext,
  `photo` tinytext,
  `bio` longtext,
  `producer_id` int(11) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `odb_artistes`
--

INSERT INTO `odb_artistes` (`id`, `stagename`, `fname`, `mname`, `lname`, `gender`, `photo`, `bio`, `producer_id`, `date_added`) VALUES
(1, 'gaza BIG', '', '', '', 'male', '20110427_84808.jpg', '<p>zxcZXZXZX dsadas</p>', 55, '2010-10-08'),
(2, 'ice', '', '', '', 'male', '20110427_49429.jpg', '<p>sd d sad as dsa d sadasdsadasd</p>', 55, '2010-10-08'),
(3, 'iceman', '', '', '', 'male', '20110427_38644.jpg', '<p>sfdsfdsfdf dsfdsfdfiuf dfdsfo dfpodsfsd fsfd dfdsfdsfdfs</p>', 55, '2010-10-08');

-- --------------------------------------------------------

--
-- Table structure for table `odb_content`
--

DROP TABLE IF EXISTS `odb_content`;
CREATE TABLE IF NOT EXISTS `odb_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page` tinytext,
  `title` tinytext,
  `detail` longtext,
  `date_added` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `odb_content`
--

INSERT INTO `odb_content` (`id`, `page`, `title`, `detail`, `date_added`) VALUES
(3, 'about', 'about', '<p>sdfdsf sd fsdf sd fsdfsd fsdfsd</p>', '2010-07-07'),
(4, 'terms', 'Terms & Conditions', '<p>Terms &amp; Conditions ewrwerwe rwer werwe rwerwer we</p>', '2010-07-27'),
(5, 'legal', 'legal', '<p>sadasda sdasd asdasdas dasdas das dasdasdasdas dasdsadasdas dasdasd as</p>', '2010-07-27'),
(6, 'sell_your_music', 'Sell your music', '<p>sell_your_music</p>', NULL),
(7, 'advertise', 'Advertise with us', '<p>advertise</p>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `odb_country`
--

DROP TABLE IF EXISTS `odb_country`;
CREATE TABLE IF NOT EXISTS `odb_country` (
  `country_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `iso_code_2` varchar(2) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `iso_code_3` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `address_format` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`country_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=240 ;

--
-- Dumping data for table `odb_country`
--

INSERT INTO `odb_country` (`country_id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`) VALUES
(1, 'Afghanistan', 'AF', 'AFG', ''),
(2, 'Albania', 'AL', 'ALB', ''),
(3, 'Algeria', 'DZ', 'DZA', ''),
(4, 'American Samoa', 'AS', 'ASM', ''),
(5, 'Andorra', 'AD', 'AND', ''),
(6, 'Angola', 'AO', 'AGO', ''),
(7, 'Anguilla', 'AI', 'AIA', ''),
(8, 'Antarctica', 'AQ', 'ATA', ''),
(9, 'Antigua and Barbuda', 'AG', 'ATG', ''),
(10, 'Argentina', 'AR', 'ARG', ''),
(11, 'Armenia', 'AM', 'ARM', ''),
(12, 'Aruba', 'AW', 'ABW', ''),
(13, 'Australia', 'AU', 'AUS', ''),
(14, 'Austria', 'AT', 'AUT', ''),
(15, 'Azerbaijan', 'AZ', 'AZE', ''),
(16, 'Bahamas', 'BS', 'BHS', ''),
(17, 'Bahrain', 'BH', 'BHR', ''),
(18, 'Bangladesh', 'BD', 'BGD', ''),
(19, 'Barbados', 'BB', 'BRB', ''),
(20, 'Belarus', 'BY', 'BLR', ''),
(21, 'Belgium', 'BE', 'BEL', ''),
(22, 'Belize', 'BZ', 'BLZ', ''),
(23, 'Benin', 'BJ', 'BEN', ''),
(24, 'Bermuda', 'BM', 'BMU', ''),
(25, 'Bhutan', 'BT', 'BTN', ''),
(26, 'Bolivia', 'BO', 'BOL', ''),
(27, 'Bosnia and Herzegowina', 'BA', 'BIH', ''),
(28, 'Botswana', 'BW', 'BWA', ''),
(29, 'Bouvet Island', 'BV', 'BVT', ''),
(30, 'Brazil', 'BR', 'BRA', ''),
(31, 'British Indian Ocean Territory', 'IO', 'IOT', ''),
(32, 'Brunei Darussalam', 'BN', 'BRN', ''),
(33, 'Bulgaria', 'BG', 'BGR', ''),
(34, 'Burkina Faso', 'BF', 'BFA', ''),
(35, 'Burundi', 'BI', 'BDI', ''),
(36, 'Cambodia', 'KH', 'KHM', ''),
(37, 'Cameroon', 'CM', 'CMR', ''),
(38, 'Canada', 'CA', 'CAN', ''),
(39, 'Cape Verde', 'CV', 'CPV', ''),
(40, 'Cayman Islands', 'KY', 'CYM', ''),
(41, 'Central African Republic', 'CF', 'CAF', ''),
(42, 'Chad', 'TD', 'TCD', ''),
(43, 'Chile', 'CL', 'CHL', ''),
(44, 'China', 'CN', 'CHN', ''),
(45, 'Christmas Island', 'CX', 'CXR', ''),
(46, 'Cocos (Keeling) Islands', 'CC', 'CCK', ''),
(47, 'Colombia', 'CO', 'COL', ''),
(48, 'Comoros', 'KM', 'COM', ''),
(49, 'Congo', 'CG', 'COG', ''),
(50, 'Cook Islands', 'CK', 'COK', ''),
(51, 'Costa Rica', 'CR', 'CRI', ''),
(52, 'Cote D''Ivoire', 'CI', 'CIV', ''),
(53, 'Croatia', 'HR', 'HRV', ''),
(54, 'Cuba', 'CU', 'CUB', ''),
(55, 'Cyprus', 'CY', 'CYP', ''),
(56, 'Czech Republic', 'CZ', 'CZE', ''),
(57, 'Denmark', 'DK', 'DNK', ''),
(58, 'Djibouti', 'DJ', 'DJI', ''),
(59, 'Dominica', 'DM', 'DMA', ''),
(60, 'Dominican Republic', 'DO', 'DOM', ''),
(61, 'East Timor', 'TP', 'TMP', ''),
(62, 'Ecuador', 'EC', 'ECU', ''),
(63, 'Egypt', 'EG', 'EGY', ''),
(64, 'El Salvador', 'SV', 'SLV', ''),
(65, 'Equatorial Guinea', 'GQ', 'GNQ', ''),
(66, 'Eritrea', 'ER', 'ERI', ''),
(67, 'Estonia', 'EE', 'EST', ''),
(68, 'Ethiopia', 'ET', 'ETH', ''),
(69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', ''),
(70, 'Faroe Islands', 'FO', 'FRO', ''),
(71, 'Fiji', 'FJ', 'FJI', ''),
(72, 'Finland', 'FI', 'FIN', ''),
(73, 'France', 'FR', 'FRA', ''),
(74, 'France, Metropolitan', 'FX', 'FXX', ''),
(75, 'French Guiana', 'GF', 'GUF', ''),
(76, 'French Polynesia', 'PF', 'PYF', ''),
(77, 'French Southern Territories', 'TF', 'ATF', ''),
(78, 'Gabon', 'GA', 'GAB', ''),
(79, 'Gambia', 'GM', 'GMB', ''),
(80, 'Georgia', 'GE', 'GEO', ''),
(81, 'Germany', 'DE', 'DEU', ''),
(82, 'Ghana', 'GH', 'GHA', ''),
(83, 'Gibraltar', 'GI', 'GIB', ''),
(84, 'Greece', 'GR', 'GRC', ''),
(85, 'Greenland', 'GL', 'GRL', ''),
(86, 'Grenada', 'GD', 'GRD', ''),
(87, 'Guadeloupe', 'GP', 'GLP', ''),
(88, 'Guam', 'GU', 'GUM', ''),
(89, 'Guatemala', 'GT', 'GTM', ''),
(90, 'Guinea', 'GN', 'GIN', ''),
(91, 'Guinea-bissau', 'GW', 'GNB', ''),
(92, 'Guyana', 'GY', 'GUY', ''),
(93, 'Haiti', 'HT', 'HTI', ''),
(94, 'Heard and Mc Donald Islands', 'HM', 'HMD', ''),
(95, 'Honduras', 'HN', 'HND', ''),
(96, 'Hong Kong', 'HK', 'HKG', ''),
(97, 'Hungary', 'HU', 'HUN', ''),
(98, 'Iceland', 'IS', 'ISL', ''),
(99, 'India', 'IN', 'IND', ''),
(100, 'Indonesia', 'ID', 'IDN', ''),
(101, 'Iran (Islamic Republic of)', 'IR', 'IRN', ''),
(102, 'Iraq', 'IQ', 'IRQ', ''),
(103, 'Ireland', 'IE', 'IRL', ''),
(104, 'Israel', 'IL', 'ISR', ''),
(105, 'Italy', 'IT', 'ITA', ''),
(106, 'Jamaica', 'JM', 'JAM', ''),
(107, 'Japan', 'JP', 'JPN', ''),
(108, 'Jordan', 'JO', 'JOR', ''),
(109, 'Kazakhstan', 'KZ', 'KAZ', ''),
(110, 'Kenya', 'KE', 'KEN', ''),
(111, 'Kiribati', 'KI', 'KIR', ''),
(112, 'Korea, Democratic People''s Republic of', 'KP', 'PRK', ''),
(113, 'Korea, Republic of', 'KR', 'KOR', ''),
(114, 'Kuwait', 'KW', 'KWT', ''),
(115, 'Kyrgyzstan', 'KG', 'KGZ', ''),
(116, 'Lao People''s Democratic Republic', 'LA', 'LAO', ''),
(117, 'Latvia', 'LV', 'LVA', ''),
(118, 'Lebanon', 'LB', 'LBN', ''),
(119, 'Lesotho', 'LS', 'LSO', ''),
(120, 'Liberia', 'LR', 'LBR', ''),
(121, 'Libyan Arab Jamahiriya', 'LY', 'LBY', ''),
(122, 'Liechtenstein', 'LI', 'LIE', ''),
(123, 'Lithuania', 'LT', 'LTU', ''),
(124, 'Luxembourg', 'LU', 'LUX', ''),
(125, 'Macau', 'MO', 'MAC', ''),
(126, 'Macedonia, The Former Yugoslav Republic of', 'MK', 'MKD', ''),
(127, 'Madagascar', 'MG', 'MDG', ''),
(128, 'Malawi', 'MW', 'MWI', ''),
(129, 'Malaysia', 'MY', 'MYS', ''),
(130, 'Maldives', 'MV', 'MDV', ''),
(131, 'Mali', 'ML', 'MLI', ''),
(132, 'Malta', 'MT', 'MLT', ''),
(133, 'Marshall Islands', 'MH', 'MHL', ''),
(134, 'Martinique', 'MQ', 'MTQ', ''),
(135, 'Mauritania', 'MR', 'MRT', ''),
(136, 'Mauritius', 'MU', 'MUS', ''),
(137, 'Mayotte', 'YT', 'MYT', ''),
(138, 'Mexico', 'MX', 'MEX', ''),
(139, 'Micronesia, Federated States of', 'FM', 'FSM', ''),
(140, 'Moldova, Republic of', 'MD', 'MDA', ''),
(141, 'Monaco', 'MC', 'MCO', ''),
(142, 'Mongolia', 'MN', 'MNG', ''),
(143, 'Montserrat', 'MS', 'MSR', ''),
(144, 'Morocco', 'MA', 'MAR', ''),
(145, 'Mozambique', 'MZ', 'MOZ', ''),
(146, 'Myanmar', 'MM', 'MMR', ''),
(147, 'Namibia', 'NA', 'NAM', ''),
(148, 'Nauru', 'NR', 'NRU', ''),
(149, 'Nepal', 'NP', 'NPL', ''),
(150, 'Netherlands', 'NL', 'NLD', ''),
(151, 'Netherlands Antilles', 'AN', 'ANT', ''),
(152, 'New Caledonia', 'NC', 'NCL', ''),
(153, 'New Zealand', 'NZ', 'NZL', ''),
(154, 'Nicaragua', 'NI', 'NIC', ''),
(155, 'Niger', 'NE', 'NER', ''),
(156, 'Nigeria', 'NG', 'NGA', ''),
(157, 'Niue', 'NU', 'NIU', ''),
(158, 'Norfolk Island', 'NF', 'NFK', ''),
(159, 'Northern Mariana Islands', 'MP', 'MNP', ''),
(160, 'Norway', 'NO', 'NOR', ''),
(161, 'Oman', 'OM', 'OMN', ''),
(162, 'Pakistan', 'PK', 'PAK', ''),
(163, 'Palau', 'PW', 'PLW', ''),
(164, 'Panama', 'PA', 'PAN', ''),
(165, 'Papua New Guinea', 'PG', 'PNG', ''),
(166, 'Paraguay', 'PY', 'PRY', ''),
(167, 'Peru', 'PE', 'PER', ''),
(168, 'Philippines', 'PH', 'PHL', ''),
(169, 'Pitcairn', 'PN', 'PCN', ''),
(170, 'Poland', 'PL', 'POL', ''),
(171, 'Portugal', 'PT', 'PRT', ''),
(172, 'Puerto Rico', 'PR', 'PRI', ''),
(173, 'Qatar', 'QA', 'QAT', ''),
(174, 'Reunion', 'RE', 'REU', ''),
(175, 'Romania', 'RO', 'ROM', ''),
(176, 'Russian Federation', 'RU', 'RUS', ''),
(177, 'Rwanda', 'RW', 'RWA', ''),
(178, 'Saint Kitts and Nevis', 'KN', 'KNA', ''),
(179, 'Saint Lucia', 'LC', 'LCA', ''),
(180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', ''),
(181, 'Samoa', 'WS', 'WSM', ''),
(182, 'San Marino', 'SM', 'SMR', ''),
(183, 'Sao Tome and Principe', 'ST', 'STP', ''),
(184, 'Saudi Arabia', 'SA', 'SAU', ''),
(185, 'Senegal', 'SN', 'SEN', ''),
(186, 'Seychelles', 'SC', 'SYC', ''),
(187, 'Sierra Leone', 'SL', 'SLE', ''),
(188, 'Singapore', 'SG', 'SGP', ''),
(189, 'Slovakia (Slovak Republic)', 'SK', 'SVK', ''),
(190, 'Slovenia', 'SI', 'SVN', ''),
(191, 'Solomon Islands', 'SB', 'SLB', ''),
(192, 'Somalia', 'SO', 'SOM', ''),
(193, 'South Africa', 'ZA', 'ZAF', ''),
(194, 'South Georgia and the South Sandwich Islands', 'GS', 'SGS', ''),
(195, 'Spain', 'ES', 'ESP', ''),
(196, 'Sri Lanka', 'LK', 'LKA', ''),
(197, 'St. Helena', 'SH', 'SHN', ''),
(198, 'St. Pierre and Miquelon', 'PM', 'SPM', ''),
(199, 'Sudan', 'SD', 'SDN', ''),
(200, 'Suriname', 'SR', 'SUR', ''),
(201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', ''),
(202, 'Swaziland', 'SZ', 'SWZ', ''),
(203, 'Sweden', 'SE', 'SWE', ''),
(204, 'Switzerland', 'CH', 'CHE', ''),
(205, 'Syrian Arab Republic', 'SY', 'SYR', ''),
(206, 'Taiwan', 'TW', 'TWN', ''),
(207, 'Tajikistan', 'TJ', 'TJK', ''),
(208, 'Tanzania, United Republic of', 'TZ', 'TZA', ''),
(209, 'Thailand', 'TH', 'THA', ''),
(210, 'Togo', 'TG', 'TGO', ''),
(211, 'Tokelau', 'TK', 'TKL', ''),
(212, 'Tonga', 'TO', 'TON', ''),
(213, 'Trinidad and Tobago', 'TT', 'TTO', ''),
(214, 'Tunisia', 'TN', 'TUN', ''),
(215, 'Turkey', 'TR', 'TUR', ''),
(216, 'Turkmenistan', 'TM', 'TKM', ''),
(217, 'Turks and Caicos Islands', 'TC', 'TCA', ''),
(218, 'Tuvalu', 'TV', 'TUV', ''),
(219, 'Uganda', 'UG', 'UGA', ''),
(220, 'Ukraine', 'UA', 'UKR', ''),
(221, 'United Arab Emirates', 'AE', 'ARE', ''),
(222, 'United Kingdom', 'GB', 'GBR', ''),
(223, 'United States', 'US', 'USA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city}, {zone} {postcode}\r\n{country}'),
(224, 'United States Minor Outlying Islands', 'UM', 'UMI', ''),
(225, 'Uruguay', 'UY', 'URY', ''),
(226, 'Uzbekistan', 'UZ', 'UZB', ''),
(227, 'Vanuatu', 'VU', 'VUT', ''),
(228, 'Vatican City State (Holy See)', 'VA', 'VAT', ''),
(229, 'Venezuela', 'VE', 'VEN', ''),
(230, 'Viet Nam', 'VN', 'VNM', ''),
(231, 'Virgin Islands (British)', 'VG', 'VGB', ''),
(232, 'Virgin Islands (U.S.)', 'VI', 'VIR', ''),
(233, 'Wallis and Futuna Islands', 'WF', 'WLF', ''),
(234, 'Western Sahara', 'EH', 'ESH', ''),
(235, 'Yemen', 'YE', 'YEM', ''),
(236, 'Yugoslavia', 'YU', 'YUG', ''),
(237, 'Zaire', 'ZR', 'ZAR', ''),
(238, 'Zambia', 'ZM', 'ZMB', ''),
(239, 'Zimbabwe', 'ZW', 'ZWE', '');

-- --------------------------------------------------------

--
-- Table structure for table `odb_credit_cost`
--

DROP TABLE IF EXISTS `odb_credit_cost`;
CREATE TABLE IF NOT EXISTS `odb_credit_cost` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `credit` int(11) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `odb_credit_cost`
--

INSERT INTO `odb_credit_cost` (`id`, `credit`, `cost`) VALUES
(1, 50, 100),
(2, 100, 200),
(3, 300, 300),
(4, 400, 400),
(5, 500, 450),
(6, 1000, 1000),
(7, 2000, 1500);

-- --------------------------------------------------------

--
-- Table structure for table `odb_credit_purchase`
--

DROP TABLE IF EXISTS `odb_credit_purchase`;
CREATE TABLE IF NOT EXISTS `odb_credit_purchase` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trans_date` timestamp NULL DEFAULT NULL,
  `trans_states` tinytext,
  `client_id` tinytext,
  `credit_amount` int(11) DEFAULT NULL,
  `amount` double DEFAULT NULL,
  `ipaddress` tinytext,
  `transaction_code` tinytext,
  `order_id` tinytext,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `odb_credit_purchase`
--

INSERT INTO `odb_credit_purchase` (`id`, `trans_date`, `trans_states`, `client_id`, `credit_amount`, `amount`, `ipaddress`, `transaction_code`, `order_id`) VALUES
(6, '2010-07-07 14:22:52', 'Successful payment', '55', 1000, 1000, '66.54.115.112', '', '2010070720224527297'),
(5, '2010-07-07 14:21:42', 'Successful payment', '55', 100, 200, '66.54.115.112', '', '2010070720213520711'),
(7, '2010-07-07 14:23:26', 'Successful payment', '55', 50, 100, '66.54.115.112', '', '2010070720231911478'),
(8, '2010-07-07 14:28:21', 'Badcard', '55', 2000, 1500, '66.54.115.112', 'Insufficient Funds', '2010070720281527287'),
(9, '2010-07-07 14:28:41', 'Fraud', '55', 2000, 1500, '66.54.115.112', 'Invalid Credit Card Number.|Credit Card Expiration Date Expired.|', '2010070720283518162'),
(10, '2010-07-07 14:29:27', 'Fraud', '55', 50, 100, '66.54.115.112', 'Invalid Credit Card Number.|Credit Card Expiration Date Expired.|', '2010070720292111390'),
(11, '2010-12-05 03:18:57', 'Unkonw', '49', 2000, 1500, '127.0.0.1', '', ''),
(12, '2010-12-05 03:21:20', 'Unkonw', '49', 2000, 1500, '127.0.0.1', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `odb_faqs`
--

DROP TABLE IF EXISTS `odb_faqs`;
CREATE TABLE IF NOT EXISTS `odb_faqs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `detail` longtext,
  `date_added` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `odb_faqs`
--

INSERT INTO `odb_faqs` (`id`, `title`, `detail`, `date_added`) VALUES
(3, 'Question 1', '<p>bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla bla</p>', '2010-07-07'),
(4, 'Question 2', '<p>more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text</p>', NULL),
(5, 'Question 3', '<p>more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text more text</p>', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `odb_mp3`
--

DROP TABLE IF EXISTS `odb_mp3`;
CREATE TABLE IF NOT EXISTS `odb_mp3` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `filename` tinytext,
  `filesize` tinytext,
  `detail` longtext,
  `riddim_id` int(11) DEFAULT NULL,
  `label` tinytext,
  `keywords` tinytext,
  `credit_amount` int(11) DEFAULT NULL,
  `producer_id` int(11) DEFAULT NULL,
  `featured` int(11) DEFAULT '0',
  `downloaded` int(11) DEFAULT '0',
  `date_added` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=63 ;

--
-- Dumping data for table `odb_mp3`
--

INSERT INTO `odb_mp3` (`id`, `title`, `filename`, `filesize`, `detail`, `riddim_id`, `label`, `keywords`, `credit_amount`, `producer_id`, `featured`, `downloaded`, `date_added`) VALUES
(8, 'Beethoven''s_Symphony_No._9_Scherzo', 'Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', '', 1, '', '', 10, 55, 0, 1, '2010-10-08'),
(9, 'Beethoven''s_Symphony_No._9_Scherzo', 'Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', '', 2, '', '', 5, 55, 0, 0, '2010-10-08'),
(7, 'New_Stories_Highway_Blues', 'New_Stories_Highway_Blues.wma', '760748', '', 2, 'labl 1', '', 5, 55, 0, 0, '2010-10-08'),
(10, 'Copy_2_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_2_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', '', 2, '', '', 10, 55, 0, 0, '2010-10-08'),
(11, 'Copy_2_of_New_Stories_Highway_Blues', 'Copy_2_of_New_Stories_Highway_Blues.wma', '760748', '', 2, '', '', 12, 55, 0, 1, '2010-10-08'),
(12, 'Copy_3_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_3_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', '', 2, '', '', 10, 55, 0, 0, '2010-10-08'),
(13, 'Copy_3_of_New_Stories_Highway_Blues', 'Copy_3_of_New_Stories_Highway_Blues.wma', '760748', '', 1, '', '', 5, 55, 0, 0, '2010-10-08'),
(14, 'Copy_4_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_4_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', '', 2, '', '', 10, 55, 0, 0, '2010-10-08'),
(15, 'Copy_4_of_New_Stories_Highway_Blues', 'Copy_4_of_New_Stories_Highway_Blues.wma', '760748', '', 2, '', '', 8, 55, 0, 0, '2010-10-08'),
(16, 'Copy_5_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_5_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(17, 'Copy_5_of_New_Stories_Highway_Blues', 'Copy_5_of_New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(18, 'Copy_6_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_6_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(19, 'Copy_6_of_New_Stories_Highway_Blues', 'Copy_6_of_New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(20, 'Copy_7_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_7_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(21, 'Copy_7_of_New_Stories_Highway_Blues', 'Copy_7_of_New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(22, 'Copy_8_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_8_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(23, 'Copy_8_of_New_Stories_Highway_Blues', 'Copy_8_of_New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(24, 'Copy_9_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_9_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(25, 'Copy_9_of_New_Stories_Highway_Blues', 'Copy_9_of_New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(26, 'Copy_10_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_10_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(27, 'Copy_10_of_New_Stories_Highway_Blues', 'Copy_10_of_New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(28, 'Copy_11_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_11_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(29, 'Copy_11_of_New_Stories_Highway_Blues', 'Copy_11_of_New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(30, 'Copy_12_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_12_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(31, 'Copy_12_of_New_Stories_Highway_Blues', 'Copy_12_of_New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(32, 'Copy_13_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_13_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(33, 'Copy_13_of_New_Stories_Highway_Blues', 'Copy_13_of_New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(34, 'Copy_of_Beethoven''s_Symphony_No._9_Scherzo', 'Copy_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(35, 'Copy_of_New_Stories_Highway_Blues', 'Copy_of_New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(36, 'New_Stories_Highway_Blues', 'New_Stories_Highway_Blues.wma', '760748', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-08'),
(37, 'Copy 2 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_2_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '613638', '', 2, '', '', 10, 55, 0, 0, '2010-10-08'),
(38, 'Beethoven''s Symphony No. 9 Scherzo', 'Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-10-24'),
(39, 'Beethoven''s Symphony No. 9 Scherzo', 'Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-11-15'),
(40, 'Copy 5 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_5_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', '', 3, '', '', 10, 55, 0, 0, '2010-12-05'),
(41, 'Copy 4 of New Stories Highway Blues', 'Copy_4_of_New_Stories_Highway_Blues.wma', '765806', NULL, NULL, NULL, NULL, NULL, 55, 0, 0, '2010-12-05'),
(42, 'Copy 2 of New Stories Highway Blues', 'Copy_2_of_New_Stories_Highway_Blues.wma', '765806', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(43, 'Copy 3 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_3_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(44, 'Copy 5 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_5_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(45, 'Copy 2 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_2_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(46, 'Copy 4 of New Stories Highway Blues', 'Copy_4_of_New_Stories_Highway_Blues.wma', '765806', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(47, 'Copy 3 of New Stories Highway Blues', 'Copy_3_of_New_Stories_Highway_Blues.wma', '765806', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(48, 'Copy 2 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_2_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(49, 'Copy 4 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_4_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(50, 'Copy 4 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_4_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(51, 'Copy 5 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_5_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(52, 'Copy 2 of New Stories Highway Blues', 'Copy_2_of_New_Stories_Highway_Blues.wma', '765806', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(53, 'Copy 5 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_5_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(54, 'Copy 4 of New Stories Highway Blues', 'Copy_4_of_New_Stories_Highway_Blues.wma', '765806', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(55, 'Copy 4 of New Stories Highway Blues', 'Copy_4_of_New_Stories_Highway_Blues.wma', '765806', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(56, 'Copy 3 of New Stories Highway Blues', 'Copy_3_of_New_Stories_Highway_Blues.wma', '765806', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(57, 'Copy 2 of New Stories Highway Blues', 'Copy_2_of_New_Stories_Highway_Blues.wma', '765806', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(58, 'Copy 4 of New Stories Highway Blues', 'Copy_4_of_New_Stories_Highway_Blues.wma', '765806', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(59, 'AlbumArtSmall', 'AlbumArtSmall.jpg', '2101', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(60, 'Beethoven''s Symphony No. 9 Scherzo', 'Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(61, 'Copy 2 of Beethoven''s Symphony No. 9 Scherzo', 'Copy_2_of_Beethoven''s_Symphony_No._9_Scherzo.wma', '618692', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05'),
(62, 'AlbumArt EFFDEB51C9134EE18B2AC80112057955 Small', 'AlbumArt_EFFDEB51C9134EE18B2AC80112057955_Small.jpg', '2101', NULL, NULL, NULL, NULL, NULL, 49, 0, 0, '2010-12-05');

-- --------------------------------------------------------

--
-- Table structure for table `odb_mp3_artiste`
--

DROP TABLE IF EXISTS `odb_mp3_artiste`;
CREATE TABLE IF NOT EXISTS `odb_mp3_artiste` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mp3_id` int(11) DEFAULT NULL,
  `artiste_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `odb_mp3_artiste`
--

INSERT INTO `odb_mp3_artiste` (`id`, `mp3_id`, `artiste_id`) VALUES
(25, 8, 1),
(24, 8, 2),
(23, 8, 3),
(15, 7, 1),
(14, 7, 3),
(13, 9, 3),
(16, 10, 2),
(17, 11, 1),
(21, 15, 1),
(18, 12, 3),
(19, 13, 1),
(20, 14, 3),
(22, 15, 2),
(26, 37, 1),
(27, 40, 3),
(28, 40, 2);

-- --------------------------------------------------------

--
-- Table structure for table `odb_news`
--

DROP TABLE IF EXISTS `odb_news`;
CREATE TABLE IF NOT EXISTS `odb_news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` tinytext,
  `detail` longtext,
  `date_added` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `odb_news`
--

INSERT INTO `odb_news` (`id`, `title`, `detail`, `date_added`) VALUES
(3, 'test 2', '<p><img align="left" src="http://www.curacaofinest.com/wp-content/gallery/mambo/poker-tina-004.jpg" alt="" />gf&quot;hghgf hg&quot;f hgfhgf</p>', '2010-07-07');

-- --------------------------------------------------------

--
-- Table structure for table `odb_payment_history`
--

DROP TABLE IF EXISTS `odb_payment_history`;
CREATE TABLE IF NOT EXISTS `odb_payment_history` (
  `user_id` int(11) NOT NULL,
  `credit_total` int(11) DEFAULT NULL,
  `payment_date_period` date NOT NULL,
  PRIMARY KEY (`user_id`,`payment_date_period`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `odb_payment_history`
--

INSERT INTO `odb_payment_history` (`user_id`, `credit_total`, `payment_date_period`) VALUES
(49, 31, '2010-11-02'),
(49, 8, '2010-10-02');

-- --------------------------------------------------------

--
-- Table structure for table `odb_riddims`
--

DROP TABLE IF EXISTS `odb_riddims`;
CREATE TABLE IF NOT EXISTS `odb_riddims` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext,
  `detail` longtext,
  `producer_id` int(11) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `odb_riddims`
--

INSERT INTO `odb_riddims` (`id`, `name`, `detail`, `producer_id`, `date_added`) VALUES
(1, 'riddim', '<p>dsadas dsiad sadj asdsa das</p>', 55, '2010-10-08'),
(3, 'erewre', 'wrewwrwe rewr', 55, '2010-10-24');

-- --------------------------------------------------------

--
-- Table structure for table `odb_sales_report`
--

DROP TABLE IF EXISTS `odb_sales_report`;
CREATE TABLE IF NOT EXISTS `odb_sales_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `credit_total` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `odb_sales_report`
--


-- --------------------------------------------------------

--
-- Table structure for table `odb_transaction`
--

DROP TABLE IF EXISTS `odb_transaction`;
CREATE TABLE IF NOT EXISTS `odb_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mp3_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `credit_amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `odb_transaction`
--

INSERT INTO `odb_transaction` (`id`, `mp3_id`, `user_id`, `date`, `credit_amount`) VALUES
(8, 11, 55, '2010-10-26 00:11:05', 12),
(7, 7, 55, '2010-08-26 00:11:02', 5),
(6, 8, 55, '2010-10-26 00:10:58', 11),
(4, 13, 49, '2010-09-26 00:09:55', 5),
(5, 8, 55, '2010-08-26 00:10:07', 12),
(9, 15, 49, '2010-10-26 00:11:08', 8),
(10, 8, 49, '2010-08-26 00:11:27', 12),
(11, 15, 55, '2010-10-26 00:11:31', 8),
(12, 40, 49, '2011-04-27 01:35:52', 10),
(13, 11, 49, '2011-04-27 01:37:59', 12);

-- --------------------------------------------------------

--
-- Table structure for table `odb_user_cartitems__`
--

DROP TABLE IF EXISTS `odb_user_cartitems__`;
CREATE TABLE IF NOT EXISTS `odb_user_cartitems__` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cart_items` tinytext,
  `account_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `odb_user_cartitems__`
--

INSERT INTO `odb_user_cartitems__` (`id`, `cart_items`, `account_id`) VALUES
(3, '8,7', 55);
