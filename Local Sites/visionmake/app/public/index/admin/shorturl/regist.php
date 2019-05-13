<?php
require_once 'resources/mockdata.inc';

require dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/controller');

if ( ! ( isset($_SERVER['HTTP_X_REQUESTED_WITH'])
			&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
			&& ( !empty($_SERVER['SCRIPT_FILENAME']) && 'regist.php' === basename($_SERVER['SCRIPT_FILENAME']))
		)
{
	//restrict to direct access
	exit;
}

//for json data
$json_string = file_get_contents('php://input');

$params = json_decode($json_string,TRUE);

$data = array();
foreach ($params as $value) {
	$data[$value['name']] = $value['value'];
}

$mapper = new ShortUrlMapper(Config::getPDO());
$shortUrlObj = new ShortUrl();
$shortUrlObj->fromArray($data);

$status = 0;

if ( $shortUrlObj->long_url != null) {
	$matcher = sprintf("/%s/",preg_quote(SHORT_URL_BASE,'/'));
	if ( preg_match( $matcher, $shortUrlObj->long_url)) {
		$status = 4;
	}
}

if ( $status == 0) {

	$lastShortCode = @$data['last_short_code'];
	if ( $lastShortCode != NULL) {
		$r = $mapper->findByCode($lastShortCode);
		if ( !empty($r)) {
			$shortUrlObj->short_code = $lastShortCode;
			$mapper->update($r->id,$shortUrlObj);
			$status = 2;
		}
	} else {
		if ( $shortUrlObj->short_code != NULL
				 && $shortUrlObj->auto_short_code == NULL) {
			//手動入力による短縮コードの場合、重複チェックする
			$r = $mapper->findByCode($shortUrlObj->short_code);
			if (!empty($r)) {
				$status = 3;
			}
		}
		if ( $status == 0) {
			$mapper->insert($shortUrlObj);
			$status = 1;
		}
	}
}

header('Content-Type: application/json');
echo json_encode( array("status"=>$status));
