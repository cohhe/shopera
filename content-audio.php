<?php
/**
 * The template for displaying posts in the Audio post format
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php
			if ( is_single() ) :
				the_title( '<h1 class="entry-title">', '</h1>' );
			endif;
			$post_grid = get_theme_mod( 'shopera_post_grid', true );

			if ( ( $post_grid && !is_single() ) && !is_search() ) {
				$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'shopera-post-picture');
			} else {
				$img = wp_get_attachment_image_src(get_post_thumbnail_id(), 'shopera-full-width');
			}
			
			if ( empty($img[0]) ) {
				$img[0] = get_template_directory_uri() . '/images/default-image.jpg';
			}

			if ( $post->post_type == 'post' ) {
				echo '<div class="content-image"><a href="'.esc_url( get_permalink() ).'" rel="bookmark"><img src="'.esc_url( $img[0] ).'" alt="post-img" class="post-inner-picture"></a></div>';
			}
		?>
		<div class="entry-meta">
			<?php if ( !is_single() ) { ?>
				<div class="entry-meta-left">
					<span class="date"><?php echo get_the_date('d', $post->ID); ?></span>
					<span class="month"><?php echo get_the_date('F', $post->ID); ?></span>
					<span class="year"><?php echo get_the_date('Y', $post->ID); ?></span>
				</div>
				<div class="entry-meta-right">
					<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark"><?php echo get_the_title(); ?></a>
					<span class="post-by"><?php echo __('by', 'shopera').' '; ?><a href="<?php echo get_author_posts_url( get_post_field( 'post_author', $post->id ) );?>"><?php echo get_userdata( get_post_field( 'post_author', $post->id ) )->display_name; ?></a></span>
				</div>
				<div class="clearfix"></div>
			<?php } else {
				$tc = wp_count_comments($post->ID); ?>
				<div class="entry-meta-full">
					<span class="post-author author vcard"><span class="glyphicon glyphicon-user"></span><?php echo __('by', 'shopera').' ';?><a href="<?php echo get_author_posts_url( get_post_field( 'post_author', $post->id ) );?>" class="fn"><?php echo get_userdata( get_post_field( 'post_author', $post->id ) )->display_name; ?></a></span>
					<?php
						$entry_utility_bottom = '';
						$categories_list = get_the_category_list( __( ', ', 'shopera' ) );
						if ( $categories_list ) {
							$entry_utility_bottom .= '
							<span class="post-category"><span class="glyphicon glyphicon-folder-open"></span>
							' . $categories_list;
							$show_sep = TRUE;
							$entry_utility_bottom .= '
							</span>';
						}
						$tags_list = get_the_tag_list( '', __( ', ', 'shopera' ) );
						if ( $tags_list ) {
							$entry_utility_bottom .= '
							<span class="post-category"><span class="glyphicon glyphicon-tag"></span>
							' . $tags_list;
							$show_sep = true;
							$entry_utility_bottom .= '
							</span>';
						}
						echo $entry_utility_bottom;
					?>
					<span class="post-comments"><span class="glyphicon glyphicon-comment"></span><?php echo $tc->total_comments.' '.__('Comments', 'shopera'); ?></span>
					<div class="post-share">
						<?php
							if ( defined('SSBA_VERSION') ) {
								echo do_shortcode('[ssba]');
							}
						?>
						<div class="clearfix"></div>
					</div>
					<div class="post-information" style="display: none;">
						<time class="published" datetime="<?php echo get_the_date( 'Y-d-m H:i:s' ); ?>"><?php echo get_the_date( 'Y-d-m H:i:s' ); ?></time>
						<time class="updated" datetime="<?php the_modified_date( 'Y-d-m H:i:s', '', '', true ); ?>"><?php the_modified_date( 'Y-d-m H:i:s', '', '', true ); ?></time>
					</div>
					<div class="clearfix"></div>
				</div>
			<?php } ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->
	<?php if ( is_search() ) : ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
		<?php
			$post_grid = get_theme_mod( 'shopera_post_grid', true );

			if( empty( get_the_excerpt() ) ) {
				$post_content = __( 'No excerpt for this post.', 'shopera' );
			} elseif ( $post_grid == false || is_single() ) {
				the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'shopera' ) );
			} else {
				if ( strlen( get_the_excerpt() ) > 140 ) {
					$post_content = substr(get_the_excerpt(), 0, 140) . '..';
				} else {
					$post_content = get_the_excerpt();
				}
				echo '<p>'.$post_content.'</p>';
			}
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'shopera' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
</article><!-- #post-## -->
