<?php
 session_start(); require_once( dirname(__FILE__).'/../../../common/config.ini' ); require_once( dirname(__FILE__).'/../../../common/users.php' ); require_once( dirname(__FILE__).'/../../../common/builders.php' ); $usersObj = new users(); $buildersObj = new builders(); if( $usersObj->get_auth_session( $_SESSION, $user )) { if( $usersObj->db_login( $user['email'], $user['password'], $auth=ADMIN_ROLL, $user )) { session_regenerate_id( TRUE ); } else { $usersObj->session_dell(); } } else { header( 'Location:'.URL.'/admin/' ); } if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $buildersObj->get_data($_REQUEST, $form_data); (!isset($form_data['status'])) ? $form_data['status'] = '':NULL; } if(empty($form_data['id'])) { $form_data['id'] = 1; $_SESSION['id'] = 1; } switch ($form_data['status']) { case 'edit_info': if( !$buildersObj->get_inquirys( $form_data['id'], $form_data )) { exit("err!! inquirys no data."); } $form_data['status'] = 'edit_info'; require_once( 'edit_info.php'); break; case 'edit_info_done': $buildersObj->db_edit_inquirys_info( $form_data ); $message = '更新しました。'; $form_data['status'] = 'edit_info'; require_once( 'edit_info.php'); break; case 'edit': if( !$buildersObj->get_inquirys( $form_data['id'], $form_data )) { exit("err!! inquirys no data."); } $form_data['status'] = 'edit'; require_once( 'edit.php'); break; case 'edit_done': $buildersObj->check_input_inquirys( $form_data ); $err = $buildersObj->get_err(); if( empty( $err )) { $buildersObj->db_edit_inquirys( $form_data ); } else { require_once( 'edit.php'); break; } $message = '更新しました。'; $form_data['status'] = 'edit'; require_once( 'edit.php'); break; case 'edit_item': $form_data['status'] = 'edit_item'; require_once( dirname(__FILE__).'/edit_item/edit_item.php'); break; case 'edit_item_done': $message = '更新しました。'; require_once( dirname(__FILE__).'/edit_item/edit_item.php'); break; case 'search': $form_data['status'] = 'search'; require_once( dirname(__FILE__).'/edit_item/search.php'); break; case 'edit_form': if( !$buildersObj->get_inquirys( $form_data['id'], $form_data )) { exit("err!! inquirys no data."); } $form_data['status'] = 'edit_form'; require_once( 'edit_form.php'); break; case 'edit_form_done': $buildersObj->check_input_inquirys_form( $form_data ); $err = $buildersObj->get_err(); if( empty( $err )) { $buildersObj->db_edit_inquirys_form( $form_data ); } else { require_once( 'edit_form.php'); break; } $message = '更新しました。'; $form_data['status'] = 'edit_form'; require_once( 'edit_form.php'); break; default: if( !$buildersObj->get_all_inquirys( $inquirys_data )) { $err['inquirys'] = "自動返信メールが登録されていません。"; } $form_data['status'] = 'default'; require_once( 'list.php'); break; } ?>