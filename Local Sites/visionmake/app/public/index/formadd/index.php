<?php
session_start(); require_once( dirname(__FILE__).'/../authorize.php' ); require_once( dirname(__FILE__).'/../common/users.php' ); require_once( dirname(__FILE__).'/../common/mails.php' ); require_once( dirname(__FILE__).'/../common/bodys.php' ); require_once( dirname(__FILE__).'/../common/builders.php' ); require_once( dirname(__FILE__).'/../common/payment_lib.php' ); require_once ( dirname(__FILE__).'/../admin/payment/config/Config.php' ); define( 'STATUS_OK', 'Completed' ); define( 'PAYPAL', 'paypal' ); define( 'BANK', 'bank' ); $usersObj = new users(); $mailsObj = new mails(); $buildersObj = new builders(); $paymentObj = new payment_lib(); $settings = $usersObj->get_settings(); $buildersObj->get_all_setting( $tp_settings_data ); $buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 ); $data['title'] = ''; $data['site_name'] = $buildersObj->html_decode( $tp_settings_data['site_name']); $data['head'] = $buildersObj->html_decode( $tp_settings_data['head'] ); $data['css'] = $buildersObj->html_decode( $tp_settings_data['css'] ); $data['head_script_add'] = $buildersObj->html_decode( $tp_settings_data['head_script_add'] ); $data['body_script_add'] = $buildersObj->html_decode( $tp_settings_data['body_script_add'] ); $data['header_img'] = (!empty($img_uploaders_data)) ? URL.'/'.$img_uploaders_data[0]['store_folder'].'/'.$img_uploaders_data[0]['store_file']:NULL; if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' ) { $usersObj->get_data($_REQUEST, $form_data); $status = (!empty($form_data['status'])) ? $form_data['status'] : NULL; $mode = (!empty($form_data['mode'])) ? $form_data['mode'] : NULL; $form_data['firstname'] = (!empty($form_data['firstname'])) ? $form_data['firstname'] : NULL; $form_data['lastname'] = (!empty($form_data['lastname'])) ? $form_data['lastname'] : NULL; $form_data['order_no'] = (!empty($form_data['order_no'])) ? $form_data['order_no'] : NULL; $form_data['email1'] = (!empty($form_data['email1'])) ? $form_data['email1'] : NULL; $form_data['email2'] = (!empty($form_data['email2'])) ? $form_data['email2'] : NULL; $form_data['form_password2'] = (!empty($form_data['form_password2'])) ? $form_data['form_password2'] : NULL; $form_data['group_id'] = (!empty($form_data['group_id'])) ? $form_data['group_id'] : 1; $form_data['unit_code'] = (!empty($form_data['unit_code'])) ? $form_data['unit_code'] : 1; $settings2 = $usersObj->get_settings($form_data['group_id']); if(empty($settings2)){$status='NOGROUP';} $password = $settings2['form_password']; $is_order = FALSE; $flg_order = FALSE; if(!empty($form_data['order'])) { $form_data['order_no'] = $form_data['order']; $is_order = TRUE; if(empty($settings['form_order_no'])) { $flg_order = TRUE; } } } switch( $status ) { case 'NOGROUP': $status = 'NOGROUP'; $err['nogroup'] = 'このページは存在しません。'; break; case 'LOCK': if( strcmp( $password, $form_data['pw'] ) == 0 ) { $status = 'LOGIN'; } else { $status = 'LOCK'; $err['password'] = 'パスワードが正しくありません。'; } break; case 'LOGIN': $usersObj->check_mailadd( $form_data['email1'] ); if( $settings['form_email2'] ) $usersObj->check_mailadd( $form_data['email2'] ); if(!empty($form_data['email1']) & !empty($form_data['email2'])) $usersObj->check_double_mail( $form_data['email1'], $form_data['email2'] ); if( $settings['form_password2'] & $settings['form_is_password2'] ) $usersObj->check_pw( $form_data['form_password2'] ); if( $settings['form_firstname'] & $settings['form_is_firstname'] ) $usersObj->check_name( $form_data['firstname'], 40, 'name1' ); if( $settings['form_lastname'] & $settings['form_is_lastname'] ) $usersObj->check_name( $form_data['lastname'], 40, 'name2' ); if( $settings['form_order_no'] & $settings['form_is_order_no'] ) $usersObj->check_order_no( $form_data['order_no'], 32 ); $err = $usersObj->get_err(); if( empty( $err )) { $form_data['email'] = $form_data['email1']; $user_cnt = $usersObj->get_user_cnt( $form_data['email'] ); $is_group = $usersObj->check_is_group( $form_data['group_id'] ); if(empty($is_group)){$err['group'] = 'グループが存在しません。';break;} if( $user_cnt > 0 ) { $err['email'] = 'すでに登録されています。'; } else { $status = 'CONF'; break; } } $status = 'LOGIN'; break; case 'CONF2': $err = ''; if( empty( $err )) { $form_data['email'] = $form_data['email1']; $user_cnt = $usersObj->get_user_cnt( $form_data['email'] ); $is_group = $usersObj->check_is_group( $form_data['group_id'] ); if(empty($is_group)){$err['group'] = 'グループが存在しません。';break;} if( $user_cnt > 0 ) { $err['email'] = 'すでに登録されています。'; } else { $user['email'] = $form_data['email']; $user['password'] = (!empty($form_data['form_password2'])) ? $form_data['form_password2'] : $usersObj->make_password(); $user['firstname'] = (!empty($form_data['firstname'])) ? $form_data['firstname'] : NULL; $user['lastname'] = (!empty($form_data['lastname'])) ? $form_data['lastname'] : NULL; $user['order_no'] = (!empty($form_data['order_no'])) ? $form_data['order_no'] : NULL; $user['story_no'] = 0; $user['scenario_id'] = SCENARIOS_ID; $user['group_id'] = (!empty($form_data['group_id'])) ? $form_data['group_id'] : 1; $user['auth'] = USER_ROLL; $user['delete_flg'] = FLG_NORMAL; $user['created'] = $mailsObj->get_now_date(); $user['ip'] = $_SERVER["REMOTE_ADDR"]; $user['host'] = getHostByAddr(getenv('REMOTE_ADDR')); $status = $usersObj->add_user( $user ); $user['user_id'] = $usersObj->get_insert_user_id(); $user['stepmail_url'] = $mailsObj->get_backnumber_url($user['user_id']); $user['extramail_url'] = $mailsObj->get_backnumber_url($user['user_id'], true); if( $status ) { $continue = TRUE; $login_mode = (!empty($_SESSION['login_mode'])) ? $_SESSION['login_mode']:NULL; $api_value_type = (!empty($_SESSION['type'])) ? $_SESSION['type']:NULL; $api_value_order = (!empty($user['order_no'])) ? $user['order_no']:NULL; $ret_url = (!empty($_SESSION['returl'])) ? $_SESSION['returl']:NULL; if ($login_mode == 'paymant') { $row = array(); if ( $usersObj->search_email_order($user, $row)) { $params = Array(); $params[] = array('name'=>'cmd','value'=>UTAPI_CMD_INSERT); $params[] = array('name'=>'user','value'=>$row[0]['id']); $params[] = array('name'=>'type','value'=>$api_value_type); $params[] = array('name'=>'order','value'=>$api_value_order); $res = $usersObj->curl_json( UTAPI_URL, $params ); if ( $res[UTAPI_RESULT] != UTAPI_RESULT_OK) { $usersObj->db_delete_user($row[0]['id']); $continue = FALSE; } } else { $continue = FALSE; } } if ( $continue == FALSE) { error_log(PHP_EOL."ユーザー登録エラー（UTAPI_ERROR#2）",3,sys_get_temp_dir() ."/lt_api.log"); $status = 'NOGROUP'; $err['nogroup'] = 'ユーザーの登録に失敗しました。'; break; } $status = 'DONE'; if( $settings['automail_add_admin'] & $settings['automail_add_user'] ) { $form_data['send_settings'] = 0; } elseif( $settings['automail_add_admin'] ) { $form_data['send_settings'] = 1; } elseif( $settings['automail_add_user'] ) { $form_data['send_settings'] = 2; } $form_data['status'] = ''; if ($mailsObj->is_smtp()) { $mailsObj->send_auto_mail_smtp($form_data, $user, $settings); } else { $mailsObj->send_auto_mail($form_data, $user, $settings); } if ($login_mode == 'paymant' && !empty($ret_url)) { session_regenerate_id(TRUE); $_SESSION[SESSION_USER_ID] = $row[0]['email']; $_SESSION[SESSION_PASSWORD] = $row[0]['password']; $_SESSION[SESSION_REG_DATE] = date('Y/m/d', strtotime( "+1 day" )); $_SESSION[SESSION_GROUP_ID] = $row[0]['group_id']; $_SESSION['login_mode'] = ''; $_SESSION['type'] = ''; $_SESSION['order'] = ''; $_SESSION['group_id'] = ''; $_SESSION['returl'] = ''; if(!empty($_SESSION[SESSION_USER_ID]) && !empty($_SESSION[SESSION_PASSWORD])) { $auth = jdgAuth($_SESSION[SESSION_USER_ID], $_SESSION[SESSION_PASSWORD], $data); if($auth === AUTH_RES_PASS) { header('location: '.$ret_url); exit(); }else{ $_SESSION = array(); @session_destroy(); } } header('Location:'.URL.'/main.php'); exit(); } } else { $status = 'LOGIN'; } } } break; default: if(!empty($form_data['type']) & !empty($form_data['order']) & !empty($form_data['group_id'])) { $api_value_type = $form_data['type']; $api_value_order = $form_data['order']; $params = array(); $params[] = array('name'=>'cmd','value'=>UTAPI_CMD_QUERY); $params[] = array('name'=>'type','value'=>$api_value_type); $params[] = array('name'=>'order','value'=>$api_value_order); $res = $usersObj->curl_json( UTAPI_URL, $params ); if ( $res[UTAPI_RESULT] != UTAPI_RESULT_OK) { $status = 'NOGROUP'; $err['nogroup'] = 'ご購入の確認ができませんでした。'; break; } $payment = array(); if( $api_value_type == BANK ) { $payment = $paymentObj->find_payment_id_by_bank_order( $api_value_order ); } else if( $api_value_type == PAYPAL ) { $payment = $paymentObj->find_payment_id_by_paypal_order( $api_value_order ); } $is_order = FALSE; if( is_numeric($payment[0]->user_id) && $payment[0]->user_id != 0) { $cnt = $paymentObj->count_users_by_id($payment[0]->user_id); if( $cnt[0]->cnt == 1 ) { if( $payment[0]->status == STATUS_OK ) $is_order = TRUE; header('Location:'.URL); exit(); } } else{ } $_SESSION = array(); $_SESSION['login_mode'] = 'paymant'; $_SESSION['type'] = $form_data['type']; $_SESSION['order'] = $form_data['order']; $_SESSION['group_id'] = $form_data['group_id']; $_SESSION['returl'] = ($form_data['returl']) ? $form_data['returl']:NULL; $settings2['form_is_password'] = 0; } if( $settings2['form_is_password'] == 1 ) { $status = 'LOCK'; $form_data['locked'] = (!empty($form_data['locked']))?$form_data['locked']:''; if ($form_data['locked'] == 'unlocked') { $status = 'LOGIN'; } } else { $status = 'LOGIN'; } break; } ?>
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
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g=" crossorigin="anonymous"></script>
	<?php ?>
	<?php
 switch( $status ) { case 'DONE': echo (!empty($data['head_script_add'])) ? $data['head_script_add'] : NULL; break; case 'default': break; } ?>
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
<h2 class="border bottomline3 mplus-1p-bold">パスワードを入力して登録画面を開きます。</h2>
<div class="info"></a></div>
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
<h2 class="border bottomline3 mplus-1p-bold">会員登録</h2>
</div>
<div class="content">
<form method="post" action="regist.php">
	<fieldset>
<?php echo (!empty($err['group'])) ? '<div class="alert alert-error">'.$err['group'].'</div>':NULL;?>

<?php if( !empty($settings['form_firstname'] ) || !empty($settings['form_lastname'] )): ?>
	<label for="firstname">お名前　<?php if($settings['form_is_firstname'] or $settings['form_is_lastname']){echo '<span class="label label-important">必須</span>';} ?></label>
	
<?php if( !empty($settings['form_firstname'] )): ?>
	<div class="input-prepend">
	
	<span class="add-on" style="color:#474747;">姓</span><input type="text" id="firstname" name="firstname" value="<?php echo $form_data['firstname']; ?>" placeholder="姓を入れてください">
	</div>
<?php endif; ?>

<?php if( !empty($settings['form_lastname'] )): ?>
	<div class="input-prepend">
	<span class="add-on" style="color:#474747;">名</span><input type="text" id="lastname" name="lastname" value="<?php echo $form_data['lastname']; ?>" placeholder="名前を入れてください">
	</div>
<?php endif; ?>

	<?php
 if( !empty($err['name1']) || !empty($err['name2']) ) { $errname = (!empty($err['name1'])) ? $err['name1']:''; $errname.= (!empty($err['name2'])) ? $err['name2']:''; echo '<div class="help-block red">'.$errname.'</div>'; } ?>
	
<?php endif;?>

<?php if( !empty($settings['form_email'] )): ?>
	<label for="email1">メールアドレス　<span class="label label-important">必須</span></label><input type="text" id="Email1" name="email1" placeholder="メールアドレス" value="<?php echo $form_data['email1']; ?>">
	<?php echo (!empty($err['email'])) ? '<div class="help-inline red">'.$err['email'].'</div>':NULL;?>
<?php if( !empty($settings['form_email2'] )): ?>
	<label for="email2">再入力（貼り付けできません）</label><input type="text" id="Email2" name="email2" placeholder="再入力" value="<?php echo $form_data['email2']; ?>" onPaste="return false">
<?php endif; ?>
<?php endif; ?>
<?php if( !empty($settings['form_password2'] )): ?>
	<br>
	<label for="form_password2">メンバーサイトログインパスワード<?php echo ($settings['form_is_password2']) ? ' <span class="label label-important">必須</span>':NULL; ?></label><input type="password" id="FormPassword2" name="form_password2" value="<?php echo $form_data['form_password2']; ?>" placeholder="ご希望のパスワード">
	<?php echo (!empty($err['password'])) ? '<div class="help-inline red">'.$err['password'].'</div>':NULL;?>
<?php endif; ?>
<?php if(!empty($settings['form_order_no'])): ?>
	<br>
	<label for="order_no">注文ID<?php echo ($settings['form_is_order_no']) ? ' <span class="label label-important">必須</span>':NULL; ?></label><input type="text" id="order_no" name="order_no" value="<?php echo $form_data['order_no']; ?>" <?php echo ($is_order)? 'disabled="disabled"':NULL?>>
	<?php echo (!empty($err['order_no'])) ? '<div class="help-inline red">'.$err['order_no'].'</div>':NULL;?>
<?php endif; ?>
<?php if($flg_order): ?>
	<input name="order_no" type="hidden" value="<?php echo $form_data['order_no'];?>" />
<?php endif; ?>
	<label></label>
	<input name="status" type="hidden" value="default" />
	<button type="button" id="submitBtn" class="btn btn-primary input-large">確　認</button>
	</fieldset>
</form>
<script type="text/javascript" src="<?php echo URL?>/formadd/login.js"></script>
<?php break; ?>


<?php case 'CONF': ?>
<div class="heading">
<h2 class="border bottomline3 mplus-1p-bold">会員登録確認</h2>
</div>
<div class="content">
<p>こちらの情報で登録します。よろしければ登録をクリックして下さい。</p>
<form method="post" action="thanks.php">
<div class="well" style="color:#474747;">
<dl class="dl-horizontal">

<?php if( !empty($settings['form_firstname'] ) || !empty($settings['form_lastname'] )): ?>
	<dt>お名前</dt>
	<dd>
<?php if( !empty($settings['form_firstname'] )):?>
	<?php echo (!empty($form_data['firstname']))?$form_data['firstname']:"　"; ?>
	<input type="hidden" name="firstname" value="<?php echo $form_data['firstname']?>" />
<?php endif; ?>
<?php if( !empty($settings['form_lastname'] )): ?>
	<?php echo (!empty($form_data['lastname']))?$form_data['lastname']:"　"; ?>
	<input type="hidden" name="lastname" value="<?php echo $form_data['lastname']?>" />
<?php endif; ?>
	</dd>
<?php endif; ?>
	
<?php if( !empty($settings['form_email'] )): ?>
	<dt>メールアドレス</dt>
	<dd>
	<?php echo (!empty($form_data['email1']))?$form_data['email1']:"　"; ?>
	<input type="hidden" name="email1" value="<?php echo $form_data['email1']?>" />
	</dd>
<?php endif; ?>

<?php if( !empty($settings['form_password2'] )): ?>
	<dt>ログインパスワード</dt>
	<dd>
	<?php echo (!empty($form_data['form_password2']))?str_repeat('*',strlen($form_data['form_password2'])):"　"; ?>
	<input type="hidden" name="form_password2" value="<?php echo $form_data['form_password2']?>" />
	</dd>
<?php endif; ?>

<?php if(!empty($settings['form_order_no'])): ?>
	<dt>注文ID</dt>
	<dd>
	<?php echo $form_data['order_no']; ?>
	<input type="hidden" name="order_no" value="<?php echo $form_data['order_no']?>" />
	</dd>
<?php endif; ?>
</dl>
</div>

<?php if($flg_order): ?>
<input name="order_no" type="hidden" value="<?php echo $form_data['order_no'];?>" />
<?php endif; ?>
<input type="hidden" name="status" value="default" />
<input type="hidden" name="locked" value="unlocked" />
<button type="button" id="submitBtn" class="btn btn-primary input-small">登　録</button>　<button type="button" id="cancelBtn" class="btn btn-default">戻る</button>
</form>
<script type="text/javascript" src="<?php echo URL?>/formadd/confform.js"></script>
<?php break; ?>


<?php case 'DONE': ?>
<div class="heading">
<h2 class="border bottomline3 mplus-1p-bold">会員登録完了</h2>
</div>
<div class="content">
<?php echo $usersObj->html_decode($settings['form_add_done_message']); ?>
<?php if( $settings['automail_add_user'] ): ?>
<p>”<?php echo $user['email'] ?>”に登録完了メールを送信しましたのでご確認下さい。</p>
<?php endif; ?>
<?php if($ret_url): ?>
<p><a href="<?php echo $ret_url ?>" class="b" target="_blank">こちらのページ</a>からログインしてください。。</p>
<?php endif; ?>
<?php echo (!empty($data['body_script_add'])) ? $data['body_script_add'] : NULL; ?>
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
