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

define('ID_RAND_MIN_LEN',16);
define('ID_RAND_MAX_LEN',16);
define('ID_CREATION_RETRY',5);

define('PAYMENT_URL', URL . '/purchase/index.php' );

?>