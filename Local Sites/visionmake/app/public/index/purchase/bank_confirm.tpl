<!DOCTYPE html>
<!--[if lt IE 7]>	   <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>		   <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>		   <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>購入申込画面</title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">

		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

		<!-- additional files -->
		<link rel="stylesheet" href="<?php echo URL; ?>/common/lightning/css/ui-lightness/jquery-ui-1.9.2.custom.min.css">
		<link rel="stylesheet" href="<?php echo URL; ?>/common/lightning/css/bootstrap.min.css">
<?php if ( $smartPhone) : ?>
		<link rel="stylesheet" href="<?php echo URL; ?>/common/lightning/css/bootstrap-responsive.min.css">
<?php endif;?>

		<style>
			* {
				font-family: Verdana, "メイリオ", "ヒラギノ角ゴ Pro W3", "ＭＳ Ｐゴシック", sans-serif;
			}
			.payment-panel {
				display: none;
			}
			.dialog {
				display: none;
			}
			td.head {
				text-align:center;
			}
			td.must {
				background-color: cornsilk !important;
			}
		</style>

	</head>

	<body>
		<div id="header">
		</div>

		<div class="container">

			<div id="sys-message"></div>

			<form id="form-payment-bank" class="form-horizontal" role="form" action="bank.php" method="post">

				<input type="hidden" name="pid" value="#{$product->id} "/>

				<div class="alert" role="alert">
					<div  class="center-block">
						<h4>
							<span style="color:red;">※まだお申し込みは完了しておりません</span>
							<br />※以下の内容をご確認頂き、よろしければ「送信」ボタンをクリックしてください
						</h4>
					</div>
				</div>

				<div class="panel panel-default">

					<div class="panel-heading">
						<h4 class="well">商品情報</h4>
					</div>

					<div class="panel-body">

						<table class="table table-bordered">
							<tr>
								<td class="head <?php echo ($smartPhone ? "" : "span2"); ?>"><strong>商品名</strong></td>
								<td>#{$product->title}</td>
							</tr>
							<tr>
								<td class="head"><strong>説明</strong></td>
								<td><span id="product-desc">#{nl2br($product->description)}</span></td>
							</tr>
							<tr>
								<td class="head"><strong>金額</strong></td>
								<td>
								<input type="hidden" name="payment_amount" value="#{$bank->bank_payment_amount} "/>
								#{$product->price}円
								</td>
							</tr>
							<tr>
								<td class="head"><strong>支払方法</strong></td>
								<td>銀行振り込み</td>
							</tr>
						</table>

					    <h4 class="well">振込先銀行情報</h4>

						<table class="table table-bordered">
							<tr>
								<td class="head <?php echo ($smartPhone ? "" : "span2"); ?>"><strong>銀行名</strong></td>
								<td>#{$settings->bank_name}</td>
							</tr>
							<tr>
								<td class="head"><strong>支店名</strong></td>
								<td>#{$settings->bank_branch_name}</td>
							</tr>
							<tr>
								<td class="head"><strong>口座種別</strong></td>
								<td><?php echo ( $settings->bank_type == 0 ? "普通" : "当座"); ?></td>
							</tr>
							<tr>
								<td class="head"><strong>口座番号</strong></td>
								<td>#{$settings->bank_account_number}</td>
							</tr>
							<tr>
								<td class="head"><strong>口座名義</strong></td>
								<td>#{$settings->bank_account}</td>
							</tr>
						</table>

					    <h4 class="well">購入者　振込申請</h4>

					    <table class="table table-bordered">
							<tr>
								<td class="head must <?php echo ($smartPhone ? "" : "span2"); ?>"><strong>振込予定日</strong></td>
								<td>
									<input type="hidden" name="bank_buyer_transfer_date" value="#{$bank->bank_buyer_transfer_date}">
									#{$bank->bank_buyer_transfer_date}
								</td>
							</tr>
							<tr>
								<td class="head must"><strong>振込名</strong></td>
								<td>
									<input type="hidden" name="bank_account_name" value="#{$bank->bank_account_name}"></input>
									#{$bank->bank_account_name}
								</td>
							</tr>
							<tr>
								<td class="head must"><strong>メールアドレス</strong></td>
								<td>
									<input type="hidden" name="bank_buyer_email" value="#{$bank->bank_buyer_email}"></input>
									#{$bank->bank_buyer_email}
								</td>
							</tr>
						</table>

						<br/>
						<div class="control-group">
							<label class="span2 control-label">&nbsp;</label>
							<div class="span8 hideInProcess">
								<button type="submit" id="payment-bank-btn" class="btn btn-primary btn-large input-xlarge">送信</button>
								　　
								<a href="javascript:history.back();" class="btn btn-large input-large">戻る</a>
							</div>
						</div>

					</div><!-- end of panel-body -->

					<div class="panel-footer">
					</div>

				</div><!-- end of panel -->

			</form>

			<div id="alert-base" class="alert" role="alert" style="display: none;">
			</div>

		</div><!-- end of container -->

		<script src="<?php echo URL; ?>/common/lightning/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/i18n/jquery-ui-i18n.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/bootstrap.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/jquery.blockUI.js"></script>

		<script>
			$(document).ajaxStop($.unblockUI);
			$(document).ajaxStart( function() {
				$.blockUI({
					overlayCSS:{ opacity: 0.1},
					message: $('<h3>手続き中です。しばらくお待ちください…&nbsp;<img src="<?php echo URL; ?>/common/lightning/img/busy.gif"/></h3>'),
				});
			});

			$(document).ready( function() {

				var alertMessage = function(type,msg) {
					var alt = $('#alert-base').clone(true);
					alt.removeAttr('id');
					alt.addClass(type);
					alt.append(msg);
					$('#sys-message').empty().append(alt);
					alt.show();
				};

				$('#payment-bank-btn').click( function(e) {

					$.blockUI({
						overlayCSS:{ opacity: 0.1},
						message: $('<h3>手続き中です。しばらくお待ちください…&nbsp;<img src="<?php echo URL; ?>/common/lightning/img/busy.gif"/></h3>'),
					});

					/**

					e.preventDefault();

					var data = $('#form-payment-bank').serializeArray();

					$('.hideInProcess').hide();
					$('input').remove();
					$('#confirm-heading').hide();

					$.ajax({
							type:"POST",
							url: "bank.php",
							data:JSON.stringify(data),
							contentType: 'application/json',
							success: function(html) {
								$('#sys-message').empty().append(html);
							},
							error: function() {
								alertMessage('alert-danger','通信エラーが発生しました。購入手続きを始めからやり直してください');
								return false;
							},
							done: function(html) {
							}
						});
					**/
				});

			});
		</script>

	</body>
</html>