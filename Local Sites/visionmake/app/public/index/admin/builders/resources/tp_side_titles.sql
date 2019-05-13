-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2015 年 2 朁E23 日 14:15
-- サーバのバージョン： 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `members11`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `tp_side_titles`
--

CREATE TABLE IF NOT EXISTS `tp_side_titles` (
`id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `position_m` int(11) NOT NULL,
  `public` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tp_side_titles`
--

INSERT INTO `tp_side_titles` (`id`, `title`, `position_m`, `public`, `created`, `modified`) VALUES
(36, '大塚', 36, 1, '2015-02-23 13:23:45', NULL),
(35, '駒込', 1, 1, '2015-02-23 13:21:18', '2015-02-23 13:22:05'),
(34, '巣鴨', 35, 1, '2015-02-23 13:19:21', '2015-02-23 13:22:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tp_side_titles`
--
ALTER TABLE `tp_side_titles`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tp_side_titles`
--
ALTER TABLE `tp_side_titles`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=37;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
