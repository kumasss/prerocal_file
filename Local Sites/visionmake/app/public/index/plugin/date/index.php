<?php
$name = "日付";
$text = "今日の日付を表示する<br>[date]";
$plugintxt=date('n月j日');
if(strstr($data_contents,"[date]"))
{
	$data_contents=str_replace("[date]", $plugintxt, $data_contents);
}
?>