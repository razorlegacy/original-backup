# Need to create /assets/components/com_giftguides with full permissions


INSERT INTO `websvc_components` (`name`,`link`,`menuid`,`parent`,`admin_menu_link`,`admin_menu_alt`,`option`,`ordering`,`admin_menu_img`,`iscore`,`params`,`enabled`)
VALUES
	('Gift Guides', 'option=com_giftguides', 0, 0, 'option=com_giftguides', 'Gift Guides', 'com_giftguides', 0, 'js/ThemeOffice/component.png', 0, '', 1);



# Sequel Pro dump
# Version 2492
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.1.52)
# Database: joomla_multisite
# Generation Time: 2011-01-11 11:09:50 -0800
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table websvc_giftguides
# ------------------------------------------------------------

DROP TABLE IF EXISTS `websvc_giftguides`;

CREATE TABLE `websvc_giftguides` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `giftguide_name` varchar(255) DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `facebook_icon` varchar(255) DEFAULT NULL,
  `facebook_title` varchar(255) DEFAULT NULL,
  `facebook_description` text,
  `email_header` varchar(255) DEFAULT NULL,
  `email_title` varchar(255) DEFAULT NULL,
  `email_description` text,
  `twitter_description` varchar(255) DEFAULT NULL,
  `super_banner` varchar(255) DEFAULT NULL,
  `super_banner_static` varchar(255) DEFAULT NULL,
  `js_fadeIn` int(11) DEFAULT NULL,
  `js_fadeOut` int(11) DEFAULT NULL,
  `js_modal_template` varchar(50) DEFAULT NULL,
  `js_modal_width` varchar(50) DEFAULT NULL,
  `js_modal_height` varchar(50) DEFAULT NULL,
  `published` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;



# Dump of table websvc_giftguides_category
# ------------------------------------------------------------

DROP TABLE IF EXISTS `websvc_giftguides_category`;

CREATE TABLE `websvc_giftguides_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `category_name` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `featured` int(11) DEFAULT NULL,
  `tracking_pixel` varchar(255) DEFAULT NULL,
  `category_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=146 DEFAULT CHARSET=latin1;



# Dump of table websvc_giftguides_product
# ------------------------------------------------------------

DROP TABLE IF EXISTS `websvc_giftguides_product`;

CREATE TABLE `websvc_giftguides_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gid` int(11) DEFAULT NULL,
  `cid` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `description` text,
  `price` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `img_large` varchar(255) DEFAULT NULL,
  `product_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=latin1;






/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
