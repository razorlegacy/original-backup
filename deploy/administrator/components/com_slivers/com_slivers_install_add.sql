ALTER TABLE  `jos_slivers` ADD  `abdisappear` BOOLEAN NOT NULL;

CREATE TABLE `websvc_slivers_buttons` (
 `id` MEDIUMINT UNSIGNED NOT NULL AUTO_INCREMENT,
 `sliver_id` MEDIUMINT UNSIGNED NOT NULL,
 `width` SMALLINT UNSIGNED NOT NULL,
 `height` SMALLINT UNSIGNED NOT NULL,
 `x_offset` MEDIUMINT NOT NULL DEFAULT 0,
 `y_offset` MEDIUMINT NOT NULL DEFAULT 0,
 `tracking_name` VARCHAR(255) NOT NULL,
 `area` VARCHAR(63) NOT NULL DEFAULT 'sliver',
 `action` VARCHAR(63) NOT NULL DEFAULT 'link',
 `on` VARCHAR(63) NOT NULL DEFAULT 'click',
 `url` VARCHAR(1023) NOT NULL,
 `name` VARCHAR(63) NOT NULL,
 PRIMARY KEY (`id`),
 KEY `sliver_id` (`sliver_id`),
 CONSTRAINT `websvc_slivers_buttons_ibfk_1` FOREIGN KEY (`sliver_id`) REFERENCES `jos_slivers` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8

ALTER TABLE  `websvc_slivers_videos` ADD  `starts` DATE NOT NULL;
ALTER TABLE  `websvc_slivers_videos` ADD INDEX (  `starts` );

ALTER TABLE `websvc_slivers` DROP COLUMN `trigger_type`, DROP COLUMN `trigger_width`, DROP COLUMN `trigger_x_offset`, DROP COLUMN `button_url`, DROP COLUMN `button_height`, DROP COLUMN `button_width`, DROP COLUMN `button_x_offset`, DROP COLUMN `button_y_offset`, DROP COLUMN `button_tracking_name`;

ALTER TABLE `websvc_slivers_videos` DROP COLUMN `controls_uri`, DROP COLUMN `source_uri`, DROP COLUMN `thumbnail_uri`;
ALTER TABLE  `websvc_slivers_videos` ADD  `embed_code` TEXT NOT NULL;
ALTER TABLE  `websvc_slivers_videos` ADD  `order` TINYINT(3) UNSIGNED NOT NULL;
ALTER TABLE  `websvc_slivers_videos` ADD INDEX (  `order` );
ALTER TABLE  `websvc_slivers` ADD  `ab_open_animation` VARCHAR(63) NOT NULL;
ALTER TABLE  `websvc_slivers` ADD  `ab_close_animation` VARCHAR(63) NOT NULL;
ALTER TABLE  `websvc_slivers` ADD  `sliv_open_animation` VARCHAR(63) NOT NULL;
ALTER TABLE  `websvc_slivers` ADD  `sliv_close_animation` VARCHAR(63) NOT NULL;
ALTER TABLE  `websvc_slivers` ADD  `sliv_open_duration` SMALLINT(5) UNSIGNED NOT NULL;
ALTER TABLE  `websvc_slivers` ADD  `sliv_close_duration` SMALLINT(5) UNSIGNED NOT NULL;
ALTER TABLE  `websvc_slivers` ADD  `ab_open_duration` SMALLINT(5) UNSIGNED NOT NULL;
ALTER TABLE  `websvc_slivers` ADD  `ab_close_duration` SMALLINT(5) UNSIGNED NOT NULL;
ALTER TABLE  `websvc_slivers` ADD  `animation_resolution` SMALLINT(5) UNSIGNED NOT NULL;
