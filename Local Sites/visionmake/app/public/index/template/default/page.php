<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title><?php echo ($data['title']) ? $data['title'].'&nbsp;|&nbsp;'.$data['site_name'] : $data['site_name'];?></title>
<meta name="description" content="<?php echo $data['description']; ?>">
<meta name="keywords" content="<?php echo $data['keyword']; ?>">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
<link rel="stylesheet" href="<?php echo URL; ?>/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo URL; ?>/css/advanced.css">
<link rel="stylesheet" href="<?php echo URL; ?>/css/font.css">
<link rel="stylesheet" href="<?php echo URL; ?>/template/<?php echo $data['css']; ?>">
<?php echo (!empty($data['head'])) ? $data['head'] : NULL; ?>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<?php require_once(dirname(__FILE__).'/../../common/common.inc');?>
<script type="text/javascript"> 
$(function(){
$("#sub li").click(function(){
if($(this).find("a").length){window.location=$(this).find("a").attr("href");}
return false;
});
});
</script>
<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<link rel="icon" href="./favicon.ico" type="image/x-icon">
</head>
<body id="top">
<header>
<div class="hlogo">
		<?php if(empty($data['header_img'])){?>
		<h1><a href="<?php echo URL;?>"><?php echo ($data['site_name'])?$data['site_name']:'タイトル';?></a></h1>
		<?php }else{ ?>
		<a href="<?php echo URL;?>"><img src="<?php echo $data['header_img'];?>" alt="<?php echo $data['site_name'];?>"></a>
		<?php }; ?>
</div>
</header>
<nav id="menu">
<div class="wrap">
<ul>
<li><a href="<?php echo URL; ?>/main.php">ホーム<span>HOME</span></a></li>
<li><a href="<?php echo URL; ?>/member.php">会員情報変更<span>EDIT</span></a></li>
<li><a href="<?php echo URL; ?>/contact.php">お問い合わせ<span>CONTACT</span></a></li>
<li><a href="<?php echo URL; ?>/logout.php">ログアウト<span>LOGOUT</span></a></li>
</ul>
</div>
</nav>
<div id="container">
<div id="contents">
	<div id="main">
		<section>
		<h1><span><?php echo $data['title'] ?></span></h1>
		<?php echo $data['contents']; ?>
		</section>
	</div><!-- /main -->
	<div id="sub">
		<?php echo $sidebar; ?>
	</div><!-- /sub -->
	<p id="pagetop"><a href="#"><i class="icon-chevron-sign-up"></i> PAGE TOP</a></p>
</div><!-- /contents -->
</div><!-- /container -->
<footer>
	<div class="copyright">
		<p>&copy;  <a href="<?php echo URL; ?>"><?php echo ($data['site_name']) ? $data['site_name'] : 'サイト名'; ?></a></p>
	</div>
</footer>
</body>
</html>
