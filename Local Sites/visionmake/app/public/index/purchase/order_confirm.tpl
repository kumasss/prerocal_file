<!DOCTYPE html>
<!--[if lt IE 7]>	   <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>		   <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>		   <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>PayPal決済</title>
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
			td.head {
				text-align:center;
			}
			td.must {
				background-color: cornsilk !important;
			}
			.center-block {
				text-align:center;
			}
		</style>

	</head>

	<body>
		<div id="header">
		</div>

		<div id="default-container" class="container">

			<div class="panel panel-default">

				<div class="panel-heading">
					<h4 class="well">商品購入最終確認</h4>
				</div>

				<div class="panel-body">

					<table class="table table-bordered">
							<tr>
								<td class="head <?php echo ($smartPhone ? "" : "span2");?>"><strong>お名前</strong></td>
								<td>#{$res['LASTNAME']} #{$res['FIRSTNAME']} 様</td>
							</tr>
							<tr>
								<td class="head"><strong>メールアドレス</strong></td>
								<td>#{$res['EMAIL']}</td>
							</tr>
							<tr>
								<td class="head"><strong>注文商品名</strong></td>
								<td>#{$res['L_NAME0']}</td>
							</tr>
							<tr>
								<td class="head"><strong>支払金額合計</strong></td>
								<td>
								#{$res['PAYMENTREQUEST_0_AMT']}<?php echo $res["PAYMENTREQUEST_0_CURRENCYCODE"] == 'JPY' ? '円' : '';?>
								</td>
							</tr>
					</table>

				<div class="alert info" role="alert">
					<div  class="center-block">
						<h4>上記注文内容で支払を確定します。<br />よろしいですか？</h4>
					</div>
				</div>

					<div class="row">

						<div id="payment-paypal" class="payment-panel">

							<form action="paypal.php" class="form-horizontal" role="form" method="post">
<?php foreach ($res as $key=>$value):?>
									<input type="hidden" name="#{$key}" value="#{$value}"/>
<?php endforeach; ?>
								<div class="center-block">
									<button name='paypal_submit'  id="paypal_submit" class="btn btn-primary btn-large input-xlarge"><strong>はい、支払を確定します</strong></button>
									　　
									<a href="<?php echo URL."/purchase/?id=".$res['L_NUMBER0'];?>" class="btn btn-large input-large">キャンセルして戻る</a>
								</div>
							</form>

						</div><!-- //end of payment-paypal -->

					</div>

				</div><!-- end of panel-body -->

				<div class="panel-footer">
				</div>

			</div><!-- end of panel -->

		</div><!-- end of container -->

		<div id="paypal-container" class="container">
			<div class="center-block">
			</div>
		</div>

		<script src="<?php echo URL; ?>/common/lightning/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/bootstrap.min.js"></script>

	</body>
</html>