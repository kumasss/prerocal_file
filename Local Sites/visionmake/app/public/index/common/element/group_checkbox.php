		<div class="control-group" id="group_id">
		<label class="control-label" for="group_id"><span class="red">*</span>グループ</label>
		<div class="controls">
			<?php
			if( isset($groups_data) ):
				if(!empty($_SESSION['acc_flg'])) {
					$id = (!empty($_SESSION['group_id'])) ? (int)$_SESSION['group_id']:1;
					$form_data['group_id-'.$id] = 1;
				}
				if(count($groups_data) > 1){$multi_array = TRUE;}else{$multi_array = FALSE;}
				$cnt = 0;
				foreach( $groups_data as $col ):
					$name = 'group_id-'.$col['id'];
					$chk = '';
					(isset($form_data[$name])) ? $chk='checked':NULL;
					if($col['id'] == 1 & $cnt == 0){
						echo '[ メンバー全員対象 ]<br>';
					}
			?>
		<label class="checkbox inline" style="margin:0 10px 0 0;">
		<input type="checkbox" id="GroupId<?php echo $col['id'];?>" name="<?php echo $name;?>" value="<?php echo $col['id'];?>" <?php echo $chk?>><?php echo $col['group_name'];?>
			<?php
				if($col['id'] == 1 & $cnt == 0){
					echo '<br><span class="green">こちらを選択した場合は、グループに関わらずメンバー全員が対象となります</span>';
				}
			?>
		</label>
			<?php
					if($col['id']==1 & $multi_array){
						echo '<br><br>[ グループ指定 ]<br>';
					}
					$cnt++;
				endforeach;
			else:
				echo '<label class="checkbox">グループが設定されていません。</label>';
			endif;
			?>
		</div>
		</div>
<script>
	$("#group_id input").change(function(){
		//$check = $("#GroupId1").prop("checked");
		$check = $(this).prop("checked");
		$id = $(this).attr("id");
		console.log($id);
		console.log($check);
		if($id=="GroupId1"){
			$('#group_id input').prop('checked', false);
			$('#GroupId1').prop('checked', true);
		}else{
			$('#GroupId1').prop('checked', false);
		}
	});
</script>
