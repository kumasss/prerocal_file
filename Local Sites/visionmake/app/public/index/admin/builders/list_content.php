<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/doctype.php'); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<h1>コンテンツページ一覧・コンテンツページの作成</h1>
<div class="waku">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>コンテンツページ　</span>経過日を設定することで、「ステップ配信基準日」から経過した日数にあわせて表示するページをつくることができます。</p><p style="color:#EE0000;">※コンテンツページのサイドバー表示順序は、<a href="<?php echo URL?>/admin/builders/?status=sidebar">サイドバーの設定</a>で変更できます。</p>
	<a class="btn btn-primary input-large" href="<?php echo URL; ?>/admin/builders/tp_contents/">コンテンツページ作成</a>
</div>
<div class="row">
<div class="span2">
<?php $group_url = '/admin/builders/?status=content'; ?>
<?php require_once( dirname(__FILE__).'/../../common/element/group_select_li.php'); ?>
</div>
<div class="span10">
<script src="<?php echo URL;?>/common/js/clipboard.min.js"></script>
<table id="table_id" cellspacing="0" cellpadding="0" style="margin-bottom:8px;">
	<thead>
		<th style="width:300px"><span style="font-size:0.82em;color:green;">グループ(ID)</span><br><a href="<?php echo $sort_url_title;?>">タイトル</a></th>
		<th style="width:120px"><a href="<?php echo $sort_url_sidetitle;?>">見出し</a></th>
		<th style="width:120px"><a href="<?php echo $sort_url_date;?>">表示期間</a></th>
		<th><a href="<?php echo $sort_url_furl;?>">固定URL</s></th>
		<th><a href="<?php echo $sort_url_curl;?>">カスタムURL</s></th>
		<th>&nbsp;</th>
	</tr>
	</thead>
	<tbody>
	<?php
	if( isset( $contents_data )):
		foreach( $contents_data as $col ):
		$tsid = $buildersObj->get_side_title_id_tp_sidebars( $col['id'] );
		$midasi = $buildersObj->get_side_title_name_tp_side_titles( $tsid );
	?>
	<?php
	$group_name = $groupsObj->make_group_name( $groups_data, $col['group_id'] );
	?>
	<td><span style="font-size:0.82em;color:green;"><?php echo $group_name;?>(<?php echo $col['group_id'];?>)</span><br><a onclick="window.open('<?php echo URL;?>/preview2.php?page=<?php echo $col['id'];?>','preview2','width=1000,height=600,menubar=no,toolbar=no,location=no,status=no,directories=no,resizable=yes,scrollbars=yes'); event.returnValue=false; return false;" href="#"><?php echo mb_strimwidth($col['title'],0,120,'...','UTF-8'); ?></a></td>
	<td>
	<?php echo ($col['sidetitle']=='no caption') ? NOCAPTION:$col['sidetitle'];?>
	</td>
	<?php
	if( $col['public_date'] == 0 & $col['no_public_date'] == 0 ){
		$public_date = '期間設定なし';
	} elseif( $col['no_public_date'] == 0 ) {
		$public_date = $col['public_date'].'日後～';
	} elseif( $col['public_date'] >= $col['no_public_date'] ) {
		$public_date = $col['public_date'].'日後';
	} else {
		$public_date = $col['public_date'].'～'.$col['no_public_date'].'日後';
	}
	?>
	<td><?php echo $public_date; ?><br>
	<?php echo $col['public'] == 1 ? '<span class="label label-success">公開</span>':'<span class="label label-inverse">非公開</span>'; ?>
	<?php echo (!empty($col['password'])) ? '<span class="label label-inverse">パスワード</span>':''; ?>
	</td>
	<td>
	<div id="btn01<?php echo $col['id']?>" style="cursor:pointer;color:#0088cc;">page=<?php echo $col['id'];?></div>
	<script>
	var clipboard = new Clipboard("#btn01<?php echo $col['id']?>", {
		text: function() {
		return "<?php echo URL; ?>/page.php?page=<?php echo $col['id'];?>";
		}
	});
	clipboard.on('success', function(e) {
		copywindow(e['text']);
	});
	</script>
	</td>
	<td>
	<div id="btn02<?php echo $col['id']?>" style="cursor:pointer;color:#0088cc;"><?php echo $col['url']?></div>
	<script>
	var clipboard = new Clipboard("#btn02<?php echo $col['id']?>", {
		text: function() {
		return "<?php echo URL; ?>/pg/<?php echo $col['url']?>";
		}
	});
	clipboard.on('success', function(e) {
		copywindow(e['text']);
	});
	</script>
	</td>
	<td class="actions">
	<a class="label label-info" href="<?php echo URL; ?>/admin/builders/tp_contents/index.php?status=edit&id=<?php echo $col['id'];?>">編集</a>
	<form method="post" style="display:none;" id="del_post_id" name="del_post_id<?php echo $col['id'];?>" action="<?php echo URL; ?>/admin/builders/tp_contents/index.php?status=delete&id=<?php echo $col['id'];?>">
	<input type="hidden" value="POST" name="_method">
	</form>
	<a class="label label-important" onclick="if (confirm('ページを削除します。')) { document.forms['del_post_id<?php echo $col['id'];?>'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
	</td>
	</tr>
	<?php 
		endforeach;
	endif;
	?>
	</tbody>
</table>
<?php require_once( dirname(__FILE__).'/../../common/element/content_page_link.php'); ?>
<?php /**** copy url ****/ ?>
<div id="overlay">
   <p id="text">コピーしました。<br><span id="win_url">コピーしたURL</span></p>
</div>
<script>
function copywindow(t){
	$("#win_url").text(t);
	$("#overlay").fadeIn(200);
	$("#overlay").fadeOut(2000);
}
</script>
<style type="text/css">
#overlay{
	display: none;
	width: 100%;
	height:100%;
	text-align: center;
	position: fixed;
	top: 0;
	left:0;
	z-index: 100;
	background: rgba(0,0,0,0.7);
}
#text{
	font-size: 20px;
	color: #eee;
	padding-top: 200px;
	vertical-align: middle;
	font-weight: bold;
}
</style>
<?php /**** end of copy url ****/ ?>
</div><!--end of span-->
</div><!--end of row-->
</body>
</html>