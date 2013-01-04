--
-- phpMyAdmin SQL Dump
-- version 2.11.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 08, 2011 at 12:31 PM
-- Server version: 5.0.67
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
--
-- Database: `joomla`
--

-- ------------------------------------------ --------------


INSERT INTO `websvc_components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`)
VALUES
	('Syndi', 'option=com_syndi', 0, 0, 'option=com_syndi', '', 'com_syndi', 2, 'js/ThemeOffice/component.png', 0, '', 1);




--
-- Table structure for table `websvc_syndi`
--
DROP TABLE IF EXISTS `websvc_syndi`;
CREATE TABLE `websvc_syndi` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `syndi_name` varchar(100) NOT NULL,
  `syndi_bg` varchar(255) DEFAULT NULL,
  `config` longblob,
  `manager` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `websvc_syndi_article`
--
DROP TABLE IF EXISTS `websvc_syndi_article`;
CREATE TABLE `websvc_syndi_article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `articleURL` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` varchar(100) NOT NULL,
  `alias` varchar(100) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` mediumtext,
  `tab_id` int(11) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `websvc_syndi_qa`
--
DROP TABLE IF EXISTS `websvc_syndi_qa`;
CREATE TABLE IF NOT EXISTS `websvc_syndi_qa` (
  `qa_id` int(11) NOT NULL auto_increment,
  `email` varchar(100) NOT NULL,
  `title` varchar(255) default NULL,
  `description` mediumtext,
  `tab_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ordering` int(11) default NULL,
  PRIMARY KEY  (`qa_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `websvc_syndi_video`
--
CREATE TABLE `websvc_syndi_video` (
  `video_id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `pid` varchar(50) DEFAULT NULL,
  `siteId` varchar(50) NOT NULL DEFAULT '',
  `videoId` varchar(50) NOT NULL DEFAULT '',
  `tab_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ordering` int(11) DEFAULT NULL,
  `sbFeed` longblob,
  PRIMARY KEY (`video_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Table structure for table `websvc_syndi_image`
--
DROP TABLE IF EXISTS `websvc_syndi_image`;
CREATE TABLE IF NOT EXISTS `websvc_syndi_image` (
  `image_id` int(11) NOT NULL auto_increment,
  `image` varchar(255) NOT NULL,
  `clickURL` varchar(255) NOT NULL,
  `tab_id` int(11) NOT NULL,
  `ordering` int(11) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY  (`image_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;


--
-- Table structure for table `websvc_syndi_tabs`
--
DROP TABLE IF EXISTS `websvc_syndi_tabs`;
CREATE TABLE `websvc_syndi_tabs` (
  `tab_id` int(11) NOT NULL AUTO_INCREMENT,
  `sid` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `typetab` varchar(255) NOT NULL,
  `tab_bg` varchar(255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tab_order` int(11) NOT NULL,
  PRIMARY KEY (`tab_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


--
-- Table structure for table `websvc_syndi_facebook`
--
DROP TABLE IF EXISTS `websvc_syndi_facebook`;
CREATE TABLE IF NOT EXISTS `websvc_syndi_facebook` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `websvc_syndi_poll`
--
DROP TABLE IF EXISTS `websvc_syndi_poll`;
CREATE TABLE IF NOT EXISTS `websvc_syndi_poll` (
  `poll_id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `polldaddy_feed` longblob,
  `polldaddy_key` int(11) NOT NULL,
  `tab_id` int(11) NOT NULL,
  `ordering` int(11) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Table structure for table `websvc_syndi_rss`
--
DROP TABLE IF EXISTS `websvc_syndi_rss`;
CREATE TABLE IF NOT EXISTS `websvc_syndi_rss` (
  `rss_id` int(11) NOT NULL auto_increment,
  `feed_url` varchar(255) default NULL,
  `articles_number` int(11) NOT NULL,
  `tab_id` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`rss_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- Table structure for table `websvc_syndi_twitter`
--
DROP TABLE IF EXISTS `websvc_syndi_twitter`;
CREATE TABLE IF NOT EXISTS `websvc_syndi_twitter` (
  `twitter_id` int(11) NOT NULL auto_increment,
  `twitter_config` longblob NOT NULL,
  `tab_id` int(11) NOT NULL,
  `ordering` int(11) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`twitter_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;