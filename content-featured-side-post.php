<?php
/**
 * The template for displaying featured posts on the front page
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('swiper-slide side'); ?>>
	<div class="slide-inner">
		<?php
			// Output the featured image.
			if ( has_post_thumbnail() ) :
				if ( 'grid' == get_theme_mod( 'featured_content_layout' ) ) { ?>
					<a class="post-thumbnail" href="<?php the_permalink(); ?>"><?php the_post_thumbnail(); ?></a>
				<?php
				} else {
					$slide_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'shopera-post-picture' ); ?>
					<div class="slide-image" style="background-image:url('<?php echo esc_url( $slide_image_url[0] ); ?>');"></div>
					<?php
				}
			endif;
		?>
		<div class="slider-text-content">
			<header class="entry-header">
				<?php
					$external_url = get_post_meta(get_the_ID(), 'shopera_external_url', true);
					if ( !$external_url ) {
						$post_link = get_permalink();
					} else {
						$post_link = $external_url;
					}
				?>
				<?php the_title( '<h1 class="entry-title"><a href="' . esc_url( $post_link ) . '" rel="bookmark">','</a></h1>' ); ?>
				<div class="clearfix"></div>
			</header><!-- .entry-header -->
			<div class="slider-content">
				<?php the_excerpt(); ?>
				<div class="clearfix"></div>
			</div>
		</div>
		<!-- <a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" class="featured-side"></a> -->
	</div>
</div><!-- #post-## -->
