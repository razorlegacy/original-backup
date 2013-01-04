# Sequel Pro dump
# Version 2210
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.0.86-log)
# Database: joomla_multisite
# Generation Time: 2010-06-02 18:16:43 -0700
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table e3gr_banner
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_banner`;

CREATE TABLE `e3gr_banner` (
  `bid` int(11) NOT NULL auto_increment,
  `cid` int(11) NOT NULL default '0',
  `type` varchar(30) NOT NULL default 'banner',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `imptotal` int(11) NOT NULL default '0',
  `impmade` int(11) NOT NULL default '0',
  `clicks` int(11) NOT NULL default '0',
  `imageurl` varchar(100) NOT NULL default '',
  `clickurl` varchar(200) NOT NULL default '',
  `date` datetime default NULL,
  `showBanner` tinyint(1) NOT NULL default '0',
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `custombannercode` text,
  `catid` int(10) unsigned NOT NULL default '0',
  `description` text NOT NULL,
  `sticky` tinyint(1) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `tags` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY  (`bid`),
  KEY `viewbanner` (`showBanner`),
  KEY `idx_banner_catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_bannerclient
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_bannerclient`;

CREATE TABLE `e3gr_bannerclient` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `contact` varchar(255) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `extrainfo` text NOT NULL,
  `checked_out` tinyint(1) NOT NULL default '0',
  `checked_out_time` time default NULL,
  `editor` varchar(50) default NULL,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_bannertrack
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_bannertrack`;

CREATE TABLE `e3gr_bannertrack` (
  `track_date` date NOT NULL,
  `track_type` int(10) unsigned NOT NULL,
  `banner_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_categories`;

CREATE TABLE `e3gr_categories` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `image` varchar(255) NOT NULL default '',
  `section` varchar(50) NOT NULL default '',
  `image_position` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `editor` varchar(50) default NULL,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `cat_idx` (`section`,`published`,`access`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_categories` WRITE;
/*!40000 ALTER TABLE `e3gr_categories` DISABLE KEYS */;
INSERT INTO `e3gr_categories` (`id`,`parent_id`,`title`,`name`,`alias`,`image`,`section`,`image_position`,`description`,`published`,`checked_out`,`checked_out_time`,`editor`,`ordering`,`access`,`count`,`params`)
VALUES
	(37,0,'Articles','','articles','','16','left','<p>\r\n	&nbsp;</p>\r\n<div firebugversion=\"1.5.4\" id=\"_firebugConsole\" style=\"display: none;\">\r\n	&nbsp;</div>\r\n<br />',1,0,'0000-00-00 00:00:00',NULL,1,0,0,''),
	(38,0,'News','','news','','17','left','<p>\r\n	&nbsp;</p>\r\n<div firebugversion=\"1.5.4\" id=\"_firebugConsole\" style=\"display: none;\">\r\n	&nbsp;</div>\r\n<br />',1,0,'0000-00-00 00:00:00',NULL,1,0,0,''),
	(39,0,'Interviews','','interviews','','17','left','<p>\r\n	&nbsp;</p>\r\n<div firebugversion=\"1.5.4\" id=\"_firebugConsole\" style=\"display: none;\">\r\n	&nbsp;</div>\r\n<br />',1,0,'0000-00-00 00:00:00',NULL,2,0,0,'');

/*!40000 ALTER TABLE `e3gr_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_components
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_components`;

CREATE TABLE `e3gr_components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` varchar(255) NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  `enabled` tinyint(4) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `parent_option` (`parent`,`option`(32))
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_components` WRITE;
/*!40000 ALTER TABLE `e3gr_components` DISABLE KEYS */;
INSERT INTO `e3gr_components` (`id`,`name`,`link`,`menuid`,`parent`,`admin_menu_link`,`admin_menu_alt`,`option`,`ordering`,`admin_menu_img`,`iscore`,`params`,`enabled`)
VALUES
	(1,'Banners','',0,0,'','Banner Management','com_banners',0,'js/ThemeOffice/component.png',0,'track_impressions=0\ntrack_clicks=0\ntag_prefix=\n\n',1),
	(2,'Banners','',0,1,'option=com_banners','Active Banners','com_banners',1,'js/ThemeOffice/edit.png',0,'',1),
	(3,'Clients','',0,1,'option=com_banners&c=client','Manage Clients','com_banners',2,'js/ThemeOffice/categories.png',0,'',1),
	(4,'Web Links','option=com_weblinks',0,0,'','Manage Weblinks','com_weblinks',0,'js/ThemeOffice/component.png',0,'show_comp_description=1\ncomp_description=\nshow_link_hits=1\nshow_link_description=1\nshow_other_cats=1\nshow_headings=1\nshow_page_title=1\nlink_target=0\nlink_icons=\n\n',1),
	(5,'Links','',0,4,'option=com_weblinks','View existing weblinks','com_weblinks',1,'js/ThemeOffice/edit.png',0,'',1),
	(6,'Categories','',0,4,'option=com_categories&section=com_weblinks','Manage weblink categories','',2,'js/ThemeOffice/categories.png',0,'',1),
	(7,'Contacts','option=com_contact',0,0,'','Edit contact details','com_contact',0,'js/ThemeOffice/component.png',1,'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n',1),
	(8,'Contacts','',0,7,'option=com_contact','Edit contact details','com_contact',0,'js/ThemeOffice/edit.png',1,'',1),
	(9,'Categories','',0,7,'option=com_categories&section=com_contact_details','Manage contact categories','',2,'js/ThemeOffice/categories.png',1,'contact_icons=0\nicon_address=\nicon_email=\nicon_telephone=\nicon_fax=\nicon_misc=\nshow_headings=1\nshow_position=1\nshow_email=0\nshow_telephone=1\nshow_mobile=1\nshow_fax=1\nbannedEmail=\nbannedSubject=\nbannedText=\nsession=1\ncustomReply=0\n\n',1),
	(10,'Polls','option=com_poll',0,0,'option=com_poll','Manage Polls','com_poll',0,'js/ThemeOffice/component.png',0,'',1),
	(11,'News Feeds','option=com_newsfeeds',0,0,'','News Feeds Management','com_newsfeeds',0,'js/ThemeOffice/component.png',0,'',1),
	(12,'Feeds','',0,11,'option=com_newsfeeds','Manage News Feeds','com_newsfeeds',1,'js/ThemeOffice/edit.png',0,'show_headings=1\nshow_name=1\nshow_articles=1\nshow_link=1\nshow_cat_description=1\nshow_cat_items=1\nshow_feed_image=1\nshow_feed_description=1\nshow_item_description=1\nfeed_word_count=0\n\n',1),
	(13,'Categories','',0,11,'option=com_categories&section=com_newsfeeds','Manage Categories','',2,'js/ThemeOffice/categories.png',0,'',1),
	(14,'User','option=com_user',0,0,'','','com_user',0,'',1,'',1),
	(15,'Search','option=com_search',0,0,'option=com_search','Search Statistics','com_search',0,'js/ThemeOffice/component.png',1,'enabled=0\n\n',1),
	(16,'Categories','',0,1,'option=com_categories&section=com_banner','Categories','',3,'',1,'',1),
	(17,'Wrapper','option=com_wrapper',0,0,'','Wrapper','com_wrapper',0,'',1,'',1),
	(18,'Mail To','',0,0,'','','com_mailto',0,'',1,'',1),
	(19,'Media Manager','',0,0,'option=com_media','Media Manager','com_media',0,'',1,'upload_extensions=bmp,csv,doc,epg,gif,ico,jpg,odg,odp,ods,odt,pdf,png,ppt,swf,txt,xcf,xls,BMP,CSV,DOC,EPG,GIF,ICO,JPG,ODG,ODP,ODS,ODT,PDF,PNG,PPT,SWF,TXT,XCF,XLS\nupload_maxsize=10000000\nfile_path=images\nimage_path=images/stories\nrestrict_uploads=1\nallowed_media_usergroup=3\ncheck_mime=1\nimage_extensions=bmp,gif,jpg,png\nignore_extensions=\nupload_mime=image/jpeg,image/gif,image/png,image/bmp,application/x-shockwave-flash,application/msword,application/excel,application/pdf,application/powerpoint,text/plain,application/x-zip\nupload_mime_illegal=text/html\nenable_flash=0\n\n',1),
	(20,'Articles','option=com_content',0,0,'','','com_content',0,'',1,'show_noauth=0\nshow_title=1\nlink_titles=0\nshow_intro=1\nshow_section=0\nlink_section=0\nshow_category=0\nlink_category=0\nshow_author=1\nshow_create_date=1\nshow_modify_date=1\nshow_item_navigation=0\nshow_readmore=1\nshow_vote=0\nshow_icons=0\nshow_pdf_icon=0\nshow_print_icon=0\nshow_email_icon=0\nshow_hits=0\nfeed_summary=0\nfilter_tags=\nfilter_attritbutes=\n\n',1),
	(21,'Configuration Manager','',0,0,'','Configuration','com_config',0,'',1,'',1),
	(22,'Installation Manager','',0,0,'','Installer','com_installer',0,'',1,'',1),
	(23,'Language Manager','',0,0,'','Languages','com_languages',0,'',1,'',1),
	(24,'Mass mail','',0,0,'','Mass Mail','com_massmail',0,'',1,'mailSubjectPrefix=\nmailBodySuffix=\n\n',1),
	(25,'Menu Editor','',0,0,'','Menu Editor','com_menus',0,'',1,'',1),
	(27,'Messaging','',0,0,'','Messages','com_messages',0,'',1,'',1),
	(28,'Modules Manager','',0,0,'','Modules','com_modules',0,'',1,'',1),
	(29,'Plugin Manager','',0,0,'','Plugins','com_plugins',0,'',1,'',1),
	(30,'Template Manager','',0,0,'','Templates','com_templates',0,'',1,'',1),
	(31,'User Manager','',0,0,'','Users','com_users',0,'',1,'allowUserRegistration=1\nnew_usertype=Registered\nuseractivation=1\nfrontend_userparams=1\n\n',1),
	(32,'Cache Manager','',0,0,'','Cache','com_cache',0,'',1,'',1),
	(33,'Control Panel','',0,0,'','Control Panel','com_cpanel',0,'',1,'',1),
	(34,'JoomGallery','option=com_joomgallery',0,0,'option=com_joomgallery','JoomGallery','com_joomgallery',0,'components/com_joomgallery/assets/images/joom_main.png',0,'',1),
	(35,'Category Manager','',0,34,'option=com_joomgallery&act=categories','Category Manager','com_joomgallery',0,'components/com_joomgallery/assets/images/joom_categories.png',0,'',1),
	(36,'Picture Manager','',0,34,'option=com_joomgallery&act=pictures','Picture Manager','com_joomgallery',1,'components/com_joomgallery/assets/images/joom_pictures.png',0,'',1),
	(37,'Comments Manager','',0,34,'option=com_joomgallery&act=comments','Comments Manager','com_joomgallery',2,'components/com_joomgallery/assets/images/joom_comments.png',0,'',1),
	(38,'Votes Manager','',0,34,'option=com_joomgallery&act=votes','Votes Manager','com_joomgallery',3,'components/com_joomgallery/assets/images/joom_votes.png',0,'',1),
	(39,'Picture Upload','',0,34,'option=com_joomgallery&act=upload','Picture Upload','com_joomgallery',4,'components/com_joomgallery/assets/images/joom_pictureupload.png',0,'',1),
	(40,'Batch Upload','',0,34,'option=com_joomgallery&act=batchupload','Batch Upload','com_joomgallery',5,'components/com_joomgallery/assets/images/joom_batchupload.png',0,'',1),
	(41,'FTP Upload','',0,34,'option=com_joomgallery&act=ftpupload','FTP Upload','com_joomgallery',6,'components/com_joomgallery/assets/images/joom_ftpupload.png',0,'',1),
	(42,'Java Upload','',0,34,'option=com_joomgallery&act=jupload','Java Upload','com_joomgallery',7,'components/com_joomgallery/assets/images/joom_jupload.png',0,'',1),
	(43,'Configuration Manager','',0,34,'option=com_joomgallery&act=configuration','Configuration Manager','com_joomgallery',8,'components/com_joomgallery/assets/images/joom_config.png',0,'',1),
	(44,'Customize CSS','',0,34,'option=com_joomgallery&act=editcss','Customize CSS','com_joomgallery',9,'components/com_joomgallery/assets/images/joom_css.png',0,'',1),
	(45,'Migration Manager','',0,34,'option=com_joomgallery&act=migrate','Migration Manager','com_joomgallery',10,'components/com_joomgallery/assets/images/joom_migration.png',0,'',1),
	(46,'Help','',0,34,'option=com_joomgallery&act=help','Help','com_joomgallery',11,'components/com_joomgallery/assets/images/joom_information.png',0,'',1),
	(47,'JANews Manager','option=com_janews',0,0,'option=com_janews','JA News Manager','com_janews',0,'components/com_janews/images/favicon.ico',0,'',1),
	(48,'Joomla Tags','option=com_tag',0,0,'option=com_tag','Joomla Tags','com_tag',0,'components/com_tag/images/logo.png',0,'capitalize=1\nlowcase=1\nautoMetaKeywordsExtractor=1\nStripCharacters=-\\|_\\|,\\|~\\|!\\|@\\|%\\|^\\|(\\|)\\|<\\|>\\|:\\|;\\|{\\|}\\|[\\|]\\|&\\|`\\|\"\\|#\\|*\ntag_page_limit=30\npage_limit=10\nlayout=blog\nonlyIntro=1\ndescription=0\ncontentMeta=1\nShowArchiveArticles=1\nOrder=rdate\ntopAds=\nbottomAds=\nTagPosition=0\nFrontPageTag=1\nBlogTag=1\nShowAddTagButton=1\nSuppresseSingleTerms=0\nHitsNumber=0\nMaxTagsNumber=10\nRelatedArticlesByTags=0\nRelatedArticlesCountByTags=10\nRelatedArticlesTitleByTags=Related Articles\nIgnoeNumericTags=0\nMinTagLength=1\n\n',1),
	(49,'Frontpage SlideShow','option=com_fpss',0,0,'option=com_fpss','Frontpage SlideShow','com_fpss',0,'js/ThemeOffice/component.png',0,'',1);

/*!40000 ALTER TABLE `e3gr_components` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_contact_details
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_contact_details`;

CREATE TABLE `e3gr_contact_details` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `con_position` varchar(255) default NULL,
  `address` text,
  `suburb` varchar(100) default NULL,
  `state` varchar(100) default NULL,
  `country` varchar(100) default NULL,
  `postcode` varchar(100) default NULL,
  `telephone` varchar(255) default NULL,
  `fax` varchar(255) default NULL,
  `misc` mediumtext,
  `image` varchar(255) default NULL,
  `imagepos` varchar(20) default NULL,
  `email_to` varchar(255) default NULL,
  `default_con` tinyint(1) unsigned NOT NULL default '0',
  `published` tinyint(1) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  `user_id` int(11) NOT NULL default '0',
  `catid` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `mobile` varchar(255) NOT NULL default '',
  `webpage` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_content`;

CREATE TABLE `e3gr_content` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `title_alias` varchar(255) NOT NULL default '',
  `introtext` mediumtext NOT NULL,
  `fulltext` mediumtext NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `sectionid` int(11) unsigned NOT NULL default '0',
  `mask` int(11) unsigned NOT NULL default '0',
  `catid` int(11) unsigned NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  `created_by` int(11) unsigned NOT NULL default '0',
  `created_by_alias` varchar(255) NOT NULL default '',
  `modified` datetime NOT NULL default '0000-00-00 00:00:00',
  `modified_by` int(11) unsigned NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `images` text NOT NULL,
  `urls` text NOT NULL,
  `attribs` text NOT NULL,
  `version` int(11) unsigned NOT NULL default '1',
  `parentid` int(11) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `metakey` text NOT NULL,
  `metadesc` text NOT NULL,
  `access` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0',
  `metadata` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_section` (`sectionid`),
  KEY `idx_access` (`access`),
  KEY `idx_checkout` (`checked_out`),
  KEY `idx_state` (`state`),
  KEY `idx_catid` (`catid`),
  KEY `idx_createdby` (`created_by`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_content` WRITE;
/*!40000 ALTER TABLE `e3gr_content` DISABLE KEYS */;
INSERT INTO `e3gr_content` (`id`,`title`,`alias`,`title_alias`,`introtext`,`fulltext`,`state`,`sectionid`,`mask`,`catid`,`created`,`created_by`,`created_by_alias`,`modified`,`modified_by`,`checked_out`,`checked_out_time`,`publish_up`,`publish_down`,`images`,`urls`,`attribs`,`version`,`parentid`,`ordering`,`metakey`,`metadesc`,`access`,`hits`,`metadata`)
VALUES
	(29,'Splinter Cell','splinter-cell','','<p>\r\n	<img alt=\"\" src=\"images/stories/pig-cat.jpg\" /></p>\r\n<p>\r\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis orci turpis. Proin non dui urna, id laoreet augue. Duis vitae tellus quis nulla placerat commodo id sed felis. Donec auctor nunc at turpis vehicula non adipiscing nisi lacinia. Curabitur a eros a sem tincidunt ullamcorper a sit amet quam. Donec sit amet pellentesque orci. Nullam tempus feugiat nulla ut rutrum. Morbi egestas turpis ultricies sapien ullamcorper elementum.</p>\r\n<hr class=\"system-pagebreak\" />\r\n<p>\r\n	Maecenas a ante sollicitudin dolor mollis porta id sed risus. Donec et pulvinar erat. Maecenas id fermentum ipsum. Donec vel sapien ut risus tempus dignissim ac eu arcu. Integer ullamcorper suscipit tellus, sit amet varius risus tincidunt sed. Suspendisse sed velit risus. Sed auctor ante id lectus dignissim molestie. Aenean lacinia diam vitae neque egestas quis porta felis faucibus. Duis nec nibh turpis. Vestibulum in tellus in massa imperdiet accumsan nec tincidunt velit. Phasellus sollicitudin, ligula eu sodales aliquam, elit turpis volutpat dolor, sit amet bibendum sem nibh lobortis quam. Curabitur gravida tincidunt nisl non tempor.</p>','',1,16,0,37,'2010-05-30 00:06:00',62,'','2010-05-30 02:04:21',62,0,'0000-00-00 00:00:00','2010-05-30 00:06:00','0000-00-00 00:00:00','','','show_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_vote=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nlanguage=\nkeyref=\nreadmore=',2,0,1,'','',0,19,'robots=\nauthor='),
	(30,'Nintendo','nintendo','','<p>\r\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec quis orci turpis. Proin non dui urna, id laoreet augue. Duis vitae tellus quis nulla placerat commodo id sed felis. Donec auctor nunc at turpis vehicula non adipiscing nisi lacinia. Curabitur a eros a sem tincidunt ullamcorper a sit amet quam. Donec sit amet pellentesque orci. Nullam tempus feugiat nulla ut rutrum. Morbi egestas turpis ultricies sapien ullamcorper elementum. Maecenas a ante sollicitudin dolor mollis porta id sed risus. Donec et pulvinar erat. Maecenas id fermentum ipsum. Donec vel sapien ut risus tempus dignissim ac eu arcu. Integer ullamcorper suscipit tellus, sit amet varius risus tincidunt sed. Suspendisse sed velit risus. Sed auctor ante id lectus dignissim molestie. Aenean lacinia diam vitae neque egestas quis porta felis faucibus.</p>\r\n<hr class=\"system-pagebreak\" />\r\n<p>\r\n	Duis nec nibh turpis. Vestibulum in tellus in massa imperdiet accumsan nec tincidunt velit. Phasellus sollicitudin, ligula eu sodales aliquam, elit turpis volutpat dolor, sit amet bibendum sem nibh lobortis quam. Curabitur gravida tincidunt nisl non tempor.</p>','',1,17,0,38,'2010-05-30 00:06:30',62,'','0000-00-00 00:00:00',0,0,'0000-00-00 00:00:00','2010-05-30 00:06:30','0000-00-00 00:00:00','','','show_title=\nlink_titles=\nshow_intro=\nshow_section=\nlink_section=\nshow_category=\nlink_category=\nshow_vote=\nshow_author=\nshow_create_date=\nshow_modify_date=\nshow_pdf_icon=\nshow_print_icon=\nshow_email_icon=\nlanguage=\nkeyref=\nreadmore=',1,0,1,'','',0,2,'robots=\nauthor=');

/*!40000 ALTER TABLE `e3gr_content` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_content_frontpage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_content_frontpage`;

CREATE TABLE `e3gr_content_frontpage` (
  `content_id` int(11) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_content_rating
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_content_rating`;

CREATE TABLE `e3gr_content_rating` (
  `content_id` int(11) NOT NULL default '0',
  `rating_sum` int(11) unsigned NOT NULL default '0',
  `rating_count` int(11) unsigned NOT NULL default '0',
  `lastip` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`content_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_core_acl_aro
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_core_acl_aro`;

CREATE TABLE `e3gr_core_acl_aro` (
  `id` int(11) NOT NULL auto_increment,
  `section_value` varchar(240) NOT NULL default '0',
  `value` varchar(240) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `e3gr_section_value_value_aro` (`section_value`(100),`value`(100)),
  KEY `e3gr_gacl_hidden_aro` (`hidden`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_core_acl_aro` WRITE;
/*!40000 ALTER TABLE `e3gr_core_acl_aro` DISABLE KEYS */;
INSERT INTO `e3gr_core_acl_aro` (`id`,`section_value`,`value`,`order_value`,`name`,`hidden`)
VALUES
	(10,'users','62',0,'Administrator',0),
	(11,'users','63',0,'Editor',0),
	(12,'users','64',0,'Ahmad Childress',0),
	(13,'users','65',0,'Johnny Firecloud',0),
	(14,'users','66',0,'Paul Hanges',0);

/*!40000 ALTER TABLE `e3gr_core_acl_aro` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_core_acl_aro_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_core_acl_aro_groups`;

CREATE TABLE `e3gr_core_acl_aro_groups` (
  `id` int(11) NOT NULL auto_increment,
  `parent_id` int(11) NOT NULL default '0',
  `name` varchar(255) NOT NULL default '',
  `lft` int(11) NOT NULL default '0',
  `rgt` int(11) NOT NULL default '0',
  `value` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `e3gr_gacl_parent_id_aro_groups` (`parent_id`),
  KEY `e3gr_gacl_lft_rgt_aro_groups` (`lft`,`rgt`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_core_acl_aro_groups` WRITE;
/*!40000 ALTER TABLE `e3gr_core_acl_aro_groups` DISABLE KEYS */;
INSERT INTO `e3gr_core_acl_aro_groups` (`id`,`parent_id`,`name`,`lft`,`rgt`,`value`)
VALUES
	(17,0,'ROOT',1,22,'ROOT'),
	(28,17,'USERS',2,21,'USERS'),
	(29,28,'Public Frontend',3,12,'Public Frontend'),
	(18,29,'Registered',4,11,'Registered'),
	(19,18,'Author',5,10,'Author'),
	(20,19,'Editor',6,9,'Editor'),
	(21,20,'Publisher',7,8,'Publisher'),
	(30,28,'Public Backend',13,20,'Public Backend'),
	(23,30,'Manager',14,19,'Manager'),
	(24,23,'Administrator',15,18,'Administrator'),
	(25,24,'Super Administrator',16,17,'Super Administrator');

/*!40000 ALTER TABLE `e3gr_core_acl_aro_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_core_acl_aro_map
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_core_acl_aro_map`;

CREATE TABLE `e3gr_core_acl_aro_map` (
  `acl_id` int(11) NOT NULL default '0',
  `section_value` varchar(230) NOT NULL default '0',
  `value` varchar(100) NOT NULL,
  PRIMARY KEY  (`acl_id`,`section_value`,`value`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_core_acl_aro_sections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_core_acl_aro_sections`;

CREATE TABLE `e3gr_core_acl_aro_sections` (
  `id` int(11) NOT NULL auto_increment,
  `value` varchar(230) NOT NULL default '',
  `order_value` int(11) NOT NULL default '0',
  `name` varchar(230) NOT NULL default '',
  `hidden` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `e3gr_gacl_value_aro_sections` (`value`),
  KEY `e3gr_gacl_hidden_aro_sections` (`hidden`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_core_acl_aro_sections` WRITE;
/*!40000 ALTER TABLE `e3gr_core_acl_aro_sections` DISABLE KEYS */;
INSERT INTO `e3gr_core_acl_aro_sections` (`id`,`value`,`order_value`,`name`,`hidden`)
VALUES
	(10,'users',1,'Users',0);

/*!40000 ALTER TABLE `e3gr_core_acl_aro_sections` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_core_acl_groups_aro_map
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_core_acl_groups_aro_map`;

CREATE TABLE `e3gr_core_acl_groups_aro_map` (
  `group_id` int(11) NOT NULL default '0',
  `section_value` varchar(240) NOT NULL default '',
  `aro_id` int(11) NOT NULL default '0',
  UNIQUE KEY `group_id_aro_id_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_core_acl_groups_aro_map` WRITE;
/*!40000 ALTER TABLE `e3gr_core_acl_groups_aro_map` DISABLE KEYS */;
INSERT INTO `e3gr_core_acl_groups_aro_map` (`group_id`,`section_value`,`aro_id`)
VALUES
	(23,'',11),
	(23,'',14),
	(24,'',12),
	(24,'',13),
	(25,'',10);

/*!40000 ALTER TABLE `e3gr_core_acl_groups_aro_map` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_core_log_items
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_core_log_items`;

CREATE TABLE `e3gr_core_log_items` (
  `time_stamp` date NOT NULL default '0000-00-00',
  `item_table` varchar(50) NOT NULL default '',
  `item_id` int(11) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_core_log_searches
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_core_log_searches`;

CREATE TABLE `e3gr_core_log_searches` (
  `search_term` varchar(128) NOT NULL default '',
  `hits` int(11) unsigned NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_fpss_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_fpss_categories`;

CREATE TABLE `e3gr_fpss_categories` (
  `id` int(3) NOT NULL auto_increment,
  `name` varchar(225) NOT NULL,
  `width` int(11) NOT NULL,
  `quality` int(11) NOT NULL,
  `width_thumb` int(11) NOT NULL,
  `quality_thumb` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `e3gr_fpss_categories` WRITE;
/*!40000 ALTER TABLE `e3gr_fpss_categories` DISABLE KEYS */;
INSERT INTO `e3gr_fpss_categories` (`id`,`name`,`width`,`quality`,`width_thumb`,`quality_thumb`,`published`)
VALUES
	(1,'Frontpage',539,80,165,75,1);

/*!40000 ALTER TABLE `e3gr_fpss_categories` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_fpss_slides
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_fpss_slides`;

CREATE TABLE `e3gr_fpss_slides` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL,
  `name` varchar(225) NOT NULL default '',
  `path` varchar(225) NOT NULL default '',
  `path_type` varchar(110) NOT NULL default '',
  `thumb` varchar(225) NOT NULL,
  `state` tinyint(3) NOT NULL default '0',
  `publish_up` datetime NOT NULL default '0000-00-00 00:00:00',
  `publish_down` datetime NOT NULL default '0000-00-00 00:00:00',
  `itemlink` int(11) NOT NULL default '0',
  `menulink` int(11) NOT NULL default '0',
  `target` tinyint(3) NOT NULL default '0',
  `customlink` varchar(225) default NULL,
  `nolink` tinyint(1) NOT NULL,
  `ctext` text NOT NULL,
  `plaintext` text NOT NULL,
  `registers` tinyint(3) NOT NULL default '0',
  `showtitle` tinyint(3) NOT NULL default '0',
  `showseccat` tinyint(3) NOT NULL default '0',
  `showcustomtext` tinyint(3) NOT NULL default '0',
  `showplaintext` tinyint(3) NOT NULL default '0',
  `showreadmore` tinyint(3) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

LOCK TABLES `e3gr_fpss_slides` WRITE;
/*!40000 ALTER TABLE `e3gr_fpss_slides` DISABLE KEYS */;
INSERT INTO `e3gr_fpss_slides` (`id`,`catid`,`name`,`path`,`path_type`,`thumb`,`state`,`publish_up`,`publish_down`,`itemlink`,`menulink`,`target`,`customlink`,`nolink`,`ctext`,`plaintext`,`registers`,`showtitle`,`showseccat`,`showcustomtext`,`showplaintext`,`showreadmore`,`ordering`)
VALUES
	(9,1,'test','assets/components/com_fpss/images/fpss.jpg','1','assets/components/com_fpss/images/thumbs/fpss.jpg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',29,0,0,'',0,'<p>\r\n	&nbsp;</p>\r\n<div firebugversion=\"1.5.4\" id=\"_firebugConsole\" style=\"display: none;\">\r\n	&nbsp;</div>\r\n<br />','test',0,0,0,0,1,0,2),
	(10,1,'SplinterCell2','assets/components/com_fpss/images/fpss_1.jpg','1','assets/components/com_fpss/images/thumbs/fpss_1.jpg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',30,0,0,'',0,'<p>\r\n	&nbsp;</p>\r\n<div firebugversion=\"1.5.4\" id=\"_firebugConsole\" style=\"display: none;\">\r\n	&nbsp;</div>\r\n<br />','Splinter Cell Conviction',0,0,0,0,1,0,3),
	(11,1,'Test3','assets/components/com_fpss/images/The_Tortoise_and_the_Hare_by_splgum.jpg','1','assets/components/com_fpss/images/thumbs/The_Tortoise_and_the_Hare_by_splgum.jpg',1,'0000-00-00 00:00:00','0000-00-00 00:00:00',0,0,0,'',1,'<p>\r\n	&nbsp;</p>\r\n<div firebugversion=\"1.5.4\" id=\"_firebugConsole\" style=\"display: none;\">\r\n	&nbsp;</div>\r\n<br />','Test3',0,0,0,0,1,0,1);

/*!40000 ALTER TABLE `e3gr_fpss_slides` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_groups`;

CREATE TABLE `e3gr_groups` (
  `id` tinyint(3) unsigned NOT NULL default '0',
  `name` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_groups` WRITE;
/*!40000 ALTER TABLE `e3gr_groups` DISABLE KEYS */;
INSERT INTO `e3gr_groups` (`id`,`name`)
VALUES
	(0,'Public'),
	(1,'Registered'),
	(2,'Special');

/*!40000 ALTER TABLE `e3gr_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_janews_frontpage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_janews_frontpage`;

CREATE TABLE `e3gr_janews_frontpage` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `headline` varchar(255) NOT NULL default '',
  `blog` varchar(255) NOT NULL default '',
  `sections` text NOT NULL,
  `default_f` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `e3gr_janews_frontpage` WRITE;
/*!40000 ALTER TABLE `e3gr_janews_frontpage` DISABLE KEYS */;
INSERT INTO `e3gr_janews_frontpage` (`id`,`title`,`headline`,`blog`,`sections`,`default_f`)
VALUES
	(1,'frontpage','2','7','16,17',1);

/*!40000 ALTER TABLE `e3gr_janews_frontpage` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_janews_sections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_janews_sections`;

CREATE TABLE `e3gr_janews_sections` (
  `secid` int(11) unsigned NOT NULL,
  `categories` text NOT NULL,
  `headline` int(11) NOT NULL default '0',
  `blog` int(11) NOT NULL default '0',
  `params` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `e3gr_janews_sections` WRITE;
/*!40000 ALTER TABLE `e3gr_janews_sections` DISABLE KEYS */;
INSERT INTO `e3gr_janews_sections` (`secid`,`categories`,`headline`,`blog`,`params`)
VALUES
	(3,'3',2,4,'catlayout=2'),
	(2,'2',2,4,'catlayout=1'),
	(4,'4,5,6',2,1,'catlayout=1'),
	(13,'34',2,4,'catlayout=1'),
	(14,'35',2,4,'catlayout=1'),
	(15,'36',2,4,'catlayout=1'),
	(16,'37',2,4,'catlayout=1'),
	(17,'38,39',2,4,'catlayout=1');

/*!40000 ALTER TABLE `e3gr_janews_sections` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_janews_templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_janews_templates`;

CREATE TABLE `e3gr_janews_templates` (
  `id` int(11) NOT NULL auto_increment,
  `template` varchar(255) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

LOCK TABLES `e3gr_janews_templates` WRITE;
/*!40000 ALTER TABLE `e3gr_janews_templates` DISABLE KEYS */;
INSERT INTO `e3gr_janews_templates` (`id`,`template`,`title`,`type`,`params`)
VALUES
	(7,'split_home','Home - Split','blog','datatype=group_by\nwrap_id=\norder=created desc\nshowcattitle=1\nshowcattitlelink=1\nshow_create_date=0\ndateformat=\nshowblurb=1\nintroitems=3\nlinkitems=0\nmaxchars=50\nheaderlevel=h3\nshowimage=1\nautoresize=1\nwidth=100\nheight=100\nshowreadmore=0\nshowreadmoresection=1\ncolumns=2'),
	(2,'empty','Empty','headline','emptyness=0\nnumberofheadlinenews=0\nlistofhlcontent=1'),
	(4,'si_section_list','Section List','blog','datatype=no_group_by\nintroitems=10\nlinkitems=0\nmaxchars=120\nshowimage=1\nalign=0\nautoresize=1\nwidth=100\nheight=100\nhiddenClasses=\nshow_create_date=1\ndateformat=\nshow_author=1\nshow_title=1\nlink_titles=1\nshow_readmore=1\nshow_description=1\nshow_description_image=0\ngrab_blurb=0\nblurb_length=100\nshow_pagination=2\nshow_pagination_results=0');

/*!40000 ALTER TABLE `e3gr_janews_templates` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_joomgallery
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_joomgallery`;

CREATE TABLE `e3gr_joomgallery` (
  `id` int(11) NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `imgtitle` text NOT NULL,
  `imgauthor` varchar(50) default NULL,
  `imgtext` text NOT NULL,
  `imgdate` varchar(20) default NULL,
  `imgcounter` int(11) NOT NULL default '0',
  `imgvotes` int(11) NOT NULL default '0',
  `imgvotesum` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `imgfilename` varchar(100) NOT NULL default '',
  `imgthumbname` varchar(100) NOT NULL default '',
  `checked_out` int(11) NOT NULL default '0',
  `owner` int(11) unsigned NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '0',
  `useruploaded` tinyint(1) NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `idx_catid` (`catid`),
  KEY `idx_owner` (`owner`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;



# Dump of table e3gr_joomgallery_catg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_joomgallery_catg`;

CREATE TABLE `e3gr_joomgallery_catg` (
  `cid` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `parent` int(11) NOT NULL default '0',
  `description` text,
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `published` char(1) NOT NULL default '0',
  `owner` int(11) default NULL,
  `catimage` varchar(100) default NULL,
  `img_position` int(10) default '0',
  `catpath` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`cid`),
  KEY `idx_parent` (`parent`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;



# Dump of table e3gr_joomgallery_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_joomgallery_comments`;

CREATE TABLE `e3gr_joomgallery_comments` (
  `cmtid` int(11) NOT NULL auto_increment,
  `cmtpic` int(11) NOT NULL default '0',
  `cmtip` varchar(15) NOT NULL default '',
  `userid` int(11) unsigned NOT NULL default '0',
  `cmtname` varchar(50) NOT NULL default '',
  `cmttext` text NOT NULL,
  `cmtdate` varchar(20) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`cmtid`),
  KEY `idx_cmtpic` (`cmtpic`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_joomgallery_config
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_joomgallery_config`;

CREATE TABLE `e3gr_joomgallery_config` (
  `id` int(1) NOT NULL default '0',
  `jg_pathimages` varchar(50) NOT NULL,
  `jg_pathoriginalimages` varchar(50) NOT NULL,
  `jg_paththumbs` varchar(50) NOT NULL,
  `jg_pathftpupload` varchar(50) NOT NULL,
  `jg_pathtemp` varchar(50) NOT NULL,
  `jg_wmpath` varchar(50) NOT NULL,
  `jg_wmfile` varchar(50) NOT NULL,
  `jg_dateformat` varchar(50) NOT NULL,
  `jg_checkupdate` int(1) NOT NULL,
  `jg_filenamewithjs` int(1) NOT NULL,
  `jg_filenamesearch` varchar(50) NOT NULL,
  `jg_filenamereplace` varchar(50) NOT NULL,
  `jg_thumbcreation` varchar(5) NOT NULL,
  `jg_fastgd2thumbcreation` int(1) NOT NULL,
  `jg_impath` varchar(50) NOT NULL,
  `jg_resizetomaxwidth` int(1) NOT NULL,
  `jg_maxwidth` int(5) NOT NULL,
  `jg_picturequality` int(3) NOT NULL,
  `jg_useforresizedirection` int(1) NOT NULL,
  `jg_thumbwidth` int(5) NOT NULL,
  `jg_thumbheight` int(5) NOT NULL,
  `jg_thumbquality` int(3) NOT NULL,
  `jg_uploadorder` int(1) NOT NULL,
  `jg_useorigfilename` int(1) NOT NULL,
  `jg_filenamenumber` int(1) NOT NULL,
  `jg_delete_original` int(1) NOT NULL,
  `jg_wrongvaluecolor` varchar(10) NOT NULL,
  `jg_combuild` int(1) NOT NULL,
  `jg_realname` int(1) NOT NULL,
  `jg_bridge` int(1) NOT NULL,
  `jg_cooliris` int(1) NOT NULL,
  `jg_coolirislink` int(1) NOT NULL,
  `jg_userspace` int(1) NOT NULL,
  `jg_approve` int(1) NOT NULL,
  `jg_usercat` int(1) NOT NULL,
  `jg_maxusercat` int(5) NOT NULL,
  `jg_userowncatsupload` int(1) NOT NULL,
  `jg_maxuserimage` int(9) NOT NULL,
  `jg_maxfilesize` int(9) NOT NULL,
  `jg_category` text NOT NULL,
  `jg_usercategory` text NOT NULL,
  `jg_usercatacc` int(1) NOT NULL,
  `jg_maxuploadfields` int(3) NOT NULL,
  `jg_useruploadnumber` int(1) NOT NULL,
  `jg_special_gif_upload` int(1) NOT NULL,
  `jg_delete_original_user` int(1) NOT NULL,
  `jg_newpiccopyright` int(1) NOT NULL,
  `jg_newpicnote` int(1) NOT NULL,
  `jg_showrating` int(1) NOT NULL,
  `jg_maxvoting` int(1) NOT NULL,
  `jg_onlyreguservotes` int(1) NOT NULL,
  `jg_showcomment` int(1) NOT NULL,
  `jg_anoncomment` int(1) NOT NULL,
  `jg_namedanoncomment` int(1) NOT NULL,
  `jg_approvecom` int(1) NOT NULL,
  `jg_secimages` int(1) NOT NULL,
  `jg_bbcodesupport` int(1) NOT NULL,
  `jg_smiliesupport` int(1) NOT NULL,
  `jg_anismilie` int(1) NOT NULL,
  `jg_smiliescolor` varchar(10) NOT NULL,
  `jg_firstorder` varchar(20) NOT NULL,
  `jg_secondorder` varchar(20) NOT NULL,
  `jg_thirdorder` varchar(20) NOT NULL,
  `jg_pagetitle_cat` varchar(50) NOT NULL,
  `jg_pagetitle_detail` varchar(50) NOT NULL,
  `jg_showgalleryhead` int(1) NOT NULL,
  `jg_showpathway` int(1) NOT NULL,
  `jg_completebreadcrumbs` int(1) NOT NULL,
  `jg_search` int(1) NOT NULL,
  `jg_showallpics` int(1) NOT NULL,
  `jg_showallhits` int(1) NOT NULL,
  `jg_showbacklink` int(1) NOT NULL,
  `jg_suppresscredits` int(1) NOT NULL,
  `jg_showuserpanel` int(1) NOT NULL,
  `jg_showallpicstoadmin` int(1) NOT NULL,
  `jg_showminithumbs` int(1) NOT NULL,
  `jg_openjs_padding` int(3) NOT NULL,
  `jg_openjs_background` varchar(10) NOT NULL,
  `jg_dhtml_border` varchar(10) NOT NULL,
  `jg_show_title_in_dhtml` int(1) NOT NULL,
  `jg_show_description_in_dhtml` int(1) NOT NULL,
  `jg_lightbox_speed` int(3) NOT NULL,
  `jg_lightbox_slide_all` int(1) NOT NULL,
  `jg_resize_js_image` int(1) NOT NULL,
  `jg_disable_rightclick_original` int(1) NOT NULL,
  `jg_showgallerysubhead` int(1) NOT NULL,
  `jg_showallcathead` int(1) NOT NULL,
  `jg_colcat` int(1) NOT NULL,
  `jg_catperpage` int(1) NOT NULL,
  `jg_ordercatbyalpha` int(1) NOT NULL,
  `jg_showgallerypagenav` int(1) NOT NULL,
  `jg_showcatcount` int(1) NOT NULL,
  `jg_showcatthumb` int(1) NOT NULL,
  `jg_showrandomcatthumb` int(1) NOT NULL,
  `jg_ctalign` int(1) NOT NULL,
  `jg_showtotalcathits` int(1) NOT NULL,
  `jg_showcatasnew` int(1) NOT NULL,
  `jg_catdaysnew` int(3) NOT NULL,
  `jg_rmsm` int(1) NOT NULL,
  `jg_showrmsmcats` int(1) NOT NULL,
  `jg_showsubsingalleryview` int(1) NOT NULL,
  `jg_showcathead` int(1) NOT NULL,
  `jg_usercatorder` int(1) NOT NULL,
  `jg_usercatorderlist` varchar(50) NOT NULL,
  `jg_showcatdescriptionincat` int(1) NOT NULL,
  `jg_showpagenav` int(1) NOT NULL,
  `jg_showpiccount` int(1) NOT NULL,
  `jg_perpage` int(3) NOT NULL,
  `jg_catthumbalign` int(1) NOT NULL,
  `jg_colnumb` int(3) NOT NULL,
  `jg_detailpic_open` int(1) NOT NULL,
  `jg_lightboxbigpic` int(1) NOT NULL,
  `jg_showtitle` int(1) NOT NULL,
  `jg_showpicasnew` int(1) NOT NULL,
  `jg_daysnew` int(3) NOT NULL,
  `jg_showhits` int(1) NOT NULL,
  `jg_showauthor` int(1) NOT NULL,
  `jg_showowner` int(1) NOT NULL,
  `jg_showcatcom` int(1) NOT NULL,
  `jg_showcatrate` int(1) NOT NULL,
  `jg_showcatdescription` int(1) NOT NULL,
  `jg_showcategorydownload` int(1) NOT NULL,
  `jg_showcategoryfavourite` int(1) NOT NULL,
  `jg_showsubcathead` int(1) NOT NULL,
  `jg_showsubcatcount` int(1) NOT NULL,
  `jg_colsubcat` int(3) NOT NULL,
  `jg_subperpage` int(3) NOT NULL,
  `jg_showpagenavsubs` int(1) NOT NULL,
  `jg_subcatthumbalign` int(1) NOT NULL,
  `jg_showsubthumbs` int(1) NOT NULL,
  `jg_showrandomsubthumb` int(1) NOT NULL,
  `jg_ordersubcatbyalpha` int(1) NOT NULL,
  `jg_showtotalsubcathits` int(1) NOT NULL,
  `jg_showdetailpage` int(1) NOT NULL,
  `jg_showdetailnumberofpics` int(1) NOT NULL,
  `jg_cursor_navigation` int(1) NOT NULL,
  `jg_disable_rightclick_detail` int(1) NOT NULL,
  `jg_showdetailtitle` int(1) NOT NULL,
  `jg_showdetail` int(1) NOT NULL,
  `jg_showdetailaccordion` int(1) NOT NULL,
  `jg_showdetaildescription` int(1) NOT NULL,
  `jg_showdetaildatum` int(1) NOT NULL,
  `jg_showdetailhits` int(1) NOT NULL,
  `jg_showdetailrating` int(1) NOT NULL,
  `jg_showdetailfilesize` int(1) NOT NULL,
  `jg_showdetailauthor` int(1) NOT NULL,
  `jg_showoriginalfilesize` int(1) NOT NULL,
  `jg_showdetaildownload` int(1) NOT NULL,
  `jg_downloadfile` int(1) NOT NULL,
  `jg_downloadwithwatermark` int(1) NOT NULL,
  `jg_watermark` int(1) NOT NULL,
  `jg_watermarkpos` int(1) NOT NULL,
  `jg_bigpic` int(1) NOT NULL,
  `jg_bigpic_open` int(1) NOT NULL,
  `jg_bbcodelink` int(1) NOT NULL,
  `jg_showcommentsunreg` int(1) NOT NULL,
  `jg_showcommentsarea` int(1) NOT NULL,
  `jg_send2friend` int(1) NOT NULL,
  `jg_minis` int(1) NOT NULL,
  `jg_motionminis` int(1) NOT NULL,
  `jg_motionminiWidth` int(3) NOT NULL,
  `jg_motionminiHeight` int(3) NOT NULL,
  `jg_miniWidth` int(3) NOT NULL,
  `jg_miniHeight` int(3) NOT NULL,
  `jg_minisprop` int(1) NOT NULL,
  `jg_nameshields` int(1) NOT NULL,
  `jg_nameshields_unreg` int(1) NOT NULL,
  `jg_show_nameshields_unreg` int(1) NOT NULL,
  `jg_nameshields_height` int(3) NOT NULL,
  `jg_nameshields_width` int(3) NOT NULL,
  `jg_slideshow` int(1) NOT NULL,
  `jg_slideshow_timer` int(3) NOT NULL,
  `jg_slideshow_usefilter` int(1) NOT NULL,
  `jg_slideshow_filterbychance` int(1) NOT NULL,
  `jg_slideshow_filtertimer` int(3) NOT NULL,
  `jg_showsliderepeater` int(1) NOT NULL,
  `jg_showexifdata` int(1) NOT NULL,
  `jg_subifdtags` text NOT NULL,
  `jg_ifdotags` text NOT NULL,
  `jg_gpstags` text NOT NULL,
  `jg_showiptcdata` int(1) NOT NULL,
  `jg_iptctags` text NOT NULL,
  `jg_showtoplist` int(1) NOT NULL,
  `jg_toplist` int(3) NOT NULL,
  `jg_topthumbalign` int(1) NOT NULL,
  `jg_toptextalign` int(1) NOT NULL,
  `jg_toplistcols` int(3) NOT NULL,
  `jg_whereshowtoplist` int(1) NOT NULL,
  `jg_showrate` int(1) NOT NULL,
  `jg_showlatest` int(1) NOT NULL,
  `jg_showcom` int(1) NOT NULL,
  `jg_showthiscomment` int(1) NOT NULL,
  `jg_showmostviewed` int(1) NOT NULL,
  `jg_favourites` int(1) NOT NULL,
  `jg_showdetailfavourite` int(1) NOT NULL,
  `jg_favouritesshownotauth` int(1) NOT NULL,
  `jg_maxfavourites` int(5) NOT NULL,
  `jg_zipdownload` int(1) NOT NULL,
  `jg_usefavouritesforpubliczip` int(1) NOT NULL,
  `jg_usefavouritesforzip` int(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_joomgallery_config` WRITE;
/*!40000 ALTER TABLE `e3gr_joomgallery_config` DISABLE KEYS */;
INSERT INTO `e3gr_joomgallery_config` (`id`,`jg_pathimages`,`jg_pathoriginalimages`,`jg_paththumbs`,`jg_pathftpupload`,`jg_pathtemp`,`jg_wmpath`,`jg_wmfile`,`jg_dateformat`,`jg_checkupdate`,`jg_filenamewithjs`,`jg_filenamesearch`,`jg_filenamereplace`,`jg_thumbcreation`,`jg_fastgd2thumbcreation`,`jg_impath`,`jg_resizetomaxwidth`,`jg_maxwidth`,`jg_picturequality`,`jg_useforresizedirection`,`jg_thumbwidth`,`jg_thumbheight`,`jg_thumbquality`,`jg_uploadorder`,`jg_useorigfilename`,`jg_filenamenumber`,`jg_delete_original`,`jg_wrongvaluecolor`,`jg_combuild`,`jg_realname`,`jg_bridge`,`jg_cooliris`,`jg_coolirislink`,`jg_userspace`,`jg_approve`,`jg_usercat`,`jg_maxusercat`,`jg_userowncatsupload`,`jg_maxuserimage`,`jg_maxfilesize`,`jg_category`,`jg_usercategory`,`jg_usercatacc`,`jg_maxuploadfields`,`jg_useruploadnumber`,`jg_special_gif_upload`,`jg_delete_original_user`,`jg_newpiccopyright`,`jg_newpicnote`,`jg_showrating`,`jg_maxvoting`,`jg_onlyreguservotes`,`jg_showcomment`,`jg_anoncomment`,`jg_namedanoncomment`,`jg_approvecom`,`jg_secimages`,`jg_bbcodesupport`,`jg_smiliesupport`,`jg_anismilie`,`jg_smiliescolor`,`jg_firstorder`,`jg_secondorder`,`jg_thirdorder`,`jg_pagetitle_cat`,`jg_pagetitle_detail`,`jg_showgalleryhead`,`jg_showpathway`,`jg_completebreadcrumbs`,`jg_search`,`jg_showallpics`,`jg_showallhits`,`jg_showbacklink`,`jg_suppresscredits`,`jg_showuserpanel`,`jg_showallpicstoadmin`,`jg_showminithumbs`,`jg_openjs_padding`,`jg_openjs_background`,`jg_dhtml_border`,`jg_show_title_in_dhtml`,`jg_show_description_in_dhtml`,`jg_lightbox_speed`,`jg_lightbox_slide_all`,`jg_resize_js_image`,`jg_disable_rightclick_original`,`jg_showgallerysubhead`,`jg_showallcathead`,`jg_colcat`,`jg_catperpage`,`jg_ordercatbyalpha`,`jg_showgallerypagenav`,`jg_showcatcount`,`jg_showcatthumb`,`jg_showrandomcatthumb`,`jg_ctalign`,`jg_showtotalcathits`,`jg_showcatasnew`,`jg_catdaysnew`,`jg_rmsm`,`jg_showrmsmcats`,`jg_showsubsingalleryview`,`jg_showcathead`,`jg_usercatorder`,`jg_usercatorderlist`,`jg_showcatdescriptionincat`,`jg_showpagenav`,`jg_showpiccount`,`jg_perpage`,`jg_catthumbalign`,`jg_colnumb`,`jg_detailpic_open`,`jg_lightboxbigpic`,`jg_showtitle`,`jg_showpicasnew`,`jg_daysnew`,`jg_showhits`,`jg_showauthor`,`jg_showowner`,`jg_showcatcom`,`jg_showcatrate`,`jg_showcatdescription`,`jg_showcategorydownload`,`jg_showcategoryfavourite`,`jg_showsubcathead`,`jg_showsubcatcount`,`jg_colsubcat`,`jg_subperpage`,`jg_showpagenavsubs`,`jg_subcatthumbalign`,`jg_showsubthumbs`,`jg_showrandomsubthumb`,`jg_ordersubcatbyalpha`,`jg_showtotalsubcathits`,`jg_showdetailpage`,`jg_showdetailnumberofpics`,`jg_cursor_navigation`,`jg_disable_rightclick_detail`,`jg_showdetailtitle`,`jg_showdetail`,`jg_showdetailaccordion`,`jg_showdetaildescription`,`jg_showdetaildatum`,`jg_showdetailhits`,`jg_showdetailrating`,`jg_showdetailfilesize`,`jg_showdetailauthor`,`jg_showoriginalfilesize`,`jg_showdetaildownload`,`jg_downloadfile`,`jg_downloadwithwatermark`,`jg_watermark`,`jg_watermarkpos`,`jg_bigpic`,`jg_bigpic_open`,`jg_bbcodelink`,`jg_showcommentsunreg`,`jg_showcommentsarea`,`jg_send2friend`,`jg_minis`,`jg_motionminis`,`jg_motionminiWidth`,`jg_motionminiHeight`,`jg_miniWidth`,`jg_miniHeight`,`jg_minisprop`,`jg_nameshields`,`jg_nameshields_unreg`,`jg_show_nameshields_unreg`,`jg_nameshields_height`,`jg_nameshields_width`,`jg_slideshow`,`jg_slideshow_timer`,`jg_slideshow_usefilter`,`jg_slideshow_filterbychance`,`jg_slideshow_filtertimer`,`jg_showsliderepeater`,`jg_showexifdata`,`jg_subifdtags`,`jg_ifdotags`,`jg_gpstags`,`jg_showiptcdata`,`jg_iptctags`,`jg_showtoplist`,`jg_toplist`,`jg_topthumbalign`,`jg_toptextalign`,`jg_toplistcols`,`jg_whereshowtoplist`,`jg_showrate`,`jg_showlatest`,`jg_showcom`,`jg_showthiscomment`,`jg_showmostviewed`,`jg_favourites`,`jg_showdetailfavourite`,`jg_favouritesshownotauth`,`jg_maxfavourites`,`jg_zipdownload`,`jg_usefavouritesforpubliczip`,`jg_usefavouritesforzip`)
VALUES
	(0,'components/com_joomgallery/img_pictures/','components/com_joomgallery/img_originals/','components/com_joomgallery/img_thumbnails/','components/com_joomgallery/ftp_upload/','administrator/components/com_joomgallery/temp/','components/com_joomgallery/assets/images/','watermark.png','%d.%m.%Y %H:%M:%S',1,1,'ä|ö|ü|ß','ae|oe|ue|ss','gd2',1,'',1,400,100,0,133,100,100,1,0,1,0,'#f00',0,0,0,0,0,1,0,1,10,0,500,2000000,'','',1,3,0,1,2,1,1,0,5,0,0,1,1,1,0,1,1,0,'grey','ordering ASC','imgdate DESC','imgtitle DESC','[! JGS_CATEGORY!]: #cat','[! JGS_CATEGORY!]: #cat - [! JGS_PICTURE!]:  #img',1,0,1,0,0,0,0,0,0,1,1,10,'#fff','#808080',0,1,5,1,1,1,0,0,2,14,1,2,0,1,3,3,0,0,7,0,0,0,1,0,'date,title',1,2,0,12,1,2,0,1,0,0,10,0,0,0,0,0,1,0,0,0,0,2,12,2,3,2,3,0,1,1,0,1,0,1,0,0,1,0,0,0,0,0,0,0,2,1,0,9,2,6,0,0,2,0,1,2,400,50,28,28,2,0,0,0,10,6,1,3,1,0,1,0,0,'','','',0,'',0,12,1,1,1,0,0,1,0,0,1,0,0,0,0,0,0,0);

/*!40000 ALTER TABLE `e3gr_joomgallery_config` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_joomgallery_countstop
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_joomgallery_countstop`;

CREATE TABLE `e3gr_joomgallery_countstop` (
  `cspicid` int(11) NOT NULL default '0',
  `csip` varchar(20) NOT NULL,
  `cssessionid` varchar(200) default NULL,
  `cstime` datetime default NULL,
  KEY `idx_cspicid` (`cspicid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_joomgallery_nameshields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_joomgallery_nameshields`;

CREATE TABLE `e3gr_joomgallery_nameshields` (
  `nid` int(11) NOT NULL auto_increment,
  `npicid` int(11) NOT NULL default '0',
  `nuserid` int(11) unsigned NOT NULL default '0',
  `nxvalue` int(11) NOT NULL default '0',
  `nyvalue` int(11) NOT NULL default '0',
  `nuserip` varchar(15) NOT NULL default '0',
  `ndate` varchar(20) NOT NULL,
  `nzindex` int(11) NOT NULL default '0',
  PRIMARY KEY  (`nid`),
  KEY `idx_picid` (`npicid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_joomgallery_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_joomgallery_users`;

CREATE TABLE `e3gr_joomgallery_users` (
  `uid` int(11) NOT NULL auto_increment,
  `uuserid` int(11) NOT NULL default '0',
  `piclist` text,
  `layout` int(1) NOT NULL,
  `time` datetime NOT NULL,
  `zipname` varchar(70) NOT NULL,
  PRIMARY KEY  (`uid`),
  KEY `idx_uid` (`uuserid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_joomgallery_votes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_joomgallery_votes`;

CREATE TABLE `e3gr_joomgallery_votes` (
  `voteid` int(11) NOT NULL auto_increment,
  `picid` int(11) NOT NULL default '0',
  `userid` int(11) unsigned NOT NULL default '0',
  `userip` varchar(15) NOT NULL default '0',
  `datevoted` varchar(20) NOT NULL,
  `timevoted` varchar(20) NOT NULL,
  `vote` int(11) NOT NULL default '0',
  PRIMARY KEY  (`voteid`),
  KEY `idx_picid` (`picid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_menu`;

CREATE TABLE `e3gr_menu` (
  `id` int(11) NOT NULL auto_increment,
  `menutype` varchar(75) default NULL,
  `name` varchar(255) default NULL,
  `alias` varchar(255) NOT NULL default '',
  `link` text,
  `type` varchar(50) NOT NULL default '',
  `published` tinyint(1) NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `componentid` int(11) unsigned NOT NULL default '0',
  `sublevel` int(11) default '0',
  `ordering` int(11) default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `pollid` int(11) NOT NULL default '0',
  `browserNav` tinyint(4) default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `utaccess` tinyint(3) unsigned NOT NULL default '0',
  `params` text NOT NULL,
  `lft` int(11) unsigned NOT NULL default '0',
  `rgt` int(11) unsigned NOT NULL default '0',
  `home` int(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `componentid` (`componentid`,`menutype`,`published`,`access`),
  KEY `menutype` (`menutype`)
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_menu` WRITE;
/*!40000 ALTER TABLE `e3gr_menu` DISABLE KEYS */;
INSERT INTO `e3gr_menu` (`id`,`menutype`,`name`,`alias`,`link`,`type`,`published`,`parent`,`componentid`,`sublevel`,`ordering`,`checked_out`,`checked_out_time`,`pollid`,`browserNav`,`access`,`utaccess`,`params`,`lft`,`rgt`,`home`)
VALUES
	(1,'mainmenu','E3 GameRevolution','e3-gamerevolution','index.php?option=com_janews&view=janews','component',1,0,47,0,2,0,'0000-00-00 00:00:00',0,0,0,3,'show=0\nid=0\nhomepage=\nendable=\npage_title=E3 2010 \\| GameRevolution\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n',0,0,1),
	(10,'mainmenu','JA News','ja-news','index.php?option=com_janews&view=janews','component',0,0,47,0,1,62,'2010-05-24 20:24:44',0,0,0,0,'show=0\nid=0\nhomepage=\r\nendable=\r\npage_title=\r\nshow_page_title=1\npageclass_sfx=\r\nmenu_image=-1\nsecure=0\n',0,0,0),
	(52,'janews','Featured Games','featured-games','index.php?option=com_janews&view=section&layout=blog&id=16','component',1,0,47,0,1,0,'0000-00-00 00:00:00',0,0,0,0,'homepage=\nendable=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n',0,0,0),
	(53,'janews','Articles','articles','index.php?option=com_content&view=category&layout=blog&id=37','component',1,52,20,1,1,0,'0000-00-00 00:00:00',0,0,0,0,'show_description=0\nshow_description_image=0\nnum_leading_articles=1\nnum_intro_articles=4\nnum_columns=1\nnum_links=4\norderby_pri=\norderby_sec=\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1',0,0,0),
	(54,'janews','News and Interviews','news-and-interviews','index.php?option=com_janews&view=section&layout=blog&id=17','component',1,0,47,0,2,0,'0000-00-00 00:00:00',0,0,0,0,'homepage=\nendable=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n',0,0,0),
	(55,'janews','News','news','index.php?option=com_content&view=category&layout=blog&id=38','component',1,54,20,1,1,62,'2010-05-31 00:37:42',0,0,0,0,'show_description=0\nshow_description_image=0\nnum_leading_articles=1\nnum_intro_articles=4\nnum_columns=1\nnum_links=4\norderby_pri=\norderby_sec=\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1',0,0,0),
	(56,'janews','Interviews','interviews','index.php?option=com_content&view=category&layout=blog&id=39','component',1,54,20,1,2,0,'0000-00-00 00:00:00',0,0,0,0,'show_description=0\nshow_description_image=0\nnum_leading_articles=1\nnum_intro_articles=4\nnum_columns=1\nnum_links=4\norderby_pri=\norderby_sec=\nshow_pagination=2\nshow_pagination_results=1\nshow_feed_link=1',0,0,0),
	(57,'mainmenu','Galleries','galleries','index.php?option=com_joomgallery','component',1,0,34,0,3,0,'0000-00-00 00:00:00',0,0,0,0,'page_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n',0,0,0),
	(58,'mainmenu','Featured Games','featured-games','index.php?option=com_janews&view=janews','component',1,0,47,0,4,0,'0000-00-00 00:00:00',0,0,0,0,'show=1\nid=16\nhomepage=\nendable=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n',0,0,0),
	(59,'mainmenu','News and Interviews','news-and-interviews','index.php?option=com_janews&view=janews','component',1,0,47,0,5,0,'0000-00-00 00:00:00',0,0,0,0,'show=1\nid=17\nhomepage=\nendable=\npage_title=\nshow_page_title=1\npageclass_sfx=\nmenu_image=-1\nsecure=0\n\n',0,0,0);

/*!40000 ALTER TABLE `e3gr_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_menu_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_menu_types`;

CREATE TABLE `e3gr_menu_types` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `menutype` varchar(75) NOT NULL default '',
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `menutype` (`menutype`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_menu_types` WRITE;
/*!40000 ALTER TABLE `e3gr_menu_types` DISABLE KEYS */;
INSERT INTO `e3gr_menu_types` (`id`,`menutype`,`title`,`description`)
VALUES
	(1,'mainmenu','Main Menu','The main menu for the site'),
	(2,'janews','JA News','Real Magazine Portal'),
	(4,'hidden','Hidden','Hidden');

/*!40000 ALTER TABLE `e3gr_menu_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_messages
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_messages`;

CREATE TABLE `e3gr_messages` (
  `message_id` int(10) unsigned NOT NULL auto_increment,
  `user_id_from` int(10) unsigned NOT NULL default '0',
  `user_id_to` int(10) unsigned NOT NULL default '0',
  `folder_id` int(10) unsigned NOT NULL default '0',
  `date_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `state` int(11) NOT NULL default '0',
  `priority` int(1) unsigned NOT NULL default '0',
  `subject` text NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY  (`message_id`),
  KEY `useridto_state` (`user_id_to`,`state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_messages_cfg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_messages_cfg`;

CREATE TABLE `e3gr_messages_cfg` (
  `user_id` int(10) unsigned NOT NULL default '0',
  `cfg_name` varchar(100) NOT NULL default '',
  `cfg_value` varchar(255) NOT NULL default '',
  UNIQUE KEY `idx_user_var_name` (`user_id`,`cfg_name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_migration_backlinks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_migration_backlinks`;

CREATE TABLE `e3gr_migration_backlinks` (
  `itemid` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `sefurl` text NOT NULL,
  `newurl` text NOT NULL,
  PRIMARY KEY  (`itemid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_modules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_modules`;

CREATE TABLE `e3gr_modules` (
  `id` int(11) NOT NULL auto_increment,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `ordering` int(11) NOT NULL default '0',
  `position` varchar(50) default NULL,
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `module` varchar(50) default NULL,
  `numnews` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `showtitle` tinyint(3) unsigned NOT NULL default '1',
  `params` text NOT NULL,
  `iscore` tinyint(4) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  `control` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `published` (`published`,`access`),
  KEY `newsfeeds` (`module`,`published`)
) ENGINE=MyISAM AUTO_INCREMENT=58 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_modules` WRITE;
/*!40000 ALTER TABLE `e3gr_modules` DISABLE KEYS */;
INSERT INTO `e3gr_modules` (`id`,`title`,`content`,`ordering`,`position`,`checked_out`,`checked_out_time`,`published`,`module`,`numnews`,`access`,`showtitle`,`params`,`iscore`,`client_id`,`control`)
VALUES
	(1,'Main Menu','',0,'nav_top',0,'0000-00-00 00:00:00',0,'mod_mainmenu',0,0,1,'menutype=mainmenu\nmenu_style=list\nstartLevel=0\nendLevel=0\nshowAllChildren=0\nwindow_open=\nshow_whitespace=0\ncache=1\ntag_id=\nclass_sfx=\nmoduleclass_sfx=_menu\nmaxdepth=10\nmenu_images=0\nmenu_images_align=0\nmenu_images_link=0\nexpand_menu=0\nactivate_parent=0\nfull_active_id=0\nindent_image=0\nindent_image1=\nindent_image2=\nindent_image3=\nindent_image4=\nindent_image5=\nindent_image6=\nspacer=\nend_spacer=\n\n',1,0,''),
	(2,'Login','',1,'login',0,'0000-00-00 00:00:00',1,'mod_login',0,0,1,'',1,1,''),
	(3,'Popular','',3,'cpanel',0,'0000-00-00 00:00:00',1,'mod_popular',0,2,1,'',0,1,''),
	(4,'Recent added Articles','',4,'cpanel',0,'0000-00-00 00:00:00',1,'mod_latest',0,2,1,'ordering=c_dsc\nuser_id=0\ncache=0\n\n',0,1,''),
	(5,'Menu Stats','',5,'cpanel',0,'0000-00-00 00:00:00',1,'mod_stats',0,2,1,'',0,1,''),
	(6,'Unread Messages','',1,'header',0,'0000-00-00 00:00:00',1,'mod_unread',0,2,1,'',1,1,''),
	(7,'Online Users','',2,'header',0,'0000-00-00 00:00:00',1,'mod_online',0,2,1,'',1,1,''),
	(8,'Toolbar','',1,'toolbar',0,'0000-00-00 00:00:00',1,'mod_toolbar',0,2,1,'',1,1,''),
	(9,'Quick Icons','',1,'icon',0,'0000-00-00 00:00:00',1,'mod_quickicon',0,2,1,'',1,1,''),
	(10,'Logged in Users','',2,'cpanel',0,'0000-00-00 00:00:00',1,'mod_logged',0,2,1,'',0,1,''),
	(11,'Footer','',0,'footer',0,'0000-00-00 00:00:00',1,'mod_footer',0,0,1,'',1,1,''),
	(12,'Admin Menu','',1,'menu',0,'0000-00-00 00:00:00',1,'mod_menu',0,2,1,'',0,1,''),
	(13,'Admin SubMenu','',1,'submenu',0,'0000-00-00 00:00:00',1,'mod_submenu',0,2,1,'',0,1,''),
	(14,'User Status','',1,'status',0,'0000-00-00 00:00:00',1,'mod_status',0,2,1,'',0,1,''),
	(15,'Title','',1,'title',0,'0000-00-00 00:00:00',1,'mod_title',0,2,1,'',0,1,''),
	(36,'Google AD Helper','',1,'body',62,'2010-05-24 20:36:01',1,'mod_php',0,0,0,'moduleclass_sfx=\ncache=0\nphp=<!-- GAM Header Script -->\\n<script type=\"text/javascript\" src=\"http://partner.googleadservices.com/gampad/google_service.js\">\\n</script>\\n<script type=\"text/javascript\">\\n  GS_googleAddAdSenseService(\"ca-pub-1304704158939332\");\\n  GS_googleEnableAllServices();\\n</script>\\n<script type=\"text/javascript\">\\n  GA_googleUseIframeRendering();\\n</script>\\n<!-- END GAM Header Script -->\\n\neval_php=1\ndiscovery=1\n\n',0,0,''),
	(17,'AD 230x90','',0,'small_leaderboard',62,'2010-05-26 18:47:52',1,'mod_gnads',0,0,0,'sitename=cr.craveonline.com\nsize=230x90\ntriggertags=1\nelse=GA_googleFillSlotWithSize(\"ca-pub-1304704158939332\", \"craveonline_ros_230x90\", 230, 90);\ntest_mode=0\nprefix=\nextra_params=\nextra_triggers=\n\n',0,0,''),
	(18,'AD 728x90','',0,'leaderboard',0,'0000-00-00 00:00:00',1,'mod_gnads',0,0,0,'sitename=cr.craveonline.com\nsize=728x90\ntriggertags=0\nelse=\ntest_mode=0\nprefix=summer-hub\nextra_params=\nextra_triggers=\n\n',0,0,''),
	(19,'Property Menu','',0,'nav_top',0,'0000-00-00 00:00:00',1,'mod_si_menu',0,0,0,'menu=gamerevolution\n\n',0,0,''),
	(40,'AD 1000x1000','',0,'nav_top',0,'0000-00-00 00:00:00',0,'mod_gnads',0,0,0,'sitename=cr.craveonline.com\nsize=1000x1000\ntriggertags=0\nelse=\ntest_mode=0\nprefix=summer-hub\nextra_params=\nextra_triggers=\n\n',0,0,''),
	(23,'JoomGallery News','',1,'joom_cpanel',0,'0000-00-00 00:00:00',1,'mod_feed',0,0,1,'cache=1\n    cache_time=15\n    moduleclass_sfx=\n    rssurl=http://en.joomgallery.net/?format=feed&type=rss\n    rssrtl=0\n    rsstitle=1\n    rssdesc=0\n    rssimage=1\n    rssitems=3\n    rssitemdesc=1\n    word_count=30',0,1,''),
	(31,'Latest Articles','',4,'right',0,'0000-00-00 00:00:00',1,'mod_minifrontpage',0,0,1,'cache=1\nmoduleclass_sfx=latest_articles\nsections=13,14,15\ncategories=34,35,36\norder=0\norder_type=desc\nperiod=1200\nloadorder=0\ncat_title=0\ncat_title_link=0\nshow_front=1\nshow_title=1\ntitle_link=1\nshow_author=0\nshow_author_type=0\nshow_date=0\ndate_type=0\ndate_format=%d/%m/%Y\nlimit=100\nfulllink=+ Full Story\ncolumns=1\ncount=10\nnum_intro=10\nnum_intro_skip=0\nthumb_embed=1\nthumb_embed_default=1\nthumb_width=64\nthumb_height=64\naspect=0\nheader_title_links=Other Articles\n\n',0,0,''),
	(51,'Footer','',0,'footer',0,'0000-00-00 00:00:00',1,'mod_si_footer',0,0,0,'footer=gamerevolution\ncraveRU=0\ntracking=\n\n',0,0,''),
	(52,'Twitter','',3,'features',0,'0000-00-00 00:00:00',0,'mod_twitter',0,0,0,'username=game_revolution\ntweets=5\nmarquee=1\ndirection=left\nspeed=50\ncontainer=\nwrap=\n\n',0,0,''),
	(53,'Frontpage Slideshow','',2,'features',62,'2010-06-02 23:34:01',1,'mod_fpss',0,0,0,'moduleclass_sfx=fpss\ncache=1\ncache_time=900\ncatid=1\nengine=mootools\ndisablelib=0\noptimizejs=0\nfpss_template=GameRev\nwidth=539\nheight=304\nsidebar_width=200\nhide_nav=0\ndelay=6000\nspeed=500\nloadingTime=800\nautoSlide=0\nrandom=0\nlimitslides=\nrotateAction=mouseover\nmtCTRtext_effect=0\nmtCTRtransitionText=1000\nseperator=>>\nwords=20\nchars=\nstriptags=1\nshowtitle=2\nshowseccat=2\nshowcustomtext=2\nshowplaintext=2\nshowreadmore=2\nnolink=2\n\n',0,0,''),
	(54,'Destructoid Twitter','',3,'right',0,'0000-00-00 00:00:00',1,'mod_php',0,0,0,'moduleclass_sfx=twitter\ncache=0\nphp=<script type=\"text/javascript\" src=\"http://cdn.widgetserver.com/syndication/subscriber/InsertWidget.js\"></script><script type=\"text/javascript\">if (WIDGETBOX) WIDGETBOX.renderWidget(\'2d72366d-114a-4bec-8355-0afde220e4b2\');</script><noscript>Get the <a href=\"http://www.widgetbox.com/widget/destructoid-editors-destructoid-on-twitter\">Destructoid Editors (destructoid) on Twitter</a> widget and many other <a href=\"http://www.widgetbox.com/\">great free widgets</a> at <a href=\"http://www.widgetbox.com\">Widgetbox</a>! Not seeing a widget? (<a href=\"http://docs.widgetbox.com/using-widgets/installing-widgets/why-cant-i-see-my-widget/\">More info</a>)</noscript>\neval_php=1\ndiscovery=1\n\n',0,0,''),
	(55,'Destructoid RSS','',1,'right',0,'0000-00-00 00:00:00',1,'mod_php',0,0,0,'moduleclass_sfx=rss\ncache=0\nphp=<script type=\"text/javascript\" src=\"http://cdn.widgetserver.com/syndication/subscriber/InsertWidget.js\"></script><script type=\"text/javascript\">if (WIDGETBOX) WIDGETBOX.renderWidget(\'3e11a73b-37f0-4bed-816d-568aedbfd7c4\');</script><noscript>Get the <a href=\"http://www.widgetbox.com/widget/destructoidcommodeatomte3\">destructoid.com/?mode=atom&t=E3</a> widget and many other <a href=\"http://www.widgetbox.com/\">great free widgets</a> at <a href=\"http://www.widgetbox.com\">Widgetbox</a>! Not seeing a widget? (<a href=\"http://docs.widgetbox.com/using-widgets/installing-widgets/why-cant-i-see-my-widget/\">More info</a>)</noscript>\neval_php=1\ndiscovery=1\n\n',0,0,''),
	(28,'Galleries','',0,'bottom_content',0,'0000-00-00 00:00:00',1,'mod_joomimg',0,0,1,'moduleclass_sfx=hp_galleries\nitemid=\nslideshowthis=0\nimagetype=0\nlimit=8\nsorting=rand()\nresultbytime=0\ncats=\nshoworhidecats=1\ndynamiccats=0\nimg_per_row=4\npiclink=0\nopeninbox=0\nshow_empty_message=1\nimage_position=1\ncrop_img=0\ncrop_sizewidth=135\ncrop_sizeheight=135\nauto_resize=1\nauto_resize_max=200\nimgwidth=\nimgheight=135\nshowtext=0\nshowtitle=0\nstrtitlewrap=0\nshowdescription=0\nstrdescount=0\nstrdeswrap=0\nshowuser=0\nshowcatg=0\nshowhits=0\nshowvotesum=0\nshowvotes=0\nshowimgdate=0\nshowcmtdate=0\nshowcmttext=0\nshowcmtcount=0\nstrcmtcount=0\nstrcmtwrap=0\nshowcmtmore=0\nscrollthis=0\nscrolldirection=left\nscrollheight=250\nscrollwidth=230\nscrollamount=1\nscrolldelay=10\nscrollmouse=1\ndir_hor=left\ndir_vert=top\nsectiontableentry=0\nborder=0\nborderwidth=2px\nborderstyle=solid\nbordercolor=#000\nborderpadding=2px\nwidth=430\nheight=300\npiclinkslideshow=0\nloadingDiv=1\nshowCaption=1\nshowTitleCaption=1\nheightCaption=45\ntitleSize=13px\ntitleColor=#fff\ndescSize=11px\ndescColor=#ccc\nimageResize=1\nimageDuration=9000\ntransDuration=2000\ntransType=combo\npan=50\nzoom=50\ntransition=Expo.easeOut\n\n',0,0,''),
	(57,'Connect','',0,'features',0,'0000-00-00 00:00:00',1,'mod_php',0,0,0,'moduleclass_sfx=fpss_connect\ncache=0\nphp=<div class=\'connect_icons\'>\\n<a href=\'\' class=\'facebook\'>Facebook Share</a>\\n<a href=\'\' class=\'twitter\'>Twitter Share</a>\\n<a href=\'\' class=\'rss\'>RSS Feed</a>\\n</div>\neval_php=1\ndiscovery=1\n\n',0,0,''),
	(48,'Hidden','',1,'left',0,'0000-00-00 00:00:00',0,'mod_mainmenu',0,0,1,'menutype=hidden',0,0,''),
	(56,'Destructoid RSS - View More','',2,'right',0,'0000-00-00 00:00:00',1,'mod_php',0,0,0,'moduleclass_sfx=rss_more\ncache=0\nphp=<a href=\'http://destructoid.com/?mode=atom&t=E3\' target=\'_blank\'>View RSS</a>\neval_php=1\ndiscovery=1\n\n',0,0,''),
	(49,'Breadcrumbs','',0,'breadcrumbs',0,'0000-00-00 00:00:00',1,'mod_breadcrumbs',0,0,0,'showHome=1\nhomeText=Home\nshowSection=1\nshowCategory=0\nshowLast=1\nseparator=\\\nmoduleclass_sfx=\ncache=0\n\n',0,0,'');

/*!40000 ALTER TABLE `e3gr_modules` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_modules_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_modules_menu`;

CREATE TABLE `e3gr_modules_menu` (
  `moduleid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`moduleid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_modules_menu` WRITE;
/*!40000 ALTER TABLE `e3gr_modules_menu` DISABLE KEYS */;
INSERT INTO `e3gr_modules_menu` (`moduleid`,`menuid`)
VALUES
	(1,0),
	(17,0),
	(18,0),
	(19,0),
	(28,1),
	(31,2),
	(31,5),
	(31,25),
	(31,32),
	(31,33),
	(31,35),
	(31,36),
	(31,37),
	(31,38),
	(31,39),
	(31,40),
	(31,42),
	(31,43),
	(31,44),
	(31,45),
	(31,46),
	(31,47),
	(31,48),
	(31,49),
	(36,0),
	(40,0),
	(41,0),
	(48,0),
	(49,52),
	(49,53),
	(49,54),
	(49,55),
	(49,56),
	(49,57),
	(49,58),
	(49,59),
	(51,0),
	(52,1),
	(53,1),
	(54,0),
	(55,0),
	(56,0),
	(57,1);

/*!40000 ALTER TABLE `e3gr_modules_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_newsfeeds
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_newsfeeds`;

CREATE TABLE `e3gr_newsfeeds` (
  `catid` int(11) NOT NULL default '0',
  `id` int(11) NOT NULL auto_increment,
  `name` text NOT NULL,
  `alias` varchar(255) NOT NULL default '',
  `link` text NOT NULL,
  `filename` varchar(200) default NULL,
  `published` tinyint(1) NOT NULL default '0',
  `numarticles` int(11) unsigned NOT NULL default '1',
  `cache_time` int(11) unsigned NOT NULL default '3600',
  `checked_out` tinyint(3) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `rtl` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `published` (`published`),
  KEY `catid` (`catid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_plugins
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_plugins`;

CREATE TABLE `e3gr_plugins` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(100) NOT NULL default '',
  `element` varchar(100) NOT NULL default '',
  `folder` varchar(100) NOT NULL default '',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `ordering` int(11) NOT NULL default '0',
  `published` tinyint(3) NOT NULL default '0',
  `iscore` tinyint(3) NOT NULL default '0',
  `client_id` tinyint(3) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_folder` (`published`,`client_id`,`access`,`folder`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_plugins` WRITE;
/*!40000 ALTER TABLE `e3gr_plugins` DISABLE KEYS */;
INSERT INTO `e3gr_plugins` (`id`,`name`,`element`,`folder`,`access`,`ordering`,`published`,`iscore`,`client_id`,`checked_out`,`checked_out_time`,`params`)
VALUES
	(1,'Authentication - Joomla','joomla','authentication',0,1,1,1,0,0,'0000-00-00 00:00:00',''),
	(2,'Authentication - LDAP','ldap','authentication',0,2,0,1,0,0,'0000-00-00 00:00:00','host=\nport=389\nuse_ldapV3=0\nnegotiate_tls=0\nno_referrals=0\nauth_method=bind\nbase_dn=\nsearch_string=\nusers_dn=\nusername=\npassword=\nldap_fullname=fullName\nldap_email=mail\nldap_uid=uid\n\n'),
	(3,'Authentication - GMail','gmail','authentication',0,4,0,0,0,0,'0000-00-00 00:00:00',''),
	(4,'Authentication - OpenID','openid','authentication',0,3,0,0,0,0,'0000-00-00 00:00:00',''),
	(5,'User - Joomla!','joomla','user',0,0,1,0,0,0,'0000-00-00 00:00:00','autoregister=1\n\n'),
	(6,'Search - Content','content','search',0,1,1,1,0,0,'0000-00-00 00:00:00','search_limit=50\nsearch_content=1\nsearch_uncategorised=1\nsearch_archived=1\n\n'),
	(7,'Search - Contacts','contacts','search',0,3,1,1,0,0,'0000-00-00 00:00:00','search_limit=50\n\n'),
	(8,'Search - Categories','categories','search',0,4,1,0,0,0,'0000-00-00 00:00:00','search_limit=50\n\n'),
	(9,'Search - Sections','sections','search',0,5,1,0,0,0,'0000-00-00 00:00:00','search_limit=50\n\n'),
	(10,'Search - Newsfeeds','newsfeeds','search',0,6,1,0,0,0,'0000-00-00 00:00:00','search_limit=50\n\n'),
	(11,'Search - Weblinks','weblinks','search',0,2,1,1,0,0,'0000-00-00 00:00:00','search_limit=50\n\n'),
	(12,'Content - Pagebreak','pagebreak','content',0,10000,1,1,0,0,'0000-00-00 00:00:00','enabled=1\ntitle=1\nmultipage_toc=1\nshowall=1\n\n'),
	(13,'Content - Rating','vote','content',0,4,1,1,0,0,'0000-00-00 00:00:00',''),
	(14,'Content - Email Cloaking','emailcloak','content',0,5,1,0,0,0,'0000-00-00 00:00:00','mode=1\n\n'),
	(15,'Content - Code Hightlighter (GeSHi)','geshi','content',0,5,0,0,0,0,'0000-00-00 00:00:00',''),
	(16,'Content - Load Module','loadmodule','content',0,6,1,0,0,0,'0000-00-00 00:00:00','enabled=1\nstyle=0\n\n'),
	(17,'Content - Page Navigation','pagenavigation','content',0,2,1,1,0,0,'0000-00-00 00:00:00','position=1\n\n'),
	(18,'Editor - No Editor','none','editors',0,0,1,1,0,0,'0000-00-00 00:00:00',''),
	(19,'Editor - TinyMCE','tinymce','editors',0,0,1,1,0,0,'0000-00-00 00:00:00','mode=advanced\nskin=0\ncompressed=0\ncleanup_startup=0\ncleanup_save=2\nentity_encoding=raw\nlang_mode=0\nlang_code=en\ntext_direction=ltr\ncontent_css=1\ncontent_css_custom=\nrelative_urls=1\nnewlines=0\ninvalid_elements=applet\nextended_elements=\ntoolbar=top\ntoolbar_align=left\nhtml_height=550\nhtml_width=750\nelement_path=1\nfonts=1\npaste=1\nsearchreplace=1\ninsertdate=1\nformat_date=%Y-%m-%d\ninserttime=1\nformat_time=%H:%M:%S\ncolors=1\ntable=1\nsmilies=1\nmedia=1\nhr=1\ndirectionality=1\nfullscreen=1\nstyle=1\nlayer=1\nxhtmlxtras=1\nvisualchars=1\nnonbreaking=1\ntemplate=0\nadvimage=1\nadvlink=1\nautosave=1\ncontextmenu=1\ninlinepopups=1\nsafari=1\ncustom_plugin=\ncustom_button=\n\n'),
	(20,'Editor - XStandard Lite 2.0','xstandard','editors',0,0,0,1,0,0,'0000-00-00 00:00:00',''),
	(21,'Editor Button - Image','image','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00',''),
	(22,'Editor Button - Pagebreak','pagebreak','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00',''),
	(23,'Editor Button - Readmore','readmore','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00',''),
	(24,'XML-RPC - Joomla','joomla','xmlrpc',0,7,0,1,0,0,'0000-00-00 00:00:00',''),
	(25,'XML-RPC - Blogger API','blogger','xmlrpc',0,7,0,1,0,0,'0000-00-00 00:00:00','catid=1\nsectionid=0\n\n'),
	(27,'System - SEF','sef','system',0,1,1,0,0,62,'2010-05-20 20:39:28',''),
	(28,'System - Debug','debug','system',0,2,1,0,0,0,'0000-00-00 00:00:00','queries=1\nmemory=1\nlangauge=1\n\n'),
	(29,'System - Legacy','legacy','system',0,3,0,1,0,0,'0000-00-00 00:00:00','route=0\n\n'),
	(30,'System - Cache','cache','system',0,4,0,1,0,0,'0000-00-00 00:00:00','browsercache=0\ncachetime=15\n\n'),
	(31,'System - Log','log','system',0,5,0,1,0,0,'0000-00-00 00:00:00',''),
	(32,'System - Remember Me','remember','system',0,6,1,1,0,0,'0000-00-00 00:00:00',''),
	(33,'System - Backlink','backlink','system',0,7,0,1,0,0,'0000-00-00 00:00:00',''),
	(34,'Editor - JoomlaCK','jckeditor','editors',0,0,1,0,0,62,'2010-05-24 20:44:42','toolbar=Blog\ntoolbar_ft=Full\nuicolor=#D6E6F4\nskin=office2007\ncontent_css=1\neditor_css=0\ncontent_css_custom=\nimagePath=images\nflashPath=imagesflash\nfilePath=files\nentermode=1\nshiftentermode=1\nwwidth=100%\nhheight=480\nshowerrors=1\nlang_mode=1\nlang_code=en\nbgcolor=#FFFFFF\nreturnScript=1\n\n'),
	(35,'System - TagSef','tagSef','system',0,0,1,0,0,0,'0000-00-00 00:00:00',''),
	(36,'Search - SearchTags','searchTags','search',0,0,0,0,0,0,'0000-00-00 00:00:00',''),
	(37,'Content - Tags','tags','content',0,0,1,0,0,0,'0000-00-00 00:00:00',''),
	(38,'Editors-xtd - AddTags','addTags','editors-xtd',0,0,1,0,0,0,'0000-00-00 00:00:00','');

/*!40000 ALTER TABLE `e3gr_plugins` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_poll_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_poll_data`;

CREATE TABLE `e3gr_poll_data` (
  `id` int(11) NOT NULL auto_increment,
  `pollid` int(11) NOT NULL default '0',
  `text` text NOT NULL,
  `hits` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `pollid` (`pollid`,`text`(1))
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_poll_date
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_poll_date`;

CREATE TABLE `e3gr_poll_date` (
  `id` bigint(20) NOT NULL auto_increment,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `vote_id` int(11) NOT NULL default '0',
  `poll_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `poll_id` (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_poll_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_poll_menu`;

CREATE TABLE `e3gr_poll_menu` (
  `pollid` int(11) NOT NULL default '0',
  `menuid` int(11) NOT NULL default '0',
  PRIMARY KEY  (`pollid`,`menuid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_polls
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_polls`;

CREATE TABLE `e3gr_polls` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `voters` int(9) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL default '0',
  `access` int(11) NOT NULL default '0',
  `lag` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_sections
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_sections`;

CREATE TABLE `e3gr_sections` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `name` varchar(255) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `image` text NOT NULL,
  `scope` varchar(50) NOT NULL default '',
  `image_position` varchar(30) NOT NULL default '',
  `description` text NOT NULL,
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) unsigned NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `access` tinyint(3) unsigned NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `idx_scope` (`scope`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_sections` WRITE;
/*!40000 ALTER TABLE `e3gr_sections` DISABLE KEYS */;
INSERT INTO `e3gr_sections` (`id`,`title`,`name`,`alias`,`image`,`scope`,`image_position`,`description`,`published`,`checked_out`,`checked_out_time`,`ordering`,`access`,`count`,`params`)
VALUES
	(16,'Featured Games','','featured-games','','content','left','<p>\r\n	&nbsp;</p>\r\n<div firebugversion=\"1.5.4\" id=\"_firebugConsole\" style=\"display: none;\">\r\n	&nbsp;</div>\r\n<br />',1,0,'0000-00-00 00:00:00',1,0,1,''),
	(17,'News and Interviews','','news-and-interviews','','content','left','<p>\r\n	&nbsp;</p>\r\n<div firebugversion=\"1.5.4\" id=\"_firebugConsole\" style=\"display: none;\">\r\n	&nbsp;</div>\r\n<br />',1,0,'0000-00-00 00:00:00',2,0,2,'');

/*!40000 ALTER TABLE `e3gr_sections` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_session
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_session`;

CREATE TABLE `e3gr_session` (
  `username` varchar(150) default '',
  `time` varchar(14) default '',
  `session_id` varchar(200) NOT NULL default '0',
  `guest` tinyint(4) default '1',
  `userid` int(11) default '0',
  `usertype` varchar(50) default '',
  `gid` tinyint(3) unsigned NOT NULL default '0',
  `client_id` tinyint(3) unsigned NOT NULL default '0',
  `data` longtext,
  PRIMARY KEY  (`session_id`(64)),
  KEY `whosonline` (`guest`,`usertype`),
  KEY `userid` (`userid`),
  KEY `time` (`time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_session` WRITE;
/*!40000 ALTER TABLE `e3gr_session` DISABLE KEYS */;
INSERT INTO `e3gr_session` (`username`,`time`,`session_id`,`guest`,`userid`,`usertype`,`gid`,`client_id`,`data`)
VALUES
	('','1275527690','e25be944e75bc136975fde4c543cea4d',1,0,'',0,0,'__default|a:7:{s:22:\"session.client.browser\";s:95:\"Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; en-US; rv:1.9.2.4) Gecko/20100527 Firefox/3.6.4\";s:15:\"session.counter\";i:13;s:8:\"registry\";O:9:\"JRegistry\":3:{s:17:\"_defaultNameSpace\";s:7:\"session\";s:9:\"_registry\";a:1:{s:7:\"session\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}}s:7:\"_errors\";a:0:{}}s:4:\"user\";O:5:\"JUser\":19:{s:2:\"id\";i:0;s:4:\"name\";N;s:8:\"username\";N;s:5:\"email\";N;s:8:\"password\";N;s:14:\"password_clear\";s:0:\"\";s:8:\"usertype\";N;s:5:\"block\";N;s:9:\"sendEmail\";i:0;s:3:\"gid\";i:0;s:12:\"registerDate\";N;s:13:\"lastvisitDate\";N;s:10:\"activation\";N;s:6:\"params\";N;s:3:\"aid\";i:0;s:5:\"guest\";i:1;s:7:\"_params\";O:10:\"JParameter\":7:{s:4:\"_raw\";s:0:\"\";s:4:\"_xml\";N;s:9:\"_elements\";a:0:{}s:12:\"_elementPath\";a:1:{i:0;s:89:\"/Users/gnmedia/Sites/e3.gamerevolution.com/deploy/libraries/joomla/html/parameter/element\";}s:17:\"_defaultNameSpace\";s:8:\"_default\";s:9:\"_registry\";a:1:{s:8:\"_default\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}}s:7:\"_errors\";a:0:{}}s:9:\"_errorMsg\";N;s:7:\"_errors\";a:0:{}}s:19:\"session.timer.start\";i:1275527117;s:18:\"session.timer.last\";i:1275527683;s:17:\"session.timer.now\";i:1275527690;}'),
	('admin','1275527721','f081643cdd5c96fa7d19c28185d9b82f',0,62,'Super Administrator',25,1,'__default|a:8:{s:15:\"session.counter\";i:13;s:19:\"session.timer.start\";i:1275527621;s:18:\"session.timer.last\";i:1275527716;s:17:\"session.timer.now\";i:1275527721;s:22:\"session.client.browser\";s:95:\"Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.6; en-US; rv:1.9.2.4) Gecko/20100527 Firefox/3.6.4\";s:8:\"registry\";O:9:\"JRegistry\":3:{s:17:\"_defaultNameSpace\";s:7:\"session\";s:9:\"_registry\";a:2:{s:7:\"session\";a:1:{s:4:\"data\";O:8:\"stdClass\":0:{}}s:11:\"application\";a:1:{s:4:\"data\";O:8:\"stdClass\":1:{s:4:\"lang\";s:0:\"\";}}}s:7:\"_errors\";a:0:{}}s:4:\"user\";O:5:\"JUser\":19:{s:2:\"id\";s:2:\"62\";s:4:\"name\";s:13:\"Administrator\";s:8:\"username\";s:5:\"admin\";s:5:\"email\";s:15:\"test@willfu.com\";s:8:\"password\";s:65:\"d73470cef3579521cec5bb731eb4b73d:pZF1vuf4gRawsl9I0JazUQ9DnjyXgvo3\";s:14:\"password_clear\";s:0:\"\";s:8:\"usertype\";s:19:\"Super Administrator\";s:5:\"block\";s:1:\"0\";s:9:\"sendEmail\";s:1:\"1\";s:3:\"gid\";s:2:\"25\";s:12:\"registerDate\";s:19:\"2010-05-18 17:13:33\";s:13:\"lastvisitDate\";s:19:\"2010-06-02 23:17:18\";s:10:\"activation\";s:0:\"\";s:6:\"params\";s:70:\"admin_language=en-GB\nlanguage=\neditor=jckeditor\nhelpsite=\ntimezone=0\n\n\";s:3:\"aid\";i:2;s:5:\"guest\";i:0;s:7:\"_params\";O:10:\"JParameter\":7:{s:4:\"_raw\";s:0:\"\";s:4:\"_xml\";N;s:9:\"_elements\";a:0:{}s:12:\"_elementPath\";a:1:{i:0;s:89:\"/Users/gnmedia/Sites/e3.gamerevolution.com/deploy/libraries/joomla/html/parameter/element\";}s:17:\"_defaultNameSpace\";s:8:\"_default\";s:9:\"_registry\";a:1:{s:8:\"_default\";a:1:{s:4:\"data\";O:8:\"stdClass\":5:{s:14:\"admin_language\";s:5:\"en-GB\";s:8:\"language\";s:0:\"\";s:6:\"editor\";s:9:\"jckeditor\";s:8:\"helpsite\";s:0:\"\";s:8:\"timezone\";s:1:\"0\";}}}s:7:\"_errors\";a:0:{}}s:9:\"_errorMsg\";N;s:7:\"_errors\";a:0:{}}s:13:\"session.token\";s:32:\"0b98808fe7bb4f849f937172783dddbc\";}');

/*!40000 ALTER TABLE `e3gr_session` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_stats_agents
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_stats_agents`;

CREATE TABLE `e3gr_stats_agents` (
  `agent` varchar(255) NOT NULL default '',
  `type` tinyint(1) unsigned NOT NULL default '0',
  `hits` int(11) unsigned NOT NULL default '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table e3gr_tag_term
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_tag_term`;

CREATE TABLE `e3gr_tag_term` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `description` text,
  `weight` tinyint(4) NOT NULL default '0',
  `hits` int(10) NOT NULL default '0',
  `created` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`),
  KEY `id_tag` (`id`,`name`),
  KEY `id_hits` (`id`,`hits`),
  KEY `term_hits` (`hits`),
  KEY `term_created` (`created`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;



# Dump of table e3gr_tag_term_content
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_tag_term_content`;

CREATE TABLE `e3gr_tag_term_content` (
  `tid` int(10) unsigned NOT NULL default '0',
  `cid` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`tid`,`cid`),
  KEY `cid` (`cid`),
  KEY `tid` (`tid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_tag_term_content` WRITE;
/*!40000 ALTER TABLE `e3gr_tag_term_content` DISABLE KEYS */;
INSERT INTO `e3gr_tag_term_content` (`tid`,`cid`)
VALUES
	(18,24),
	(18,26),
	(25,25);

/*!40000 ALTER TABLE `e3gr_tag_term_content` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_templates_menu
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_templates_menu`;

CREATE TABLE `e3gr_templates_menu` (
  `template` varchar(255) NOT NULL default '',
  `menuid` int(11) NOT NULL default '0',
  `client_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`menuid`,`client_id`,`template`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_templates_menu` WRITE;
/*!40000 ALTER TABLE `e3gr_templates_menu` DISABLE KEYS */;
INSERT INTO `e3gr_templates_menu` (`template`,`menuid`,`client_id`)
VALUES
	('e3_gr',0,0),
	('khepri',0,1);

/*!40000 ALTER TABLE `e3gr_templates_menu` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_users`;

CREATE TABLE `e3gr_users` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `username` varchar(150) NOT NULL default '',
  `email` varchar(100) NOT NULL default '',
  `password` varchar(100) NOT NULL default '',
  `usertype` varchar(25) NOT NULL default '',
  `block` tinyint(4) NOT NULL default '0',
  `sendEmail` tinyint(4) default '0',
  `gid` tinyint(3) unsigned NOT NULL default '1',
  `registerDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `lastvisitDate` datetime NOT NULL default '0000-00-00 00:00:00',
  `activation` varchar(100) NOT NULL default '',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `usertype` (`usertype`),
  KEY `idx_name` (`name`),
  KEY `gid_block` (`gid`,`block`),
  KEY `username` (`username`),
  KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;

LOCK TABLES `e3gr_users` WRITE;
/*!40000 ALTER TABLE `e3gr_users` DISABLE KEYS */;
INSERT INTO `e3gr_users` (`id`,`name`,`username`,`email`,`password`,`usertype`,`block`,`sendEmail`,`gid`,`registerDate`,`lastvisitDate`,`activation`,`params`)
VALUES
	(62,'Administrator','admin','test@willfu.com','d73470cef3579521cec5bb731eb4b73d:pZF1vuf4gRawsl9I0JazUQ9DnjyXgvo3','Super Administrator',0,1,25,'2010-05-18 17:13:33','2010-06-03 01:13:44','','admin_language=en-GB\nlanguage=\neditor=jckeditor\nhelpsite=\ntimezone=0\n\n'),
	(63,'Editor','editor','test@test.com','8b1a123fc6f9ba8d8733e675f0a95077:O5PErB9lNXLxURzNhApVd8SVbni8TCwS','Manager',0,0,23,'2010-05-21 20:58:19','2010-05-25 00:08:02','','admin_language=\nlanguage=\neditor=jckeditor\nhelpsite=\ntimezone=-8\n\n'),
	(64,'Ahmad Childress','ahmad.childress','ahmad.childress@craveonline.com','38dbc5fe39c882e93cdfa9ae2f78ab31:TbVsGPaWbPNR1pkfSj5QFcAG1IHsrTzu','Administrator',1,0,24,'2010-05-24 23:59:27','0000-00-00 00:00:00','','admin_language=\nlanguage=\neditor=jckeditor\nhelpsite=\ntimezone=-8\n\n'),
	(65,'Johnny Firecloud','johnny.firecloud','johnnyfirecloud@hotmail.com','a1b930b4adce741016e3f463f6f8ee4c:gFSA9w0UUYbjkqQJy90rjhmQwLyGJO5e','Administrator',1,0,24,'2010-05-25 00:00:36','0000-00-00 00:00:00','','admin_language=\nlanguage=\neditor=jckeditor\nhelpsite=\ntimezone=-8\n\n'),
	(66,'Paul Hanges','paul.hanges','paul@gamerevolution.com','7572f8d311e6bfbe921e85fb57ec5621:DoLLobHCBhDpnIPOevS2jwfrbWrJR7sQ','Manager',0,0,23,'2010-06-02 18:10:45','0000-00-00 00:00:00','','admin_language=en-GB\nlanguage=en-GB\neditor=jckeditor\nhelpsite=\ntimezone=-8\n\n');

/*!40000 ALTER TABLE `e3gr_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table e3gr_weblinks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `e3gr_weblinks`;

CREATE TABLE `e3gr_weblinks` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `catid` int(11) NOT NULL default '0',
  `sid` int(11) NOT NULL default '0',
  `title` varchar(250) NOT NULL default '',
  `alias` varchar(255) NOT NULL default '',
  `url` varchar(250) NOT NULL default '',
  `description` text NOT NULL,
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `hits` int(11) NOT NULL default '0',
  `published` tinyint(1) NOT NULL default '0',
  `checked_out` int(11) NOT NULL default '0',
  `checked_out_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL default '0',
  `archived` tinyint(1) NOT NULL default '0',
  `approved` tinyint(1) NOT NULL default '1',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `catid` (`catid`,`published`,`archived`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;






/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
