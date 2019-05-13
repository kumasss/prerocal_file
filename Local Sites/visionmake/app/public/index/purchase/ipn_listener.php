<?php
require_once 'resources/framework.inc';

require_once ("paypal_settings.php");

error_reporting(E_ALL);

function getValueSafe(&$array,$key) {
	if ( isset($array[$key])) {
		return $array[$key];
	}
	return NULL;
}

/*
 * https://developer.paypal.com/docs/classic/ipn/gs_IPN/#listener
 * https://developer.paypal.com/docs/classic/ipn/ht_ipn/
*/

//Upon receipt of a notification from PayPal, send an empty HTTP 200 response.
//Send an empty HTTP 200 OK response to acknowledge receipt of the notification
header('HTTP/1.1 200 OK');

// STEP 1: read POST data

// Reading POSTed data directly from $_POST causes serialization issues with array data in the POST.
// Instead, read raw POST data from the input stream.
$raw_post_data = file_get_contents('php://input');
$raw_post_array = explode('&', $raw_post_data);
$myPost = array();
foreach ($raw_post_array as $keyval) {
  $keyval = explode ('=', $keyval);
  if (count($keyval) == 2)
     $myPost[$keyval[0]] = urldecode($keyval[1]);
}
// read the IPN message sent from PayPal and prepend 'cmd=_notify-validate'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc')) {
   $get_magic_quotes_exists = true;
}
foreach ($myPost as $key => $value) {
   if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
        $value = urlencode(stripslashes($value));
   } else {
        $value = urlencode($value);
   }
   $req .= "&$key=$value";
}


// STEP 2: POST IPN data back to PayPal to validate
$cipher_list = (stripos(curl_version()['ssl_version'], "NSS") === 0)?'rsa_aes_128_sha':'TLSv1';
$ch = curl_init( getPaypalRootURL());
curl_setopt($ch, CURLOPT_SSLVERSION , 1);
curl_setopt($ch, CURLOPT_SSL_CIPHER_LIST, $cipher_list);
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

// In wamp-like environments that do not come bundled with root authority certificates,
// please download 'cacert.pem' from "http://curl.haxx.se/docs/caextract.html" and set
// the directory path of the certificate as shown below:
if ( API_IS_SANDBOX_MODE) {
//	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
//	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
//	curl_setopt($ch, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
} else {
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
}

if( !($res = curl_exec($ch)) ) {
    LogController::ipn_trace("Got " . curl_error($ch) . " when processing IPN data");
    curl_close($ch);
    exit;
}
curl_close($ch);


// STEP 3: Inspect IPN validation result and act accordingly

if (strcmp ($res, "VERIFIED") == 0) {

	LogController::ipn_trace("VERIFIED");

    // The IPN is verified, process it:
    // check whether the payment_status is Completed
    // check that txn_id has not been previously processed
    // check that receiver_email is your Primary PayPal email
    // check that payment_amount/payment_currency are correct
    // process the notification

    // assign posted variables to local variables
	foreach($_POST as $key => $value) {
		//      echo $key." = ". $value."<br>";
		LogController::ipn_trace("POST: ${key} = ${value}");
	}

    // IPN message values depend upon the type of notification sent.
    // To loop through the &_POST array and print the NV pairs to the screen:

	$transaction_id = getValueSafe($_POST,'txn_id');
	$parent_txn_id = getValueSafe($_POST,'parent_txn_id');

	if ( $transaction_id) {

		LogController::ipn_trace("has transaction_id.");

    	$paypal = new PaymentPaypal();

		$paypal->payer_id = 				getValueSafe($_POST,'payer_id');
		$paypal->tax = 						getValueSafe($_POST,'tax');
		$paypal->payment_date = 		getValueSafe($_POST,'payment_date');
		$paypal->payment_status = 		getValueSafe($_POST,'payment_status');
		$paypal->first_name = 				getValueSafe($_POST,'first_name');
		$paypal->mc_fee = 					getValueSafe($_POST,'mc_fee');
		$paypal->notify_version = 		getValueSafe($_POST,'notify_version');
		$paypal->payer_status = 			getValueSafe($_POST,'payer_status');
		$paypal->num_cart_items = 		getValueSafe($_POST,'num_cart_items');
		$paypal->payer_email = 			getValueSafe($_POST,'payer_email');
    	$paypal->txn_id = 					$transaction_id;
		$paypal->payment_type = 		getValueSafe($_POST,'payment_type');
		$paypal->last_name = 				getValueSafe($_POST,'last_name');
		$paypal->receiver_email = 		getValueSafe($_POST,'receiver_email');
		$paypal->payment_fee = 			getValueSafe($_POST,'payment_fee');
		$paypal->receiver_id = 				getValueSafe($_POST,'receiver_id');
		$paypal->txn_type = 				getValueSafe($_POST,'txn_type');
		$paypal->mc_gross = 				getValueSafe($_POST,'mc_gross');
		$paypal->mc_currency = 			getValueSafe($_POST,'mc_currency');
		$paypal->test_ipn = 					getValueSafe($_POST,'test_ipn');
		$paypal->transaction_subject = getValueSafe($_POST,'transaction_subject');
		$paypal->payment_gross = 		getValueSafe($_POST,'payment_gross');
		$paypal->ipn_track_id = 			getValueSafe($_POST,'ipn_track_id');

		$paypal->adjustEncode( getValueSafe($_POST,'charset'));
		$paypal->logPostData($_POST);

    	$error = error_get_last();
    	if ( $error) {
    		LogController::ipn_trace($error['message']);

    	} else {

    		$db_error = FALSE;
    		$txnId = ( $parent_txn_id != NULL ? $parent_txn_id : $transaction_id);

    		$dbm_ppm = new PaymentPaypalMapper(Config::getPDO());
    		$dbm_ppm->beginTransaction();

			try {

				LogController::ipn_trace("transaction_id = ${transaction_id},  parent_txn_id = ${parent_txn_id}, try - ");

				$paypal_db = $dbm_ppm->isExists($txnId);

				if ( $paypal_db) {
					LogController::ipn_trace("UPDATE transaction_id = ${txnId}");
					$paypal->txn_id = $txnId;
					if ( $parent_txn_id) {
						$paypal->mc_gross += $paypal_db->mc_gross;
					} else {
						$paypal->mc_gross = $paypal_db->mc_gross;
					}
					$dbm_ppm->update($paypal);
				} else {
					LogController::ipn_trace("INSERT");
					$dbm_ppm->insert($paypal);
				}

				$dbm_ppm->commit();
				LogController::ipn_trace("success!");

			} catch ( Exception $ex) {

				$db_error = TRUE;
				$dbm_ppm->rollback();

				LogController::ipn_trace( $ex->getMessage());
				LogController::ipn_trace( $ex->getTraceAsString());
			}

			if ( $db_error == FALSE) {

				$dbm_cm = new ContractMapper(Config::getPDO());
				$contract = $dbm_cm->findByPayPalTxnId($txnId);

				if ( $contract) {

					if ( $paypal->payment_status == STATUS_COMPLETED) {

						$ulc = new UserLibController();
						$ulc->resolveUserAndStatus($contract,STATUS_COMPLETED);

						LogController::ipn_trace("done.");

					} else {
						$contract->status = $paypal->payment_status;
					}

					LogController::ipn_trace("contract status = ".$contract->status);

					if ( $contract->status == STATUS_REFUNDED) {

						$tx = new TxController();
						$tx->combineData($contract);

						if ( $tx->sendStateChangeMail($contract->status,$contract)) {
							LogController::ipn_trace("mail sent.");

						} else {
							LogController::ipn_trace("send mail skipped.");
						}
					}

					if ( empty($contract->user_id)) {
						$dbm_cm->updateStatus($contract);
					} else {
						$dbm_cm->update($contract);
					}
				}

			}
    	}

	} else {
		LogController::ipn_trace("Unknown IPN Transaction ID: '${transaction_id}'");
	}

	LogController::ipn_trace("process end.");

    // Send an email announcing the IPN message is VERIFIED
/*
    $mail_From    = "IPN@example.com";
    $mail_To      = "Your-eMail-Address";
    $mail_Subject = "VERIFIED IPN";
    $mail_Body    = $req;
    mail($mail_To, $mail_Subject, $mail_Body, $mail_From);
   */
} else if (strcmp ($res, "INVALID") == 0) {
    // IPN invalid, log for manual investigation
    //echo "The response from IPN was: <b>" .$res ."</b>";
    LogController::ipn_trace("The response from IPN was: ${res}");

    // Send an email announcing the IPN message is INVALID
/*
    $mail_From    = "IPN@example.com";
    $mail_To      = "Your-eMail-Address";
    $mail_Subject = "INVALID IPN";
    $mail_Body    = $req;

    mail($mail_To, $mail_Subject, $mail_Body, $mail_From);
    */

}
?>
