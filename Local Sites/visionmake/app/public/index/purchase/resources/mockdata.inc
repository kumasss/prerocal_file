<?php
session_start();
require_once (dirname(__FILE__).'/../../common/config.ini');
require_once (dirname(__FILE__).'/../../common/users.php');
require_once (dirname(__FILE__).'/../../authorize.php');

if ( isAuthAlive() == true) {
	$usersObj = new users();
	$email = htmlspecialchars($_SESSION[SESSION_USER_ID]);
	$id = $usersObj->get_user_id( $email );
	$usersObj->db_set_user( $id );
	$user = $usersObj->db_get_user();
	if ( empty($user)) {
		header( 'Location:'.URL);
		exit;
	}
}

require_once 'framework.inc';

?>