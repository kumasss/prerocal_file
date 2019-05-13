<?php
/**
 * カード型記事一覧テンプレート
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('card-type'); ?>>
		<a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'twentytwelve' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
		<?php if ( has_post_thumbnail() ): ?>
		<?php the_post_thumbnail('thumbnail'); ?>
		<?php else: ?>
		<div class="noimage" style="height:<?php echo get_option('thumbnail_size_h'); ?>px"><img src="<?php echo get_template_directory_uri(); ?>/images/no_image.png" alt=""></div>
		<?php endif; ?>

		<div class="card-content">
			<h1 class="entry-title"><?php the_title(); ?></h1> 
			<span class="date-link">
			<i class="icon-clock"></i>
			<?php printf( '<time class="entry-date" datetime="%1$s">%2$s</time>',
				esc_attr( get_the_date( 'c' ) ),
				esc_html( get_the_date() )
			); ?>
			</span><!-- .date-link -->
			<span class="category-link">
			<i class="icon-folder"></i>
			<?php $cat = get_the_category(); $cat = $cat[0]; { echo $cat->cat_name; } ?>
			</span><!-- .category-link -->
			<p class="card-text"><?php echo strip_tags(get_the_content()); ?>続きを読む</p>
		</div>
		</a>
	</article><!-- #post -->
