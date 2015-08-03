<?php
/*
 * Layout options
 */

$config = array(
	'id'       => 'vh_layouts',
	'title'    => __('Layouts', 'shopera'),
	'pages'    => array('page', 'post'),
	'context'  => 'normal',
	'priority' => 'high',
);

$options = array(array(
	'name'    => __('Layout type', 'shopera'),
	'id'      => 'layouts',
	'type'    => 'layouts',
	'only'    => 'page,post',
	'default' => get_theme_mod('shopera_layout', 'full'),
));

require_once(get_template_directory() . '/inc/metaboxes/add_metaboxes.php');
new shopera_create_meta_boxes($config, $options);