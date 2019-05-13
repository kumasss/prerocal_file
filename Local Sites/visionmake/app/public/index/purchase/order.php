<?php
require_once 'resources/mockdata.inc';

require_once ("paypal_settings.php");

require_once ("paypalfunctions.php");

$PaymentOption = "PayPal";
if ( $PaymentOption == "PayPal")
{
	$notifyURL =  URL . "/purchase/ipn_listener.php";

	// ==================================
	// PayPal Express Checkout Module
	// ==================================

	//'------------------------------------
	//' The paymentAmount is the total value of
	//' the purchase.
	//'
	//' TODO: Enter the total Payment Amount within the quotes.
	//' example : $paymentAmount = "15.00";
	//'------------------------------------

	$paymentAmount = $_POST['payment_amount'];


	//'------------------------------------
	//' The currencyCodeType
	//' is set to the selections made on the Integration Assistant
	//'------------------------------------
	$currencyCodeType = "JPY";
	$paymentType = "Sale";

	//'------------------------------------
	//' The returnURL is the location where buyers return to when a
	//' payment has been succesfully authorized.
	//'
	//' This is set to the value entered on the Integration Assistant
	//'------------------------------------
	$returnURL = URL . "/purchase/order_confirm.php";

	//'------------------------------------
	//' The cancelURL is the location buyers are sent to when they hit the
	//' cancel button during authorization of payment during the PayPal flow
	//'
	//' This is set to the value entered on the Integration Assistant
	//'------------------------------------
	$cancelURL = URL . "/purchase/?id=".@$_POST['number'];

	//'------------------------------------
	//' Calls the SetExpressCheckout API call
	//'
	//' The CallSetExpressCheckout function is defined in the file PayPalFunctions.php,
	//' it is included at the top of this file.
	//'-------------------------------------------------


	$items = array();
	$items[] = array('name' => $_POST['name'], 'number'=> $_POST['number'], 'amt' => $paymentAmount, 'qty' => 1);

	//::ITEMS::

	// to add anothe item, uncomment the lines below and comment the line above
	// $items[] = array('name' => 'Item Name1', 'amt' => $itemAmount1, 'qty' => 1);
	// $items[] = array('name' => 'Item Name2', 'amt' => $itemAmount2, 'qty' => 1);
	// $paymentAmount = $itemAmount1 + $itemAmount2;

	// assign corresponding item amounts to "$itemAmount1" and "$itemAmount2"
	// NOTE : sum of all the item amounts should be equal to payment  amount

	$resArray = SetExpressCheckoutDG( $paymentAmount, $currencyCodeType, $paymentType,
			$returnURL, $cancelURL, $notifyURL, $items );

	$ack = strtoupper($resArray["ACK"]);
	if($ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING")
	{
		$token = urldecode($resArray["TOKEN"]);
		if ( MobileController::isAppleSmartPhone()) {
			RedirectToPayPalMini( $token );
		} else {
			//RedirectToPayPalDG( $token );
			RedirectToPayPal( $token );
		}
	}
	else
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
/*
		echo "SetExpressCheckout API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
*/
		$error = "\n\nDoExpressCheckoutDetails API 呼び出しエラーが発生しました:\n";
		$error .= ($settings->api_sandbox_mode)?"\n【サンドボックス状態】\n":"";
		$error .= "\nDetailed Error Message: " . $ErrorLongMsg;
		$error .= "\nShort Error Message: " . $ErrorShortMsg;
		$error .= "\nError Code: " . $ErrorCode;
		$error .= "\nError Severity Code: " . $ErrorSeverityCode;

		LogController::paypal_trace( $error);

		$view = new View( dirname(__FILE__).'/order_error.php');
		$view->assign("productId",@$_POST['number']);
		$view->assign('smartPhone', MobileController::isSmartPhone());
		$view->assign("error",$error);
		$view->display();

		exit;

	}
}

?>
