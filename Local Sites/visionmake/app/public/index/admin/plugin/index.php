<?php
 session_start(); require_once(dirname(__FILE__).'/../../common/config.ini'); require_once(dirname(__FILE__).'/../../common/users.php'); require_once(dirname(__FILE__).'/../../common/builders.php'); $usersObj = new users(); $buildersObj = new builders(); if( $usersObj->get_auth_session( $_SESSION, $user )) { if( $usersObj->db_login( $user['email'], $user['password'], $auth=ADMIN_ROLL, $user )) { session_regenerate_id( TRUE ); } else { $usersObj->session_dell(); } } else { header( 'Location:'.URL.'/admin/' ); } if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $usersObj->get_data($_REQUEST, $form_data); (!isset($form_data['status'])) ? $form_data['status'] = '':NULL; } switch ($form_data['status']) { default: $plugin['name'] = ""; $plugin['text'] = ""; $buildersObj->do_plugin( $data="", $plugins ); $form_data['status'] = 'default'; require_once( 'list.php'); break; } ?>