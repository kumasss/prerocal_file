	<div class="pagination">
	<?php
	$start=$skip+1;
	$end=$result_per_page+$skip;
	if($data_all==0)$start=0;
	if($end>=$data_all)$end=$data_all;
	echo '<div style="margin-bottom:5px;">';
	echo '全'.$data_all.'件中'.$start.' - '.$end.'件目';
	echo '</div>';
	?>
	<ul>
	<?php if( $num_pages > 1){echo $buildersObj->make_page_link( $form_data, $cur_page, $num_pages );} ?>
	</ul>
	</div>
