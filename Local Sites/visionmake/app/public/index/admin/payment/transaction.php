<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/controller');
$classLoader->registerDir(dirname(__FILE__) . '/view');

$records = array();

$controller = new TxController();

 if ( $_SERVER["REQUEST_METHOD"] == "POST") {

 	$action = $_POST['action'];
 	$txn_id = $_POST['txn_id'];
 	$type = $_POST['payment_type'];

 	$resCode = 500;

	$contract = NULL;

 	if ( $controller->isExistsState($action)) {

 		$pay_stat = '';
 		$dbm_cm = new ContractMapper(Config::getPDO());

 		if ( $type == 'BANK') {

 			$contract = $dbm_cm->findByBankTxnId($txn_id);

 			$dbm_pm = new ProductMapper(Config::getPDO());
 			$product = $dbm_pm->findById($contract->product_id);

 			$dbm_pb = new PaymentBankMapper(Config::getPDO());

 			switch ($action) {
 				case STATUS_COMPLETED:
 					$dbm_pb->updateStatusAndPrice($txn_id, $action,$product->price);
 					break;
 				case STATUS_REFUNDED:
 					$dbm_pb->updateStatusAndPrice($txn_id, $action,0);
 					break;
 				case STATUS_UNKNOWN:
 					//should be No Action
 					break;
 				default:
 					$dbm_pb->updateStatus($txn_id, $action);
 					break;
 			}

 			//read again
 			$contract = $dbm_cm->findByBankTxnId($txn_id);

 		} elseif ( $type == 'PAYPAL') {
 			$contract = $dbm_cm->findByPayPalTxnId($txn_id);
 		}

 		if ( $contract) {

 			$ulController = new UserLibController();

 			if ( $contract->status == STATUS_UNKNOWN || $contract->status == STATUS_COMPLETED ){
        if( isset($_POST['user'])) {
 					//手動による紐づけ
 					$action = STATUS_COMPLETED;
 					$contract->user_id = $_POST['user'];
 			  }
      }

 			if ( $action == STATUS_CANCELED || $action == STATUS_REFUNDED) {
 				$contract->status = $action;

 			} else {

	 			$ulController->resolveUserAndStatus($contract,$action);
 			}

 			LogController::debug( sprintf("user = %s",$contract->user_id));
 			LogController::debug( sprintf("action = %s, result = %s",$action,$contract->status));

 			$dbm_cm->update($contract);
 			$controller->combineData($contract);

 			$resCode = 200;

 		}
 	}

 	if ( $resCode == 200) {

 		if ( $action == STATUS_COMPLETED) {

 			if ( $contract->user_id) {

	 			$dbm_pm = new ProductMapper(Config::getPDO());
	 			$product = $dbm_pm->findById($contract->product_id);

	 			if ( $product) {

		 			list ($groupdata,$group_i,$group_f)  = $ulController->getPrimaryGroup($product->group_info);
		 			if ( $group_f == TRUE) {
		 				$ulController->changeUserGroup($contract->user_id,$group_i);
		 			}
	 			}
 			}

 			$controller->sendStateChangeMail($action,$contract) ;

 		} elseif ( $action == STATUS_REFUNDED) {

// 			if ( $contract->user_id) {
// 				$ulController->changeUserGroup($contract->user_id,0);
// 			}

 			$controller->sendStateChangeMail($action,$contract) ;
 		}

 		header(':', true, $resCode);

	 	$view = new View( dirname(__FILE__).'/transaction_cmd.php');
	 	$view->assign('item',$contract);
	 	$view->display();

	 	exit;
 	}

 	header(':', true, $resCode);
 	echo error_get_last();
 	exit;

 } else if ( $_SERVER["REQUEST_METHOD"] == "GET") {

 	$dbm_cm = new ContractMapper(Config::getPDO());
	$all_contracts = $dbm_cm->findByCondition();

	foreach ($all_contracts as $contract) {
		$controller->combineData($contract);
	}

	$totalCount = count($all_contracts);
	$itemsOnPage = 50; //$totalCount;
	if ( isset($_COOKIE['trx-items-onpage'])) {
		$itemsOnPage = $_COOKIE['trx-items-onpage'];
	}

	$offset = 1;
	if ( isset($_COOKIE['trx-draw-page'])) {
		$offset = $_COOKIE['trx-draw-page'];
	}

	$startIndex = $itemsOnPage * ( $offset - 1);

	$page_array = array_slice($all_contracts,$startIndex,$itemsOnPage);

	$view = new View(__FILE__);
	$view->assign('records',$page_array);
	$view->assign('total_records',$totalCount);

	$view->display();

}

