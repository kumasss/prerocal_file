<?php
require_once ("paypal_settings.php");
require_once ("paypalfunctions.php");

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

	//--- inserts by paypal confirm callback (order_time uses bank, also)
	$contract->txn_id = '8CK84582N4909084N';
	$contract->txn_type = 'cart';
	$contract->payment_type = 'instant';
	$contract->order_time = '2014-10-01 00:00:00';
	$contract->amt = '1';
	$contract->fee_amt = '1';
	$contract->tax_amt = '0';
	$contract->currency_code = 'JPY';
	$contract->pending_reason = 'None';
	$contract->reason_code = 'None';
	$contract->error_code = NULL;

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

	//--- join on paypal payment part
	$contract->payer_email = 'sample@cyfons.com';
	$contract->last_name = 'Last';
	$contract->first_name = 'First';
	$contract->mc_gross = $product->price;
	$contract->payment_status = 'Completed';

	$contract->created = '2014-10-01 00:00:00';
	$contract->updated = NULL;

	return $contract;
}

//----------------------------------

$transactionId = NULL;
$productId = NULL;
$contract = NULL;

if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$productId = @$_GET['id'];
	$txn_id = @$_GET['order'];

	$contract = NULL;
	if ( $txn_id) {
		if ( $txn_id == 'review') {
			if ( empty($productId)) {
				$view = new View( dirname(__FILE__).'/paypal_complete_review.php');
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
			$contract = $dbm_ct->findByPayPalTxnId($txn_id);
		}
	}

} else if ( $_SERVER["REQUEST_METHOD"] == "POST") {

	global $user;

	/*
	 '------------------------------------
	' Calls the DoExpressCheckoutPayment API call
	'
	' The ConfirmPayment function is defined in the file PayPalFunctions.php,
	' that is included at the top of this file.
	'-------------------------------------------------
	*/

	/* -- dump
	foreach ($_POST as $k => $v) {
		LogController::paypal_trace("${k}\t${v}");
	}
	*/

	//Format the  parameters that were stored or received from GetExperessCheckout call.
	$token 						= $_POST['TOKEN'];
	$payerID 					= $_POST['PAYERID'];
	$paymentType 			= 'Sale';
	$currencyCodeType 	= $_POST['CURRENCYCODE'];

	$finalPaymentAmount =  $_POST["PAYMENTREQUEST_0_AMT"];


	$items = array();
	$i = 0;
	// adding item details those set in setExpressCheckout
	while(isset($_POST["L_PAYMENTREQUEST_0_NAME$i"]))
	{
		$items[] = array('name' => $_POST["L_PAYMENTREQUEST_0_NAME$i"], 'number' => $_POST["L_PAYMENTREQUEST_0_NUMBER$i"]
				, 'amt' => $_POST["L_PAYMENTREQUEST_0_AMT$i"], 'qty' => $_POST["L_PAYMENTREQUEST_0_QTY$i"]);
		$i++;
	}

	$custom = @$_POST['PAYMENTREQUEST_0_CUSTOM'];
	$productId = @$_POST['L_PAYMENTREQUEST_0_NUMBER0'];

	$resArray = ConfirmPayment ( $token, $paymentType, $currencyCodeType, $payerID, $finalPaymentAmount, $items, $custom);

	/* -- dump
	 foreach ($resArray as $k => $v) {
	LogController::paypal_trace("${k}\t${v}");
	}
	*/

	$ack = strtoupper($resArray["ACK"]);
	if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
	{

		/*
		 * TODO: Proceed with desired action after the payment
		* (ex: start download, start streaming, Add coins to the game.. etc)
		'********************************************************************************************************************
		'
		' THE PARTNER SHOULD SAVE THE KEY TRANSACTION RELATED INFORMATION LIKE
		'                    transactionId & orderTime
		'  IN THEIR OWN  DATABASE
		' AND THE REST OF THE INFORMATION CAN BE USED TO UNDERSTAND THE STATUS OF THE PAYMENT
		'
		'********************************************************************************************************************
		*/

		$transactionId		= $resArray["PAYMENTINFO_0_TRANSACTIONID"]; // Unique transaction ID of the payment.
		$transactionType 	= $resArray["PAYMENTINFO_0_TRANSACTIONTYPE"]; // The type of transaction Possible values: l  cart l  express-checkout
		$paymentType		= $resArray["PAYMENTINFO_0_PAYMENTTYPE"];  // Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant
		$orderTime 			= $resArray["PAYMENTINFO_0_ORDERTIME"];  // Time/date stamp of payment
		$amt						= $resArray["PAYMENTINFO_0_AMT"];  // The final amount charged, including any  taxes from your Merchant Profile.
		$currencyCode		= $resArray["PAYMENTINFO_0_CURRENCYCODE"];  // A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD.
		$feeAmt				= $resArray["PAYMENTINFO_0_FEEAMT"];  // PayPal fee amount charged for the transaction
		//	$settleAmt			= $resArray["PAYMENTINFO_0_SETTLEAMT"];  // Amount deposited in your PayPal account after a currency conversion.
		$taxAmt				= $resArray["PAYMENTINFO_0_TAXAMT"];  // Tax charged on the transaction.
		//	$exchangeRate		= $resArray["PAYMENTINFO_0_EXCHANGERATE"];  // Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer's account.

		/*
		 ' Status of the payment:
		'Completed: The payment has been completed, and the funds have been added successfully to your account balance.
		'Pending: The payment is pending. See the PendingReason element for more information.
		*/

		$paymentStatus = $resArray["PAYMENTINFO_0_PAYMENTSTATUS"];

		/*
		 'The reason the payment is pending:
		'  none: No pending reason
		'  address: The payment is pending because your customer did not include a confirmed shipping address and your Payment Receiving Preferences is set such that you want to manually accept or deny each of these payments. To change your preference, go to the Preferences section of your Profile.
		'  echeck: The payment is pending because it was made by an eCheck that has not yet cleared.
		'  intl: The payment is pending because you hold a non-U.S. account and do not have a withdrawal mechanism. You must manually accept or deny this payment from your Account Overview.
		'  multi-currency: You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment.
		'  verify: The payment is pending because you are not yet verified. You must verify your account before you can accept this payment.
		'  other: The payment is pending for a reason other than those listed above. For more information, contact PayPal customer service.
		*/

		$pendingReason = $resArray["PAYMENTINFO_0_PENDINGREASON"];

		/*
		 'The reason for a reversal if TransactionType is reversal:
		'  none: No reason code
		'  chargeback: A reversal has occurred on this transaction due to a chargeback by your customer.
		'  guarantee: A reversal has occurred on this transaction due to your customer triggering a money-back guarantee.
		'  buyer-complaint: A reversal has occurred on this transaction due to a complaint about the transaction from your customer.
		'  refund: A reversal has occurred on this transaction because you have given the customer a refund.
		'  other: A reversal has occurred on this transaction due to a reason not listed above.
		*/

		$reasonCode	= $resArray["PAYMENTINFO_0_REASONCODE"];

		// Add javascript to close Digital Goods frame. You may want to add more javascript code to
		// display some info message indicating status of purchase in the parent window

		$dbm_pm = new ProductMapper(Config::getPDO());
		$product = $dbm_pm->findById($productId);

		$dbm_cm = new ContractMapper(Config::getPDO());

		$contract_db = $dbm_cm->findByPayPalTxnId($transactionId);

		if ( $product && empty($contract_db)) {
			//PaymentPayPalとの紐づけがまだない状態のContract
			try {
				$dbm_cm->beginTransaction();

				$contract = new Contract();
				$contract->product_id = $productId;

				$contract->txn_id = $transactionId;
				$contract->txn_type = $transactionType;
				$contract->payment_type = $paymentType;
				$contract->order_time = TxController::convertTimeZone( $orderTime);
				$contract->currency_code = $currencyCode;
				$contract->amt = $amt;
				$contract->fee_amt = $feeAmt;
				$contract->tax_amt = $taxAmt;
				$contract->pending_reason = $pendingReason;
				$contract->reason_code = $reasonCode;
				$contract->payment_status = $paymentStatus;
				$contract->status = STATUS_UNKNOWN;
				if ( $custom) {
					$contract->user_id = $custom;
				}

				$dbm_cm->insert($contract);

				$dbm_cm->commit();

				$contract->last_name = 	@$_POST['LASTNAME'];
				$contract->first_name =  	@$_POST['FIRSTNAME'];
				$contract->payer_email = @$_POST['EMAIL'];
				$contract->title = 			@$_POST['L_NAME0'];
				$contract->mc_gross = 	@$_POST['PAYMENTREQUEST_0_AMT'];

			} catch ( Exception $ex) {

				$error = "\n\nエラーが発生しました:\n".$ex->getMessage();

				$dbm_cm->rollback();
			}

		} else {
			$contract = $contract_db;
		}

		if ( $contract->txn_id) {

			$dbm_ppm = new PaymentPaypalMapper(Config::getPDO());
			$paypal_db = $dbm_ppm->isExists($contract->txn_id);

			if ( $paypal_db) {
				//nothing to do
			} else {

				$paypal = new PaymentPaypal();
				$dbm_ppm->beginTransaction();

				try {
					$paypal->payment_status = 		$paymentStatus;
					$paypal->first_name = 				@$_POST['FIRSTNAME'];
					$paypal->payer_email = 			@$_POST['EMAIL'];
					$paypal->txn_id = 					$transactionId;
					$paypal->payment_type = 		$paymentType;
					$paypal->last_name = 				@$_POST['LASTNAME'];
					$paypal->txn_type = 				$transactionType;
					$paypal->mc_gross = 				@$_POST['PAYMENTREQUEST_0_AMT'];
					$paypal->mc_currency = 			$currencyCode;

					$dbm_ppm->insert($paypal);
					$dbm_ppm->commit();

					if ( $paypal->payment_status == STATUS_COMPLETED) {

						$ulc = new UserLibController();
						$ulc->resolveUserAndStatus($contract,STATUS_COMPLETED);

						LogController::debug("contract status = ".$contract->status);

						$tx = new TxController();
						$tx->combineData($contract);

						if ( $tx->sendStateChangeMail(STATUS_COMPLETED,$contract)) {
							LogController::debug("mail sent.");

						} else {
							LogController::debug("send mail skipped.");
						}

						LogController::debug("done.");
					}

				} catch ( Exception $ex) {
					$dbm_ppm->rollback();
					LogController::debug( $ex->getMessage());
					LogController::debug( $ex->getTraceAsString());
				}

			}
		}


	} else {

		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

		$error = "\n\nConfirmPayment API 呼び出しエラーが発生しました:\n";
		$error .= "\nDetailed Error Message: " . $ErrorLongMsg;
		$error .= "\nShort Error Message: " . $ErrorShortMsg;
		$error .= "\nError Code: " . $ErrorCode;
		$error .= "\nError Severity Code: " . $ErrorSeverityCode;
	}

	if ( isset( $error)) {

		LogController::paypal_trace( $error);

		$view = new View( dirname(__FILE__).'/order_error.php');
		$view->assign("productId",$productId);
		$view->assign("error",$error);
		$view->assign('smartPhone', MobileController::isSmartPhone());
		$view->display();

		exit;
	}

}// end of POST


//--- 表示のための共通処理 ---
if ( $contract && $contract->product_id == $productId) {

	$dbm = new ProductMapper(Config::getPDO());
	$product = $dbm->findById($productId);

	//--- manual join on product part
	$contract->title = @$product->title;
	$contract->price = @$product->price;
	$contract->description = @$product->description;
	$contract->mail_title = @$product->mail_title;
	$contract->mail_body = @$product->mail_body;

	$tx = new TxController();
	if ( $contract->payment_status == STATUS_COMPLETED) {
		$tx->checkUserPrivilege($product->sales_option,$contract->user_id);
	}
	$tx->combineData($contract);

	$view = new View( dirname(__FILE__).'/paypal_complete.php');

	$view->assign("product", $product);
	$view->assign('contract', $contract);

	if ( $contract->currency_code == "JPY") {
		$view->assign('currency', '円');
	} else {
		$view->assign('currency', "(".$contract->currency_code.")");
	}

	$responseFlag = new ReponseFlag();
	$ulController = new UserLibController();

	$stateMessage['title'] = "";
	$stateMessage['color'] = "";

	$mail_title = '';
	$mail_body = '';

	if ( $contract->payment_status == STATUS_COMPLETED) {

		$stateMessage['title'] = "ご購入ありがとうございます。";
		$stateMessage['color'] = "alert-success";

		$ulController->responseFlagLogic($contract, $product, $responseFlag);

		if ( $responseFlag->show_mail) {

			if ( !empty($contract->mail_title) && !empty($contract->mail_body)) {

				$mail_title = $contract->mail_title;
				$mail_body = $contract->mail_body;

			} else {

				$dbm_ss = new SellerSettingMapper(Config::getPDO());
				$settings = $dbm_ss->findByLastId();

				$mail_title = $settings->mail_title;
				$mail_body = $settings->mail_body;
			}

			$exKeyword = new ExtraKeywordController();
			$itemUrl = $exKeyword->createItemUrl( $responseFlag, $product, $contract, 'paypal', $contract->txn_id);
			//[NOTE] %item_url%があったら、self::applyWordの前に置換
			$mail_body .= "\n";
			$mail_body = str_replace( "%item_url%", $itemUrl, $mail_body);
		}

	} elseif ( $contract->payment_status == STATUS_REFUNDED ||
			$contract->payment_status == STATUS_CANCELED) {

		$stateMessage['title'] = "本取引は、キャンセルまたは返金により無効となっております。";
		$stateMessage['color'] = "alert-danger";

	} else {

		$stateMessage['title'] = "お客様の決済申請を受け付けました。取引完了までお待ちください";
		$stateMessage['color'] = "alert-info";
	}

	$view->assign("state_message", $stateMessage);

	if ( $responseFlag->show_mail) {

		$tx->applyWord($contract, $mail_title);
		$view->assign("mail_title", $mail_title);

		$tx->applyWord($contract, $mail_body);
		$view->assign("mail_body", $tx->url2Link( nl2br($mail_body)));

	}

	$view->assign("responseFlag", $responseFlag);

	$view->assign('smartPhone', MobileController::isSmartPhone());

	$view->display();

} elseif ( $productId) {
	header( 'Location:'.URL.'/purchase/?id='.$productId);
}
