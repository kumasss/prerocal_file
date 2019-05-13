-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- ホスト: 127.0.0.1
-- 生成日時: 2014 年 7 月 07 日 17:02
-- サーバのバージョン: 5.5.32-log
-- PHP のバージョン: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `test`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `su_api_access_log`
--

CREATE TABLE IF NOT EXISTS `su_api_access_log` (
  `mode` varchar(20) NOT NULL,
  `shortcode` varchar(12) BINARY NOT NULL,
  `traffic` int(11) DEFAULT '0',
  `mail_mode` varchar(20) DEFAULT NULL,
  `mail_id` int(11) DEFAULT '0',
  `datetime` datetime NOT NULL,
  KEY `shortcode` (`shortcode`),
  KEY `datetime` (`datetime`),
  KEY `mode` (`mode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
