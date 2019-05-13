<?php
session_start();
require_once('site-config.php');
require_once( './common/builders.php' );
require_once( './common/users.php' );
require_once( './common/mails.php' );
$buildersObj = new builders();
$usersObj = new users();
$mailsObj = new mails();

$buildersObj->get_all_setting( $settings_data );
$data['site_name'] = htmlspecialchars_decode( $settings_data['site_name'], ENT_QUOTES );
$errorMessage = "";
$ret = false;
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : "";
$mode = isset($_POST['mode']) ? $_POST['mode'] : "";
if($mode == "send")
{
	$user_id = htmlspecialchars(trim($user_id));
	if ( $usersObj->get_user_row( $user_id, $user ) )
	{
		// メール送信
		$mailsObj->get_admin_user($admin_user);
		
		$body = '';
		$body.="パスワードをお送りいたします。\n";
		$body.="\n";
		$body.="パスワード：".$user['password']."\n";
		
		mb_language("Ja") ;
		mb_internal_encoding("UTF8") ;
		$sender_name = $admin_user['firstname'].$admin_user['lastname'];
		$sender_email = $admin_user['email'];
		$from  = "From:" .mb_encode_mimeheader($sender_name) ."<".$sender_email.">";
		$name  = (!empty($user['firstname'])) ? $user['firstname']:'';
		$name .= (!empty($user['lastname'])) ? $user['lastname']:'';
		$to = mb_encode_mimeheader($name) ."<".$user['email'].">";
		$subject = "【".$data['site_name']."】 パスワードを送信しました。";
		$message = $body;
		$ret = @mb_send_mail($to, $subject, $message, $from);

	}else{
		$errorMessage = '<p style="color:red;">メールアドレスを正確に入力してください。</p>';
	}
	
}
?>
<?php /***** not login *****/ ?>
<!-- Doctype -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $data['site_name']?>|パスワードを忘れた方(入力ページ)</title>
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
<h2 style="border-bottom: 2px solid #919191; line-height: 25px; padding: 10px 0;">パスワードを忘れた方</h2>
<div class="info"></a></div>
</div>
<div class="content">

<?php if ($ret){?>
<p style="color: red">
ご登録メールアドレスに送付致しました。
</p>
<input type="button" name="close" value="閉じる" class="btn btn-inverse" onclick="window.close();">
<?php }else{?>
<p style="color: red">
ご登録時のメールアドレスを入力して「送信」ボタンをクリックしてください。
</p>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<input type="hidden" name="mode" value="send">
<fieldset>
<div><?php echo $errorMessage ?></div>
<label for="userid">User ID</label><input type="text" id="user_id" name="user_id" value="<?php echo $user_id; ?>">
<br>
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
</body></html>
