<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Raothue
 * @subpackage RT_Theme
 * @since 1.0
 * @version 1.0
 */

?>
					<?php do_action( 'after_layout' ); ?>

				</div><!-- #layout -->
			</div><!-- .row -->
		</div><!-- .container -->

		<?php do_action( 'under_content_before' ); ?>

		<?php if ( is_active_sidebar( 'under-content' ) ) : ?>
		<div class="under-content-section">
			<div class="container">
				<?php dynamic_sidebar( 'under-content' ); ?>
			</div>
		</div>
		<?php endif; ?>

		<?php do_action( 'under_content_after' ); ?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">

		<?php do_action( 'before_site_footer' ); ?>

		<?php get_template_part( 'template-parts/top-footer' ); ?>
		<?php get_template_part( 'template-parts/bottom-footer' ); ?>
		<?php get_template_part( 'template-parts/copyright' ); ?>

		<?php do_action( 'after_site_footer' ); ?>

	</footer><!-- #colophon -->

	<?php get_template_part( 'template-parts/mobile-menu' ); ?>

	<div class="overlay"></div>

	<?php if ( rt_option( 'totop', true, false ) ) : ?>
		<div class="backtotop"><?php rt_back_to_top(); ?></div>
	<?php endif; ?>

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
