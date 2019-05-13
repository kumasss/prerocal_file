<?php
session_start();
require_once('site-config.php');
require_once('authorize.php');
require_once('./common/users.php');
require_once('./common/builders.php');
require_once('./common/accanalyzes.php');
require_once('./common/mails.php');
if (isAuthAlive() == true) {
    session_regenerate_id(true);
    $buildersObj = new builders();
    $buildersObj->get_all_setting($settings_data);
    $buildersObj->get_all_img_uploaders2($img_uploaders_data, $position = HEADER, 0, 1);
    $data['site_name'] = $buildersObj->html_decode($settings_data['site_name']);
    $data['head'] = $buildersObj->html_decode($settings_data['head']);
    $data['css'] = $buildersObj->html_decode($settings_data['css']);
    $data['header_img'] = (!empty($img_uploaders_data)) ? URL . '/' . $img_uploaders_data[0]['store_folder'] . '/' . $img_uploaders_data[0]['store_file'] : null;
    $usersObj = new users();
    $email = htmlspecialchars($_SESSION[SESSION_USER_ID]);
    $id = $usersObj->get_user_id($email);
    $usersObj->db_set_user($id);
    $user = $usersObj->db_get_user();
    $user['group_name'] = $usersObj->db_get_group_name($user['group_id']);
    $mailsObj = new mails();
    $user['stepmail_url'] = $mailsObj->get_backnumber_url($user['user_id']);
    $user['extramail_url'] = $mailsObj->get_backnumber_url($user['user_id'], true);
} else {
    $_SESSION = array();
    require_once('./common/element/add_referer.php');
    header("Location:index.php");
}
if (!$buildersObj->get_all_top($tops_data)) {
    echo $err['top'] = "トップページが作成されていません。";
} else {
    $data['description'] = $tops_data['description'];
    $data['keyword'] = $tops_data['keyword'];
    $data['title'] = htmlspecialchars_decode($tops_data['title']);
    if ($tops_data['add_br'] == 1) {
        $data['contents'] = $buildersObj->br_replace($tops_data['contents']);
    } else {
        $data['contents'] = htmlspecialchars_decode($tops_data['contents']);
    }
    $data['title'] = $buildersObj->txtReplace($data['title'], $user);
    $data['contents'] = $buildersObj->txtReplace($data['contents'], $user);
    $data['contents'] = $buildersObj->add_backnumber($data['contents'], $user);
    $data['contents'] = $buildersObj->add_extrabacknumber($data['contents'], $user);
    $data['contents'] = $buildersObj->do_plugin($data['contents'], $dummy);
}
$buildersObj->get_all_sidebar($sidebars_data);
$buildersObj->get_all_side_freeareas($side_freeareas_data);
foreach ($side_freeareas_data as $sidedata) {
    switch ($sidedata['id']) {
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
        case '5':
            $freearea_middle = htmlspecialchars_decode($sidedata['contents']);
            break;
    }
}
$freearea_upper = $buildersObj->txtReplace($freearea_upper, $user);
$freearea_upper = $buildersObj->do_plugin($freearea_upper, $dummy);
$freearea_middle = $buildersObj->txtReplace($freearea_middle, $user);
$freearea_middle = $buildersObj->do_plugin($freearea_middle, $dummy);
$freearea_lower = $buildersObj->txtReplace($freearea_lower, $user);
$freearea_lower = $buildersObj->do_plugin($freearea_lower, $dummy);
$accanalyzesObj = new accanalyzes();
if (!empty($data['contents'])) {
    $accanalyzesObj->ac_page($data['contents']);
}
if (!empty($freearea_upper)) {
    $accanalyzesObj->ac_page($freearea_upper);
}
if (!empty($freearea_middle)) {
    $accanalyzesObj->ac_page($freearea_middle);
}
if (!empty($freearea_lower)) {
    $accanalyzesObj->ac_page($freearea_lower);
}
require_once('./sidebar.php');
require_once('./template/' . $settings_data['top_template']); ?>