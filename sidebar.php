<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Raothue
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */

$area = RT_Sidebar::get_sidebar( 'area' );

if ( ! is_active_sidebar( RT_Sidebar::get_sidebar( 'left_sidebar_name' ) ) && ! is_active_sidebar( RT_Sidebar::get_sidebar( 'right_sidebar_name' ) ) ) {
	return;
}
?>

<?php if ( is_active_sidebar( $sidebar_left = RT_Sidebar::get_sidebar( 'left_sidebar_name' ) ) && ( 'left' == $area || 'both' == $area ) ) : ?>
	<aside id="secondary-1" class="sidebar widget-area">
		<?php dynamic_sidebar( $sidebar_left ); ?>
	</aside><!-- #secondary -->
<?php endif; ?>

<?php if ( is_active_sidebar( $sidebar_right = RT_Sidebar::get_sidebar( 'right_sidebar_name' ) ) && ( 'right' == $area || 'both' == $area ) ) : ?>
	<aside id="secondary-2" class="sidebar widget-area">
		<?php dynamic_sidebar( $sidebar_right ); ?>
	</aside><!-- #secondary -->
<?php endif; ?>
