<?php
$options = get_desing_plus_option();
$content_font_size = $options['news_content_font_size'] ? $options['news_content_font_size'] : 14;
get_header();
?>
<main class="l-main">	
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$previous_post = get_previous_post();
		$next_post = get_next_post();
		$args = array(
			'orderby' => 'date',
			'post_status' => 'publish',
			'post_type' => 'news',
			'posts_per_page' => $options['recent_news_num']
		);
		$the_query = new WP_Query( $args );
?>
	<article class="p-entry">
		<?php get_template_part( 'template-parts/page-header' ); ?>
		<div class="p-entry__inner p-entry__inner--narrow l-inner">
			<?php get_template_part( 'template-parts/breadcrumb' ); ?>
			<?php if ( $options['show_sns_top_news'] ) { get_template_part( 'template-parts/sns-btn-top' ); } ?>
			<div class="p-entry__body" style="font-size: <?php echo esc_attr( $content_font_size ); ?>px;">
<?php 
		the_content(); 
		wp_link_pages( array(
			'before' => '<div class="p-page-links">',
			'after' => '</div>',
			'link_before' => '<span>',
			'link_after' => '</span>'
		) );
?>
			</div>
			<?php if ( $options['show_sns_btm_news'] ) { get_template_part( 'template-parts/sns-btn-btm' ); } ?>
<?php
		if ( '5' !== $options['cta_display'] && $options['cta_display_news'] ) {
			get_template_part( 'template-parts/cta' );
		}
		if ( $options['show_next_post_news'] && ( $previous_post || $next_post ) ) : 
?>
			<ul class="p-entry__nav c-nav01">
<?php
			if ( $previous_post ) :
?>
    		<li class="c-nav01__item c-nav01__item--prev">
    		    <a href="<?php echo esc_url( get_permalink( $previous_post->ID ) ); ?>" data-prev="<?php _e( 'Previous post', 'tcd-w' ); ?>"><span class="u-hidden-sm"><?php echo esc_html( wp_trim_words( $previous_post->post_title, 40, '...' ) ); ?></span></a>
    		</li>
<?php
			endif;
			if ( $next_post ) :
?>
    		<li class="c-nav01__item c-nav01__item--next">
    		    <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" data-next="<?php _e( 'Next post', 'tcd-w' ); ?>"><span class="u-hidden-sm"><?php echo esc_html( wp_trim_words( $next_post->post_title, 40, '...' ) ); ?></span></a>
    		</li>
<?php
			endif;
?>
			</ul>
<?php
		endif;
		get_template_part( 'template-parts/advertisement' );
?>
		</div>				
<?php 
	if ( $the_query->have_posts() ) : 
?>
		<section class="p-latest-news l-inner">
			<div class="p-latest-news__title">
				<h2><?php echo esc_html( $options['recent_news_headline'] ); ?></h2>
				<a class="p-latest-news__archive-link" href="<?php echo esc_url( get_post_type_archive_link( 'news' ) ); ?>"><?php echo esc_html( $options['recent_news_link_text'] ); ?></a>
			</div>
			<ul>
<?php
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
?>
				<li class="p-latest-news__item">
					<a href="<?php the_permalink(); ?>">
						<?php if ( $options['show_date_news'] ): ?><time class="p-latest-news__item-date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time><?php endif; ?>
						<h3 class="p-latest-news__item-title"><?php the_title(); ?></h3>
					</a>
				</li>
<?php
			endwhile;
			wp_reset_postdata();
?>
			</ul>
		</section>
<?php
	endif;
?>
	</article>
<?php
	endwhile;
endif;
?>
<?php get_footer(); ?>
