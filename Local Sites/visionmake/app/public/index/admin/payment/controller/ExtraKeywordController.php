<?php
require_once (dirname(__FILE__).'/../config/Config.php');

class ExtraKeywordController {

	function createItemUrl( $responseFlag, $product, $contract, $type, $txn_id) {

		$itemUrl = '';

		if ( $responseFlag->mail_content_url ||
				$responseFlag->mail_content_url_free) {
/*
				if ( $product->after_url) {
					$itemUrl .= sprintf("\nご注文商品ページURL:%s",$product->after_url);
				}
*/
				$content_url = sprintf("%s/purchase/%s.php?id=%s&order=%s",URL,$type,$contract->product_id,$txn_id);
				$itemUrl .= sprintf("\nご注文確認および登録ページURL：\n%s",$content_url);
		}
/*
		if ( $responseFlag->mail_regist_url) {
			if ( $product->register_url) {
				$itemUrl .= sprintf("\n登録ページURL：\n%s",$product->register_url);
			}
		}
*/
		return $itemUrl;
	}
}
?>
