<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../../common/element/doctype.php'); ?>
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
<div class="container">
<div id="content">
<?php require_once(dirname(__FILE__).'/../../../common/element/tab_form_setting.php'); ?>
<div class="titles index">
<div class="waku">
<p><span class="label label-success">使い方</span></p>
<p><span class="fs24">１．</span>下の「メールフォーム追加」ボタンを押して新しいメールフォームを追加します。</p>
<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/builders/tp_inquirys_menu/index.php?status=add">メールフォーム追加</a>
<p style="margin-top:20px;"><span class="fs24">２．</span>一覧表の右端にある「編集・確認」「削除」で編集できます。<br><span class="fs24">　　</span>タイトルクリックでタイトルを編集できます。</p>
</div>
<?php
if(isset( $message )) {
	echo '<div class="alert alert-success">';
	echo $message;
	echo '</div>';
}
?>
<table id="table_id" cellspacing="0" cellpadding="0">
<thead>
<tr>
<th>No</th>
<th>フォームタイトル</th>
<th>メールフォームURL</th>
<th>&nbsp;</th>
</tr>
</thead>
<tbody>
<?php
if( isset( $data ))
{
	$cnt = $start;
	foreach( $data as $col )
	{
		$cnt++;
		$formtitle = nl2br(mb_substr($col['formtitle'], 0, 1000, 'UTF-8'));
		$url = URL;
		if($cnt <> 1) {
			echo <<< EOD
<tr>
<td>{$cnt}</td>
<td><a href="{$url}/admin/builders/tp_inquirys_menu/index.php?status=edit&id={$col['id']}">{$formtitle}</a></td>
<td><a href="{$url}/contact.php?inqid={$col['id']}" target="_blank">{$url}/contact.php?inqid={$col['id']}</a></td>
<td class="actions">
		<a href="{$url}/admin/builders/tp_inquirys/index.php?status=edit_form&id={$col['id']}">編集・確認</a>
<form method="post" style="display:none;" id="post_id{$col['id']}" name="post_id{$col['id']}" action="{$url}/admin/builders/tp_inquirys_menu/index.php?status=delete&id={$col['id']}">
<input type="hidden" value="POST" name="_method">
</form>
<a onclick="if (confirm('このメールフォームを削除しますか？')) { document.post_id{$col['id']}.submit(); } event.returnValue = false; return false;" href="#">削除</a>
</td>
</tr>
EOD;
		} else {
			echo <<< EOD
<tr>
<td>{$cnt}</td>
<td>{$formtitle}</td>
<td><a href="{$url}/contact.php?inqid={$col['id']}" target="_blank">{$url}/contact.php?inqid={$col['id']}</a></td>
<td class="actions">
		<a href="{$url}/admin/builders/tp_inquirys/index.php?status=edit_form&id={$col['id']}">編集・確認</a>
		<a><font color="gray">削除</font></a>

</td>

</tr>
EOD;
		}


	}
}
?>
</tbody>
</table>
</div>
</div>
</div>
</body>
</html>
