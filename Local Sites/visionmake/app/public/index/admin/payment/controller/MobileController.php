<?php
class MobileController {

	static function isSmartPhone() {
		$smartPhone = FALSE;
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if ( ( strpos($ua,'iPhone') !== false) || ( strpos($ua,'iPod') !== false) || ( strpos($ua,'Android') !== false)) {
			$smartPhone = TRUE;
		}
		return $smartPhone;
	}

	static function isAppleSmartPhone() {
		$smartPhone = FALSE;
		$ua = $_SERVER['HTTP_USER_AGENT'];
		if ( ( strpos($ua,'iPhone') !== false) || ( strpos($ua,'iPod') !== false)) {
			$smartPhone = TRUE;
		}
		return $smartPhone;
	}
}