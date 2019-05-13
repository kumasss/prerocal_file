<?php

require_once ("paypal_settings.php");

/* =====================================
 *	 PayPal Express Checkout Call
 * =====================================
 */

require_once ("paypalfunctions.php");

$PaymentOption = "PayPal";
if ( $PaymentOption == "PayPal" )
{
	if ( $_SERVER['REQUEST_METHOD'] == 'GET') {
		/*
		 '------------------------------------
		 ' this  step is required to get parameters to make DoExpressCheckout API call,
		 ' this step is required only if you are not storing the SetExpressCheckout API call's request values in you database.
		 ' ------------------------------------
		 */
		$res = GetExpressCheckoutDetails( $_GET['token'] );

		$ack = strtoupper($res["ACK"]);

		if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" ) {

			/*
			 '------------------------------------
			 ' The paymentAmount is the total value of
			 ' the purchase.
			 '------------------------------------
			 */

			$email = @$res['EMAIL'];
			$productId = @$res['L_NUMBER0'];

			if ($email && $productId) {

				$dbm_pm = new ProductMapper(Config::getPDO());
				$product = $dbm_pm->findById($productId);

				$tx = new TxController();
				$tx->checkOrderPrivilege($product->sales_option,$email,ORDER_STATE_ORDER);
			}

			$view = new View(__FILE__);
			$view->assign('res',$res);

		} else {

			//Display a user friendly Error on the page using any of the following error information returned by PayPal
			$ErrorCode = @urldecode($res["L_ERRORCODE0"]);
			$ErrorShortMsg = @urldecode($res["L_SHORTMESSAGE0"]);
			$ErrorLongMsg = @urldecode($res["L_LONGMESSAGE0"]);
			$ErrorSeverityCode = @urldecode($res["L_SEVERITYCODE0"]);

			$error = "\n\nGetExpressCheckoutDetails API 呼び出しエラーが発生しました:\n";
			$error .= "\nDetailed Error Message: " . $ErrorLongMsg;
			$error .= "\nShort Error Message: " . $ErrorShortMsg;
			$error .= "\nError Code: " . $ErrorCode;
			$error .= "\nError Severity Code: " . $ErrorSeverityCode;

			LogController::paypal_trace( $error);

			$view = new View( dirname(__FILE__).'/order_error.php');
			$view->assign("productId",$res['L_NUMBER0']);
			$view->assign("error",$error);
		}

		$view->assign('smartPhone', MobileController::isSmartPhone());
		$view->display();

	}
}
