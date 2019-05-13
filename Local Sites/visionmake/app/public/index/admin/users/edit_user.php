<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../common/element/gnav_top.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<div class="users form">
<form accept-charset="utf-8" method="post" id="UserEditForm" class="form-horizontal" action="<?php echo URL; ?>/admin/users/">
	<div style="display:none;"><input type="hidden" value="PUT" name="_method"></div>
	<fieldset>
		<legend>会員情報修正</legend>
		<?php
		if(!empty($err)) {
			echo '<div class="alert alert-danger">登録できませんでした。</div>';
		}
		else if(isset( $message )) {
			echo '<div class="alert alert-success">'.$message.'</div>';
		}
		else {
			echo '<div class="waku">ユーザー情報を変更します。</div>';
		}
		?>
		<div class="control-group">
		<label class="control-label" for="title_id">配信状態</label>
		<div class="controls required">
		<select id="SendNum" class="input-medium" name="delete_flg">
		<option <?php if( $data['delete_flg'] == 0 ) echo 'selected="selected"'; ?> value="0">正常</option>
		<?php
		/*if($is_unit){
		$sel = '';
		if( $data['delete_flg'] == 10 ) $sel = ' selected="selected"';
		echo '<option'.$sel.' value="10">ユニットのみ配信</option>';
		}*/
		?>
		<option <?php if( $data['delete_flg'] == 1 ) echo 'selected="selected"'; ?> value="1">停止</option>
		<option <?php if( $data['delete_flg'] == 99 ) echo 'selected="selected"'; ?> value="99">エラー停止</option>
		</select>
		<input type="hidden" value="<?php echo $data['delete_flg']?>" name="old_delete_flg">
		</div>
		</div>
		<?php
		if($is_unit){
			$unit_user_arr = $usersObj->is_user_in_unit( $form_data['id'] );
			$unit_user_code='';
			if(is_array($unit_user_arr)){
				foreach( $unit_user_arr as $unit_user ){
					$unit_url = URL.'/admin/units/mails/?status=edit&unit_code='.$unit_user['unit_code'];
					$unit_user_code .= '<a href="'.$unit_url.'">'.mb_strimwidth($unit_user['unit_name'],0,20,'....','utf-8').'</a> / ';
				}
			}
			$unit_user_code = rtrim($unit_user_code, ' / ');
		?>
		<div class="control-group">
		<label class="control-label" for="unit">ユニットメール登録</label>
		<div class="controls">
			<span style="display:inline-block;padding-top:5px;padding-right:3px;" class="green"><?php echo ($unit_user_arr)?'登録されています['.$unit_user_code.']':'未登録';?></span>
		</div>
		</div>
		<?php } ?>
		<div class="control-group">
		<label class="control-label" for="title_id">送信済みストーリNo</label>
		<div class="controls required">
		<input type="text" class="input-mini" value="<?php echo (int)$data['story_no']; ?>" name="story_no">
		<?php if(!empty($err['num'])) echo '<div class="red fs12">'.$err['num'].'</div>'; ?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">最終配信日時</label>
		<div class="controls required">
		<?php $mail_send_date=(!empty($data['mail_send_date'])) ? $data['mail_send_date'] : NULL; ?>
		<span style="display:inline-block;padding-top:5px;padding-right:3px;"><?php echo $usersObj->show_esc($mail_send_date); ?></span>
        <input type="hidden" value="<?php echo $mail_send_date; ?>" name="send_date">
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">ステップ配信基準日</label>
		<div class="controls required">
		<input type="hidden" value="<?php echo $data['send_date'] ?>" name="send_date">
		<?php if(!empty($data['send_date'])){$send_date = $usersObj->show_esc( $data['send_date'] );} else {$send_date = '<span class="label label-inverse">未配信</span>';} ?>
		<span style="display:inline-block;padding-top:5px;padding-right:3px;"><?php echo $send_date; ?></span>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">登録日</label>
		<div class="controls required">
		<input type="hidden" value="<?php echo $data['created'] ?>" name="created">
		<span style="display:inline-block;padding-top:5px;padding-right:3px;"><?php echo $usersObj->show_esc( $data['created'] ); ?></span>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label">登録IP</label>
		<div class="controls">
		<input type="hidden" value="<?php echo $data['ip'] ?>" name="ip">
		<span style="display:inline-block;padding-top:5px;padding-right:3px;"><?php echo $usersObj->show_esc( $data['ip'] ); ?></span>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label">登録HOST</label>
		<div class="controls">
		<input type="hidden" value="<?php echo $data['host'] ?>" name="host">
		<span style="display:inline-block;padding-top:5px;padding-right:3px;"><?php echo $usersObj->show_esc( $data['host'] ); ?></span>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="group_id">グループ</label>
		<div class="controls required">
		<select id="groupId" class="input-xlarge" name="group_id">
		<?php foreach($groups_data as $col):?>
			<option <?php if($data['group_id']==$col['id']) echo 'selected="selected"'; ?> value="<?php echo $col['id'];?>"><?php echo $col['group_name'];?></option>
		<?php endforeach; ?>
		</select>
		<input type="hidden" name="old_group_id" value="<?php echo $data['group_id'];?>">
		<p class="red">※グループを変更するとステップメールのストーリNoが「０」になります。</p>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id"><span class="red">*</span>メールアドレス</label>
		<div class="controls required">
		<input type="txtarea" id="Email" value="<?php echo $data['email']; ?>" class="input-xlarge" name="email">
		<?php if(!empty($err['email'])) echo '<div class="red fs12">'.$err['email'].'</div>'; ?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="name">名前</label>
		<div class="controls required">
		<span style="display:inline-block;padding-top:5px;padding-right:3px;">姓</span><input type="txtarea" id="FName" value="<?php echo $data['firstname']; ?>" class="input-large" name="firstname">
		<span style="display:inline-block;padding-top:5px;padding-right:3px;">名</span><input type="txtarea" id="LName" value="<?php echo $data['lastname']; ?>" class="input-large" name="lastname">
		<?php if(!empty($err['name'])) echo '<div class="red fs12">'.$err['name'].'</div>'; ?>
		</div>
		</div>
		<div class="control-group">
		<label class="control-label" for="title_id">注文ID</label>
		<div class="controls required">
		<input type="txtarea" id="BlogTitle" value="<?php echo $data['order_no']; ?>" class="input-xlarge" name="order_no">
		</div>
		</div>
		<div class="control-group">
		<div class="controls">
		<span class="red">*</span> がついている項目はかならず入力してください。
		</div>
		</div>
	</fieldset>
	<div class="form-actions">
	<input type="hidden" value="<?php echo (int)$data['id'] ?>" name="id">
	<input type="hidden" value="user_edit" name="status">
	<input type="hidden" value="<?php echo $returl;?>" name="returl">
	<button type="submit" class="btn btn-primary" style="margin-right:5px"><i class="icon-ok icon-white" style="margin:1px 2px 0 0;"></i>保 存</button><a class="btn" href="<?php echo $returl;?>">戻る</a>
	</div>
	</form>
</div>
</body>
</html>
