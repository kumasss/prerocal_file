<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/doctype.php'); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../common/js/drag-and-drop.js'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>

<div class="container">
<h1 style="margin-bottom:20px;">サイドバーの設定１</h1>
<?php
if( isset( $err )) { echo '<div class="alert alert-error">'; foreach( $err as $str ) { echo $str; } echo '</div>'; } elseif(isset( $message )) { echo '<div class="alert alert-success">'; echo $message; echo '</div>'; } ?>
<div class="waku">
<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>上部フリーエリア　</span>サイドバー上部にテキストを入れたい場合に設定します。<br><span class="green">※HTML入力可能（改行したい場合は&lt;br/&gt;タグ等を追加）※<a href="<?php echo URL; ?>/admin/plugin/" target="_blank">プラグイン利用可能</a></span></p>
<div class="row">
<div class="span8">
	<?php
 if( isset( $side_freeareas_data )): foreach( $side_freeareas_data as $col ) { if($col['id'] == 1){ break; }else{ $col['contents'] = ''; } } ?>
	<form method="post" id="edit_freearea_id1" name="edit_freearea_id1" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_edit&id=1" style="margin:0">
	<textarea id="edit_freearea_id1" cols="10" rows="10" style="width:98%;height:300px;" name="contents"><?php echo $col['contents']; ?></textarea>
	<input type="hidden" value="POST" name="_method">
	</form>
	<a class="btn btn-primary" onclick="document.forms['edit_freearea_id1'].submit(); event.returnValue = false; return false;" href="#">更新</a>
	<form method="post" style="display:none;" id="del_freearea_id1" name="del_freearea_id1" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_delete&id=1">
	<input type="hidden" value="POST" name="_method">
	</form>
	<a class="btn btn-danger" onclick="if (confirm('上部フリーエリアを削除します。')) { document.forms['del_freearea_id1'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
	<?php endif;?>
</div><!-- end of span -->

<div class="span3">
<?php require(dirname(__FILE__).'/../../common/element/help_re_text.php'); ?>
</div><!--end of span-->
</div><!-- end of row -->
</div><!-- end of waku -->



<div class="waku" style="margin-top:30px;">
<h2 style="margin-bottom:10px">コンテンツページのリスト表示設定</h2>
<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>見出しタイトル　</span>サイドバーの見出しタイトルを設定します。</p>
<table id="" cellspacing="0" cellpadding="0">
	<tbody>
	<?php
 if( isset( $side_freeareas_data )): foreach( $side_freeareas_data as $col ) { if($col['id'] == 3){ break; }else{ $col['contents'] = ''; } } ?>
	<tr>
		<td>
		<form method="post" id="edit_freearea_id3" name="edit_freearea_id3" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_edit&id=3" style="margin:0">
		<input id="edit_freearea_id3" style="width:98%;" name="contents" value="<?php echo $col['contents'];?>">
		<input type="hidden" value="POST" name="_method">
		</form>
		</td>
		<td class="span2">
		<a class="btn btn-primary" onclick="document.forms['edit_freearea_id3'].submit(); event.returnValue = false; return false;" href="#">更新</a>
		</td>
	</tr>
	<?php  endif; ?>
	</tbody>
</table>

	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>並び替え設定　</span>見出しの並び替えと、リスト表示の初期状態を変更できます。</p>
	<p>見出しをクリックすると<span class="red">タイトル一覧ページ</span>へ移動します。</p>
	<p>見出しは<span class="red">ドラッグ＆ドロップ</span>で表示順序を変更することができます。コンテンツのない見出しのみ削除できます。</p>
	<p class="green">※（見出しなし）は見出しがないリストとなるため「リスト表示の初期設定」は表示のまま固定となります。</p>
<div style="margin:20px 50px;">
<table cellspacing="0" cellpadding="0" style="margin-bottom:0px;">
	<thead>
	<tr>
		<th class="span6">見出し項目<span class="red">（ドラッグして並び替え）</span></th>
		<th class="span3">リスト表示の初期設定<span class="red">（クリックで変更）</span></th>
		<th class="span1">&nbsp;</th>
	</tr>
	</thead>
	<tbody id="sort_sortable">
	<?php
 if( isset( $side_titles_data )): foreach( $side_titles_data as $col ): ?>
	<tr id="<?php echo($col['position_m']."+".$col['id']); ?>" class="<?php echo($col['id']); ?>" style="cursor:move;">
		<td>
		<?php echo (!$col['title']) ? '<span style="font-size:0.82em;color:green;">'.$group_name.'('.$group_data['group_id'].')</span><br>':NULL; ?>
		<!--見出しからさらにタイトル一覧へ-->
	<?php
 $exist_count = $buildersObj->ck_exist_title_sidebar( $col['id'] ); if ( $exist_count != 0 ){ ?>
		<a href="<?php echo URL; ?>/admin/builders/index.php?status=sidebar_title&side_title_id=<?php echo $col['id']; ?>">
		<?php echo ($col['title']=='no caption') ? NOCAPTION:$col['title'];?>
		</a>
	<?php
 }else{ echo ($col['title']=='no caption') ? NOCAPTION:$col['title']; } ?>
		</td>
		<td>
	<?php
 $exist_count = $buildersObj->ck_exist_title_sidebar( $col['id'] ); if ( $exist_count != 0 ){ if($col['title']!='no caption'){ if($col['toggle_flg']==1){ ?>
			<a id="toggle_flg-<?php echo $col['id'];?>" href="<?php echo URL; ?>/admin/builders/index.php?status=toggle_done&id=<?php echo $col['id']; ?>&toggle_flg=1"><span class="badge badge-info">開いている</span></a>
	<?php
 }else{ ?>
			<a id="toggle_flg-<?php echo $col['id'];?>" href="<?php echo URL; ?>/admin/builders/index.php?status=toggle_done&id=<?php echo $col['id']; ?>&toggle_flg=0"><span class="badge badge-warning">閉じている</span></a>
	<?php	 } }else{ echo '<div><span class="badge badge-inverse">表示のまま固定</span></div>'; } } ?>
		</td>
		<td>
		<?php
 if(!empty($col['title']) && $col['title']!='no caption' ){ ?>
		<form method="post" style="display:none;" id="del_sidebars_id<?php echo $col['id'] ?>" name="del_sidebars_id<?php echo $col['id'] ?>" action="<?php echo URL; ?>/admin/builders/index.php?status=sidebars_delete&id=<?php echo $col['id'] ?>">
		<input type="hidden" value="POST" name="_method">
		</form>
	<?php
 $exist_count = $buildersObj->ck_exist_title_sidebar( $col['id'] ); if ( $exist_count == 0 ){ ?>
		<a onclick="if (confirm('見出しを削除します。')) { document.forms['del_sidebars_id<?php echo $col['id'] ?>'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
	<?php
 } ?>
		<?php } ?>
		</td>
		
	</tr>
	<?php  endforeach; endif; ?>
	</tbody>
</table>
<p class="red" style="margin:5px;">※↑各見出しをクリックすると見出しの編集と、その見出しに含まれるページの表示順変更ができます。</p>
</div>
	<form action="" method="post" name="sort" style="margin-bottom:0px;">
		<input type="hidden" id="sort_result" value="" name="put_result" />
		<input type="hidden" value="sidebar" name="status">
		<div class="row-fluid" style="margin-top:20px;">
		<div class="control-group span4"></div>
		<div class="control-group span4">
		<input type="submit" id="btn_submit" class="btn btn-primary btn-large span4" value="並び順を保存" />
		</div>
		</div>
	</form>
</div>

<div class="waku" style="margin-top:30px;">
<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>中央部フリーエリア　</span>サイドバー中央部にテキストを入れたい場合に設定します。<br><span class="green">※HTML入力可能（改行したい場合は&lt;br/&gt;タグ等を追加）※<a href="<?php echo URL; ?>/admin/plugin/" target="_blank">プラグイン利用可能</a></span></p>
<div class="row">
<div class="span8">
	<?php
 if( isset( $side_freeareas_data )): foreach( $side_freeareas_data as $col ) { if($col['id'] == 5){ break; }else{ $col['contents'] = ''; } } ?>
	<form method="post" id="edit_freearea_id5" name="edit_freearea_id5" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_edit&id=5" style="margin:0">
	<textarea id="edit_freearea_id5" cols="10" rows="10" style="width:98%;height:300px;" name="contents"><?php echo $col['contents']; ?></textarea>
	<input type="hidden" value="POST" name="_method">
	</form>
	<a class="btn btn-primary" onclick="document.forms['edit_freearea_id5'].submit(); event.returnValue = false; return false;" href="#">更新</a>
	<form method="post" style="display:none;" id="del_freearea_id5" name="del_freearea_id5" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_delete&id=5">
	<input type="hidden" value="POST" name="_method">
	</form>
	<a class="btn btn-danger" onclick="if (confirm('中央部フリーエリアを削除します。')) { document.forms['del_freearea_id5'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
	<?php endif;?>
</div><!--end of span-->

<div class="span3">
<?php require(dirname(__FILE__).'/../../common/element/help_re_text.php'); ?>
</div><!-- end of span -->

</div><!-- end of row -->
</div><!-- end of waku -->

<div class="waku" style="margin-top:30px;">
<h2 style="margin-bottom:10px">その他ページのリスト表示設定</h2>
<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>見出しタイトル　</span>問い合わせページや会員情報変更ページのリスト表示部分の設定です。</p>
<table id="" cellspacing="0" cellpadding="0">
	<tbody>
	<?php
 if( isset( $side_freeareas_data )): foreach( $side_freeareas_data as $col ) { if($col['id'] == 4){ break; }else{ $col['contents'] = ''; } } ?>
	<tr>
		<td>
		<form method="post" id="edit_freearea_id4" name="edit_freearea_id4" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_edit&id=4" style="margin:0">
		<input id="edit_freearea_id4" style="width:98%;" name="contents" value="<?php echo $col['contents'];?>">
		<input type="hidden" value="POST" name="_method">
		</form>
		</td>
		<td class="span2">
		<a class="btn btn-primary" onclick="document.forms['edit_freearea_id4'].submit(); event.returnValue = false; return false;" href="#">更新</a>
		</td>
	</tr>
	<?php  endif; ?>
	</tbody>
</table>

<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>表示させるページ　</span>その他メニューに表示させるページの指定ができます。チェックを入れると表示します。</p>
<form id="edit_freearea_id6" name="edit_freearea_id6">

<?php
$disp_on = '<span class="green bold">【表示中】</span>'; $disp_off = '<span class="red">【非表示】</span>'; $disp_contact = ($tp_setting_data['disp_contact'])?1:0; $disp_member = ($tp_setting_data['disp_member'])?1:0; $disp_logout = ($tp_setting_data['disp_logout'])?1:0;; ?>

<div style="margin:20px 10px;">
<label class="checkbox">
<span id="disp_contact"><?php echo ($disp_contact)?$disp_on:$disp_off; ?></span><input type="checkbox" id="contact" <?php echo ($disp_contact)?"checked":"";?>>問い合わせフォーム
</label>
<label class="checkbox">
<span id="disp_member"><?php echo ($disp_member)?$disp_on:$disp_off; ?></span><input type="checkbox" id="member" <?php echo ($disp_member)?"checked":"";?>>会員情報変更
</label>
<label class="checkbox">
<span id="disp_logout"><?php echo ($disp_logout)?$disp_on:$disp_off; ?></span><input type="checkbox" id="logout" <?php echo ($disp_logout)?"checked":"";?>>ログアウト
</label>
</div>
</form>
<script type="text/javascript">
$("#edit_freearea_id6 input").change(function(){
	var flg_id = false;
	var flg_ch = false;
	if(this['id']=="contact"){
		flg_id = "contact";
	} else if(this['id']=="member"){
		flg_id = "member";
	} else if(this['id']=="logout"){
		flg_id = "logout";
	}
	if(this['checked']==true){
		flg_ch = true;
	}
	// ajax 保存
	var url = "<?php echo URL?>/admin/builders/index.php?status=sidebar_disp";
	$.ajax({
		url:url,
		type:'post',
		data:{'flg_id':flg_id,'flg_ch':flg_ch},
		success: function(res){
			var dt = res.split(",");
			var disp_pos = "#"+dt[0];
			if(dt[1]=="1"){
				$(disp_pos).html("【表示中】");
				$(disp_pos).removeClass("red bold");
				$(disp_pos).addClass("green bold");
			}else{
				$(disp_pos).html("【非表示】");
				$(disp_pos).removeClass("green bold");
				$(disp_pos).addClass("red");
			}
		},
		error: function(res){
			alert("err");
		}
	});
});
</script>
</div>

<div class="waku" style="margin-top:30px;">
<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>下部フリーエリア　</span>サイドバー下部にテキストを入れたい場合に設定します。<br><span class="green">※HTML入力可能（改行したい場合は&lt;br/&gt;タグ等を追加）※<a href="<?php echo URL; ?>/admin/plugin/" target="_blank">プラグイン利用可能</a></span></p>
<div class="row">
<div class="span8">
	<?php
 if( isset( $side_freeareas_data )): foreach( $side_freeareas_data as $col ) { if($col['id'] == 2){ break; }else{ $col['contents'] = ''; } } ?>
	<form method="post" id="edit_freearea_id2" name="edit_freearea_id2" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_edit&id=2" style="margin:0">
	<textarea id="edit_freearea_id2" cols="10" rows="10" style="width:98%;height:300px;" name="contents"><?php echo $col['contents']; ?></textarea>
	<input type="hidden" value="POST" name="_method">
	</form>
	<a class="btn btn-primary" onclick="document.forms['edit_freearea_id2'].submit(); event.returnValue = false; return false;" href="#">更新</a>
	<form method="post" style="display:none;" id="del_freearea_id2" name="del_freearea_id2" action="<?php echo URL; ?>/admin/builders/index.php?status=side_freeareas_delete&id=2">
	<input type="hidden" value="POST" name="_method">
	</form>
	<a class="btn btn-danger" onclick="if (confirm('下部フリーエリアを削除します。')) { document.forms['del_freearea_id2'].submit(); } event.returnValue = false; return false;" href="#">削除</a>
	<?php endif;?>
</div><!--end of span-->

<div class="span3">
<?php require(dirname(__FILE__).'/../../common/element/help_re_text.php'); ?>
</div><!--end of span-->

</div><!-- end of row -->
</div><!-- end of waku -->

</div>
</body>
</html>
