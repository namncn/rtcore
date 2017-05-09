<?php
/**
 * Vertical Mega Mobile Menu
 */

if ( ! rt_option( 'vertical_mega_menu', null, false ) ) {
	return;
}
?>

<div class="vertical-mega-mobile-menu">
	<div class="close-menu"><?php printf( '%s <i class="fa fa-times" aria-hidden="true"></i>', esc_html__( 'Đóng menu', 'rt-theme' ) ); // WPCS: XSS OK.?></div>

	<?php
		wp_nav_menu( array(
			'theme_location' => 'vertical-mega-menu',
			'container_class' => 'menu-vertical-mega-menu-container',
			'container_id' => 'vertical-mega-menu',
			'menu_class' => 'menu',
		) );
	?>
</div>
