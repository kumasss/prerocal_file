<?php
 session_start(); require_once( '../../../common/config.ini' ); require_once( '../../../common/users.php' ); require_once( '../../../common/builders.php' ); $usersObj = new users(); $buildersObj = new builders(); if( $usersObj->get_auth_session( $_SESSION, $user )) { if( $usersObj->db_login( $user['email'], $user['password'], $auth=ADMIN_ROLL, $user )) { session_regenerate_id( TRUE ); } else { $usersObj->session_dell(); } } else { header( 'Location:'.URL.'/admin/' ); } if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $buildersObj->get_data($_REQUEST, $form_data); (!isset($form_data['status'])) ? $form_data['status'] = '':NULL; } switch ($form_data['status']) { case 'edit': $buildersObj->check_input_site_name( $form_data ); $err = $buildersObj->get_err(); if (isset($form_data['template_flg'])){ }else{ $form_data['template_flg'] = 'default'; } $form_data['css'] = $form_data['template_flg'] . "/add.css"; $form_data['top_template'] = $form_data['template_flg'] . "/main.php"; $form_data['contents_template'] = $form_data['template_flg'] . "/page.php"; $template_flg = $form_data['template_flg']; $template_path = "../../../template/"; $template_dir_arr = $buildersObj->get_template_dir_array($template_path); $buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 ); if( empty( $err )) { $buildersObj->db_edit_setting( $form_data ); $message = '設定を更新しました。'; } require_once( 'edit.php'); break; case 'delete': $buildersObj->db_delete_setting( $form_data['id'] ); header( 'Location:'.URL.'/admin/settings/' ); break; case 'delete_header': $buildersObj->get_img_uploaders( $form_data['id'], $img_data ); $form_data['store_folder'] = $img_data['store_folder']; $form_data['store_file'] = $img_data['store_file']; $form_data['store_folder'] = '../../../'.$form_data['store_folder']; $buildersObj->del_img_file( $form_data ); $buildersObj->db_delete_img_uploaders( $form_data['id'] ); require_once("../../../common/element/header_uploaders_form.php"); break; default: if( !$buildersObj->get_all_setting( $form_data )) { $buildersObj->db_set_setting(); if( $buildersObj->get_all_setting( $form_data )) { $message = "初期設定しました。"; } else { $err['all'] = "設定情報にエラーが見つかりました。恐れ入りますがもう一度設定をして下さい。"; $buildersObj->db_all_delete_setting(); } } $buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 ); $exp = explode("/", $form_data['top_template']); if (count($exp) == 2){ $template_flg = $exp[0]; }else{ $template_flg = "default"; } $template_path = "../../../template/"; $template_dir_arr = $buildersObj->get_template_dir_array($template_path); $form_data['status'] = 'default'; require_once( 'edit.php'); break; } ?>