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
<h1>サイドバーの設定２</h1>
<?php
if( isset( $err )) { echo '<div class="alert alert-error">'; foreach( $err as $str ) { echo $str; } echo '</div>'; } elseif(isset( $message )) { echo '<div class="alert alert-success">'; echo $message; echo '</div>'; } ?>
<div style="margin-top:10px;margin-bottom:20px;"><a class="btn btn-default" href="<?php echo URL; ?>/admin/builders/?status=sidebar">サイドバーの設定１へ戻る</a></div>
<div class="well" style="margin-top:50px;">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>見出し修正　</span>見出しの修正ができます。</p>
	
	<table id="" cellspacing="0" cellpadding="0">
	<tbody>
	<?php
 if( isset( $midasi_data )): foreach( $midasi_data as $col ): $disabled = FALSE; if(!empty($col['side_titles_title'])){ $group_name = $groupsObj->make_group_name( $groups_data, $col['group_id'] ); if ($col['side_titles_title'] == 'no caption'){ $disabled = TRUE; } } ?>
	<tr>
		<td>
		<form method="post" id="edit_side_title" name="edit_side_title" action="" style="margin:0">
		<input type="hidden" value="side_title_edit" name="status">
		<input id="edit_side_title" style="width:98%;" name="side_titles_title" value="<?php echo ($disabled)?'':$col['side_titles_title'];?>" <?php echo ($disabled)?'disabled':'';?>>
		<input type="hidden" value="<?php echo $col['side_title_id']?>" name="side_title_id">
		<input type="hidden" value="POST" name="_method">
		</form>
		</td>
		<td class="span2">
		<a class="btn btn-primary" <?php echo ($disabled)?'':'onclick="document.forms[\'edit_side_title\'].submit();event.returnValue=false;return false;"';?> href="#" <?php echo ($disabled)?'disabled':'';?>>更新</a>
		</td>
	</tr>
	<?php
 break; endforeach; endif; ?>
	</tbody>
</table>

</div>
<div class="well">
	<p><span class="fs20 bold"><i style="margin-top:5px;" class="icon-ok-sign"></i>タイトル一覧　</span>タイトルの並び替えができます。</p>
	<p>タイトルは<span class="red">ドラッグ＆ドロップ</span>で表示順序を変更することができます。</p>
<div style="margin:20px 50px;">
<table cellspacing="0" cellpadding="0" style="margin-top:0px;margin-bottom:50px;">
	<thead>
	<tr>
		<th class="span2">見出し</th>
		<th class="span6"><span style="font-size:0.82em;color:green;">グループ(ID)</span><br>タイトル</th>
		<th class="span2">公開/非公開</th>
	</tr>
	</thead>
	<tbody id="sort_sortable">
	<?php
 if( isset( $midasi_data )): foreach( $midasi_data as $col ): if(!empty($col['contents_title']) || !empty($col['side_titles_title'])){ $group_name = $groupsObj->make_group_name( $groups_data, $col['group_id'] ); } ?>
	<tr id="<?php echo($col['position_c']."+".$col['contents_id']); ?>" style="cursor:move;">
		<td><?php echo ($col['side_titles_title']=='no caption') ? NOCAPTION:$col['side_titles_title']; ?></td>
		<td>
		<span style="font-size:0.82em;color:green;"><?php echo $group_name; ?>(<?php echo $col['group_id']; ?>)</span><br>
		<?php echo $col['contents_title']; ?>
		</td>
		
		<td>
		<?php if($col['contents_public']){echo '<span class="label label-success">公開</span>';}else{echo '<span class="label label-inverse">非公開</span>';}?>
		</td>
	</tr>
	<?php  endforeach; endif; ?>
	</tbody>
</table>
</div>
	<form action="" method="post" name="sort" style="margin-bottom:0px;">
		<input type="hidden" id="sort_result" value="" name="put_result" />
		<input type="hidden" value="sidebar_title" name="status">
		<div class="row-fluid" style="margin-top:20px;">
		<div class="control-group span4"></div>
		<div class="control-group span4">
		<input type="submit" id="btn_submit" class="btn btn-primary btn-large span4" value="並び順を保存" />
		</div>
		</div>
	</form>
</div><!--end of well-->
</div><!--end of container-->
</body>
</html>
