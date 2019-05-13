<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/controller');
$classLoader->registerDir(dirname(__FILE__) . '/view');


$userId = @$user['id'];

$records = array();

$dbm = new ProductMapper(Config::getPDO());

if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$data = $dbm->findAll();
	if ( $data) {
		$records = $data;
	}

}
else if ( $_SERVER["REQUEST_METHOD"] == "POST") {

	$pid = @$_POST['pid'];
	$action = @$_POST['action'];

	$product = $dbm->findById($pid);

	if( $action == 'copy') {
		//コピー追加
		$controller = new ProductController();
		$id = $controller->generateId();
		if ( $id == NULL) {
			header('HTTP', true, 500);
			exit;
		}
		$product->id = $id;
		$product->unit_id = $id;
		$product->title = $product->title."（コピー）";
		$dbm->insert($product);

	} else if ( $action == 'delete') {
		$p = new Product();
		$p->id = $pid;
		$dbm->delete($p);
	}

	$data = $dbm->findAll();
	if ( $data) {
		$records = $data;
	}
}

$grouped_records = array();
foreach ($records as $product) {
	if ( $product->id == $product->unit_id) {
		$grouped_records[ $product->id] = $product;
	}
}


$view = new View(__FILE__);

$view->assign('records',$grouped_records);

$view->display();

exit();
