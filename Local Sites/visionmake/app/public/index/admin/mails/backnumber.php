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
<div id="content">
<?php
if( !empty( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str ){echo $str.'<br>';}
	echo '</div>';
}
?>
	<div class="users index">
	<div id="user_search">
	<h2>メールバックナンバー取得</h2>
	<div class="waku">
	<p style="margin-bottom:20px;"><span class="fs20 bold"><i style="margin:7px 3px 0 0;" class="icon-ok-sign"></i></span>ステップメールのバックナンバーを表示するショートコードを取得できます。</p>
<div class="control-group">
<label class="control-label" for="group_id"><span class="bold">ショートコード</span><span class="red">※このコードをコピーしてコンテンツページ本文内にペーストしてください。</spna></label>
<div class="controls" style="margin-bottom:20px;border-bottom:1px solid #cacaca">
<label ="control-label">
<input type="text" id="shortCode" name="" class="span7" value="[group id=0 num=10]">
</label>
</div>
</div>
	<form id="UserBackNumberForm" class="form-horizontal" accept-charset="utf-8" method="post" action="">
<fieldset>
<div class="control-group">
<label class="control-label" for="group_id"><span class="bold">グループ</span></label>
<div class="controls">
<label class="radio inline"><input type="radio" id="groupId0" name="group_id" value="0" checked	>全グループ</label>
<label class="radio inline"><input type="radio" id="groupId1" name="group_id" value="1">所属グループ</label>
</div>
</div>
<div class="control-group">
<label class="control-label" for="group_id"><span class="bold">メール表示数</span></label>
<div class="controls required">
<select id="term" class="input-small" name="term">
<option value="">全数</option>
<option value="3">3</option>
<option value="5">5</option>
<option value="10">10</option>
<option value="30">30</option>
<option value="50">50</option>
<option value="100">100</option>
</select>
</div>
</div>
<div class="controls">
	<input type="hidden" name="status" value="backnumber">
	<input class="btn btn-primary btn-small" type="submit" value="ショートコード発行">
</div>
</fieldset>
	</form>
	</div>
	</div>
	</div>
</div><!--end of containt-->
</div><!--end of container-->
</body>
</html>
