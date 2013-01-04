<?php
	include_once('/app/shared/docroots/CommonConfig.php');
	
	$commonConfig = new CommonConfig();
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$dbConnect = mysql_connect($commonConfig->host, "joomla_ews", "2m56tearocks16J1");
	mysql_select_db("joomla", $dbConnect);
	
	
	$query_component	= "INSERT INTO `websvc_components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`)
VALUES
	('Monitor', 'option=com_emc_monitor', 0, 0, 'option=com_emc_monitor', '', 'com_emc_monitor', 0, 'components/com_emc_monitor/assets/images/monitor-menu-icon.png', 0, '', 1);";

	$query_monitor  = "CREATE TABLE IF NOT EXISTS `websvc_emc_monitor` (
  `id` int(11) NOT NULL auto_increment,
  `data` longblob NOT NULL,
  `start_date` date  NOT NULL,
  `end_date` date  NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `start_date` (`start_date`,`end_date`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";

	$query_reports = "CREATE TABLE IF NOT EXISTS `websvc_emc_monitor_reports` (
  `id` int(11) NOT NULL auto_increment,
  `manager` int(11) NOT NULL,
  `title_report` varchar(200) NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
	
	mysql_query($query_component) or die(mysql_error());
	mysql_query($query_monitor) or die(mysql_error());
	mysql_query($query_reports) or die(mysql_error());
	
	echo "Monitor installed...";
?>