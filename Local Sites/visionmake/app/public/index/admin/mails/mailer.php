<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../common/element/gnav.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div class="users form">
	<form accept-charset="utf-8" method="post" id="smtpEditForm" class="form-horizontal" action="">
	<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
	<fieldset>
		<legend>SMTPサーバー設定</legend>
		<div class="waku">SMTPサーバーを使用して送信する場合の設定をします。<br><span class="red">※「SMTP送信を使用する」を選択した場合、認証ユーザーに簡易メールを送信します。</span></div>

<?php
if (!empty($e_meaasage))
{
	echo '<div class="alert alert-error">'.$e_meaasage.'</div>';
}
elseif (!empty($message)) {
	echo '<div class="alert alert-success">'.$message.'</div>';
}
?>
		<div class="control-group">
		<label class="control-label" for="optionsCheckbox">SMTP送信</label>
		<div class="controls">
		<label class="checkbox" for="IsSmtp">
		<input type="hidden" name="is_smtp" value="0">
		<input type="checkbox" name="is_smtp" id="IsSmtp" value="1" <?php if($form_data['is_smtp'] == 1) echo "checked"; ?>>使用する
		</label>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">サーバー名</label>
		<div class="controls required">
		<input type="txt" id="Host" value="<?php echo $form_data['host']; ?>" class="input-large" name="host">
		<?php if( !empty( $err['host'] )) {
			echo '<div class="red fs12">'.$err['host'].'</div>';
		}?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">ポート番号</label>
		<div class="controls required">
		<input type="txt" id="Port" value="<?php echo $form_data['port']; ?>" class="input-large" name="port">
		<div class="green fs12">※エックスサーバーの場合：465（SSLを利用しない場合は 587）</div>
		<?php if( !empty( $err['port'] )) {
			echo '<div class="red fs12">'.$err['port'].'</div>';
		}?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">ユーザー名</label>
		<div class="controls required">
		<input type="txt" id="UserName" value="<?php echo $form_data['username']; ?>" class="input-large" name="username">
		<?php if( !empty( $err['username'] )) {
			echo '<div class="red fs12">'.$err['username'].'</div>';
		}?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">パスワード</label>
		<div class="controls required">
		<input type="txt" id="Password" value="<?php echo $form_data['password']; ?>" class="input-large" name="password">
		<?php if( !empty( $err['password'] )) {
			echo '<div class="red fs12">'.$err['password'].'</div>';
		}?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">セキュア接続</label>
		<div class="controls">
		<label class="radio">
		<input type="radio" name="secure" id="Secure0" value="0" <?php if($form_data['secure'] == 0) echo "checked"; ?>>なし
		</label>
		<label class="radio">
		<input type="radio" name="secure" id="Secure1" value="1" <?php if($form_data['secure'] == 1) echo "checked"; ?>>SSL
		</label>
		<label class="radio">
		<input type="radio" name="secure" id="Secure2" value="2" <?php if($form_data['secure'] == 2) echo "checked"; ?>>TLS
		</label>
		</div>
		</div>
	</fieldset>
	<div class="form-actions">
	<input type="hidden" value="<?php echo $form_data['id'] ?>" name="id">
	<input type="hidden" value="edit_mailer" name="status">
	<button type="submit" class="btn btn-primary" style="margin-right:5px" data-loading-text="保存中...">　保存　</button><a class="btn" href="<?php echo URL; ?>/admin/mails/">戻る</a>
	</div>
	</form>
</div>
<?php require_once(dirname(__FILE__).'/../../common/element/loading.php'); ?>
<script type="text/javascript">
	// 連打対策
	$(document).ready( function() {
		$("#loading").hide();
		$('[type="submit"]').click(function(){
			$("#loading").show();
			$(this).button('loading');
			$(this).prop('disabled',true);
			$(this).closest('form').submit();
		});
	});
</script>
</body>
</html>
