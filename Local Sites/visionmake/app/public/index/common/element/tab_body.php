<script type="text/javascript">
$(function(){
	var hash = location.hash;
	$("div#setting").hide();
	$("div#add").hide();
	$("div#stop").hide();
	if(hash=="#setting"){
		$("#tab_setting").addClass("active");
		$("#tab_add").removeClass("active");
		$("#tab_stop").removeClass("active");
		
		$("div#setting").fadeIn("fast");
	}else if(hash=="#stop"){
		$("#tab_setting").removeClass("active");
		$("#tab_add").removeClass("active");
		$("#tab_stop").addClass("active");
		
		$("div#stop").fadeIn("fast");
	}else{
		$("#tab_setting").removeClass("active");
		$("#tab_add").addClass("active");
		$("#tab_stop").removeClass("active");
		
		$("div#add").fadeIn("fast");
	}
	$("ul.nav-tabs li a").click(function(){
		$("ul.nav-tabs li.active").removeClass("active");
		$(this).parents("li").addClass("active");

		$("div#setting").hide();
		$("div#add").hide();
		$("div#stop").hide();
		var attr = $(this).attr("href");
		$("div "+attr).fadeIn("fast");
		return false;
	});
});
</script>
<h2 style="margin-bottom:20px">会員登録/解除時の自動返信メール編集</h2>
<?php require_once( dirname(__FILE__).'/../../common/element/waku_form_add_stop.php'); ?>
<div id="myTabs">
<ul class="nav nav-tabs">
<li id="tab_setting"><a href="#setting">自動返信メール設定</a></li>
<li id="tab_add"><a href="#add">登録完了時メール</a></li>
<li id="tab_stop"><a href="#stop">解除時メール</a></li>
</ul>
</div>
