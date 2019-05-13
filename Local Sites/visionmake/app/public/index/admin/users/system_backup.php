<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/doctype.php');?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../common/element/gnav_top.php');?>
</div>
</div>
</div>
</div>

<div class="container">
<div id="content">
<?php
if( !empty( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str ){echo $str.'<br>';}
	echo '</div>';
}
?>
	<div class="users index">
	<div id="user_search">
	<h2>システムデータダウンロード</h2>
	<div class="waku">
	<p><span class="fs20 bold"><i style="margin:7px 3px 0 0;" class="icon-ok-sign"></i></span>Cyfonsシステムのデータベース情報をダウンロードします。</p>
	<form id="UserCsvDownloadForm" accept-charset="utf-8" method="post" action="">
	<input type="hidden" name="status" value="get_system_backup">
	<input class="btn btn-primary btn-small" type="submit" value="システムバックアップ">
	</form>
	</div>
	</div>
	</div>
</div><!--end of containt-->
</div><!--end of container-->
</body>
</html>
