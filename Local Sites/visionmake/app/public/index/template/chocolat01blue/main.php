<!--------------Doctype--------------->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo ($data['title']) ? $data['title'].'&nbsp;|&nbsp;'.$data['site_name'] : $data['site_name'];?></title>
	<meta name="description" content="<?php echo $data['description']; ?>">
	<meta name="keywords" content="<?php echo $data['keyword']; ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/zerogrid.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/style.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/responsive.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/advanced.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/font.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/template/<?php echo $data['css']; ?>">

	<?php echo (!empty($data['head'])) ? htmlspecialchars_decode($data['head']) : NULL; ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
	<?php require_once(dirname(__FILE__).'/../../common/common.inc');?>


</head>
<!--------------Header--------------->
<body>
<header>
	<div class="wrap-header zerogrid">
		<?php if(empty($data['header_img'])){?>
		<div id="logotxt"><a href="<?php echo URL;?>"><?php echo ($data['site_name'])?$data['site_name']:'タイトル';?></a></div>
		<?php }else{ ?>
		<div id="logoimg"><a href="<?php echo URL;?>"><img src="<?php echo $data['header_img'];?>" alt="<?php echo $data['site_name'];?>"></a></div>
		<?php }; ?>
	</div>
<div id="slatenav">							<ul>
								<li class="current"><a href="<?php echo URL; ?>"><span>TOP</span></a>
								<li><a href="<?php echo URL; ?>/member.php"><span>会員情報変更</span></a></li>
								<li><a href="<?php echo URL; ?>/contact.php"><span>問い合わせフォーム</span></a></li>
								<li class="last"><a href="<?php echo URL; ?>/logout.php"><span>ログアウト</span></a></li>
							</ul>
</div>

</header>
<!--------------Content--------------->
<section id="content">
<div class="wrap-content zerogrid">
	<div class="row block">
		<div id="main-content" class="col-2-3">
			<div class="wrap-col">
				<article>
					<div class="heading"><h2><?php echo $data['title'] ?></h2>
						<div class="info"></a></div>
					</div>
					<div class="content">
<!--------------Page original start--------------->
<?php echo $data['contents']; ?>
<!--------------Page original end--------------->
					</div>
				</article>
			</div>
		</div>
<!--------------sidebar pagelist start--------------->
		<div id="sidebar" class="col-1-3">
			<?php echo $sidebar; ?>
		</div>
	</div>
</div>
</section>
<!--------------Footer--------------->
<footer>
	<div class="copyright">
		<p>&copy;  <a href="<?php echo URL; ?>"><?php echo ($data['site_name']) ? $data['site_name'] : 'サイト名'; ?></a></p>
	</div>
</footer>
</body></html>
