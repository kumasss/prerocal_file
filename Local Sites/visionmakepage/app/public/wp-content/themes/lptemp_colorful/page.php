<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 global $post;

$theme_options = get_theme_options();
get_header();
?>
<?php if( get_field('free', $post->ID) ) { the_field('free', $post->ID); } ?>

<?php if( get_field('page_layout', $post->ID) == 2 ) : ?>
	<?php if( $theme_options['sidebar'] === 'right' ) : ?>
	<div class="sidebar-right">
	<?php else : ?>
	<div class="sidebar-left">
	<?php endif; ?>
	<div id="primary" class="site-content two-column">
<?php else : ?>
	<div id="primary" class="site-content">
<?php endif; ?>

		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
				<?php /* comments_template( '', true ); */ ?>
			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php
if( !wp_is_mobile() && get_field('hoverwindow_text', $post->ID) ) {
	get_template_part('hover');
}
?>

<?php if( get_field('page_layout', $post->ID) == 2 ) { get_sidebar(); echo '</div>'; } ?>
<?php get_footer(); ?>