<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/controller');
$classLoader->registerDir(dirname(__FILE__) . '/view');

$dbm = new CategoryMapper(Config::getPDO());

$records = array();

if ( $_SERVER["REQUEST_METHOD"] == "POST") {

 	if ( ! ( isset($_SERVER['HTTP_X_REQUESTED_WITH'])
 			&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
 			&& ( !empty($_SERVER['SCRIPT_FILENAME']) && 'category.php' === basename($_SERVER['SCRIPT_FILENAME']))
 	)
 	{
 		//restrict to direct access
 		exit;
 	}

 	//for json data
 	$json_string = file_get_contents('php://input');

 	$params = json_decode($json_string,TRUE);

 	$ins_data = NULL;
 	$up_data = NULL;
 	$del_data = NULL;

 	$controller = new CategoryController();

 	foreach ($params as $datalist) {

 		$row_data = NULL;
 		foreach ( $datalist as $item) {
 			$row_data[$item['name']] = $item['value'];
 		}

 		$c = new Category();
 		$c->fromArray($row_data);

	 	if ( $c->id === 0) {
			if (  trim($c->name) != '') {
			$ins_data[] = $c;
 			}
		} else {
	 		if ( $c->row === 0) {
 				$del_data[] = $c;
 			} else  {
		 	 	if (  $c->name) {
					$up_data[] =  $c;
 				}
	 		}
	 	}
 	}

 	$controller->update($ins_data,$up_data,$del_data);

 	//---

	$records = $dbm->findAll();
	if (  !is_array($records)) {
		$records = array();
	}

} else if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$records = $dbm->findAll();
	if (  !is_array($records)) {
		$records = array();
	}

// 	foreach ($records as $c) {
// 		$c->description = str_replace(array("\r\n","\r"), "<br/>", $c->description);
// 	}
}

array_push( $records, new Category());

$view = new View(__FILE__);
$view->assign('records',$records);


$view->display();

exit();
