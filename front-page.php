<?php
/**
 * Trang chủ template
 * Description: Template for home page.
 *
 * @package Raothue
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php if ( is_active_sidebar( 'front-page' ) ) {
				dynamic_sidebar( 'front-page' );
			} ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
