<?php get_header(); 

if ( get_option( 'show_on_front' ) == 'page' ) {
	include( get_page_template() );
} elseif ( get_option( 'show_on_front' ) == 'posts' && get_theme_mod('shopera_demo_content', true) == false ) {
	get_template_part( 'index' );
} else { ?>

	<style type="text/css">
		body .container ul.products li.product { float: left; }
		body.post-grid #primary { padding: 0 15px; }
		.woocommerce ul.products li.product h3 { margin: 16px 0 0 0; }
		.slider .featured-slider { padding-bottom: 0; }
		.woocommerce ul.products li.product a { font-family: 'Roboto Condensed'; }
		.container .woocommerce ul.products li.product .price ins, body.woocommerce-page ul.products li.product .price ins { background: transparent; }
		.woocommerce ul.products li.product .product-image span.onsale, .woocommerce-page ul.products li.product .product-image span.onsale { color: #fff; text-align: center; font-weight: 700; }
		body.post-grid .entry-content p { min-height: auto; }
	</style>
	<script type="text/javascript">
		jQuery(window).load(function($) {
			if ( jQuery('.testimonial-container').length ) {
				jQuery('.testimonial-container').css({'left': '-'+jQuery('.entry-content').offset().left+'px'});
			};
		});
	</script>
	<div id="main-content" class="main-content row">
		<div id="primary" class="content-area col-sm-12 col-md-12 col-lg-12">
			<div id="content" class="site-content" role="main">
				<article id="post-67" class="post-67 page type-page status-publish hentry" style="position: absolute; left: 0px; top: 0px;">
					<div class="entry-content">
						<?php
							// Load woocommerce items
							get_template_part( 'demo-content/woocommerce' );

							// Load testimonials
							get_template_part( 'demo-content/testimonial' );

							// Load categories
							get_template_part( 'demo-content/categories' );

							// Load brands slider
							get_template_part( 'demo-content/brands' );
						?>
					</div> 
				</article> 
			</div> 
		</div> 
	</div>

<?php
}

get_footer(); ?>