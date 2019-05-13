<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../common/element/gnav.php'); ?>
</div>
</div>
</div>
</div>

<div class="container">
<div id="containt">
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
	elseif( $result['status'] == 0 && $result['cnt_success'] > 0 )
	{
		echo '<div class="alert alert-success">';
		echo '正常に登録されました。';
		echo '<a href="'.URL.'/admin/mails/?status=step" class="bold">ステップメール一覧</a>';
		echo '</div>';
	}
}
if ($restore_flg)
{
	echo '<div class="alert alert-success">';
	echo '復元処理は正常に終了しました。';
	echo '<a href="'.URL.'/admin/mails/?status=step" class="bold">ステップメール一覧</a>';
	echo '</div>';
}
?>
	<h2>ステップメールデータ</h2>
	<div class="waku" style="margin-bottom:50px;">
	<p><span class="fs20 bold"><i style="margin:5px 0 0 0;" class="icon-ok-sign"></i>ダウンロード　</span>すべてのステップメールデータをダウンロードします。</p>
	<form id="stepCsvDownloadForm" accept-charset="utf-8" method="post" action="">
	<input type="hidden" name="status" value="step_csv">
	<input class="btn btn-primary btn-small" type="submit" value="ダウンロード">
	</form>
	</div><!--end of waku-->
<?php /**/?>
	<div class="waku">
	<p><span class="fs20 bold"><i style="margin:5px 0 0 0;" class="icon-ok-sign"></i>アップロード　</span>ステップメールデータをテキスト形式ファイルでアップロードできます。「上」でダウンロードしたファイル形式のまま、コンテンツ内容などを修正してアップロードして下さい。</p>
	<p class="red"><span class="bold">注意：</span>登録されているステップメールをアップロードするファイルの情報で置き換えます。<br>
現在ステップメールとして登録されていても、アップロードするファイルに含まれてないステップメールは削除されますのでご注意ください。<br>
念のため、現在のステップメールデータをダウンロード・保管の上、作業してください。<br>
ファイルを修正する場合は、UTF-8対応エディタを使用してください。</p>
	<div style="margin:30px 0 30px">
	<div class="bold">ステップメールデータ入出力形式</div>
	<table class="table">
	<thead>
	<tr>
	<th>必須項目：タイトル・本文<span class="green">(※テキストフォーマットで下記10項目のデータを入出力します)</span></th>
	<th></th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td colspan="2">STEPID,タイトル,ヘッダー,本文,フッター,稼働(非稼働:0/稼働:1),グループID,配信時期,配信時間,登録日<br>
	<span class="red"><span class="bold">※</span>稼働中のシステムの場合「STEPID」項目の数字は修正不可です。ダウンロードした値のままアップロードして下さい。新規の場合は「空」でもOKです。</span>
</td>
	</tr>
	</tbody>
	</table>
	</div>
	<form id="stepCsvUploadForm" accept-charset="utf-8" method="post" enctype="multipart/form-data" class="form-inline">
	<input class="input-file" id="stepCsvUploaders" type="file" name="csv">
	<input type="hidden" name="options1" value="0">
	<input type="hidden" name="options0" value="0">
	<input type="hidden" name="status" value="step_csv_upload">
	<button id="stepCsvUploadBtn" type="submit" class="btn btn-primary btn-small" style="margin-right:5px;">アップロード</button>
	</form>
<?php if ($is_step_mails_bak & $is_stories_bak):?>
	<hr>
	<p>※アップロード前の状態に戻したい場合は「<a onclick="if(confirm('ステップメールを復元します。よろしければOKを押して下さい。')){document.forms['step_restore_data'].submit();} event.returnValue = false; return false;" href="#" class="bold">こちら</a>」から復元を試してみてください。</p>
	<form accept-charset="utf-8" method="post" style="display:none;" id="step_restore_data" name="step_restore_data">
	<input type="hidden" name="status" value="step_restore_data">
	<button id="stepRestoreBtn" type="submit" class="btn btn-primary btn-small" style="margin-right:5px;">復元</button>
	</form>
<?php endif;?>
	</div><!--end of waku-->
<?php /**/?>
</div><!--end of containt-->
</div><!--end of container-->
</body>
</html>
