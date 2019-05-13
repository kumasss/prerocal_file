<?php
require_once (dirname(__FILE__).'/../config/Config.php');

class LogController {

	static function ipn_trace($log) {
		if ( defined ('DEBUG_OUT')) {
			error_log(PHP_EOL."IPN: ".$log,3,sys_get_temp_dir() ."/lt_ipn_trace.log");
		}
	}

	static function paypal_trace($log) {
		if ( defined ('DEBUG_OUT')) {
			error_log(PHP_EOL."PAYPAL: ".$log,3,sys_get_temp_dir() ."/lt_paypal_trace.log");
		}
	}

	static function api_trace($log) {
		if ( defined ('DEBUG_OUT')) {
			error_log(PHP_EOL."API: ".$log,3,sys_get_temp_dir() ."/lt_api.log");
		}
	}

	static function debug($log) {
		if ( defined ('DEBUG_OUT')) {
			error_log(PHP_EOL."DEBUG: ".$log,3,sys_get_temp_dir() ."/lt_debug.log");
		}
	}
}