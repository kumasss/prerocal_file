<?php
global $wp_query;
$options = get_desing_plus_option();
$args = array( 
	'current' => max( 1, get_query_var( 'paged' ) ), 
	'prev_next' => false,
	'total' => $wp_query->max_num_pages,
	'type' => 'array'
); 
get_header(); 
?>
<main class="l-main">	
	<?php get_template_part( 'template-parts/page-header' ); ?>
	<div class="l-inner">
		<?php get_template_part( 'template-parts/breadcrumb' ); ?>
<?php
if ( have_posts() ) :
?>
			<ul class="p-review-list">
			    <li class="p-review-list__row">
<?php
	while ( have_posts() ) :
		the_post();
		if ( ( 0 != $wp_query->current_post ) && ( 0 == ( $wp_query->current_post ) % 2 ) ) :
?>
			    </li>
			    <li class="p-review-list__row">
<?php
		endif;
?>
						<div class="p-review-list__item p-review">
<?php 
		if ( $post->review_portrait ) : 
			$review_portrait = wp_get_attachment_image_src( $post->review_portrait, 'size2' );
?>
							<img class="p-review__image" src="<?php echo esc_attr( $review_portrait[0] ); ?>" alt="">
<?php
 		endif; 
?>
			        <div class="u-overflow-hidden">
			            <h2 class="p-review__name"><?php echo esc_html( $post->review_name ); ?> <?php echo esc_html( $post->review_job ); ?></h2>
			            <p class="p-review__desc"><?php echo esc_html( wp_trim_words( get_the_content(), 90, '...' ) ); ?></p>
									<?php if ( $post->display_review_button ) : ?><a class="p-review__button" href="<?php the_permalink(); ?>"><?php _e( 'Read more', 'tcd-w' ); ?></a><?php endif; ?>
			        </div>
			    	</div>
<?php
	endwhile;
?>
			    </li>
			</ul>
<?php
	if ( paginate_links( $args ) ) :
?>
			<ul class="p-pager">
<?php
		foreach ( paginate_links( $args ) as $page_numbers ) :
?>
			  <li class="p-pager__item"><?php echo $page_numbers; ?></li>    
<?php
		endforeach;
?>
			</ul>
<?php
	endif;
endif;
?>
	</div>
<?php get_footer(); ?>
