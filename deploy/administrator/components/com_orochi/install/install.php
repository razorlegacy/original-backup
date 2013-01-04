<?php
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$dbConnect = mysql_connect("localhost", "joomla", "gieP4gae");
	mysql_select_db("joomla", $dbConnect);

	$query_component	= "INSERT INTO `websvc_components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`)
VALUES
	('Syndi v2', 'option=com_orochi', 0, 0, 'option=com_orochi', '', 'com_orochi', 0, 'components/com_orochi/assets/images/icon.png', 0, '', 1);";

	$query_orochi  = "CREATE TABLE `websvc_orochi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` longblob NOT NULL,
  `manager` varchar(100) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";

	$query_menu = "CREATE TABLE `websvc_orochi_menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) NOT NULL,
  `content` longblob NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
	
	$query_groups = "CREATE TABLE `websvc_orochi_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) NOT NULL,
  `mid` int(11) DEFAULT NULL,
  `link` int(11) DEFAULT NULL,
  `ordering` int(11) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";

	$query_content = "CREATE TABLE `websvc_orochi_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `mid` int(11) DEFAULT NULL,
  `content` longblob NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8;";
	
	mysql_query($query_component) or die(mysql_error());
	mysql_query($query_orochi) or die(mysql_error());
	mysql_query($query_menu) or die(mysql_error());
	mysql_query($query_groups) or die(mysql_error());
	mysql_query($query_content) or die(mysql_error());
	
	echo 'Done';
?>
