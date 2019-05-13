<script type="text/javascript">
$(window).load(function() {
	$("#CustomUrlBtn").click(function(e){
		e.preventDefault();
		//input表示
		$("#editUrl").html("<input type=\"txt\" id=\"CustomUrl\" value=\"<?php echo $form_data['url']; ?>\" class=\"input-large\" name=\"url\">");
		$("#CustomUrlBtn").remove();
	});
	// enter key を無視
	$(document).on(
		'keypress',
		'#CustomUrl',
		function(e) {
			if (e.which === 13) {
			    return false;
			}
		}
	);
	// url ダブり確認
	$(document).on(
		'change',
		'#CustomUrl',
		function() {
			$("#loading").show();
			// データベースに存在確認
			<?php $form_data['id'] = empty($form_data['id']) ? '999999999' : $form_data['id']; //add時に利用?>
			var id = <?php echo $form_data['id']?>;
			var url = $(this).val();
			var checkurl = "<?php echo URL?>/admin/builders/tp_contents/index.php?status=check_url";
			$.ajax({
				url:checkurl,
				type:'post',
				data:{
					'id':id,
					'url':url
				},
				success: function(res){
				$("#loading").fadeOut(200,function(){
				$("#send_stepmail_form").show()
				if(res==99){
					$('#url_mess').css({"color":"#CC0000","border":"solid 3px #CC0000","padding":"3px", "margin":"3px 0"});
					$('#url_mess').text("カスタムURLは半角英数字及び記号(-_)で1-64文字までで入力してください。");
				}else if(res==55){
					// ダブっている
					$('#url_mess').css({"color":"#CC0000","border":"solid 3px #CC0000","padding":"3px", "margin":"3px 0"});
					$("#url_mess").text("NG");
				}else if(res==1){
					// OK
					$('#url_mess').css({"color":"#00CC00","border":"solid 3px #00CC00","padding":"3px"});
					$("#url_mess").text("OK");
				}else{
					// err
					$('#url_mess').css({"color":"#CC0000","border":"solid 3px #CC0000","padding":"3px", "margin":"3px 0"});
					$("#url_mess").text("err!!!");
				}
				});
				},
				error: function(res){
					$('#url_mess').css({"color":"#CC0000","border":"solid 3px #CC0000","padding":"3px", "margin":"3px 0"});
					$("#url_mess").text("err!!!");
				}
			});
		}
	);
});
</script>
