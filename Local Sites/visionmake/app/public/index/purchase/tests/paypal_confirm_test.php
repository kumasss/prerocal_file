<?php
require_once dirname(__FILE__).'/../resources/framework.inc';
require_once dirname(__FILE__).'/../resources/mockdata.inc';

	$resArray  = array();

	$lines  = preg_split( "/[\n]+/", file_get_contents('confirmdata.csv'));
	foreach ($lines as $line) {
		$kv = explode("\t", $line);
		$resArray[$kv[0]] = ( isset($kv[1]) ? $kv[1] : NULL);
	}

	var_dump($resArray);

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

		$contract = NULL;
		$dbm_cm = new ContractMapper(Config::getPDO());

		try {

			$contract_db = $dbm_cm->findByPayPalTxnId($transactionId);

			$dbm_cm->beginTransaction();

			if ( $contract_db) {

				$contract = $contract_db;
				$contract->status = $paymentStatus;
				$contract->pending_reason = $pendingReason;
				$contract->reason_code = $reasonCode;

				print_r("UPDATE");
				$dbm_cm->update($contract);

			} else {

				//--- test ONLY ---
				$controller = new ProductController();
				$items[0]['number'] = $controller->generateId();
				$user['id'] = 0;
				//---

				$contract = new Contract();
				$contract->product_id = $items[0]['number'];
				$contract->user_id = $user['id'];

				$contract->txn_id = $transactionId;
				$contract->txn_type = $transactionType;
				$contract->payment_type = $paymentType;
				$contract->order_time = $orderTime;
				$contract->currency_code = $currencyCode;
				$contract->amt = $amt;
				$contract->fee_amt = $feeAmt;
				$contract->tax_amt = $taxAmt;
				$contract->pending_reason = $pendingReason;
				$contract->reason_code = $reasonCode;
				$contract->payment_status = $paymentStatus;	//即時支払なので、この時点ですぐにステータスが変わる

				print_r("INSERT");
				$dbm_cm->insert($contract);
			}

			var_dump($contract);

			//--- test ONLY ---
			$dbm_cm->rollback();
			print_r("<br/>\n test success!");


		} catch ( Exception $ex) {
			echo $ex->getMessage();
			$dbm_cm->rollback();
		}
	}

?>