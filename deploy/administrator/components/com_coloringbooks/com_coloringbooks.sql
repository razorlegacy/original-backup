CREATE TABLE `websvc_com_coloringbooks` (
 `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(127) NOT NULL,
 `owner` int(10) unsigned NOT NULL,
 `embed_width` smallint(5) unsigned NOT NULL,
 `embed_height` smallint(6) unsigned NOT NULL,
 `email_enabled` tinyint(4) NOT NULL,
 `swf_uri` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `owner` (`owner`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='holds coloring book component''s coloring books';

CREATE TABLE `jos_com_coloringbooks_pages` (
 `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 `book_id` smallint(5) unsigned NOT NULL,
 `order` int(8) unsigned DEFAULT NULL,
 `uri` varchar(255) NOT NULL,
 `uri_thumb` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `book_id` (`book_id`),
 CONSTRAINT `jos_com_coloringbooks_pages_ibfk_1` FOREIGN KEY (`book_id`) REFERENCES `jos_com_coloringbooks` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Holds coloring book component''s path to drawings'

INSERT INTO `websvc_components` (`name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES
('Coloring Books', 'option=com_coloringbooks', 0, 0, 'option=com_coloringbooks', '', 'com_coloringbooks', 0, '', 0, '', 1);
