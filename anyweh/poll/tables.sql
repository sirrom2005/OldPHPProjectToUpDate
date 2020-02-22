CREATE TABLE `pollv2` (
  `id` int(11) NOT NULL auto_increment,
  `pollname` varchar(128) NOT NULL default '',
  `num_questions` int(5) NOT NULL default '0',
  `updated` timestamp(14) NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `expires` datetime NOT NULL default '0000-00-00 00:00:00',
  `description` varchar(255) NOT NULL default '',
  `caption` varchar(128) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `pollname` (`pollname`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;

INSERT INTO `pollv2` VALUES(1, 'default_poll', 5, '20080412153902', '2008-04-11 16:44:07', '2009-04-11 00:00:00', 'Test poll for testing.', 'This is a trial poll.');

CREATE TABLE `default_poll` (
  `qid` int(11) NOT NULL auto_increment,
  `question` varchar(255) NOT NULL default '',
  `num_options` int(5) NOT NULL default '1',
  `c1` varchar(128) NOT NULL default '',
  `c2` varchar(128) NOT NULL default '',
  `c3` varchar(128) NOT NULL default '',
  `c4` varchar(128) NOT NULL default '',
  `c5` varchar(128) NOT NULL default '',
  `r1` int(6) NOT NULL default '0',
  `r2` int(6) NOT NULL default '0',
  `r3` int(6) NOT NULL default '0',
  `r4` int(6) NOT NULL default '0',
  `r5` int(6) NOT NULL default '0',
  `pollcolor` varchar(32) NOT NULL default '009900',
  `pollsize` varchar(32) NOT NULL default '450x150',
  `updated` timestamp(14) NOT NULL,
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`qid`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;

INSERT INTO `default_poll` VALUES(1, 'Why is the sun red?', 2, 'yes', 'no', 'banana', 'monkey', 'socks', 10, 28, 4, 2, 9, '990000', '300x100', '20080412174240', '2008-04-11 16:45:09');
INSERT INTO `default_poll` VALUES(2, 'Why is the sky green?', 3, 'yes', 'no', 'banana', 'monkey', 'socks', 10, 4, 2, 0, 2, '999900', '450x150', '20080412174240', '2008-04-11 16:45:09');
INSERT INTO `default_poll` VALUES(3, 'Why isn''t the sun yellow?', 4, 'color blindness', 'no eyes', 'underwater', 'socks', 'bananas', 7, 6, 2, 2, 2, '009999', '400x125', '20080412174336', '2008-04-11 16:46:02');
INSERT INTO `default_poll` VALUES(4, 'Who are you?', 5, 'Joe', 'John', 'Jim', 'Jorge', 'Johannes', 219, 431, 201, 7, 48, '009900', '400x175', '20080412174336', '2008-04-11 16:46:02');
INSERT INTO `default_poll` VALUES(5, 'Color?', 5, 'green', 'blue', 'red', 'yellow', 'orange', 1, 2, 3, 4, 5, '000099', '300x80', '20080414144509', '2008-04-11 16:46:15');
