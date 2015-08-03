<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x(  __( 'Search...', 'shopera' ), 'placeholder', 'shopera' ); ?>" value="<?php echo get_search_query( __( 'Search...', 'shopera' ) ); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'shopera' ); ?>" />
	<?php
	if ( !defined('ICL_LANGUAGE_CODE') ) {
		define('ICL_LANGUAGE_CODE', '');
	}
	?>
	<input type="hidden" name="lang" value="<?php echo esc_attr(ICL_LANGUAGE_CODE); ?>"/>
	<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'shopera' ); ?>" />
</form>
<span class="search-form-submit glyphicon glyphicon-search"></span>