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

		<div class="container">

<?php if ( isset($error)): ?>
			<div class="alert alert-danger" role="alert">
				<div  class="center-block">
					<h3>#{nl2br($error)}</h3>
				</div>
			</div>
<?php endif; ?>

			<div class="center-block">
				<a href="<?php echo URL."/purchase/?id=".$productId;?>" class="btn btn-large">決済選択画面へ戻る</a>
			</div>

		</div><!-- end of container -->

		<script src="<?php echo URL; ?>/common/lightning/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/bootstrap.min.js"></script>

	</body>

</html>
