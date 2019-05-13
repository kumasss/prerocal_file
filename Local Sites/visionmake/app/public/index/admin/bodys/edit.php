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
<div id="message"></div>
<div class="titles form">
<form accept-charset="utf-8" method="post" id="TitleEditForm" action="">
<fieldset>
<?php
$id = $form_data['id'];
if ($id == 1){
echo '<legend>登録時自動送信メール編集</legend>';
	$hash = "#add";
}else if ($id == 2){
echo '<legend>解除時自動送信メール編集</legend>';
	$hash = "#stop";
}else{
echo '<legend>err!!!想定しないidです。</legend>';
	$hash = "";
}
?>
<div class="form-actions" style="margin-top:0px">
<button type="submit" class="btn btn-primary" style="margin-right:5px;">保存</button><a class="btn" href="<?php echo URL; ?>/admin/bodys/<?php echo $hash?>">戻る</a>
</div>
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
else {
	echo '<div class="waku">自動返信メールのテンプレートを作成します。';
	echo '</div>';
}
?>
<div class="row">
<div class="span8">
<div class="control-group">
<label class="control-label" for="title">
<span class="red">*</span>タイトル</label>
<div class="controls required">
<input type="txtarea" id="TitleContent" class="span8" value="<?php echo $form_data['title']; ?>" name="title">
</div>
<label class="control-label" for="body">
<span class="red">*</span>本文</label>
<div class="controls required">
<textarea id="BodyContent" class="span8" cols="10" rows="10" style="width:98%;height:250px;" name="body"><?php echo $form_data['body']; ?></textarea>
</div>
</div><!-- end of control-group -->
</div><!--end of span-->

<div class="span4">
<?php require(dirname(__FILE__).'/../../common/element/help_re_text.php'); ?>
</div><!--end of span-->
</div><!-- end of row -->
</fieldset>

<div class="form-actions">
<input type="hidden" value="<?php echo $id?>" name="hash">
<input type="hidden" value="edit_done" name="status">
<button type="submit" class="btn btn-primary" style="margin-right:5px;">保存</button><a class="btn" href="<?php echo URL; ?>/admin/bodys/<?php echo $hash?>">戻る</a>
</div>
</form>

</div>
</div>
</body>
</html>
