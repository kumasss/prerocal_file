<?php
require_once (dirname(__FILE__).'/../resources/mockdata.inc');

class ProductController {

	protected function getRandomCode(){

		$strList = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

		mt_srand((int)(microtime(true)*1000000));

		$r = mt_rand(ID_RAND_MIN_LEN,ID_RAND_MAX_LEN);

		$result = null;

		for($i=1 ; $i<=$r ; $i++){
			$result .= $strList[mt_rand(0, strlen($strList) - 1)];
		}

		return $result;
	}

	function generateId() {

		$dbm = new ProductMapper(Config::getPDO());

		for($i=0;$i<ID_CREATION_RETRY;$i++) {
			$code = $this->getRandomCode();
			if ( $dbm->isExistsRowId($code) == NULL) {
				return $code;
			}
		}
		return null;
	}

	function generateVersionNumber($id) {
		$dbm = new ProductMapper(Config::getPDO());
		$product = $dbm->findMaxVersion($id);

		return $product->version + 1;
	}

	function checkAccess($product) {

		if ( $product->sales_option == SALES_OPT_USER_ONLY) {
			$referer = $_SERVER["HTTP_REFERER"];
			$needle = URL."/admin/payment";
			return strpos( $referer, $needle, 0) === 0;
				return false;
		} else {
			return true;
		}
	}
}
