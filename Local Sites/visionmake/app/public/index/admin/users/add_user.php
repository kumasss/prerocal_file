<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( dirname(__FILE__).'/../../common/element/doctype.php' ); ?>
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
<div class="container">
<div id="content">
<?php require_once( dirname(__FILE__).'/../../common/element/tab_member_add_stop.php'); ?>
<?php
if( isset( $err ))
{
	echo '<div class="alert alert-error">';
	foreach( $err as $str ){echo $str.'<br>';}
	echo '</div>';
}
?>
<div class="users index">
<h3>会員登録・削除・送信停止</h3>
<p class="red">※この画面から会員登録を行った場合には自動返信メールは送信されません</p>
<div class="waku">
<p><span class="label label-success">使い方</span></p>
<p><span class="fs24">１．</span>登録グループを選択します。<span class="green">（送信停止の時は選択不要です）</span></p>
<form accept-charset="utf-8" method="post" id="userTxtImport" class="form-vertical" action="">
<?php require_once( '../../common/element/group_select.php'); ?>
<p style="margin-top:30px;"><span class="fs24">２．</span>テキストエリアにリストを入力します。</p>
<div style="display:none;"><input type="hidden" value="POST" name="_method"></div>
<div class="controls">
<textarea id="UserLines" cols="30" rows="6" class="input-xxlarge" name="lines"></textarea>
</div>
<?php
if( !empty( $result ))
{
	echo '<div>';
	echo '全'.$result['cnt_text'].'件中'.$result['cnt_success'].'件の処理をしました。';
	echo '</div>';
	if( !empty( $result['err'] ))
	{
		echo '<div class="alert alert-error">';
		foreach( $result['err'] as $err )
		{
			echo (isset($err['massage'])) ? $err['massage'] : NULL ;
			echo (isset($err['data'])) ? $err['data'] : NULL ;
			echo '<br />';
		}
		echo '</div>';
	}
	elseif( $result['status'] == 0 && $result['cnt_success'] > 0 )
	{
		echo '<div class="alert alert-success">';
		echo '正常に登録されました。';
		echo '</div>';
	}
	elseif( $result['status'] == 1 && $result['cnt_success'] > 0 )
	{
		echo '<div class="alert alert-success">';
		echo '送信停止にしました。';
		echo '</div>';
	}
}
?>
<p><span style="font-weight:bold;">「性」「名」「メールアドレス」</span>を<span style="font-weight:bold;color:#990000;">「タブ区切り」</span>で入力して「会員情報修正」ボタンを押してください。<br>
複数登録は改行で区切って入力してください。<br>
通常はExcelで３列をコピー・ペーストするだけでタブ区切りと改行になります。</p>
<p style="font-weight:bold">例１</p>
<pre>
佐藤	健太	kenta@example.com
田中	大輔	daisuke@example.com
</pre>
	<p style="font-weight:bold">例２</p>
<pre>
佐藤	kenta@example.com
田中	daisuke@example.com
</pre>
	<p style="font-weight:bold">例３</p>
<pre>
kenta@example.com
daisuke@example.com
</pre>

<div class="control-group">
<p style="margin-top:30px;"><span class="fs24">３．</span>送信済ストーリNoを入力します。<span class="green">（指定されたストーリNoまで送信済みとします。特に指定しない場合は1通目から送信します）</span></p>

<div class="controls">

<label class="checkbox inline">
<input type="hidden" name="is_story_no" value="0" />
<input type="checkbox" name="is_story_no" id="isStoryNo" value="1" <?php echo ($form_data['is_story_no'])?"checked":""; ?>>使用する
</label>
<div style="display:inline;padding-left:15px;">
<input type="hidden" name="story_no" value="0" />
<input class="input-mini" style="margin-bottom:0;" type="text" name="story_no" id="storyNo" value="<?php echo $form_data['story_no']; ?>" <?php echo (!$form_data['is_story_no'])?'disabled':''; ?> />
</div>

</div>
</div>

<script type="text/javascript">
$(function() {
	if(<?php echo $form_data['is_story_no'];?> == 1){
		$("#storyNo").css("border","solid 2px green");
	} else {
		$("#storyNo").css("border","solid 2px #dadada");
	}
	$('#isStoryNo').change(function() {
		if($("#isStoryNo").prop('checked')) {
			$("#storyNo").removeAttr("disabled");
			$("#storyNo").css("border","solid 2px green");
		} else {
			$("#storyNo").css("border","solid 2px #dadada");
			$("#storyNo").addClass("disabled");
			$("#storyNo").attr("disabled", "disabled");
		}
	});
});
</script>
<div class="control-group">
<p style="margin-top:30px;"><span class="fs24">４．</span>登録か送信停止を選択します。<span class="green">（新規追加登録の場合は「送信停止」は選択できません）</span></p>
<div class="controls">
<label class="radio inline">
<input type="radio" name="options" id="optionsRadios1" value="0" checked>登録
</label>
<label class="radio inline">
<input type="radio" name="options" id="optionsRadios2" value="1">送信停止
</label>
</div>
</div>
<div class="submit">
<p style="margin-top:30px;"><span class="fs24">５．</span>「会員登録・送信停止」ボタンを押して決定します。</p>
<input type="hidden" value="user_add" name="status">
<input type="submit" value="会員登録・送信停止" class="btn btn-primary">
</div>
</form>
</div><!--end of waku-->
</div>
</div><!--end of containt-->
</div><!--end of container-->
</body>
</html>
