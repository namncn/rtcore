<?php
/**
 * Navigation Teamplate
 *
 * @package Raothue
 */
?>

<nav id="site-navigation" class="main-navigation">
	<div class="container">
		<div class="row">

			<?php
				wp_nav_menu( array(
					'theme_location'  => 'primary',
					'menu_id'         => 'primary-menu',
					'menu_class'      => 'menu clearfix',
					'container_class' => rt_option( 'enable_header_search', null, false ) ? 'primary-menu-container visible-lg col-md-9' : 'primary-menu-container visible-lg col-md-12',
					'fallback_cb'     => 'primary_menu_fallback',
				));
			?>

			<?php if ( rt_option( 'enable_header_search', null, false ) ) : ?>

			<div class="header-search col-lg-3 col-md-9 col-sm-9 col-xs-9">
				<?php get_search_form( 'searchform-header' ); ?>
			</div>

			<div class="hidden-lg col-sm-3 col-xs-3">

			<?php else : ?>

			<div class="hidden-lg col-xs-12">

			<?php endif; ?>

				<button id="menu-toggle" type="button" class="rt-navbar-toggle hidden-lg">
					<span class="screen-reader-text sr-only">Toggle navigation</span>
					<span class="icon-bar bar1"></span>
					<span class="icon-bar bar2"></span>
					<span class="icon-bar bar3"></span>
				</button>
			</div>

		</div><!-- .row -->
	</div><!-- .container -->
</nav><!-- #site-navigation -->
