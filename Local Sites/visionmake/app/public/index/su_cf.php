<?php
date_default_timezone_set('Asia/Tokyo');
define('ADMIN_SHORT_URL', dirname(__FILE__) . '/admin/shorturl');

require_once ADMIN_SHORT_URL. '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir( ADMIN_SHORT_URL . '/config');
$classLoader->registerDir( ADMIN_SHORT_URL . '/model');
$classLoader->registerDir( ADMIN_SHORT_URL . '/controller');

$dbm = new ShortUrlMapper(Config::getPDO());

if ( $_SERVER["REQUEST_METHOD"] == "GET" && @$_GET['code'] != null) {

	$record = $dbm->findByCode($_GET['code']);

	if ( ! empty($record)) {

		$shortUrlObj = $record;

		$clickLogObj = new ClickLog();
		$clickLogObj->short_code = $shortUrlObj->short_code;
		$clickLogObj->short_url = $shortUrlObj->short_url;
		$clickLogObj->referrer = @$_SERVER["HTTP_REFERER"];
		$clickLogObj->user_agent = @$_SERVER["HTTP_USER_AGENT"];
		$clickLogObj->ip_address = @$_SERVER["REMOTE_ADDR"];

		$d = 1;
		$current = strtotime('now');

		if ( isset($_COOKIE[$shortUrlObj->short_code])) {
			$saved = $_COOKIE[$shortUrlObj->short_code];
			$d = intval( abs($current - $saved) / (60 * 60 * 24));
		}

		if ( $d > 0) {
			$dbm = new ClickLogMapper(Config::getPDO());
			$dbm->insert($clickLogObj);
			$expireTime =  strtotime('tomorrow') - 1;
			setcookie($shortUrlObj->short_code, $current, $expireTime);
		}

		header('Location: '.$shortUrlObj->long_url);
	}
}

