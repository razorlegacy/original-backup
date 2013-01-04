--
-- Table structure for table 'websvc_emc_origin'
--

DROP TABLE IF EXISTS websvc_emc_origin;
CREATE TABLE websvc_emc_origin (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `config` longblob,
  `content` longblob,
  `manager` varchar(100) NOT NULL,
  `modified_by` varchar(100) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table 'websvc_emc_origin_content'
--

DROP TABLE IF EXISTS websvc_emc_origin_content;
CREATE TABLE websvc_emc_origin_content (
  `id` int(11) NOT NULL auto_increment,
  `oid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `content` longblob,
  `config` longblob,
  `state` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table `websvc_emc_origin_schedule`
--

DROP TABLE IF EXISTS websvc_emc_origin_schedule;
CREATE TABLE IF NOT EXISTS websvc_emc_origin_schedule (
  `id` int(11) NOT NULL auto_increment,
  `oid` int(11) NOT NULL,
  `start_date` DATE default NULL,
  `end_date` DATE default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;