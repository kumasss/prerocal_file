<?php
session_start(); require_once('site-config.php'); require_once('authorize.php'); require_once( './common/users.php' ); require_once( './common/mails.php' ); require_once( './common/builders.php' ); require_once( './common/accanalyzes.php' ); if(isAuthAlive() == true) { session_regenerate_id(TRUE); $buildersObj = new builders(); } else { $_SESSION = array(); require_once( './common/element/add_referer.php' ); header('Location:'.URL.'/index.php'); exit; } if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $buildersObj->get_all_setting( $settings_data ); $buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 ); $data['site_name'] = $buildersObj->html_decode( $settings_data['site_name']); $data['head'] = $buildersObj->html_decode( $settings_data['head'] ); $data['css'] = $buildersObj->html_decode( $settings_data['css'] ); $data['header_img'] = (!empty($img_uploaders_data)) ? URL.'/'.$img_uploaders_data[0]['store_folder'].'/'.$img_uploaders_data[0]['store_file']:NULL; $email = htmlspecialchars($_SESSION[SESSION_USER_ID]); $usersObj = new users(); $id = $usersObj->get_user_id( $email ); $usersObj->db_set_user( $id ); $user = $usersObj->db_get_user(); $user['group_name'] = $usersObj->db_get_group_name($user['group_id']); $mailsObj = new mails(); $user['stepmail_url'] = $mailsObj->get_backnumber_url($user['user_id']); $user['extramail_url'] = $mailsObj->get_backnumber_url($user['user_id'], true); $buildersObj->get_data($_REQUEST, $form_data); if (!empty($form_data['url'])) { $page = $buildersObj->get_page($form_data['url']); $form_data['page'] = $page; } $buildersObj->get_all_sidebar( $sidebars_data ); $is_page = FALSE; foreach( $sidebars_data as $sidebar ) { if (empty($form_data['page'])){break;} if( $sidebar['contents_id'] == $form_data['page'] ) { $is_page = TRUE; $public = $buildersObj->check_reg_date( $sidebar['contents_public_date'], $sidebar['contents_no_public_date'] ); $check_group = $buildersObj->check_group( $sidebar['group_id'] ); if( $public & $check_group ){ } else { $_SESSION['title'] = '閲覧権限がありません。'; $_SESSION['contents'] = 'このページを閲覧することはできません。'; header("Location: err.php"); exit; } } } if( !$is_page ){ $_SESSION['title'] = '存在しないページ'; $_SESSION['contents'] = 'このページは存在しないか削除されました。'; header("Location: err.php"); exit; } $buildersObj->get_all_side_freeareas( $side_freeareas_data ); $buildersObj->get_content( $form_data['page'], $contents_data ); $form_data['status'] = (!empty($form_data['status'])) ? $form_data['status'] : NULL; $form_data['password'] = (!empty($form_data['password'])) ? $form_data['password'] : NULL; $page = "./template/".$settings_data['contents_template']; $data['description'] = $contents_data['description']; $data['keyword'] = $contents_data['keyword']; $data['password'] = $contents_data['password']; $data['title'] = $buildersObj->html_decode( $contents_data['title'], ENT_QUOTES ); $flg_pass = FALSE; if( !empty( $data['password'] )) { if( $form_data['status'] == 'PASSWORD' & $form_data['password'] == $data['password'] ) { $flg_pass = TRUE; } } else { $flg_pass = TRUE; } if( $flg_pass ) { if($contents_data['add_br']==1){ $data['contents'] = $buildersObj->br_replace($contents_data['contents']); } else{ $data['contents'] = $buildersObj->html_decode($contents_data['contents']); } } else { $data['contents'] = file_get_contents( './template/pass_form.php' ); } foreach($side_freeareas_data as $sidedata) { switch($sidedata['id']){ case '1': $freearea_upper = htmlspecialchars_decode($sidedata['contents']); break; case '2': $freearea_lower = htmlspecialchars_decode($sidedata['contents']); break; case '3': $subtitle1 = $buildersObj->html_decode($sidedata['contents']); break; case '4': $subtitle2 = $buildersObj->html_decode($sidedata['contents']); break; case '5': $freearea_middle = htmlspecialchars_decode($sidedata['contents']); break; } } $data['title'] = $buildersObj->txtReplace( $data['title'], $user); $data['contents'] = $buildersObj->txtReplace( $data['contents'], $user); $data['contents'] = $buildersObj->add_backnumber( $data['contents'], $user); $data['contents'] = $buildersObj->add_extrabacknumber( $data['contents'], $user); $data['contents'] = $buildersObj->do_plugin( $data['contents'], $dummy ); $freearea_upper = $buildersObj->txtReplace( $freearea_upper, $user); $freearea_upper = $buildersObj->do_plugin( $freearea_upper, $dummy); $freearea_middle = $buildersObj->txtReplace( $freearea_middle, $user); $freearea_middle = $buildersObj->do_plugin( $freearea_middle, $dummy); $freearea_lower = $buildersObj->txtReplace( $freearea_lower, $user); $freearea_lower = $buildersObj->do_plugin( $freearea_lower, $dummy); } $accanalyzesObj = new accanalyzes(); if(!empty($data['contents'])) $accanalyzesObj->ac_page( $data['contents'] ); if(!empty($freearea_upper)) $accanalyzesObj->ac_page( $freearea_upper ); if(!empty($freearea_middle)) $accanalyzesObj->ac_page( $freearea_middle ); if(!empty($freearea_lower)) $accanalyzesObj->ac_page( $freearea_lower ); require_once("sidebar.php"); require_once( $page ); ?>