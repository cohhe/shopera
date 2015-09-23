<?php
/**
 * The Header for our theme
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>
<?php
global $shopera_site_width;

$form_class    = '';
$class         = '';
$shopera_site_width    = 'col-sm-12 col-md-12 col-lg-12';
$layout_type   = get_post_meta(get_the_id(), 'layouts', true);

if ( !isset($search_string) ) {
	$search_string = '';
}

if ( is_archive() || is_search() || is_404() ) {
	$layout_type = 'full';

} elseif (empty($layout_type)) {
	$layout_type = get_theme_mod('shopera_layout', 'full');
}

switch ($layout_type) {
	case 'right':
		define('SHOPERA_LAYOUT', 'sidebar-right');
		break;
	case 'full':
		define('SHOPERA_LAYOUT', 'sidebar-no');
		break;
	case 'left':
		define('SHOPERA_LAYOUT', 'sidebar-left');
		break;
}

if ( ( SHOPERA_LAYOUT == 'sidebar-left' && is_active_sidebar( 'sidebar-1' ) ) || ( SHOPERA_LAYOUT == 'sidebar-right' && is_active_sidebar( 'sidebar-2' ) ) ) {
	$shopera_site_width = 'col-sm-8 col-md-8 col-lg-8';
}
?>
<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
		<div class="header-content container">
			<div class="header-main row">
				<div class="site-title col-xs-3 col-sm-3 col-md-3">
					<?php
					$logo = get_theme_mod( 'shopera_logo' );
					if ( $logo ) { ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><img src="<?php echo esc_url( $logo ); ?>"></a>
					<?php
					} else { ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-title title-effect"><span data-letters="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></span></a>
					<?php
					}
					?>
				</div>
				<?php if ( class_exists( 'WooCommerce' ) ) { ?>
					<div class="cart-contents"></div>
				<?php } ?>
				<div class="header_search"><?php get_search_form(); ?></div>
				<?php if ( has_nav_menu( 'primary' ) ) { ?>
				<button type="button" class="navbar-toggle visible-xs visible-sm" data-toggle="collapse" data-target=".site-navigation">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>

				<nav id="primary-navigation" class="col-xs-12 col-sm-10 col-md-10 site-navigation primary-navigation navbar-collapse collapse" role="navigation">
					<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'menu_class'     => 'nav-menu',
								'depth'          => 3,
								'walker'         => new Shopera_Header_Menu_Walker
							)
						);
					?>
				</nav>
				<?php } ?>
			</div>
		</div>
		<div class="clearfix"></div>
	</header><!-- #masthead -->
	<?php
		$slider_state = get_theme_mod( 'shopera_main_slider', true );
		if ( is_front_page() && shopera_has_featured_posts() && $slider_state ) {
			// Include the featured content template.
			get_template_part( 'featured-content' );
		}
	?>
	<div id="main" class="site-main container">