-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成時間: 2014 年 6 月 23 日 00:26
-- サーバのバージョン: 5.5.8
-- PHP のバージョン: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `test`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `su_click_log`
--

CREATE TABLE IF NOT EXISTS `su_click_log` (

	`id` int(11) NOT NULL AUTO_INCREMENT,
	`short_code` varchar(12) BINARY CHARACTER SET utf8 NOT NULL,
	`short_url` varchar(2000) CHARACTER SET utf8 NOT NULL,
	`referrer` varchar(2000) CHARACTER SET utf8 DEFAULT NULL,
	`user_agent` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
	`ip_address` varchar(41) CHARACTER SET utf8 DEFAULT NULL,
	`datetime` datetime NOT NULL,
	PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- テーブルのデータをダンプしています `click_log`
--

