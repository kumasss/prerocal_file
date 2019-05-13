<?php if(empty($form_data['status'])) header('Location:/'); ?>


<?php 
//----------------------------------------------------------------------
//  期間指定
//----------------------------------------------------------------------
if ((empty($form_data['start_date'])) || (date($form_data['start_date']) < date('1970/1/1 12:00:00'))) {
  $start_date = '';
  $start_time_hour = 0;
  $start_time_minute = 0;
}else{
  $wk_date1 = new DateTime($form_data['start_date']);
  $start_date = $wk_date1->format('Y/m/d');

  $start_time_hour = (!empty($form_data['start_time_hour'])) ? $form_data['start_time_hour'] : '';
  $start_time_minute = (!empty($form_data['start_time_minute'])) ? $form_data['start_time_minute'] : '';
}

if ((empty($form_data['end_date'])) || (date($form_data['end_date']) < date('1970/1/1 12:00:00'))) {
  $end_date = '';
  $end_time_hour = 0;
  $end_time_minute = 0;
}else{
  $wk_date2 = new DateTime($form_data['end_date']);
  $end_date = $wk_date2->format('Y/m/d');
  
  $end_time_hour = (!empty($form_data['end_time_hour'])) ? $form_data['end_time_hour'] : '23';
  $end_time_minute = (!empty($form_data['end_time_minute'])) ? $form_data['end_time_minute'] : '50';
}

?>

<?php require_once(dirname(__FILE__).'/../../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( dirname(__FILE__).'/../../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>

<div class="container" id="container">
<div id="content">
<div id="message"></div>

<div class="form-actions">
<a class="btn" href="<?php echo URL; ?>/admin/builders/tp_inquirys_menu/">フォーム一覧に戻る</a>
</div>

<div class="titles form">
<?php require_once( dirname(__FILE__).'/../../../common/element/tab_form_setting_mailform.php'); ?>
<form accept-charset="utf-8" method="post" id="FormTitleEditForm" action="">
<fieldset>
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
else {
	echo '<div class="waku">メールフォームのタイトルと有効期間を編集します。';
	echo '</div>';
}
?>
<div class="control-group">
<label class="control-label" for="title"><span class="red">*</span>メールフォームのタイトル</label>
<div class="controls required">
<input type="txt" id="formtitle" value="<?php echo $form_data['formtitle']; ?>" class="input-large" name="formtitle">
<div class="green fs12">メールフォーム一覧の表示タイトルになります。<br>管理者に送信されるメールの件名にも利用されます。</div>

<br />

<label class="control-label" for="title">開始日時</label>
<input type="text" id="start_date" class="datepicker" size="15" name="start_date" style="width:120px;" value="<?php echo (!empty($start_date)) ? $start_date : '';?>">

		<select id="BlogUpdateHour" class="input-mini" name="start_time_hour">
			<?php for($h=0; $h<24; $h++): ?>
				<option <?php echo (sprintf("%02d", $h) == $form_data['start_time_hour'])? "selected" :"";?> value=<?php echo sprintf("%02d", $h) ?>><?php echo $h; ?></option>
		    <?php endfor; ?>
		</select>時
		<select id="BlogUpdateMin" class="input-mini" name="start_time_minute">
			<?php for($m=0; $m<60; $m+=10): ?>
				<option <?php echo (sprintf("%02d", $m) == $form_data['start_time_minute'])? "selected" :"";?> value=<?php echo sprintf("%02d", $m) ?>><?php echo $m; ?></option>
		    <?php endfor; ?>
		</select>分


<label class="control-label" for="title">終了日時</label>
<input type="text" id="end_date" class="datepicker" size="15" name="end_date" style="width:120px;" value="<?php echo (!empty($end_date)) ? $end_date : '';?>">

		<select id="BlogUpdateHour" class="input-mini" name="end_time_hour">
			<?php for($h=0; $h<24; $h++): ?>
				<option <?php echo (sprintf("%02d", $h) == $form_data['end_time_hour'])? "selected" :"";?> value=<?php echo sprintf("%02d", $h) ?>><?php echo $h; ?></option>
		    <?php endfor; ?>
		</select>時
		<select id="BlogUpdateMin" class="input-mini" name="end_time_minute">
			<?php for($m=0; $m<60; $m+=10): ?>
				<option <?php echo (sprintf("%02d", $m) == $form_data['end_time_minute'])? "selected" :"";?> value=<?php echo sprintf("%02d", $m) ?>><?php echo $m; ?></option>
		    <?php endfor; ?>
		</select>分


</div>
</div>
</fieldset>
<div class="form-actions">
<input type="hidden" value="edit_form_done" name="status">
<input type="hidden" value="<?php echo $form_data['id']; ?>" name="id">
<button type="submit" class="btn btn-primary" style="margin-right:5px;">保存</button><a class="btn" href="<?php echo URL; ?>/admin/builders/tp_inquirys_menu/">キャンセル</a></div>
</form>
</div>
</div>
</div>
</body>
</html>
