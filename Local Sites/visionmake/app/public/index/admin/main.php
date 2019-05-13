<?php require_once(dirname(__FILE__).'/../common/element/doctype.php'); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../common/element/gnav_top.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<?php
$acterr = main::get_session( 'acterr', false );
$actflg = main::get_session( 'actflg', false );
if (!empty($acterr) && $actflg=='err')
{
	echo '<div class="alert alert-error">';
	echo $acterr;
	echo '<br><span class="bold">マニュアル通りに設定が完了している場合には10分後に再度ページを読み込むとこのメッセージは消えます。</span><br>';
	echo '<a href="'.URL.'/admin/users/index.php?status=admin">※cronの動作詳細はこちらで確認して下さい。</a>';
	echo '</div>';
}
?>
<div style="float:right;margin-right:10px; text-align: right;">
	Ver.<?php echo $ver = $usersObj->get_version(); ?><br>
	<?php
	$license_flg = main::get_session( 'license_flg', false );
	if($license_flg != 0){echo '<span class="green">ライセンス認証OK</span>';}?>
</div>
<h1>お知らせ</h1>
<?php
	$latest_ver = main::get_session( 'exists_update', false );
	if ( $latest_ver ) {
		$release_date = main::get_session( 'release_date', false );
		echo <<< EOD
<div class="alert alert-error">
<i><img src="../common/img/update.png" width="24"></i>　<strong>{$release_date} に新しいバージョン<span class="fs24" style="vertical-align: -4px;"> {$latest_ver}</span>が公開されています。更新は　<a href="./update_start.php?now_ver={$ver}">ここをクリック</a>　してください。</strong>
<div style="color:black;margin:15px 30px 0;">※更新時には必ず全会員データの<a href="./users/?status=csv">バックアップ</a>を取ってください。</div>
</div>
EOD;
}else{
	// ログイン時に一回ニュース取得してSESSION保存 20170903
	if ( main::get_session( 'news_flg', false ) == false )
	{
		echo '<div id="news" class="alert alert-info" style="min-height:50px"></div>';
		require_once(dirname(__FILE__).'/../common/element/loading.php');
		require_once(dirname(__FILE__).'/../common/js/news.js');
	}else{
		// SESSION保存のお知らせを表示
		$news = main::get_session( 'news', false );
		echo '<div id="news" class="alert alert-info" style="min-height:50px">'.$news.'</div>';
	}
}
?>
<h2 style="margin-top:50px;">会員サイト構築システムツール選択</h2>
<div class="waku">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>サイト作成ツール　</span>会員がログインして閲覧するコンテンツをつくることができます。</p>
	<a class="btn btn-primary" href="<?php echo URL.'/admin/builders/index.php'; ?>"><i style="margin:-1px 3px 0 0;" class="icon-th-large icon-white"></i>サイト作成ツール</a>
</div>
<div class="waku" style="margin-top:50px;">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>メインメルマガ発行ツール　</span>会員にメールマガジンを発行することができます。</p>
<?php
$settingsObj = new settings();
$send_stepmail = $settingsObj->get_send_stepmail();
$send_extramail = $settingsObj->get_send_extramail();
?>
<div style="margin-bottom:15px;">
<p>現在、<?php echo ($send_stepmail==1)?'<span style="color:green;border-bottom:solid 3px green;margin-right:8px;">ステップメールは稼働中</span>':'<span style="color:#CC0000;border-bottom:solid 3px #CC0000;margin-right:8px;">ステップメールは停止中</span>';echo '';echo ($send_extramail==1)?'<span style="color:green;border-bottom:solid 3px green;">号外メールは稼働中</span>':'<span style="color:#CC0000;border-bottom:solid 3px #CC0000;">号外メールは停止中</span>';
?>です。</p>
</div>
	<a class="btn btn-primary" href="<?php echo URL.'/admin/mails/index.php'; ?>"><i style="margin:0 3px 0 0;" class="icon-envelope icon-white"></i>メインメルマガ発行ツール</a>
</div>
<?php if($usersObj->is_unit_folder()): ?>
<div class="waku" style="margin-top:50px;">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>ユニットメールツール　</span>ユニットメールを作成します。ユニットに登録されたメンバーはメインメルマガにも自動登録されます。</p>
	<a class="btn btn-primary" href="<?php echo URL; ?>/admin/units/"><i style="margin:0 3px 0 0;" class="icon-envelope icon-white"></i>ユニットメールツール</a>
</div>
<?php endif; ?>
</div><!--end of container-->
</body>
</html>
