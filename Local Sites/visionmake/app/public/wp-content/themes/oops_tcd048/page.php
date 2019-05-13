<?php get_header(); ?>
<main class="l-main">	
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
?>
	<article class="p-entry">
		<?php get_template_part( 'template-parts/page-header' ); ?>
		<div class="p-entry__inner l-inner">
			<?php get_template_part( 'template-parts/breadcrumb' ); ?>
			<div class="p-entry__body">
<?php 
		the_content(); 
		wp_link_pages( array(
			'before' => '<div class="p-page-links"><span class="p-page-links__title">' . __( 'Page', 'tcd-w' ) . ':</span>',
			'after' => '</div>',
			'link_before' => '<span>',
			'link_after' => '</span>'
		) );
?>
			</div>
		</div>				
	</article>
<?php
	endwhile;
endif;
?>
<?php get_footer(); ?>
