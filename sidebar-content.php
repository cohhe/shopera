<?php
/**
 * The Content Sidebar
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */

if ( SHOPERA_LAYOUT == 'sidebar-right' && is_active_sidebar( 'sidebar-2' ) ) {
?>
<div id="secondary" class="content-sidebar widget-area col-sm-4 col-md-4 col-lg-4">
	<div id="content-sidebar" class="content-sidebar widget-area" role="complementary">
		<?php dynamic_sidebar( 'sidebar-2' ); ?>
	</div><!-- #content-sidebar -->
</div>
<?php
}