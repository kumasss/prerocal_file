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
<div class="container" id="container">
<div id="content">
<div id="message"></div>
<div class="titles form">
<form accept-charset="utf-8" method="POST" id="contactForm" action="">
<fieldset>
<legend>提案・改善</legend>
<?php
if( isset( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str )
	{
		echo $str;
	}
	echo '</div>';
}
elseif(isset( $message )) {
	echo '<div class="alert alert-success">';
	echo $message;
	echo '</div>';
}
?>
<table class="table">
<thead><tr>
<td class="span2"></td>
<td></td>
</tr></thead>
<tbody>
<tr>
<td><span class="red">*</span>タイトル</td>
<td><?php echo $form_data['title']; ?></td>
</tr>
<tr>
<td><span class="red">*</span>お名前</td>
<td><?php echo $form_data['name']; ?></td>
</tr>
<tr>
<td><span class="red">*</span>メール</td>
<td><?php echo $form_data['email']; ?></td>
</tr>
<tr>
<td><span class="red">*</span>カテゴリ</td>
<td><?php echo $form_data['cat']; ?></td>
</tr>
<tr>
<td><span class="red">*</span>本文</td>
<td><?php echo nl2br($form_data['content']); ?></td>
</tr>
</tbody>
</table>
</fieldset>
<div class="form-actions">
<input type="hidden" name="title" value="<?php echo $form_data['title']; ?>">
<input type="hidden" name="name" value="<?php echo $form_data['name']; ?>">
<input type="hidden" name="email" value="<?php echo $form_data['email']; ?>">
<input type="hidden" name="cat" value="<?php echo $form_data['cat']; ?>">
<input type="hidden" name="content" value="<?php echo $form_data['content']; ?>">
<button type="submit" value="done" name="status" class="btn btn-primary btn-large" style="margin-right:5px;">送信する</button>
<button type="submit" value="back" name="status" class="btn" style="margin-right:5px;">修正する</button>
</div>
</form>
</div>
</div>
</div>
</body>
</html>
