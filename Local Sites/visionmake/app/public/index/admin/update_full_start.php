<?php
/*
 * update_full_start.php
 *
 * date		2015-03-29
 * 
 * note		full package
 *			no download zip file
 *			no unzip
 */
session_start();
define('FNAME_ORG_INI','../common/config_org.ini'); 
define('FNAME_INI','../common/config.ini'); 
define('PHP_VER','5.6');
require_once('../common/main.php');

$Obj = new main();
$version = 0.25;
$latest_ver = 3.2612;
$header='';
$html='';
$footer='';

// update_full_start.php はPOSTで受信 update.phpへAjaxで送信
if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
	$Obj->session_dell();
	$Obj->get_data($_REQUEST, $form_data);
}

(empty($form_data['status'])) ? $form_data['status']='php_ver_check':NULL;

switch ($form_data['status'])
{
case 'php_ver_check':
	$phpver=phpversion();
	
	if($phpver>=PHP_VER){
		$phpver='<span style="color:green;font-weight:bold;">'.$phpver.'</span>';
		$html = <<< EOD
<h2>PHPバージョンチェック(1/2)</h2>
<p style="color:green;">【OK】PHPバージョン{$phpver}</p>
<button class="btn btn-primary" id="btn-confirm1"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" id="loading"></span>　次へ進む[01]　</button>
EOD;
	}
	else{
		$phpver='<span style="color:red;font-weight:bold;">'.$phpver.'</span>';
		$req_php_ver=PHP_VER;
		$html = <<< EOD
<h2>PHPバージョンチェック(1/2)</h2>
<div class="panel panel-danger">
<div class="panel-heading">【注意】PHPのバージョン</div>
<div class="panel-body">
<p>CyfonsではPHPのバージョンを<span style="color:red;font-weight:bold;">{$req_php_ver}以上</span>を標準としております。</p>
<p>現在インストールされようとしている環境はPHP<span style="color:red;font-weight:bold;">{$phpver}</span>かと思われますため、一部の機能が使えない可能性もございます。</p>
<p>そのことをご了承いただいたうえで、サーバーのPHPバージョンを<span style="color:red;font-weight:bold;">{$req_php_ver}以上</span>に設定を変更頂くか、このままインストールを続ける場合には一部機能が使えない可能性があることをご了承の上でお願い致します。</p>
<button class="btn btn-primary" id="btn-confirm1"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" id="loading"></span>　上記を理解したうえで、インストールを続行する　</button>
</div>
EOD;
	}
	$html.= <<< EOD
<form method="POST" id="form-confirm1">
<input type="hidden" name="now_ver" value="{$version}">
<input type="hidden" name="status" value="cyfons_ver_check">
</form>
<script>
$(document).ready( function() {
	$("#loading").hide();
	$('#btn-confirm1').click( function(e) {
		e.preventDefault();
		$("#loading").show();
		$('#btn-confirm1').attr('disabled', true);
		$('#form-confirm1').submit();
	});
});
</script>
EOD;
	break;
case 'cyfons_ver_check':
	if (empty($latest_ver))
	{
		$form_data['status'] = 'no_update';
		
		$html = <<< EOD
<div class="panel panel-danger">
<div class="panel-heading">システムエラー[01]</div>
<div class="panel-body">呼び出し方法が不正です。</div>
</div>
EOD;
		
	}
	else {
		$html = <<< EOD
<h2>Cyfonsバージョンチェック(2/2)</h2>
<p>Ver.<span style="color:red;font-weight:bold;">{$version}</span>から<span style="color:red;font-weight:bold;">{$latest_ver}</span>のすべてのバージョンアップ処理をします。</p>
<p>よろしければ「次に進む」をクリックしてください。</p>

<form method="POST" action="update.php" id="form-confirm2">
<input type="hidden" name="now_ver" value="{$version}">
<button type="button" class="btn btn-primary" id="btn-confirm2"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" id="loading"></span>　次に進む[02]　</button>
</form>
<script>
$(document).ready( function() {
	$("#loading").hide();
	$('#btn-confirm2').click( function(e) {
		e.preventDefault();
		$("#btn-confirm2").attr('disabled', true);
		$("#loading").show();
		$("#btn-confirm2").before("<h2 id=\"livemess\">アップデート処理中・・・(操作をせずにそのままお待ち下さい)</h2>");
		data = $('#form-confirm2').serializeArray();
		$.ajax({
			type:"POST",
			url: "update.php",
			data: data,
			success: function(html){
			$("div.container").fadeOut(800,function(){
				$("div.container").children().remove();
				$("div.container").show();
				$("div.container").append("<h1>Cyfonsシステムアップデート(フルアップデート)</h1>")
				$("div.container").append("<div id=\"result\"></div>")
				$("#result").html(html);
				$('#done_mess').html("<span style=\"color:#009900;\">アップデート完了</span>");
			});
			},
			error: function() {
				$("#livemess").html("<span style=\"color:#DD0000;\">アップデートエラー!!!</span>");
				alert("通信エラーが発生しました。もう一度アップデート処理をしなおしてください");
				return false;
			},
			complete: function() {
			}
		});
	});
});
</script>
EOD;
	}
	
	break;
default:
	break;
}

$header = <<< EOD
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<style>
.glyphicon-refresh-animate {
    -animation: spin .7s infinite linear;
    -webkit-animation: spin2 .7s infinite linear;
}
@-webkit-keyframes spin2 {
    from { -webkit-transform: rotate(0deg);}
    to { -webkit-transform: rotate(360deg);}
}
@keyframes spin {
    from { transform: scale(1) rotate(0deg);}
    to { transform: scale(1) rotate(360deg);}
}
</style>
</head>
<body>
<div class="container" style="margin-bottom:50px;">
<h1>Cyfonsシステムアップデート(フルアップデート)</h1>
EOD;

$footer = <<< EOD
</div><!-- /.container -->
</body>
</html>
EOD;

echo $header;
echo $html;
echo $footer;
exit;
