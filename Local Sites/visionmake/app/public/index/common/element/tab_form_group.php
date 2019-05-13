<?php
$active = ' class="active"';
$status = '';
if (!empty($form_data['status']))
{
	if ($form_data['status'] == 'default')
	{
		$status = 'add';
	}
	elseif ($form_data['status'] == 'changegroup')
	{
		$status = 'changegroup';
	}
	else{
		$status = $form_data['status'];
	}
}
?>
<h2 style="margin-bottom:20px">グループの設定</h2>
<div class="tabbable">
<ul class="nav nav-tabs">
<li<?php if($status=='add')echo $active; ?>><a href="<?php echo URL; ?>/admin/groups/">グループ追加・削除</a></li>
<li<?php if($status=='changegroup')echo $active; ?>><a href="<?php echo URL; ?>/admin/users/?status=changegroup">グループ移動用URL設定</a></li>
</ul>
</div>
