<?php
	include_once('/app/shared/docroots/CommonConfig.php');
	
	$commonConfig = new CommonConfig();
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$dbConnect = mysql_connect($commonConfig->host, "joomla_ews", "2m56tearocks16J1");
	mysql_select_db("joomla", $dbConnect);
	
	
	$query_component	= "INSERT INTO `websvc_components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`)
VALUES
	('Origin', 'option=com_emc_origin', 0, 0, 'option=com_emc_origin', '', 'com_emc_origin', 0, 'components/com_emc_origin/assets/images/origin-menu-icon.png', 0, '', 1);";

	$query_origin  = "CREATE TABLE IF NOT EXISTS `websvc_emc_origin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `config` longblob,
  `manager` varchar(100) NOT NULL,
  `modified_by` varchar(100) DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modify_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

	$query_schedule = "CREATE TABLE IF NOT EXISTS `websvc_emc_origin_schedule` (
  `id` int(11) NOT NULL auto_increment,
  `oid` int(11) NOT NULL,
  `start_date` DATE default NULL,
  `end_date` DATE default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";
	
	$query_content = "CREATE TABLE IF NOT EXISTS `websvc_emc_origin_content` (
  `id` int(11) NOT NULL auto_increment,
  `oid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  `content` longblob,
  `config` longblob,
  `state` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=INNODB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

	mysql_query($query_component) or die(mysql_error());
	mysql_query($query_origin) or die(mysql_error());
	mysql_query($query_schedule) or die(mysql_error());
	mysql_query($query_content) or die(mysql_error());
	
	echo "Origin installed...";
?>