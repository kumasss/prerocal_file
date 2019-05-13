<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/view');

$dbm = new ApiAccessLogMapper(Config::getPDOAssoc());

$records = array();

if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$code = @$_GET['code'];
	if ( $code != NULL) {
		$year = @$_GET['y'];
		$month = @$_GET['m'];
		if ( $year != NULL && $month != NULL) {
			$records = $dbm->findDaysSummary($code,$year,$month);
		}

	}
}

$view = new View(__FILE__);
$view->assign('records',$records);
$view->display();
