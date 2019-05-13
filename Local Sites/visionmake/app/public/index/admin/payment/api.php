<?php
require_once dirname(__FILE__).'/resources/mockdata.inc';

require_once dirname(__FILE__) . '/config/Config.php';
require_once dirname(__FILE__) . '/ClassLoader.php';
$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/controller');
$classLoader->registerDir(dirname(__FILE__) . '/model');

function recieveRequestData(&$inData) {

	LogController::api_trace('recieveRequestData');

	if ( ! ( isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
			strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
		header("HTTP/1.1 403 Forbidden");

		LogController::api_trace("Forbidden");
		exit;
	}

	//for json data
	$json_string = file_get_contents('php://input');
	$params = json_decode($json_string);

	if ( $params && is_array($params)) {
		$inData = array();
		foreach ( $params as $item) {
			$inData[$item->name] = $item->value;
			LogController::api_trace($item->name." = ".$inData[$item->name]);
		}
		return !empty($inData);
	}

	return FALSE;
}

function sendResponseData(&$outData) {

//	header("HTTP/1.1 200 OK");	// for localhost
	header("Content-Type: application/json; charset=utf-8");
	header('X-Content-Type-Options: nosniff');
//	header("Connection: Close");	// for localhost

	echo json_encode($outData);
}

//---

$data = NULL;
$response = FALSE;

if ( $_SERVER["REQUEST_METHOD"] == "POST") {

	if ( !recieveRequestData($data)) {
		LogController::api_trace( 'Last error: ', json_last_error());
		$resp = array(UTAPI_RESULT=>UTAPI_RESULT_NG);
		sendResponseData($resp);
		exit;
	}

	$txn_id = @$data['order'];

	if ( $txn_id == UTAPI_TEST_ORDER_ID) {

		$response = TRUE;

	} else {

		$contract = NULL;
		$resp = array();

		$dbm_cm = new ContractMapper(Config::getPDO());

		$type = @$data['type'];

		if ( $type == 'bank') {
			$contract = $dbm_cm->findByBankTxnId($txn_id);

		} elseif ( $type == 'paypal') {
			$contract = $dbm_cm->findByPayPalTxnId($txn_id);
		}

		if ( $contract) {

			switch( $data['cmd']) {

				case UTAPI_CMD_QUERY:
					$response = TRUE;
					break;

				case UTAPI_CMD_INSERT:
					if ( empty($contract->user_id)) {
						$contract->user_id = $data['user'];
						$contract->status = STATUS_COMPLETED;
						$dbm_cm->update($contract);
						$response = TRUE;
					}
					break;
			}

		}
	}

	$resp = NULL;

	if ( $response) {
		$resp = array(UTAPI_RESULT=>UTAPI_RESULT_OK);
		LogController::api_trace( 'result = OK');
	} else {
		$resp = array(UTAPI_RESULT=>UTAPI_RESULT_NG);
		LogController::api_trace( 'result = NG');
	}

	sendResponseData($resp);
}
