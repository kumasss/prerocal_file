<?php
session_start();
require_once('site-config.php');
require_once('authorize.php');
require_once( './common/builders.php' );
require_once( './common/users.php' );
require_once( './common/mails.php' );

if(isAuthAlive() == true)
{
	session_regenerate_id(TRUE);
	$buildersObj = new builders();
	$buildersObj->get_all_setting($settings_data);
	$buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 );
	$data['site_name'] = $buildersObj->html_decode( $settings_data['site_name']);
	$data['head'] = $buildersObj->html_decode( $settings_data['head'] );
	$data['css'] = $buildersObj->html_decode( $settings_data['css'] );
	$data['header_img'] = (!empty($img_uploaders_data)) ? URL.'/'.$img_uploaders_data[0]['store_folder'].'/'.$img_uploaders_data[0]['store_file']:NULL;
	$email = htmlspecialchars($_SESSION[SESSION_USER_ID]);
	$password = htmlspecialchars($_SESSION[SESSION_PASSWORD]);
	$usersObj = new users();
	$id = $usersObj->get_user_id( $email );
	$usersObj->db_set_user( $id );
	$user = $usersObj->db_get_user();
	$settings = $usersObj->get_settings();
}
else{
	$_SESSION = array();
	require_once( './common/element/add_referer.php' );
	header("Location:index.php");
}
function get_now_date()
{
	$now = date("Y-m-d H:i:s");
	return $now;
}
function send_auto_mail( $data )
{
	mb_language("Ja") ;
	mb_internal_encoding("UTF8") ;
	$sender_name = $data['sender_name'];
	$sender_email = $data['sender_email'];
	$from  = "From:" .mb_encode_mimeheader($sender_name) ."<".$sender_email.">";
	//$to = $data['email'];
	$name  = (!empty($data['name'])) ? $data['name']:'';
	$to = mb_encode_mimeheader($name) ."<".$data['email'].">";
	$subject = $data['title'];
	$message = $data['body'];
	//debug todo 2015-04-06
	//$buildersObj = new builders();
	//$buildersObj->log_out("INFO" , __FILE__ , __LINE__, "start");
	//$buildersObj->log_out("data" , __FILE__ , __LINE__, $data);
	//$buildersObj->log_out("to" , __FILE__ , __LINE__, $to);
	//$buildersObj->log_out("subject" , __FILE__ , __LINE__, $subject);
	//$buildersObj->log_out("message" , __FILE__ , __LINE__, $message);
	@mb_send_mail($to, $subject, $message, $from);
}
function send_auth_mail( $data, $users )
{
	$today = get_now_date();
	foreach( $users as $user )
	{
		if( !empty( $user['email'] ))
		{
			$mail = array();
			$body = '';
			$mail['sender_name'] = $data['sender_name'];
			$mail['sender_email'] = $data['sender_email'];
			$mail['name'] = $user['name'];
			$mail['email'] = $user['email'];
			$mail['title'] = '【'.$data['site_name'].'】会員情報変更('.$today.")";
			$body ="会員情報が変更されました。\n\n";
			$body.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
			if($data['flg_mail'])
			{
				// メールアドレスが変更された場合
				if($data['flg_admin']){
					$users[0]['email'] = $data['email1'];
					$users[1]['email'] = $data['email2'];
				}
				$body.="旧メールアドレス：".$users[1]['email']."\n";
				$body.="　↓\n";
				$body.="新メールアドレス：".$users[0]['email'];
			}
			if($data['flg_mail'] && $data['flg_pass'])
			{
				$body.="\n\n";
			}
			if($data['flg_pass'] && $users[2]['email'] != $user['email'])
			{
				// パスワードが変更された場合 =メンバーのみに表示=
				$body.="新パスワード：".$users[0]['password'];
			}
			$body.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
			$body.="送信された日時：".$today."\n";
			$body.="送信者のIPアドレス：".$_SERVER["REMOTE_ADDR"]."\n";
			$body.="送信者のホスト名：".getHostByAddr(getenv('REMOTE_ADDR'))."\n";
			$body.="問い合わせのページURL：".(empty($_SERVER["HTTPS"])?"http://":"https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]."\n";
			$mail['body'] = $body;
			send_auto_mail( $mail );
		}
	}
}
if( $_SERVER['REQUEST_METHOD'] == 'POST' || $_SERVER['REQUEST_METHOD'] == 'GET' )
{
	$buildersObj->get_data($_REQUEST, $form_data);
	$data['title'] = '会員情報修正';
	$data['description'] = '';
	$data['keyword'] = '';
	$form_data['status'] = (!empty($form_data['status'])) ? $form_data['status'] : NULL;
	$form_data['email1'] = (!empty($form_data['email1'])) ? $form_data['email1'] : NULL;
	$form_data['email2'] = (!empty($form_data['email2'])) ? $form_data['email2'] : NULL;
	$form_data['password1'] = (!empty($form_data['password1'])) ? $form_data['password1'] : NULL;
	$form_data['password2'] = (!empty($form_data['password2'])) ? $form_data['password2'] : NULL;
	$mode = (!empty($form_data['mode'])) ? $form_data['mode'] : NULL;
	$form_data['id'] = $id;
	$buildersObj->get_all_sidebar( $sidebars_data );
	$buildersObj->get_all_side_freeareas( $side_freeareas_data );
	
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
		case '5':
			$freearea_middle = htmlspecialchars_decode($sidedata['contents']);
			break;
		}
	}
	$freearea_upper = $buildersObj->txtReplace( $freearea_upper, $user);
	$freearea_upper = $buildersObj->do_plugin( $freearea_upper, $dummy);
	$freearea_middle = $buildersObj->txtReplace( $freearea_middle, $user);
	$freearea_middle = $buildersObj->do_plugin( $freearea_middle, $dummy);
	$freearea_lower = $buildersObj->txtReplace( $freearea_lower, $user);
	$freearea_lower = $buildersObj->do_plugin( $freearea_lower, $dummy);
}
switch($form_data['status'])
{
case 'user_edit':
	if( (int)$_SESSION['auth'] === ADMIN_ROLL )
	{
		$err_message = '管理者情報は管理画面から修正してください。';
		break;
	}
	if( $_SERVER['REQUEST_METHOD'] == 'POST' )
	{
		$update_flg = FALSE;
		$mailsObj = new mails();
		$data['flg_mail'] = FALSE;
		$data['flg_pass'] = FALSE;
		if( !empty( $form_data['email1'] ) & !empty( $form_data['email2'] ))
		{
			$usersObj->check_mailadd( $form_data['email1'] );
			$usersObj->check_mailadd( $form_data['email2'] );
			$usersObj->check_double_mail( $form_data['email1'], $form_data['email2'] );
			$data['flg_mail'] = TRUE;
			$update_flg = TRUE;
			$form_data['password1'] = '';
			$form_data['password2'] = '';
		}
		if( !empty( $form_data['password1'] ) & !empty( $form_data['password2'] ))
		{
			$usersObj->check_pw( $form_data['password1'] );
			$usersObj->check_pw( $form_data['password2'] );
			$usersObj->check_double_pw( $form_data['password1'], $form_data['password2'] );
			$data['flg_pass'] = TRUE;
			$update_flg = TRUE;
			$form_data['email1'] = '';
			$form_data['email2'] = '';
		}
		
		$err = $usersObj->get_err();
		
		if( empty($err) & $update_flg )
		{
			$user_cnt = $usersObj->get_user_cnt( $form_data['email1'] );
			if( $user_cnt > 0 )
			{
				$err['email'] = 'すでに登録されています。';
				break;
			}
			$form_data['name']  = '';
			$form_data['email']  = '';
			$form_data['password']  = '';
			$message = '';
			
			$user_data = $user;
			$mailsObj->get_admin_user($admin_user);
			$users[0]['email'] = '';
			$users[1]['email'] = $email;
			$users[2]['email'] = $admin_user['email'];
			$users[0]['password'] = '';
			$users[1]['password'] = $password;
			$users[2]['password'] = '';
			$users[0]['name'] = $user_data['firstname'];
			$users[1]['name'] = $user_data['firstname'];
			$users[2]['name'] = $admin_user['firstname'];
			if( !empty( $form_data['email1'] ))
			{
				$form_data['email'] = $form_data['email1'];
				$users[0]['email'] = $form_data['email'];
				$email = $form_data['email'];
				$_SESSION[SESSION_USER_ID] = $form_data['email'];
				$usersObj->db_update_users_email( $form_data, $form_data['id'] );
				$message.= 'メールアドレスを更新しました。';
			}
			if( !empty( $form_data['password1'] ))
			{
				$form_data['password'] = $form_data['password1'];
				$users[0]['password'] = $form_data['password'];
				$password = $form_data['password'];
				$_SESSION[SESSION_PASSWORD] = $form_data['password'];
				$usersObj->db_update_users_password( $form_data, $form_data['id'] );
				$message.= 'パスワードを更新しました。';
			}
			$data['sender_name'] = $admin_user['firstname'];
			$data['sender_email'] = $admin_user['email'];
			$data['flg_admin'] = FALSE;
			if( $settings['automail_edit_admin'] & $settings['automail_edit_user'] )
			{
				//管理人＆会員
				if($data['flg_mail'] == FALSE && $data['flg_pass'] == TRUE)
				{
					// パスワードのみ変更は管理者へ送信しない
					$users[2]['email'] = '';
				}
				send_auth_mail( $data, $users );
			}
			elseif( $settings['automail_edit_admin'] )
			{
				//管理人
				// パスワードのみ変更の時はメール送信なし
				if($data['flg_mail'] == FALSE && $data['flg_pass'] == TRUE)
				{
				}else{
					// メールが変更された時は管理者へ送信
					if($data['flg_mail'])
					{
						$data['flg_admin'] = TRUE;
						$data['email1'] = $users[0]['email'];
						$data['email2'] = $users[1]['email'];
						$users[0]['email'] = '';
						$users[1]['email'] = '';
						send_auth_mail( $data, $users );
					}
				}
			}
			elseif( $settings['automail_edit_user'] )
			{
				//会員
				$users[2]['email'] = '';
				send_auth_mail( $data, $users );
			}
			session_regenerate_id(TRUE);
			$form_data['email1'] = NULL;
			$form_data['email2'] = NULL;
			$form_data['email']  = NULL;
			$form_data['password1'] = NULL;
			$form_data['password2'] = NULL;
			$form_data['password']  = NULL;
		}
	}
	break;
default:
	break;
}
$err_email = (!empty($err['email'])) ? '<p class="red small">'.$err['email'].'</p>' : NULL;
$err_pass = (!empty($err['password'])) ? '<p class="red small">'.$err['password']."</p>" : NULL;
$mess = (!empty($message)) ? '<div class="box-blue">'.$message."</div>" : NULL;
$err_mess = (!empty($err_message)) ? '<div class="box-red">'.$err_message."</div>" : NULL;
$change1 = ($settings['automail_edit_user']==1) ? '変更後、新旧２つのメールアドレスに確認メールを送信します。<br>' : '確認メールの送信はしませんのでご注意ください。<br>';
$change2 = ($settings['automail_edit_user']==1) ? '変更後、確認メールを送信します。<br>' : '確認メールの送信はしませんのでご注意ください。<br>';
$data['contents'] = <<< EOF
メールアドレスを変更します。<br>
{$change1}
<br>
{$mess}
{$err_mess}
<dl>
<dt>現在登録されているメールアドレス</dt>
<dd>{$email}</dd>
</dl>
<form name="registform" action="" method="POST">
	<div class="control-group">
	    <label class="b">新しいメールアドレス</label>
		<input type="text" name="email1" id="email1" value="{$form_data['email1']}" placeholder="Email" class="span4" /><br />
		<input type="text" name="email2" id="email2" value="{$form_data['email2']}" placeholder="確認用Email（コピペできません）" class="span4" onPaste="return false"/>
{$err_email}
	</div>
	<button type="submit" name="submit" class="btn btn-primary" id="change_email">メールアドレス変更</button>
	<hr>
	パスワードを変更します。<br>
	{$change2}
	<br>
	<div class="control-group">
	    <label class="b">新しいパスワード</label>
		<input type="password" name="password1" id="password1" value="{$form_data['password1']}" placeholder="Password" class="span4" /><br />
		<input type="password" name="password2" id="password2" value="{$form_data['password2']}" placeholder="確認用Password（コピペできません）" class="span4" onPaste="return false"/>
	</div>
{$err_pass}
	<input type="hidden" name="status" value="user_edit">
	<button type="submit" name="submit" class="btn btn-primary" id="change_pass">パスワード変更</button>
</form>
<script>
	$(function(){
		$("#change_pass").on('click', function(){
			$("#email1").val('');
			$("#email2").val('');
			
		});
		$("#change_email").on('click', function(){
			$("#password1").val('');
			$("#password2").val('');
			
		});
	});
</script>
EOF;
if(!isset($mode))
{
	include('./sidebar.php');
	include('./template/'.$settings_data['top_template']);
} else {
?>
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
		<div id="logotxt"><a href="<?php echo URL; ?>"><?php echo ($data['site_name']) ? $data['site_name'] : 'タイトル'; ?></a></div>
	</div>
</header>
<!-- Content -->
<section id="content">
<div class="wrap-content zerogrid">
<div class="row block">
<div id="main-content" class="col-full">
<div class="wrap-col">
<article>

<div class="heading">
<?php echo '<h2>'.$data['title'].'</h2>'; ?>
<div class="info"></div>
</div>
<div class="content">

<!-- Page original start -->
<?php echo $data['contents']; ?>
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
<?php } ?>
