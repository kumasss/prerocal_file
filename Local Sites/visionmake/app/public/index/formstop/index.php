<?php
require_once( '../common/users.php' ); require_once( '../common/mails.php' ); require_once( '../common/builders.php' ); $usersObj = new users(); $mailsObj = new mails(); $buildersObj = new builders(); $settings = $usersObj->get_settings(); $password = $settings['form_password']; $buildersObj->get_all_setting( $tp_settings_data ); $buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 ); $data['title'] = ''; $data['site_name'] = $buildersObj->html_decode( $tp_settings_data['site_name']); $data['head'] = $buildersObj->html_decode( $tp_settings_data['head'] ); $data['css'] = $buildersObj->html_decode( $tp_settings_data['css'] ); $data['header_img'] = (!empty($img_uploaders_data)) ? URL.'/'.$img_uploaders_data[0]['store_folder'].'/'.$img_uploaders_data[0]['store_file']:NULL; $form_data['email'] = ''; $result = FALSE; if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $usersObj->get_data($_REQUEST, $form_data); $form_data['email'] = (!empty($form_data['email'])) ? $form_data['email'] : NULL; $is_unit = ($usersObj->is_users_unit()!==false)?true:false; if( !empty( $form_data['email'] )) { $usersObj->check_mailadd( $form_data['email'] ); $err = $usersObj->get_err(); if( empty( $err )) { $id = $usersObj->get_user_id( $form_data['email'] ); if( !empty( $id ) & !$usersObj->db_is_admin( $id )) { $usersObj->db_set_user( $id ); $user = $usersObj->db_get_user(); $user['stepmail_url'] = $mailsObj->get_backnumber_url($user['user_id']); $user['extramail_url'] = $mailsObj->get_backnumber_url($user['user_id'], true); if( !$settings['send_stop'] ) { $flg = FLG_DELETE; $usersObj->db_delflag_user( $flg, $id ); if ($is_unit) { $usersObj->delflag_un_user( $flg, $id ); } $result = TRUE; } else { $usersObj->db_delete_user( $id ); if ($is_unit){ $usersObj->delete_un_user( $id ); } $result = TRUE; } if( $result ) { if( $settings['automail_stop_admin'] & $settings['automail_stop_user'] ) { $form_data['send_settings'] = 0; } elseif( $settings['automail_stop_admin'] ) { $form_data['send_settings'] = 1; } elseif( $settings['automail_stop_user'] ) { $form_data['send_settings'] = 2; } $form_data['status'] = 'STOP'; if ($mailsObj->is_smtp()) { $mailsObj->send_auto_mail_smtp($form_data, $user, $settings); } else { $mailsObj->send_auto_mail($form_data, $user, $settings); } } } else { $err['email'] = 'メールアドレスが登録されていません。'; } } } } ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo ($data['title']) ? $data['title'].'&nbsp;|&nbsp;'.$data['site_name'] : $data['site_name'];?></title>
	<meta name="description" content="<?php echo $data['description']; ?>">
	<meta name="keywords" content="<?php echo $data['keyword']; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/zerogrid.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/style.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/responsive.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/advanced.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/font.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/template/<?php echo $data['css']; ?>">
	<?php echo (!empty($data['head'])) ? htmlspecialchars_decode($data['head']) : NULL; ?>
	<!--[if lt IE 9]>
		<script src="<?php echo URL; ?>/js/html5.js"></script>
		<script src="<?php echo URL; ?>/js/css3-mediaqueries.js"></script>
	<![endif]-->
</head>
<!-- Header -->
<body>
<header>
	<div class="wrap-header zerogrid">
		<?php if(empty($data['header_img'])){?>
		<div id="logotxt"><a href="<?php echo URL;?>"><?php echo ($data['site_name'])?$data['site_name']:'タイトル';?></a></div>
		<?php }else{ ?>
		<div id="logoimg"><a href="<?php echo URL;?>"><img src="<?php echo $data['header_img'];?>" alt="<?php echo $data['site_name'];?>"></a></div>
		<?php }; ?>
	</div>
</header>
<!-- Content -->
<section id="content">
<div class="wrap-content zerogrid">
<div class="row block">
<div id="main-content" class="col-full">
<div class="wrap-col">
<article>
<?php if( $result == FALSE ): ?>
<div class="heading">
<h2>会員解除</h2>
<div class="info"></a></div>
</div>
<div class="content">
<?php
if( !$settings['send_stop'] ): ?>
<p>解除すると会員メールが届かなくなりますのでご注意ください。</p>
<?php endif; ?>
<form method="post" name="send_stop" action="">
	<fieldset>
	<label for="email">メールアドレス</label>
	<input type="text" id="email" name="email" value="<?php echo $form_data['email']; ?>"><br>
	<?php echo (!empty($err['email'])) ? '<div style="color:red;">'.$err['email'].'</div>':NULL;?>
	<button  onclick="if (confirm('会員解除してよろしいですか？')) { document.send_stop.submit(); this.disabled=true;} event.returnValue = false; return false;" href="#" class="btn btn-danger">会員解除</button>
	</fieldset>
</form>
<?php else: ?>
<div class="heading">
<h2>会員解除完了</h2>
</div>
<div class="content">
<?php echo $usersObj->html_decode($settings['form_stop_done_message']); ?>
<?php if( $settings['automail_stop_user'] ): ?>
<p>”<?php echo $user['email'] ?>”に解除完了メールを送信しましたのでご確認下さい。</p>
<?php endif; ?>
<?php endif; ?>
<!-- Page original end -->
</div>
</article>
</div>
</div>
</div>
</div>
</section>
<!-- Footer -->
<footer>
	<div class="copyright">
		<p>&copy;  <a href="<?php echo URL; ?>"><?php echo ($data['site_name']) ? $data['site_name'] : 'サイト名'; ?></a></p>
	</div>
</footer>
</body></html>
