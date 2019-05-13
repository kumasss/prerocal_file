<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../common/element/gnav_top.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div id="content">
	<h2>会員サイトログインパスワードの設定</h2>
	<div class="waku">
	<p><span class="label label-success">使い方</span></p>
	<p><span class=""></span>現在の会員サイトログインパスワードは「<span style="font-weight:bold;"><?php echo $settings['user_password']; ?></span>」です。</p>
<?php
if(isset($err)){ echo '<div class="alert alert-error">';foreach($err as $str){ echo $str.'<br>'; }echo '</div>'; }
if(isset($message)){ echo '<div class="alert alert-success">'.$message.'</div>'; }
?>
	<form accept-charset="utf-8" method="post" id="UserPassword" name="UserPassword" action="">
	
	<div class="control-group">
	<div class="controls">
	<label class="radio inline">
	<input type="radio" name="options0" id="optionsRadios1" value="0" checked>新規登録用パスワード変更
	</label>
	<label class="radio inline">
	<input type="radio" name="options0" id="optionsRadios2" value="1">全会員一括変更<span class="red">(すべての会員パスワードを変更します)</span>
	</label>
	</div>
	</div>
	
	<label class="control-label" for="email">パスワード</label>
	<input type="text" id="UserUsername" maxlength="50" class="input-xlarge" name="user_password" value="<?php echo $settings['user_password']; ?>">
	<input type="hidden" name="status" value="user_password">
	<div><a onclick="if (confirm('パスワードを変更します。')) { document.UserPassword.submit(); } event.returnValue = false; return false;" href="#" class="btn btn-primary">パスワード変更</a></div>
	</form>
</div>
</div><!--end of containt-->
</div><!--end of container-->
</body>
</html>
