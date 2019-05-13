-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- ホスト: 127.0.0.1
-- 生成日時: 2014 年 8 月 05 日 18:43
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
-- テーブルの構造 `su_category`
--

CREATE TABLE IF NOT EXISTS `su_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `row` int(11) NOT NULL DEFAULT '0',
  `name` varchar(10) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- テーブルのデータのダンプ `su_category`
--

INSERT INTO `su_category` (`id`, `row`, `name`, `description`, `created`, `updated`) VALUES
(1, 0, 'カテゴリなし', NULL, '0000-00-00 00:00:00', NULL);


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
