<?php
require_once 'resources/mockdata.inc';

require_once dirname(__FILE__) . '/ClassLoader.php';

$classLoader = new ClassLoader();
$classLoader->registerDir(dirname(__FILE__) . '/config');
$classLoader->registerDir(dirname(__FILE__) . '/model');
$classLoader->registerDir(dirname(__FILE__) . '/view');

$dbm = new ApiAccessLogMapper(Config::getPDOAssoc());

$records = array();

if ( $_SERVER["REQUEST_METHOD"] == "GET") {

	$code = @$_GET['code'];
	if ( $code != NULL) {
		$year = @$_GET['y'];
		$month = @$_GET['m'];
		$day = @$_GET['d'];

		if ( $year != NULL && $month != NULL && $month != NULL) {

			$by_hour = array();
			for ($i=0; $i<24; $i++) {
				$by_hour[$i] = array(
					 'shortcode'	=> $code
					,'year'			=> $year
					,'month'		=> $month
					,'day'				=> $day
					,'hour'			=> $i
					,'click' 			=> '0'
					,'access'		=> '0'
					,'ratio'			=> '0'
				);
			}

			$records = $dbm->findHoursSummary($code,$year,$month,$day);

			foreach ( $records as $i=>$rec) {
				$by_hour[$rec['hour']] = $rec;
			}

			$by_hour = array_reverse($by_hour);
		}
	}
}


$view = new View(__FILE__);
$view->assign('records',$by_hour);
$view->display();
