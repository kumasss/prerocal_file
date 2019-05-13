<?php
	require_once( 'config.ini' );
	require_once( 'builders.php' );

	$buildersObj = new builders();
	$eye_image_id = (int)$_POST['eye_image_id'];
	$buildersObj->get_img_uploaders( $eye_image_id, $eye_image );
	
	echo '<img src="'.URL.'/'.$eye_image['store_folder'].'/'.$eye_image['store_file'].'" alt="'.$eye_image['title'].'" style="max-width:64px">';
	echo '<input type="hidden" name="eye_image_id" value="'.$eye_image_id.'">';
	echo '<a id="img-del" href="#">削除</a>';
