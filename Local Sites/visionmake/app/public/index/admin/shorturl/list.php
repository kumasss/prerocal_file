<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/controller');
$classLoader->registerDir(dirname(__FILE__) . '/view');

$dbm = new ShortUrlMapper(Config::getPDO());

$records = array();

if ( $_SERVER["REQUEST_METHOD"] == "POST") {

	if ( @$_POST['action'] != '') {

		$array = array();

		if ( $_POST['action'] == 'delete') {

			foreach ( explode(',',$_POST['codes']) as $code) {
				$obj = new ShortUrl();
				$obj->short_code = $code;
				array_push($array, $obj);
			}

			$dbm->delete($array);

		} else if ( is_numeric($_POST['action'])) {

			$category_id = intval($_POST['action']);

			foreach ( explode(',',$_POST['codes']) as $code) {
				$obj = new ShortUrl();
				$obj->group_code = $category_id;
				$obj->short_code = $code;
				array_push($array, $obj);
			}

			$dbm->updateCategory($array);
		}

		$records = $dbm->findByCondition($_POST);
		if (  !is_array($records)) {
			$records = array();
		}

	}

} else if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$records = $dbm->findByCondition(@$_GET);
	if (  !is_array($records)) {
		$records = array();
	}
}

$dbm = new CategoryMapper(Config::getPDO());
$categories = $dbm->findAll();

$actions['nop1'] = '---------';
$category_map = array();
foreach ($categories as $c) {
	$actions[$c->id] = $c->name.'&nbsp;に変更';
	$category_map[$c->id] = $c;
}
$actions['nop2'] = '---------';
$actions['delete'] = '削除';

$view = new View(__FILE__);
$view->assign('records',$records);
$view->assign('categories',$categories);
$view->assign('category_map',$category_map);
$view->assign('sort_types',$sort_types);
$view->assign('action_menus',$actions);

$view->display();

exit();
