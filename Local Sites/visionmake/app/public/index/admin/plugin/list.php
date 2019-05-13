<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../common/element/gnav_builder.php'); ?>
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
	<div class="row">
	<h2>インストール済プラグイン一覧</h2>
	<div class="waku">
	<p><span class="fs20 bold"><i style="margin:7px 3px 0 0;" class="icon-ok-sign"></i></span>コンテンツ作成時に使える各種便利機能です。</p>
	</div>
	<table>
	<thead>
	<tr>
	<th>プラグイン</th>
	<th>説明</th>
	</tr>
	</thead>
	<tbody>
	<?php
	foreach ($plugins as $plugin)
	{
		echo <<< EOD
		<tr>
		<td>{$plugin['name']}</td>
		<td>{$plugin['text']}</td>
		</tr>
EOD;
	}
	?>
	</tbody>
	</table>
	</div>
</div><!--end of containt-->
</div><!--end of container-->
</body>
</html>
