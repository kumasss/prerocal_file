<script type="text/javascript">
$(window).load(function() {
	// Window Preview
	$(".PreviewBtn").click(function(e){
		e.preventDefault();
		var title = $("#ContentsTitle").val();
		var contents = '';
		<?php
		if (isset($settings['is_edit'])){
			if (empty($settings['is_edit'])){
				echo 'contents = $("#ContentsContent").val();';
			}else{
				echo 'contents = tinyMCE.activeEditor.getContent();';
			}
		}
		?>
		var layout = $("input[name=layout]").val();
		if($("#addBr").is(':checked')){var add_br=1;}
		var url = "<?php echo URL; ?>";
		var form = $('<form></form>',{action:url+'/preview.php',target:'preview',method:'POST'}).hide();
		var body = $('body');
		body.append(form);
		form.append($('<input>',{type:'hidden',name:'title',value:title}));
		form.append($('<input>',{type:'hidden',name:'contents',value:contents}));
		form.append($('<input>',{type:'hidden',name:'layout',value:layout}));
		form.append($('<input>',{type:'hidden',name:'add_br',value:add_br}));
		window.open('about:blank'
					,'preview'
					,'width=1000,height=600,menubar=no,toolbar=no,location=no,status=no,resizable=yes,scrollbars=yes');
		form.submit();
		return false;
	});
});
</script>