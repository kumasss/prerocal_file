<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/controller');
$classLoader->registerDir(dirname(__FILE__) . '/view');

//アクセスログ同期処理
$controller =  new IndexController();
$controller->update();

$view = new View(__FILE__);
$view->display();
