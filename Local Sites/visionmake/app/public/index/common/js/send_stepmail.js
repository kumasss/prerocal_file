<script type="text/javascript">
$(function() {
	<?php
	if($send_stepmail==1){
		$css = '{"color":"green","border-bottom":"solid 3px green"}';
		$text = "ステップメール稼働中";
	}else{
		$css = '{"color":"#CC0000","border-bottom":"solid 3px #CC0000"}';
		$text = "ステップメール停止中";
	}
	?>
	$('#send_stepmail_form label').css(<?php echo $css ?>);
	$('#send_stepmail_txt').text("<?php echo $text ?>");
	$("#loading").hide();

	$('#SendStepMail').change(function(){
		$("#loading").show();
		var data = $("#SendStepMail:checked").val();
		var url = "<?php echo URL?>/admin/mails/index.php?status=send_stepmail";
		$.ajax({
			url:url,
			type:'post',
			data:{'send_stepmail':data},
			success: function(res){
				$("#loading").fadeOut(800,function(){
				$("#send_stepmail_form").show();
				if(res==99){
					$('#send_stepmail_form label').css({"color":"#CC0000","border":"solid 3px #CC0000","padding":"3px"});
					$('#send_stepmail_txt').parent().text("ステップメールを稼働できません。設定情報にエラーが見つかりました。グループをすべて削除して、新しく追加してみてください。");
				}else if(res==1){
					$('#send_stepmail_form label').css({"color":"green","border-bottom":"solid 3px green"});
					$('#send_stepmail_txt').text("ステップメール稼働中");
				}else{
					$('#send_stepmail_form label').css({"color":"#CC0000","border-bottom":"solid 3px #CC0000"});
					$('#send_stepmail_txt').text("ステップメール停止中");
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
