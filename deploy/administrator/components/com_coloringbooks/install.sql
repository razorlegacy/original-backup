CREATE TABLE `#__coloringBooks` (
 `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(127) NOT NULL,
 `owner` int(10) unsigned NOT NULL,
 `swf_uri` varchar(255) NOT NULL,
 `embed_width` smallint(5) unsigned NOT NULL,
 `embed_height` smallint(6) unsigned NOT NULL,
 `email_enabled` tinyint(4) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `owner` (`owner`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE `jos_pages` (
 `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
 `book_id` smallint(5) unsigned NOT NULL,
 `order` int(8) unsigned DEFAULT NULL,
 `uri` varchar(255) NOT NULL,
 `uri_thumb` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `collection_id` (`book_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8
