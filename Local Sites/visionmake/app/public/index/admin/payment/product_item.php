<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/view');


$editdata = new Product();

$dbm = new ProductMapper(Config::getPDO());

if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$id = @$_GET['pid'];
	if ($id) {
		$data = $dbm->findById($id);
		if ( $data) {
			$editdata = $data;
		}
	}

	$view = new View(__FILE__);

	$view->assign('editdata',$editdata);

	$view->display();

}
else if ( $_SERVER["REQUEST_METHOD"] == "POST") {

	$data = $_POST;

	if ( $_POST['command'] == 'update') {

		unset($data['command']);

		$editdata->fromArray($data);
		$dbm->updateForSubitem($editdata);

		header( 'Location:'.URL.'/admin/payment/' );

	} else if (  $_POST['command'] == 'delete') {

		unset($data['command']);

		$editdata->fromArray($data);
		$dbm->delete($editdata);

		header( 'Location:'.URL.'/admin/payment/' );
	}
	exit;

}
