<?php
require_once dirname(__FILE__).'/../resources/framework.inc';

function getValueSafe(&$array,$key) {
	if ( isset($array[$key])) {
		return $array[$key];
	}
	return NULL;
}

	$csv = array();
	$lines  = preg_split( "/[\n]+/", file_get_contents('postdata.csv'));
	foreach ($lines as $line) {
		$kv = explode("\t", $line);
		$csv[$kv[0]] = ( isset($kv[1]) ? $kv[1] : NULL);
	}

	var_dump($csv);

    // IPN message values depend upon the type of notification sent.
    // To loop through the &_POST array and print the NV pairs to the screen:

	$transaction_id = getValueSafe($csv,'txn_id');

	if ( $transaction_id) {

		print_r("<br/>\n has transaction_id.");

    	$paypal = new PaymentPaypal();

		$paypal->payer_id = 				getValueSafe($csv,'payer_id');
		$paypal->tax = 						getValueSafe($csv,'tax');
		$paypal->payment_date = 		getValueSafe($csv,'payment_date');
		$paypal->payment_status = 		getValueSafe($csv,'payment_status');
		$paypal->first_name = 				getValueSafe($csv,'first_name');
		$paypal->mc_fee = 					getValueSafe($csv,'mc_fee');
		$paypal->notify_version = 		getValueSafe($csv,'notify_version');
		$paypal->payer_status = 			getValueSafe($csv,'payer_status');
		$paypal->num_cart_items = 		getValueSafe($csv,'num_cart_items');
		$paypal->payer_email = 			getValueSafe($csv,'payer_email');
    	$paypal->txn_id = 					$transaction_id;
		$paypal->payment_type = 		getValueSafe($csv,'payment_type');
		$paypal->last_name = 				getValueSafe($csv,'last_name');
		$paypal->receiver_email = 		getValueSafe($csv,'receiver_email');
		$paypal->payment_fee = 			getValueSafe($csv,'payment_fee');
		$paypal->receiver_id = 				getValueSafe($csv,'receiver_id');
		$paypal->txn_type = 				getValueSafe($csv,'txn_type');
		$paypal->mc_gross = 				getValueSafe($csv,'mc_gross');
		$paypal->mc_currency = 			getValueSafe($csv,'mc_currency');
		$paypal->test_ipn = 					getValueSafe($csv,'test_ipn');
		$paypal->transaction_subject = getValueSafe($csv,'transaction_subject');
		$paypal->payment_gross = 		getValueSafe($csv,'payment_gross');
		$paypal->ipn_track_id = 			getValueSafe($csv,'ipn_track_id');

		print_r("<br/>\n payment date (row) - ".$paypal->payment_date);
		print_r("<br/>\n payment date (converted) -  ".TxController::convertTimeZone($paypal->payment_date));

		$paypal->adjustEncode($csv['charset']);
		$paypal->log = json_encode($csv);

    	$error = error_get_last();
    	if ( $error) {
			var_dump($error);
    	} else {

    		$dbm_ppm = new PaymentPaypalMapper(Config::getPDO());

			try {
				print_r("<br/>\n DB - ");


				$paypal_db = $dbm_ppm->isExists($transaction_id);

				$dbm_ppm->beginTransaction();

				if ( $paypal_db) {
					print_r("UPDATE");
					$dbm_ppm->update($paypal);
				} else {
					print_r("INSERT");
					$dbm_ppm->insert($paypal);
				}

				//--- test ONLY ---
				$dbm_ppm->rollback();
				print_r("<br/>\n test success!");


			} catch ( Exception $ex) {
				print_r("<br/>\n ".$ex->getMessage());
				print_r("<br/>\n ".$ex->getTraceAsString());
				$dbm_ppm->rollback();
			}
    	}

	} else {
		print_r("<br/>\n Unknown IPN Transaction ID: '${transaction_id}'");
	}

	print_r("<br/>\n process end.");
	?>
