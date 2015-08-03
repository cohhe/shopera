<?php
/**
 * The template for displaying featured content
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */
?>

<div class="featured-slider">
	<div id="featured-content" class="featured-content swiper-container">
		<div class="featured-content-inner swiper-wrapper">
		<?php
			/**
			 * Fires before the Shopera 1.0 featured content.
			 *
			 * @since Shopera 1.0
			 */
			do_action( 'shopera_featured_posts_before' );

			$featured_posts = shopera_get_featured_posts();
			foreach ( (array) $featured_posts as $order => $post ) :
				setup_postdata( $post );

				 // Include the featured content template.
				get_template_part( 'content', 'featured-post' );
			endforeach;

			/**
			 * Fires after the Shopera 1.0 featured content.
			 *
			 * @since Shopera 1.0
			 */
			do_action( 'shopera_featured_posts_after' );

			wp_reset_postdata();
		?>
		</div><!-- .featured-content-inner -->
	</div><!-- #featured-content .featured-content -->
	<div class="featured-content-side">
	<?php
		/**
		 * Fires before the Shopera 1.0 featured content.
		 *
		 * @since Shopera 1.0
		 */
		do_action( 'shopera_featured_posts_before' );

		$featured_posts = shopera_get_featured_side_posts();
		foreach ( (array) $featured_posts as $order => $post ) :
			setup_postdata( $post );

			 // Include the featured content template.
			get_template_part( 'content', 'featured-side-post' );
		endforeach;

		/**
		 * Fires after the Shopera 1.0 featured content.
		 *
		 * @since Shopera 1.0
		 */
		do_action( 'shopera_featured_posts_after' );

		wp_reset_postdata();
	?>
	</div>
</div><!-- .featured-slider -->