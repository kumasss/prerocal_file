<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../common/element/gnav_top.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div id="content">
<?php require_once( dirname(__FILE__).'/../../common/element/tab_member_add_stop.php'); ?>
<?php
if( !empty( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str ){echo $str.'<br>';}
	echo '</div>';
}
if( is_array( $result ))
{
	echo '<div>';
	echo '全'.$result['cnt_text'].'件中'.$result['cnt_success'].'件の処理をしました。';
	echo '</div>';
	if( !empty( $result['err'] ))
	{
		echo '<div class="alert alert-error">';
		foreach( $result['err'] as $err )
		{
			echo (isset($err['massage'])) ? $err['massage'] : NULL ;
			echo (isset($err['data'])) ? $err['data'] : NULL ;
			echo '<br />';
		}
		echo '</div>';
	}
	elseif( ($result['status']==0 or $result['status']==1) && $result['cnt_success'] > 0 )
	{
		echo '<div class="alert alert-success">';
		echo '正常に登録されました。';
		echo '</div>';
	}
}
?>
	<div class="users index">
	<div id="user_search">
	<h3>CSVファイルダウンロード</h3>
	<div class="waku">
	
	<p><span class="fs20 bold"><i style="margin:7px 3px 0 0;" class="icon-ok-sign"></i></span>正常会員データをCSVファイルでダウンロードできます。<br>　<span class="red">※メルマガ停止・エラーの方を省いたリストをダウンロードします</span></p>
	<form id="UserNormalCsvDownloadForm" accept-charset="utf-8" method="post" action="">
	<input type="hidden" name="status" value="user_normal_csv">
	<input class="btn btn-primary btn-small" type="submit" value="正常会員ダウンロード">
	</form>

	<p><span class="fs20 bold"><i style="margin:7px 3px 0 0;" class="icon-ok-sign"></i></span>すべての会員データをCSVファイルでダウンロードできます。<br>　<span class="red">※メルマガ停止などの方も含め全会員リストをダウンロードします</span></p>
	<form id="UserCsvDownloadForm" accept-charset="utf-8" method="post" action="">
	<input type="hidden" name="status" value="user_csv">
	<input class="btn btn-primary btn-small" type="submit" value="全会員ダウンロード">
	</form>
	
	<p><span class="fs20 bold"><i style="margin:7px 3px 0 0;" class="icon-ok-sign"></i></span>会員データ入力用に空のCSVファイルをダウンロードできます。</p>
	<form id="tempCsvDownloadForm" accept-charset="utf-8" method="post" action="">
	<input type="hidden" name="status" value="temp_csv">
	<input class="btn btn-default btn-small" type="submit" value="空ファイルダウンロード">
	</form>

	</div>
	
	<h3>CSVファイルアップロード</h3>
	<p class="red">※この画面から会員登録を行った場合には自動返信メールは送信されません</p>
	<div class="waku">
	<p><span class="fs20 bold"><i style="margin:7px 3px 0 0;" class="icon-ok-sign"></i></span>会員データをCSVファイルでアップロードできます。</p>	
	<?php require( '../../common/element/help_csv.php' );?>
	<form id="UserCsvUploadForm" accept-charset="utf-8" method="post" enctype="multipart/form-data" class="form-inline">

	<div class="control-group">
	<div class="controls">
	<label class="radio inline">
	<input type="radio" name="options1" id="optionsRadios3" value="0" <?php if($form_data['options1'] == 0) echo "checked";?>>会員データを追加する
	</label>
	<label class="radio inline">
    <input type="radio" name="options1" id="optionsRadios4" value="1" <?php if($form_data['options1'] == 1) echo "checked";?>>会員データを追加＆更新<span class="red">(新しいメールアドレスは追加、同じメールアドレスは更新します)</span>
	</label>
	</div>
	</div>
	
	<div class="control-group">
	<div class="controls">
	<label class="radio inline">
	<input type="radio" name="options0" id="optionsRadios1" value="1" <?php if($form_data['options0'] == 1) echo "checked";?>>１行目を読み込まない<span class="red">(１行目がデータ項目名のとき)</span>
	</label>
	<label class="radio inline">
	<input type="radio" name="options0" id="optionsRadios2" value="0" <?php if($form_data['options0'] == 0) echo "checked";?>>すべてを読み込む
	</label>
	</div>
	</div>
	<input class="input-file" id="UserCsvUploaders" type="file" name="csv">
	<input type="hidden" name="status" value="user_csv_upload">
	<button id="UserCsvUploadBtn" type="submit" class="btn btn-primary btn-small" style="margin-right:5px;">アップロード</button>
	</form>
	
	</div><!--end of waku-->
	</div>
</div>
</div><!--end of containt-->
</div><!--end of container-->
</body>
</html>
