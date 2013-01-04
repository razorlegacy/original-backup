<?php
/*
	include_once('/app/shared/docroots/CommonConfig.php');
	
	$commonConfig = new CommonConfig();
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$dbConnect = mysql_connect($commonConfig->host, "", "");
	mysql_select_db("joomla", $dbConnect);

	$query_component	= "INSERT INTO `websvc_components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`)
VALUES
	('Cartographer', 'option=com_emc_cartographer', 0, 0, 'option=com_emc_cartographer', '', 'com_emc_cartographer', 0, 'components/com_emc_cartographer/assets/images/icon-menu.png', 0, '', 1);";

	$query_cartographer  = "CREATE TABLE IF NOT EXISTS `websvc_emc_cartographer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `content` longblob,
  `manager` varchar(100) NOT NULL,
  `modified_by` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `published` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;";

	$query_groups = "CREATE TABLE IF NOT EXISTS `websvc_emc_cartographer_groups` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL,
  `content` longblob,
  `ordering` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
	
	$query_markers = "CREATE TABLE IF NOT EXISTS `websvc_emc_cartographer_markers` (
  `id` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `content` longblob,
  `coordinates` tinytext,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

	mysql_query($query_component) or die(mysql_error());
	mysql_query($query_cartographer) or die(mysql_error());
	mysql_query($query_groups) or die(mysql_error());
	mysql_query($query_markers) or die(mysql_error());
	
	echo 'Done';
*/
?>