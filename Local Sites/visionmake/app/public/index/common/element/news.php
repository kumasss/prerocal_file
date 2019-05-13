<?php
session_start();
// お知らせ取得
$url = 'https://cyfons.net/inc/ns.php';
$options = array(
	'http' => array(
		'method'  => 'GET',
		'timeout' => 3,
	)
);
$html = @file_get_contents($url, false, stream_context_create($options));
if ($html === false) {
	$html = '<span class="bold">お知らせの所得に失敗しました...</span>';
} else {
	$_SESSION['news_flg'] = true;
}
$_SESSION['news'] = $html;
echo $html;
