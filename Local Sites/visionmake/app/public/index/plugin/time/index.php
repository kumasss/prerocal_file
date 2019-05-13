<?php
$name = "時間表示";
$text = "今の時間を表示する<br>[time]";
$plugintxt=date('G時i分s秒');
if(strstr($data_contents,"[time]")){$data_contents=str_replace("[time]", $plugintxt, $data_contents);}
?>