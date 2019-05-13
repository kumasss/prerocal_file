<script type="text/javascript">
$(function(){
	var hash = "<?php echo $form_data['hash'];?>";
	$("div#system").hide();
	$("div#admin").hide();
	if(hash=="admin"){
		$("#tab_system").removeClass("active");
		$("#tab_admin").addClass("active");
		
		$("div#admin").fadeIn("fast");
	}else{
		$("#tab_system").addClass("active");
		$("#tab_admin").removeClass("active");
		
		$("div#system").fadeIn("fast");
	}
	$("ul.nav-tabs li a").click(function(){
		$("ul.nav-tabs li.active").removeClass("active");
		$(this).parents("li").addClass("active");

		$("div#system").hide();
		$("div#admin").hide();
		var attr = $(this).attr("href");
		$("div "+attr).fadeIn("fast");
		return false;
	});
});
</script>
<h2 style="margin-bottom:20px">管理者情報変更/システム情報確認</h2>
<div id="myTabs">
<ul class="nav nav-tabs">
<li id="tab_admin"><a href="#admin">管理者情報</a></li>
<li id="tab_system"><a href="#system">システム情報</a></li>
</ul>
</div>
