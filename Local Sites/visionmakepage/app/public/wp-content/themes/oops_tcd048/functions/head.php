<?php
function tcd_head() {
	global $post;
	$options = get_desing_plus_option();
	$primary_color = $options['primary_color'];
	$secondary_color = $options['secondary_color'];
	$hex_color1 = esc_html( implode( ', ', hex2rgb( $primary_color ) ) ); // keyframe の記述が長くなるため、ここでエスケープ
  $hex_color2 = esc_html( implode( ', ', hex2rgb( $secondary_color ) ) ); // keyframe の記述が長くなるため、ここでエスケープ
	$content_font_size = $options['content_font_size'] ? $options['content_font_size'] : 14;
	$news_content_font_size = $options['news_content_font_size'] ? $options['news_content_font_size'] : 14;
?>
<?php if ( $options['favicon'] ) : ?>
<link rel="shortcut icon" href="<?php echo esc_html( wp_get_attachment_url( $options['favicon'] ) ); ?>">
<?php endif; ?>
<style>
/* Primary color */
.p-global-nav .sub-menu a, .p-news-ticker, .p-widget-dropdown, .p-widget-dropdown select, .p-headline, .p-latest-news__title, .l-footer, .p-menu-button.is-active { background: <?php echo esc_html( $options['primary_color'] ); ?>; }

/* Secondary color */
.p-global-nav .sub-menu li a:hover, .p-widget-search__submit:hover, .p-button, .p-review__button:hover, .p-pager__item a:hover, .c-comment__form-submit:hover { background: <?php echo esc_html( $secondary_color ); ?>; }
.l-header--large .p-global-nav > li > a:hover, .l-header--large.is-active .p-global-nav > li > a:hover, .p-global-nav > .current-menu-item > a, .p-global-nav > li > a:hover, .p-global-nav .current-menu-item > a .p-widget-list a:hover, .p-news-ticker__item-date { color: <?php echo esc_html( $secondary_color ); ?>; }

/* Tertiary color */
.p-button:hover, .slick-dots li.slick-active, .slick-dots li:hover { background: <?php echo esc_html( $options['tertiary_color'] ); ?>; }
.p-article01__title a:hover, .p-article01__category a:hover, .p-footer-blog__archive-link:hover, .p-footer-nav a:hover, .p-social-nav__item a:hover, .p-index-content07__archive-link:hover, .p-news-ticker__archive-link:hover { color: <?php echo esc_html( $options['tertiary_color'] ); ?>; }

/* font type */
<?php if ( 'type1' == $options['font_type'] ) : ?>
body { font-family: Verdana, "ヒラギノ角ゴ ProN W3", "Hiragino Kaku Gothic ProN", "メイリオ", Meiryo, sans-serif; }
<?php elseif ( 'type2' == $options['font_type'] ) : ?>
body { font-family: "Segoe UI", Verdana, "游ゴシック", YuGothic, "Hiragino Kaku Gothic ProN", Meiryo, sans-serif; }
<?php else : ?>
body { font-family: "Times New Roman", "游明朝", "Yu Mincho", "游明朝体", "YuMincho", "ヒラギノ明朝 Pro W3", "Hiragino Mincho Pro", "HiraMinProN-W3", "HGS明朝E", "ＭＳ Ｐ明朝", "MS PMincho", serif; }
<?php endif; ?>

/* headline font type */
.p-index-slider__item-catch, .p-index-content01__catch, .p-index-content02__item-catch, .p-showcase__catch, .p-index-content04__catch, .p-index-content06__item-catch, .p-index-content07__catch, .p-index-content09__catch, .p-footer-blog__catch, .p-article01__title, .p-page-header__title, .p-headline, .p-article02__title, .p-latest-news__title h2, .p-review__name, .p-review-header__title, #js-header-video .caption .title, #js-header-youtube .caption .title {
<?php if ( 'type1' == $options['headline_font_type'] ) : ?>
font-family: Segoe UI, "ヒラギノ角ゴ ProN W3", "Hiragino Kaku Gothic ProN", "メイリオ", Meiryo, sans-serif; 
<?php elseif ( 'type2' == $options['headline_font_type'] ) : ?>
font-family: "Segoe UI", Verdana, "游ゴシック", YuGothic, "Hiragino Kaku Gothic ProN", Meiryo, sans-serif;
<?php else : ?>
font-family: "Times New Roman", "游明朝", "Yu Mincho", "游明朝体", "YuMincho", "ヒラギノ明朝 Pro W3", "Hiragino Mincho Pro", "HiraMinProN-W3", "HGS明朝E", "ＭＳ Ｐ明朝", "MS PMincho", serif; font-weight: 500;
<?php endif; ?>
}

<?php
if ( 'type1' === $options['header_content_type'] ) {
  for ( $i = 1; $i <= 3; $i++ ) :
?>
.p-index-slider__item:nth-child(<?php echo $i; ?>) .p-button { background: <?php echo esc_html( $options['slider_btn_bg' . $i] ); ?>; color: <?php echo esc_html( $options['slider_btn_color' . $i] ); ?>; }
.p-index-slider__item:nth-child(<?php echo $i; ?>) .p-button:hover { background: <?php echo esc_html( $options['slider_btn_bg_hover' . $i] ); ?>; color: <?php echo esc_html( $options['slider_btn_color_hover' . $i] ); ?>; }
<?php
  endfor;

// video -------------------------------------------------------
} elseif($options['header_content_type'] == 'type2' || $options['header_content_type'] == 'type3') {
 $use_button = $options['show_video_catch_button'];
 if( $use_button == 1 ) {
   $text_color = $options['video_button_color'];
   $text_color_hover = $options['video_button_color_hover'];
   $bg_color = $options['video_button_bg_color'];
   $bg_color_hover = $options['video_button_bg_color_hover'];
   if($options['header_content_type'] == 'type2') {
     if(!wp_is_mobile()) {
       echo "#js-header-video .caption .button { background-color:" . $bg_color . "; color:" . $text_color . "; }\n";
       echo "#js-header-video .caption .button:hover { background-color:" . $bg_color_hover . "; color:" . $text_color_hover . "; }\n";
     } else {
       echo ".p-header-video .caption .button { background-color:" . $bg_color . "; color:" . $text_color . "; }\n";
       echo ".p-header-video .caption .button:hover { background-color:" . $bg_color_hover . "; color:" . $text_color_hover . "; }\n";
     };
  } else {
     if(!wp_is_mobile()) {
       echo "#js-header-youtube .caption .button { background-color:" . $bg_color . "; color:" . $text_color . "; }\n";
       echo "#js-header-youtube .caption .button:hover { background-color:" . $bg_color_hover . "; color:" . $text_color_hover . "; }\n";
     } else {
       echo ".p-header-youtube .caption .button { background-color:" . $bg_color . "; color:" . $text_color . "; }\n";
       echo ".p-header-youtube .caption .button:hover { background-color:" . $bg_color_hover . "; color:" . $text_color_hover . "; }\n";
     };
   };
 };
}; // END video
?>
/* load */
@-webkit-keyframes loading-square-loader {
  0% { box-shadow: 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px 0 rgba(<?php echo $hex_color1; ?>, 0), 0 -16px rgba(<?php echo $hex_color1; ?>, 0), 16px -16px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  5% { box-shadow: 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px 0 rgba(<?php echo $hex_color1; ?>, 0), 0 -16px rgba(<?php echo $hex_color1; ?>, 0), 16px -16px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  10% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px -8px rgba(<?php echo $hex_color1; ?>, 0), 0 -16px rgba(<?php echo $hex_color1; ?>, 0), 16px -16px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  15% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -24px rgba(<?php echo $hex_color1; ?>, 0), 16px -16px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  20% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -24px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  25% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -24px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  30% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -50px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  35% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -50px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  40% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -50px rgba(242, 205, 123, 0); }
  45%, 55% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  60% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  65% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  70% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  75% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  80% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px -8px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  85% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px -8px rgba(<?php echo $hex_color1; ?>, 0), 0 -24px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  90% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px -8px rgba(<?php echo $hex_color1; ?>, 0), 0 -24px rgba(<?php echo $hex_color1; ?>, 0), 16px -24px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  95%, 100% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px -8px rgba(<?php echo $hex_color1; ?>, 0), 0 -24px rgba(<?php echo $hex_color1; ?>, 0), 16px -24px rgba(<?php echo $hex_color1; ?>, 0), 32px -24px rgba(<?php echo $hex_color2; ?>, 0); }
}
@keyframes loading-square-loader {
  0% { box-shadow: 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px 0 rgba(<?php echo $hex_color1; ?>, 0), 0 -16px rgba(<?php echo $hex_color1; ?>, 0), 16px -16px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  5% { box-shadow: 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px 0 rgba(<?php echo $hex_color1; ?>, 0), 0 -16px rgba(<?php echo $hex_color1; ?>, 0), 16px -16px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  10% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px -8px rgba(<?php echo $hex_color1; ?>, 0), 0 -16px rgba(<?php echo $hex_color1; ?>, 0), 16px -16px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  15% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -24px rgba(<?php echo $hex_color1; ?>, 0), 16px -16px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  20% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -24px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  25% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -24px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  30% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -50px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  35% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -50px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(242, 205, 123, 0); }
  40% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -50px rgba(242, 205, 123, 0); }
  45%, 55% { box-shadow: 16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  60% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  65% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -16px rgba(<?php echo $hex_color1; ?>, 1), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  70% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -16px rgba(<?php echo $hex_color1; ?>, 1), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  75% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px -16px rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  80% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px -8px rgba(<?php echo $hex_color1; ?>, 0), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  85% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px -8px rgba(<?php echo $hex_color1; ?>, 0), 0 -24px rgba(<?php echo $hex_color1; ?>, 0), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  90% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px -8px rgba(<?php echo $hex_color1; ?>, 0), 0 -24px rgba(<?php echo $hex_color1; ?>, 0), 16px -24px rgba(<?php echo $hex_color1; ?>, 0), 32px -32px rgba(<?php echo $hex_color2; ?>, 1); }
  95%, 100% { box-shadow: 16px 8px rgba(<?php echo $hex_color1; ?>, 0), 32px 8px rgba(<?php echo $hex_color1; ?>, 0), 0 -8px rgba(<?php echo $hex_color1; ?>, 0), 16px -8px rgba(<?php echo $hex_color1; ?>, 0), 32px -8px rgba(<?php echo $hex_color1; ?>, 0), 0 -24px rgba(<?php echo $hex_color1; ?>, 0), 16px -24px rgba(<?php echo $hex_color1; ?>, 0), 32px -24px rgba(<?php echo $hex_color2; ?>, 0); }
}

.c-load--type2:before { box-shadow: 16px 0 0 rgba(<?php echo $hex_color1; ?>, 1), 32px 0 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -16px 0 rgba(<?php echo $hex_color1; ?>, 1), 16px -16px 0 rgba(<?php echo $hex_color1; ?>, 1), 32px -16px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -32px rgba(<?php echo $hex_color1; ?>, 1), 16px -32px rgba(<?php echo $hex_color1; ?>, 1), 32px -32px rgba(<?php echo $hex_color2; ?>, 0); }
.c-load--type2:after { background-color: rgba(<?php echo $hex_color2; ?>, 1); }
.c-load--type1 { border: 3px solid rgba(<?php echo esc_html( $hex_color1 ); ?>, 0.2); border-top-color: <?php echo esc_html( $primary_color ); ?>; }
#site_loader_animation.c-load--type3 i { background: <?php echo esc_html( $options['primary_color'] ); ?>; }

/* hover effect */
<?php if ( $options['hover1_rotate'] ) : ?>
.p-hover-effect--type1:hover img { -webkit-transform: scale(<?php echo esc_html( $options['hover1_zoom'] ); ?>) rotate(2deg); transform: scale(<?php echo esc_html( $options['hover1_zoom'] ); ?>) rotate(2deg); }
<?php else : ?>
.p-hover-effect--type1:hover img { -webkit-transform: scale(<?php echo esc_html( $options['hover1_zoom'] ); ?>); transform: scale(<?php echo esc_html( $options['hover1_zoom'] ); ?>); }
<?php endif; ?>
<?php if ( 'type1' == $options['hover2_direct'] ) : ?>
.p-hover-effect--type2 img { margin-left: 15px; -webkit-transform: scale(1.2) translate3d(-15px, 0, 0); transform: scale(1.2) translate3d(-15px, 0, 0);}
<?php else : ?>
.p-hover-effect--type2 img { margin-left: -15px; -webkit-transform: scale(1.2) translate3d(15px, 0, 0); transform: scale(1.2) translate3d(15px, 0, 0); }
<?php endif; ?>
.p-hover-effect--type2:hover img { opacity: <?php echo esc_html( $options['hover2_opacity'] ); ?> }
.p-hover-effect--type3 { background: <?php echo esc_html( $options['hover3_bgcolor'] ); ?>; }
.p-hover-effect--type3:hover img { opacity: <?php echo esc_html( $options['hover3_opacity'] ); ?>; }

/* Page header */
<?php if ( is_404() ) : ?>
.p-page-header::before { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $options['overlay_404'] ) ) ); ?>, <?php echo esc_html( $options['overlay_opacity_404'] ); ?>) }
<?php elseif ( is_author() || is_category() || is_date() || is_home() || is_search() || is_tag() ) : ?>
.p-page-header::before { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $options['archive_overlay'] ) ) ); ?>, <?php echo esc_html( $options['archive_overlay_opacity'] ); ?>) }
<?php elseif ( is_page() && ! is_front_page() ) : // フロントページも固定ページのため、条件から除く ?>
.p-page-header::before { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $post->page_overlay ) ) ); ?>, <?php echo esc_html( $post->page_overlay_opacity ); ?>) }
<?php elseif ( is_post_type_archive( 'news' ) ) : ?>
.p-page-header::before { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $options['news_archive_overlay'] ) ) ); ?>, <?php echo esc_html( $options['news_archive_overlay_opacity'] ); ?>) }
<?php elseif ( is_post_type_archive( 'review' ) ) : ?>
.p-page-header::before { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $options['review_archive_overlay'] ) ) ); ?>, <?php echo esc_html( $options['review_archive_overlay_opacity'] ); ?>) }
<?php elseif ( is_singular( 'news' ) ) : ?>
.p-page-header::before { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $options['news_overlay'] ) ) ); ?>, <?php echo esc_html( $options['news_overlay_opacity'] ); ?>) }
<?php elseif ( is_singular( 'post' ) ) : ?>
.p-page-header::before { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $options['blog_overlay'] ) ) ); ?>, <?php echo esc_html( $options['blog_overlay_opacity'] ); ?>) }
.p-page-header__meta a { color: <?php echo esc_html( $options['blog_color'] ); ?>; }
<?php endif; ?>

/* Entry body */
<?php if ( is_page() || is_singular( 'post' ) || is_singular( 'review' ) ) : ?>
.p-entry__body, .p-entry__body p { font-size: <?php echo esc_html( $content_font_size ); ?>px; }
<?php elseif ( is_singular( 'news' ) ) : ?>
.p-entry__body, .p-entry__body p { font-size: <?php echo esc_html( $news_content_font_size ); ?>px; }
<?php endif; ?>
.p-entry__body a { color: <?php echo esc_html( $options['content_link_color'] ); ?>; }

/* Header */
.l-header, .l-header--large.is-active { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $options['sub_header_bg'] ) ) ); ?>, <?php echo 'type1' === $options['header_fix'] ? 1 : esc_html( $options['sub_header_opacity'] ); ?>); }
<?php if ( is_front_page() ) : ?>
.l-header--large { background: rgba(<?php echo esc_html( implode( ', ', hex2rgb( $options['top_header_bg'] ) ) ); ?>, <?php echo esc_html( $options['top_header_opacity'] ); ?>); }
.l-header--large .p-global-nav > li > a { color: <?php echo esc_html( $options['top_header_font_color'] ); ?>; }
.l-header__logo a { color: <?php echo esc_html( $options['top_header_font_color'] ); ?>; } 
<?php else : ?>
.l-header__logo a { color: <?php echo esc_html( $options['sub_header_font_color'] ); ?>; } 
<?php endif; ?>
.p-global-nav > li > a, .l-header--large.is-active .p-global-nav > li > a { color: <?php echo esc_html( $options['sub_header_font_color'] ); ?>; }

/* Contents builder */
<?php 
foreach ( $options['contents_builder'] as $key => $value ) : 
	if ( 'showcase' == $value['cb_content_select'] ) :
?>
#cb_<?php echo $key; ?>::before { background: rgba( <?php echo esc_html( implode( ', ',  hex2rgb( $value['cb_showcase_overlay'] ) ) ); ?>, <?php echo esc_html( $value['cb_showcase_opacity'] ); ?>); }
#cb_<?php echo $key; ?> .p-button { background: <?php echo esc_html( $value['cb_showcase_btn_bg'] ); ?>; color: <?php echo esc_html( $value['cb_showcase_btn_color'] ); ?>; }
#cb_<?php echo $key; ?> .p-button:hover { background: <?php echo esc_html( $value['cb_showcase_btn_bg_hover'] ); ?>; color: <?php echo esc_html( $value['cb_showcase_btn_color_hover'] ); ?>; }
<?php
	endif;
endforeach;
?>

/* Footer bar */
<?php if ( is_mobile() && ( 'type1' === $options['footer_bar_display'] || 'type2' === $options['footer_bar_display'] ) ) : ?>
.c-footer-bar { background: rgba(<?php echo implode( ',', hex2rgb( $options['footer_bar_bg'] ) ) . ', ' . esc_html( $options['footer_bar_tp'] ) ?>); border-top: 1px solid <?php echo esc_html( $options['footer_bar_border'] ); ?>; color:<?php echo esc_html( $options['footer_bar_color']); ?>; }
.c-footer-bar a { color: <?php echo esc_html( $options['footer_bar_color'] ); ?>; }
.c-footer-bar__item + .c-footer-bar__item { border-left: 1px solid <?php echo esc_html( $options['footer_bar_border'] ); ?>; }
<?php endif; ?>

/* Responsive */
<?php if ( ! is_no_responsive() ) : ?>
@media only screen and (max-width: 1200px) {
.l-header, .l-header--large.is-active { background: <?php echo esc_html( $options['sub_header_bg'] ); ?>; }
.p-global-nav { background: rgba(<?php echo esc_html( $hex_color1 ); ?>, <?php echo esc_html( $options['sub_header_opacity'] ); ?>); }	
.l-header__logo a { color: <?php echo esc_html( $options['sub_header_font_color'] ); ?>; } 
}
@media only screen and (max-width: 767px) {

@-webkit-keyframes loading-square-loader {
  0% { box-shadow: 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px 0 rgba(<?php echo $hex_color1; ?>, 0), 0 -10px rgba(<?php echo $hex_color1; ?>, 0), 10px -10px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  5% { box-shadow: 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px 0 rgba(<?php echo $hex_color1; ?>, 0), 0 -10px rgba(<?php echo $hex_color1; ?>, 0), 10px -10px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  10% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px -5px rgba(<?php echo $hex_color1; ?>, 0), 0 -10px rgba(<?php echo $hex_color1; ?>, 0), 10px -10px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  15% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -15px rgba(<?php echo $hex_color1; ?>, 0), 10px -10px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  20% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -15px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  25% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -15px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  30% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -50px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  35% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -50px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  40% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -50px rgba(242, 205, 123, 0); }
  45%, 55% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  60% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  65% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  70% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  75% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  80% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px -5px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  85% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px -5px rgba(<?php echo $hex_color1; ?>, 0), 0 -15px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  90% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px -5px rgba(<?php echo $hex_color1; ?>, 0), 0 -15px rgba(<?php echo $hex_color1; ?>, 0), 10px -15px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  95%, 100% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px -5px rgba(<?php echo $hex_color1; ?>, 0), 0 -15px rgba(<?php echo $hex_color1; ?>, 0), 10px -15px rgba(<?php echo $hex_color1; ?>, 0), 20px -15px rgba(<?php echo $hex_color2; ?>, 0); }
}
@keyframes loading-square-loader {
  0% { box-shadow: 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px 0 rgba(<?php echo $hex_color1; ?>, 0), 0 -10px rgba(<?php echo $hex_color1; ?>, 0), 10px -10px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  5% { box-shadow: 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px 0 rgba(<?php echo $hex_color1; ?>, 0), 0 -10px rgba(<?php echo $hex_color1; ?>, 0), 10px -10px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  10% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px -5px rgba(<?php echo $hex_color1; ?>, 0), 0 -10px rgba(<?php echo $hex_color1; ?>, 0), 10px -10px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  15% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -15px rgba(<?php echo $hex_color1; ?>, 0), 10px -10px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  20% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -15px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  25% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -15px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  30% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -50px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  35% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -50px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(242, 205, 123, 0); }
  40% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -50px rgba(242, 205, 123, 0); }
  45%, 55% { box-shadow: 10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  60% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  65% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -10px rgba(<?php echo $hex_color1; ?>, 1), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  70% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -10px rgba(<?php echo $hex_color1; ?>, 1), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  75% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px -10px rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  80% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px -5px rgba(<?php echo $hex_color1; ?>, 0), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  85% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px -5px rgba(<?php echo $hex_color1; ?>, 0), 0 -15px rgba(<?php echo $hex_color1; ?>, 0), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  90% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px -5px rgba(<?php echo $hex_color1; ?>, 0), 0 -15px rgba(<?php echo $hex_color1; ?>, 0), 10px -15px rgba(<?php echo $hex_color1; ?>, 0), 20px -20px rgba(<?php echo $hex_color2; ?>, 1); }
  95%, 100% { box-shadow: 10px 5px rgba(<?php echo $hex_color1; ?>, 0), 20px 5px rgba(<?php echo $hex_color1; ?>, 0), 0 -5px rgba(<?php echo $hex_color1; ?>, 0), 10px -5px rgba(<?php echo $hex_color1; ?>, 0), 20px -5px rgba(<?php echo $hex_color1; ?>, 0), 0 -15px rgba(<?php echo $hex_color1; ?>, 0), 10px -15px rgba(<?php echo $hex_color1; ?>, 0), 20px -15px rgba(<?php echo $hex_color2; ?>, 0); }
}
.c-load--type2:before { box-shadow: 10px 0 0 rgba(<?php echo $hex_color1; ?>, 1), 20px 0 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -10px 0 rgba(<?php echo $hex_color1; ?>, 1), 10px -10px 0 rgba(<?php echo $hex_color1; ?>, 1), 20px -10px 0 rgba(<?php echo $hex_color1; ?>, 1), 0 -20px rgba(<?php echo $hex_color1; ?>, 1), 10px -20px rgba(<?php echo $hex_color1; ?>, 1), 20px -20px rgba(<?php echo $hex_color2; ?>, 0); }

}
<?php endif; ?>

/* Custom CSS */
<?php if ( $options['css_code'] ) { echo $options['css_code']; } ?>
</style>
<?php
}
add_action( 'wp_head', 'tcd_head' );
