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
<h1>グループの設定</h1>
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
}
?>

<div class="waku" style="margin:20px 0;">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>グループ名修正　</span>グループ名を日本語２０文字までで設定できます。</p>
	<form accept-charset="utf-8" method="post" id="groupNameForm" class="form-inline">
	<label class="control-label" for="description">グループ名</label>
	<input type="txt" id="groupNameTitle" value="<?php echo $groups_data['group_name']; ?>" class="input-xlarge" name="group_name" placeholder="グループ名">
	<input type="hidden" value="<?php echo $groups_data['group_code']; ?>" name="group_code">
	<button type="submit" name="status" value="edit_done" class="btn btn-primary" style="margin-right:5px;">グループ名修正</button>
	<a href="<?php echo URL?>/admin/groups/" class="btn btn-default">戻る</a>
	</form>
</div>
</body>
</html>
