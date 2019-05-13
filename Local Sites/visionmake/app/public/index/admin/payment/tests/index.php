<?php
require_once '../resources/mockdata.inc';

require_once dirname(__FILE__) . '/../ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/../model');
$classLoader->registerDir(dirname(__FILE__) . '/../controller');


$tx = new TxController();

$case = @$_GET['case'];

if ( $case == 0) {

	for($i=0;$i<100;$i++) {
		echo "<br/>".TxController::generateTxnId();
	}

} else if ( $case == 1) {

	echo "function 'TxController::send_login_mail' has been removed.";

} else if ( $case == 2) {

	$contract = new Contract();
	$contract->title = "商品タイトル";
	$contract->txn_id = "5N054989PY846103Y";
	$contract->bank_txn_id = "201409084065";
	$contract->price = "19800";
	$contract->order_time ="2014-10-1";
	$contract->bank_tr_deadline =10;

	$contract->bank_buyer_transfer_date = "2014-9-30";
	$contract->bank_account_name = "フリコミ　ジロウ";

	$contract->first_name = "太郎";
	$contract->last_name = "ペイパル";
	$contract->payer_email = "taro@cyfons.com";

	$bank_contents = <<< BANK
	[銀行振込の購入者宛てメール]
		注文日：%order_time%
		取引ID：%bank_txn_id%

		商品名：%title%
		価格：%price%円（税込）

		振込予定日：%bank_buyer_transfer_date%
		振込期日：%deadline_date%
		口座名義人：%bank_account_name%
BANK;

	$tx->applyWord($contract, $bank_contents);

	$e = error_get_last();
	if ( $e) {
		var_dump($e);
	} else {
		var_dump($bank_contents);
	}

	$paypal_contents = <<< PAYPAL
	[PAYPAL決済の購入者宛てメール]
		注文日：%order_time%
		取引ID：%txn_id%

		商品名：%title%
		価格：%price%円（税込）

		申込者名（名）：%first_name%
		申込者名（姓）：%last_name%
		メールアドレス：%payer_email%
PAYPAL;

	$tx->applyWord($contract, $paypal_contents);

	$e = error_get_last();
	if ( $e) {
		var_dump($e);
	} else {
		var_dump($paypal_contents);
	}

} elseif ( $case == 3) {

	/*
	 * http://localhost/cyfons/admin/payment/txtest.php?case=3&total=21&onpage=20&offset=1
	 * start index = 0, total = 20
	 *
	 * http://localhost/cyfons/admin/payment/txtest.php?case=3&total=21&onpage=20&offset=2
	 * start index = 20, total = 1
	 */

	$totalCount = 300;
	if ( isset( $_GET['total'])) {
		$totalCount = $_GET['total'];
	}

	$all_contracts = array();

	if ( intval($totalCount) > 0) {
		for ($i=0;$i<$totalCount; $i++) {
			$all_contracts[] = "$i";
		}
	}

	$itemsOnPage = $totalCount;
	if ( isset( $_GET['onpage'])) {
		$itemsOnPage = $_GET['onpage'];
	}

	$offset = 1;
	if ( isset( $_GET['offset'])) {
		$offset = $_GET['offset'];
	}

	$startIndex = $itemsOnPage * ( $offset - 1);

	$page_array = array_slice($all_contracts,$startIndex,$itemsOnPage);

	echo sprintf("<p>start index = %d<p>",$startIndex);
	echo sprintf("<p>total = %d<p>",count($page_array));

	if ( count($page_array) < 100) {
		var_dump($page_array);
	}


}

exit;

