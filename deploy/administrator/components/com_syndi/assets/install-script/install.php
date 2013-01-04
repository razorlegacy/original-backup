<?php
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$dbConnect = mysql_connect("localhost", "joomla", "gieP4gae");
	mysql_select_db("joomla", $dbConnect);

	$query_component	= "INSERT INTO `websvc_components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`)
VALUES
	('Syndi', 'option=com_syndi', 0, 0, 'option=com_syndi', '', 'com_syndi', 2, 'js/ThemeOffice/component.png', 0, '', 1);";

	$query_syndi  = "
	CREATE TABLE `websvc_syndi` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `syndi_name` varchar(100) NOT NULL,
  `syndi_bg` varchar(255) DEFAULT NULL,
  `config` longblob,
  `manager` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
	
	";

	$query_article = "CREATE TABLE `websvc_syndi_article` (`article_id` int(11) NOT NULL AUTO_INCREMENT, `articleURL` varchar(255) DEFAULT NULL, `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, `title` varchar(100) NOT NULL, `alias` varchar(100) DEFAULT NULL, `image` varchar(255) DEFAULT NULL, `content` mediumtext, `tab_id` int(11) NOT NULL, `ordering` int(11) DEFAULT NULL, PRIMARY KEY (`article_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	
	$query_qa = "CREATE TABLE IF NOT EXISTS `websvc_syndi_qa` (`qa_id` int(11) NOT NULL AUTO_INCREMENT, `email` varchar(100) NOT NULL, `title` varchar(255) default NULL, `description` mediumtext, `tab_id` int(11) NOT NULL, `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, `ordering` int(11) default NULL, PRIMARY KEY  (`qa_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	
	$query_video	= "CREATE TABLE `websvc_syndi_video` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `pid` varchar(50) DEFAULT NULL,
  `siteId` varchar(50) NOT NULL DEFAULT '',
  `videoId` varchar(50) NOT NULL DEFAULT '',
  `tab_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ordering` int(11) DEFAULT NULL,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;";
	
	$query_image	= "CREATE TABLE IF NOT EXISTS `websvc_syndi_image` (`image_id` int(11) NOT NULL AUTO_INCREMENT,`image` varchar(255) NOT NULL,`clickURL` varchar(255) NOT NULL,`tab_id` int(11) NOT NULL,`ordering` int(11) default NULL,`timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,PRIMARY KEY  (`image_id`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8;";
	
	$query_tabs	= "CREATE TABLE `websvc_syndi_tabs` (
  `tab_id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `typetab` varchar(255) NOT NULL,
  `tab_bg` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tab_order` int(11) NOT NULL,
  PRIMARY KEY (`tab_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	$query_facebook ="CREATE TABLE IF NOT EXISTS `websvc_syndi_facebook` (
  `facebook_id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL,
  `alias` varchar(100) default NULL,
  `feedURL` varchar(255) default NULL,
  `header` varchar(10) default NULL,
  `colorscheme` varchar(100) default NULL,
  `tab_id` int(11) NOT NULL,
  `ordering` int(11) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`facebook_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	
	mysql_query($query_component) or die(mysql_error());
	mysql_query($query_syndi) or die(mysql_error());
	mysql_query($query_article) or die(mysql_error());
	mysql_query($query_qa) or die(mysql_error());
	mysql_query($query_image) or die(mysql_error());
	mysql_query($query_video) or die(mysql_error());
	mysql_query($query_tabs) or die(mysql_error());
	mysql_query($query_facebook) or die(mysql_error());
	echo 'here';
?>
