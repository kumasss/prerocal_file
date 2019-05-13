<?php
$class_users='';
$class_bodys='';
$name=$_SERVER['SCRIPT_NAME'];
if(strpos($name,'users') !== false){
	$class_users=' disabled';
}else if(strpos($name,'bodys') !== false)
{
	$class_bodys=' disabled';
}
?>
<script>
$(function(){
	$('a.disabled').click(function(){
		return false;
	})
});
</script>
<div class="well">
<a href="<?php echo URL; ?>/admin/users/?status=form" class="btn btn-default btn-small<?php echo $class_users?>">フォーム・ページ設定</a>
<a href="<?php echo URL; ?>/admin/bodys/" class="btn btn-default btn-small<?php echo $class_bodys?>" style="margin-left:20px">自動返信メール設定</a>
</div>
