<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/controller');

$controller = new ProxyController();

$access_url = @$_GET['url'];
if ( $access_url != null) {

	header('Access-Control-Allow-Origin:'.URL);
	header('Access-Control-Allow-Credentials:true');
	header('Content-Type:text/plain;charset=UTF-8');

	echo $controller->getSiteTitleAndShortCode($access_url);

} else {

	echo $controller->getShortCode();
}

exit();
