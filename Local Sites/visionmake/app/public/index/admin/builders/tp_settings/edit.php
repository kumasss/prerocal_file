<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div class="users form">
	<form accept-charset="utf-8" method="post" id="UserEditForm" class="form-horizontal" action="">
	<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
	<fieldset>
		<legend>会員サイト基本設定</legend>
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
	echo '<div class="waku">会員サイトの基本設定をします。</div>';
}
?>
		<div class="control-group">
		<label class="control-label" for="SiteName"><span class="red">*</span>サイト名</label>
		<div class="controls required">
		<input type="txt" id="SiteName" value="<?php echo $form_data['site_name']; ?>" class="input-large" name="site_name">
		<div class="green fs12">サイト名を入力します。&lt;title&gt;とヘッダーに表示されます。</div>
		</div>
		</div>

		<div class="control-group">
		<label class="control-label" for="HeaderImg">ヘッダー画像</label>
		<div class="controls required" id="HeaderImg">
		<?php
		if( isset($img_uploaders_data) ){
		echo '<ul class="thumbnails">';
		foreach( $img_uploaders_data as $img ):
			?>
			<li class="span3" style="margin-bottom:0;">
			<div class="thumbnail">
			<img src="<?php echo URL.'/'.$img['store_folder'].'/'.$img['store_file']?>" style="max-height:200px;" />
			<div class="caption">
			<button id="img-<?php echo $img['id']?>" class="btn btn-danger">削除</button>
			</div>
			</div>
			</li>
			<script Language="JavaScript"><!--
			$(function(){
				var url = "<?php echo URL?>";
				var img_id = "<?php echo $img['id'] ?>";
				url=url+"/admin/builders/tp_settings/index.php?status=delete_header&id=<?php echo $img['id']?>";
				$("#img-<?php echo $img['id']?>").live('click', (function(){
					if(confirm("削除してよろしいですか？")){
						$.post(url,{'header_id': img_id},function(data){
							$("#HeaderImg").html(data);
						});
					}
					return false;
				}));
			});
			// --></script>
			<?php
		endforeach;
		echo '</ul>';
		echo '<div class="green fs12">新しいヘッダー画像を設置するとき、ヘッダー画像を使用しない時は画像を削除してください。</div>';
		}else if( !isset($img_uploaders_data) ){
			require_once( dirname(__FILE__).'/../../../common/element/header_uploaders_form.php' );
		} ?>

		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="head">ヘッダーカスタム設定</label>
		<div class="controls required">
		<textarea id="Head" rows="6" class="input-xxlarge" cols="5" name="head"><?php echo $buildersObj->html_decode($form_data['head']); ?></textarea>
		<div class="green fs12">&lt;head&gt;部分へそのまま追加します。</div>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="contents_template"><span class="red">*</span>テンプレート設定</label>
		<div class="controls required">
		<select class="input-medium" name="template_flg">
		<?php 
		foreach ($template_dir_arr as $key => $val){
			if ($template_flg == $key){
				echo("<option selected='selected' value='$key'>$val</option>");
			}else{
				echo("<option value='$key'>$val</option>");
			}
		}
		?>
		</select>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for=""></label>
		<div class="controls">
		<a href="<?php echo URL; ?>/admin/builders/?status=template">カスタムテンプレートのダウンロードはこちら。</a>
		</div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="is_edit"><span class="red">*</span>高機能エディタを使う</label>
		<div class="controls">
		<label class="checkbox inline"><input name="is_edit" <?php if ($form_data['is_edit']){?>checked<?php }?> type="radio" value="1" >使う</label>
		<label class="checkbox inline"><input name="is_edit" <?php if ($form_data['is_edit'] == 0){?>checked<?php }?> type="radio" value="0" >使わない</label>
		</div>
		</div>
	</fieldset>
	<div class="form-actions">
	<input type="hidden" value="<?php echo $form_data['id'] ?>" name="id">
	<input type="hidden" value="edit" name="status">
	<input type="hidden" value="<?php echo $form_data['css']; ?>" name="css">
	<button type="submit" class="btn btn-primary" style="margin-right:5px">保存</button><a class="btn" href="<?php echo URL; ?>/admin/builders/">キャンセル</a>
	<span class="red">*</span> がついている項目はかならず入力してください。
	</div>
	</form>
</div>
</body>
</html>
