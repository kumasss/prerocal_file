<?php
$active = ' class="active"';
$status = '';
if (!empty($form_data['status']))
{
	if ($form_data['status'] == 'edit_form_add_done')
	{
		$status = 'edit_form_add';
	}
	elseif ($form_data['status'] == 'edit_form_stop_done')
	{
		$status = 'edit_form_stop';
	}
	elseif ($form_data['status'] == 'form_password')
	{
		$status = 'form';
	}
	else{
		$status = $form_data['status'];
	}
}
?>
<h1 style="margin-bottom:20px">会員登録フォーム設定</h1>
<?php require_once( dirname(__FILE__).'/../../common/element/waku_form_add_stop.php'); ?>
<div class="tabbable">
<ul class="nav nav-tabs">
<li<?php if($status=='form')echo $active; ?>><a href="<?php echo URL; ?>/admin/users/?status=form">会員登録フォーム</a></li>
<li<?php if($status=='edit_form_add')echo $active; ?>><a href="<?php echo URL; ?>/admin/users/?status=edit_form_add">登録完了ページ</a></li>
<li<?php if($status=='edit_form_stop')echo $active; ?>><a href="<?php echo URL; ?>/admin/users/?status=edit_form_stop">解除完了ページ</a></li>
</ul>
</div>
