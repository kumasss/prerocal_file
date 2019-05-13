/*!40101 SET NAMES binary*/;
/*!40014 SET FOREIGN_KEY_CHECKS=0*/;

CREATE TABLE `wp_ewwwio_images` (
  `id` int(14) unsigned NOT NULL AUTO_INCREMENT,
  `attachment_id` bigint(20) unsigned DEFAULT NULL,
  `gallery` varchar(10) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `resize` varchar(75) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `path` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `converted` text COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `results` varchar(75) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `image_size` int(10) unsigned DEFAULT NULL,
  `orig_size` int(10) unsigned DEFAULT NULL,
  `backup` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `level` int(5) unsigned DEFAULT NULL,
  `pending` tinyint(1) NOT NULL DEFAULT '0',
  `updates` int(5) unsigned DEFAULT NULL,
  `updated` timestamp NOT NULL DEFAULT '1970-12-31 15:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `trace` blob,
  UNIQUE KEY `id` (`id`),
  KEY `path_image_size` (`path`(191),`image_size`),
  KEY `attachment_info` (`gallery`(3),`attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1383 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;
