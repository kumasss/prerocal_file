<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/controller');
$classLoader->registerDir(dirname(__FILE__) . '/view');

$records = array();

$ulController = new UserLibController();

if ( $_SERVER["REQUEST_METHOD"] == "GET") {

 	$action = htmlspecialchars($_GET['action']);

 	if ( $action == "Search") {

 		$search_name = htmlspecialchars($_GET['search_name']);
 		$search_email = htmlspecialchars($_GET['search_email']);

 		if ( $ulController->searchUserByNameEmail($search_name, $search_email,$records)) {
 			header(":", true, 200);
 			header("Content-Type: application/json; charset=utf-8");
 			header("X-Content-Type-Options: nosniff");
 			echo json_encode($records);
 			exit;
 		}

 		header(":", true, 404);
 		header("Content-Type: text/plain; charset=utf-8");
 		echo '該当者が見つかりません';
 		exit;

 	} elseif ( $action == STATUS_UNKNOWN) {

 		$txn_id = htmlspecialchars($_GET['txn_id']);
 		$type = htmlspecialchars($_GET['payment_type']);

		$dbm_cm = new ContractMapper(Config::getPDO());

		$contract = NULL;

		switch($type) {
			case 'BANK':
				$contract = $dbm_cm->findByBankTxnId($txn_id);
				break;

			case 'PAYPAL':
				$contract = $dbm_cm->findByPayPalTxnId($txn_id);
				break;
		}

		if ( $contract) {
			//完了させることが可能かテスト
			$ulController->resolveUserAndStatus($contract,STATUS_COMPLETED);
			if ( $contract->status == STATUS_COMPLETED) {
				header(":", true, 200);
				exit;
			}
		}

 	}

}

header(":", true, 404);
exit;

