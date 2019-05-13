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

<?php if ( isset($state_message)): ?>
			<div class="alert #{$state_message['color']}" role="alert">
				<div  class="center-block">
					<h3>#{$state_message['title']}</h3>
				</div>
			</div>
<?php endif; ?>

			<div  class="center-block">

<?php if ( ($responseFlag->content_url  || $responseFlag->content_url_free) && !empty($product->after_url)) :?>
<pre>
<a href="#{$product->after_url}" class="btn btn-primary btn-large">コンテンツはこちらをクリック</a>
</pre>
<?php elseif ( $responseFlag->content_url ) :?>
<pre>
<a href="#{$product->register_url}" class="btn btn-primary btn-large">コンテンツはこちらをクリック</a>
</pre>
<?php elseif ($responseFlag->login_content_url) :?>
<pre>
<a href="#{$product->register_url}" class="btn btn-primary btn-large">ログインはこちらをクリック</a>
</pre>
<?php endif;?>

<?php if ( $responseFlag->regist_url && !empty($product->register_url)) :?>
<pre>
<a href="#{$product->register_url}" class="btn btn-primary btn-large">ユーザー登録はこちらをクリック</a>
</pre>
<?php endif;?>

<?php if ($responseFlag->login_url) :?>
<pre>
<a href="#{URL}" class="btn btn-primary btn-large">ログインはこちらをクリック</a>
</pre>
<?php endif;?>

			</div>

<?php if ( $responseFlag->show_mail): ?>
			<br/>
			<div class="well well-lg">
				<h4>#{$mail_title}</h4>
				<br/>
				<div>
					#{$mail_body}
				</div>
			</div>
<?php endif;?>


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
							#{$product->price}円（税込）
							</td>
						</tr>
						<tr>
							<td class="head"><strong>支払方法</strong></td>
							<td>PayPal決済</td>
						</tr>
					</table>


<?php if ( $contract) : ?>

				<h4 class="well">PayPal 決済情報</h4>

					<table class="table table-bordered">
						<tr>
							<td class="head  <?php echo ($smartPhone ? "" : "span2"); ?>"><strong>取引日</strong></td>
							<td>#{$contract->order_time}</td>
						</tr>
						<tr>
							<td class="head"><strong>取引ID</strong></td>
							<td>#{$contract->txn_id}</td>
						</tr>
						<tr>
							<td class="head"><strong>支払金額</strong></td>
							<td>#{$contract->mc_gross}#{$currency}</td>
						</tr>
					</table>

<?php else: ?>
			<div class="alert alert-danger" role="alert">
				取引情報を取得できません。
				<br/><a href="https://www.paypal.jp/">PayPal</a>にログインし、
				<br/>取引状況をご確認ください。
			</div>
<?php endif;?>

				</div><!-- end of panel-body -->

				<div class="panel-footer">
				</div>

			</div><!-- end of panel -->

			<div class="center-block">
				<a href="<?php echo URL."/purchase/?id=".$product->id;?>" class="btn btn-large">決済選択画面へ戻る</a>
			</div>

		</div><!-- end of container -->

		<script src="<?php echo URL; ?>/common/lightning/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/bootstrap.min.js"></script>

	</body>
</html>