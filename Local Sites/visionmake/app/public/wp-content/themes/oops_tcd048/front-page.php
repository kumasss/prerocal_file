<?php 
$options = get_desing_plus_option();
get_header(); 
?>
<main class="l-main">
	<?php get_template_part( 'template-parts/index-slider' ); ?>
	<?php 
	if ( $options['display_news_ticker'] ) : 
		$news_ticker_args = array(
			'post_type' => 'news',
			'post_status' => 'publish',
			'posts_per_page' => $options['news_ticker_num'] ? $options['news_ticker_num'] : 5
		);
		$the_query = new WP_Query( $news_ticker_args );
		if ( $the_query->have_posts() ) :
	?>
	<div class="p-news-ticker">
		<div class="p-news-ticker__inner l-inner">
			<?php if ( $options['display_news_ticker_link'] ) : ?><a class="p-news-ticker__archive-link" href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>"><?php echo esc_html( $options['news_ticker_link_text'] ); ?></a><?php endif; ?>
			<div id="js-news-ticker">
				<ul class="p-news-ticker__list">
					<?php
					while ( $the_query->have_posts() ) :
						$the_query->the_post();
					?>
					<li class="p-news-ticker__item">
						<?php if ( $options['display_news_ticker_date'] ) : ?><time class="p-news-ticker__item-date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time><?php endif; ?><a href="<?php the_permalink(); ?>"><?php echo esc_html( wp_trim_words( get_the_title(), 56 ) ); ?></a>
					</li>
					<?php
					endwhile;
					wp_reset_postdata();
					?>
				</ul>
			</div>
		</div>
	</div>
	<?php 
		endif; 
	endif;
	foreach( $options['contents_builder'] as $key => $value ) :
		if ( 'catch_and_desc' == $value['cb_content_select'] ) : 
			if ( $value['cb_catch_and_desc_display'] ) : 
?>
	<div class="l-inner">
		<div id="cb_<?php echo $key; ?>" class="p-index-content01">
			<h2 class="p-index-content01__catch" style="font-size:<?php echo esc_attr( $value['cb_catch_and_desc_headline_font_size'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_catch_and_desc_headline'] ) ); ?></h2>
				<p class="p-index-content01__desc" style="font-size:<?php echo esc_attr( $value['cb_catch_and_desc_desc_font_size'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_catch_and_desc_desc'] ) ); ?></p>
			</div>
	</div><!-- /.l-inner -->
<?php 
			endif; 
		elseif ( 'three_boxes' == $value['cb_content_select'] ) : 
			if ( $value['cb_three_boxes_display'] ) : 
?>
	<div class="l-inner">
		<div id="cb_<?php echo $key; ?>" class="p-index-content02">
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
			<div class="p-index-content02__item">
				<h3 class="p-index-content02__item-catch" style="font-size: <?php echo esc_attr( $value['cb_three_boxes_headline_font_size' . $i] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_three_boxes_headline' . $i] ) ); ?></h3>
				<p class="p-index-content02__item-desc" style="font-size: <?php echo esc_attr( $value['cb_three_boxes_desc_font_size' . $i] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_three_boxes_desc' . $i] ) ); ?></p>
				<a class="p-index-content02__item-image p-hover-effect--<?php echo esc_attr( $options['hover_type'] ); ?>" href="<?php echo esc_url( $value['cb_three_boxes_url' . $i] ); ?>"<?php if ( $value['cb_three_boxes_target' . $i] ) { echo ' target="_blank"'; } ?>>
					<?php
					if ( $value['cb_three_boxes_image' . $i] ) { 
						echo wp_get_attachment_image( $value['cb_three_boxes_image' . $i], 'size3' );		
					} else {
						echo '<img src="' . get_template_directory_uri() . '/img/no-image-340x220.gif" alt="">' . "\n";
					}
					?>
				</a>
			</div>
			<?php endfor; ?>
		</div>
	</div><!-- /.l-inner -->
<?php 
			endif; 
		elseif ( 'showcase' == $value['cb_content_select'] ) : 
			if ( $value['cb_showcase_display'] ) : 
				if ( 'type1' == $value['cb_showcase_type'] ) :
?>
	<div id="cb_<?php echo $key; ?>" class="p-index-content03 p-showcase" data-parallax="scroll" data-image-src="<?php echo esc_attr( wp_get_attachment_url( $value['cb_showcase_bg_image'] ) ); ?>">
		<div class="p-showcase__inner l-inner">
			<div class="p-showcase__content">
				<h2 class="p-showcase__catch" style="font-size: <?php echo esc_attr( $value['cb_showcase_headline_font_size'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_showcase_headline'] ) ); ?></h2>
				<p class="p-showcase__desc" style="font-size: <?php echo esc_attr( $value['cb_showcase_desc_font_size'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_showcase_desc'] ) ); ?></p>
				<?php if ( $value['cb_showcase_display_button'] ) : ?>
				<p class="p-showcase__action"><a class="p-button" href="<?php echo esc_url( $value['cb_showcase_url'] ); ?>"<?php if ( $value['cb_showcase_target'] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $value['cb_showcase_label'] ); ?></a></p>
				<?php endif; ?>
			</div>
			<div class="p-index-content03__image p-showcase__image"><?php if ( $value['cb_showcase_image'] ) { echo wp_get_attachment_image( $value['cb_showcase_image'], 'full' ); } ?></div>
		</div>
	</div>
<?php 
				elseif ( 'type2' == $value['cb_showcase_type'] ) :
?>
	<div id="cb_<?php echo $key; ?>" class="p-index-content05 p-showcase p-showcase--reverse" data-parallax="scroll" data-image-src="<?php echo esc_attr( wp_get_attachment_url( $value['cb_showcase_bg_image'] ) ); ?>">
		<div class="p-showcase__inner l-inner">
			<div class="p-showcase__content">
				<h2 class="p-showcase__catch" style="font-size: <?php echo esc_attr( $value['cb_showcase_headline_font_size'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_showcase_headline'] ) ); ?></h2>
				<p class="p-showcase__desc" style="font-size: <?php echo esc_attr( $value['cb_showcase_desc_font_size'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_showcase_desc'] ) ); ?></p>
				<?php if ( $value['cb_showcase_display_button'] ) : ?>
				<p class="p-showcase__action"><a class="p-button" href="<?php echo esc_url( $value['cb_showcase_url'] ); ?>"<?php if ( $value['cb_showcase_target'] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $value['cb_showcase_label'] ); ?></a></p>
				<?php endif; ?>
			</div>
			<div class="p-index-content05__image p-showcase__image"><?php if ( $value['cb_showcase_image'] ) { echo wp_get_attachment_image( $value['cb_showcase_image'], 'full' ); } ?></div>
		</div>
	</div>
<?php
				else:
?>
	<div id="cb_<?php echo $key; ?>" class="p-index-content08 p-showcase" data-parallax="scroll" data-image-src="<?php echo esc_attr( wp_get_attachment_url( $value['cb_showcase_bg_image'] ) ); ?>">
		<div class="p-index-content08__inner p-showcase__inner l-inner">
			<h2 class="p-showcase__catch" style="font-size: <?php echo esc_attr( $value['cb_showcase_headline_font_size'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_showcase_headline'] ) ); ?></h2>
			<p class="p-showcase__desc" style="font-size: <?php echo esc_attr( $value['cb_showcase_desc_font_size'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_showcase_desc'] ) ); ?></p>
			<?php if ( $value['cb_showcase_display_button'] ) : ?>
			<p class="p-showcase__action"><a class="p-button" href="<?php echo esc_url( $value['cb_showcase_url'] ); ?>"<?php if ( $value['cb_showcase_target'] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $value['cb_showcase_label'] ); ?></a></p>
			<?php endif; ?>
		</div>
	</div>
<?php
				endif; // ショーケースのタイプ
			endif; // ショーケースを表示する
		elseif ( 'gallery_content' == $value['cb_content_select'] ) : 
			if ( $value['cb_gallery_content_display'] ) : 
?>
	<div class="l-inner">
		<div id="cb_<?php echo $key; ?>" class="p-index-content04">
			<h2 class="p-index-content04__catch" style="font-size: <?php echo esc_attr( $value['cb_gallery_content_headline_font_size'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_gallery_content_headline'] ) ); ?></h2>
			<p class="p-index-content04__summary" style="font-size: <?php echo esc_attr( $value['cb_gallery_content_summary_font_size'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_gallery_content_summary'] ) ); ?></p>
			<?php if ( $value['cb_gallery_content_display_slider'] ) : ?>
			<div class="p-index-content04__carousel">
				<?php 
				if ( $value['cb_gallery_content_items'] ) :
					foreach ( $value['cb_gallery_content_items'] as $option ) :
						if ( $option['image'] ) :
				?>
				<a href="<?php echo esc_attr( wp_get_attachment_url( $option['image'] ) ); ?>" class="p-hover-effect--<?php echo esc_attr( $options['hover_type'] ); ?>" data-lightbox="lightbox[index-content04__carousel<?php echo $key; ?>]" data-title="<?php echo esc_html( $option['caption'] ); ?>"><?php echo wp_get_attachment_image( $option['image'], 'size2' ); ?></a>
				<?php 
						endif;
					endforeach; 
				endif; 
				?>
			</div>
			<?php endif; ?>
			<div class="p-index-content04__desc<?php if ( ! $value['cb_gallery_content_desc1'] || ! ( $value['cb_gallery_content_desc2'] ) ) : ?> p-index-content04__desc--full<?php endif; ?>">
				<p style="font-size: <?php echo esc_attr( $value['cb_gallery_content_desc_font_size1'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_gallery_content_desc1'] ) ); ?></p>
				<p style="font-size: <?php echo esc_attr( $value['cb_gallery_content_desc_font_size2'] ); ?>px;"><?php echo nl2br( esc_html( $value['cb_gallery_content_desc2'] ) ); ?></p>
			</div>
		</div>
	</div><!-- /.l-inner -->
<?php 
			endif; 
	elseif ( 'circular_images_and_texts' == $value['cb_content_select'] ) : 
		if ( $value['cb_circular_images_and_texts_display'] ) : 
?>
	<div class="l-inner">
		<div id="cb_<?php echo $key; ?>" class="p-index-content06">
			<?php 
			if ( $value['cb_circular_images_and_texts_items'] ) :
				foreach ( $value['cb_circular_images_and_texts_items'] as $option ) :
			?>
			<div class="p-index-content06__item">
				<div class="p-index-content06__item-image"><?php echo wp_get_attachment_image( $option['image'], 'size2' ); ?></div>
				<div class="p-index-content06__item-catch"><?php echo nl2br( esc_html( $option['headline'] ) ); ?></div>
				<p class="p-index-content06__item-desc"><?php echo nl2br( esc_html( $option['desc'] ) ); ?></p>
			</div>
			<?php
				endforeach;
			endif;
			?>
		</div>
	</div>
<?php 
			endif; 
		elseif ( 'review_slider' == $value['cb_content_select'] ) : 
			if ( $value['cb_review_slider_display'] ) : 
?>
	<div id="cb_<?php echo $key; ?>" class="p-index-content07">
		<div class="l-inner">
			<h2 class="p-index-content07__catch" style="font-size: <?php echo esc_attr( $value['cb_review_slider_headline_font_size'] ); ?>px;"><?php echo esc_html( $value['cb_review_slider_headline'] ); ?></h2>
			<?php 
			if ( $value['cb_review_slider_display_slider'] ) : 
				$args = array(
					'post_status' => 'publish',
					'post_type' => 'review',
					'posts_per_page' => -1,
					'meta_query' => array(
						array(
							'key'     => 'display_on_front',
							'value'   => 1
						),
					),
				);	
				$the_query = new WP_Query( $args );
				if ( $the_query->have_posts() ) :
			?>
			<ul class="p-index-content07__review">
				<?php
				while ( $the_query->have_posts() ) :
					$the_query->the_post();
						$review_portrait = wp_get_attachment_image_src( $post->review_portrait, 'size2' );
				?>
				<li class="p-review u-cleafix">
					<?php if ( $review_portrait ) : ?>
					<img class="p-review__image" src="<?php echo esc_attr( $review_portrait[0] ); ?>" alt="">
					<?php endif; ?>
					<div>
						<h3 class="p-review__name"><?php echo esc_html( $post->review_name ); ?> <?php echo esc_html( $post->review_job ); ?></h3>
						<p class="p-review__desc"><?php echo esc_html( wp_trim_words( get_the_content(), 120, '...' ) ); ?></p>
					</div>
				</li>
				<?php
				endwhile;
				wp_reset_postdata();
				?>
			</ul>
			<?php endif; endif; ?>
			<?php if ( $value['cb_review_slider_display_link'] ) : ?>
			<a class="p-index-content07__archive-link" href="<?php echo esc_url( get_post_type_archive_link( 'review' ) ); ?>"><?php echo esc_html( $value['cb_review_slider_link_text'] ); ?></a>
			<?php endif; ?>
		</div>
	</div>
<?php 
			endif; 
		elseif ( 'wysiwyg' == $value['cb_content_select'] ) : 
			if ( $value['cb_wysiwyg_display'] ) {
      	$cb_wysiwyg_editor = apply_filters( 'the_content', $value['cb_wysiwyg_editor'] );
				if ( $cb_wysiwyg_editor ) {
					echo '<div id="cb_' . $key . '">' . $cb_wysiwyg_editor . '</div>' . "\n";
				}
			} 
?>
<?php 
		endif; 
	endforeach; // コンテンツビルダーここまで
	?>
<?php get_footer(); ?>
