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
	<?php require_once( dirname(__FILE__).'/../../common/element/tab_form_add_stop.php'); ?>
	<h2>会員登録フォーム表示設定</h2>
	<div class="waku">
	<?php if(isset($err1)){ echo '<div class="alert alert-error">';foreach($err1 as $str){ echo $str.'<br>'; }echo '</div>'; } ?>
	<?php if(isset($message1)){ echo '<div class="alert alert-success">'.$message1.'</div>'; } ?>
	
	<?php /************************************************/ ?>
	<form accept-charset="utf-8" method="post" id="FormSettings" name="form_settings" action="">
	
	<div class="control-group" style="margin-top:20px;">
	<p><i style="margin:2px 3px 0 0;" class="icon-ok-sign"></i><span style="font-weight:bold;">表示設定（表示する場合にチェックを入れてください）</span></p>
	<dl class="dl-horizontal">
	<dt style="text-align:left;width:200px;">
	<label class="checkbox" for="FormEmail">
	<input type="hidden" name="form_email" value="1">
	<input type="checkbox" name="form_email" id="FormEmail" value="1" <?php if($settings['form_email'] == 1) echo "checked"; ?> disabled>メールアドレス
	</label>
	</dt>
	<dd>
	<label class="checkbox" for="form_is_email">
	<input type="hidden" name="form_is_email" value="1">
	<input type="checkbox" name="form_is_email" id="FormIsEmail" value="1" <?php if($settings['form_is_email'] == 1) echo "checked"; ?> disabled>必須
	</label>
	</dd>
	<dt style="text-align:left;width:100%;">
	<label class="checkbox" for="FormEmail2">
	<input type="hidden" name="form_email2" value="0">
	<input type="checkbox" name="form_email2" id="FormEmail2" value="1" <?php if($settings['form_email2'] == 1) echo "checked"; ?>>メールアドレスの2重チェックをする
<span style="color:green;">&nbsp;&nbsp;&nbsp;※「2重チェック」をする場合、メールアドレスを2回入力してもらうことで入力ミスチェックを行います。</span>
	</label>
	</dt>
	<dd></dd>
	<dt style="text-align:left;width:200px;">
	<label class="checkbox" for="FormPassword2">
	<input type="hidden" name="form_password2" value="0">
	<input type="checkbox" name="form_password2" id="FormPassword2" value="1" <?php if($settings['form_password2'] == 1) echo "checked"; ?> onclick="this.form.FormIsPassword2.disabled=!this.checked">パスワード
	</label>
	</dt>
	<dd>
	<label class="checkbox" for="FormIsPassword2">
	<input type="hidden" name="form_is_password2" value="0">
	<input type="checkbox" name="form_is_password2" id="FormIsPassword2" value="1" <?php if($settings['form_is_password2'] == 1) echo "checked";?> onclick="if(this.checked)this.form.FormPassword2.checked=true;">必須
<span style="color:green;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;※パスワード非表示、未入力の場合はシステムで自動発行します。</span>
	</label>
	</dd>
	<dt style="text-align:left;width:200px;">
	<label class="checkbox inline" for="FormName1" style="padding-top:0;">
	<input type="hidden" name="form_firstname" value="0">
	<input type="checkbox" name="form_firstname" id="FormName1" value="1" <?php if($settings['form_firstname'] == 1) echo "checked"; ?>>姓
	</label>
	<label class="checkbox inline" for="FormName2" style="padding-top:0;margin-left:20px;">
	<input type="hidden" name="form_lastname" value="0">
	<input type="checkbox" name="form_lastname" id="FormName2" value="1" <?php if($settings['form_lastname'] == 1) echo "checked"; ?>>名
	</label>
	</dt>
	<dd>
	<label class="checkbox" for="FormIsName">
	<input type="hidden" name="form_is_firstname" id="FormIsName1" value="<?php echo $settings['form_is_firstname']?>">
	<input type="hidden" name="form_is_lastname" id="FormIsName2" value="<?php echo $settings['form_is_lastname']?>">
	<input type="checkbox" name="form_is_name" id="FormIsName" value="1">必須
	</label>
	</dd>
	<dt style="text-align:left;width:200px;">
	<label class="checkbox" for="FormOrderNo">
	<input type="hidden" name="form_order_no" value="0">
	<input type="checkbox" name="form_order_no" id="FormOrderNo" value="1" <?php if($settings['form_order_no'] == 1) echo "checked"; ?> onclick="this.form.FormIsOrderNo.disabled=!this.checked">注文ID
	</label>
	</dt>
	<dd>
	<label class="checkbox" for="FormIsOrderNo">
	<input type="hidden" name="form_is_order_no" value="0">
	<input type="checkbox" name="form_is_order_no" id="FormIsOrderNo" value="1" <?php if($settings['form_is_order_no'] == 1) echo "checked"; ?> onclick="if(this.checked)this.form.FormOrderNo.checked=true;">必須
	</label>
	</dd>
	</dl>
	</div>
	<input type="hidden" name="status" value="form">
	<input type="submit" value="設定変更" class="btn btn-primary">
	</form>
	<script>
		$(function(){
			var isName1 = <?php echo $settings['form_is_firstname']?>;
			var isName2 = <?php echo $settings['form_is_lastname']?>;
			if (isName1 == 1 || isName2 == 1)
			{
				$('#FormIsName').prop('checked', true);
			}
			if ((!$('#FormName1').prop('checked') && !$('#FormName2').prop('checked')) && (isName1 != 1 || isName2 != 1))
			{
				$('#FormIsName').prop('disabled', true);
			}
			$('#FormName1').change(function(){
				exec();
			});
			$('#FormName2').change(function(){
				exec();
			});
			$('#FormIsName').change(function(){
				exec();
			});
			
			function exec(){
				if($('#FormName1').prop('checked') && $('#FormName2').prop('checked') && $('#FormIsName').prop('checked'))
				{
					$('#FormIsName').prop('disabled', false);
					$('#FormIsName1').prop('value', 1);
					$('#FormIsName2').prop('value', 1);
				}
				else if($('#FormName1').prop('checked') && $('#FormIsName').prop('checked'))
				{
					$('#FormIsName').prop('disabled', false);
					$('#FormIsName1').prop('value', 1);
					$('#FormIsName2').prop('value', 0);
				}
				else if($('#FormName2').prop('checked') && $('#FormIsName').prop('checked'))
				{
					$('#FormIsName').prop('disabled', false);
					$('#FormIsName1').prop('value', 0);
					$('#FormIsName2').prop('value', 1);
				}
				else if($('#FormName1').prop('checked') && $('#FormName2').prop('checked'))
				{
					$('#FormIsName').prop('disabled', false);
					$('#FormIsName1').prop('value', 0);
					$('#FormIsName2').prop('value', 0);
				}
				else if($('#FormName1').prop('checked'))
				{
					$('#FormIsName').prop('disabled', false);
					$('#FormIsName1').prop('value', 0);
					$('#FormIsName2').prop('value', 0);
				}
				else if($('#FormName2').prop('checked'))
				{
					$('#FormIsName').prop('disabled', false);
					$('#FormIsName1').prop('value', 0);
					$('#FormIsName2').prop('value', 0);
				}
				else if(!$('#FormName1').prop('checked') && !$('#FormName2').prop('checked'))
				{
					$('#FormIsName').prop('checked', false);
					$('#FormIsName').prop('disabled', true);
					$('#FormIsName1').prop('value', 0);
					$('#FormIsName2').prop('value', 0);
				}
				else
				{
					$('#FormIsName').prop('checked', false);
					$('#FormIsName').prop('disabled', true);
					$('#FormIsName1').prop('value', 0);
					$('#FormIsName2').prop('value', 0);
				}
			}
		});
	</script>
	<?php /************************************************/ ?>
	</div><!-- end of waku -->
	
	<div class="users form" style="margin-top:30px;">
	<h2>会員登録フォームパスワード・タグ</h2>
	<div class="waku">
	<?php if(isset($err2)){ echo '<div class="alert alert-error">';foreach($err2 as $str){ echo $str.'<br>'; }echo '</div>'; } ?>
	<?php if(isset($message2)){ echo '<div class="alert alert-success">'.$message2.'</div>'; } ?>
	<p><i style="margin:2px 3px 0 0;" class="icon-ok-sign"></i><span style="font-weight:bold;">設定するグループ</span></p>
	<p>設定するグループを選択してください。</p>
	<?php /************************************************/ ?>
	<form id='sel_group'>
	<?php require_once( '../../common/element/group_select.php'); ?>
	</form>
	<?php /************************************************/ ?>
	<script>
	$(function() {
	$('#sel_group select').change(function() {
		var data = $(this).val();
		var url = '<?php echo URL ?>/admin/users/?status=form&group_id='+data;
		window.location.href = url;
	});
	});
	</script>

	<p><i style="margin:2px 3px 0 0;" class="icon-ok-sign"></i><span style="font-weight:bold;">登録フォームのアドレス</span></p>
	<p>会員登録フォーム：<a href="<?php echo URLADD.'?group_id='.$form_data['group_id']; ?>" target="_blank"><?php echo URLADD.'?group_id='.$form_data['group_id']; ?></a></p>
	<?php
	$url = URLADD.'?group_id='.$form_data['group_id'];
	?>
	<script>
	$(function() {
		var qr_code="<?php echo URL ?>/common/qr/ajax_qr.php";
		var data="<?php echo $url ?>";
		var group_id="<?php echo $form_data['group_id'] ?>";
		var src="<?php echo URL?>/images/qr"+group_id+".png";
		$.ajax({
			url:qr_code,
			type:'get',
			data:{'d':data,'gid':group_id},
			success: function(){
				$("#qr").append('<img src="" width="100"/>');
				$("#qr").children("img").attr({'src':src});
				$("#qr_url").html('&lt;img src="'+src+'" /&gt;');
			},
			error: function(res){
				alert("QR code err!! Please try again.");
			}
		});
	});
	</script>
	<div id="qr"></div>
	<div id="qr_url"></div>
	<div class="green fs12" style="margin:0 0 20px;">右クリック画像保存で保存されます</div>
	
	<p><i style="margin:2px 3px 0 0;" class="icon-ok-sign"></i><span style="font-weight:bold;">登録フォームのパスワード設定</span></p>
	<p><span class=""></span>会員登録フォームのログインパスワードは「<span style="font-weight:bold;"><?php echo $settings2['form_password']; ?></span>」です。</p>
	
	<?php /************************************************/ ?>
	<form accept-charset="utf-8" method="post" id="FormPassword" name="FormPassword" action="">
	<div class="control-group form-inline">
	<label class="checkbox" for="FormIsPassword">
	<input type="hidden" name="form_is_password" value="0">
	<input type="checkbox" name="form_is_password" id="FormIsPassword" value="1" <?php if($settings2['form_is_password'] == 1) echo "checked"; ?> onclick="this.form.UserUsername.disabled=!this.checked">登録フォームをパスワード制限する
	</label>
	<label class="control-label" for="form_password" style="margin-left:20px;">パスワード</label>
	<input type="hidden" name="form_password" value="<?php echo $settings2['form_password']; ?>">
	<input type="text" id="UserUsername" maxlength="50" class="input-xlarge" name="form_password" value="<?php echo $settings2['form_password']; ?>" onclick="if(this.form.FormIsPassword.checked==false)this.form.FormIsPassword.checked=true;">
	<p><span style="color:green;">※パスワード制限する場合、パスワードを入力してもらうことで登録フォームが開くようになります。<br>
	※こちらで設定したパスワードは<a href="<?php echo URL?>/admin/users/?status=changegroup">グループ変更フォーム</a>にも利用されます</span></p>
	</div>
	<button type="submit" name="status" value="form_password" class="btn btn-primary">パスワード変更</button>
	</form>
	<?php /************************************************/ ?>
	
	</div><!-- waku -->
	
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
	
</div><!-- end of users form -->
</div><!-- end of content -->
</div><!-- end of container -->
</body>
</html>
