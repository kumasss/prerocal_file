<?php
	require_once( 'config.ini' );
	require_once( 'builders.php' );
	$buildersObj = new builders();

	$buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 );
	$id = $img_uploaders_data[0]['id'];
	$store_folder = $img_uploaders_data[0]['store_folder'];
	$store_file = $img_uploaders_data[0]['store_file'];

	echo '<ul class="thumbnails">';
	echo '<li class="span3" style="margin-bottom:0;">';
	echo '<img src="'.URL.'/'.$store_folder.'/'.$store_file.'" style="max-height:200px;" />';
	echo '<a id="img-'.$id.'" href="#">削除</a>';
	echo '</li>';
	echo '</ul>';
	echo '<div class="green fs12">新しいヘッダー画像を設置するときは、画像を削除してください。</div>';
?>
<script Language="JavaScript"><!--
$(function(){
	var url = "<?php echo URL?>";
	var img_id = "<?php echo $id ?>";
	url=url+"/admin/builders/tp_settings/index.php?status=delete_header&id=<?php echo $id?>";
	$("#img-<?php echo $id?>").live('click', (function(){
		if(confirm("削除してよろしいですか？")){
			$.post(url,{'header_id': img_id},function(data){
				$("#HeaderImg").html(data);
			});
		}
		return false;
	}));
});
// --></script>