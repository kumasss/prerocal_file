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
	<?php require_once( dirname(__FILE__).'/../../common/element/tab_form_group.php'); ?>
	<div class="waku">
	<?php if(isset($err2)){ echo '<div class="alert alert-error">';foreach($err2 as $str){ echo $str.'<br>'; }echo '</div>'; } ?>
	<?php if(isset($message2)){ echo '<div class="alert alert-success">'.$message2.'</div>'; } ?>
	<p><i style="margin:2px 3px 0 0;" class="icon-ok-sign"></i><span style="font-weight:bold;">設定するグループ</span></p>
	<p>変更するグループを選択してください。</p>
	<?php /************************************************/ ?>
	<form id='sel_group'>
	<div style="display:inline-flex">
	<div><?php require_once( '../../common/element/group_select.php'); ?></div>
	<?php /************************************************/ ?>
	<div>&nbsp;&nbsp;<i class="icon-arrow-right"></i>&nbsp;&nbsp;</div>
	<?php /************************************************/ ?>
	<div><?php require_once( '../../common/element/group_select2.php'); ?></div></div>
	</form>
	<?php /************************************************/ ?>
	<script type="text/javascript">
	$(function() {
	$('#sel_group select').change(function() {
		if(document.getElementById('group_id').value!=<?php echo $form_data['group_id'] ?>){
			var data = document.getElementById('group_id').value;
			var data2 = <?php echo $form_data['group_id2'] ?>;
		}else{
			var data = <?php echo $form_data['group_id'] ?>;
			var data2 = document.getElementById('group_id2').value;
		}
		var url = '<?php echo URL ?>/admin/users/?status=changegroup&group_id='+data+'&group_id2='+data2;
		window.location.href = url;
	});
	});
	</script>
	<?php $form_data['form_html'] =  preg_replace( '/<!--GROUP_NAME-->/', $usersObj->db_get_group_name(($form_data['group_id'])), $form_data['form_html']) ?>
	<?php $form_data['form_html'] =  preg_replace( '/<!--GROUP_NAME2-->/', $usersObj->db_get_group_name(($form_data['group_id2'])), $form_data['form_html']) ?>

	<p style="clear:both;"><i style="margin:2px 3px 0 0;" class="icon-ok-sign"></i><span style="font-weight:bold;">登録フォームのパスワード設定</span></p>
	<?php if($settings3['form_is_password'] == 1): ?>
	<p><span class=""></span>グループ変更フォームのログインパスワードは「<span style="font-weight:bold;"><?php echo $settings3['form_password']; ?></span>」です。</p>
	<?php else:?>
	<p class="red">フォームはパスワード設定されていません。</p>
	<?php endif;?>
	<?php if(!isset($form_data['group_id2'])){$form_data['group_id2']=$form_data['group_id'];} ?>
	<p>グループ変更フォーム：<a href="<?php echo URLGROUP.'?group_id='.$group_code.'&group_id2='.$group_code2 ?>" target="_blank"><?php echo URLGROUP.'?group_id='.$group_code.'&group_id2='.$group_code2; ?></a></p>
	<p><span style="color:green;">※グループ変更フォームのパスワードは<a href="<?php echo URL?>/admin/users/?status=form&group_id=<?php echo $form_data['group_id2']?>">変更先のグループと同一設定</a>が利用されます</span></p>
	</div><!--waku-->

	<form class="form-horizontal">
	<fieldset>
		<div class="waku">
		<p>下のHTMLをコピーして、設置したいブログやサイトに張り付けて使用してください。</p>
		<div class="control-group" style="margin-top:20px;">
		<label class="control-label" for="form_html">直接表示URL</label>
		<div class="controls">
		<input type="" name="form_url" id="FormDirect" class="span9" value="<?php echo $form_data['form_url']; ?>">
		</div>
		</div>
		<div class="control-group" style="margin-top:20px;">
		<label class="control-label" for="form_html">HTML版</label>
		<div class="controls">
		<textarea name="form_html" id="FormHtml" class="span9" rows="10" cols="10"><?php echo $form_data['form_html']; ?></textarea>
		<div class="green">※HTML版は貼り付けるページの文字コードが UTF-8 の場合にご利用可能です。（Wordpress は殆どの場合問題ありません）<br />※HTML版の場合は登録フォーム表示のパスワード制限が利用できません</div>
		</div>
		</div>
		<div class="control-group" style="margin-top:20px;">
		<label class="control-label" for="form_html">iframe版</label>
		<div class="controls">
		<textarea name="form_html" id="FormHtml" class="span9" rows="10" cols="10"><?php echo $form_data['form_iframe']; ?></textarea>
		</div>
		</div>
		</div>
	</fieldset>
	</form>
</div>
</body>
</html>
