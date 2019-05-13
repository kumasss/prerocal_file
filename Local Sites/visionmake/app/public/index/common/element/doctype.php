<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Cyfons管理画面</title>
<script src="<?php echo URL; ?>/common/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>/common/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>/common/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>/common/js/bootstrap-dropdown.js" type="text/javascript"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js"></script>
<link type="text/css" href="//ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />
<?php include_once(str_replace('\\','/',dirname(__FILE__)).'/../js/tinymce.inc');?>
<link href="<?php echo URL; ?>/common/css/bootstrap.min.css" type="text/css" rel="stylesheet">
<link href="<?php echo URL; ?>/common/css/common.css" type="text/css" rel="stylesheet">
<script type="text/javascript">
$(document).ready(function(){
	$('.dropdown-toggle').dropdown();
	$(".datepicker").datepicker();
});
</script>
</head>
