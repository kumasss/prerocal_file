<?php
$options = get_desing_plus_option();
$footer_blog_post_order = $options['footer_blog_post_order'];
$logo_font_size_footer = $options['logo_font_size_footer'] ? $options['logo_font_size_footer'] : 26;

// 無限スクロールするコンテンツのクラス
$target = is_post_type_archive( 'news' ) ? '.p-news-list__item' : '.p-blog-list__item';
$max_num_pages = $wp_query->max_num_pages;
$message = __( 'No more post', 'tcd-w' );
$img_path = get_template_directory_uri() . '/img/ajax-loader.gif';

// ブログコンテンツ
$args = array(
	'post_status' => 'publish',
	'post_type' => 'post',
	'posts_per_page' => $options['footer_blog_num']
);
if ( 'rand' == $footer_blog_post_order ) {
	$args['orderby'] = 'rand';
} else {
	$args['orderby'] = 'date';
	if ( 'date1' == $footer_blog_post_order ) {
		$args['order'] = 'DESC';
	} else {
		$args['order'] = 'ASC';
	}
}
$the_query = new WP_Query( $args );
?>
	<div id="js-pagetop" class="p-pagetop"><a href="#"></a></div>
</main>
<footer class="l-footer">
	<div class="l-footer__inner l-inner">
<?php
if ( ( is_front_page() && $options['show_footer_blog_top'] ) || ( ! is_front_page() && $options['show_footer_blog'] ) ) : 
	if ( $the_query->have_posts() ) :
?>
		<div class="p-footer-blog">
			<h2 class="p-footer-blog__catch"><?php echo esc_html( $options['footer_blog_catchphrase'] ); ?></h2>
			<?php if ( $options['show_footer_blog_link'] ) : ?><a class="p-footer-blog__archive-link" href="<?php echo esc_url( get_post_type_archive_link( 'post' ) ); ?>"><?php echo esc_html( $options['footer_blog_link_text'] ); ?></a><?php endif; ?>
			<div id="js-footer-blog__list" class="p-footer-blog__list">
				<div class="p-footer-blog__item-wrapper clearfix">
<?php
		while ( $the_query->have_posts() ) :
			$the_query->the_post();
?>
					<article class="p-footer-blog__item p-article01">
						<a class="p-article01__thumbnail p-hover-effect--<?php echo esc_attr( $options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'size1' );
			} else {
				echo '<img src="' . get_template_directory_uri() . '/img/no-image-360x180.gif" alt="">' . "\n";
			}
?>
						</a>
						<h3 class="p-footer-blog__item-title p-article01__title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 30, '...' ); ?></a></h3>
<?php
			if ( $options['show_footer_blog_date'] || $options['show_footer_blog_category'] ) :
?>
						<p class="p-article01__meta"><?php if ( $options['show_footer_blog_date'] ) : ?><time class="p-article01__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time><?php endif; ?><?php if ( $options['show_footer_blog_category'] ) : ?><span class="p-article01__category"><?php the_category( ', ' ); ?></span><?php endif; ?></p>
<?php
			endif;
?>
					</article>
<?php
			// 4つ目の記事の時、div を出力する
			// ただし、最後の記事の場合は出力しない
			if ( ( 0 == ( $the_query->current_post + 1 ) % 4 ) && ( $options['footer_blog_num'] != ( $the_query->current_post + 1 ) ) ) :
?>
			
				</div>
				<div class="p-footer-blog__item-wrapper clearfix">
<?php 
			endif;
		endwhile;
		wp_reset_postdata();
?>
				</div>
			</div>
		</div>
<?php
	endif; 
endif; 
?>
		<div class="l-footer__logo p-logo" style="font-size: <?php echo esc_attr( $logo_font_size_footer ); ?>px;">
<?php
if ( $options['footer_logo_image'] ) {
	echo '<a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . wp_get_attachment_image_url( $options['footer_logo_image'], 'full' ) . '" alt="' . get_bloginfo( 'name' ) . '"></a>' . "\n";
} else {
	echo '<a href="' . esc_url( home_url( '/' ) ) . '">' . get_bloginfo( 'name' ) . '</a>' . "\n";
}
?>
		</div>
		<p class="p-address"><?php echo nl2br( esc_html( $options['footer_company_address'] ) ); ?></p>
		<ul class="p-social-nav u-clearfix">
			<?php if ( $options['facebook_url'] ) : ?><li class="p-social-nav__item p-social-nav__item--facebook"><a href="<?php echo esc_url( $options['facebook_url'] ); ?>" target="_blank"></a></li><?php endif; ?><?php if ( $options['twitter_url'] ) : ?><li class="p-social-nav__item p-social-nav__item--twitter"><a href="<?php echo esc_url( $options['twitter_url'] ); ?>" target="_blank"></a></li><?php endif; ?><?php if ( $options['insta_url'] ) : ?><li class="p-social-nav__item p-social-nav__item--instagram"><a href="<?php echo esc_url( $options['insta_url'] ); ?>" target="_blank"></a></li><?php endif; ?><?php if ( $options['show_rss'] ) : ?><li class="p-social-nav__item p-social-nav__item--rss"><a href="<?php bloginfo( 'rss2_url' ); ?>" target="_blank"></a></li><?php endif; ?>
		</ul>
<?php
if ( has_nav_menu( 'footer' ) ) {
	wp_nav_menu( array(
		'menu_class'     => 'p-footer-nav',
		'theme_location' => 'footer'
	) );
}
?>
	</div>
	<div class="p-copyright" style="background: <?php echo esc_attr( $options['copyright_bg'] ); ?>;">
		<div class="l-inner">
			<p class="u-clearfix"><span class="u-hidden-sm"><?php echo esc_html( $options['footer_company_address'] ); ?></span><small>Copyright &copy; <?php bloginfo( 'name' ); ?></small></p>
		</div>
	</div>
<?php if ( is_mobile() && ! is_no_responsive() && '5' === $options['footer_cta_display'] ) { get_template_part( 'template-parts/footer-bar' ); } ?>
<?php 
if ( '5' !== $options['footer_cta_display'] ) { 
	if ( ( is_front_page() && ! $options['footer_cta_hide_on_front'] ) || ! is_front_page() ) {
		get_template_part( 'template-parts/footer-cta' ); 
	}
} 
?>
</footer>
<?php if ( $options['use_load_icon'] ) : ?> 
</div>
<?php endif; ?>
<?php wp_footer(); ?>
<script>
jQuery(function($){

	// ブログコンテンツの設定
	if ($("#js-footer-blog__list").length) {
	  $("#js-footer-blog__list").slick({
	    arrows: false,
	    autoplay: true,
	    dots: true,
	    infinite: true,
	    slidesToShow: 1,
			speed: <?php echo esc_html( $options['footer_blog_slide_time'] ); ?>
	  }); 
	}

<?php 
if ( $options['use_load_icon'] ) : 
	// フロントページ
	// スライダー用の記述を読み込ませる
	if ( is_front_page() && 'type1' == $options['header_content_type'] ) :
?>
	$(window).load(function() {
  	$('#site_loader_animation').delay(600).fadeOut(400);
		$('#site_loader_overlay').delay(900).fadeOut(800, index_slider);
		$('#site-wrap').css('display', 'block');
	});
	$(function() {
		setTimeout(function(){
  		$('#site-loader-spinner').delay(600).fadeOut(400);
  		$('#site-wrap').css('display', 'block');
  	}, <?php if ( $options['load_time'] ) { echo esc_html( $options['load_time'] ); } else { echo '5000'; } ?>);
	});
<?php
	// スマホ、タブレット表示
	// またはブログ一覧、ニュース一覧を除くPC表示
	elseif ( 
		wp_is_mobile() 
		|| 
		( ! wp_is_mobile() && ! ( ( is_archive() && ! is_post_type_archive( 'review' ) ) || is_home() || is_search() ) ) 
	) : 
?>
	$(window).load(function() {
  	$('#site_loader_animation').delay(600).fadeOut(400);
		$('#site_loader_overlay').delay(900).fadeOut(800);
		$('#site-wrap').css('display', 'block');
	});
	$(function() {
		setTimeout(function(){
  		$('#site_loader_animation').delay(600).fadeOut(400);
			$('#site_loader_overlay').delay(900).fadeOut(800);
  		$('#site-wrap').css('display', 'block');
  	}, <?php if ( $options['load_time'] ) { echo esc_html( $options['load_time'] ); } else { echo '5000'; } ?>);
	});
<?php 
	// PCのアーカイブページ（レビュー除く）
	// infinitescroll用の記述を読み込ませる
	else :
?>
	$(window).load(function() {
  	$('#site_loader_animation').delay(600).fadeOut(400);
		$('#site_loader_overlay').delay(900).fadeOut(800, function() { init_post_list( '<?php echo $target; ?>', <?php echo esc_html( $max_num_pages ); ?>, '<?php echo $message; ?>', '<?php echo $img_path; ?>'); });
		$('#site-wrap').css('display', 'block');
	});
	$(function() {
		setTimeout(function(){
  		$('#site_loader_animation').delay(600).fadeOut(400);
  		$('#site_loader_overlay').delay(900).fadeOut(800);
  		//$('#site-loader-overlay').delay(900).fadeOut(800, function() { init_post_list('<?php echo $target; ?>', <?php echo esc_html( $max_num_pages ); ?>, '<?php echo $message; ?>', '<?php echo $img_path; ?>');
			//});
  		$('#site-wrap').css('display', 'block');
  	}, <?php if ( $options['load_time'] ) { echo esc_html( $options['load_time'] ); } else { echo '5000'; } ?>);
	});
<?php 
	endif;
else : // ロード画面を表示しない
	if ( ! wp_is_mobile() && ( ( is_archive() && ! is_post_type_archive( 'review' ) ) || is_home() || is_search()) ) : 
?>
	init_post_list('<?php echo $target; ?>', <?php echo esc_html( $max_num_pages ); ?>, '<?php echo $message; ?>', '<?php echo $img_path; ?>');
<?php 
	elseif ( is_front_page() && 'type1' == $options['header_content_type'] ) :
?>
	index_slider(0);
<?php
	endif; 
endif;
?>
});
<?php 
if ( is_front_page() ) :
	if ( 'type2' == $options['header_content_type'] && $options['video'] ) :
?>
jQuery(document).ready(function($){
	$('#js-header-video').vegas({
		timer: false,
	  slides: [
	  	{ 
				<?php if ( $options['video_image'] ) : ?>
				src: '<?php echo esc_html( wp_get_attachment_url( $options['video_image'] ) ); ?>',
				<?php endif; ?>
				video: {
	      	src: [ '<?php echo esc_html( $options['video'] ); ?>'], 
					loop: true, 
					mute: true
				},
			}
		]
	});
});
<?php 
	elseif ( $options['header_content_type'] == 'type3' && $options['youtube_url'] ) : 
?>
jQuery(document).ready(function($) {
	jQuery('#js-youtube-video-player').YTPlayer();
});
<?php 
	endif; ?>
lightbox.option({
	'albumLabel': '',
	'fitImagesInViewport': true,
	'showImageNumberLabel': false,
  'wrapAround': true,
	'fadeDuration': 500,
	'resizeDuration': 500,
})
<?php
endif;
?> 

jQuery(window).load(function () {
<?php
     // if is top page --------------------------------------------------------
     if(is_front_page()) {
       // Video --------------------------------------------------------
       if($options['header_content_type'] == 'type2') {
         if(!wp_is_mobile()) {
           echo "jQuery('#js-header-video .caption').addClass('first_active');\n";
         } else {
           echo "jQuery('#header_slider .item1').addClass('first_active');\n";
         };
       // Youtube --------------------------------------------------------
       } elseif($options['header_content_type'] == 'type3') {
         if(!wp_is_mobile()) {
           echo "jQuery('#js-header-youtube .caption').addClass('first_active');\n";
         } else {
           echo "jQuery('#header_slider .item1').addClass('first_active');\n";
         };
       }; // END header content
     }; // END top page
?>
});
</script>
<?php 
if ( is_single() ) :
	if ( 'type5' == $options['sns_type_top'] || 'type5' == $options['sns_type_btm'] ) :
		if ( $options['show_twitter_top'] || $options['show_twitter_btm'] ) :
?>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<?php
		endif;
		if ( $options['show_fblike_top'] || $options['show_fbshare_top'] || $options['show_fblike_btm'] || $options['show_fbshare_btm'] ) :
?>
<!-- facebook share button code -->
<div id="fb-root"></div>
<script>
(function(d, s, id) {
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) return;
   	js = d.createElement(s); js.id = id;
   	js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5";
   	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<?php
		endif;
		if ( $options['show_google_top'] || $options['show_google_btm'] ) :
?>
<script type="text/javascript">window.___gcfg = {lang: 'ja'};(function() {var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;po.src = 'https://apis.google.com/js/plusone.js';var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);})();
</script>
<?php
		endif;
		if ( $options['show_hatena_top'] || $options['show_hatena_btm'] ) :
?>
<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
<?php
		endif;
		if ( $options['show_pocket_top'] || $options['show_pocket_btm'] ) :
?>
<script type="text/javascript">!function(d,i){if(!d.getElementById(i)){var j=d.createElement("script");j.id=i;j.src="https://widgets.getpocket.com/v1/j/btn.js?v=1";var w=d.getElementById(i);d.body.appendChild(j);}}(document,"pocket-btn-js");</script>
<?php
		endif; 
		if ( $options['show_pinterest_top'] || $options['show_pinterest_btm'] ) :
?>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
<?php
		endif; 
	endif; 
endif;
?>
</body>
</html>
