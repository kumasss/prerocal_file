<script type="text/javascript">
$(function(){
	str = "<?php echo URL;?>"+"/common/element/news.php";
	$("#loading").show();
	$.ajax({
		type: 'GET',
		url: str,
		dataType: 'html',
		success: function(data) {
			$("#loading").fadeOut(30,function(){
				$('#news').html(data);
			});
		},
		complete: function(){
		},
		error:function() {
			$("#loading").hide();
			alert('お知らせの取得に失敗しました。時間を開けて再度読み込みなおしてください。');
		}
	});

});
</script>
