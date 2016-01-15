<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */
?>

		</div><!-- #main -->

		<div class="site-footer-wrapper">
			<div class="site-footer-container container">
				<footer id="colophon" class="site-footer row" role="contentinfo">
					<?php
						if ( is_null(get_sidebar( 'footer' )) && get_option( 'show_on_front' ) != 'page' ) {
							get_template_part( 'demo-content/footer' );
						} else {
							get_sidebar( 'footer' );
						}
					?>
				</footer><!-- #colophon -->
				<div class="clearfix"></div>
			</div>
			<div class="site-info col-sm-12 col-md-12 col-lg-12">
				<div class="site-info-content container">
					<div class="copyright">
						<?php
							$copyright = get_theme_mod( 'shopera_copyright' );
							if ( $copyright ) {
								echo sanitize_text_field( $copyright );
							}
						?> 
						<?php _e( 'Created by', 'shopera' ); ?> <a href="https://cohhe.com/"><?php _e( 'Cohhe', 'shopera' ); ?></a>. 
						<?php _e( 'Proudly powered by', 'shopera' ); ?> <a href="<?php echo esc_url( 'http://wordpress.org/' ); ?>"><?php _e( 'WordPress', 'shopera' ); ?></a>
					</div>
					<?php 
						$show_scroll_to_top = get_theme_mod( 'shopera_scrolltotop' );

						if ( $show_scroll_to_top ) { ?>
							<a class="scroll-to-top" href="#"><?php _e( 'Up', 'shopera' ); ?></a>
						<?php
						}
					?>
				</div>
			</div><!-- .site-info -->
		</div>
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>