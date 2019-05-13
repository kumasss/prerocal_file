$("input").keypress(function (e) {
	if (e.which === 13) {
	e.preventDefault();
	return false;
	}
});
$("#submitBtn").click(function(e) {
	e.preventDefault();
	$(this).parents("form").attr('action', '');
	$("input[name='status']").val('LOGIN');
	$(this).prop('disabled',true);
	$(this).parents().submit();
	return false;
});
