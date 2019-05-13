<?php
$url = $_SERVER["REQUEST_URI"];
$url = rtrim($url);
$active = ' class="active"';
?>
<h2 style="margin-bottom:20px">ステップ・号外メール用ヘッダー/フッター編集</h2>
<div class="tabbable">
<ul class="nav nav-tabs">
<li<?php if(strpos($url,'headers'))echo $active; ?>><a href="<?php echo URL; ?>/admin/headers/">ヘッダー</a></li>
<li<?php if(strpos($url,'footers'))echo $active; ?>><a href="<?php echo URL; ?>/admin/footers/">フッター</a></li>
</ul>
</div>
