CREATE TABLE `websvc_slivers` (
 `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `owner_id` int(11) NOT NULL,
 `tweenBG` tinyint(1) NOT NULL DEFAULT '0',
 `trigger_type` varchar(127) NOT NULL DEFAULT 'rollover',
 `trigger_width` smallint(5) unsigned NOT NULL,
 `trigger_x_offset` mediumint(9) NOT NULL DEFAULT '0',
 `sliver_height` smallint(5) unsigned NOT NULL DEFAULT '250',
 `sliver_color` varchar(127) NOT NULL,
 `sliver_preloadColor` varchar(127) NOT NULL,
 `autoOpen` tinyint(1) NOT NULL DEFAULT '0',
 `actionbar_height` smallint(5) unsigned NOT NULL DEFAULT '50',
 `actionbar_color` varchar(127) NOT NULL,
 `swf` varchar(255) NOT NULL,
 `button_uri` varchar(1023) NOT NULL,
 `button_height` smallint(5) unsigned NOT NULL,
 `button_width` smallint(5) unsigned NOT NULL,
 `button_x_offset` mediumint(9) NOT NULL,
 `button_y_offset` mediumint(9) NOT NULL,
 `button_tracking_name` varchar(255) NOT NULL,
 `prefix` varchar(255) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8

CREATE TABLE `websvc_slivers_scheduledImages` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `starts` date NOT NULL,
 `actionbar_uri` varchar(1023) NOT NULL,
 `actionbar_is_upload` tinyint(1) NOT NULL DEFAULT '0',
 `flash_uri` varchar(1023) NOT NULL,
 `flash_is_upload` tinyint(1) NOT NULL DEFAULT '0',
 `flash_width` smallint(5) unsigned NOT NULL,
 `flash_height` smallint(5) unsigned NOT NULL,
 `sliver_id` mediumint(8) unsigned NOT NULL,
 PRIMARY KEY (`id`),
 KEY `sliver_id` (`sliver_id`),
 KEY `starts` (`starts`),
 CONSTRAINT `websvc_slivers_scheduledImages_ibfk_1` FOREIGN KEY (`sliver_id`) REFERENCES `websvc_slivers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8

CREATE TABLE `websvc_slivers_videos` (
 `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `name` varchar(255) NOT NULL,
 `height` smallint(5) unsigned NOT NULL,
 `width` smallint(5) unsigned NOT NULL,
 `autoPlay` tinyint(1) NOT NULL DEFAULT '1',
 `autoPlayOn` varchar(31) NOT NULL DEFAULT 'init',
 `startMuted` tinyint(1) NOT NULL DEFAULT '1',
 `unmuteOnRollover` tinyint(1) NOT NULL DEFAULT '1',
 `volume` tinyint(3) unsigned NOT NULL DEFAULT '40',
 `controls_uri` varchar(1023) NOT NULL,
 `posX` mediumint(9) NOT NULL,
 `posY` mediumint(9) NOT NULL,
 `source_uri` varchar(1023) NOT NULL,
 `thumbnail_uri` varchar(1023) NOT NULL,
 `sliver_id` mediumint(8) unsigned NOT NULL,
 PRIMARY KEY (`id`),
 KEY `sliver_id` (`sliver_id`),
 CONSTRAINT `websvc_slivers_videos_ibfk_1` FOREIGN KEY (`sliver_id`) REFERENCES `websvc_slivers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8

INSERT INTO `websvc_components` (`id`, `name`, `link`, `menuid`, `parent`, `admin_menu_link`, `admin_menu_alt`, `option`, `ordering`, `admin_menu_img`, `iscore`, `params`, `enabled`) VALUES
(39, 'Slivers', 'option=com_slivers', 0, 0, 'option=com_slivers', '', 'com_slivers', 0, '', 0, '', 1);
