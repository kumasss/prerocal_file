<?php
/*
 * file name	err.php
 * date			2014-10-01
 */
session_start();
require_once('site-config.php');
require_once('authorize.php');
require_once( './common/users.php' );
require_once( './common/builders.php' );
require_once( './common/accanalyzes.php' );

if(isAuthAlive() == true)
{
	session_regenerate_id(TRUE);
	$buildersObj = new builders();
}
else {
	$_SESSION = array();
	//@session_destroy(); !!!!NG!!!!
	require_once( './common/element/add_referer.php' );
	header('Location:'.URL.'/index.php');
	exit;
}
if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' )
{
	$buildersObj->get_all_setting( $settings_data );
	$buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 );
	$data['site_name'] = htmlspecialchars_decode( $settings_data['site_name'], ENT_QUOTES );
	$data['head'] = htmlspecialchars_decode( $settings_data['head'] );
	$data['css'] = htmlspecialchars_decode( $settings_data['css'] );
	$data['header_img'] = (!empty($img_uploaders_data)) ? URL.'/'.$img_uploaders_data[0]['store_folder'].'/'.$img_uploaders_data[0]['store_file']:NULL;
	$email = htmlspecialchars($_SESSION[SESSION_USER_ID]);
	
	$usersObj = new users();
	$id = $usersObj->get_user_id( $email );
	$usersObj->db_set_user( $id );
	$user = $usersObj->db_get_user();
	$user['group_name'] = $usersObj->db_get_group_name($user['group_id']);
	$buildersObj->get_data($_REQUEST, $form_data);
	$buildersObj->get_all_sidebar( $sidebars_data );
	$buildersObj->get_all_side_freeareas( $side_freeareas_data );
	
	$page = "./template/".$settings_data['contents_template'];
	$data['description'] = '';
	$data['keyword'] = '';
	$data['title'] = (isset($_SESSION['title']))?$_SESSION['title']:'存在しないページ';
	$data['contents'] = (isset($_SESSION['contents']))?$_SESSION['contents']:'存在しないページです。';
	unset($_SESSION['title']);
	unset($_SESSION['contents']);
	if(!empty($_SERVER["HTTP_REFERER"]))
	{
		$referer = $_SERVER["HTTP_REFERER"];
		$data['contents'] .= '<center><a href="'.$referer.'">戻る</a></center>';
	}
	foreach($side_freeareas_data as $sidedata)
	{
		switch($sidedata['id']){
		case '1':
			$freearea_upper = htmlspecialchars_decode($sidedata['contents']);
			break;
		case '2':
			$freearea_lower = htmlspecialchars_decode($sidedata['contents']);
			break;
		case '3':
			$subtitle1 = $buildersObj->html_decode($sidedata['contents']);
			break;
		case '4':
			$subtitle2 = $buildersObj->html_decode($sidedata['contents']);
			break;
		}
	}
	$freearea_upper = $buildersObj->txtReplace( $freearea_upper, $user);
	$freearea_lower = $buildersObj->txtReplace( $freearea_lower, $user);
}
require_once("sidebar.php");
require_once( $page );
?>