<?php

require_once (dirname(__FILE__).'/../../../common/config.ini');

/***** 取引関連定義 *****/

define('PRD_GRP_NONE', 0);
define('PRD_GRP_SELECTED_OFF', 1);
define('PRD_GRP_SELECTED_ON', 2);


define('SALES_OPT_USER_FREE', 0);
define('SALES_OPT_NEW_USER_ONLY', 1);
define('SALES_OPT_USER_ONLY', 2);
define('SALES_OPT_USER_NEED', 3);

define('PAYPAL_PENDING_REASON','None');

define('STATUS_COMPLETED','Completed');
define('STATUS_UNKNOWN','Unknown');
define('STATUS_REFUNDED','Refunded');
define('STATUS_UNCONFIRMED','Unconfirmed');
define('STATUS_CANCELED','Canceled');

define('ORDER_STATE_NONE','None');
define('ORDER_STATE_ORDER','Order');
define('ORDER_STATE_ORDERED','Ordered');

define('MAIL_TRANSFER','mail_transfer');
define('MAIL_COMPLETE','mail_complete');
define('MAIL_REFUND','mail_refund');

/***** 取引情報およびユーザー情報関連API定義 *****/
define('UTAPI_URL',URL.'/admin/payment/api.php');
define('UTAPI_CMD_QUERY','query');
define('UTAPI_CMD_INSERT','insert');
define('UTAPI_RESULT','result');
define('UTAPI_RESULT_OK','ok');
define('UTAPI_RESULT_NG','ng');
define('UTAPI_TEST_USER_ID',1);
define('UTAPI_TEST_ORDER_ID','TestOrderID-OK');

/**
 * PDOインスタンスを管理する関数
 *
 */
class Config {

	static function getPDO() {

			$pdo = new PDO (
					'mysql:dbname='.DB_NAME.';host='.DB_HOST,
					DB_USER,
					DB_PASSWORD,
					array(
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_CLASS,
					)
			);

			return $pdo;
	}

	static function getPDOAssoc() {

			$pdo = new PDO(
					'mysql:dbname='.DB_NAME.';host='.DB_HOST,
					DB_USER,
					DB_PASSWORD,
					array(
							PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
							PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
						)
					);

			return $pdo;
	}
}