<?php
session_start(); require_once(dirname(__FILE__).'/../site-config.php'); require_once(dirname(__FILE__).'/../authorize.php'); require_once(dirname(__FILE__).'/../common/users.php'); require_once(dirname(__FILE__).'/../common/mails.php'); require_once(dirname(__FILE__).'/../common/bodys.php'); require_once(dirname(__FILE__).'/../common/builders.php'); require_once(dirname(__FILE__).'/../common/payment_lib.php'); if(isAuthAlive() == true){ session_regenerate_id(TRUE); $form_data = array(); }else{ $_SESSION = array(); @session_destroy(); $nologin ='NOLOGIN'; } $usersObj = new users(); $mailsObj = new mails(); $buildersObj = new builders(); $paymentObj = new payment_lib(); $settings = $usersObj->get_settings(); $buildersObj->get_all_setting( $tp_settings_data ); $buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 ); $data['title'] = ''; $data['site_name'] = $buildersObj->html_decode( $tp_settings_data['site_name']); $data['head'] = $buildersObj->html_decode( $tp_settings_data['head'] ); $data['css'] = $buildersObj->html_decode( $tp_settings_data['css'] ); $data['header_img'] = (!empty($img_uploaders_data)) ? URL.'/'.$img_uploaders_data[0]['store_folder'].'/'.$img_uploaders_data[0]['store_file']:NULL; if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $usersObj->get_data($_REQUEST, $form_data); $status = (!empty($form_data['status'])) ? $form_data['status'] : NULL; $status = (!empty($nologin)) ? $nologin : $status; $mode = (!empty($form_data['mode'])) ? $form_data['mode'] : NULL; $group_code = (!empty($form_data['group_id'])) ? $form_data['group_id'] : NULL; $group_code2 = (!empty($form_data['group_id2'])) ? $form_data['group_id2'] : NULL; $group_id = $usersObj->db_get_group_id( $group_code ); $group_id2 = $usersObj->db_get_group_id( $group_code2 ); $form_data['group_id'] = $group_id; $form_data['group_id2'] = $group_id2; if(empty($form_data['group_id']) || empty($form_data['group_id2'])){$status='NOGROUP';} if($form_data['group_id'] == $form_data['group_id2']){$status='NOCHANGE';} $settings3 = $usersObj->get_settings($form_data['group_id2']); if(empty($settings3)){$status='NOGROUP';} $password = $settings3['form_password']; } switch( $status ) { case 'NOLOGIN': $status = 'NOGROUP'; $err['nogroup'] = '<p><span class="red">グループ変更するためには先にログインをお願いします。</span></br>ログインは<a href="'.URL.'/" target="_blank">こちら</a>からお願いします。</p><a class="btn btn-primary" href="'.URL.'/">ログイン</a>'; break; case 'NOCHANGE': $status = 'NOGROUP'; $err['nogroup'] = 'グループの変更はありません。'; break; case 'NOGROUP': $status = 'NOGROUP'; $err['nogroup'] = 'グループ設定にエラーがあります。'; break; case 'LOCK': if( strcmp( $password, $form_data['pw'] ) == 0 ) { $status = 'LOGIN'; } else { $status = 'LOCK'; $err['password'] = 'パスワードが正しくありません。'; } break; case 'LOGIN': $email = htmlspecialchars($_SESSION[SESSION_USER_ID]); $id = $usersObj->get_user_id( $email ); $usersObj->db_set_user( $id ); $user = $usersObj->db_get_user(); $user['group_name'] = $usersObj->db_get_group_name($user['group_id']); if($user['group_id'] != $form_data['group_id']){ $err['group'] = '対象者ではありません。';break; } $user['group_id'] = $form_data['group_id2']; $user['story_no'] = 0; $usersObj->db_update_users_groupid( $user, $user['id'] ); $status = 'DONE'; break; default: if( $settings3['form_is_password'] == 1 ) { $status = 'LOCK'; } else { $status = 'LOGIN'; } break; } ?>
<!-- Doctype -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo ($data['title']) ? $data['title'].'&nbsp;|&nbsp;'.$data['site_name'] : $data['site_name'];?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/zerogrid.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/style.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/responsive.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/advanced.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/font.css">
	<?php if($mode=='if'){}else{ ?>
	<link rel="stylesheet" href="<?php echo URL; ?>/template/<?php echo $data['css']; ?>">
	<?php } ?>
	<?php echo (!empty($data['head'])) ? htmlspecialchars_decode($data['head']) : NULL; ?>
    <!--[if lt IE 9]>
		<script src="<?php echo URL; ?>/js/html5.js"></script>
		<script src="<?php echo URL; ?>/js/css3-mediaqueries.js"></script>
	<![endif]-->
</head>
<body>
<?php if($mode=='if'){}else{ ?>
<!-- Header -->
<header>
	<div class="wrap-header zerogrid">
<?php if(empty($data['header_img'])){?>
		<div id="logotxt"><a href="<?php echo URL;?>"><?php echo ($data['site_name'])?$data['site_name']:'タイトル';?></a></div>
<?php }else{ ?>
		<div id="logoimg"><a href="<?php echo URL;?>"><img src="<?php echo $data['header_img'];?>" alt="<?php echo $data['site_name'];?>"></a></div>
<?php }; ?>
	</div>
</header>
<?php } ?>
<!-- Content -->
<section id="content">
<div class="wrap-content zerogrid">
<div class="row block">
<div id="main-content" class="col-full">
<div class="wrap-col">
<article>
<?php switch( $status ): ?>
<?php case 'NOGROUP': ?>
<div class="heading">
<h2 class="border bottomline3 mplus-1p-bold">エラー</h2>
<div class="info"><?php echo $err['nogroup'];?></div></div>
<div class="content">
<?php break; ?>
<?php case 'LOCK': ?>
<div class="heading">
<h2 class="border bottomline3 mplus-1p-bold">パスワードを入力してグループ移動画面を開きます。</h2>
<div class="info"></div>
</div>
<div class="content">
<form action="" method="POST">
<fieldset>
<label class="semifom">パスワード</label>
<input name="pw" id="pw" type="password" />
<?php echo (!empty($err['password'])) ? '<div class="help-inline red">'.$err['password'].'</div>':NULL;?>
<label></label>
<input name="status" type="hidden" value="LOCK" />
<input name="action" type="submit" value="送信" class="btn btn-primary" />
</fieldset>
</form>
<?php break; ?>
<?php case 'LOGIN': ?>
<?php
?>
<div class="heading">
<h2 class="border bottomline3 mplus-1p-bold">グループを変更</h2>
</div>
<div class="content">
［<?php echo $usersObj->db_get_group_name(($form_data['group_id'])) ?>］から［<?php echo $usersObj->db_get_group_name(($form_data['group_id2'])) ?>］へグループを変更します。
<form method="post" action="">
	<fieldset>
<?php echo (!empty($err['group'])) ? '<div class="alert alert-error">'.$err['group'].'</div>':NULL;?>
	<input name="status" type="hidden" value="LOGIN" />
	<input type="submit" id="login" name="login" value="グループ変更"  class="btn btn-primary">
	</fieldset>
</form>
<?php break; ?>
<?php case 'DONE': ?>
<div class="heading">
<h2 class="border bottomline3 mplus-1p-bold">グループ変更完了</h2>
</div>
<div class="content">
<p>グループを［<?php echo $usersObj->db_get_group_name(($form_data['group_id2'])) ?>］へ変更しました。</p>
<?php break; ?>
<?php default: ?>
<?php break; ?>
<?php endswitch; ?>
<!-- Page original end -->
</div>
</article>
</div>
</div>
</div>
</div>
</section>
<?php if($mode=='if'){}else{ ?>
<!-- Footer -->
<footer>
	<div class="copyright">
		<p>&copy;  <a href="<?php echo URL; ?>"><?php echo ($data['site_name']) ? $data['site_name'] : 'サイト名'; ?></a></p>
	</div>
</footer>
<?php } ?>
</body></html>
