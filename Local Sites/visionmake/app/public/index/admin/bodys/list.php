<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/doctype.php'); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../common/element/gnav_top.php');?>
</div>
</div>
</div>
</div>
<div class="container">
<div id="content">
<?php require_once(dirname(__FILE__).'/../../common/element/tab_body.php'); ?>
<div id="tabContent" class="tab-content">

<div id="setting">
<div class="row">
<div class="span12">
<h2>自動返信メール設定</h2>
<?php
if(!empty( $message_setting )) {
	echo '<div class="alert alert-success">';
	echo $message_setting;
	echo '</div>';
}
?>
<div class="waku">
	<?php if(isset($err1)){ echo '<div class="alert alert-error">';foreach($err1 as $str){ echo $str.'<br>'; }echo '</div>'; } ?>
	<?php if(isset($message1)){ echo '<div class="alert alert-success">'.$message1.'</div>'; } ?>

	<form accept-charset="utf-8" method="post" id="FormSettings" name="form_settings" action="">

	<div class="control-group" style="margin-top:20px;">
	<p><i style="margin:2px 3px 0 0;" class="icon-ok-sign"></i><span style="font-weight:bold;">登録・解除・修正時の自動返信メール設定</span></p>
	<ul class="thumbnails"><li class="span5">
	<div class="control-group">
	<label class="control-label" for="optionsCheckbox" style="font-weight:bold;">自動返信（管理者）</label>
	<div class="controls">
	<label class="checkbox" for="AutomailAddAdmin">
	<input type="hidden" name="automail_add_admin" value="0">
	<input type="checkbox" name="automail_add_admin" id="AutomailAddAdmin" value="1" <?php if($settings['automail_add_admin'] == 1) echo "checked"; ?>>会員登録フォームからの登録時
	</label>
	<label class="checkbox" for="AutomailStopAdmin">
	<input type="hidden" name="automail_stop_admin" value="0">
	<input type="checkbox" name="automail_stop_admin" id="AutomailStopAdmin" value="1" <?php if($settings['automail_stop_admin'] == 1) echo "checked"; ?>>会員解除フォームからの解除時
	</label>
	<label class="checkbox" for="AutomailEditAdmin">
	<input type="hidden" name="automail_edit_admin" value="0">
	<input type="checkbox" name="automail_edit_admin" id="AutomailEditAdmin" value="1" <?php if($settings['automail_edit_admin'] == 1) echo "checked"; ?>>会員情報修正ページで修正時<br><span class="green">※チェックを入れた場合、<br>会員がメールアドレスを変更した際に管理者に通知します。</span>
	</label>
	</div>
	</div>
	</li>
	<li class="span4">
	<div class="control-group">
	<label class="control-label" for="optionsCheckbox" style="font-weight:bold;">自動返信（会員）</label>
	<div class="controls">
	<label class="checkbox" for="AutomailAddUser">
	<input type="hidden" name="automail_add_user" value="0">
	<input type="checkbox" name="automail_add_user" id="AutomailAddUser" value="1" <?php if($settings['automail_add_user'] == 1) echo "checked"; ?>>会員登録フォームからの登録時
	</label>
	<label class="checkbox" for="AutomailStopUser">
	<input type="hidden" name="automail_stop_user" value="0">
	<input type="checkbox" name="automail_stop_user" id="AutomailStopUser" value="1" <?php if($settings['automail_stop_user'] == 1) echo "checked"; ?>>会員解除フォームからの解除時
	</label>
	<label class="checkbox" for="AutomailEditUser">
	<input type="hidden" name="automail_edit_user" value="0">
	<input type="checkbox" name="automail_edit_user" id="AutomailEditUser" value="1" <?php if($settings['automail_edit_user'] == 1) echo "checked"; ?>>会員情報修正ページで修正時
	</label>
	</div>
	</div>
	</li>
	</ul>
	</div>

	<input type="hidden" name="status" value="form">
	<input type="submit" value="設定変更" class="btn btn-primary">
	</form>

</div>
</div><!-- end of span -->
</div><!-- end of row -->
</div><!-- end of #setting -->

<div id="add">
<div class="row">
<div class="span12">
<h2>登録時自動返信</h2>
<div class="waku">
<p><span class="label label-success">使い方</span></p>
<p style="margin-top:20px;">登録フォームから会員登録した時の自動返信メールを設定します。</p>
<p style="margin-top:0;"><i style="margin-top:0px;" class="icon-ok-sign"></i>右端にある「編集」で編集できます。</p>
</div>
<?php
if(!empty( $message_add )) {
	echo '<div class="alert alert-success">';
	echo $message_add;
	echo '</div>';
}
?>
</div><!-- end of span -->
<div class="span8">
<table cellspacing="0" cellpadding="0">
<thead>
<tr>
<th style="width:30%;">タイトル</th>
<th>本文</th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php
if( isset( $data_add ))
{
	$cnt = $start;
	foreach( $data_add as $col )
	{
		$cnt++;
		$body = nl2br( mb_substr($col['body'], 0, 10000 ));
		$url = URL;
		echo <<< EOD
<tr>
<td>{$col['title']}</td>
<td>{$body}</td>
<td class="actions">
<a href="{$url}/admin/bodys/index.php?status=edit&id={$col['id']}" class="btn btn-primary">編集</a>
</td>
</tr>
EOD;
	}
}
?>
</tbody>
</table>
</div>

<div class="span4">
<?php require(dirname(__FILE__).'/../../common/element/help_re_text.php'); ?>
</div><!-- end of span -->

</div><!-- end of row -->
</div><!-- end of #add -->

<div id="stop">
<div class="row">
<div class="span12">
<h2>解除時自動返信</h2>
<div class="waku">
<p><span class="label label-success">使い方</span></p>
<p style="margin-top:20px;">会員解除した時の自動送信メールを設定します。</p>
<p style="margin-top:0;"><i style="margin-top:0px;" class="icon-ok-sign"></i>右端にある「編集」で編集できます。</p>
</div>
<?php
if(!empty( $message_delete )) {
	echo '<div class="alert alert-success">';
	echo $message_delete;
	echo '</div>';
}
?>
</div><!-- end of span -->
<div class="span8">
<table cellspacing="0" cellpadding="0">
<thead>
<tr>
<th style="width:30%;">タイトル</th>
<th>本文</th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php
if( isset( $data_delete ))
{
	$cnt = $start;
	foreach( $data_delete as $col )
	{
		$cnt++;
		$body = nl2br( mb_substr($col['body'], 0, 10000 ));
		$url = URL;
		echo <<< EOD
<tr>
<td>{$col['title']}</td>
	<td>{$body}</td>
<td class="actions">
<a href="{$url}/admin/bodys/index.php?status=edit&id={$col['id']}" class="btn btn-primary">編集</a>
</td>
</tr>
EOD;
	}
}
?>
</tbody>
</table>
</div>

<div class="span4">
<?php require(dirname(__FILE__).'/../../common/element/help_re_text.php'); ?>
</div><!-- end of span -->

</div><!-- end of row -->
</div><!-- end of #stop -->

</div><!--end of id tabContent-->
</div><!--end of content-->
</div><!--end of container-->
</body>
</html>
