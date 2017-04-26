<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Raothue
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<?php if ( rt_option( 'responsive', true, false ) ) : ?>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php endif; ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" <?php rt_layout_classes( 'site' ); ?>>
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html__( 'Skip to content', 'rt-theme' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<div class="site-branding"<?php echo get_header_image() ? ' style="background: url(' . get_header_image() . ') center center no-repeat;"' : ''; ?>>
			<div class="container">
				<div class="row">

					<div class="col-md-4 col-sm-12 col-xs-12">
						<?php if ( has_custom_logo() ) : ?>
							<?php the_custom_logo(); ?>
						<?php else : ?>
							<?php
							if ( ! is_singular() || is_front_page() ) : ?>
								<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
							<?php else : ?>
								<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></div>
							<?php
							endif;

							$description = get_bloginfo( 'description', 'display' );
							if ( $description || is_customize_preview() ) : ?>
								<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
							<?php
							endif; ?>
						<?php endif; ?>
					</div><!-- .col-xs-4 -->

					<?php if ( is_active_sidebar( 'header-right' ) ) : ?>
					<div class="col-md-8 col-sm-12 col-xs-12">
						<?php dynamic_sidebar( 'header-right' ); ?>
					</div>
					<?php endif; ?>

				</div><!-- .row -->
			</div><!-- .container -->
		</div><!-- .site-branding -->

		<?php get_template_part( 'template-parts/navigation' ); ?>

	</header><!-- #masthead -->

	<div id="content" class="site-content">

		<?php do_action( 'above_content_before' ); ?>

		<?php if ( is_active_sidebar( 'above-content' ) && is_front_page() ) : ?>
		<div class="above-content-section">
			<?php if ( ! rt_option( 'above_content_full_width', null, false ) ) : ?>
			<div class="container">
				<div class="row">
			<?php endif; ?>

					<?php dynamic_sidebar( 'above-content' ); ?>

			<?php if ( ! rt_option( 'above_content_full_width', null, false ) ) : ?>
				</div>
			</div>
			<?php endif; ?>
		</div>
		<?php endif; ?>

		<?php do_action( 'above_content_after' ); ?>

		<div class="container">
			<div class="row">
				<div id="layout" <?php rt_layout_class( 'clearfix' ); ?>>

					<?php do_action( 'before_layout' );
