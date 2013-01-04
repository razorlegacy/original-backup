CREATE TABLE IF NOT EXISTS `e3gr_ninjarsssyndicator` 
(
	`id` tinyint(4) NOT NULL auto_increment, 
	`msg` varchar(100) default NULL,			  		
	`defaultType` varchar(4) default NULL, 
	`count` varchar(4) default NULL, 
	`orderby` varchar(10) default NULL,
	`numWords` tinyint(4) unsigned default NULL, 
	`cache` smallint(9) default NULL, 
	`imgUrl` varchar(100) default NULL,
	`renderAuthorFormat` varchar(10) default 'NAME', 
	`renderHTML` tinyint(1) default '1', 
	`FPItemsOnly` tinyint(1) default '0',
	`description` text default NULL, PRIMARY KEY  (`id`) 
) TYPE=MyISAM;

INSERT IGNORE INTO `e3gr_ninjarsssyndicator` (`id`, `msg`, `defaultType`, `count`, `orderby`, `numWords`, `cache`, `imgUrl`, `renderHTML`, `FPItemsOnly`) VALUES (1,'Get the latest news direct to your desktop','2.0','10','rdate',0,3600,'',1, 0);

CREATE TABLE IF NOT EXISTS `e3gr_ninjarsssyndicator_feeds` 
(
	`id` tinyint(4) NOT NULL auto_increment, 
	`feed_name` varchar(150) default NULL,
	`feed_description` text default NULL, `feed_type` varchar(10) default NULL, 
	`feed_cache` smallint(9) default NULL,
	`feed_imgUrl` varchar(100) default NULL, 
	`feed_button` varchar(100) default NULL, 
	`feed_renderAuthorFormat` varchar(10) default '0',
  	`feed_renderHTML` tinyint(1) default '0',
	`feed_renderImages` INT(1) NOT NULL, 
	`msg_count` varchar(4) default NULL, 
	`msg_orderby` varchar(10) default NULL,
	`msg_numWords` tinyint(4) unsigned default NULL, 
	`msg_FPItemsOnly` tinyint(1) default '1', 
	`msg_sectlist` varchar(50) default NULL, 
	`msg_excatlist` varchar(100) default NULL, 	
	`msg_includeCats` tinyint(1) default NULL, 
	`msg_fulltext` tinyint(1) default NULL, 
	`msg_exitems` varchar(250) default NULL, 
	`msg_contentPlugins` tinyint(1) default NULL, 
	`published` tinyint(1) default NULL, PRIMARY KEY  (`id`) 
) TYPE=MyISAM;



INSERT INTO `e3gr_components` (`id`,`name`,`link`,`menuid`,`parent`,`admin_menu_link`,`admin_menu_alt`,`option`,`ordering`,`admin_menu_img`,`iscore`,`params`,`enabled`)
VALUES
	(91, 'Ninja RSS Syndicator', 'option=com_ninjarsssyndicator', 0, 0, 'option=com_ninjarsssyndicator', 'Ninja RSS Syndicator', 'com_ninjarsssyndicator', 0, 'components/com_ninjarsssyndicator/assets/images/nficon.png', 0, '', 1),
	(92, 'Dashboard', '', 0, 91, 'option=com_ninjarsssyndicator&task=info', 'Dashboard', 'com_ninjarsssyndicator', 0, 'js/ThemeOffice/component.png', 0, '', 1),
	(93, 'Feeds', '', 0, 91, 'option=com_ninjarsssyndicator&task=feeds', 'Feeds', 'com_ninjarsssyndicator', 1, 'js/ThemeOffice/component.png', 0, '', 1),
	(94, 'Button Maker', '', 0, 91, 'option=com_ninjarsssyndicator&task=buttonmaker', 'Button Maker', 'com_ninjarsssyndicator', 2, 'js/ThemeOffice/component.png', 0, '', 1);
