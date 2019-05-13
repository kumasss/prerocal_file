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
-- テーブルの構造 `tp_contents`
--

CREATE TABLE IF NOT EXISTS `tp_contents` (
`id` int(11) NOT NULL,
  `description` varchar(400) DEFAULT NULL,
  `keyword` varchar(400) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `position_c` int(11) NOT NULL,
  `contents` text,
  `eye_image_id` int(11) DEFAULT NULL,
  `add_br` int(11) DEFAULT '1',
  `url` varchar(200) DEFAULT NULL,
  `public_date` int(11) DEFAULT NULL,
  `no_public_date` int(11) DEFAULT NULL,
  `public` int(11) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `group_id` varchar(1000) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `tp_contents`
--

INSERT INTO `tp_contents` (`id`, `description`, `keyword`, `title`, `position_c`, `contents`, `eye_image_id`, `add_br`, `url`, `public_date`, `no_public_date`, `public`, `password`, `group_id`, `created`, `modified`) VALUES
(49, '', '', 'こまごめ３', 49, 'こまごめ３', 0, 0, 'post-20150223132145', 0, 0, 1, '', '1', '2015-02-23 13:21:45', '2015-02-23 13:22:50'),
(48, '', '', 'こまごめ２', 48, 'こまごめ２', 0, 0, 'post-20150223132133', 0, 0, 1, '', '1', '2015-02-23 13:21:33', '2015-02-23 13:22:50'),
(47, '', '', 'こまごめ１', 47, 'こまごめ１', 0, 0, 'post-20150223132118', 0, 0, 1, '', '1', '2015-02-23 13:21:18', '2015-02-23 13:22:50'),
(43, '', '', 'すがも１', 1, 'すがも１', 0, 0, 'post-20150223131921', 0, 0, 1, '', '1', '2015-02-23 13:19:21', NULL),
(44, '', '', 'すがも２', 44, 'すがも２', 0, 0, 'post-20150223131946', 0, 0, 1, '', '1', '2015-02-23 13:19:46', NULL),
(45, '', '', 'すがも３', 45, 'すがも３', 0, 0, 'post-20150223132047', 0, 0, 1, '', '1', '2015-02-23 13:20:47', NULL),
(46, '', '', 'すがも４', 46, 'すがも４', NULL, 0, 'post-20150223132103', 0, 0, 1, '', '1', '2015-02-23 13:21:03', '2015-02-23 13:23:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tp_contents`
--
ALTER TABLE `tp_contents`
 ADD PRIMARY KEY (`id`), ADD KEY `eye_image_id` (`eye_image_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tp_contents`
--
ALTER TABLE `tp_contents`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
