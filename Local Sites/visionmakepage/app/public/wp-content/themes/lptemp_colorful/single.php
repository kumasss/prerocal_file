<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 global $post;

$theme_options = get_theme_options();
get_header();
?>

<?php if( get_field('post_layout', $post->ID) == 1 ) : ?>
	<div id="primary" class="site-content">
<?php else : ?>
	<?php if( $theme_options['sidebar'] === 'right' ) : ?>
	<div class="sidebar-right">
	<?php else : ?>
	<div class="sidebar-left">
	<?php endif; ?>
	<div id="primary" class="site-content two-column">
<?php endif; ?>

		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', get_post_format() ); ?>

				<!--<nav class="nav-single">
					<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
					 <span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
				</nav> --> <!-- .nav-single -->

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php if( get_field('post_layout', $post->ID) != 1 ) { get_sidebar(); echo '</div>'; } ?>
<?php get_footer(); ?>