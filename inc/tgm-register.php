<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * @see https://github.com/TGMPA/TGM-Plugin-Activation/blob/develop/example.php
 *
 * @package RTCORRE
 */

/**
 * Register the required plugins for this theme.
 */
function raothue_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 */
	$plugins = array(
		array(
			'name'     => esc_html__( 'RT Core', 'raothue' ),
			'slug'     => 'rt-plugin',
			'source'   => 'https://github.com/namncn/rt-plugin/archive/master.zip',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Meta Slider', 'raothue' ),
			'slug'     => 'ml-slider',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'WooCommerce', 'raothue' ),
			'slug'     => 'woocommerce',
			'required' => true,
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 */
	$config = array(
		'id'           => 'raothue',
		'is_automatic' => true,
		'strings'      => array( 'nag_type' => 'notice-warning' ),
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'raothue_register_required_plugins' );
