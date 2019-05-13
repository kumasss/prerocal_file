<?php
/*
 * API 呼び出し
 *
 * サイトアクセスログ
 *
 *	 /admin/accanalyzes/?mode=site&date=2014-07-01&time=15%3A00
 *
 * [
 * {"result":"ok|err"},
 * {"shortcode":"i3e6ja","datetime":"2014-07-02 17:00","traffic":"1"}
 * ]
 *
 */

	$json = <<< HERE
	[
		{"header": { "result":"ok", "size":"1"}},
		{"shortcode":"i3e6ja","datetime":"2014-07-02 17:00","traffic":"1"}
	]
HERE;

	$obj = json_decode($json);
	$stdObj= $obj[0];
	echo sprintf("%s,%d",$stdObj->header->result,$stdObj->header->size);
	echo PHP_EOL;

	$index=1;
	for ($i=0;$i<$stdObj->header->size;$i++) {
		$dataObj = $obj[$index];
		echo sprintf("%s,%s,%d",$dataObj->shortcode,$dataObj->datetime,$dataObj->traffic);
		echo PHP_EOL;
		$index++;
	}

	/*
	 * API 呼び出し
	 *
	 * メールログ
	 *
	 * /admin/accanalyzes/?mode=mail&date=2014-07-03&time=01%3A00
	 *
	 * [
	 * {"result":"ok|err"},
	 * {"shortcode":"f1wyju","datetime":"2014-07-04 23:00","traffic":"10","mail_mode":"extra|step","mail_id":"1"},
	 * ]
	 *
	 */

	$json = <<< HERE
	[
		{"header": { "result":"ok", "size":"10"}},
		{"shortcode":"f1wyju","datetime":"2014-07-04 23:00","traffic":"10","mail_mode":"extra","mail_id":"1"},
		{"shortcode":"0plqj2","datetime":"2014-07-04 23:00","traffic":"10","mail_mode":"extra","mail_id":"2"},
		{"shortcode":"7y6r7b","datetime":"2014-07-04 23:00","traffic":"10","mail_mode":"extra","mail_id":"2"},
		{"shortcode":"f1wyju","datetime":"2014-07-04 23:00","traffic":"10","mail_mode":"extra","mail_id":"2"},
		{"shortcode":"0plqj2","datetime":"2014-07-04 23:00","traffic":"1","mail_mode":"step","mail_id":"2"},
		{"shortcode":"0plqj2","datetime":"2014-07-05 00:00","traffic":"6","mail_mode":"step","mail_id":"1"},
		{"shortcode":"7y6r7b","datetime":"2014-07-05 00:00","traffic":"6","mail_mode":"step","mail_id":"1"},
		{"shortcode":"f1wyju","datetime":"2014-07-05 00:00","traffic":"6","mail_mode":"step","mail_id":"1"},
		{"shortcode":"0plqj2","datetime":"2014-07-05 01:00","traffic":"1","mail_mode":"step","mail_id":"1"},
		{"shortcode":"7y6r7b","datetime":"2014-07-05 01:00","traffic":"1","mail_mode":"step","mail_id":"1"},
		{"shortcode":"f1wyju","datetime":"2014-07-05 01:00","traffic":"1","mail_mode":"step","mail_id":"1"},
		{"shortcode":"0plqj2","datetime":"2014-07-05 01:00","traffic":"6","mail_mode":"step","mail_id":"2"},
		{"shortcode":"7y6r7b","datetime":"2014-07-05 01:00","traffic":"6","mail_mode":"step","mail_id":"2"},
		{"shortcode":"f1wyju","datetime":"2014-07-05 01:00","traffic":"6","mail_mode":"step","mail_id":"2"}
	]
HERE;

	$obj = json_decode($json);
	$stdObj= $obj[0];
	echo sprintf("%s,%d"
			,$stdObj->header->result
			,$stdObj->header->size);
	echo PHP_EOL;

	$index=1;
	for ($i=0;$i<$stdObj->header->size;$i++) {
		$dataObj = $obj[$index];
		echo sprintf("%s,%s,%d,%s,%d"
				,$dataObj->shortcode
				,$dataObj->datetime
				,$dataObj->traffic
				,$dataObj->mail_mode
				,$dataObj->mail_id
);
		echo PHP_EOL;
		$index++;
	}

	echo PHP_EOL;
	$url = sprintf("/admin/accanalyzes/?mode=site&date=%s&time=%s"
				,date('Y-m-d')
				,urlencode(date('H:00')));
	echo $url;

