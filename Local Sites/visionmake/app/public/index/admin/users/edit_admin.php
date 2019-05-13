<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../common/element/gnav_top.php');?>
</div>
</div>
</div>
</div>
<div class="container">
<?php if ($license_mess){ ?>
<div class="alert alert-success"><label for="serialnumber" >シリアル番号の認証に成功しました。</label></div>
<?php } ?>
<?php require_once(dirname(__FILE__).'/../../common/element/tab_system.php'); ?>
<div id="tabContent" class="tab-content">
<div id="admin" class="users form" style="margin-bottom:30px">
<h1>管理者情報修正</h1>
	<form accept-charset="utf-8" method="post" id="AdminEditForm" class="form-horizontal" action="">
	<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
	<fieldset>
		<?php
		if( isset( $err['password'] ))
		{
		echo '<div class="alert alert-error">';
		echo $err['password'];
		echo '</div>';
		} elseif(isset( $message )) {
		echo '<div class="alert alert-success">';
		echo $message;
		echo '</div>';
		} else {
			echo '<div class="waku"><p>管理者のログインメールアドレス(ID)とパスワードを設定します。<br>メールアドレスは送信元メールアドレスとして使用されます。</p><p class="red bold">※メールの到達率向上のため、Cyfons設置ドメインと管理者メールアドレス（送信者アドレス）は一致させておくようお願い致します。<br>
（設置ドメインとメールの送信アドレスが異なる場合、迷惑メールフィルターにかかりやすくなります）</p></div>';
		}
		?>
		<div class="control-group">
		<label class="control-label" for="email"><span class="red">*</span>メールアドレス</label>
		<div class="controls required">
		<input type="txtarea" id="Email" value="<?php echo $form_data['email']; ?>" class="input-xlarge" name="email">
		<div class="green fs12">メルマガの送信アドレスになります。<br>またIDを設定しない場合にはログインIDとしても利用されます。</div>
		<?php if( !empty( $err['email'] )) echo '<div class="red fs12">'.$err['email'].'</div>'; ?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="admin_id">ID</label>
		<div class="controls required">
		<input type="txtarea" id="adminId" value="<?php echo $form_data['admin_id']; ?>" class="input-xlarge" name="admin_id">
		<div class="green fs12">IDを設定するとメールアドレスでログインできなくなります。<br>使用可能文字：半角英数字（A～Z、0～9）半角（-+._）</div>
		<?php if( !empty( $err['admin_id'] )) echo '<div class="red fs12">'.$err['admin_id'].'</div>'; ?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">パスワード</label>
		<div class="controls required">
		<input type="password" id="Pass1" value="<?php echo $form_data['password1']; ?>" class="input-xlarge" name="password1">
		<div class="green fs12">パスワードを修正する時に入力して下さい。</div>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">パスワード再入力</label>
		<div class="controls required">
		<input type="password" id="Pass2" value="<?php echo $form_data['password2']; ?>" class="input-xlarge" name="password2">
		</div>
		</div>
		
		<div class="control-group" style="border-bottom:1px solid #aaa; margin-top:50px;">
		<label class="control-label"><span class="fs14 bold">基本情報</span></label>
		<div class="controls"></div>
		</div>
		
		<div class="control-group">
		<label class="control-label" for="firstname"><span class="red">*</span>送信者名</label>
		<div class="controls required">
		<input type="txtarea" id="firstname" value="<?php echo $form_data['firstname']; ?>" class="input-xlarge" name="firstname">
		<div class="green fs12">メールの送信者名になります。メール基本設定でも修正可能です。</div>
		<?php if( !empty( $err['firstname'] )) echo '<div class="red fs12">'.$err['firstname'].'</div>'; ?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="site_name"><span class="red">*</span>サイト名</label>
		<div class="controls required">
		<input type="txtarea" id="siteName" value="<?php echo $form_data['site_name']; ?>" class="input-xlarge" name="site_name">
		<div class="green fs12">サイト名を入力します。メンバーサイトや登録ページタイトルやヘッダーに利用されます。<br>サイト基本設定でも修正可能です</div>
		<?php if( !empty( $err['site_name'] )) echo '<div class="red fs12">'.$err['site_name'].'</div>'; ?>
		</div>
		</div>
		<div class="control-group">
		<div class="controls">
		<span class="red">*</span> がついている項目はかならず入力してください。
		</div>
		</div>
	</fieldset>
	<div class="form-actions">
	<input type="hidden" value="<?php echo $form_data['id'] ?>" name="id">
	<input type="hidden" value="admin_edit" name="status">
	<button type="submit" class="btn btn-primary" style="margin-right:5px">保存</button>
	</div>
	</form>
</div><!-- end of admin -->
<div id="system">
<div style="margin-bottom:30px">
<h1>システム情報</h1>
<?php
$row = $usersObj->get_serialnumber();
$serialnumber = $row->serialnumber;
?>
<dl class="dl-horizontal">
<dt style="text-align:left">PHPバージョン</dt>
<dd><?php echo PHP_VERSION;?></dd>
<dt style="text-align:left">Cyfonsバージョン</dt>
<dd><?php echo $ver = $usersObj->get_version(); ?></dd>
<dt style="text-align:left">シリアル番号</dt>
<dd><?php echo $serialnumber;?></dd>
<dt style="text-align:left"></dt>
<dd></dd>
</dl>

<p class="bold">システムが設置されているドメイン：</p>
<?php $vers = explode("\n", $usersObj->getInstallDomain2()); ?>
<?php $str = '<ul id="domain" style="margin:0 0 15px;">';
$i=0;
foreach($vers as $ver){
	$str .= '<li style="display:inline;margin-right:8px;"><a href="" id="domain'.$i.'" name="'.$ver.'" title="'.$ver.'を削除"><i class="icon-remove"></i></a>【'.$ver.'】</li>';
	$i++;
}
$str .= '</ul>';
echo $str;
?>
<div id="delete-confirm-dialog" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">確認</h4>
			</div>
			<div class="modal-body">
      			<p>削除してもよろしいですか？</p>
			</div>
			<div class="modal-footer">
				<form>
				<input type="hidden" value="" name="del_id">
				<input type="hidden" value="" name="del_domain">
				<button type="button" id="btn-delete-action" class="btn btn-primary">削除実行</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">中止</button>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script type="text/javascript">
$(function(){
	jQuery( "#domain a" ).tooltip();

	$('#domain a').on('click', function(e) {
		e.preventDefault();
		var domain=$(this).attr('name');
		var id=$(this).attr('id');
		$('[name="del_domain"]').prop("value", domain);
		$('[name="del_id"]').prop("value", id);
		$('div.modal-body p').text(domain+"を削除してもよろしいですか？");
		$('#delete-confirm-dialog').modal('show');
	});
	
	$('#btn-delete-action').click( function(e) {
		e.preventDefault();
		var domain=$('[name="del_domain"]').prop("value");
		var id=$('[name="del_id"]').prop("value");
		$('#delete-confirm-dialog').modal('hide');
		del_domain_action(domain, id);
	});
	
	var del_domain_action = function(domain, id) {
		var domain = domain;
		var id = id;
		var url = "<?php echo URL?>/admin/users/index.php";
		$.ajax({
			url:url,
			type:'post',
			data:{'domain':domain,'status':'del_domain'},
			success: function(res){
				// 削除完：1
				// エラー：0
				if(res==1){
					$('#'+id).html('<span class="bold" style="color:#dd0000">【削除しました】</a>');
					$('#'+id).parent().hide(900);
				} else {
					alert("削除に失敗しました。");
				}
			},
			error: function(){
			alert("err[ajax]");
			}
		});
	};
});
</script>

<p><span class="bold">システムデータのバックアップデータ取得はこちらのリンクから。</span><br>
<a href="./?status=system_backup">システムバックアップ</a></p>
</div>
<div style="margin-bottom:30px">
<h1>CRON設定情報</h1>
<?php
$time1 = '---';
$time2 = '---';
if (isset($_SESSION['acttime1']) && isset($_SESSION['acttime2']))
{
	$time1=date( 'Y-m-d H:i:s', $_SESSION['acttime1'] );
	$time2=date( 'Y-m-d H:i:s', $_SESSION['acttime2'] );	
}
if ($_SESSION['actflg']=='err'){
	echo '<div class="alert alert-error">';
	echo $_SESSION['acterr'];
	echo '<br><span class="bold">マニュアル通りに設定が完了している場合には10分後に再度ページを読み込むとこのメッセージは消えます。</span><br>';
	echo '</div>';
	$ok_ng = '<span class="red bold">NG　</span>';
}
else if ($_SESSION['actflg']=='not'){
	$time1 = '---';
	$time2 = '---';
	echo '<div class="alert alert-default">';
	echo $_SESSION['acterr'];
	echo '<br><span class="bold">マニュアル通りに設定が完了している場合には10分後に再度ページを読み込むとこのメッセージは消えます。</span><br>';
	echo '</div>';
	$ok_ng = '<span class="bold">動作確認中　</span>';
}
else{
	$ok_ng = '<span class="green bold">OK　</span>';
}
?>
<p>【前回のcron起動確認】<?php echo $ok_ng;?><?php echo 'ステップメール：'.$time1.'　/　号外メール：'.$time2;?></p>

<div class="well">
<?php
$dir=str_replace("\\", "/", dirname(dirname(__FILE__)));
if ($is_unit_folder){
	// todo 2016-03-28 ここで .sh ファイルの存在確認
	echo <<<EOD
<p style="font-weight:bold;">エックスサーバーの場合のCron設定（ユニットメール用シェル・スクリプト　通常）</p>
<p>エックスサーバーをご利用の場合のみ利用できます。<br>
Cron 設定は「シェルスクリプト用コマンド」をコピーして「コマンド」欄に貼り付けてください。</p>
<p class="red bold">※お使いのサーバーによって設定方法が異なりますので、各サーバーのマニュアルを参考に設定してください。</p>
<p><img style="border:1px solid #dadada;margin:0 auto;" src="../../common/img/cron_sh_sample.png" /></p>

<form class="form-horizontal">
<div class="control-group">
<label class="control-label" for="title_id">シェルスクリプト用<br>コマンド</label>
<div class="controls">
	<input type="text" value="sh {$dir}/mails/send_mail.sh" class="input-xxlarge">
</div>
</div>

<div><p class="red bold">※上記はあくまでエックスサーバーをご利用の場合のコマンドとなります。<br>
　他のサーバーをお使いの場合はご利用頂けません。</p></div>
</form>
<hr style="margin:50px 0">
<p style="font-weight:bold;">エックスサーバーの場合のCron設定（ユニットメール用　上記シェル・スクリプトが使えない場合）</p>
<div class="alert alert-danger">上記のシェル・スクリプトを設定してもうまく動かない場合は下記コマンドを設定してください。シェル・スクリプトを設定している場合はこちらのコマンドは設定不要です。<br>
<b>こちらを設定する場合は上記のシェル・スクリプトは必ず削除してください。</b></div>

<form class="form-horizontal">
<div class="control-group">
<label class="control-label" for="title_id">ステップメール用<br>コマンド</label>
<div class="controls">
	<input type="text" value="/usr/bin/php5.6 {$dir}/mails/send_step_mail.php" class="input-xxlarge">
</div>
</div>

<div class="control-group">
<label class="control-label" for="title_id">号外メール用<br>コマンド</label>
<div class="controls">
	<input type="text" value="/usr/bin/php5.6 {$dir}/mails/send_extra_mail.php" class="input-xxlarge">
</div>
</div>

<div class="control-group">
<label class="control-label" for="title_id">ステップメール用<br>（ユニット）コマンド</label>
<div class="controls">
	<input type="text" value="/usr/bin/php5.6 {$dir}/units/mails/send_step_mail.php" class="input-xxlarge">
</div>
</div>

<div class="control-group">
<label class="control-label" for="title_id">号外メール用<br>（ユニット）コマンド</label>
<div class="controls">
	<input type="text" value="/usr/bin/php5.6 {$dir}/units/mails/send_extra_mail.php" class="input-xxlarge">
</div>
</div>

<div class="control-group">
<label class="control-label" for="title_id">メール送信履歴削除用<br>コマンド</label>
<div class="controls">
	<input type="text" value="/usr/bin/php5.6 {$dir}/units/logs/del_mail_logs.php" class="input-xxlarge">
</div>
</div>

<div><p class="red bold">※上記はあくまでエックスサーバーをご利用の場合のコマンドとなります。<br>
　他のサーバーをお使いの場合はご利用頂けません。</p></div>
</form>
EOD;
}else{
	echo <<<EOD
<p style="font-weight:bold;">エックスサーバーの場合のCron設定</p>
<p>エックスサーバーをご利用の場合のみ利用できます。<br>
Cron 設定は「ステップメール用コマンド」「号外メール用コマンド」をコピーして「コマンド」欄に貼り付けてください。</p>
<p class="red bold">※お使いのサーバーによって設定方法が異なりますので、各サーバーのマニュアルを参考に設定してください。</p>
<p><img style="border:1px solid #dadada;margin:0 auto;" src="../../common/img/cron_sample.png" /></p>

<form class="form-horizontal">
<div class="control-group">
<label class="control-label" for="title_id">ステップメール用<br>コマンド</label>
<div class="controls">
	<input type="text" value="/usr/bin/php7.0 {$dir}/mails/send_step_mail.php" class="input-xxlarge">
</div>
</div>

<div class="control-group">
<label class="control-label" for="title_id">号外メール用<br>コマンド</label>
<div class="controls">
	<input type="text" value="/usr/bin/php7.0 {$dir}/mails/send_extra_mail.php" class="input-xxlarge">
</div>
</div>

<div><p class="red bold">※上記はあくまでエックスサーバーをご利用の場合のコマンドとなります。<br>
　他のサーバーをお使いの場合はご利用頂けません。</p></div>
</form>
EOD;
}
?>
</div><!-- end of well -->
</div><!--  -->
</div><!-- end of system -->
</div><!-- end of tabContent -->
</div><!-- end of container -->
</body>
</html>
