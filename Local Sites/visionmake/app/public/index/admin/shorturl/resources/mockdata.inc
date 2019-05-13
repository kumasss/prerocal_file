<?php
session_start();
require_once (dirname(__FILE__).'/../../../common/config.ini');
require_once (dirname(__FILE__).'/../../../common/users.php');

$usersObj = new users();

if( $usersObj->get_auth_session( $_SESSION, $user ))
{
	if( $usersObj->db_login( $user['email'], $user['password'], $auth=ADMIN_ROLL, $user ))
	{
		session_regenerate_id( TRUE );
	} else {
		$usersObj->session_dell();
	}
} else {
	header( 'Location:'.URL.'/admin/' );
}

define('SHORT_URL_BASE', URL . '/cf/' );

define('RAND_MIN_LEN',1);
define('RAND_MAX_LEN',8);
define('URL_CREATION_RETRY',5);


$sort_types = array(
	'登録順'
	,'カテゴリー順'
	,'タイトル順'
	,'URL'
	,'短縮URL'
	,'クリック数の多い順'
	,'アクセス数の多い順'
);


?>