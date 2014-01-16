CREATE TABLE IF NOT EXISTS `#__bw_static_cacher_links` (
	`id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	`request_uri` varchar(255) NOT NULL,
	`deep` int(10) unsigned NOT NULL,
	`cached` tinyint(1) unsigned NOT NULL,
	`skipped` tinyint(2) unsigned NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE (`request_uri`)
) DEFAULT CHARACTER SET utf8;