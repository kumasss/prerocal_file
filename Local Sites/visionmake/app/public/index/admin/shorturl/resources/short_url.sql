-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- ホスト: 127.0.0.1
-- 生成日時: 2014 年 7 月 07 日 17:03
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
-- テーブルの構造 `su_short_url`
--

CREATE TABLE IF NOT EXISTS `su_short_url` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `short_code` varchar(12) BINARY NOT NULL,
  `short_url` varchar(2000) NOT NULL,
  `long_url` varchar(2000) NOT NULL,
  `title` varchar(200) NOT NULL,
  `group_code` int(11) DEFAULT NULL,
  `created` datetime NOT NULL,
  `end_url` varchar(2000) DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `short_code` (`short_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

--
-- テーブルのデータのダンプ `su_short_url`
--


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
