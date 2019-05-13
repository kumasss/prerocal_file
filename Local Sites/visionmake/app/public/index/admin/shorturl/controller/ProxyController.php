<?php
require_once 'resources/mockdata.inc';

class ProxyController {
	function toJson($status,$title,$code) {
		return json_encode(
				array(
						'status' => $status
						,'title' => $title
						,'code' => $code
				)
		);
	}

	function getRandomCode(){

		$strList = '0123456789abcdefghijklmnopqrstuvwxyz';

		mt_srand((int)(microtime(true)*1000000));

		$r = mt_rand(RAND_MIN_LEN,RAND_MAX_LEN);

		$result = null;

		for($i=1 ; $i<=$r ; $i++){
			$result .= $strList[mt_rand(0, strlen($strList) - 1)];
		}

		return $result;
	}

	//URLベース＋ランダムコードでユニークとする
	function createUniqueUrlCode() {

		$dbm = new ShortUrlMapper(Config::getPDO());

		for($i=0;$i<URL_CREATION_RETRY;$i++) {
			$code = $this->getRandomCode();
			if ( $dbm->findByCode($code) == NULL) {
				return $code;
			}
		}
		return null;
	}

	function getShortCode() {
		$code = $this->createUniqueUrlCode();
		return $this->toJson('200', '', $code);
	}

	//根本的に動作しないときはallow_url_fopenがOnか確認
	//もしくは、extension=php_openssl.dllか確認
	function getSiteTitleAndShortCode($url) {

		$ctx = stream_context_create(
			array(
				'http' => array(
							'header'=>"Content-Type: text/html; charset=utf-8"
							,'ignore_errors' => true
							,'timeout' => 60
						)
			)
		);

		$response = file_get_contents($url, false, $ctx);

		preg_match('/HTTP\/1\.[0|1|x] ([0-9]{3})/', $http_response_header[0], $matches);
		$status_code = $matches[1];

		$title = "";
		$code = "";
		switch ($status_code) {
			case '200':
				if ( $response != null) {
					if ( preg_match('/<title>(.*)<\/title>/',$response,$title_mathes)) {
						$title = mb_convert_encoding( $title_mathes[1], 'UTF-8', mb_detect_encoding($title_mathes[1],"UTF-8, eucjp-win, sjis-win, JIS"));
						$code = $this->createUniqueUrlCode();
					}
				}
				break;
			case '404':
				break;
			default:
				break;
		}
		return $this->toJson($status_code, $title, $code);
	}
}
