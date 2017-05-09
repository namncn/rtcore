<?php
/**
 * Mobile menu template part.
 *
 * @package  Raothue
 */
?>

<div class="mobile-menu-container">
	<div class="close-menu"><?php printf( '%s <i class="fa fa-times" aria-hidden="true"></i>', esc_html__( 'Đóng menu', 'rt-theme' ) ); // WPCS: XSS OK.?></div>

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
