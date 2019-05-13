<?php
 session_start(); require_once(dirname(__FILE__).'/../../../common/config.ini'); require_once(dirname(__FILE__).'/../../../common/users.php'); require_once(dirname(__FILE__).'/../../../common/builders.php'); $usersObj = new users(); $buildersObj = new builders(); if( $usersObj->get_auth_session( $_SESSION, $user )) { if( $usersObj->db_login( $user['email'], $user['password'], $auth=ADMIN_ROLL, $user )) { session_regenerate_id( TRUE ); } else { $usersObj->session_dell(); } } else { header( 'Location:'.URL.'/admin/' ); } if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $buildersObj->get_data($_REQUEST, $form_data); (!isset($form_data['status'])) ? $form_data['status'] = '':NULL; } switch ($form_data['status']) { case 'add': require_once( 'add.php'); break; case 'add_done': $usersObj->check_word_count( $form_data['formtitle'], 1000 ); $err = $usersObj->get_err(); if( empty( $err )) { $buildersObj->db_add_inquirys( $form_data ); } else { require_once( 'add.php'); break; } header( 'Location:'.URL.'/admin/builders/tp_inquirys_menu/' ); break; case 'edit': if( $buildersObj->get_inquirys( $form_data['id'], $form_data )) { } $form_data['status'] = 'edit'; require_once( 'edit.php'); break; case 'edit_done': $usersObj->check_word_count( $form_data['formtitle'], 1000 ); $err = $usersObj->get_err(); if( empty( $err )) { $buildersObj->db_edit_inquirys_formtitle( $form_data ); } else { require_once( 'edit.php' ); break; } header( 'Location:'.URL.'/admin/builders/tp_inquirys_menu/' ); break; case 'delete': $buildersObj->db_delete_inquirys( $form_data['id'] ); $usersObj->unlinkRecursive( dirname(__FILE__).'/../tp_inquirys/edit_item/data'.$form_data['id'], TRUE); header( 'Location:'.URL.'/admin/builders/tp_inquirys_menu/' ); break; default: $start = 0; $num = 100; if( !$buildersObj->get_all_inquirys( $data, $start, $num )) { $message = "メールフォームが登録されていません。"; } $form_data['status'] = 'default'; require_once( 'list.php'); break; } ?>