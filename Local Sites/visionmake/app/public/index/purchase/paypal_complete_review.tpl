
<!DOCTYPE html>
<!--[if lt IE 7]>	   <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>		   <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>		   <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>お取引内容</title>
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
			.center-block {
				text-align:center;
			}
		</style>

	</head>

	<body>
		<div id="header">
		</div>

		<div class="container">

			<div class="alert alert-success" role="alert">
				<div  class="center-block">
					<h3>ご購入ありがとうございます。</h3>
				</div>
			</div>

			<div  class="center-block">
<pre>
<a href="<?php echo URL; ?>" class="btn btn-primary btn-large">コンテンツはこちらをクリック</a>
</pre>
			</div>
			<br/>


			<br/>
			<div class="well well-lg">
				<h4>決済完了メールタイトル</h4>
				<br/>
				<div>
					メール本文<br />
					〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇<br />
					〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇<br />
					〇〇〇〇〇〇〇〇〇〇〇〇〇〇〇
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
							<td>〇〇〇〇〇</td>
						</tr>
						<tr>
							<td class="head"><strong>説明</strong></td>
							<td>
								<span id="product-desc">
								〇〇〇〇〇<br />
								〇〇〇〇〇<br />
								〇〇〇〇〇
								</span>
							</td>
						</tr>
						<tr>
							<td class="head"><strong>金額</strong></td>
							<td>
							*****円（税込）
							</td>
						</tr>
						<tr>
							<td class="head"><strong>支払方法</strong></td>
							<td>PayPal決済</td>
						</tr>
					</table>



				<h4 class="well">PayPal 取引内容</h4>

					<table class="table table-bordered">
						<tr>
							<td class="head  <?php echo ($smartPhone ? "" : "span2"); ?>"><strong>取引日</strong></td>
							<td>****年**月**日 **時**分**秒</td>
						</tr>
						<tr>
							<td class="head"><strong>取引ID</strong></td>
							<td>****************</td>
						</tr>
						<tr>
							<td class="head "><strong>支払金額</strong></td>
							<td>*****円</td>
						</tr>
					</table>


				</div><!-- end of panel-body -->

				<div class="panel-footer">
				</div>

			</div><!-- end of panel -->

		</div><!-- end of container -->

		<script src="<?php echo URL; ?>/common/lightning/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/i18n/jquery-ui-i18n.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/bootstrap.min.js"></script>

	</body>
</html>