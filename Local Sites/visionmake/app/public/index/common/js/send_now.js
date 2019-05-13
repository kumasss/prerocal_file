<script type="text/javascript">
$(function() {
	<?php
	if($send_now==1){
		$css = '{"color":"green"}';
		$text = "ステップメールのストーリNo１を会員登録時に即時送信する";
	}else{
		$css = '{"color":"#0077CC"}';
		$text = "ステップメールのストーリNo１を会員登録時に即時送信しない";
	}
	?>
	$('#send_now_form label').css(<?php echo $css ?>);
	$('#send_now_txt').text("<?php echo $text ?>");
	$("#loading").hide();

	$('#SendNow').change(function(){
		$("#loading").show();
		var data = $("#SendNow:checked").val();
		
		var url = "<?php echo URL?>/admin/mails/index.php?status=send_now";
		$.ajax({
			url:url,
			type:'post',
			data:{'send_now':data},
			success: function(res){
				$("#loading").fadeOut(800,function(){
				$("#send_now_form").show();
				if(res==99){
					$('#send_now_form label').css({"color":"#CC0000","border":"solid 3px #CC0000","padding":"3px"});
					$('#send_now_txt').parent().text("即時送信を設定できません。設定情報にエラーが見つかりました。グループをすべて削除して、新しく追加してみてください。");
				}else if(res==1){
					$('#send_now_form label').css({"color":"green"});
					$('#send_now_txt').text("ステップメールのストーリNo１を会員登録時に即時送信する");
				}else{
					$('#send_now_form label').css({"color":"#0077CC"});
					$('#send_now_txt').text("ステップメールのストーリNo１を会員登録時に即時送信しない");
				}
				});
			},
			error: function(res){
			alert("err");
			}
		});
	});
});
</script>
