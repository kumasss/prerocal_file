<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../../common/element/doctype.php'); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>
<div class="container" id="container">
<div id="content">
<div class="titles form">
<form accept-charset="utf-8" method="post" id="ContentsEditForm" class="form-horizontal">
<fieldset>
<legend>コンテンツページ修正</legend>
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
	echo '<div class="waku">';
	$pub=(1 == $form_data['public'])?'<span class="bold green">公開中</span>':'<span class="bold red">非公開</span>';
	echo 'このページは'.$pub.'です。<br>';
	echo '</div>';
}
?>
<div class="control-group">
<div class="controls">
<button type="submit" class="btn btn-primary" style="margin-right:5px;"><i class="icon-ok icon-white" style="margin:1px 2px 0 0;"></i>ページの保存</button><button id="" class="PreviewBtn btn btn-primary" style="margin-right:5px;"><i class="icon-white icon-eye-open" style="margin:1px 2px 0 0;"></i>プレビュー</button>
</div>
</div>
<div class="control-group"><?php /** start of midashi **/ ?>
<label class="control-label" for="title"><span class="red">*</span>見出し</label>
<div class="controls">
<div style="display:inline-block;vertical-align:top;">
<select id="SideTitles" class="input-large" name="side_title">
<?php
if(!empty($sidebars_data)){
	foreach($sidebars_data as $col){
		if($col['title']=='no caption'){
			$cap=NOCAPTION;
		}else{
			$cap=$col['title'];
		}
		echo ("<option value='".$col['title']."'");
		if ( $col['title'] == $midasi ){
			echo (" selected");
		}
		echo (">".$cap."</option>\n");
	}
} 
?>
</select>
</div>
<div style="display:inline-block;">
<input type="text" id="SideTitles" value="" style="width:315px;" name="side_title2"><br>
<span class="green">※見出しを新しく追加する場合はこちらに入力してください。</span>
</div>
</div><?php /** end of control **/ ?>
</div><?php /** end of midashi **/ ?>
<div class="control-group">
<label class="control-label" for="title"><span class="red">*</span>タイトル</label>
<div class="controls required">
<input type="txt" id="ContentsTitle" value="<?php echo $form_data['title']; ?>" class="input-xxlarge" name="title">
</div>
</div>
<?php if ($custom_url):?>
<div class="control-group">
<label class="control-label" for="url"><span class="red">*</span>URL</label>
<div class="controls">
<span class="help-inline">カスタム：<?php echo URL?>/pg/<span id="editUrl"><?php echo $form_data['url']; ?><input type="hidden" value="<?php echo $form_data['url'] ?>" name="url"></span></span> <button id="CustomUrlBtn" type="submit" class="btn btn-default">編集</button><span class="help-inline" id="url_mess"></span><br>
<span class="help-inline">固定　　：<?php echo URL.'/page.php?page='.$form_data['id']?></span>
</div>
</div>
<?php require_once(dirname(__FILE__).'/../../../common/element/loading.php'); ?>
<?php require_once(dirname(__FILE__).'/../../../common/element/custom_url.php'); ?>
<?php else:?>
<input type="hidden" value="<?php echo $form_data['url'] ?>" name="url">
<?php endif; ?>
<div class="control-group">
<label class="control-label" for="description">ディスクリプション</label>
<div class="controls required">
<input type="txt" id="ContentsDescription" value="<?php echo $form_data['description']; ?>" class="input-xxlarge" name="description">
</div>
</div>
<div class="control-group">
<label class="control-label" for="keyword">キーワード</label>
<div class="controls required">
<input type="txt" id="ContentsKeyword" value="<?php echo $form_data['keyword']; ?>" class="input-xxlarge" name="keyword">
</div>
</div>
<div class="control-group">
<label class="control-label" for="ContentsContent"><span class="red">*</span>記事</label>
<div class="controls required" style="overflow:hidden">
<textarea id="ContentsContent" rows="20" class="span9" name="contents"><?php echo $form_data['contents']; ?></textarea>
<div class="green">※実際の表示は選択されたテンプレートのスタイルによって異なります</div>
<div class="green">※インストール済みのプラグイン一覧は<a href="<?php echo URL;?>/admin/plugin/" target="_blank">こちら</a></div>
<?php require_once(dirname(__FILE__).'/../../../common/element/help_under_textarea.php' );?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="preview">アイキャッチ</label>
<div class="controls">
<div id="eye_image" class="input-xxlarge" style="text-align:left;padding:4px;border:1px solid #dadada;">
<?php
if(!empty($form_data['eye_image_id']) & $buildersObj->get_img_uploaders( $form_data['eye_image_id'], $eye_image )){
		echo '<img src="'.URL.'/'.$eye_image['store_folder'].'/'.$eye_image['store_file'].'" alt="'.$eye_image['title'].'" style="max-width:64px">';
		echo '<input type="hidden" name="eye_image_id" value="'.$form_data['eye_image_id'].'">';
		echo '<a id="img-del" href="#">削除</a>';
}else{
	echo 'アイキャッチは未設定です。';
}
?>
</div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="preview">アイキャッチ用画像</label>
<div class="controls">
<div id="ajax_img_upload_area" class="input-xxlarge" style="height:120px;overflow:auto;">
<?php require_once(dirname(__FILE__).'/../../../common/element/img_uploaders_area.php'); ?>
</div>
<div id="img_uploaders_form_area" class="input-xxlarge"></div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="public_date">経過日</label>
<div class="controls required">
<input type="txtarea" id="" class="input-mini" name="public_date" value="<?php echo $form_data['public_date'] ?>">
<span style="padding:4px;">日後から</span>
<input type="txtarea" id="" class="input-mini" name="no_public_date" value="<?php echo ($form_data['no_public_date']==0)?NULL:$form_data['no_public_date']; ?>">
<span style="padding:4px;">日後まで表示</span>
<div class="green fs12">初回ステップメールを送信した日に表示したい場合には0日後としてください。その後は初回ステップメール送信日の次の日 = 1日後、・・と設定してください。</div>
</div>
</div>
<div class="control-group">
<label class="control-label" for="public">公開</label>
<div class="controls required">
<select id="Public" class="input-small" name="public">
	<option <?php echo (1 == $form_data['public'])? "selected" :"";?> value="1">公開</option>
	<option <?php echo (1 != $form_data['public'])? "selected" :"";?> value="0">非公開</option>
</select>
</div>
</div>
<div class="control-group">
<label class="control-label" for="password">パスワード</label>
<div class="controls">
<input type="txt" id="ContentsPassword" value="<?php echo $form_data['password']; ?>" class="input-small" name="password"><br>
<span class="green fs10">※このページにパスワードをかけたい場合に設定してください</span>
</div>
</div>
<?php require_once(dirname(__FILE__).'/../../../common/element/group_checkbox.php');?>
</fieldset>
<div class="form-actions" style="margin:0;">
<input type="hidden" value="0" name="add_br">
<input type="hidden" value="<?php echo $form_data['id'] ?>" name="id">
<input type="hidden" value="edit_done" name="status">
<input type="hidden" value="page" name="layout">
<button type="submit" class="btn btn-primary" style="margin-right:5px;"><i class="icon-ok icon-white" style="margin:1px 2px 0 0;"></i>ページの保存</button><button id="" class="PreviewBtn btn btn-primary" style="margin-right:5px;"><i class="icon-white icon-eye-open" style="margin:1px 2px 0 0;"></i>プレビュー</button>
<span class="red">*</span> がついている項目はかならず入力してください。
<?php require_once(dirname(__FILE__).'/../../../common/element/preview_js.php'); ?>
</div>
</form>
</div>
</div>
</form>
</div>

</div>
</div><!-- end of titles form -->
</div>
</div>
</body>
</html>
