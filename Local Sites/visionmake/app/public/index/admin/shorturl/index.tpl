<?php
require_once 'resources/mockdata.inc';
?>
<!DOCTYPE html>
<!--[if lt IE 7]>	   <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>		   <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>		   <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Cyfons管理画面</title>
		<meta name="description" content="">

		<!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

		<!-- additional files -->
		<link rel="stylesheet" href="<?php echo URL; ?>/common/lightning/css/ui-lightness/jquery-ui-1.9.2.custom.min.css">
		<link rel="stylesheet" href="<?php echo URL; ?>/common/lightning/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo URL; ?>/common/lightning/css/chosen/chosen.min.css">

		<style>
			* {
				font-family: Verdana, "メイリオ", "ヒラギノ角ゴ Pro W3", "ＭＳ Ｐゴシック", sans-serif;
			}
			thead {
				background: aliceblue
			}
			.marked {
				background: cornsilk  !important;
			}
			td.longurl {
				white-space:nowrap;
				overflow:hidden;
				text-overflow:ellipsis;
				-webkit-text-overflow:ellipsis;
				-o-text-overflow: ellipsis;
			}
			td.click-cnt {
				text-align:right
			}
		</style>

	</head>

	<body>
		<div id="header">
			<div class="navbar navbar-fixed-top">
				<div class="navbar-inner">
					<div class="container">
					<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>

					<div class="nav-collapse">
						<ul class="nav">
							<li id="menu3" class="dropdown">
								<a href="#menu3" data-toggle="dropdown" class="dropdown-toggle">
									会員管理
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo URL; ?>/admin/users/">会員管理</a></li>
									<li><a href="<?php echo URL; ?>/admin/groups/">グループ設定</a></li>
									<li><a href="<?php echo URL; ?>/admin/users/?status=form">会員登録フォーム設定</a></li>
									<li><a href="<?php echo URL; ?>/admin/bodys/">登録/解除時自動返信メール</a></li>
								</ul>
							</li>
							<li><a href="<?php echo URL; ?>/admin/shorturl/">短縮URL作成</a></li>
							<li><a href="<?php echo URL; ?>/admin/payment/">商品／入金管理</a></li>
							<li><a href="<?php echo URL; ?>" target="_blank">会員サイトを見る</a></li>
						</ul>
						<ul class="nav pull-right">
							<li id="menu4" class="dropdown">
								<a href="#menu4" data-toggle="dropdown" class="dropdown-toggle">
									システム管理
									<b class="caret"></b>
								</a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo URL; ?>/admin/users/index.php?status=admin">管理者情報</a></li>
									<li><a href="<?php echo URL; ?>/admin/users/index.php?status=system_backup">システムバックアップ</a></li>
									<li><a href="<?php echo URL; ?>/admin/contact/">提案/改善</a></li>
									<li><a href="<?php echo URL_MANUAL; ?>" target="_blank">ヘルプ</a></li>
									<li class="divider"></li>
									<li><a href="<?php echo URL; ?>/admin/index.php?status=logout">ログアウト</a></li>
								</ul>
							</li>
						</ul>
					</div>

					</div>
				</div>
			</div>
		</div>

		<div class="container">

			<h1>短縮URL管理</h1>
			<br/>

			<ul class="nav nav-tabs">
				<li><a href="#list" data-toggle="tab">一覧</a></li>
				<li><a href="#settings" data-toggle="tab">詳細（新規・更新）</a></li>
				<li><a href="#category" data-toggle="tab">カテゴリー（新規・更新）</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane  fade in active" id="list"></div>
				<div class="tab-pane  fade in" id="settings"></div>
				<div class="tab-pane  fade in" id="category"></div>
			</div>

		</div><!-- end of container -->

		<script src="<?php echo URL; ?>/common/lightning/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/jquery-ui-1.9.2.custom.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/i18n/jquery-ui-i18n.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/bootstrap.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/jquery.cookie.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/chosen.jquery.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/jquery.blockUI.js"></script>

		<script>
			$(document).ajaxStop($.unblockUI);
			$(document).ajaxStart( function() {
				$.blockUI({
					overlayCSS:{ opacity: 0.1},
					message: $('<h3>お待ちください…&nbsp;<img src="<?php echo URL; ?>/common/lightning/img/busy.gif"/></h3>'),
				});
			});

			$(document).ready( function() {

				if ( $.cookie("openTag")) {
					$('a[data-toggle="tab"]').parent().removeClass('active');
					$('a[href=#' + $.cookie("openTag") +']').click();
				} else {
					//default
					$('a[data-toggle="tab"]').parent().removeClass('active');
					$('a[href=#list]').click();
				}

				$('a[data-toggle="tab"]').on('shown', function (e) {

					var tabName = e.target.href;
					var items = tabName.split("#"); // script,active tab

					var subQuery = '';
					if ( items[1] === 'settings') {
						var shortCode = $.cookie("shortCode");
						if ( shortCode) {
							subQuery = "?code="+shortCode;
						}
					} else {
						$.cookie("shortCode","");
					}

					$.ajax({
						url: items[1]+".php"+subQuery,
						cache: false,
						success: function(html) {
							$( $(e.target).attr('href')).html(html);
								$.cookie("openTag",items[1], { expires: 700 });
						}
					});

					//e.relatedTarget // previous tab
				}).on('show', function(e) {
					$( $(e.target).attr('href')).empty();
				});
			});
		</script>

	</body>
</html>