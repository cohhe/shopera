<?php
/**
 * The Template for displaying all single posts
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */

get_header();

global $shopera_site_width;
?>

<div id="main-content" class="main-content row">
	<?php get_sidebar(); ?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content <?php echo esc_attr( $shopera_site_width ); ?>" role="main">
			<?php
				// Start the Loop.
				while ( have_posts() ) : the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_footer();
