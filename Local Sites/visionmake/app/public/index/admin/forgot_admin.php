<?php
session_start();
require_once( '../common/builders.php' );
require_once( '../common/users.php' );
require_once( '../common/mails.php' );
$buildersObj = new builders();
$usersObj = new users();
$mailsObj = new mails();
if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
	$usersObj->get_data($_REQUEST, $form_data);
}
$errorMessage = "";
$ret = false;
$buildersObj->get_all_setting( $settings_data );
$data['site_name'] = htmlspecialchars_decode( $settings_data['site_name'], ENT_QUOTES );
$email = (isset($form_data['email'])) ? $form_data['email']:NULL;
$status = (isset($form_data['status'])) ? $form_data['status']:NULL;
if($status == "send")
{
	if( $usersObj->get_admin_row($email, $admin_user) )
	{
		$password = $usersObj->make_password();
		$admin_user['password'] = sha1($password);
		$usersObj->db_update_admin( $admin_user, $admin_user['id'] );
		$usersObj->db_update_admin_id( '', $admin_user['id'] );
		
		$body = '';
		$body.="管理者パスワードを再設定しました。\n";
		$body.="IDが設定されていた場合、ID情報もクリアされていますので\n";
		$body.="メールアドレスと下記パスワードにてログイン後、必要に応じて再設定をして下さい。\n";
		$body.="\n";
		$body.="パスワード：".$password."\n";
		$body.="\n";
		$body.="上記パスワードでログイン後、再度管理者パスワードを設定してください。\n";
		
		mb_language("Ja") ;
		mb_internal_encoding("UTF8") ;
		$sender_name = $admin_user['firstname'].$admin_user['lastname'];
		$sender_email = $admin_user['email'];
		$from  = "From:" .mb_encode_mimeheader($sender_name) ."<".$sender_email.">";
		$to = $sender_email;
		$subject = "【".$data['site_name']."】 管理者パスワードを再発行しました。";
		$message = $body;
		$ret = @mb_send_mail($to, $subject, $message, $from);

	}else{
		$errorMessage = '<p style="color:red;">管理者メールアドレスを入力してください。</p>';
	}
}
?>
<?php /***** not login *****/ ?>
<!-- Doctype -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $data['site_name']?>|管理者パスワード再発行(入力ページ)</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/style.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/bootstrap.css">
</head>
<!-- Header -->
<body>
<!-- Content -->
<section id="content">
<div class="row block">
<div id="main-content" class="col-full">
<div class="wrap-col">
<article>
<div class="heading">
<h2 style="border-bottom: 2px solid #919191; line-height: 25px; padding: 10px 0;">管理者パスワード再発行</h2>
<div class="info"></a></div>
</div>
<div class="content">
<?php if ($ret){?>
<p style="color: red">
ご登録の管理者メールアドレスに新しいパスワード送付致しました。
</p>
<input type="button" name="close" value="閉じる" class="btn btn-inverse" onclick="window.close();">
<?php }else{?>
<p>ご登録時のメールアドレスを入力して「送信」ボタンをクリックしてください。</p>
<form method="post" action="">
<fieldset>
<div><?php echo $errorMessage ?></div>
<label for="email">管理者メールアドレス</label>
<input type="text" id="Email" name="email" value="<?php echo $email; ?>" placeholder="Email">
<input type="hidden" name="status" value="send"><br>
<input type="submit" name="send" value="送信" class="btn btn-primary">
<?php }?>
</fieldset>
</form>
</div>
</article>
</div>
</div>
</div>
</section>
</body>
</html>
