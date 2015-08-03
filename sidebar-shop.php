<?php
/**
 * The Shop Sidebar
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */

if ( is_active_sidebar( 'sidebar-6' ) && ( is_shop() || is_product_category() ) ) {
?>
<div id="shop-sidebar" class="shop-sidebar widget-area col-sm-3 col-md-3 col-lg-3" role="complementary">
	<?php dynamic_sidebar( 'sidebar-6' ); ?>
</div><!-- #content-sidebar -->
<?php
}