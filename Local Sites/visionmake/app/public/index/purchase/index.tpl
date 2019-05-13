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
			.alert {
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

		<div id="default-container" class="container">


			<div class="panel panel-default">
<?php if($product->price > 0): ?>
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
							#{$product->price}円
							</td>
						</tr>

						<tr>
							<td  class="head must"><strong>支払方法</strong></td>
							<td>
								<select name="payment_type" id="payment-type" class="form-control">
	<?php if ( $enable_paypal) : ?>
									<option value="0">PayPal決済</option>
	<?php endif; ?>
	<?php if ( $enable_banking) : ?>
									<option value="1" >銀行振り込み</option>
	<?php endif; ?>
								</select>
							</td>
						</tr>
					</table>

					<div class="row">

						<div id="payment-paypal" class="payment-panel">

							<form action="order.php" id="paypal_submit_form" class="form-horizontal" role="form" method="post">
								<div class="control-group">
									<label for="paypal_submit" class="control-label">&nbsp;</label>
									<div class="span8">
											<button id="paypal_submit" class="btn btn-primary btn-large input-xlarge" data-loading-text="お待ちください..."><strong>PayPal決済で申込み</strong></button>
											<input type="hidden" name="name" value="#{$product->title}"/>
											<input type="hidden" name="number" value="#{$product->id}"/>
											<input type="hidden" name="payment_amount" value="#{$product->price}"/>
									</div>
								</div>
							</form>

						</div><!-- //end of payment-paypal -->

					</div>

					<div id="payment-bank"  class="payment-panel">

						<form id="form-payment-bank" class="form-horizontal" role="form" method="post">

							<input type="hidden" name="product_id" value="#{$product->id}"/>
							<input type="hidden" name="payment_amount" value="#{$product->price}"/>

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

							<br/>
							<table class="table table-bordered">
								<tr>
									<td class="head must <?php echo ($smartPhone ? "" : "span2"); ?>"><strong>振込予定日</strong></td>
									<td>
										<input type="text" name="bank_buyer_transfer_date"
										 id="bank-buyer-transfer-date" class="form-control input-small datePeriod"
										  placeholder="クリックして設定" <?php echo ( $smartPhone ? 'readonly="readonly"' : ''); ?>>
<?php if ( $product->bank_tr_deadline) : ?>
										※振込期限は、申し込み日から#{$product->bank_tr_deadline}日以内となっております。
<?php endif;?>
									</td>
								</tr>
								<tr>
									<td class="head must"><strong>振込名</strong></td>
									<td>
									<input name="bank_account_name" id="bank-account-name" class="form-control span5" maxlength="200" value=""></input>
									</td>
								</tr>
								<tr>
									<td class="head must"><strong>メールアドレス</strong></td>
									<td>
									<input name="bank_buyer_email" id="bank-buyer-email" class="form-control span5" maxlength="200" value="#{$buyer_email}"></input>
									</td>
								</tr>

							</table>

							<br/>
					        <div id="validation-message" style="color:red;"></div>

							<div class="control-group">
								<label for="payment-bank-btn" class="control-label">&nbsp;</label>
								<div class="span8">
									<button id="payment-bank-btn" class="btn btn-primary btn-large input-xlarge"><strong>銀行決済で申し込み</strong></button>
									<br/>※お申し込み後メールでもお振込先をご案内致します
								</div>
							</div>


						</form>

						<div id="alert-base" class="alert" role="alert"></div>

					</div><!-- //end of payment-bank  -->

				</div><!-- end of panel-body -->

				<div class="panel-footer">
				</div>

			</div><!-- end of panel -->
<?php else: //price < 1 ?>
	<div class="panel-heading">
		<h4 class="well">現在、この商品は販売されていません</h4>
	</div>
<?php endif; //price check ?>

		</div><!-- end of container -->

		<div id="paypal-container" class="container">
		</div>

		<script src="<?php echo URL; ?>/common/lightning/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/i18n/jquery-ui-i18n.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/bootstrap.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/jquery.blockUI.js"></script>

		<script>

			$(document).ready( function() {

				$('#payment-type').change( function(e) {

					$('.payment-panel').hide();

					var type = $(this).val();

					if( type == 0) {
						$('#payment-paypal').fadeIn();

					} else if ( type == 1) {
						$('#payment-bank').fadeIn();

					}

				}).change();

				$('#paypal_submit').on('click',function() {
					$(this).button('loading');
					$('#paypal_submit_form').submit();
				});

				$(".datePeriod").datepicker({
					showButtonPanel: true,
					showMonthAfterYear: true,
					dateFormat:  "yy-m-d",
					minDate: 0
				});

				$('input').keypress(function(ev) {
					if ((ev.which && ev.which === 13) || (ev.keyCode && ev.keyCode === 13)) {
						return false;
					} else {
						return true;
					}
				});

				var alertMessage = function(type,msg) {
					var alt = $('#alert-base').clone(true);
					alt.removeAttr('id');
					alt.addClass(type);
					alt.append(msg);
					$('#validation-message').empty().append(alt);
					alt.show();
				};

				var alertOff = function() {
					$('#validation-message').empty();
				};


				$('#payment-bank-btn').click( function(e) {

					e.preventDefault();

					if ( $('#bank-buyer-transfer-date').val() == '') {
						alertMessage('alert-danger','振込予定日を入力して下さい');
						return false;
					}

					var bank_account = $('#bank-account-name').val();
					if ( bank_account == '' || bank_account.trim() == '') {
						alertMessage('alert-danger','振込名を入力して下さい');
						return false;
					}

					var buyer_email = $('#bank-buyer-email').val();
					if ( buyer_email == '' || buyer_email.trim() == '') {
						alertMessage('alert-danger','連絡先メールアドレスをを入力して下さい');
						return false;
					}

					if( !buyer_email.match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._+-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)) {
						alertMessage('alert-danger','正しいメールアドレスをを入力して下さい');
						return false;
					}

					alertOff();

					$.blockUI({
						overlayCSS:{ opacity: 0.1},
						message: $('<h3>お待ちください…&nbsp;<img src="<?php echo URL; ?>/common/lightning/img/busy.gif"/></h3>'),
					});

					$('#form-payment-bank').submit();

				});

				$.datepicker.setDefaults( $.datepicker.regional["ja"]);

			});
		</script>

	</body>
</html>