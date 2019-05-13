<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 global $post;
 $theme_options = get_theme_options();
 $custom_css = get_custom_css();

 // カウントダウン有無
 $countdown = false;
 if( is_page() ) {
  if( get_field('countdown_method', $post->ID) === 'access' || get_field('countdown_method', $post->ID) === 'date' ) {
   $countdown = true;
  }
 }

 // ページ幅
 if( is_home() || is_single() || is_archive() || is_search() || (get_field('entire_enable', $post->ID) === 'on' || $theme_options['all_enable'] === 'on') ) { // 全体設定
  if( $theme_options['pwidth'] ) {
   $pwidth = $theme_options['pwidth'];
  } else {
   $pwidth = 900;
  }
  $sp_enable = $theme_options['sp_enable'];
 } else { // 個別設定
  if( get_field('pwidth', $post->ID) ) {
   $pwidth = get_field('pwidth', $post->ID);
  } else {
   $pwidth = 900;
  }
  $sp_enable = get_field('sp_enable', $post->ID);
 }
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7 <?php echo $post->post_type; ?>" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8 <?php echo $post->post_type; ?>" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html class="<?php echo $post->post_type; ?>" <?php language_attributes(); ?>>
<!--<![endif]-->



<!-- ＝＝＝＝＝＝＝　ここからhead　＝＝＝＝＝＝＝ -->

<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<?php if( $sp_enable === 'on' ) : ?>
<meta name="viewport" content="width=device-width" />
<?php else : ?>
<meta name="viewport" content="width=<?php echo $pwidth + 100; ?>" />
<?php endif; ?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<script src="https://www.youtube.com/iframe_api" type="text/javascript"></script>
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.smoothScroll.js" type="text/javascript"></script>

<?php if( get_field('countdown_design', $post->ID) === 'design2' || get_field('countdown_indesign', $post->ID) === 'design2' ) : ?>
<script src="<?php echo get_template_directory_uri(); ?>/countdown/assets/countdown/jquery.countdown.js"></script>
<?php endif; ?>
<?php if( get_field('countdown_indesign', $post->ID) === 'design3' ) : ?>
<link rel="stylesheet"  href="<?php echo get_template_directory_uri(); ?>/css/jquery.classycountdown.css" type="text/css" media="all" />
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.knob.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.throttle.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.classycountdown.min.js"></script>
<?php endif; ?>
<?php if( get_field('countdown_indesign', $post->ID) === 'design4' ) : ?>
<link rel="stylesheet"  href="<?php echo get_template_directory_uri(); ?>/css/flipclock.css" type="text/css" media="all" />
<script src="<?php echo get_template_directory_uri(); ?>/js/flipclock.min.js"></script>
<?php endif; ?>

<?php wp_head(); ?>
<link rel="stylesheet"  href="<?php echo get_template_directory_uri(); ?>/css/gelatine.css" type="text/css" media="all" />
<link rel="stylesheet"  href="<?php echo get_template_directory_uri(); ?>/css/fontello.css" type="text/css" media="all" />
<?php if( wp_is_mobile() ) : ?><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/fontello.css" type="text/css" media="all" /><?php endif; ?>
<?php if( $sp_enable === 'on' ) : ?><link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/sp.css" type="text/css" media="all" /><?php endif; ?>

<?php
 // フォント
 if( is_home() || is_single() || is_archive() || is_search() || (get_field('entire_enable', $post->ID) === 'on' || $theme_options['all_enable'] === 'on') ) { // 全体設定
  $font_family = $theme_options['font_family'];
 } else { // 個別設定
  $font_family = get_field('font_family', $post->ID);
 }
 switch( $font_family ) {
   case 1:
     $font = '"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","メイリオ",Meiryo, Osaka,"ＭＳ Ｐゴシック","MS PGothic",sans-serif';
     break;
   case 2:
     $font = '"ヒラギノ明朝 Pro W3","ＭＳ Ｐ明朝",serif';
     break;
   case 3:
     $font = '"メイリオ",Meiryo,"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","ＭＳ Ｐゴシック",sans-serif';
     break;
   case 4:
     $font = '"ヒラギノ丸ゴ Pro W4","ヒラギノ丸ゴ Pro","Hiragino Maru Gothic Pro","ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","HG丸ｺﾞｼｯｸM-PRO","HGMaruGothicMPRO"';
     break;
   case 5:
     $font = '"游ゴシック体","Yu Gothic",YuGothic,"ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","メイリオ",Meiryo,Arial,Sans-Serif';
     break;
   case 6:
     $font = '"游明朝",YuMincho,"Hiragino Mincho ProN","Hiragino Mincho Pro","ＭＳ 明朝",serif';
     break;
   default:
     $font = '"Open Sans",Helvetica,Arial,sans-serif';
     break;
 }

 if( is_home() || is_single() || is_archive() || is_search() || (get_field('entire_enable', $post->ID) === 'on' || $theme_options['all_enable'] === 'on') ) { // 全体設定
  // フォントサイズ
  if( $theme_options['fontsize'] ) {
   $fontsize = $theme_options['fontsize'];
  } else {
   $fontsize = 16;
  }
  // 行間
  if( $theme_options['lineheight'] ) {
   $lineheight = $theme_options['lineheight'];
  } else {
   $lineheight = 2.3;
  }
 } else { // 個別設定
  // フォントサイズ
  if( get_field('fontsize', $post->ID) ) {
   $fontsize = get_field('fontsize', $post->ID);
  } else {
   $fontsize = 16;
  }
  // 行間
  if( get_field('lineheight', $post->ID) ) {
   $lineheight = get_field('lineheight', $post->ID);
  } else {
   $lineheight = 2.3;
  }
 }

 // 全体設定分岐
 $entire_enable = false;
 if( is_home() || is_singular('post') || is_archive() || is_search() ) {
   $entire_enable = true;
 } elseif( is_page() ) {
  if( get_field('entire_enable', $post->ID) === 'on' || $theme_options['all_enable'] === 'on' ) {
   $entire_enable = true;
  }
 } elseif( is_singular('hfcontent') ) {
  if( get_field('hf_entire_enable', $post->ID) !== 'on' ) {
   $entire_enable = true;
  }
 }

 // 背景色反映
 if( $entire_enable ) { // 全体設定
  if( $theme_options['bg_color'] ) {
   $background_color = $theme_options['bg_color'];
  } else {
   $background_color = '#FFF';
  }
  if( $theme_options['bg_image'] ) {
   $background_image = $theme_options['bg_image'];
  } else {
   $background_image = '';
  }
  if( $theme_options['bg_repeat'] ) {
   $background_repeat = $theme_options['bg_repeat'];
  } else {
   $background_repeat = 'repeat';
  }
  if( $theme_options['bg_attachment'] ) {
   $background_attachment = $theme_options['bg_attachment'];
  } else {
   $background_attachment = 'scroll';
  }
  if( $theme_options['bg_position'] ) {
   $background_position = $theme_options['bg_position'];
  } else {
   $background_position = 'left';
  }
 } else { // 個別設定
  if( get_field('background_color', $post->ID) ) {
   $background_color = get_field('background_color', $post->ID);
  } else {
   $background_color = '#FFF';
  }
  if( get_field('background_image', $post->ID) ) {
   $background_image = get_field('background_image', $post->ID);
  } else {
   $background_image = '';
  }
  if( get_field('background_repeat', $post->ID) ) {
   $background_repeat = get_field('background_repeat', $post->ID);
  } else {
   $background_repeat = 'repeat';
  }
  if( get_field('background_attachment', $post->ID) ) {
   $background_attachment = get_field('background_attachment', $post->ID);
  } else {
   $background_attachment = 'scroll';
  }
  if( get_field('background_position', $post->ID) ) {
   $background_position = get_field('background_position', $post->ID);
  } else {
   $background_position = 'left';
  }
 }

 // 記事背景色反映
 if( $entire_enable ) { // 全体設定
  if( $theme_options['content_bg_color'] ) {
   $content_bgcolor = $theme_options['content_bg_color'];
  } else {
   $content_bgcolor = '#FFF';
  }
  if( $theme_options['content_bg_image'] ) {
   $content_bgimage = $theme_options['content_bg_image'];
  } else {
   $content_bgimage = '';
  }
  if( $theme_options['content_bg_repeat'] ) {
   $content_bgrepeat = $theme_options['content_bg_repeat'];
  } else {
   $content_bgrepeat = 'repeat';
  }
  if( $theme_options['content_bg_attachment'] ) {
   $content_bgattachment = $theme_options['content_bg_attachment'];
  } else {
   $content_bgattachment = 'scroll';
  }
  if( $theme_options['content_bg_position'] ) {
   $content_bgposition = $theme_options['content_bg_position'];
  } else {
   $content_bgposition = 'left';
  }
 } else { // 個別設定
  if( get_field('content_bgcolor', $post->ID) ) {
   $content_bgcolor = get_field('content_bgcolor', $post->ID);
  } else {
   $content_bgcolor = '#FFF';
  }
  if( get_field('content_bgimage', $post->ID) ) {
   $content_bgimage = get_field('content_bgimage', $post->ID);
  } else {
   $content_bgimage = '';
  }
  if( get_field('content_bgrepeat', $post->ID) ) {
   $content_bgrepeat = get_field('content_bgrepeat', $post->ID);
  } else {
   $content_bgrepeat = 'repeat';
  }
  if( get_field('content_bgattachment', $post->ID) ) {
   $content_bgattachment = get_field('content_bgattachment', $post->ID);
  } else {
   $content_bgattachment = 'scroll';
  }
  if( get_field('content_bgposition', $post->ID) ) {
   $content_bgposition = get_field('content_bgposition', $post->ID);
  } else {
   $content_bgposition = 'left';
  }
 }

 // サイドバー背景色反映
 if( $entire_enable || get_field('post_layout', $post->ID) != 1 ) { // 全体設定
  if( $theme_options['sidebar_font_color'] ) {
   $sidebar_font_color = $theme_options['sidebar_font_color'];
  } else {
   $sidebar_font_color = '#000';
  }
  if( $theme_options['sidebar_bg_color'] ) {
   $sidebar_bgcolor = $theme_options['sidebar_bg_color'];
  } else {
   $sidebar_bgcolor = '#FFF';
  }
  if( $theme_options['sidebar_bg_image'] ) {
   $sidebar_bgimage = $theme_options['sidebar_bg_image'];
  } else {
   $sidebar_bgimage = '';
  }
  if( $theme_options['sidebar_bg_repeat'] ) {
   $sidebar_bgrepeat = $theme_options['sidebar_bg_repeat'];
  } else {
   $sidebar_bgrepeat = 'repeat';
  }
  if( $theme_options['sidebar_bg_attachment'] ) {
   $sidebar_bgattachment = $theme_options['sidebar_bg_attachment'];
  } else {
   $sidebar_bgattachment = 'scroll';
  }
  if( $theme_options['sidebar_bg_position'] ) {
   $sidebar_bgposition = $theme_options['sidebar_bg_position'];
  } else {
   $sidebar_bgposition = 'left';
  }
 }
?>
<style type="text/css">
	body {
		background-color:<?php echo $background_color; ?>;
		<?php if( $background_image ) : ?>
		background-image:url('<?php echo $background_image; ?>');
		background-repeat:<?php echo $background_repeat; ?>;
		background-attachment:<?php echo $background_attachment; ?>;
		background-position:<?php echo $background_position; ?>;
		<?php endif; ?>
	}
	.site {
		font-size:<?php echo $fontsize; ?>px;
		font-family:<?php echo $font; ?>;
		width:auto;
		max-width:<?php echo $pwidth; ?>px;
		background-color:<?php echo $content_bgcolor; ?>;
		<?php if( $content_bgimage ) : ?>
		background-image:url('<?php echo $content_bgimage; ?>');
		background-repeat:<?php echo $content_bgrepeat; ?>;
		background-attachment:<?php echo $content_bgattachment; ?>;
		background-position:<?php echo $content_bgposition; ?>;
		<?php endif; ?>
	}
	.site p {
		line-height:<?php echo $lineheight; ?>;
	}
	.entry-content,
	.content-width {
		width:auto;
		max-width:<?php echo $pwidth - 100; ?>px;
	}
	.bg-youtube-content {
		box-sizing: border-box;
		margin: 0 auto;
		max-width:<?php echo $pwidth - 100; ?>px;
	}

	#secondary {
		background-color:<?php echo $sidebar_bgcolor; ?>;
		<?php if( $sidebar_bgimage ) : ?>
		background-image:url('<?php echo $sidebar_bgimage; ?>');
		background-repeat:<?php echo $sidebar_bgrepeat; ?>;
		background-attachment:<?php echo $sidebar_bgattachment; ?>;
		background-position:<?php echo $sidebar_bgposition; ?>;
		<?php endif; ?>
	}

	#secondary,
	#secondary h3,
	#secondary .widget a,
	#secondary .widget a:hover {
		color:<?php echo $sidebar_font_color; ?>;
	}

	img.wide,
	table.wide,
	table.head-w,
	table.head-b,
	table.obi,
	table.obi-b,
	table.tape,
	table.gra-blue,
	table.gra-red,
	table.gra-green,
	table.gra-purple,
	table.gra-gray,
	table.gra-yellow,
	table.fab-blue,
	table.fab-red,
	table.fab-green,
	table.fab-purple,
	table.fab-gray {
		width:<?php echo $pwidth; ?>px;
	}

	table img.wide,
	table table.wide,
	table table.head-w,
	table table.head-b,
	table table.obi,
	table table.obi-b,
	table table.tape,
	table table.gra-blue,
	table table.gra-red,
	table table.gra-green,
	table table.gra-purple,
	table table.gra-gray,
	table table.gra-yellow,
	table table.fab-blue,
	table table.fab-red,
	table table.fab-green,
	table table.fab-purple,
	table table.fab-gray {
		width:<?php echo $pwidth - 100; ?>px;
		margin: 0 -20px;
	}

	table.submit img.wide,
	table.submit table.wide,
	table.submit table.head-w,
	table.submit table.head-b,
	table.submit table.obi,
	table.submit table.obi-b,
	table.submit table.tape,
	table.submit table.gra-blue,
	table.submit table.gra-red,
	table.submit table.gra-green,
	table.submit table.gra-purple,
	table.submit table.gra-gray,
	table.submit table.gra-yellow,
	table.submit table.fab-blue,
	table.submit table.fab-red,
	table.submit table.fab-green,
	table.submit table.fab-purple,
	table.submit table.fab-gray {
		margin: 0 ;
	}

	@media only screen and (max-width: <?php echo $pwidth - 1; ?>px){
		img.wide,
		table.wide,
		table.head-w,
		table.head-b,
		table.obi,
		table.obi-b,
		table.tape,
		table.gra-blue,
		table.gra-red,
		table.gra-green,
		table.gra-purple,
		table.gra-gray,
		table.gra-yellow,
		table.fab-blue,
		table.fab-red,
		table.fab-green,
		table.fab-purple,
		table.fab-gray {
			margin: 0 -30px;
			width: 100vw;
		}

		table table.wide,
		table table.head-w,
		table table.head-b,
		table table.obi,
		table table.obi-b,
		table table.tape,
		table table.gra-blue,
		table table.gra-red,
		table table.gra-green,
		table table.gra-purple,
		table table.gra-gray,
		table table.gra-yellow,
		table table.fab-blue,
		table table.fab-red,
		table table.fab-green,
		table table.fab-purple,
		table table.fab-gray {
			margin: 0 -20px !important;
			width: calc(100% + 40px) !important;
			width: -webkit-calc(100% + 40px) !important;
		}

		table img.wide {
			margin: 0 -25px !important;
			width: calc(100% + 50px) !important;
			width: -webkit-calc(100% + 50px) !important;
			max-width: calc(100% + 50px) !important;
			max-width: -webkit-calc(100% + 50px) !important;
			position: relative !important;
		}

		table.submit img.wide,
		table.submit table.wide,
		table.submit table.head-w,
		table.submit table.head-b,
		table.submit table.obi,
		table.submit table.obi-b,
		table.submit table.tape,
		table.submit table.gra-blue,
		table.submit table.gra-red,
		table.submit table.gra-green,
		table.submit table.gra-purple,
		table.submit table.gra-gray,
		table.submit table.gra-yellow,
		table.submit table.fab-blue,
		table.submit table.fab-red,
		table.submit table.fab-green,
		table.submit table.fab-purple,
		table.submit table.fab-gray {
			margin: 0 !important;
			width: 100% !important;
		}

		<?php if($countdown) : ?>
		.head-image {
			background-size: auto 100% !important;
		}
		<?php else : ?>
		.head-image {
			background-size: cover !important;
		}
		<?php endif; ?>
	}

	table.shikaku img,
	table.shikaku tbody img,
	table.shikaku tr img,
	table.shikaku td img,
	table.marukaku img,
	table.marukaku tbody img,
	table.marukaku tr img,
	table.marukaku td img,
	table.pressed img,
	table.pressed tbody img,
	table.pressed tr img,
	table.pressed td img,
	table.pressed-fiber img,
	table.pressed-fiber tbody img,
	table.pressed-fiber tr img,
	table.pressed-fiber td img,
	table.tableshadow img,
	table.tableshadow tbody img,
	table.tableshadow tr img,
	table.tableshadow td img {
		max-width: <?php echo $pwidth - 150; ?>px;
	}

	table.shikaku img.wide.wide,
	table.shikaku tbody img.wide,
	table.shikaku tr img.wide,
	table.shikaku td img.wide,
	table.marukaku img.wide,
	table.marukaku tbody img.wide,
	table.marukaku tr img.wide,
	table.marukaku td img.wide,
	table.pressed img.wide,
	table.pressed tbody img.wide,
	table.pressed tr img.wide,
	table.pressed td img.wide,
	table.pressed-fiber img.wide,
	table.pressed-fiber tbody img.wide,
	table.pressed-fiber tr img.wide,
	table.pressed-fiber td img.wide,
	table.tableshadow img.wide,
	table.tableshadow tbody img.wide,
	table.tableshadow tr img.wide,
	table.tableshadow td img.wide {
		max-width: <?php echo $pwidth - 100; ?>px;
		margin: 0 -20px;
	}

	table.wide img,
	table.wide tbody img,
	table.wide tr img,
	table.wide td img {
		max-width: <?php echo $pwidth - 110; ?>px;
	}

	img.wide {
		max-width: <?php echo $pwidth; ?>px;
	}
</style>

<?php if( $sp_enable !== 'on' && get_field('sp_fontsize', $post->ID) === 'on' && wp_is_mobile() ) : ?>
<style type="text/css">
body, .site {
 font-size: 32px !important;
}
</style>
<?php endif; ?>


<?php if( wp_is_mobile() ) : ?>
<style type="text/css">
	button:hover,
	.btn-custom:hover,
	.btn-custom-sma:hover,
	.btn-blue:hover,
	.btn-blue-sma:hover,
	.btn-red:hover,
	.btn-red-sma:hover,
	.btn-green:hover,
	.btn-green-sma:hover,
	.btn-purple:hover,
	.btn-purple-sma:hover,
	.btn-gray:hover,
	.btn-gray-sma:hover,
	.btn-custom-3d:hover,
	.btn-custom-3d-sma:hover,
	.btn-blue-3d:hover,
	.btn-blue-3d-sma:hover,
	.btn-red-3d:hover,
	.btn-red-3d-sma:hover,
	.btn-green-3d:hover,
	.btn-green-3d-sma:hover,
	.btn-purple-3d:hover,
	.btn-purple-3d-sma:hover,
	.btn-gray-3d:hover,
	.btn-gray-3d-sma:hover,
	a:hover img {
		opacity: 1 !important;
	}
</style>
<?php endif; ?>
<?php if( !wp_is_mobile() ) : ?>
<style type="text/css">
	.bg-youtube .sp-bgimage {
		display: none;
	}
</style>
<?php endif; ?>

<?php if( $entire_enable ) : /* 全体設定 */ ?>
<?php
	// 影の色
	$shadow_color = ($theme_options['shadow_color'])? $theme_options['shadow_color'] : '#000000';
	$shadow_color = str_replace('#', '', $shadow_color);
	$rgb = array(
		hexdec(substr($shadow_color, 0, 2)),
		hexdec(substr($shadow_color, 2, 2)),
		hexdec(substr($shadow_color, 4, 2))
	);
	$shadow_color = sprintf('rgba(%2d,%2d,%2d,0.25)', $rgb[0], $rgb[1], $rgb[2]);

	if( $theme_options['shadow_enable'] !== 'off' ) :
?>
<style type="text/css">
	.site {
		box-shadow: 0 0 10px <?php echo $shadow_color; ?>;
		-moz-box-shadow: 0 0 10px <?php echo $shadow_color; ?>;
		-webkit-box-shadow: 0 0 10px <?php echo $shadow_color; ?>;
	}
</style>
<?php endif; ?>
<?php else : /* 個別設定 */ ?>
<?php
	// 影の色
	$shadow_color = (get_field('shadow_color', $post->ID))? get_field('shadow_color', $post->ID) : '#000000';
	$shadow_color = str_replace('#', '', $shadow_color);
	$rgb = array(
		hexdec(substr($shadow_color, 0, 2)),
		hexdec(substr($shadow_color, 2, 2)),
		hexdec(substr($shadow_color, 4, 2))
	);
	$shadow_color = sprintf('rgba(%2d,%2d,%2d,0.25)', $rgb[0], $rgb[1], $rgb[2]);

	if( get_field('shadow_enable', $post->ID) !== 'off' ) :
?>
<style type="text/css">
	.site {
		box-shadow: 0 0 10px <?php echo $shadow_color; ?>;
		-moz-box-shadow: 0 0 10px <?php echo $shadow_color; ?>;
		-webkit-box-shadow: 0 0 10px <?php echo $shadow_color; ?>;
	}
</style>
<?php endif; ?>
<?php endif; ?>

<?php if($countdown) : ?>
<?php if( get_field('countdown_design', $post->ID) === 'design1' ) : ?>
<style type="text/css">
	.navbar .navbar-inner {
		background-color:<?php the_field('countdown_bgcolor', $post->ID); ?>;
	}
	.navbar .brand {
		color:<?php the_field('countdown_fontcolor', $post->ID); ?>;
	}
</style>
<?php endif; ?>
<?php if( get_field('countdown_design', $post->ID) === 'design2' ) : ?>
<style type="text/css">
	.navbar {
		margin-bottom: 80px;
	}
	.navbar .navbar-inner {
		height: 80px;
	}
</style>
<?php endif; ?>

<?php if( get_field('countdown_indesign', $post->ID) === 'design1' ) : ?>
<style type="text/css">
	.navbar-nofix {
		margin-bottom: 0;
	}
	.navbar-nofix .navbar-inner {
		background-color:<?php the_field('countdown_inbgcolor', $post->ID); ?>;
		height: 60px;
	}
	.navbar-nofix .brand {
		color:<?php the_field('countdown_infontcolor', $post->ID); ?>;
	}
</style>
<?php endif; ?>
<?php if( get_field('countdown_indesign', $post->ID) === 'design2' ) : ?>
<style type="text/css">
	.navbar-nofix {
		margin-bottom: 0;
	}
	.navbar-nofix .navbar-inner {
		background-color: #fff;
		padding: 10px 0;
	}
</style>
<?php endif; ?>
<?php if( get_field('countdown_design', $post->ID) === 'design2' || get_field('countdown_indesign', $post->ID) === 'design2' ) : ?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/countdown/assets/countdown/jquery.countdown.css" />
<?php endif; ?>
<?php endif; /* $countdown */ ?>

<!-- フォーム入力設定
    ================================================== -->
<script type="text/javascript">
$(function(){
	$('.formbox').each(function(){
		$(this).val( $(this).attr('title') ).css('color', '#969696');
	});

	$('.formbox').focus(function(){
		$(this).val('').css('color', '#000');
	});

	$('.formbox').blur(function(){
		$(this).val( $(this).attr('title') ).css('color', '#969696');
	});

	$('.focus').focus(function(){
		if(this.value == "メールアドレスを入力"){
			$(this).val("").css("color","#000000");
		} else if(this.value == "名前を入力") {
			$(this).val("").css("color","#000000");}
	});

	$('.focus').blur(function(){
		if(this.value == ""){
			if(this.name == "d[0]"){
				$(this).val("メールアドレスを入力").css("color","#969696");
			} else {
				$(this).val("名前を入力").css("color","#969696");
				}
			}
	});

	$(window).bind('load resize', function(){
		if( $(window).width() > <?php echo $pwidth; ?> ) {
			$('.full-width').each(function(){
				$(this).height( $(this).height() );
				if( !$(this).find('.absolute')[0] ) {
					$(this).html( '<div class="absolute"><div class="content-width">' + $(this).html() + '</div></div>' );
					$(this).find('.absolute').css( 'backgroundColor', $(this).find('.content-width').children().eq(0).css('backgroundColor') );
					$(this).find('.absolute').css( 'backgroundImage', $(this).find('.content-width').children().eq(0).css('backgroundImage') );
					$(this).find('.absolute').css( 'backgroundPosition', $(this).find('.content-width').children().eq(0).css('backgroundPosition') );
					$(this).find('.absolute').css( 'backgroundRepeat', $(this).find('.content-width').children().eq(0).css('backgroundRepeat') );
					if( $(this).find('.content-width').children().eq(0).hasClass('tilt') ) {
						$(this).find('.absolute').addClass('tilt');
					}
				}
				$(this).find('.absolute').width( $(window).width() );
				$(this).find('.content-width').children().eq(0).css('backgroundColor','');
				$(this).find('.content-width').children().eq(0).css('backgroundImage','');
				$(this).find('.content-width').children().eq(0).css('backgroundPosition','');
				$(this).find('.content-width').children().eq(0).css('backgroundRepeat','');
				$(this).find('.content-width').children().eq(0).removeClass('tilt');
			});

			$('.full-width-image').each(function(){
				if( !$(this).find('.absolute')[0] ) {
					$(this).html( '<div class="absolute">' + $(this).html() + '</div>' );
				}
				$(this).find('.absolute').width( $(window).width() );
				if(  $(this).find('img').height() > 0 ) {
					$(this).height( $(this).find('img').height() );
				} else {
					$(this).height( $(this).find('img').attr('height') );
				}
			});

			$('.full-width-video').each(function(){
				$(this).height( $(this).find('video').height() );
				if( !$(this).find('.absolute')[0] ) {
					$(this).html( '<div class="absolute">' + $(this).html() + '</div>' );
				}
				$(this).find('.absolute').width( $(window).width() );
			});

			$('.full-width-youtube').each(function(){
				$(this).height( $(this).find('.bg-youtube-content').height() );
				if( !$(this).find('.absolute')[0] ) {
					$(this).html( '<div class="absolute"><div class="absolute-inner">' + $(this).html() + '</div></div>' );
				}
				$(this).find('.absolute').width( $(window).width() );
				$(this).find('.absolute-inner').width( $(window).width() );
				$(this).find('iframe').height( $(this).find('.absolute').width() * 36/64 );

				if( $(this).find('.bg-youtube-content').height() > $(this).find('iframe').height() ) {
					$(this).find('iframe').height( $(this).find('.bg-youtube-content').height() );
					$(this).find('.absolute-inner').width( $(this).find('iframe').height() * 64/36  );
				}

				$(this).find('.absolute').height( $(this).find('.bg-youtube-content').height() );
				var absoluteLeft = $(this).find('.absolute').width() - $(this).find('.absolute-inner').width();
				var absoluteTop = $(this).find('.absolute').height() - $(this).find('iframe').height();
				$(this).find('.absolute-inner').css('left', absoluteLeft / 2);
				$(this).find('iframe').css('top', absoluteTop / 2);
			});
		}

		$('.bg-video').each(function(){
			$(this).height( $(this).find('video').height() );
		});
	});

	$(window).bind('load', function(){
		$('.youtube').each(function(){
			var timerID;
			var played = 0;
			var box = $(this);
			var iframe = box.find('iframe').eq(0);
			var playerID = box.find('iframe').eq(0).attr('id');
			var player = new YT.Player(playerID, {
				events: {
					'onStateChange': function(event) {
						if( event.data == YT.PlayerState.ENDED ) {
							box.next('.youtube-text').show();
						}

						if( event.data == YT.PlayerState.PLAYING ) {
							timerID = setInterval(function(){
								played++;
								if( iframe.data('show') && played >= iframe.data('show') ) {
									box.next('.youtube-text').show();
								}
							},1000);
						} else {
							clearInterval(timerID);
						}
					}
				}
			});
		});

		$('.bg-youtube').each(function(){
			var box = $(this);
			var iframe = box.find('iframe').eq(0);
			var playerID = box.find('iframe').eq(0).attr('id');
			var player = new YT.Player(playerID, {
				events: {
					'onReady': function(event) {
						//event.target.playVideo();
						var videourl = event.target.getVideoUrl();
						var videoid = videourl.substr( videourl.indexOf('v=') + 2 );
						event.target.loadPlaylist(videoid);
						event.target.setLoop(true);
						event.target.mute();
					}
				}
			});
<?php if( wp_is_mobile() ) : ?>
			box.css( 'height', box.find('bg-youtube-content').css('height') );
			iframe.hide();
			box.find('bg-youtube-content').css('height','')
<?php endif; ?>
		});
	});

	$('#header iframe').bind('load', function(){
		var content = this.contentWindow.document.documentElement;
		var frameHeight = 100;
		if(document.all) {
			frameHeight  = content.scrollHeight;
		} else {
			frameHeight  = content.offsetHeight;
		}
		this.style.height = frameHeight+'px';
	});

	$('#footer iframe').bind('load', function(){
		var content = this.contentWindow.document.documentElement;
		var frameHeight = 100;
		if(document.all) {
			frameHeight  = content.scrollHeight;
		} else {
			frameHeight  = content.offsetHeight;
		}
		this.style.height = frameHeight+'px';
	});

<?php if( wp_is_mobile() ) : ?>
	$('.tel').each(function(){
		var alt = '';
		if( this.tagName == 'IMG' ) {
			alt = $(this).attr('alt');
		} else {
			alt = $(this).text();
		}
		$(this).wrap('<a href="tel:' + alt + '"></a>');
	});
<?php endif; ?>
});
</script>

<script type="text/javascript">
$(function(){
	$('img.wide').each(function(){
		$(this).parent().height( $(this).height() ).css('display', 'block');
		$(this).bind('load', function(){
			$(this).parent().height( $(this).height() );
		});
	});
	var h = $('.head-image').height();
	$(window).bind('load resize', function(){
		if( $('.head-image').width() < (<?php echo $pwidth; ?> + 100) ) {
			$('.head-image').height( h * $('.head-image').width() / (<?php echo $pwidth; ?> + 100) );
		}
	});
});
</script>

<?php if( get_field('sp_url', $post->ID) != '' ) : ?>
<script type="text/javascript">
if ( ((navigator.userAgent.indexOf('iPhone') > 0 &&
	navigator.userAgent.indexOf('iPad') == -1) ||
	navigator.userAgent.indexOf('iPod') > 0 ||
	navigator.userAgent.indexOf('Android') > 0) ) {
	location.href = '<?php the_field('sp_url', $post->ID); ?>';
}
</script>
<?php endif; ?>

<?php if( get_field('gacode', $post->ID) ) { the_field('gacode', $post->ID); } ?>

<?php if($custom_css['css']) : ?>
<style type="text/css">
<?php echo $custom_css['css']; ?>
</style>
<?php endif; ?>

<?php if($custom_css['head']) { echo $custom_css['head']; } ?>
</head>

<!-- ＝＝＝＝＝＝＝　headここまで　＝＝＝＝＝＝＝ -->




<!-- ＝＝＝＝＝＝＝　ここからbody　＝＝＝＝＝＝＝ -->

<body <?php body_class(); ?>>
<?php if($custom_css['body']) { echo $custom_css['body']; } ?>

<?php
if( is_home() || is_singular('post') || is_archive() || is_search() || (get_field('entire_enable', $post->ID) === 'on' || $theme_options['all_enable'] === 'on') ) { // 全体設定
	$menu_enable = $theme_options['menu_enable'];
	$menu_name = $theme_options['menu_name'];
	$menu_design = $theme_options['menu_design'];
	$menu_position = $theme_options['menu_position'];
} else { // 個別設定
	$menu_enable = get_field('menu_enable', $post->ID);
	$menu_name = get_field('menu_name', $post->ID);
	$menu_design = get_field('menu_design', $post->ID);
	$menu_position = get_field('menu_position', $post->ID);
}
?>
<?php if( $menu_enable === 'on' && !is_singular( array('hfcontent', 'hover') ) ) : ?>
<?php
$menu_object = wp_get_nav_menu_object($menu_name);
$menu_items = wp_get_nav_menu_items($menu_object->term_id);
switch($menu_design) {
	case 'design1':
		$menu_class = 'fixed_menu1';
		$menu_btn = 'menu_btn1';
		break;

	case 'design2':
		$menu_class = 'fixed_menu2';
		$menu_btn = 'menu_btn2';
		break;

	case 'design3':
		$menu_class = 'fixed_menu3';
		$menu_btn = 'menu_btn3';
		break;

	case 'design4':
		$menu_class = 'fixed_menu4';
		$menu_btn = 'menu_btn3';
		break;

	case 'design5':
		$menu_class = 'fixed_menu5';
		$menu_btn = 'menu_btn3';
		break;

	case 'design6':
		$menu_class = 'fixed_menu6';
		$menu_btn = 'menu_btn3';
		break;

	default:
		break;
}
?>
<?php if($countdown) : ?>
<style type="text/css">
.navbar .navbar-inner {
	margin-top: 50px;
}
</style>
<?php endif; ?>
<div class="menu_box"></div>
<?php if( (wp_is_mobile() && $sp_enable === 'on') || $menu_position != 'middle' ) : ?><nav id="fixed_menu" class="<?php echo $menu_class; ?>"><?php endif; ?>
<?php if( wp_is_mobile() && $sp_enable === 'on' ) : ?>
<script type="text/javascript">
$(function(){
	$('#fixed_menu > ul').hide();
	$('#menu_btn').click(function(){
		$('#fixed_menu ul').slideToggle();
	});
	$('#fixed_menu > ul a').click(function(){
		$('#fixed_menu ul').hide();
	});
});
</script>
<div id="menu_btn" class="<?php echo $menu_btn; ?>"><i class="icon-th-list"></i>Menu</div>
<?php else : ?>
<script type="text/javascript">
$(function(){
	$('#fixed_menu > ul > li').hover(
		function(){ $('.sub-menu', this).slideDown(); },
		function(){ $('.sub-menu', this).slideUp(); }
	);
});
</script>
<?php endif; ?>
<?php
	$args = array(
		'menu' => $menu_object->term_id,
		'container' => false,
		'depth' => 2,
	);
	if( (wp_is_mobile() && $sp_enable === 'on') || $menu_position != 'middle' ) wp_nav_menu($args);
?> 
<?php if( (wp_is_mobile() && $sp_enable === 'on') || $menu_position != 'middle' ) : ?></nav><?php endif; ?>
<?php endif; ?>

<?php if($countdown) : ?>
<!-- カウントダウン部分　ここに追加
    ================================================== -->

<?php if( get_field('countdown_top', $post->ID) === 'off' ) : ?>
<style type="text/css">
.navbar-fixed-top {
	height: 30px;
	position: fixed;
	width: 100%;
	z-index: 10;
}
.navbar-fixed-top .navbar-inner {
	display: none;
}
</style>
<?php endif; ?>
<div class="navbar navbar-inverse navbar-fixed-top" onMouseOver="dispWin();">
      <div class="navbar-inner" >
      
      <div class="brand">
	<!-- カウントダウンはここに追加 -->
    <p><?php echo get_field('countdown_name', $post->ID); ?>　<span id="CDT"></span></p>
	<!-- カウントダウンはここまで -->

      </div>

      </div>

</div>

<!-- カウントダウンここまで
    ================================================== -->
<?php else : ?>
<div style="width:100%;height:30px;position:fixed;z-index:10;" onMouseOver="dispWin();"></div>
<?php endif; ?>

<?php if( is_home() || is_singular('post') || is_archive() || is_search() ) : ?>
	<?php if( $theme_options['header_content'] > 0 ) : ?>
	<header id="header">
	<?php
	  $post = get_post($theme_options['header_content']);
	  setup_postdata($post);
	?>
	<iframe src="<?php the_permalink(); ?>" width="100%" scrolling="no" frameBorder="0"></iframe>
	<?php wp_reset_postdata(); ?>
	</header><!-- #header -->
	<?php endif; ?>

	<?php if( $theme_options['header_content'] == -1 ) : ?>
	<header id="header" class="widget-template clear">
		<?php if ( is_active_sidebar( 'header-1' ) ) : ?><div class="widget-area"><?php dynamic_sidebar( 'header-1' ); ?></div><?php endif ?>
		<?php if ( is_active_sidebar( 'header-2' ) ) : ?><div class="widget-area"><?php dynamic_sidebar( 'header-2' ); ?></div><?php endif ?>
	</header><!-- #header -->
	<?php endif; ?>
<?php elseif( is_page() ) : ?>
	<?php if( (get_field('entire_hf_enable', $post->ID) === 'on' || $theme_options['all_enable'] === 'on') && $theme_options['header_content'] > 0 ) : ?>
	<header id="header">
	<?php
	  $post = get_post($theme_options['header_content']);
	  setup_postdata($post);
	?>
	<iframe src="<?php the_permalink(); ?>" width="100%" scrolling="no" frameBorder="0"></iframe>
	<?php wp_reset_postdata(); ?>
	</header><!-- #header -->
	<?php endif; ?>

	<?php if( (get_field('entire_hf_enable', $post->ID) === 'on' || $theme_options['all_enable'] === 'on') && $theme_options['header_content'] == -1 ) : ?>
	<header id="header" class="widget-template clear">
		<?php if ( is_active_sidebar( 'header-1' ) ) : ?><div class="widget-area"><?php dynamic_sidebar( 'header-1' ); ?></div><?php endif ?>
		<?php if ( is_active_sidebar( 'header-2' ) ) : ?><div class="widget-area"><?php dynamic_sidebar( 'header-2' ); ?></div><?php endif ?>
	</header><!-- #header -->
	<?php endif; ?>
<?php endif; ?>

<?php if( (!wp_is_mobile() || $sp_enable !== 'on') && $menu_position == 'middle' && !is_singular( array('hfcontent', 'hover') ) ) : ?>
<style type="text/css">
nav.fixed_menu1.relative,
nav.fixed_menu2.relative,
nav.fixed_menu3.relative,
nav.fixed_menu4.relative,
nav.fixed_menu5.relative,
nav.fixed_menu6.relative {
	position: relative;
}
.menu_box {
	display: none;
}
</style>
<script type="text/javascript">
$(function(){
	var menuFlag = false;
	var menuTop = $('#fixed_menu').offset().top;
	$(document).scroll(function() {
		if(!menuFlag) menuTop = $('#fixed_menu').offset().top;
		menuFlag = true;
		if( $(document).scrollTop() >= menuTop ) {
			$('#fixed_menu').removeClass('relative');
		} else {
			$('#fixed_menu').addClass('relative');
		}
	});
});
</script>
<nav id="fixed_menu" class="<?php echo $menu_class; ?> relative">
<?php wp_nav_menu($args); ?>
</nav>
<?php endif; ?>

<?php $header_image = get_header_image(); ?>
<?php if( get_field('topheader_image', $post->ID) ) : ?>
<?php $image = wp_get_attachment_image_src( get_field('topheader_image', $post->ID), 'full' ); ?>
<div class="head-image" style="width:100%;height:<?php echo $image[2]; ?>px;background:url(<?php echo $image[0]; ?>) no-repeat center top;"></div>
<?php elseif( !empty($header_image) ): ?>
<div class="head-image" style="width:100%;height:<?php echo get_custom_header()->height; ?>px;background:url(<?php echo $header_image; ?>) no-repeat center top;"></div>
<?php endif; ?>

<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
	</header><!-- #masthead -->

	<div id="main" class="wrapper">