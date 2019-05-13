<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/view');


$editdata = new PaymentPaypal();

$dbm = new PaymentPaypalMapper(Config::getPDO());

if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$log = array();
	$txnId = @$_GET['txn'];

	if ($txnId) {
		$result = $dbm->findLogByTxnId($txnId);
		if ( $result) {
			$json = $result->log;
			$log = json_decode($json,true);
		}
	}


	$view = new View(__FILE__);

	$view->assign('log',$log);

	$view->display();

}
