<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Raothue
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) : ?>
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			the_posts_pagination( array(
				'prev_text' => '<span class="screen-reader-text">' . esc_html__( 'Trang trước', 'rt-theme' ) . '</span>',
				'next_text' => '<span class="screen-reader-text">' .  esc_html__( 'Trang sau', 'rt-theme' ) . '</span>',
				'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Trang', 'rt-theme' ) . ' </span>',
			) );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
