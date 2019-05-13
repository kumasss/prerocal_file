<?php
require_once ("paypal_settings.php");

$product = NULL;
global $user;


if ( $_SERVER["REQUEST_METHOD"] == "POST") {

	$productId = @htmlspecialchars( $_POST['product_id']);

	if ( $productId ) {

		$dbm_set = new SellerSettingMapper(Config::getPDO());
		$settings = $dbm_set->findByLastId();

		$dbm = new ProductMapper(Config::getPDO());
		$product = $dbm->findById($productId);

		$bank = new PaymentBank();
		$bank->bank_account_name = htmlspecialchars($_POST['bank_account_name']);
		$bank->bank_payment_amount =  htmlspecialchars($_POST['payment_amount']);
		$bank->bank_buyer_email = htmlspecialchars($_POST['bank_buyer_email']);
		$bank->bank_buyer_transfer_date =  htmlspecialchars( $_POST['bank_buyer_transfer_date']);

		$tx = new TxController();
		$tx->checkOrderPrivilege($product->sales_option,$bank->bank_buyer_email,ORDER_STATE_ORDER);

		$contract = new Contract();
		$contract->product_id = $productId;

		$view = new View( dirname(__FILE__).'/bank_confirm.php');

		$view->assign('settings', $settings);
		$view->assign("product",$product);
		$view->assign("contract",$contract);
		$view->assign("bank",$bank);

		$view->assign('smartPhone', MobileController::isSmartPhone());

		$view->display();

	}

} else if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$productId = @$_GET['id'];
	$retUrl = @$_COOKIE['returl'];

	if ( $retUrl) {

		header("Location:".urldecode($retUrl));
		exit;

	} elseif ( $productId) {

		$dbm = new ProductMapper(Config::getPDO());
		$product = $dbm->findById($productId);

		if ( $product) {

			$dbm_set = new SellerSettingMapper(Config::getPDO());
			$settings = $dbm_set->findByLastId();

			if ( $settings) {

				$tx = new TxController();
				$tx->checkOrderPrivilege($product->sales_option,NULL,ORDER_STATE_NONE);

				$view = new View(__FILE__);

				$view->assign('settings', $settings);
				$view->assign('product', $product);

				$view->assign('enable_paypal', SellerSetting::hasPayPalValues($settings));
				$view->assign('enable_banking', ( $product->bank_flag && SellerSetting::hasBankValues($settings)));

				$view->assign('smartPhone', MobileController::isSmartPhone());

				if (  $user && isset($user['id']) && $user['auth'] == USER_ROLL) {
					$view->assign('buyer_email',$user['email']);
				} else {
					$view->assign('buyer_email','');
				}

				$view->display();
			}
		}
	}
}

