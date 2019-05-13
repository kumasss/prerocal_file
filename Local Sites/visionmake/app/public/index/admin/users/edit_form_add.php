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
<div class="container" id="container">
<div id="content">
<div class="titles form">
<?php require_once( dirname(__FILE__).'/../../common/element/tab_form_add_stop.php'); ?>
<h2>登録完了ページ設定</h2>
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
?>
<div style="padding:0px 20px;margin:8px 0;background-color:#fff;">
<button type="submit" class="btn btn-primary" style="margin-right:5px;"><i class="icon-ok icon-white" style="margin:1px 2px 0 0;"></i>保存　</button>
</div>
<div class="well"><i style="margin:0 3px 0 0;" class="icon-ok-sign"></i>会員登録完了ページに表示されるメッセージを編集します。<br><span style="margin:0 3px 0 0;">　</span>会員登録ページは<a href="<?php echo URL?>/formadd/" target="_blank">こちら</a></div>
<div class="control-group">
<label class="control-label" for="contents">
<span class="red">*</span>本文</label>
<div class="controls required">
<textarea id="ContentsInquiry" rows="6" class="input-xxlarge" cols="5" name="form_add_done_message"><?php echo $form_data['form_add_done_message']; ?></textarea>
</div>
</div>
</fieldset>
<fieldset>
<div class="well"><i style="margin:0 3px 0 0;" class="icon-ok-sign"></i>登録完了ページにコンバージョンタグ等を入れたい場合はこちらをご利用ください。</div>
<div class="control-group">
<label class="control-label" for="head">&lt;/head&gt;の前に出力したい場合はこちら。</label>
<div class="controls required">
<textarea id="ContentsInquiry" rows="6" class="input-xxlarge" cols="5" name="form_head_script_add"><?php echo $form_data['form_head_script_add']; ?></textarea>
</div>
</div>
<div class="control-group">
<label class="control-label" for="body">&lt;/body&gt;の前に出力したい場合はこちら。</label>
<div class="controls required">
<textarea id="ContentsInquiry" rows="6" class="input-xxlarge" cols="5" name="form_body_script_add"><?php echo $form_data['form_body_script_add']; ?></textarea>
</div>
</div>
</fieldset>
<div style="padding:8px 20px;margin:8px 0;background-color:#eee;">
<input type="hidden" value="edit_form_add_done" name="status">
<input type="hidden" value="<?php echo $form_data['message_id']; ?>" name="message_id">
<input type="hidden" value="<?php echo $form_data['script_id']; ?>" name="script_id">
<button type="submit" class="btn btn-primary" style="margin-right:5px;"><i class="icon-ok icon-white" style="margin:1px 2px 0 0;"></i>保存　</button>
</div>
</form>
</div>
</div>
</div>
</body>
</html>
