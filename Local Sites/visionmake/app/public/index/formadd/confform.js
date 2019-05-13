$("#submitBtn").click(function(e){
	e.preventDefault();
	$(this).parents("form").attr('action', '');
	$("input[name='status']").val("CONF2");
	$(this).prop('disabled',true);
	$(this).parents("form").submit();
	return false;
});
$("#cancelBtn").click(function(e){
	e.preventDefault();
	$(this).parents("form").attr('action', '');
	$("input[name='status']").val("");
	$(this).parents("form").submit();
	return false;
});
