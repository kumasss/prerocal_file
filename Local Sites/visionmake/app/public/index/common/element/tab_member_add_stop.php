<?php
$active = ' class="active"';
$status = '';
if (!empty($form_data['status']))
{
	if ($form_data['status'] == 'user_csv_upload')
	{
		$status = 'csv';
	}
	elseif ($form_data['status'] == 'user_add')
	{
		$status = 'add';
	}
	elseif ($form_data['status'] == 'user_search')
	{
		$status = 'default';
	}
	else{
		$status = $form_data['status'];
	}
}
?>
<h2 style="margin-bottom:20px">会員管理</h2>
<div class="tabbable">
<ul class="nav nav-tabs">
<li<?php if($status=='default')echo $active; ?>><a href="<?php echo URL; ?>/admin/users/">会員検索</a></li>
<li<?php if($status=='add')echo $active; ?>><a href="<?php echo URL; ?>/admin/users/?status=add">テキスト登録・停止</a></li>
<li<?php if($status=='csv')echo $active; ?>><a href="<?php echo URL; ?>/admin/users/?status=csv">CSVファイル</a></li>
</ul>
</div>
