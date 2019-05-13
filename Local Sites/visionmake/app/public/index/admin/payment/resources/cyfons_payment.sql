-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- ホスト: 127.0.0.1
-- 生成日時: 2014 年 8 月 04 日 16:50
-- サーバのバージョン: 5.5.32-log
-- PHP のバージョン: 5.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

-- --------------------------------------------------------

--
-- テーブルの構造 `pm_contract`
--

CREATE TABLE IF NOT EXISTS `pm_contract` (
`id` int(11) NOT NULL AUTO_INCREMENT,
`product_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
`status` varchar(20) DEFAULT NULL,
`user_id` int(11) DEFAULT NULL,
`bank_txn_id` varchar(20) DEFAULT NULL,
`txn_id` varchar(20) DEFAULT NULL,
`txn_type` varchar(20) DEFAULT NULL,
`payment_type` varchar(20) DEFAULT NULL,
`order_time` datetime NOT NULL,
`amt` varchar(20) DEFAULT NULL,
`fee_amt` varchar(20) DEFAULT NULL,
`tax_amt` varchar(20) DEFAULT NULL,
`currency_code` varchar(20) DEFAULT NULL,
`pending_reason` varchar(20) DEFAULT NULL,
`reason_code` varchar(20) DEFAULT NULL,
`error_code` varchar(20) DEFAULT NULL,
`mail_transfer` varchar(30) DEFAULT NULL,
`mail_complete` varchar(30) DEFAULT NULL,
`mail_refund` varchar(30) DEFAULT NULL,
`created` datetime NOT NULL,
`updated` datetime DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- テーブルの構造 `pm_payment_bank`
--

CREATE TABLE IF NOT EXISTS `pm_payment_bank` (
`bank_txn_id` varchar(20) NOT NULL,
`bank_buyer_name` varchar(40) DEFAULT NULL,
`bank_buyer_email` varchar(200) DEFAULT NULL,
`bank_buyer_transfer_date` DATETIME NULL,
`bank_account_name` varchar(40) DEFAULT NULL,
`bank_payment_amount` int(11) DEFAULT NULL,
`bank_payment_status` varchar(20) DEFAULT NULL,
`created` datetime DEFAULT NULL,
`updated` datetime DEFAULT NULL,
PRIMARY KEY (`bank_txn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `pm_payment_paypal`
--

CREATE TABLE IF NOT EXISTS `pm_payment_paypal` (
  `payer_id` varchar(20) DEFAULT NULL,
  `tax` int(11) DEFAULT  '0',
  `payment_date` datetime DEFAULT NULL,
  `payment_status` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `mc_fee` int(11) DEFAULT '0',
  `notify_version` varchar(10) DEFAULT NULL,
  `payer_status` varchar(20) DEFAULT NULL,
  `num_cart_items` int(11) DEFAULT '0',
  `payer_email` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `txn_id` varchar(20) NOT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `receiver_email` varchar(200) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `payment_fee` int(11) DEFAULT '0',
  `receiver_id` varchar(20) DEFAULT NULL,
  `txn_type` varchar(20) DEFAULT NULL,
  `mc_gross` int(11) DEFAULT '0',
  `mc_currency` varchar(10) DEFAULT NULL,
  `test_ipn` int(1) DEFAULT NULL,
  `transaction_subject` varchar(200) DEFAULT NULL,
  `payment_gross` int(11) DEFAULT '0',
  `ipn_track_id` varchar(20) DEFAULT NULL,
  `log` text,
  `created` datetime DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
PRIMARY KEY (`txn_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `pm_product`
--

CREATE TABLE IF NOT EXISTS `pm_product` (
  `id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `unit_id` varchar(16) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `price` int(11) NOT NULL DEFAULT '0',
  `bank_flag` int(11) NOT NULL DEFAULT '0',
  `bank_tr_deadline` smallint(6) DEFAULT '7',
  `bank_app_mail_title` varchar(100) DEFAULT NULL,
  `bank_app_mail_body` varchar(6000) DEFAULT NULL,
  `sales_option` tinyint(4) NOT NULL DEFAULT '0',
  `image_flag` int(11) DEFAULT '0',
  `group_info` varchar(100) DEFAULT NULL,
  `mail_title` varchar(100) DEFAULT NULL,
  `mail_body` varchar(6000) DEFAULT NULL,
  `after_url` varchar(1000) DEFAULT NULL,
  `register_url` varchar(1000) DEFAULT NULL,
  `version` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pm_product_IX1` (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- テーブルの構造 `pm_seller_setting`
--

CREATE TABLE IF NOT EXISTS `pm_seller_setting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_req_title` varchar(100) DEFAULT NULL,
  `bank_req_body` varchar(6000) DEFAULT NULL,
  `sender_name` varchar(200) DEFAULT NULL,
  `sender_email` varchar(200) DEFAULT NULL,
  `mail_title` varchar(100) NOT NULL,
  `mail_body` varchar(6000) NOT NULL,
  `payback_mail_title` varchar(100) NOT NULL,
  `payback_mail_body` varchar(6000) NOT NULL,
  `bank_name` varchar(40) NOT NULL,
  `bank_branch_name` varchar(40) NOT NULL,
  `bank_type` int(11) DEFAULT '0',
  `bank_account_number` varchar(40) NOT NULL,
  `bank_account` varchar(40) NOT NULL,
  `api_username` varchar(200) DEFAULT NULL,
  `api_password` varchar(20) DEFAULT NULL,
  `api_signature` varchar(80) DEFAULT NULL,
  `api_sandbox_mode` tinyint(1) DEFAULT '1',
  `api_sand_username` varchar(200) DEFAULT NULL,
  `api_sand_password` varchar(20) DEFAULT NULL,
  `api_sand_signature` varchar(80) DEFAULT NULL,
  `created` datetime NOT NULL,
  `updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- テーブルのデータをダンプしています `pm_seller_setting`
--

INSERT INTO `pm_seller_setting` (`id`, `bank_req_title`, `bank_req_body`, `sender_name`, `sender_email`, `mail_title`, `mail_body`, `payback_mail_title`, `payback_mail_body`, `bank_name`, `bank_branch_name`, `bank_type`, `bank_account_number`, `bank_account`, `api_username`, `api_password`, `api_signature`, `api_sandbox_mode`, `api_sand_username`, `api_sand_password`, `api_sand_signature`, `created`, `updated`) VALUES
(1, '「%title%」銀行振込お申込みの確認', '%bank_account_name%様\r\n\r\n\r\nこのたびは、「%title%」をお申し込み頂き、\r\n誠にありがとうございます。\r\n\r\nこのメールには\r\nお申し込み内容とお振込先口座番号が明記されておりますので、\r\n大切に保管していただきますようお願いいたします。\r\n\r\n\r\n-------------------------------------------\r\n　お振込先口座番号\r\n-------------------------------------------\r\n\r\n【振込先口座】\r\n%bank_seller_account%\r\n振り込み金額：%price% 円\r\n\r\n\r\nお振込予定日：%bank_buyer_transfer_date%\r\n（お振込み期限は %deadline_date% となっておりますのでご注意ください）\r\n\r\n\r\n備考：\r\n・お振り込み手数料はご負担くださいますようお願い申し上げます。\r\n・銀行からのお振込み控えをもって領収書にかえさせていただきます。\r\n\r\n\r\nご入金が確認できましたら弊社からその旨メールにてお知らせいたします。\r\n\r\n\r\n\r\n-------------------------------------------\r\n　商品情報\r\n-------------------------------------------\r\n\r\n注文ID：%bank_txn_id%\r\n商品名：%title%\r\n価　格：%price% 円\r\n注文日：%order_time%', '', '', '「%title%」決済完了のお知らせ', '%x_account%様\r\n\r\nこのたびは、「%title%」をお申し込み頂き、\r\n誠にありがとうございます。\r\n\r\n決済の確認ができました。\r\n\r\n\r\n引き続きこちらのページよりご登録をお願い致します。\r\n\r\n%item_url%\r\n\r\n\r\n■お申込み内容確認\r\n\r\n-------------------------------------------\r\n　商品情報\r\n-------------------------------------------\r\n\r\n注文ID：%x_txn_id%\r\n商品名：%title%\r\n価　格：%price% 円\r\n注文日：%order_time%', '「%title%」返金のお知らせ', '%x_account%様\r\n\r\n「%title%」の返金手続きを行いましたので、\r\nお知らせいたします。\r\n\r\n\r\n-------------------------------------------\r\n　商品情報\r\n-------------------------------------------\r\n\r\n注文ID：%bank_txn_id%\r\n商品名：%title%\r\n価　格：%price% 円\r\n注文日：%order_time%\r\n\r\n\r\n\r\nクレジット決済にてお申し込み頂いた方へ\r\n　Paypalを通じて、ご登録のクレジットカードに返金となります。\r\n　その場合、いったん決済された後に、遅れて返金される流れとなるかと思います。\r\n　（お使いのカードによっては決済日から１、２ヵ月後となる場合がございます）\r\n\r\n銀行振込にてお申し込み頂いた方へ\r\n　確認させて頂きました銀行口座へ返金させて頂いておりますのでご確認ください。', '', '', 0, '', '', '', '', '', 1, '', '', '', '2014-12-22 00:00:00', '2014-12-22 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
