<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( dirname(__FILE__).'/../../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>

<div class="container" id="container">
<div id="content">
<div id="message"></div>

<div class="form-actions">
<a class="btn" href="<?php echo URL; ?>/admin/builders/tp_inquirys_menu/">フォーム一覧に戻る</a>
</div>

<div class="titles form">
<?php require_once( dirname(__FILE__).'/../../../common/element/tab_form_setting_mailform.php'); ?>
<form accept-charset="utf-8" method="post" id="InquirysEditForm" action="">
<fieldset>
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
	echo '<div class="waku">お問い合せフォーム上部のお知らせ欄を編集します。';
	echo '</div>';
}
?>
<div class="row">
<div class="span8">
<div class="control-group">
<label class="control-label" for="contents">本文</label>
<div class="controls required">
<textarea id="ContentsInquiry" class="span8" cols="5" rows="10" style="height:320px" name="info"><?php echo $form_data['info']; ?></textarea>
</div>
</div>
</div><!-- end of span -->
<div class="span4">
<?php require(dirname(__FILE__).'/../../../common/element/help_re_text.php'); ?>
</div><!--end of span-->
</div><!-- end of row -->
</fieldset>
<div class="form-actions">
<input type="hidden" value="edit_info_done" name="status">
<input type="hidden" value="<?php echo $form_data['id']; ?>" name="id">
<button type="submit" class="btn btn-primary" style="margin-right:5px;">保存</button><a class="btn" href="<?php echo URL; ?>/admin/builders/tp_inquirys_menu/">キャンセル</a></div>
</form>
</div>
</div>
</div>
</body>
</html>
