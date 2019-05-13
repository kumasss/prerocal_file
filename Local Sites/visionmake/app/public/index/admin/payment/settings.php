<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/controller');
$classLoader->registerDir(dirname(__FILE__) . '/view');


$editdata = new SellerSetting();

$dbm = new SellerSettingMapper(Config::getPDO());

 if ( $_SERVER["REQUEST_METHOD"] == "POST") {

 	if ( ! ( isset($_SERVER['HTTP_X_REQUESTED_WITH'])
 			&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
 		header("HTTP/1.1 403 Forbidden");
 		exit;
 	}

 	//for json data
 	$json_string = file_get_contents('php://input');

 	$params = json_decode($json_string,TRUE);

 	$data = array();
 	foreach ($params as $value) {
 		$data[$value['name']] = $value['value'];
 	}

 	$editdata->fromArray($data);

	if ( $editdata->id != NULL) {
		$dbm->update($editdata);
	} else {
		$dbm->insert($editdata);
	}

 } else if ( $_SERVER["REQUEST_METHOD"] == "GET") {

 	$referer = @$_SERVER["HTTP_REFERER"];
 	if ( !$referer) {
 		exit;
 	}

 	if ( isset($_GET['action']) && $_GET['action'] == 'check') {
 		$settings = $dbm->findByLastId();
 		echo json_encode(SellerSetting::hasBankValues($settings));
 		exit;
 	}

 	$setting = $dbm->findByLastId();

 	if ( $setting) {
 		$editdata = $setting;
 	}
 }

$view = new View(__FILE__);

$dbm = new SellerSettingMapper(Config::getPDO());
list($paypalApiState,$paypalApiStateColor) = $dbm->toStringPayPayApiState();

$view->assign('ppapi_state',$paypalApiState);
$view->assign('ppapi_state_col',$paypalApiStateColor);

$view->assign('editdata',$editdata);

$view->display();

exit();
