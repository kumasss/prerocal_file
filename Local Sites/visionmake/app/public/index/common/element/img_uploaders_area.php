<?php if(is_array($img_uploaders_data)):?>
<ul id="img_uploaders_area" class="thumbnails">
<?php foreach( $img_uploaders_data as $col ): ?>
<?php if($col['thumbnail']): ?>
<li class="span1">
<a id="img-<?php echo $col['id']?>" href="#" class="thumbnail" target="_blank"><img src="<?php echo URL.'/'.$col['store_folder'].'/'.$col['store_file']; ?>" alt="<?php echo $col['title'];?>" style="max-width:64px"><div style="text-align:center;">選択</div></a>
<?php /*<a id="img-<?php echo $col['id']?>" href="#">選択</a>*/?>

<script type="text/javascript">
$(function(){
	// add eye image
	$("#img-<?php echo $col['id']?>").live('click', (function(){
		var selText = "<?php echo $col['id'] ?>";
		var url = "<?php echo URL ?>";
		url=url+"/common/ajax_set_eye_image.php";
		$.post(url,{'eye_image_id': selText},function(data){
			$("#eye_image").html(data);
		});
		return false;
	}));
	// delete eye image
	$("#img-del").live('click', (function(){
		$("#eye_image").empty();
		$("#eye_image").html("アイキャッチは未設定です。");
		return false;
	}));

});
</script>

</li>
<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>
