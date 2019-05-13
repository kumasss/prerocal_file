<?php if(empty($form_data['group_id'])){ $group['id']='all'; } ?>
<div class="" style="margin-top:25px;">
<ul class="nav nav-pills nav-stacked">
<?php
foreach( $groups_data as $group )
{
	if($form_data['group_id'] == $group['id']){
		echo '<li class="active">';
	}else{
		echo '<li>';
	}
	echo '<a href="'.URL.$group_url.'&group_id='.$group['id'].'">'.$group['group_name'].'</a></li>';
}
?>
</ul>
</div>
