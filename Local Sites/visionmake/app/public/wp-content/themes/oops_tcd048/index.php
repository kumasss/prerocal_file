<?php
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
		<div id="js-infinitescroll" class="p-blog-list">
<?php
	while ( have_posts() ) :
		the_post();
?>
			<article class="p-blog-list__item p-article01"<?php if ( ! wp_is_mobile() ) { echo ' style="opacity: 0;"'; } ?>>
      	<a class="p-article01__thumbnail p-hover-effect--<?php echo esc_attr( $options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'size1' ); 
		} else {
			echo '<img src="' . get_template_directory_uri() . '/img/no-image-360x180.gif" alt="">' . "\n";
		}
?>
				</a>
        <h2 class="p-article01__title"><a href="<?php the_permalink(); ?>"><?php echo is_mobile() ? esc_html( wp_trim_words( get_the_title(), 30, '...' ) ) : esc_html( wp_trim_words( get_the_title(), 40, '...' ) ); ?></a></h2>
<?php
		if ( $options['show_date'] || $options['show_category'] ) :
?>
        <p class="p-article01__meta">
					<?php if ( $options['show_date'] ) : ?><time class="p-article01__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time><?php endif; if ( $options['show_category'] && get_the_category() ) : ?><span class="p-article01__category"><?php the_category( ', ' ); ?></span><?php endif; ?></p>
<?php
		endif;
?>
      		</article>
<?php
	endwhile;
?>
		</div>
<?php 
	if ( wp_is_mobile() ) :
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
	else :	
		if ( get_next_posts_link() ) : 
?>
		<p id="js-load-post" class="p-load-post"><?php next_posts_link( __( 'Next Blog', 'tcd-w' ) ); ?></p>
<?php 
		endif; 
	endif;
endif;
?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
