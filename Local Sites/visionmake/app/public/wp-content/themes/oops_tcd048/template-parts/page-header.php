<?php
$options = get_desing_plus_option();

if ( is_404() ) :
	$signage = wp_get_attachment_url( $options['image_404'] );
	$catchphrase = $options['catchphrase_404'];
	$desc = $options['desc_404'];
	$catchphrase_font_size = $options['catchphrase_font_size_404'] ? $options['catchphrase_font_size_404'] : 40;
	$desc_font_size = $options['desc_font_size_404'] ? $options['desc_font_size_404'] : 14;
	$color = $options['color_404'] ? $options['color_404'] : '#FFFFFF';
	$shadow1 = ( ! empty( $options['shadow1_404'] ) ) ? $options['shadow1_404'] : 0;
	$shadow2 = ( ! empty( $options['shadow2_404'] ) ) ? $options['shadow2_404'] : 0;
	$shadow3 = ( ! empty( $options['shadow3_404'] ) ) ? $options['shadow3_404'] : 0;
	$shadow4 = $options['shadow_color_404'];

elseif ( is_author() || is_category() || is_date() || is_home() || is_search() || is_tag() ) :
	$signage = wp_get_attachment_url( $options['archive_image'] );
	$catchphrase = $options['archive_catchphrase'];
	$desc = $options['archive_desc'];
	$catchphrase_font_size = $options['archive_catchphrase_font_size'] ? $options['archive_catchphrase_font_size'] : 40;
	$desc_font_size = $options['archive_desc_font_size'] ? $options['archive_desc_font_size'] : 14;
	$color = $options['archive_color'] ? $options['archive_color'] : '#FFFFFF';
	$shadow1 = ( ! empty( $options['archive_shadow1'] ) ) ? $options['archive_shadow1'] : 0;
	$shadow2 = ( ! empty( $options['archive_shadow2'] ) ) ? $options['archive_shadow2'] : 0;
	$shadow3 = ( ! empty( $options['archive_shadow3'] ) ) ? $options['archive_shadow3'] : 0;
	$shadow4 = $options['archive_shadow_color'];

elseif ( is_page() ) :
	$signage = wp_get_attachment_url( $post->page_header_image );
	$catchphrase = $post->page_headline;
	$catchphrase_font_size = $post->page_headline_font_size ? $post->page_headline_font_size : 40;
	$desc = $post->page_desc;
	$desc_font_size = $post->page_desc_font_size ? $post->page_desc_font_size : 14;
	$color = $post->page_headline_color;
	$shadow1 = ( ! empty( $post->page_headline_shadow1 ) ) ? $post->page_headline_shadow1 : 0;
	$shadow2 = ( ! empty( $post->page_headline_shadow2 ) ) ? $post->page_headline_shadow2 : 0;
	$shadow3 = ( ! empty( $post->page_headline_shadow3 ) ) ? $post->page_headline_shadow3 : 0;
	$shadow4 = $post->page_headline_shadow4;

elseif ( is_post_type_archive( 'news' ) ) :
	$signage = wp_get_attachment_url( $options['news_archive_image'] );
	$catchphrase = $options['news_archive_catchphrase'];
	$desc = $options['news_archive_desc'];
	$catchphrase_font_size = $options['news_archive_catchphrase_font_size'] ? $options['news_archive_catchphrase_font_size'] : 40;
	$desc_font_size = $options['news_archive_desc_font_size'] ? $options['news_archive_desc_font_size'] : 14;
	$color = $options['news_archive_color'] ? $options['news_archive_color'] : 'FFFFFF';
	$shadow1 = ( ! empty( $options['news_archive_shadow1'] ) ) ? $options['news_archive_shadow1'] : 0;
	$shadow2 = ( ! empty( $options['news_archive_shadow2'] ) ) ? $options['news_archive_shadow2'] : 0;
	$shadow3 = ( ! empty( $options['news_archive_shadow3'] ) ) ? $options['news_archive_shadow3'] : 0;
	$shadow4 = $options['news_archive_shadow_color'];

elseif ( is_post_type_archive( 'review' ) || is_singular( 'review' ) ) :
	$signage = wp_get_attachment_url( $options['review_archive_image'] );
	$catchphrase = $options['review_archive_catchphrase'];
	$desc = $options['review_archive_desc'];
	$catchphrase_font_size = $options['review_archive_catchphrase_font_size'] ? $options['review_archive_catchphrase_font_size'] : 40;
	$desc_font_size = $options['review_archive_desc_font_size'] ? $options['review_archive_desc_font_size'] : 14;
	$color = $options['review_archive_color'] ? $options['review_archive_color'] : 'FFFFFF';
	$shadow1 = ( ! empty( $options['review_archive_shadow1'] ) ) ? $options['review_archive_shadow1'] : 0;
	$shadow2 = ( ! empty( $options['review_archive_shadow2'] ) ) ? $options['review_archive_shadow2'] : 0;
	$shadow3 = ( ! empty( $options['review_archive_shadow3'] ) ) ? $options['review_archive_shadow3'] : 0;
	$shadow4 = $options['review_archive_shadow_color'];

elseif ( is_singular( 'post' ) ) :
	if ( $options['show_thumbnail'] ) {
		$signage = has_post_thumbnail() ? wp_get_attachment_url( get_post_thumbnail_id() ) : wp_get_attachment_url( $options['archive_image'] );
	} else {
		$signage = wp_get_attachment_url( $options['archive_image'] );
	}
	// $catchphrase = get_the_title(); 改行に対応するため、the_title() を使用する
	$catchphrase_font_size = $options['title_font_size'] ? $options['title_font_size'] : 40;
	$color = $options['blog_color'] ? $options['blog_color'] : 'FFFFFF';
	$shadow1 = ( ! empty( $options['blog_shadow1'] ) ) ? $options['blog_shadow1'] : 0;
	$shadow2 = ( ! empty( $options['blog_shadow2'] ) ) ? $options['blog_shadow2'] : 0;
	$shadow3 = ( ! empty( $options['blog_shadow3'] ) ) ? $options['blog_shadow3'] : 0;
	$shadow4 = $options['blog_shadow_color'];

elseif ( is_singular( 'news' ) ) :
	if ( $options['show_thumbnail_news'] ) {
		$signage = has_post_thumbnail() ? wp_get_attachment_url( get_post_thumbnail_id() ) : wp_get_attachment_url( $options['news_archive_image'] );
	} else {
		$signage = wp_get_attachment_url( $options['news_archive_image'] );
	}
	// $catchphrase = get_the_title(); 改行に対応するため、the_title() を使用する
	$catchphrase_font_size = $options['news_title_font_size'] ? $options['news_title_font_size'] : 40;
	$color = $options['news_color'] ? $options['news_color'] : 'FFFFFF';
	$shadow1 = ( ! empty( $options['news_shadow1'] ) ) ? $options['news_shadow1'] : 0;
	$shadow2 = ( ! empty( $options['news_shadow2'] ) ) ? $options['news_shadow2'] : 0;
	$shadow3 = ( ! empty( $options['news_shadow3'] ) ) ? $options['news_shadow3'] : 0;
	$shadow4 = $options['news_shadow_color'];

endif;
?>
	<header class="p-page-header" data-parallax="scroll" data-image-src="<?php echo esc_attr( $signage ); ?>">
		<div class="p-page-header__inner l-inner" style="text-shadow: <?php echo esc_attr( $shadow1 ); ?>px <?php echo esc_attr( $shadow2 ); ?>px <?php echo esc_attr( $shadow3 ); ?>px <?php echo esc_attr( $shadow4 ); ?>">
<?php
if ( is_singular( 'post' ) || is_singular( 'news' ) ) : 
?>
			<h1 class="p-page-header__title" style="color: <?php echo esc_attr( $color ); ?>; font-size: <?php echo esc_attr( $catchphrase_font_size ); ?>px;"><?php the_title(); ?></h1>
<?php 
	if ( is_singular( 'post' ) ) : 
?>
			<p class="p-page-header__meta" style="color: <?php echo esc_attr( $color ); ?>;">
				<?php if ( $options['show_date'] ) : ?><time class="p-page-header__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time><?php endif; ?><?php if ( $options['show_category'] ) : ?><span class="p-page-header__category"><?php the_category( ', ' ); ?></span><?php endif; ?>
			</p>
<?php
	elseif ( is_singular( 'news' ) ) : 
?>
			<p class="p-page-header__meta" style="color: <?php echo esc_attr( $color ); ?>;">
				<?php if ( $options['show_date_news'] ) : ?><time class="p-page-header__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time><?php endif; ?>
			</p>
<?php
		endif;
?>
<?php 
else : // ブログ詳細、ニュース詳細以外
?>
			<h1 class="p-page-header__title" style="color: <?php echo esc_attr( $color ); ?>; font-size: <?php echo esc_attr( $catchphrase_font_size ); ?>px;"><?php echo esc_html( $catchphrase ); ?></h1>
			<p class="p-page-header__desc" style="color: <?php echo esc_attr( $color ); ?>; font-size: <?php echo esc_attr( $desc_font_size ); ?>px;"><?php echo nl2br( esc_html( $desc ) ); ?></p>
<?php 
endif; 
?>
		</div>
	</header>
