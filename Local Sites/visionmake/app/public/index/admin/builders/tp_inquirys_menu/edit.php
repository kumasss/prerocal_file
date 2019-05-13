<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>
<div class="container" id="container">
<div id="content">
<div id="message"></div>
<div class="titles form">
<form accept-charset="utf-8" method="post" id="FormTitleEditForm" action="">
<fieldset>
<legend>メールフォームのタイトル編集</legend>
<?php
if( isset( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str )
	{
		echo $str;
	}
	echo '</div>';
}
elseif(isset( $message )) {
	echo '<div class="alert alert-success">';
	echo $message;
	echo '</div>';
}
else {
	echo '<div class="waku"><p>メールフォームのタイトルを編集します。</p>';
	echo '</div>';
}
?>
<div class="control-group">
<label class="control-label" for="title">メールフォームのタイトル</label>
<span class="red">*</span>
<div class="controls required">

<input type="txt" id="formtitle" value="<?php echo $form_data['formtitle']; ?>" class="input-large" name="formtitle">
<div class="green fs12">メールフォーム一覧の表示タイトルになります。<br>管理者に送信されるメールの件名にも利用されます。</div>


</div>
</div>
</fieldset>
<div class="form-actions">
<input type="hidden" value="edit_done" name="status">
<button type="submit" class="btn btn-primary" style="margin-right:5px;">保存</button><a class="btn" href="<?php echo URL; ?>/admin/builders/tp_inquirys_menu/">キャンセル</a></div></form>
</div>
</div>
</div>
</body>
</html>
