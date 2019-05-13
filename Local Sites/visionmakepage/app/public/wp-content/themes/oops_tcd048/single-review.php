<?php get_header(); ?>
<main class="l-main">	
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		get_template_part( 'template-parts/page-header' );
?>
		<article class="p-entry">
		<div class="p-entry__inner l-inner">
			<?php get_template_part( 'template-parts/breadcrumb' ); ?>
			<header class="p-review-header">
				<p class="p-review-header__name"><?php echo esc_html( $post->review_name ); ?> <?php echo esc_html( $post->review_job ); ?></p>
				<h1 class="p-review-header__title l-inner l-inner--narrow"><?php the_title(); ?></h1>
			</header>
			<div class="p-entry__body l-inner l-inner--narrow">
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
			<footer class="p-review-footer">
<?php 
		if ( $post->review_portrait ) {
			$review_portrait = wp_get_attachment_image_src( $post->review_portrait, 'size2' );
			echo '<img class="p-review-footer__portrait" src="' . esc_attr( $review_portrait[0] ) . '" alt="">' . "\n";
		} else {
			echo '<img class="p-review-footer__portrait" src="<?php echo get_template_directory_uri(); ?>/img/no-image-320x320.gif" alt="">' . "\n";
		}
?>
				<p class="p-review-footer__name"><?php echo esc_html( $post->review_name ); ?> <?php echo esc_html( $post->review_job ); ?></p>
				<a class="p-review-footer__link" href="<?php echo esc_url( get_post_type_archive_link( 'review' ) ); ?>"><span><?php _e( 'Back to archive page', 'tcd-w' ); ?></span></a>
			</footer>
				<?php if ( '5' !== $options['cta_display'] && $options['cta_display_review'] ) { get_template_part( 'template-parts/cta' ); } ?>
		</div>
	</article>
<?php
	endwhile;
endif;
?>
<?php get_footer(); ?>
