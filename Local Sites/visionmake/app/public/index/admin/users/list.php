<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once(dirname(__FILE__).'/../../common/element/doctype.php'); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once(dirname(__FILE__).'/../../common/element/gnav_top.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div id="content">
<?php require_once( dirname(__FILE__).'/../../common/element/tab_member_add_stop.php'); ?>
<?php if( !empty( $err )):
	echo '<div class="alert alert-error">';
	foreach( $err as $str ){echo $str.'<br>';}
	echo '</div>';
endif?>
	<div class="users index">
	<div id="user_search">
	<h3>会員検索</h3>
	<div class="waku">
	<form accept-charset="utf-8" method="get" id="UserSearchUserForm" action="">
	<table class="table">
	<thead>
	<tr>
	<th>メールアドレス</th>
	<th>ユーザー名（姓または名のどちらか）</th>
	<th>注文ID</th>
	<th>グループ</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td><input type="text" id="UserUsername" style="width:100%;" placeholder="mail@exsample.com" class="form-control" name="email" value="<?php echo $form_data['email']; ?>"></td>
	<td><input type="text" id="UserName" style="width:100%;" placeholder="姓または名のどちらか" class="form-control" name="name" value="<?php echo $form_data['name']; ?>"></td>
	<td><input type="text" id="OrderNo" style="width:100%;" placeholder="123456" class="form-control" name="order_no" value="<?php echo $form_data['order_no']; ?>"></td>
	<td><?php require_once(dirname(__FILE__).'/../../common/element/group_select.php');?></td>
	</tr>
	</tbody>
	</table>
	
	<table class="table">
	<thead>
	<tr>
	<th>登録日</th>
	<th>ステップ配信基準日</th>
	<th>配信済ストーリーNo</th>
	<th>状態</th>
	</tr>
	</thead>
	<tbody>
	<tr>
	<td>
	<input type="text" id="create1" placeholder="2017-01-01" class="form-control" name="create1" value="<?php echo $form_data['create1']; ?>" style="width:100px;">　～　<input type="text" id="create2" placeholder="2017-01-01" class="form-control" name="create2" value="<?php echo $form_data['create2']; ?>" style="width:100px;">
	</td>
	<td>
	<input type="text" id="sendDate1" placeholder="2017-01-01" class="form-control" name="send_date1" value="<?php echo $form_data['send_date1']; ?>" style="width:100px;">　～　<input type="text" id="sendDate2" placeholder="2017-01-01" class="form-control" name="send_date2" value="<?php echo $form_data['send_date2']; ?>" style="width:100px;">
	</td>
	<td>
	<input type="text" id="storyNo1" placeholder="0" class="form-control" name="story_no1" value="<?php echo $form_data['story_no1']; ?>" style="width:50px;">　～　<input type="text" id="storyNo2" placeholder="123" class="form-control" name="story_no2" value="<?php echo $form_data['story_no2']; ?>" style="width:50px;">
	</td>
	<td>
<?php
$sel = '';
$sel0 = '';
$sel1 = '';
$sel99 = '';
if(isset($form_data['delete_flg']))
{
	if ($form_data['delete_flg'] == '0') {
		$sel0 = ' selected';
	}
	else if ($form_data['delete_flg'] == '1') {
		$sel1 = ' selected';
	}
	else if ($form_data['delete_flg'] == '99') {
		$sel99 = ' selected';
	}
	else {
		$sel = ' selected';
	}
}
else {
	$sel = ' selected';
	$form_data['delete_flg'] = '';
}
?>
	<select name="delete_flg" style="width:80px" class="form-control">
	<option value=""<?php echo $sel;?>>すべて</option>
	<option value="0"<?php echo $sel0;?>>正常</option>
	<option value="1"<?php echo $sel1;?>>停止</option>
	<option value="99"<?php echo $sel99;?>>エラー</option>
	</select>
	</td>
	</tr>
	</tbody>
	</table>
	
	<input type="hidden" name="status" value="user_search">
	<button type="submit" class="btn btn-primary" name="submit" value="serch">検　索</button>　
	<button type="submit" class="btn btn-default" name="submit" value="csv">CSVダウンロード</button>
	
	</form>	
	</div><!--end of waku-->
	</div>

	<div id="user_search_result">
	<h3>会員検索結果<span style="font-size:small;font-weight:normal;">　<?php echo '(全'.$data_all.'件)';?></span></h3>
	<table id="table_id" cellspacing="0" cellpadding="0" style="margin-bottom:8px;">
	<thead>
		<tr>
			<th style="width:8em">ユーザー名</th>
			<th>メールアドレス</th>
			<th>グループ(ID)<?php if($is_unit){echo "<br>ユニット";} ?></th>
			<th>登録日</th>
			<th>ステップ<br>配信基準日</th>
			<th style="text-align:center;padding:0;margin:0;width:6em;">送信済み<br>ストーリNo</th>
			<th>状態</th>
			<th>&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if( isset( $data )):
			foreach( $data as $col ):
		?>
		<tr>
		<td><?php echo $usersObj->show_esc( $col['firstname'].$col['lastname'] ); ?></td>
		<td><?php echo $usersObj->show_esc( $col['email'] ); ?></td>
		<?php
		$unit_user_code='';
		if($is_unit){
			$unit_user_arr = $usersObj->is_user_in_unit( $col['id'] );
			if(is_array($unit_user_arr)){
				foreach( $unit_user_arr as $unit_user ){
					$unit_user_code .= mb_strimwidth($unit_user['unit_name'],0,20,'....','utf-8').' / ';
				}
			}
			$unit_user_code = rtrim($unit_user_code, ' / ');
		}
		foreach( $groups_data as $group )
		{
			if( $group['id'] == $col['group_id'] ){$group_name = $group['group_name'];break;}else{$group_name='存在しないグループ';}
		}
		?>
		<td><?php echo mb_strimwidth($group_name,0,24,'....','utf-8').'('.$col['group_id'].')'; ?><br><?php echo $unit_user_code;?></td>
		<td><?php echo date('Y-m-d H:i', strtotime($col['created']));?></td>
		<td><?php echo (!empty($col['send_date'])) ? date('Y-m-d H:i', strtotime($col['send_date'])) : '<span class="label label-inverse">未配信</span>'; ?></td>
		<td style="text-align:center;"><?php echo (isset($col['story_no'])) ? (int)$col['story_no'] : NULL; ?></td>
		<td><?php if( $col['delete_flg'] == 0 ){echo '<span class="label label-success">正常</span>';}elseif( $col['delete_flg'] == 99 ){echo '<span class="label label-important">サーバーエラー</span>';}else{echo '<span class="label label-inverse">停止</span>';} ?></td>
		<td class="actions">
		<a href="<?php echo URL; ?>/admin/users/?status=edit&id=<?php echo (int)$col['id']; ?>" class="label label-info">編集</a>
		<form method="post" style="display:none;" id="post_id<?php echo (int)$col['id']; ?>" name="post_id<?php echo (int)$col['id']; ?>" action="<?php echo URL; ?>/admin/users/?status=user_delete&id=<?php echo (int)$col['id']; ?>"><input type="hidden" value="POST" name="_method"></form>
		<a onclick="if (confirm('会員を削除してよろしいですか？')) { document.post_id<?php echo (int)$col['id']; ?>.submit(); } event.returnValue = false; return false;" href="#" class="label label-important">削除</a>
		</td>
		</tr>
		<?php
			endforeach;
		endif;
		?>
	</tbody>
	</table>
	<?php require_once(dirname(__FILE__).'/../../common/element/user_page_link.php'); ?>
	</div><!--end of user_search_result-->
</div>
</div><!--end of containt-->
</div><!--end of container-->
<script>
$(function() {
	$("#create1").datepicker();
	$("#create1").datepicker("option", "dateFormat", "yy-mm-dd");
	$("#create2").datepicker();
	$("#create2").datepicker("option", "dateFormat", "yy-mm-dd");
	$("#sendDate1").datepicker();
	$("#sendDate1").datepicker("option", "dateFormat", "yy-mm-dd");
	$("#sendDate2").datepicker();
	$("#sendDate2").datepicker("option", "dateFormat", "yy-mm-dd");
	
	$('#create1').val("<?php echo $form_data['create1']?>");
	$('#create2').val("<?php echo $form_data['create2']?>");
	$('#sendDate1').val("<?php echo $form_data['send_date1']?>");
	$('#sendDate2').val("<?php echo $form_data['send_date2']?>");
	
	$('#create1').change( function(e) {
		e.preventDefault();
		var fromDate = $('#create1').val();
		var toDate = $('#create2').val();
		if ( fromDate && toDate) {
			if ( fromDate > toDate) {
				alert('日付の開始日を終了日より後に指定することはできません');
				$('#create1').val("");
				return false;
			}
		}
	});
	$('#create2').change( function(e) {
		e.preventDefault();
		var fromDate = $('#create1').val();
		var toDate = $('#create2').val();
		if ( fromDate && toDate) {
			if ( fromDate > toDate) {
				alert('日付の開始日を終了日より後に指定することはできません');
				$('#create2').val("");
				return false;
			}
		}
	});
	$('#sendDate1').change( function(e) {
		e.preventDefault();
		var fromDate = $('#sendDate1').val();
		var toDate = $('#sendDate2').val();
		if ( fromDate && toDate) {
			if ( fromDate > toDate) {
				alert('日付の開始日を終了日より後に指定することはできません');
				$('#sendDate1').val("");
				return false;
			}
		}
	});
	$('#sendDate2').change( function(e) {
		e.preventDefault();
		var fromDate = $('#sendDate1').val();
		var toDate = $('#sendDate2').val();
		if ( fromDate && toDate) {
			if ( fromDate > toDate) {
				alert('日付の開始日を終了日より後に指定することはできません');
				$('#sendDate2').val("");
				return false;
			}
		}
	});
	$('#storyNo1').change( function(e) {
		e.preventDefault();
		var fromDate = $('#storyNo1').val();
		var toDate = $('#storyNo2').val();
		if ( fromDate && toDate) {
			if ( fromDate > toDate) {
				alert('ストーリーNoの開始Noを終了Noより後に指定することはできません');
				$('#storyNo1').val("");
				return false;
			}
		}
	});
	$('#storyNo2').change( function(e) {
		e.preventDefault();
		var fromDate = $('#storyNo1').val();
		var toDate = $('#storyNo2').val();
		if ( fromDate && toDate) {
			if ( fromDate > toDate) {
				alert('ストーリーNoの開始Noを終了Noより後に指定することはできません');
				$('#storyNo2').val("");
				return false;
			}
		}
	});
});
</script>
</body>
</html>
