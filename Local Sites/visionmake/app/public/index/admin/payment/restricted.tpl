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
		</style>

	</head>

	<body>
		<div id="header">
		</div>

		<div class="container">

			<div class="alert-danger" role="alert">
				<h3>
					<center>
					#{$error_message}
					</center>
				</h3>
			</div>

			<div>
				<br/>
				<center>
					<a href="<?php echo URL;?>" class="btn btn-large">トップページへ</a>
				</center>
			</div>

		</div><!-- end of container -->

		<script src="<?php echo URL; ?>/common/lightning/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/bootstrap.min.js"></script>


	</body>
</html>