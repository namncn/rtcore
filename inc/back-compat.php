<?php
/**
 * RT Theme back compat functionality
 *
 * Prevents RT Theme from running on WordPress versions prior to 4.7.3,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.7.3.
 *
 * @package Raothue
 * @subpackage RT_Theme
 * @since 1.0
 */

/**
 * Prevent switching to RT Theme on old versions of WordPress.
 *
 * Switches to the default theme.
 *
 * @since RT Theme 1.0
 */
function rt_switch_theme() {
	switch_theme( WP_DEFAULT_THEME );
	unset( $_GET['activated'] );
	add_action( 'admin_notices', 'rt_upgrade_notice' );
}
add_action( 'after_switch_theme', 'rt_switch_theme' );

/**
 * Adds a message for unsuccessful theme switch.
 *
 * Prints an update nag after an unsuccessful attempt to switch to
 * RT Theme on WordPress versions prior to 4.7.3.
 *
 * @since RT Theme 1.0
 *
 * @global string $wp_version WordPress version.
 */
function rt_upgrade_notice() {
	$message = sprintf( __( 'RT Theme requires at least WordPress version 4.7.3. You are running version %s. Please upgrade and try again.', 'rt-theme' ), $GLOBALS['wp_version'] );
	printf( '<div class="error"><p>%s</p></div>', $message );
}

/**
 * Prevents the Customizer from being loaded on WordPress versions prior to 4.7.3.
 *
 * @since RT Theme 1.0
 *
 * @global string $wp_version WordPress version.
 */
function rt_customize() {
	wp_die( sprintf( __( 'RT Theme requires at least WordPress version 4.7.3. You are running version %s. Please upgrade and try again.', 'rt-theme' ), $GLOBALS['wp_version'] ), '', array(
		'back_link' => true,
	) );
}
add_action( 'load-customize.php', 'rt_customize' );

/**
 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.7.3.
 *
 * @since RT Theme 1.0
 *
 * @global string $wp_version WordPress version.
 */
function rt_preview() {
	if ( isset( $_GET['preview'] ) ) {
		wp_die( sprintf( __( 'RT Theme requires at least WordPress version 4.7.3. You are running version %s. Please upgrade and try again.', 'rt-theme' ), $GLOBALS['wp_version'] ) );
	}
}
add_action( 'template_redirect', 'rt_preview' );

/**
 * And only works with PHP 5.3.9 or later.
 */
if ( version_compare( phpversion(), '5.3.9', '<' ) ) :
	/**
	 * Prevent switching to RT Theme on old versions of WordPress.
	 *
	 * Switches to the default theme.
	 */
	function rt_phpcompat_switch_theme() {
		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

		unset( $_GET['activated'] );

		add_action( 'admin_notices', 'rt_phpcompat_upgrade_notice' );
	}
	add_action( 'after_switch_theme', 'rt_phpcompat_switch_theme' );

	/**
	 * Adds a message for outdate PHP version.
	 */
	function rt_phpcompat_upgrade_notice() {
		$message = sprintf( esc_html__( 'RT Theme requires at least PHP version 5.3.9. You are running version %s.', 'rt-theme' ), phpversion() );
		printf( '<div class="error"><p>%s</p></div>', $message ); // WPCS: XSS OK.
	}
endif;
