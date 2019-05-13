<?php
//複数メールフォーム対応  2016/3/21
$active = ' class="active"';
$status = '';
if(!empty($form_data['status'])){
	$status = $form_data['status'];
}
if( isset($form_data['id']))
{
	$_SESSION['id'] = $form_data['id'];
}
if( isset($form_data['formtitle']))
{
	$_SESSION['formtitle'] = $form_data['formtitle'];
}

?>
<h2 style="margin-bottom:20px">「<?php echo $_SESSION['formtitle'];?>」フォーム設定</h2>

<div class="tabbable">
<ul class="nav nav-tabs">
<li<?php if($status=='edit_form')echo $active; ?>><a href="<?php echo URL; ?>/admin/builders/tp_inquirys/?status=edit_form&id=<?php echo $_SESSION['id'];?>">フォーム設定</a></li>
<li<?php if($status=='edit_info')echo $active; ?>><a href="<?php echo URL; ?>/admin/builders/tp_inquirys/?status=edit_info&id=<?php echo $_SESSION['id'];?>">ページ上部自由入力欄</a></li>
<li<?php if($status=='')echo $active; ?>><a href="<?php echo URL; ?>/admin/builders/tp_inquirys/edit_item/?id=<?php echo $_SESSION['id'];?>">項目編集</a></li>
<li<?php if($status=='edit')echo $active; ?>><a href="<?php echo URL; ?>/admin/builders/tp_inquirys/?status=edit&id=<?php echo $_SESSION['id'];?>">自動返信メール編集</a></li>
<li<?php if($status=='search')echo $active; ?>><a href="<?php echo URL; ?>/admin/builders/tp_inquirys/?status=search&id=<?php echo $_SESSION['id'];?>">受信一覧</a></li>
</ul>
</div>
