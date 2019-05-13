<?php
require_once 'resources/mockdata.inc';

global $user;

function check_last_error() {
	$e = error_get_last();
	LogController::debug($e['message']);
	if ( $e) {
		$view = new View( dirname(__FILE__).'/bank_error.php');
		$view->assign('error', $e['message']);
		$view->assign('smartPhone', MobileController::isSmartPhone());
		$view->display();
		exit;
	}
}

function exception_exit($ex) {
	$view = new View( dirname(__FILE__).'/bank_error.php');
	$view->assign('error', $ex->getMessage());
	$view->assign('smartPhone', MobileController::isSmartPhone());
	$view->display();
	exit;
}

function createSampleData($product,$txnId) {

	global $user;

	$contract = new Contract();

	//--- contract inserts
	$contract->id = 0;
	$contract->product_id = $product->id;
	$contract->status = 'Completed';
	$contract->user_id = @$user['id'];
	$contract->mail_transfer = '2014-10-01 00:00:00';
	$contract->mail_complete = '2014-10-01 00:00:00';
	$contract->mail_refund = NULL;

	//--- inserts by bank payment
	$contract->bank_txn_id = '201410019999ZZZZ';

	//--- join on users part
	$contract->email = @$user['email'];
	$contract->firstname = @$user['firstname'];
	$contract->lastname = @$user['lastname'];

	//--- join on product part
	$contract->title = $product->title;
	$contract->price = $product->price;
	$contract->description = $product->description;
	$contract->sales_option = $product->sales_option;
	$contract->mail_title = $product->mail_title;
	$contract->mail_body = $product->mail_body;
	$contract->bank_app_mail_title = $product->bank_app_mail_title;
	$contract->bank_app_mail_body = $product->bank_app_mail_body;
	$contract->bank_tr_deadline = $product->bank_tr_deadline;

	//--- join on bank payment part
	$contract->bank_buyer_name = '購入者名';
	$contract->bank_buyer_email = 'sample@cyfons.com';
	$contract->bank_account_name = 'フリコミメイ';
	$contract->bank_payment_amount =  10000;
	$contract->bank_payment_status = 'Completed';
	$contract->bank_buyer_transfer_date =  '2014-10-01 00:00:00';

	$contract->created = '2014-10-01 00:00:00';
	$contract->updated = NULL;

	return $contract;
}

if ( $_SERVER["REQUEST_METHOD"] == "POST") {


	$productId = htmlspecialchars( trim($_POST['pid']));
	$amount = htmlspecialchars( trim($_POST['payment_amount']));

	$userId = NULL;
	if (  $user && isset($user['id']) && $user['auth'] == USER_ROLL) {
		$userId = $user['id'];
	}
	$orderTime = date("c");

	$dbm = new ProductMapper(Config::getPDO());
	$product = $dbm->findById($productId);

	if ( empty($product)) {
		exit;
	}

	$contract = new Contract();

	$contract->product_id = $productId;

	$dbm_ct = new ContractMapper(Config::getPDO());

	$txnId = NULL;
	for ($i=0;$i<5;$i++) {
		$txnId = TxController::generateTxnId();
		if ( !$dbm_ct->isExistsBankTxnId($txnId)) {
			break;
		}
	}
	$contract->bank_txn_id = $txnId;

	if ( $userId) {
		$contract->user_id = $userId;
	}
	$contract->order_time = $orderTime;
	$contract->amt = $amount;
	$contract->status = STATUS_UNCONFIRMED;

	check_last_error();

	$dbm_ct = new ContractMapper(Config::getPDO());
	try {

		$dbm_ct->beginTransaction();
		$dbm_ct->insert($contract);
		$dbm_ct->commit();

	} catch (Exception $ex1) {
		$dbm_ct->rollback();
		exception_exit($ex1);
	}

	$dbm_pb = new PaymentBankMapper(Config::getPDO());
	try {
		$bank = new PaymentBank();
		$bank->bank_txn_id = $txnId;
		$bank->bank_buyer_name = sprintf("%s %s",@$user['firstname'],@$user['lastname']);
		$bank->bank_buyer_email = htmlspecialchars($_POST['bank_buyer_email']);
		$bank->bank_account_name = htmlspecialchars($_POST['bank_account_name']);
		$bank->bank_payment_amount =  0;
		$bank->bank_buyer_transfer_date =  htmlspecialchars( $_POST['bank_buyer_transfer_date']);

		$bank->bank_payment_status = STATUS_UNCONFIRMED;

		check_last_error();

		$dbm_pb->beginTransaction();
		$dbm_pb->insert($bank);
		$dbm_pb->commit();

	} catch (Exception $ex2) {
		$dbm_pb->rollback();
		$contract = $dbm_ct->findByBankTxnId($txnId);
		if ( $contract) {
			$contract->bank_payment_status = "Canceled-By-System";
			$dbm_ct->update($contract);
		}
		exception_exit($ex2);
	}

	if ( $contract->mail_transfer == NULL) {

		$contract = $dbm_ct->findByBankTxnId($txnId);

		if ( $contract) {
			$tx = new TxController();
			$tx->combineData($contract);
			$tx->sendStateChangeMail(MAIL_TRANSFER,$contract);
		}
	}

	check_last_error();

	header( 'Location:'.URL.'/purchase/bank.php?id='.$productId.'&order='.$txnId);
	exit;

} else if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$productId = @$_GET['id'];
	$txn_id = @$_GET['order'];

	$contract = NULL;
	if ( $txn_id) {
		if ( $txn_id == 'review') {
			if ( empty($productId)) {
				$view = new View( dirname(__FILE__).'/bank_complete_review.php');
				$view->assign('smartPhone', MobileController::isSmartPhone());
				$view->display();
				exit;
			} else {
				$dbm = new ProductMapper(Config::getPDO());
				$product = $dbm->findById($productId);
				$contract = createSampleData($product,$txn_id);
			}

		} else {
			$dbm_ct = new ContractMapper(Config::getPDO());
			$contract = $dbm_ct->findByBankTxnId($txn_id);
		}
	}

	if ( $contract && $contract->product_id == $productId) {

		$dbm = new ProductMapper(Config::getPDO());
		$product = $dbm->findById($productId);

		$tx = new TxController();
		if ( $contract->bank_payment_status == STATUS_COMPLETED) {
			$tx->checkUserPrivilege($product->sales_option,$contract->user_id);
		}
		$tx->combineData($contract);

		$view = new View( dirname(__FILE__).'/bank_complete.php');

		$dbm_set = new SellerSettingMapper(Config::getPDO());
		$settings = $dbm_set->findByLastId();
		$view->assign('settings', $settings);

		$responseFlag = new ReponseFlag();
		$ulController = new UserLibController();
		$exKeyword = new ExtraKeywordController();

		$stateMessage['title'] = "";
		$stateMessage['color'] = "";

		$mail_title = '';
		$mail_body = '';

		$assignMailContent = FALSE;

		if ( $contract->bank_payment_status == STATUS_COMPLETED) {

			$stateMessage['title'] = "ご購入ありがとうございます。";
			$stateMessage['color'] = "alert-success";

			if ( !empty($contract->mail_title) && !empty($contract->mail_body)) {

				$mail_title = $contract->mail_title;
				$mail_body = $contract->mail_body;

			} else {

				$mail_title = $settings->mail_title;
				$mail_body = $settings->mail_body;
			}

			$ulController->responseFlagLogic($contract, $product, $responseFlag);

			if ( $responseFlag->show_mail) {

				$itemUrl = $exKeyword->createItemUrl( $responseFlag, $product, $contract, 'bank', $txn_id);
				//[NOTE] %item_url%があったら、self::applyWordの前に置換
				$mail_body .= "\n";
				$mail_body = str_replace( "%item_url%", $itemUrl, $mail_body);

				$assignMailContent = TRUE;
			}


		} elseif ( $contract->bank_payment_status == STATUS_UNCONFIRMED
				 || $contract->bank_payment_status == STATUS_UNKNOWN) {

			//振込前

			$stateMessage['title'] = "お客様の振込申請を以下の通り受け付けました。　振込予定日までに手続きを行ってください。";
			$stateMessage['color'] = "alert-info";

			if ( !empty($contract->bank_app_mail_title) && !empty($contract->bank_app_mail_body)) {

				$mail_title = $contract->bank_app_mail_title;
				$mail_body = $contract->bank_app_mail_body;

			} else {
				$mail_title = $settings->bank_req_title;
				$mail_body = $settings->bank_req_body;
			}

			$assignMailContent = TRUE;

		} elseif ( $contract->bank_payment_status == STATUS_REFUNDED ||
				$contract->bank_payment_status == STATUS_CANCELED) {

			$stateMessage['title'] = "本取引は、キャンセルまたは返金により無効となっております。";
			$stateMessage['color'] = "alert-danger";
		}

		if ( $assignMailContent) {

			$tx->applyWord($contract, $mail_title);
			$view->assign("mail_title", $mail_title);

			$tx->applyWord($contract, $mail_body);
			$view->assign("mail_body", $tx->url2Link( nl2br($mail_body)));

		}

		$view->assign("product", $product);
		$view->assign('contract', $contract);

		$view->assign("state_message", $stateMessage);

		$view->assign("responseFlag", $responseFlag);

		$view->assign('smartPhone', MobileController::isSmartPhone());

		$view->display();

	} else if ( $productId) {

		header( 'Location:'.URL.'/purchase/?id='.$productId);
		exit;
	}

}
