<script type="text/javascript">
//ドラッグ＆ドロップ(list_sidebar.php list_sidebar_title.php)
$(function() {
	$("#sort_sortable").sortable({helper: helper1});
	$("#sort_sortable").disableSelection();
	$("#btn_submit").click(function() {
		var result = $("#sort_sortable").sortable("toArray");
		$("#sort_result").val(result);
		$("form.put_result").submit();
	});
});
function helper1(e, tr) {
	var $originals = tr.children();
	var $helper = tr.clone();
	$helper.children().each(function(index) {
		$(this).width($originals.eq(index).width());
	});
	return $helper;
}
</script>
