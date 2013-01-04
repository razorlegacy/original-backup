--
-- Table structure for table 'websvc_emc_monitor'
--

DROP TABLE IF EXISTS websvc_emc_monitor;
CREATE TABLE websvc_emc_monitor (
  `id` int(11) NOT NULL auto_increment,
  `data` longblob NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `start_date` (`start_date`,`end_date`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Table structure for table 'websvc_emc_monitor_reports'
--

DROP TABLE IF EXISTS websvc_emc_monitor_reports;
CREATE TABLE websvc_emc_monitor_reports (
  `id` int(11) NOT NULL auto_increment,
  `manager` int(11) NOT NULL,
  `title_report` varchar(200) NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;