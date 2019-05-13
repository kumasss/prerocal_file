<?php
$options = get_desing_plus_option();
$content_font_size = $options['content_font_size'] ? $options['content_font_size'] : 14;
$show_author = $options['show_author'];
$show_category = $options['show_category'];
$show_comment = $options['show_comment'];
$show_date = $options['show_date'];
$show_tag = $options['show_tag'];
get_header();
?>
<main class="l-main">	
<?php
if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$categories = get_the_category();
		$previous_post = get_previous_post();
		$next_post = get_next_post();
		$args = array(
			'category_name' => $categories[0]->slug,
			'orderby' => 'rand',
			'post__not_in' => array( $post->ID ),
			'post_status' => 'publish',
			'post_type' => 'post',
			'posts_per_page' => 4
		);
		$the_query = new WP_Query( $args );
?>
	<article class="p-entry">
		<?php get_template_part( 'template-parts/page-header' ); ?>
		<div class="p-entry__inner p-entry__inner--narrow l-inner">
			<?php get_template_part( 'template-parts/breadcrumb' ); ?>
			<?php if ( $options['show_sns_top'] ) { get_template_part( 'template-parts/sns-btn-top' ); } ?>
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
			<?php if ( $options['show_sns_btm'] ) { get_template_part( 'template-parts/sns-btn-btm' ); } ?>
<?php 
		if ( $show_author || $show_category || $show_tag || $show_comment ) : ?>
			<ul class="p-entry__meta c-meta-box u-clearfix">
				<?php if ( $show_author ) : ?><li class="c-meta-box__item c-meta-box__item--author"><?php _e( 'Author', 'tcd-w' ); ?>: <?php the_author_posts_link(); ?></li><?php endif; ?>
				<?php if ( $show_category ) : ?><li class="c-meta-box__item c-meta-box__item--category"><?php the_category( ', ' ); ?></li><?php endif; ?>
				<?php if ( $show_tag && get_the_tags() ) : ?><li class="c-meta-box__item c-meta-box__item--tag"><?php echo get_the_tag_list( '', ', ', '' ); ?></li><?php endif; ?>
				<?php if ( $show_comment ) : ?><li class="c-meta-box__item c-meta-box__item--comment"><?php _e( 'Comments', 'tcd-w' ); ?>: <a href="#comment_headline"><?php echo get_comments_number( '0', '1', '%' ); ?></a></li><?php endif; ?>
			</ul>
<?php
		endif;
		if ( '5' !== $options['cta_display'] ) {
			get_template_part( 'template-parts/cta' );
		}
		if ( $options['show_next_post'] && ( $previous_post || $next_post ) ) : 
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
		if ( $show_comment ) {
			comments_template( '', true ); 
		} 
?>
		</div>				
<?php
	if ( $options['show_related_post'] ) :
?>
		<section class="l-inner">
			<h2 class="p-headline"><?php _e( 'Related posts', 'tcd-w' ); ?></h2>
			<div class="p-entry__related">
<?php
		if ( $the_query->have_posts() ) :
			while ( $the_query->have_posts() ) :
				$the_query->the_post();
?>
				<article class="p-entry__related-item p-article01">
    	  	<a class="p-article01__thumbnail p-hover-effect--<?php echo esc_attr( $options['hover_type'] ); ?>" href="<?php the_permalink(); ?>">
<?php
				if ( has_post_thumbnail() ) {
					the_post_thumbnail( 'size1' );
				} else {
					echo '<img src="' . get_template_directory_uri() . '/img/no-image-360x180.gif" alt="">' . "\n";
				}
?>
					</a>
    	   	<h3 class="p-article01__title"><a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 30, '...' ); ?></a></h3>
    	  	<p class="p-article01__meta"><?php if ( $show_date ) : ?><time class="p-article01__date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time><?php endif; ?><?php if ( $show_category ) : ?><span class="p-article01__category"><?php the_category( ', ' ); ?></span><?php endif; ?></p>
    		</article>
<?php
			wp_reset_postdata();
			endwhile;
		else :
			echo '<p>' . __( 'No related posts.', 'tcd-w' ) . '</p>';
		endif;
?>
			</div>
		</section>
<?php
	endif;
?>
	</article>
<?php
	endwhile;
endif;
?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
