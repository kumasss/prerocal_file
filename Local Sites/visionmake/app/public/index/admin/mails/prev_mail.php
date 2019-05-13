<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div class="container" style="width:500px">
<div class="blogs form">
	<fieldset>
		<legend style="border: none;">メール確認</legend>
		<?php
		if(!empty($err))
		{
			echo '<div class="alert alert-error">'.$err.'</div>';
		}
		else{
		?>
		<table class="table">
			<colgroup>
				<col class="span2">
			 	<col class="span10">
			</colgroup>
			<tr>
				<td>タイトル</td>
				<td><?php echo $mails_data['title'];?></td>
			</tr>
			<tr>
				<td>記事</td>
				<td>
				<?php if(!empty($mails_data['header'])){echo nl2br($mails_data['header']);echo '<br>';} ?>
				<?php echo nl2br($mails_data['contents']);?><br>
				<?php if(!empty($mails_data['footer'])){echo nl2br($mails_data['footer']);echo '<br>';} ?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
			</tr>
		</table>
		<?php } ?>
	</fieldset>
</div>
</div>
<!-- Content -->
</body></html>
