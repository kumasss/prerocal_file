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
			td.head {
				text-align:center;
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
				<h3 class="center-block">#{$state_message['title']}</h3>
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

<?php if ( $contract) : ?>

				    <h4 class="well">お振込申請内容</h4>

					<table class="table table-bordered">
						<tr>
							<td class="head <?php echo ($smartPhone ? "" : "span2"); ?>"><strong>取引日</strong></td>
							<td>#{$contract->order_time}</td>
						</tr>
						<tr>
							<td class="head"><strong>取引ID</strong></td>
							<td>#{$contract->bank_txn_id}</td>
						</tr>
						<tr>
							<td class="head"><strong>振込金額</strong></td>
							<td>
							#{$contract->price}円
							</td>
						</tr>
						<tr>
							<td class="head"><strong>振込予定日</strong></td>
							<td>
							#{$contract->bank_buyer_transfer_date}
							</td>
						</tr>
						<tr>
							<td class="head"><strong>振込名</strong></td>
							<td>
								#{$contract->bank_account_name}
							</td>
						</tr>
					</table>

<?php else: ?>
			<div class="alert alert-danger" role="alert">
				取引情報を取得できません。
			</div>
<?php endif;?>

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