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
		<div id="js-infinitescroll" class="p-news-list">
<?php
	while ( have_posts() ) :
		the_post();
?>
			<article class="p-news-list__item p-article02"<?php if ( ! wp_is_mobile() ) { echo ' style="opacity: 0;"'; } ?>>
				<a href="<?php the_permalink(); ?>">
			  	<header class="p-article02__header">
			      <div class="p-article02__thumbnail p-hover-effect--<?php echo esc_attr( $options['hover_type'] ); ?>">
<?php
			if ( has_post_thumbnail() ) {
				the_post_thumbnail( 'size2' );
			} else {
				echo '<img src="' . get_template_directory_uri() . '/img/no-image-320x320.gif" alt="">' . "\n";
			}
?>
			      </div>
			      <div class="p-article02__content">
			          <h2 class="p-article02__title"><?php echo wp_trim_words( get_the_title(), 35 ); ?></h2>
			          <?php if ( $options['show_date_news'] ) : ?><time class="p-article02__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time><?php endif; ?>
			      </div>
			  	</header>
			  	<p class="p-article02__excerpt"><?php echo esc_html( wp_trim_words( get_the_content(), 65, '...' ) ); ?></p>
			  </a>
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
		<p id="js-load-post" class="p-load-post"><?php next_posts_link( __( 'Next News', 'tcd-w' ) ); ?></p>
<?php 
		endif; 
	endif;
endif;
?>
	</div>
<?php get_footer(); ?>
