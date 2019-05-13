<div class="nav-collapse">
	<ul class="nav">
		<li><a href="<?php echo URL; ?>/admin/builders/">サイト作成ツール</a></li>
		<li id="menu1" class="dropdown">
			<a href="#menu1" data-toggle="dropdown" class="dropdown-toggle">
				サイト管理
				<b class="caret"></b>
			</a>
			<ul class="dropdown-menu">
				<li><a href="<?php echo URL; ?>/admin/builders/?status=upload">アイキャッチ設定</a></li>
				<li><a href="<?php echo URL; ?>/admin/builders/tp_inquirys_menu/">メールフォーム設定</a></li> 
				<li><a href="<?php echo URL; ?>/admin/builders/tp_contents/?status=csv">コンテンツデータダウンロード</a></li>
				<li><a href="<?php echo URL; ?>/admin/plugin/">プラグイン</a></li>
			</ul>
		</li>
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
