<?php
/**
 * Shopera 1.0 Theme Customizer support
 *
 * @package WordPress
 * @subpackage Shopera
 * @since Shopera 1.0
 */

/**
 * Implement Theme Customizer additions and adjustments.
 *
 * @since Shopera 1.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function shopera_customize_register( $wp_customize ) {
	// Add custom description to Colors and Background sections.
	$wp_customize->get_section( 'colors' )->description           = __( 'Background may only be visible on wide screens.', 'shopera' );
	$wp_customize->get_section( 'background_image' )->description = __( 'Background may only be visible on wide screens.', 'shopera' );

	// Add postMessage support for site title and description.
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	// Rename the label to "Site Title Color" because this only affects the site title in this theme.
	$wp_customize->get_control( 'header_textcolor' )->label = __( 'Site Title Color', 'shopera' );

	// Rename the label to "Display Site Title & Tagline" in order to make this option extra clear.
	$wp_customize->get_control( 'display_header_text' )->label = __( 'Display Site Title &amp; Tagline', 'shopera' );

	// Add the featured content section in case it's not already there.
	$wp_customize->add_section( 'featured_content', array(
		'title'       => __( 'Featured Content', 'shopera' ),
		'description' => sprintf( __( 'To feature your posts use <a href="%1$s">featured</a> tag or provide your own tag below. If no posts match the tag, <a href="%2$s">sticky posts</a> will be displayed instead.', 'shopera' ), admin_url( '/edit.php?tag=featured' ), admin_url( '/edit.php?show_sticky=1' ) ),
		'priority'    => 130,
	) );

	$wp_customize->add_section( 'featured_content_side', array(
		'title'       => __( 'Featured Side Content', 'shopera' ),
		'description' => sprintf( __( 'To feature your posts use <a href="%1$s">featured-side</a> tag or provide your own tag below. If no posts match the tag, <a href="%2$s">sticky posts</a> will be displayed instead.', 'shopera' ), admin_url( '/edit.php?tag=featured-side' ), admin_url( '/edit.php?show_sticky=1' ) ),
		'priority'    => 140,
	) );

	// Add General setting panel and configure settings inside it
	$wp_customize->add_panel( 'shopera_general_panel', array(
		'priority'       => 150,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'General settings' , 'shopera'),
		'description'    => __( 'You can configure your general theme settings here' , 'shopera')
	) );

	// Website logo
	$wp_customize->add_section( 'shopera_general_logo', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Website logo' , 'shopera'),
		'description'    => __( 'Please upload your logo, recommended logo size should be between 262x80' , 'shopera'),
		'panel'          => 'shopera_general_panel'
	) );

	$wp_customize->add_setting( 'shopera_logo', array( 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'shopera_logo', array(
		'label'    => __( 'Website logo', 'shopera' ),
		'section'  => 'shopera_general_logo',
		'settings' => 'shopera_logo',
	) ) );

	// woocommerce shop breadcrumb
	$wp_customize->add_section( 'shopera_general_shop_breadcrumb', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'WooCommerce shop breadcrumb' , 'shopera'),
		'description'    => __( 'Please upload your image for WooCommerce shop breadcrumbs.' , 'shopera'),
		'panel'          => 'shopera_general_panel'
	) );

	$wp_customize->add_setting( 'shopera_shop_breadcrumbs', array( 'default' => get_template_directory_uri().'/images/breadcrumbs.jpg', 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'shopera_shop_breadcrumbs', array(
		'label'    => __( 'WooCommerce shop breadcrumb', 'shopera' ),
		'section'  => 'shopera_general_shop_breadcrumb',
		'settings' => 'shopera_shop_breadcrumbs',
	) ) );

	// Copyright
	$wp_customize->add_section( 'shopera_general_copyright', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Copyright' , 'shopera'),
		'description'    => __( 'Please provide short copyright text which will be shown in footer.' , 'shopera'),
		'panel'          => 'shopera_general_panel'
	) );

	$wp_customize->add_setting( 'shopera_copyright', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'shopera_copyright',
		array(
			'label'      => 'Copyright',
			'section'    => 'shopera_general_copyright',
			'type'       => 'text',
		)
	);

	// Scroll to top
	$wp_customize->add_section( 'shopera_general_scrolltotop', array(
		'priority'       => 30,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Scroll to top' , 'shopera'),
		'description'    => __( 'Do you want to enable "Scroll to Top" button?' , 'shopera'),
		'panel'          => 'shopera_general_panel'
	) );

	$wp_customize->add_setting( 'shopera_scrolltotop', array( 'sanitize_callback' => 'shopera_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'shopera_scrolltotop',
		array(
			'label'      => 'Scroll to top',
			'section'    => 'shopera_general_scrolltotop',
			'type'       => 'checkbox',
		)
	);

	// Favicon
	$wp_customize->add_section( 'shopera_general_favicon', array(
		'priority'       => 40,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Favicon' , 'shopera'),
		'description'    => __( 'Do you have favicon? You can upload it here.' , 'shopera'),
		'panel'          => 'shopera_general_panel'
	) );

	$wp_customize->add_setting( 'shopera_favicon', array( 'sanitize_callback' => 'esc_url_raw' ) );

	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'shopera_favicon', array(
		'label'    => __( 'Favicon', 'shopera' ),
		'section'  => 'shopera_general_favicon',
		'settings' => 'shopera_favicon',
	) ) );

	// Comment form URL field
	$wp_customize->add_section( 'shopera_general_commenturl', array(
		'priority'       => 50,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Comment form URL field' , 'shopera'),
		'description'    => __( 'Do you want to disable comment URL field?' , 'shopera'),
		'panel'          => 'shopera_general_panel'
	) );

	$wp_customize->add_setting( 'shopera_commenturl', array( 'sanitize_callback' => 'shopera_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'shopera_commenturl',
		array(
			'label'      => 'Comment form URL field',
			'section'    => 'shopera_general_commenturl',
			'type'       => 'checkbox',
		)
	);

	// Slider settings
	$wp_customize->add_section( 'shopera_general_slider', array(
		'priority'       => 51,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Slider status' , 'shopera'),
		'description'    => __( 'Enable or disable the front page slider.' , 'shopera'),
		'panel'          => 'shopera_general_panel'
	) );

	$wp_customize->add_setting( 'shopera_main_slider', array( 'default' => '1', 'sanitize_callback' => 'shopera_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'shopera_main_slider',
		array(
			'label'      => 'Slider status',
			'section'    => 'shopera_general_slider',
			'type'       => 'checkbox',
		)
	);

	// Post grid settings
	$wp_customize->add_section( 'shopera_general_grid', array(
		'priority'       => 52,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Post grid status' , 'shopera'),
		'description'    => __( 'Do you want to display posts in a grid?' , 'shopera'),
		'panel'          => 'shopera_general_panel'
	) );

	$wp_customize->add_setting( 'shopera_post_grid', array( 'default' => '1', 'sanitize_callback' => 'shopera_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'shopera_post_grid',
		array(
			'label'      => 'Post grid status',
			'section'    => 'shopera_general_grid',
			'type'       => 'checkbox',
		)
	);

	// Page layout
	$wp_customize->add_section( 'shopera_general_layout', array(
		'priority'       => 60,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Layout' , 'shopera'),
		'description'    => __( 'Choose a layout for your theme pages. Note that a widget has to be inside widget are, or the layout won\'t change.' , 'shopera'),
		'panel'          => 'shopera_general_panel'
	) );

	$wp_customize->add_setting(
		'shopera_layout',
		array(
			'default'           => 'full',
			'sanitize_callback' => 'sanitize_text_field'
		)
	);

	$wp_customize->add_control(
		'shopera_layout',
		array(
			'type' => 'radio',
			'label' => 'Layout',
			'section' => 'shopera_general_layout',
			'choices' => array(
				'left' => 'Left',
				'full' => 'Full',
				'right' => 'Right'
			)
		)
	);

	// Demo content settings
	$wp_customize->add_section( 'shopera_general_demo', array(
		'priority'       => 61,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Demo content' , 'shopera'),
		'description'    => __( 'Demo content is going to be shown if this checkbox is checked and the front page is set to "Your latest posts"' , 'shopera'),
		'panel'          => 'shopera_general_panel'
	) );

	$wp_customize->add_setting( 'shopera_demo_content', array( 'default' => '1', 'sanitize_callback' => 'shopera_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'shopera_demo_content',
		array(
			'label'      => 'Show demo content',
			'section'    => 'shopera_general_demo',
			'type'       => 'checkbox',
		)
	);

	// Add Font setting panel and configure settings inside it
	$wp_customize->add_panel( 'shopera_font_panel', array(
		'priority'       => 160,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Font settings' , 'shopera'),
		'description'    => __( 'You can configure your themes font settings here, if there are characters in your language that are not supported by a particular font, disable it..' , 'shopera')
	) );

	// Fonts
	$wp_customize->add_section( 'shopera_fonts', array(
		'priority'       => 10,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Theme fonts' , 'shopera'),
		'description'    => __( 'If there are characters in your language that are not supported by any of these fonts, disable them.' , 'shopera'),
		'panel'          => 'shopera_font_panel'
	) );

	$wp_customize->add_setting( 'shopera_roboto', array( 'default' => '1', 'sanitize_callback' => 'shopera_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'shopera_roboto',
		array(
			'label'      => 'Roboto font',
			'section'    => 'shopera_fonts',
			'type'       => 'checkbox',
		)
	);

	$wp_customize->add_setting( 'shopera_roboto_slab', array( 'default' => '1', 'sanitize_callback' => 'shopera_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'shopera_roboto_slab',
		array(
			'label'      => 'Roboto Slab font',
			'section'    => 'shopera_fonts',
			'type'       => 'checkbox',
		)
	);

	$wp_customize->add_setting( 'shopera_roboto_condensed', array( 'default' => '1', 'sanitize_callback' => 'shopera_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'shopera_roboto_condensed',
		array(
			'label'      => 'Roboto font',
			'section'    => 'shopera_fonts',
			'type'       => 'checkbox',
		)
	);

	$wp_customize->add_setting( 'shopera_opensans', array( 'default' => '1', 'sanitize_callback' => 'shopera_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'shopera_opensans',
		array(
			'label'      => 'Open Sans font',
			'section'    => 'shopera_fonts',
			'type'       => 'checkbox',
		)
	);

	$wp_customize->add_setting( 'shopera_satisfy', array( 'default' => '1', 'sanitize_callback' => 'shopera_sanitize_checkbox' ) );

	$wp_customize->add_control(
		'shopera_satisfy',
		array(
			'label'      => 'Satisfy font',
			'section'    => 'shopera_fonts',
			'type'       => 'checkbox',
		)
	);

	// Font size
	$wp_customize->add_section( 'shopera_font_size', array(
		'priority'       => 20,
		'capability'     => 'edit_theme_options',
		'title'          => __( 'Font size' , 'shopera'),
		'description'    => __( 'You can change your websites main title size.' , 'shopera'),
		'panel'          => 'shopera_font_panel'
	) );

	$wp_customize->add_setting( 'shopera_logo_font_size', array( 'default' => '50', 'sanitize_callback' => 'absint' ) );

	$wp_customize->add_control(
		'shopera_logo_font_size',
		array(
			'label'      => 'Satisfy font',
			'section'    => 'shopera_font_size',
			'type'       => 'range',
			'input_attrs' => array(
				'min' => 10,
				'max' => 80,
				'step' => 2,
			)
		)
	);

	// Social links
	$wp_customize->add_section( new Shopera_Customized_Section( $wp_customize, 'shopera_social_links', array(
		'priority'       => 210,
		'capability'     => 'edit_theme_options'
		) )
	);

	$wp_customize->add_setting( 'shopera_fake_field', array( 'sanitize_callback' => 'sanitize_text_field' ) );

	$wp_customize->add_control(
		'shopera_fake_field',
		array(
			'label'      => '',
			'section'    => 'shopera_social_links',
			'type'       => 'text'
		)
	);

}
add_action( 'customize_register', 'shopera_customize_register' );

if ( class_exists( 'WP_Customize_Section' ) && !class_exists( 'Shopera_Customized_Section' ) ) {
	class Shopera_Customized_Section extends WP_Customize_Section {
		public function render() {
			$classes = 'accordion-section control-section control-section-' . $this->type;
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
				<style type="text/css">
					.cohhe-social-profiles {
						padding: 14px;
					}
					.cohhe-social-profiles li:last-child {
						display: none !important;
					}
					.cohhe-social-profiles li i {
						width: 20px;
						height: 20px;
						display: inline-block;
						background-size: cover !important;
						margin-right: 5px;
						float: left;
					}
					.cohhe-social-profiles li i.twitter {
						background: url(<?php echo get_template_directory_uri().'/images/icons/twitter.png'; ?>);
					}
					.cohhe-social-profiles li i.facebook {
						background: url(<?php echo get_template_directory_uri().'/images/icons/facebook.png'; ?>);
					}
					.cohhe-social-profiles li i.googleplus {
						background: url(<?php echo get_template_directory_uri().'/images/icons/googleplus.png'; ?>);
					}
					.cohhe-social-profiles li i.cohhe_logo {
						background: url(<?php echo get_template_directory_uri().'/images/icons/cohhe.png'; ?>);
					}
					.cohhe-social-profiles li a {
						height: 20px;
						line-height: 20px;
					}
					#customize-theme-controls>ul>#accordion-section-shopera_social_links {
						margin-top: 10px;
					}
					.cohhe-social-profiles li.documentation {
						text-align: right;
						margin-bottom: 10px;
					}
					.cohhe-social-profiles li.gopremium {
						text-align: right;
						margin-bottom: 60px;
					}
				</style>
				<ul class="cohhe-social-profiles">
					<li class="documentation"><a href="http://documentation.cohhe.com/shopera" class="button button-primary button-hero" target="_blank"><?php _e( 'Documentation', 'shopera' ); ?></a></li>
					<li class="gopremium"><a href="https://cohhe.com/project-view/shopera-pro/" class="button button-secondary button-hero" target="_blank"><?php _e( 'Go Premium', 'shopera' ); ?></a></li>
					<li class="social-twitter"><i class="twitter"></i><a href="https://twitter.com/Cohhe_Themes" target="_blank"><?php _e( 'Follow us on Twitter', 'shopera' ); ?></a></li>
					<li class="social-facebook"><i class="facebook"></i><a href="https://www.facebook.com/cohhethemes" target="_blank"><?php _e( 'Join us on Facebook', 'shopera' ); ?></a></li>
					<li class="social-googleplus"><i class="googleplus"></i><a href="https://plus.google.com/+Cohhe_Themes/posts" target="_blank"><?php _e( 'Join us on Google+', 'shopera' ); ?></a></li>
					<li class="social-cohhe"><i class="cohhe_logo"></i><a href="https://cohhe.com/" target="_blank"><?php _e( 'Cohhe.com', 'shopera' ); ?></a></li>
				</ul>
			</li>
			<?php
		}
	}
}

function shopera_sanitize_checkbox( $input ) {
	// Boolean check 
	return ( ( isset( $input ) && true == $input ) ? true : false );
}

/**
 * Sanitize the Featured Content layout value.
 *
 * @since Shopera 1.0
 *
 * @param string $layout Layout type.
 * @return string Filtered layout type (grid|slider).
 */
function shopera_sanitize_layout( $layout ) {
	if ( ! in_array( $layout, array( 'slider' ) ) ) {
		$layout = 'slider';
	}

	return $layout;
}

/**
 * Bind JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Shopera 1.0
 */
function shopera_customize_preview_js() {
	wp_enqueue_script( 'shopera_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20131205', true );
}
add_action( 'customize_preview_init', 'shopera_customize_preview_js' );

/**
 * Add contextual help to the Themes and Post edit screens.
 *
 * @since Shopera 1.0
 *
 * @return void
 */
function shopera_contextual_help() {
	if ( 'admin_head-edit.php' === current_filter() && 'post' !== $GLOBALS['typenow'] ) {
		return;
	}

	get_current_screen()->add_help_tab( array(
		'id'      => 'shopera',
		'title'   => __( 'Shopera 1.0', 'shopera' ),
		'content' =>
			'<ul>' .
				'<li>' . sprintf( __( 'The home page features your choice of up to 6 posts prominently displayed in a grid or slider, controlled by the <a href="%1$s">featured</a> tag; you can change the tag and layout in <a href="%2$s">Appearance &rarr; Customize</a>. If no posts match the tag, <a href="%3$s">sticky posts</a> will be displayed instead.', 'shopera' ), admin_url( '/edit.php?tag=featured' ), admin_url( 'customize.php' ), admin_url( '/edit.php?show_sticky=1' ) ) . '</li>' .
				'<li>' . sprintf( __( 'Enhance your site design by using <a href="%s">Featured Images</a> for posts you&rsquo;d like to stand out (also known as post thumbnails). This allows you to associate an image with your post without inserting it. Shopera 1.0 uses featured images for posts and pages&mdash;above the title&mdash;and in the Featured Content area on the home page.', 'shopera' ), 'http://codex.wordpress.org/Post_Thumbnails#Setting_a_Post_Thumbnail' ) . '</li>' .
				'<li>' . sprintf( __( 'For an in-depth tutorial, and more tips and tricks, visit the <a href="%s">Shopera 1.0 documentation</a>.', 'shopera' ), 'http://codex.wordpress.org/Shopera' ) . '</li>' .
			'</ul>',
	) );
}
add_action( 'admin_head-themes.php', 'shopera_contextual_help' );
add_action( 'admin_head-edit.php',   'shopera_contextual_help' );
