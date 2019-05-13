<script type="text/javascript">
$(function() {
	<?php
	if($send_extramail==1){
		$css = '{"color":"green","border-bottom":"solid 3px green"}';
		$text = "号外メール稼働中";
	}else{
		$css = '{"color":"#CC0000","border-bottom":"solid 3px #CC0000"}';
		$text = "号外メール停止中";
	}
	?>
	$('#send_extramail_form label').css(<?php echo $css ?>);
	$('#send_extramail_txt').text("<?php echo $text ?>");
	$("#loading").hide();

	$('#SendExtraMail').change(function(){
		$("#loading").show();
		var data = $("#SendExtraMail:checked").val();
		var url = "<?php echo URL?>/admin/mails/index.php?status=send_extramail";
		$.ajax({
			url:url,
			type:'post',
			data:{'send_extramail':data},
			success: function(res){
				$("#loading").fadeOut(800,function(){
				$("#send_extramail_form").show();
				if(res==99){
					$('#send_extramail_form label').css({"color":"#CC0000","border":"solid 3px #CC0000","padding":"3px"});
					$('#send_extramail_txt').parent().text("号外メールを稼働できません。設定情報にエラーが見つかりました。グループをすべて削除して、新しく追加してみてください。");
				}else if(res==1){
					$('#send_extramail_form label').css({"color":"green","border-bottom":"solid 3px green"});
					$('#send_extramail_txt').text("号外メール稼働中");
				}else{
					$('#send_extramail_form label').css({"color":"#CC0000","border-bottom":"solid 3px #CC0000"});
					$('#send_extramail_txt').text("号外メール停止中");
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
