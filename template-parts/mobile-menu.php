<?php
/**
 * Mobile menu template part.
 *
 * @package  Raothue
 */
?>

<div class="mobile-menu-container">
	<div class="close-menu"><?php esc_html_e( 'Đóng menu x', 'rt' ); ?></div>

	<?php
	/**
	* Displays a navigation menu
	* @param array $args Arguments
	*/
	$args = array(
		'theme_location' => 'secondary',
		'container' => '',
		'container_id' => '',
		'menu_class' => 'mobile-menu',
		'menu_id' => 'moblie-menu',
		'fallback_cb' => 'mobile_menu_fallback',
	);

	wp_nav_menu( $args ); ?>

</div><!-- .mobile-menu-container -->
