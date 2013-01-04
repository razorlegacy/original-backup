--
-- Table structure for table `#__emc_cartographer`
--
DROP TABLE IF EXISTS `#__emc_cartographer`;
CREATE TABLE `#__emc_cartographer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `content` longblob,
  `manager` varchar(100) NOT NULL,
  `modified_by` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;


--
-- Table structure for table `#__emc_cartographer_groups`
--

DROP TABLE IF EXISTS `#__emc_cartographer_groups`;
CREATE TABLE IF NOT EXISTS `#__emc_cartographer_groups` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL,
  `content` longblob,
  `ordering` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `#__emc_cartographer_markers`
--

DROP TABLE IF EXISTS `#__emc_cartographer_markers`;
CREATE TABLE IF NOT EXISTS `#__emc_cartographer_markers` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `content` longblob,
  `coordinates` tinytext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;