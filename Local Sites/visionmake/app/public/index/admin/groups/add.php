<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../common/element/gnav_top.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<?php require_once( dirname(__FILE__).'/../../common/element/tab_form_group.php'); ?>
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
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>グループ追加　</span>グループ名を日本語２０文字までで設定できます。</p>
	<p><span class="red">※グループを削除する場合は先に会員、メール、コンテンツを該当グループから移動するか削除してください。</span></p>
	<form accept-charset="utf-8" method="post" id="groupNameForm" class="form-inline">
	<label class="control-label" for="description">グループ名</label>
	<input type="txt" id="groupNameTitle" value="<?php echo $form_data['group_name']; ?>" class="input-xlarge" name="group_name" placeholder="グループ名">
	<!--input type="hidden" value="edit" name="status"-->
	<button type="submit" name="status" value="add" class="btn btn-primary" style="margin-right:5px;">グループ追加</button>
	</form>
</div>
<table id="" cellspacing="0" cellpadding="0" style="margin-bottom:50px;">
	<thead>
	<tr>
		<th class="span1" style="text-align:center;">グループID</th>
		<th class="span4">グループ名</th>
		<th class="span1" style="text-align:center;">会員数</th>
		<th class="span1" style="text-align:center;">コンテンツ数</th>
		<th class="span2" style="text-align:center;">メール数<br><span style="font-size:8px;">ステップ / 号外</span></th>
		<th class="span1" style="text-align:center;">商品数</th>
		<th class="span1">&nbsp;</th>
		<th class="span1">&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	if( isset( $groups_data )):
		foreach( $groups_data as $col ):
			if( !empty($col['group_name']) ):
	?>
	<tr>
		<td style="text-align:center;">
		<?php echo $col['id']; ?>
		</td>
		<td>
		<?php echo $col['group_name']; ?>
		</td>
		<td style="text-align:center;">
		<?php echo $cnt_u=$groupsObj->count_group( $col['id'] ); ?>
		</td>
		<td style="text-align:center;">
		<?php echo $cnt_c=$groupsObj->count_content_in_group( $col['id'] );?>
		</td>
		<td style="text-align:center;">
		<?php $cnt_m=$groupsObj->count_mail_in_group( $col['id'] ); echo $cnt_m['step'].' / '.$cnt_m['extra'];?>
		</td>
		<td style="text-align:center;">
		<?php echo $cnt_p = $paymentObj->count_product_in_group($col['id']);?>
		</td>
		<td>
		<?php if($col['id']!=1):?>
		<a href="<?php echo URL; ?>/admin/groups/index.php?status=edit&id=<?php echo $col['id'];?>">修正</a>
		<?php endif;?>
		</td>
		<td>
		<?php if($col['id']!=1 & $cnt_u==0 & $cnt_c==0 & $cnt_m['step']==0 & $cnt_m['extra']==0 & $cnt_p==0):?>
		<form method="post" style="display:none;" id="delId<?php echo $col['id'] ?>" name="del_id<?php echo $col['id'] ?>" action="<?php echo URL; ?>/admin/groups/index.php?status=delete&id=<?php echo $col['id'];?>">
		<input type="hidden" value="POST" name="_method">
		</form>
		<a onclick="if (confirm('グループを削除します。')) { document.forms['del_id<?php echo $col['id'] ?>'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
		<?php endif;?>
		</td>
	</tr>
	<?php 
			endif;
		endforeach;
	endif;
	?>
	</tbody>
</table>
</div><!-- end of container -->
</body>
</html>
