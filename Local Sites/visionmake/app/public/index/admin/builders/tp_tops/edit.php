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
<form accept-charset="utf-8" method="post" id="ContentsEditForm" class="form-horizontal">
<fieldset>
<legend>トップページ修正</legend>
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
	echo '<div class="waku">トップページを修正します。';
	echo '</div>';
}
?>
<div class="control-group">
<div class="controls">
<button type="submit" class="btn btn-primary" style="margin-right:5px;"><i class="icon-ok icon-white" style="margin:1px 2px 0 0;"></i>ページの保存</button><button id="" class="PreviewBtn btn btn-primary" style="margin-right:5px;"><i class="icon-white icon-eye-open" style="margin:1px 2px 0 0;"></i>プレビュー</button>
</div>
</div>
<div class="control-group">
<label class="control-label" for="keyword">タイトル</label>
<div class="controls required">
<input type="txt" id="ContentsTitle" value="<?php echo $form_data['title']; ?>" class="input-xxlarge" name="title">
</div>
</div>
<div class="control-group">
<label class="control-label" for="description">ディスクリプション</label>
<div class="controls required">
<input type="txt" id="ContentsDescription" value="<?php echo $form_data['description']; ?>" class="input-xxlarge" name="description">
</div>
</div>
<div class="control-group">
<label class="control-label" for="keyword">キーワード</label>
<div class="controls required">
<input type="txt" id="ContentsKeyword" value="<?php echo $form_data['keyword']; ?>" class="input-xxlarge" name="keyword">
</div>
</div>
<div class="control-group">
<label class="control-label" for="ContentsContent"><span class="red">*</span>トップページ記事</label>
<div class="controls required" style="overflow:hidden">
<textarea id="ContentsContent" rows="20" class="span9" name="contents"><?php echo $buildersObj->html_decode($form_data['contents']); ?></textarea>
<div class="green">※実際の表示は選択されたテンプレートのスタイルによって異なります</div>
<div class="green">※インストール済みのプラグイン一覧は<a href="<?php echo URL;?>/admin/plugin/" target="_blank">こちら</a></div>
<?php require_once( '../../../common/element/help_under_textarea.php' );?>
</div>
</div>
<div class="control-group">
<div class="controls">
<span class="red">*</span> がついている項目はかならず入力してください。
</div>
</div>
</fieldset>
<div class="form-actions">
<input type="hidden" value="0" name="add_br">
<input type="hidden" value="1" name="public">
<input type="hidden" value="<?php echo $form_data['id'] ?>" name="id">
<input type="hidden" value="<?php echo $form_data['url'] ?>" name="url">
<input type="hidden" value="edit_done" name="status">
<input type="hidden" value="top" name="layout">
<button type="submit" class="btn btn-primary" style="margin-right:5px;"><i class="icon-ok icon-white" style="margin:1px 2px 0 0;"></i>ページの保存</button><button id="" class="PreviewBtn btn btn-primary" style="margin-right:5px;"><i class="icon-white icon-eye-open" style="margin:1px 2px 0 0;"></i>プレビュー</button>
</div>
</form>
<?php require_once(dirname(__FILE__).'/../../../common/element/preview_js.php'); ?>
</div>
</div><!-- end of titles form -->
</div>
</div>
</body>
</html>
