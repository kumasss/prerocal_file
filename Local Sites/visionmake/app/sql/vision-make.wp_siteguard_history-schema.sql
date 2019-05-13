/*!40101 SET NAMES binary*/;
/*!40014 SET FOREIGN_KEY_CHECKS=0*/;

CREATE TABLE `wp_siteguard_history` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `login_name` varchar(40) NOT NULL DEFAULT '',
  `ip_address` varchar(40) NOT NULL DEFAULT '',
  `operation` int(11) NOT NULL DEFAULT '0',
  `time` datetime DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
