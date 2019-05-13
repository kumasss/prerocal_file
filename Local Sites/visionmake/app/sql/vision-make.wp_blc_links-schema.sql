/*!40101 SET NAMES binary*/;
/*!40014 SET FOREIGN_KEY_CHECKS=0*/;

CREATE TABLE `wp_blc_links` (
  `link_id` int(20) unsigned NOT NULL AUTO_INCREMENT,
  `url` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `first_failure` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_check` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_success` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_check_attempt` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `check_count` int(4) unsigned NOT NULL DEFAULT '0',
  `final_url` text CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL,
  `redirect_count` smallint(5) unsigned NOT NULL DEFAULT '0',
  `log` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `http_code` smallint(6) NOT NULL DEFAULT '0',
  `status_code` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT '',
  `status_text` varchar(250) COLLATE utf8mb4_unicode_520_ci DEFAULT '',
  `request_duration` float NOT NULL DEFAULT '0',
  `timeout` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `broken` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `warning` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `may_recheck` tinyint(1) NOT NULL DEFAULT '1',
  `being_checked` tinyint(1) NOT NULL DEFAULT '0',
  `result_hash` varchar(200) COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT '',
  `false_positive` tinyint(1) NOT NULL DEFAULT '0',
  `dismissed` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`link_id`),
  KEY `url` (`url`(150)),
  KEY `final_url` (`final_url`(150)),
  KEY `http_code` (`http_code`),
  KEY `broken` (`broken`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
