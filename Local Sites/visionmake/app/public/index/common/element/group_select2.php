<?php if(empty($form_data['group_id2'])){ $group['id']='all'; } ?>
<div class="">
<select name='group_id2' id="group_id2">
<?php
foreach( $groups_data as $group2 )
{
	if($form_data['group_id2'] == $group2['id']){
		echo '<option value="'.$group2['id'].'" selected>';
	}else{
		echo '<option value="'.$group2['id'].'">';
	}
	echo $group2['group_name'].'</option>';
}
?>
</select>
</div>
