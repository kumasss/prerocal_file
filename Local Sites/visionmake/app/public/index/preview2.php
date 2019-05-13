<?php
session_start();
require_once( './common/config.ini' );
require_once( './common/users.php' );
require_once( './common/builders.php' );
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
$buildersObj = new builders();
$buildersObj->get_all_setting( $settings_data );
$buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 );
$data['site_name'] = htmlspecialchars_decode( $settings_data['site_name'], ENT_QUOTES );
$data['head'] = htmlspecialchars_decode( $settings_data['head'] );
$data['css'] = htmlspecialchars_decode( $settings_data['css'] );
$data['header_img'] = (!empty($img_uploaders_data)) ? URL.'/'.$img_uploaders_data[0]['store_folder'].'/'.$img_uploaders_data[0]['store_file']:NULL;

$_SESSION[SESSION_REG_DATE] = date('Y/m/d', strtotime( "-3600 day" ));

if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' )
{
	$buildersObj->get_data($_REQUEST, $form_data);
	$buildersObj->get_all_sidebar( $sidebars_data );
	$buildersObj->get_all_side_freeareas( $side_freeareas_data );
	if( !$buildersObj->get_content( $form_data['page'], $form_data ))
	{
		echo 'ご指定のページは存在しません。';
		return;
	}
	$data['description'] = '';
	$data['keyword'] = '';
	$data['contents'] = $form_data['contents'];
	$data['title'] = htmlspecialchars_decode($form_data['title']);
	if($form_data['add_br']==1){
		$data['contents'] = $buildersObj->br_replace($data['contents']);
	}else{
		$data['contents'] = htmlspecialchars_decode($data['contents']);
	}
	$freearea_upper = htmlspecialchars_decode($side_freeareas_data[0]['contents']);
	$freearea_lower = htmlspecialchars_decode($side_freeareas_data[1]['contents']);
	$subtitle1 = htmlspecialchars_decode($side_freeareas_data[2]['contents']);
	$subtitle2 = htmlspecialchars_decode($side_freeareas_data[3]['contents']);
}
include("sidebar.php");
require_once("./template/".$settings_data['contents_template']);
?>
