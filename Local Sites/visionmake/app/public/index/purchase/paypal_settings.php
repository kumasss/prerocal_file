<?php
require_once 'resources/mockdata.inc';

$dbm = new SellerSettingMapper(Config::getPDO());

$settings = $dbm->findPayPalApiSetting();

define('API_IS_SANDBOX_MODE',  $settings->api_sandbox_mode);

if ( $settings->api_sandbox_mode) {
	define('API_USERNAME', $settings->api_sand_username);
	define('API_PASSWORD',  $settings->api_sand_password);
	define('API_SIGNATURE',  $settings->api_sand_signature);

} else {
	define('API_USERNAME', $settings->api_username);
	define('API_PASSWORD',  $settings->api_password);
	define('API_SIGNATURE',  $settings->api_signature);
}

function getPaypalRootURL() {
	return ( API_IS_SANDBOX_MODE == TRUE ? PAYPAL_SAND_URL : PAYPAL_LIVE_URL);
}
