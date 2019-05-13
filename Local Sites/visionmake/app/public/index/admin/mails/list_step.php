<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/doctype.php'); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../common/element/gnav.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<h1>登録メール一覧・メールの作成</h1>
<div class="waku">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>ステップメール　</span>「ステップ配信基準日」から起算して何日後に第何話という風に番号順にメールを配信することができます。</p>
	<div class="form-group">
		<form id="send_stepmail_form" class="form-inline">
		<label class="checkbox" for="SendStepMail">
		<input type="checkbox" value="1" name="send_stepmail" id="SendStepMail" <?php echo ($send_stepmail==1)?'checked="checked"':NULL;?>>
		<span id="send_stepmail_txt">ステップメール</span></label>
	    <span class="help-block">※チェックで稼働・停止を切り替えられます。</span>
		</form>
		<form id="send_now_form" class="form-inline">
		<label class="checkbox" for="SendNow">
		<input type="checkbox" value="1" name="send_now" id="SendNow" <?php echo ($send_now==1)?'checked="checked"':NULL;?>>
		<span id="send_now_txt">ステップメールのストーリNo１を会員登録時に即時送信する</span>
		</label>
		<span class="help-block">※チェックでステップメールのストーリNo１を会員登録時に即時送信する・しないを切り替えます。<br>
		※会員登録・解除時の自動返信メール設定は<a href="<?php echo URL?>/admin/bodys/">こちら</a></span>
		</form>
		<a class="btn btn-primary input-large" href="<?php echo URL; ?>/admin/mails/step/">ステップメール作成</a>
	</div>
</div>
<?php require_once(dirname(__FILE__).'/../../common/element/loading.php'); ?>
<?php require_once(dirname(__FILE__).'/../../common/js/send_stepmail.js'); ?>
<?php require_once(dirname(__FILE__).'/../../common/js/send_now.js'); ?>
<div class="row">
<div class="span2">
<?php $group_url = '/admin/mails/?status=step'; ?>
<?php require_once(dirname(__FILE__).'/../../common/element/group_select_li.php'); ?>
</div>
<div class="span10">
<table cellspacing="0" cellpadding="0">
	<tbody>
	<tr>
		<?php if (is_numeric($form_data['group_id'])):?>
		<th style="text-align:center;">ストーリNo</th>
		<?php endif;?>
		<th><span style="font-size:0.82em;color:green;">グループ(ID)</span><br>タイトル</th>
		<th>配信時期</th>
		<th>配信時間</th>
		<th class="span1">稼働</th>
		<th>&nbsp;</th>
	</tr>
	<?php
if( isset( $step_mails_data ))
{
	$cnt=0;
	foreach( $step_mails_data as $col ):
		$cnt++;
		$group_name = $groupsObj->make_group_name( $groups_data, $col['group_id'] );
		?>
		<tr>
		<?php if (is_numeric($form_data['group_id'])):?>
		<td style="text-align:center;"><?php echo $col['sto_story_no'];?></td>
		<?php endif;?>
		<?php $href = 'window.open("'.URL.'/admin/mails/index.php?status=prev_step&id='.$col['id'].'","extraMail","width=600,height=600,scrollbars=yes,resizable=yes,toolbar=no,location=no,directories=no,status=no,menubar=no");';?>
	<td><span style="font-size:0.82em;color:green;"><?php echo $group_name;?>(<?php echo $col['group_id'];?>)</span><br><a href='#' onclick='javascript:<?php echo $href;?>'><?php echo $col['title'];?></a></td>
		<td><?php echo $col['send_date'];?>日後</td>
		<td><?php echo $col['send_time'];?></td>
		<td><?php echo $col['send_flg'] == 1 ? '<span class="label label-success">稼働中</span>':'<span class="label label-inverse">停止</span>';?> </td>
		<td class="actions">
		<a href="<?php echo URL; ?>/admin/mails/step/index.php?status=edit&id=<?php echo $col['id'];?>" class="label label-info">編集</a>
		<form method="post" style="display:none;" id="del_post_id" name="del_post_id<?php echo $col['id'];?>" action="<?php echo URL; ?>/admin/mails/step/index.php?status=delete&id=<?php echo $col['id'];?>">
		<input type="hidden" value="POST" name="_method">
		</form>
		<a onclick="if(confirm('メールを削除します。')){document.forms['del_post_id<?php echo $col['id'];?>'].submit();} event.returnValue = false; return false;" href="#" class="label label-important">削除</a>
		</td>
	</tr>
	<?php 
	endforeach;
};
?>
	</tbody>
</table>
<?php require_once( dirname(__FILE__).'/../../common/element/mail_page_link.php'); ?>
</div><!--end of span-->
</div><!--end of row-->
</div><!--end of container-->
</body>
</html>
