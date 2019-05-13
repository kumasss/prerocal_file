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
<h1>メルマガ発行ツール</h1>
<div class="waku">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>ステップメール　</span>「ステップ配信基準日」から起算して何日後に第何話という風に番号順にメールを配信することができます。</p>
<?php
$settingsObj = new settings();
$send_stepmail = $settingsObj->get_send_stepmail();
$send_extramail = $settingsObj->get_send_extramail();
?>
	<div style="margin-bottom:15px;">
	<p><?php echo ($send_stepmail==1)?'<span style="color:green;border-bottom:solid 3px green;margin-right:8px;">ステップメール稼働中</span>':'<span style="color:#CC0000;border-bottom:solid 3px #CC0000;margin-right:8px;">ステップメール停止中</span>';
	?></p>
	</div>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/mails/?status=step">ステップメール</a>
	<p style="margin-top:30px;"><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>号外メール　</span>即時送信したり日時を指定してメールを配信することができます。</p>
	<div style="margin-bottom:15px;">
	<p><?php echo ($send_extramail==1)?'<span style="color:green;border-bottom:solid 3px green;">号外メール稼働中</span>':'<span style="color:#CC0000;border-bottom:solid 3px #CC0000;">号外メール停止中</span>';
	?></p>
	</div>
	<a class="btn btn-primary btn-small" href="<?php echo URL; ?>/admin/mails/?status=extra">号外メール</a>
</div>
<div class="waku" style="margin-top:50px;">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>各種設定　</span>メールの基本設定をします。</p>
	<a class="btn btn-default btn-small" href="<?php echo URL; ?>/admin/settings/">メール基本設定</a>
	<a class="btn btn-default btn-small" href="<?php echo URL;?>/admin/bodys/" style="margin-left:20px">登録/解除時自動返信メール</a>
	<?php
	$mailer = FALSE;
	if (defined('MAILER')) $mailer = MAILER;
	if ($mailer):?>
	<a class="btn btn-default btn-small" href="<?php echo URL;?>/admin/mails/index.php?status=mailer" style="margin-left:20px">SMTP設定</a>
	<?php endif;?>
</div>
</div><!--end of container-->
</body>
</html>
