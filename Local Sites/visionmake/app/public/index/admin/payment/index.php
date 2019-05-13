<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir( dirname(__FILE__)  . '/config');
$classLoader->registerDir( dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/view');

$view = new View(__FILE__);

$dbm = new SellerSettingMapper(Config::getPDO());
list($paypalApiState,$paypalApiStateColor) = $dbm->toStringPayPayApiState();

$view->assign('ppapi_state',$paypalApiState);
$view->assign('ppapi_state_col',$paypalApiStateColor);

$view->display();
