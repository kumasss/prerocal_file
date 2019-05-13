<?php
require_once (dirname(__FILE__).'/../../common/config.ini');

date_default_timezone_set('Asia/Tokyo');

define('COMMON_PAYMENT_URL', dirname(__FILE__) . '/../../admin/payment');

require_once COMMON_PAYMENT_URL. '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir( COMMON_PAYMENT_URL . '/config');
$classLoader->registerDir( COMMON_PAYMENT_URL . '/model');
$classLoader->registerDir( COMMON_PAYMENT_URL . '/controller');
$classLoader->registerDir( COMMON_PAYMENT_URL . '/view');

define('ID_RAND_MIN_LEN',16);
define('ID_RAND_MAX_LEN',16);
define('ID_CREATION_RETRY',5);

?>
