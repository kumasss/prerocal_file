<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/doctype.php' );?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../common/element/gnav.php');?>
</div>
</div>
</div>
</div>
<div class="container">
<h1>登録メール一覧・メールの作成</h1>
<div class="waku">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>号外メール　</span>即時送信したり日時を指定してメールを配信することができます。</p>
	<div class="form-group">
		<form id="send_extramail_form" class="form-inline">
		<label class="checkbox" for="SendExtraMail">
		<input type="checkbox" value="1" name="send_extramail" id="SendExtraMail" <?php echo ($send_extramail==1)?'checked="checked"':NULL;?>>
		<span id="send_extramail_txt">号外メール</span></label>
	    <span class="help-block">※チェックで稼働・停止を切り替えられます。<br>
	    ※会員登録・解除時の自動返信メール設定は<a href="<?php echo URL?>/admin/bodys/">こちら</a></span>
		</form>
		<a class="btn btn-primary input-large" href="<?php echo URL; ?>/admin/mails/extra/">号外メール作成</a>
	</div>
</div>
<?php require_once(dirname(__FILE__).'/../../common/element/loading.php');?>
<?php require_once(dirname(__FILE__).'/../../common/js/send_extramail.js');?>
<div class="row">
<div class="span2">
<?php $group_url = '/admin/mails/?status=extra'; ?>
<?php require_once(dirname(__FILE__).'/../../common/element/group_select_li.php');?>
</div>
<div class="span10">
<table cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<th><span style="font-size:0.82em;color:green;">グループ(ID)</span><br>タイトル</th>
		<th>配信日</th>
		<th>配信時間</th>
		<th>配信完了</th>
		<th style="width:60px;text-align:center;">複製して作成</th>
		<th>&nbsp;</th>
	</tr>
<?php
if( isset( $extra_mails_data )):
	$cnt = 0;
	foreach( $extra_mails_data as $col ):
		$cnt++; 
		$is_on = $logsObj->check_extra_mail_log($col['id'], 99);
		$group_name = $groupsObj->make_group_name( $groups_data, $col['group_id'] );
	?>
	<tr>
		<?php $href = 'window.open("'.URL.'/admin/mails/index.php?status=prev_extra&id='.$col['id'].'","extraMail","width=600,height=600,scrollbars=yes,resizable=yes,toolbar=no,location=no,directories=no,status=no,menubar=no");';?>
		<td><span style="font-size:0.82em;color:green;"><?php echo $group_name;?>(<?php echo $col['group_id'];?>)</span><br><a href='#' onclick='javascript:<?php echo $href;?>'><?php echo $col['title'];?></a></td>
		<td><?php echo $col['send_date'];?></td>
		<td><?php echo $col['send_time'];?></td>
		<td><?php echo $col['send_done_date'];?><br><?php echo $col['send_done_time'];?><?php if($is_on){echo '<span style="color:#c55">[送信中…]</span>';}?></td>
		<td style="text-align:center;"><?php echo (!empty($col['send_done_date']))?'<a href="'.URL.'/admin/mails/extra/index.php?status=add&id='.$col['id'].'" class="label label-warning big">複製</a>':NULL;?></td>
		<td class="actions">
<?php if($is_on){echo '<span class="label label-important">送信中</span>';}elseif($col['send_done_date']){echo '<span class="label label-success">送信済</span>';}else{echo '<a href="'.URL.'/admin/mails/extra/index.php?status=edit&id='.$col['id'].'">編集</a>';} ?>
		<form method="post" style="display:none;" id="del_post_id" name="del_post_id<?php echo $col['id'];?>" action="<?php echo URL; ?>/admin/mails/extra/index.php?status=delete&id=<?php echo $col['id'];?>">
		<input type="hidden" value="POST" name="_method">
		</form>
		<a onclick="if (confirm('メールを削除します。')) { document.forms['del_post_id<?php echo $col['id'];?>'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
		</td>
	</tr>
<?php 
	endforeach;
endif
;?>
	</tbody>
</table>
<?php require_once( dirname(__FILE__).'/../../common/element/mail_page_link.php'); ?>
</div><!--end of span-->
</div><!--end of row-->
</div>
</body>
</html>
