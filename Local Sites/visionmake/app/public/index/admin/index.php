<?php
 session_start(); require_once(dirname(__FILE__).'/../common/config.ini'); require_once(dirname(__FILE__).'/../common/users.php'); require_once(dirname(__FILE__).'/../common/settings.php'); $usersObj = new users(); $err = array(); $form_data = array(); if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $usersObj->get_data($_REQUEST, $form_data); (!isset($form_data['status'])) ? $form_data['status'] = '':NULL; (!isset($form_data['email'])) ? $form_data['email'] = '':NULL; (!isset($form_data['password'])) ? $form_data['password'] = '':NULL; (!isset($form_data['serial_number'])) ? $form_data['serial_number'] = '':NULL; $err['email'] = ''; } switch ($form_data['status']) { case 'login': $admin_email = $usersObj->is_admin_id(); if( !empty( $form_data['email'] )) { if (!$admin_email){ $usersObj->check_mailadd( $form_data['email'] ); } else { if (!$usersObj->login_adminid( $form_data['email'], 200 )){ $err['all'] = 'ユーザー情報が間違っています。'; require_once( 'login.php' ); break; } } } if( !empty( $form_data['password'] )) { $usersObj->check_pw( $form_data['password'] ); } $err_f = FALSE; $usersObj->check_login(); $err = $usersObj->get_err(); if( empty( $err )) { if ($admin_email) $form_data['email'] = $admin_email; if( $usersObj->db_login( $form_data['email'], sha1($form_data['password']), $auth=ADMIN_ROLL, $userdata)) { $_SESSION = array(); $usersObj->set_auth_session( $userdata ); $_SESSION['license_flg'] = ''; if( !empty( $userdata['modified'] )) { $go = $usersObj->hide2go($usersObj->chkLicense()); } else { $go = $usersObj->hide2go2($usersObj->chkLicense()); } require_once(dirname(__FILE__).'/../common/logs.php'); $logsObj = new logs(); $logsObj->check_act_mail(); require_once($go); exit; } else { $err_f = TRUE; } } else { $err_f = TRUE; } if (!empty($err_f)) { $err['all'] = 'ユーザー情報が間違っています。'; } require_once( 'login.php' ); break; case 'logout': $payment_uri = dirname($_SERVER["REQUEST_URI"])."/payment"; $paymentCookies = array( 'openTag' ,'productId' ,'trx-filters' ,'trx-items-onpage' ,'trx-draw-page' ); foreach ($paymentCookies as $ck) { setcookie("$ck", '', time() - 3600, $payment_uri); } $usersObj->session_dell(); header( 'Location:'.URL.'/admin/' ); exit; break; case 'set_serial': if (empty($form_data['serial_number'])){ $err['serial_number'] = 'シリアル番号が入力されていません。'; }else{ $err['serial_number'] = $usersObj->setSerialNumber($form_data['serial_number']); } if (empty($err['serial_number'])){ $_SESSION['license_flg'] = 1; header( 'Location:'.URL.'/admin/users/index.php?status=admin' ); exit; }else{ $_SESSION['license_flg'] = 0; require_once( 'login.php'); } break; default: if( $usersObj->get_auth_session( $_SESSION, $user )) { if( $usersObj->db_login( $user['email'], $user['password'], $auth=ADMIN_ROLL, $user )) { require_once(dirname(__FILE__).'/../common/logs.php'); $logsObj = new logs(); $logsObj->check_act_mail(); require_once( 'main.php'); exit; } } $_SESSION = array(); $_SESSION['license_flg'] = ''; $_SESSION['acttime1'] = ''; $_SESSION['acttime2'] = ''; $_SESSION['acterr'] = ''; $_SESSION['actflg'] = ''; require_once( 'login.php'); break; } ?>