<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../common/element/doctype.php' ); ?>
<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>
<div class="container">
<form action="<?php echo URL?>/admin/builders/?status=template" name="template_frm" method="post">
<input type="hidden" name="template_file" value="">
<?php echo $html;?>
</form>

<script>
$(document).ready(function(){
	$("a.tmpl").click(function(){
	file=$(this).attr("href");
		if (confirm('選択したテンプレートをダウンロードします。') == false){
			return false;
		}
		document.forms['template_frm']['template_file'].value = file;
		document.forms['template_frm'].submit();
	return false;
	});
});
var status = "";
<?php if (isset($down_status)){?>
	status = "<?php echo $down_status;?>";
<?php }?>
if (status == "-1"){
	alert('アップデートファイルがダウンロードできませんでした。\nしばらくしてから再度実行してください。');
}else if (status == "1") {
	alert('ダウンロードされました。');
}
</script>

</div><!--end of container-->
</body>
</html>
