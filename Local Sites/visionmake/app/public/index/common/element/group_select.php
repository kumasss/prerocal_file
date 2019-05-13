<?php if(empty($form_data['group_id'])){ $group['id']='all'; } ?>
<div class="">
<select name='group_id' id="group_id">
<?php
foreach( $groups_data as $group )
{
	if($form_data['group_id'] == $group['id']){
		echo '<option value="'.$group['id'].'" selected>';
	}else{
		echo '<option value="'.$group['id'].'">';
	}
	echo $group['group_name'].'</option>';
}
?>
</select>
</div>
