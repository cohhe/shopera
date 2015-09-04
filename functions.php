<?php
/**
 * Shopera 1.0 functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */

/**
 * Set up the content width value based on the theme's design.
 *
 * @see shopera_content_width()
 *
 * @since Shopera 1.0
 */
if ( ! isset( $content_width ) ) {
	$content_width = 680;
}

if ( ! function_exists( 'shopera_setup' ) ) :
/**
 * Shopera 1.0 setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since Shopera 1.0
 */
function shopera_setup() {
	require(get_template_directory() . '/inc/metaboxes/layouts.php');

	// TGM plugins activation
	require_once(get_template_directory() . '/inc/tgm-activation/class-tgm-plugin-activation.php');

	/*
	 * Make Shopera 1.0 available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Shopera 1.0, use a find and
	 * replace to change 'shopera' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'shopera', get_template_directory() . '/languages' );

	// This theme styles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css' ) );

	// Add RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// Enable support for Post Thumbnails, and declare two sizes.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 672, 372, true );
	add_image_size( 'shopera-full-width', 1170, 600, true );
	add_image_size( 'shopera-huge-width', 1800, 600, true );
	add_image_size( 'shopera-cart-item', 46, 46, true );
	add_image_size( 'shopera-brand-image', 170, 110, true );
	add_image_size( 'shopera-post-picture', 400, 260, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'   => __( 'Top primary menu', 'shopera' )
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'audio', 'quote', 'link', 'gallery',
	) );

	// This theme allows users to set a custom background.
	add_theme_support( 'custom-background', apply_filters( 'shopera_custom_background_args', array(
		'default-color' => 'f5f5f5',
	) ) );

	// Add support for featured content.
	add_theme_support( 'featured-content', array(
		'featured_content_filter' => 'shopera_get_featured_posts',
		'max_posts' => 6,
	) );

	add_theme_support( 'featured-content-side', array(
		'featured_content_filter' => 'shopera_get_featured_side_posts',
		'max_posts' => 5,
	) );

	add_theme_support( 'title-tag' );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );

	// Add support for featured content.
	// add_theme_support( 'featured-content', array(
	// 	'featured_content_filter' => 'shopera_get_featured_posts',
	// 	'max_posts' => 6,
	// ) );
}
endif; // shopera_setup
add_action( 'after_setup_theme', 'shopera_setup' );

/**
 * Adjust content_width value for image attachment template.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_content_width() {
	if ( is_attachment() && wp_attachment_is_image() ) {
		$GLOBALS['content_width'] = 810;
	}
}
add_action( 'template_redirect', 'shopera_content_width' );

/**
 * Getter function for Featured Content Plugin.
 *
 * @since Shopera 1.0
 *
 * @return array An array of WP_Post objects.
 */
function shopera_get_featured_posts() {
	/**
	 * Filter the featured posts to return in Shopera 1.0.
	 *
	 * @since Shopera 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'shopera_get_featured_posts', array() );
}

function shopera_get_featured_side_posts() {
	/**
	 * Filter the featured posts to return in Shopera 1.0.
	 *
	 * @since Shopera 1.0
	 *
	 * @param array|bool $posts Array of featured posts, otherwise false.
	 */
	return apply_filters( 'shopera_get_featured_side_posts', array() );
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Shopera 1.0
 *
 * @return bool Whether there are featured posts.
 */
function shopera_has_featured_posts() {
	return ! is_paged() && (bool) shopera_get_featured_posts();
}

function shopera_has_featured_side_posts() {
	return ! is_paged() && (bool) shopera_get_featured_side_posts();
}

/**
 * A helper conditional function that returns a boolean value.
 *
 * @since Shopera 1.0
 *
 * @return bool Whether there are featured posts.
 */
add_filter('add_to_cart_fragments', 'shopera_woocommerce_header_add_to_cart_fragment');
function shopera_woocommerce_header_add_to_cart_fragment( $fragments ) {
	global $woocommerce;
	
	ob_start();
	
	?>
	<div class="cart-contents">
		<span class="cart-items glyphicon glyphicon-shopping-cart"><span>
		<span class="cart-items-total"><?php echo $woocommerce->cart->cart_contents_count?></span>
		<div class="cart-content-list">
			<?php
				$cart_items = $woocommerce->cart->cart_contents;
				foreach ($cart_items as $cart_value) {
					$price = get_post_meta( $cart_value['product_id'], '_regular_price', true);

					switch( get_option( 'woocommerce_currency_pos' ) ) {
						case 'right':
							$item_price = $cart_value['line_subtotal'].get_woocommerce_currency_symbol();
							$total_item_price = $price.get_woocommerce_currency_symbol();
							$cart_subtotal = $woocommerce->cart->cart_contents_total.get_woocommerce_currency_symbol();
							break;
						case 'right_space':
							$item_price = $cart_value['line_subtotal'].' '.get_woocommerce_currency_symbol();
							$total_item_price = $price.' '.get_woocommerce_currency_symbol();
							$cart_subtotal = $woocommerce->cart->cart_contents_total.' '.get_woocommerce_currency_symbol();
							break;
						case 'left':
							$item_price = get_woocommerce_currency_symbol().$cart_value['line_subtotal'];
							$total_item_price = get_woocommerce_currency_symbol().$price;
							$cart_subtotal = get_woocommerce_currency_symbol() . $woocommerce->cart->cart_contents_total;
							break;
						case 'left_space':
							$item_price = get_woocommerce_currency_symbol().' '.$cart_value['line_subtotal'];
							$total_item_price = get_woocommerce_currency_symbol().' '.$price;
							$cart_subtotal = get_woocommerce_currency_symbol().' '.$woocommerce->cart->cart_contents_total;
							break;
						default:
							$item_price = get_woocommerce_currency_symbol().$cart_value['line_subtotal'];
							$total_item_price = get_woocommerce_currency_symbol().$price;
							$cart_subtotal = get_woocommerce_currency_symbol() . $woocommerce->cart->cart_contents_total;
							break;
					}

					echo '<div class="cart-list-item">';
						echo get_the_post_thumbnail($cart_value['data']->id, 'shopera-cart-item');
						echo '<div class="product-info">';
							echo '<span class="cart-item-title">'.$cart_value['data']->post->post_title.'</span>';
							echo '<span class="quantity">'.$cart_value['quantity'].' x <span>'.$item_price.'</span></span>';
						echo '</div>';
						echo '<span class="cart-item-price">'.$total_item_price.'</span>';
						echo '<div class="clearfix"></div>';
					echo '</div>';
				}
			?>
			<div class="cart-lower">
				<?php 
				if ( sizeof( $woocommerce->cart->cart_contents) > 0 ) { ?>
				<a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="button left" title="<?php _e( 'Checkout', 'shopera' ) ?>"><?php _e( 'Checkout', 'shopera' ) ?></a>
				<a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" class="button right"><?php _e( 'View Cart', 'shopera' ); ?></a>
				
				<span class="subtotal">
					<?php
					echo __('Subtotal:', 'shopera'). ' <span>' . $cart_subtotal .'</span>';
					?>
				</span>
				<div class="clearfix"></div>
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
	
	$fragments['div.cart-contents'] = ob_get_clean();
	
	return $fragments;
}

/**
 * Register three Shopera 1.0 widget areas.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Primary Sidebar', 'shopera' ),
		'id'            => 'sidebar-1',
		'class'			=> 'col-sm-4 col-md-4 col-lg-4',
		'description'   => __( 'Main sidebar that appears on the left.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Content Sidebar', 'shopera' ),
		'id'            => 'sidebar-2',
		'class'			=> 'col-sm-4 col-md-4 col-lg-4',
		'description'   => __( 'Additional sidebar that appears on the right.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Shop Sidebar', 'shopera' ),
		'id'            => 'sidebar-6',
		'class'			=> 'col-sm-4 col-md-4 col-lg-4',
		'description'   => __( 'Additional sidebar that appears on the right.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 1', 'shopera' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Appears in the footer section of the site.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 2', 'shopera' ),
		'id'            => 'sidebar-4',
		'description'   => __( 'Appears in the footer section of the site.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Widget Area 3', 'shopera' ),
		'id'            => 'sidebar-5',
		'description'   => __( 'Appears in the footer section of the site.', 'shopera' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<div class="divider"><h3 class="widget-title">',
		'after_title'   => '</h3><div class="separator"></div></div>',
	) );
}
add_action( 'widgets_init', 'shopera_widgets_init' );

/**
 * Register Google fonts for Shopera 1.0.
 *
 * @since Shopera 1.0
 *
 * @return string
 */
function shopera_font_url() {
	$fonts_url        = '';
	$roboto           = get_theme_mod('shopera_roboto', true);
	$roboto_slab      = get_theme_mod('shopera_roboto_slab', true);
	$roboto_condensed = get_theme_mod('shopera_roboto_condensed', true);
	$open_sans        = get_theme_mod('shopera_opensans', true);
	$satisfy          = get_theme_mod('shopera_satisfy', true);

	$font_families = array();
	
	if ( $roboto ) {
		$font_families[] = 'Raleway:400,100,300,700,900';
	}

	if ( $roboto_slab ) {
		$font_families[] = 'Raleway+Slab:400,100,300,700';
	}

	if ( $roboto_condensed ) {
		$font_families[] = 'Roboto Condensed:400,100,300,700,900';
	}

	if ( $open_sans ) {
		$font_families[] = 'Open+Sans:400,300,700';
	}

	if ( $satisfy ) {
		$font_families[] = 'Satisfy:400,100,300,700,900';
	}

	if ( !empty($font_families) ) {

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin' ),
		);

		$fonts_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $fonts_url;
}

function shopera_woocommerce_output_related_products() {

	$args = array(
		'posts_per_page' => 4,
		'columns' => 4,
		'orderby' => 'rand'
	);

	woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );
}

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', 11 );

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
add_action( 'woocommerce_after_single_product_sidebar', 'shopera_woocommerce_output_related_products', 20 );

remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

/**
 * Enqueue scripts and styles for the front end.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_scripts() {

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array() );

	// Add Google fonts
	// wp_register_style('googleFonts');
	wp_enqueue_style( 'googleFonts', shopera_font_url());

	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'genericons', get_template_directory_uri() . '/genericons/genericons.css', array(), '3.0.2' );

	// Load our main stylesheet.
	wp_enqueue_style( 'shopera-style', get_stylesheet_uri(), array( 'genericons' ) );

	wp_enqueue_style( 'shopera-responsiveness', get_template_directory_uri() . '/css/responsive.css', array(), '3.0.2' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'shopera-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20130402' );
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		wp_enqueue_script( 'jquery-masonry' );
	}

	if ( is_front_page() ) {
		wp_enqueue_script( 'shopera-slider', get_template_directory_uri() . '/js/slider.js', array( 'jquery' ), '20131205', true );
	}

	wp_enqueue_script( 'shopera-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20131209', true );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '20131209', true );
	wp_enqueue_script( 'jcarousel', get_template_directory_uri() . '/js/jquery.jcarousel.pack.js', array( 'jquery' ), '20131209', true );

	wp_enqueue_style( 'animate', get_template_directory_uri() . '/css/animate.min.css', array() );

	wp_enqueue_script( 'html5shiv', get_template_directory_uri() . '/js/html5.js', array(), '', false );

	wp_enqueue_script( 'isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', array(), '', false );

	$shop_breadcrumb_img = get_theme_mod('shopera_shop_breadcrumbs', get_template_directory_uri().'/images/breadcrumbs.jpg');
	if ( $shop_breadcrumb_img ) {
		wp_add_inline_style( 'shopera-style', '.woocommerce-breadcrumb { background-image: url('.$shop_breadcrumb_img.'); }' );
	}
}
add_action( 'wp_enqueue_scripts', 'shopera_scripts' );

add_filter( 'script_loader_tag', function( $tag, $handle ) {
	if ( $handle === 'html5shiv' ) {
		$tag = "<!--[if lt IE 9]>$tag<![endif]-->";
	}
	return $tag;
}, 10, 2 );

if ( ( $GLOBALS['pagenow'] == 'post.php' || $GLOBALS['pagenow'] == 'post-new.php' ) && is_admin() ) {
	// Admin Javascript
	function shopera_admin_scripts() {
		wp_register_script('master', get_template_directory_uri() . '/inc/js/admin-master.js', array('jquery'));
		wp_enqueue_script('master');
	}
	add_action( 'admin_enqueue_scripts', 'shopera_admin_scripts' );

	// Admin CSS
	function shopera_admin_css() {
		wp_enqueue_style( 'admin-css', get_template_directory_uri() . '/css/wp-admin.css' );
	}
	add_action('admin_head','shopera_admin_css');
}

if ( ! function_exists( 'shopera_the_attached_image' ) ) :
/**
 * Print the attached image with a link to the next attached image.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_the_attached_image() {
	$post                = get_post();
	/**
	 * Filter the default Shopera 1.0 attachment size.
	 *
	 * @since Shopera 1.0
	 *
	 * @param array $dimensions {
	 *     An array of height and width dimensions.
	 *
	 *     @type int $height Height of the image in pixels. Default 810.
	 *     @type int $width  Width of the image in pixels. Default 810.
	 * }
	 */
	$attachment_size     = apply_filters( 'shopera_attachment_size', array( 810, 810 ) );
	$next_attachment_url = wp_get_attachment_url();

	/*
	 * Grab the IDs of all the image attachments in a gallery so we can get the URL
	 * of the next adjacent image in a gallery, or the first image (if we're
	 * looking at the last image in a gallery), or, in a gallery of one, just the
	 * link to that image file.
	 */
	$attachment_ids = get_posts( array(
		'post_parent'    => $post->post_parent,
		'fields'         => 'ids',
		'numberposts'    => -1,
		'post_status'    => 'inherit',
		'post_type'      => 'attachment',
		'post_mime_type' => 'image',
		'order'          => 'ASC',
		'orderby'        => 'menu_order ID',
	) );

	// If there is more than 1 attachment in a gallery...
	if ( count( $attachment_ids ) > 1 ) {
		foreach ( $attachment_ids as $attachment_id ) {
			if ( $attachment_id == $post->ID ) {
				$next_id = current( $attachment_ids );
				break;
			}
		}

		// get the URL of the next image attachment...
		if ( $next_id ) {
			$next_attachment_url = get_attachment_link( $next_id );
		}

		// or get the URL of the first image attachment.
		else {
			$next_attachment_url = get_attachment_link( array_shift( $attachment_ids ) );
		}
	}

	printf( '<a href="%1$s" rel="attachment">%2$s</a>',
		esc_url( $next_attachment_url ),
		wp_get_attachment_image( $post->ID, $attachment_size )
	);
}
endif;

/**
 * Extend the default WordPress body classes.
 *
 * Adds body classes to denote:
 * 1. Single or multiple authors.
 * 2. Presence of header image.
 * 3. Index views.
 * 5. Presence of footer widgets.
 * 6. Single views.
 * 7. Featured content layout.
 *
 * @since Shopera 1.0
 *
 * @param array $classes A list of existing body class values.
 * @return array The filtered body class list.
 */
function shopera_body_classes( $classes ) {
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( is_archive() || is_search() || is_home() ) {
		$classes[] = 'list-view';
	}

	if ( is_active_sidebar( 'sidebar-3' ) ) {
		$classes[] = 'footer-widgets';
	}

	if ( is_singular() && ! is_front_page() ) {
		$classes[] = 'singular';
	}

	if ( is_front_page() ) {
		$classes[] = 'slider';
	} elseif ( is_front_page() ) {
		$classes[] = 'grid';
	}

	$post_grid = get_theme_mod( 'shopera_post_grid', true );
	if ( ( is_archive() || is_search() || is_home() ) && ( $post_grid && !is_single() ) ) {
		$classes[] = 'post-grid';
	}

	$slider_status = get_theme_mod('shopera_main_slider', true);
	if ( $slider_status == false ) {
		$classes[] = 'slider-off';
	}

	return $classes;
}
add_filter( 'body_class', 'shopera_body_classes' );

function shopera_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'shopera' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'shopera' ), '<span class="edit-link button blue">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 60;
						echo get_avatar( $comment, $avatar_size );							
					?>
				</div><!-- .comment-author .vcard -->
			</div>

			<div class="comment-content">
				<?php
					echo '<a href="'.get_author_posts_url($comment->user_id).'" class="fn">' . get_comment_author_link() . '</a>';
					echo '<div class="reply-edit-container">';
					echo '<span class="comment-time">'.get_comment_time("F d, Y g:i a").'</span>';
				?>
					<span class="reply">
						<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'shopera' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
					</span><!-- end of reply -->
					<?php edit_comment_link( __( 'Edit', 'shopera' ), '<span class="edit-link button blue">', '</span>' ); ?>
					<div class="clearfix"></div>
				</div>
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'shopera' ); ?></em>
				<?php endif; ?>
				<?php comment_text(); ?>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div><!-- end of comment -->

	<?php
			break;
	endswitch;
}

// custom comment fields
function shopera_custom_comment_fields($fields) {
	global $post, $commenter;

	$url_status = get_theme_mod('shopera_commenturl');

	$fields['author'] = '<div class="comment_auth_email"><p class="comment-form-author">
							<span class="input-label">' . __( 'Name', 'shopera' ) . '</span>
							<input id="author" name="author" type="text" class="span4" value="' . esc_attr( $commenter['comment_author'] ) . '" aria-required="true" size="30" />
						 </p>';

	$fields['email'] = '<p class="comment-form-email">
							<span class="input-label">' . __( 'Email', 'shopera' ) . '</span>
							<input id="email" name="email" type="text" class="span4" value="' . esc_attr( $commenter['comment_author_email'] ) . '" aria-required="true" size="30" />
						</p><div class="clearfix"></div></div>';

	$url_field = '<p class="comment-form-url">
						<span class="input-label">' . __( 'Website', 'shopera' ) . '</span>
						<input id="url" name="url" type="text" class="span4" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" />
					</p>';


	$fields = array( $fields['author'], $fields['email'] );

	if ( $url_status == false ) {
		$fields[] = $url_field;
	}

	return $fields;
}
add_filter( 'comment_form_default_fields', 'shopera_custom_comment_fields' );

function shopera_woo_edit_before_shop_page() {
	if ( is_active_sidebar( 'sidebar-6' ) ) {
		$extra = ' col-sm-9 col-md-9 col-lg-9';
	} else {
		$extra = '';
	}
	echo '<div class="woo-shop-page'.$extra.'">';
}
add_action( 'woocommerce_before_shop_loop', 'shopera_woo_edit_before_shop_page' );

function shopera_woo_edit_after_shop_page() {
	echo '</div>';
	echo get_sidebar( 'shop' );
}
add_action( 'woocommerce_after_shop_loop', 'shopera_woo_edit_after_shop_page' );

add_filter( 'loop_shop_per_page', create_function( '$cols', 'return 12;' ), 20 );

/**
 * Extend the default WordPress post classes.
 *
 * Adds a post class to denote:
 * Non-password protected page with a post thumbnail.
 *
 * @since Shopera 1.0
 *
 * @param array $classes A list of existing post class values.
 * @return array The filtered post class list.
 */
function shopera_post_classes( $classes ) {
	if ( ! post_password_required() && has_post_thumbnail() ) {
		$classes[] = 'has-post-thumbnail';
	}

	return $classes;
}
add_filter( 'post_class', 'shopera_post_classes' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Shopera 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function shopera_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'shopera' ), max( $paged, $page ) );
	}

	return $title;
}
add_filter( 'wp_title', 'shopera_wp_title', 10, 2 );

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Add Theme Customizer functionality.
require get_template_directory() . '/inc/customizer.php';

/*
 * Add Featured Content functionality.
 *
 * To overwrite in a plugin, define your own Featured_Content class on or
 * before the 'setup_theme' hook.
 */
if ( ! class_exists( 'Shopera_Featured_Content' ) ) {
	require get_template_directory() . '/inc/featured-content.php';
}

if ( ! class_exists( 'Shopera_Featured_Content_Side' ) ) {
	require get_template_directory() . '/inc/featured-content-side.php';
}

/**
 * Create HTML list of nav menu items.
 * Replacement for the native Walker, using the description.
 *
 * @see    http://wordpress.stackexchange.com/q/14037/
 * @author toscho, http://toscho.de
 */
class Shopera_Header_Menu_Walker extends Walker_Nav_Menu {

	/**
	 * Start the element output.
	 *
	 * @param  string $output Passed by reference. Used to append additional content.
	 * @param  object $item   Menu item data object.
	 * @param  int $depth     Depth of menu item. May be used for padding.
	 * @param  array $args    Additional strings.
	 * @return void
	 */
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$classes         = empty ( $item->classes ) ? array () : (array) $item->classes;
		$has_description = '';

		$class_names = join(
			' '
		,   apply_filters(
				'nav_menu_css_class'
			,   array_filter( $classes ), $item
			)
		);

		// insert description for top level elements only
		// you may change this
		$description = ( ! empty ( $item->description ) )
			? '<small>' . esc_attr( $item->description ) . '</small>' : '';

		$has_description = ( ! empty ( $item->description ) )
			? 'has-description ' : '';

		! empty ( $class_names )
			and $class_names = ' class="' . $has_description . esc_attr( $class_names ) . '"';

		$output .= "<li id='menu-item-$item->ID' $class_names>";

		$attributes  = '';

		if ( !isset($item->target) ) {
			$item->target = '';
		}

		if ( !isset($item->attr_title) ) {
			$item->attr_title = '';
		}

		if ( !isset($item->xfn) ) {
			$item->xfn = '';
		}

		if ( !isset($item->url) ) {
			$item->url = '';
		}

		if ( !isset($item->title) ) {
			$item->title = '';
		}

		if ( !isset($item->ID) ) {
			$item->ID = '';
		}

		if ( !isset($args->link_before) ) {
			$args = new stdClass();
			$args->link_before = '';
		}

		if ( !isset($args->before) ) {
			$args->before = '';
		}

		if ( !isset($args->link_after) ) {
			$args->link_after = '';
		}

		if ( !isset($args->after) ) {
			$args->after = '';
		}

		! empty( $item->attr_title )
			and $attributes .= ' title="'  . esc_attr( $item->attr_title ) .'"';
		! empty( $item->target )
			and $attributes .= ' target="' . esc_attr( $item->target     ) .'"';
		! empty( $item->xfn )
			and $attributes .= ' rel="'    . esc_attr( $item->xfn        ) .'"';
		! empty( $item->url )
			and $attributes .= ' href="'   . esc_attr( $item->url        ) .'"';

		$title = apply_filters( 'the_title', $item->title, $item->ID );

		$item_output = $args->before
			. "<a $attributes>"
			. $args->link_before
			. '<span>' . $title . '</span>'
			. $description
			. '</a> '
			. $args->link_after
			. $args->after;

		// Since $output is called by reference we don't need to return anything.
		$output .= apply_filters(
			'walker_nav_menu_start_el'
		,   $item_output
		,   $item
		,   $depth
		,   $args
		);
	}
}

function shopera_favicon() {
	$favicon = get_theme_mod('shopera_favicon');
	if ( $favicon ) {
		echo '<link rel="shortcut icon" href="' . esc_url( $favicon ) . '" />';
	}
}
add_action('wp_head', 'shopera_favicon');

function shopera_woocommerce_support() {
	add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'shopera_woocommerce_support' );

function shopera_woocommerce_breadcrumbs( $defaults ) {

	$defaults['wrap_before'] = '<nav class="woocommerce-breadcrumb" itemprop="breadcrumb"><div class="woo-breadcrumb-content"><span class="product-category">' . __( 'Product', 'shopera' ) . '</span><div class="woo-breadcrumb-inner">';
	$defaults['wrap_after'] = '</div></div></nav>';

	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'shopera_woocommerce_breadcrumbs' );

function woo_archive_custom_cart_button_text() {
	 return '';
}
add_filter( 'woocommerce_product_add_to_cart_text', 'woo_archive_custom_cart_button_text' );

function shopera_logo_text_size() {
	$large_logo_font_size = get_theme_mod('shopera_logo_font_size', '50');
	$logo = get_theme_mod( 'shopera_logo' );

	if ( !$logo ) { ?>
		<style type="text/css">a.site-title { font-size: <?php echo esc_attr( $large_logo_font_size ).'px'; ?> }</style>
	<?php
	}
}
add_action('wp_head', 'shopera_logo_text_size');

function shopera_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		array(
			'name'     				=> 'Shopera Functionality', // The plugin name
			'slug'     				=> 'functionality-for-shopera-theme', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Tiled Galleries Carousel Without Jetpack', // The plugin name
			'slug'     				=> 'tiled-gallery-carousel-without-jetpack', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'WooCommerce', // The plugin name
			'slug'     				=> 'woocommerce', // The plugin slug (typically the folder name)
			'source'   				=> 'http://downloads.wordpress.org/plugin/woocommerce.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.3.13', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Bootstrap Shortcodes for WordPress', // The plugin name
			'slug'     				=> 'bootstrap-3-shortcodes', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '3.3.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Contact Form 7', // The plugin name
			'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '4.2.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Newsletter', // The plugin name
			'slug'     				=> 'newsletter', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '3.8.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Simple Share Buttons Adder', // The plugin name
			'slug'     				=> 'simple-share-buttons-adder', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '6.0.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Easy Testimonials', // The plugin name
			'slug'     				=> 'easy-testimonials', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.31.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'YITH WooCommerce Wishlist', // The plugin name
			'slug'     				=> 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.0.9', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'YITH WooCommerce Zoom Magnifier', // The plugin name
			'slug'     				=> 'yith-woocommerce-zoom-magnifier', // The plugin slug (typically the folder name)
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.2.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
		)
	);

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'domain'       		=> 'shopera',                   // Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_slug'     	=> 'themes.php', 				// The parent menu slug for the plugin install page
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
		'strings'      		=> array(
			'page_title'                       			=> __( 'Install Required Plugins', 'shopera' ),
			'menu_title'                       			=> __( 'Install Plugins', 'shopera' ),
			'installing'                       			=> __( 'Installing Plugin: %s', 'shopera' ), // %1$s = plugin name
			'oops'                             			=> __( 'Something went wrong with the plugin API.', 'shopera' ),
			'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.', 'shopera' ), // %1$s = plugin name(s)
			'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.', 'shopera' ), // %1$s = plugin name(s)
			'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.', 'shopera' ), // %1$s = plugin name(s)
			'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.', 'shopera' ), // %1$s = plugin name(s)
			'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.', 'shopera' ), // %1$s = plugin name(s)
			'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.', 'shopera' ), // %1$s = plugin name(s)
			'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.', 'shopera' ), // %1$s = plugin name(s)
			'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.', 'shopera' ), // %1$s = plugin name(s)
			'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins', 'shopera' ),
			'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins', 'shopera' ),
			'return'                           			=> __( 'Return to Required Plugins Installer', 'shopera' ),
			'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'shopera' ),
			'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'shopera' ), // %1$s = dashboard link
			'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
		)
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'shopera_register_required_plugins' );