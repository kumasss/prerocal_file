<?php
session_start();
define('FNAME_ORG_INI', '../common/config_org.ini');
define('FNAME_INI', '../common/config.ini');
define('REQUIRED_FILE1', 'install.php');
define('UNNECESSARY_FILE1', 'cyfons');
define('LASTVER', '3.2612');
$DEBUG = false;
require_once('../common/main.php');
$Obj = new main();
function get_data($data, &$aryData)
{
    $aryData = array();
    if (is_array($data)) {
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $$key = isset($value) ? htmlspecialchars($value, ENT_QUOTES) : null;
                $reqData[$key] = $$key;
                $aryData = $reqData;
            }
        }
    }
}

function unlink_file($dir)
{
    $files = glob($dir, GLOB_NOCHECK);
    if (is_array($files)) {
        if (count($files) == 0 || $files[0] == $dir) {
        } else {
            foreach ($files as $file) {
                unlink($file);
            }
        }
    }
}

$dir = "*." . UNNECESSARY_FILE1;
unlink_file($dir);
$dir = "../*." . UNNECESSARY_FILE1;
unlink_file($dir);
$form_data['now_ver'] = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    get_data($_REQUEST, $form_data);
}
if (empty($form_data['now_ver'])) {
    $form_data['now_ver'] = '';
}
$latest_ver = main::get_session('exists_update', false);
$Obj->session_dell();
if ($latest_ver == "exists_update") {
    $latest_ver = LASTVER;
}
if (empty($form_data['now_ver'])) {
    $version = $Obj->get_version();
} else {
    $version = $form_data['now_ver'];
    $latest_ver = (empty($latest_ver)) ? LASTVER : $latest_ver;
}
if ($DEBUG) {
    echo '<div class="bg-danger" style="padding:10px;"><h1>debug</h1></div>';
    $version = 3.09;
    $latest_ver = 999;
}
echo <<< EOD
<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>Cyfonsインストール(update)</title>
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
EOD;
if (empty($form_data['status'])) {
    $form_data['status'] = '';
    if (empty($latest_ver)) {
        echo '<h1>Cyfonsシステムアップデート(更新ファイル確認)</h1>';
        if (file_exists(REQUIRED_FILE1)) {
            $rstr = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 12);
            rename(REQUIRED_FILE1, $rstr . '.cyfons');
            echo '<p style="color:green;">【OK】install.phpを削除しました[01]</p>';
        } else {
            echo '<p style="color:green;">【OK】install.phpは削除済[01]</p>';
        }
        $form_data['status'] = 'no_update';
        echo '<p style="color:green">【OK】現在バージョンアップの必要はありません。</p>';
        echo '<p>現在のバージョンは' . $version . 'です。</p>';
        echo '<p><b>初期設定が完了しました。</b><br>';
        echo 'ログインして管理者情報を入力して下さい</p>';
        echo '<p>━━━━━━━━━━━━━━━━━━━━<br>';
        echo '<b>初期設定値(新規インストール時)</b><br>';
        echo 'ID：admin@admin.admin<br>';
        echo 'PW：123456<br>';
        echo '━━━━━━━━━━━━━━━━━━━━</p>';
        echo '<p class="small" style="color:red;">※バージョンアップ時は設定済のIDでログインしてください。</p>';
        echo '<a href="./" class="btn btn-primary">管理画面からログイン</a>';
    } else {
        echo <<< EOD
<h1>Cyfonsシステムアップデート(1/2)</h1>
<p>Ver.{$version}から{$latest_ver}へバージョンアップします。</p>
<p>よろしければ「次に進む」をクリックしてください。</p>
<form method="post" action="./update_start.php" id="form-confirm1">
<input type="hidden" name="status" value="confirm1">
<input type="hidden" name="now_ver" value={$version}>
<button type="button" class="btn btn-primary" id="btn-confirm1"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" id="loading"></span>　次に進む　</button>
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
    }
}
if ($form_data['status'] == 'confirm1') {
    echo '<h1>Cyfonsシステムアップデート(2/2)</h1>';
    $tmp = @file_get_contents('https://miyako:wk1234@cyfons.net/update/update.zip');
    if ($tmp === false) {
        die("アップデートファイルがダウンロードできませんでした。しばらくしてから再度実行してください。");
    }
    $fp = fopen(dirname(__FILE__) . '/../update.zip', 'w');
    fwrite($fp, $tmp);
    fclose($fp);
    $mess = '<p style="color:green;font-weight:bold;">Cyfons システムのダウンロード';
    if (PHP_OS == "WIN32" || PHP_OS == "WINNT") {
        $mess .= '完了。<br><span style="color:red">Windows環境のためZIP展開できませんでした。手動で展開してください。</span></p>';
    } else {
        $str = exec('unzip -o -d ' . dirname(__FILE__) . '/../ ' . dirname(__FILE__) . '/../update.zip');
        $rstr = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 12);
        @rename('../update.zip', '../' . $rstr . '.cyfons');
        $mess .= '完了、展開完了。</p>';
    }
    if (file_exists(REQUIRED_FILE1)) {
        $rstr = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 12);
        @rename(REQUIRED_FILE1, $rstr . '.cyfons');
        echo '<p style="color:green;">【OK】install.phpを削除しました[02]</p>';
    } else {
        echo '<p style="color:green;">【OK】install.phpは削除済[02]</p>';
    }
    echo <<< EOD
<p>{$mess}</p>
<p>残りの更新作業を行います。</p>
<form method="POST" id="UserSearchRssult">
<div id="result" style="display:none;"></div>
<input type="hidden" name="now_ver" value="{$version}">
<button type="button" class="btn btn-primary" id="btn-confirm"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate" id="loading"></span>　次に進む　</button>
</form>
EOD;
    echo <<< EOD
<script>
$(document).ready( function() {
	$("#loading").hide();
	$('#btn-confirm').click( function(e) {
		e.preventDefault();
		$('#btn-confirm').attr('disabled', true);
		$("#result").html("<h2>アップデート処理中・・・</h2>");
		$('#result').css('margin-bottom','20px');
		$('#result').fadeIn();
		data = $('#UserSearchRssult').serializeArray();
		$("#loading").show();
		$.ajax({
			type:"POST",
			url: "update.php",
			data: data,
			success: function(html) {
				$("#result").fadeOut(800,function(){
				$("#result").show();
				$("#result").html(html);
				$('#done_mess').html("アップデート完了");
				$('#btn-confirm').hide();
				});
			},
			error: function() {
					alert("通信エラーが発生しました。画面をリロードして設定しなおしてください");
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
echo '</div><!-- /.container -->';
echo '</body>';
echo '</html>';