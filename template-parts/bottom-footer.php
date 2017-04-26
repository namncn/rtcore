<?php
/**
 * Footer template part.
 *
 * @package  Raothue
 */

if ( ! is_active_sidebar( 'bottom-footer' ) && ! is_active_sidebar( 'bottom-footer-2' ) && ! is_active_sidebar( 'bottom-footer-3' ) ) {
	return;
}

?>

<div class="bottom-footer">
	<div class="container">
		<div class="row">
		<?php if ( is_active_sidebar( 'bottom-footer' ) ) : ?>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<?php dynamic_sidebar( 'bottom-footer' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'bottom-footer-2' ) ) : ?>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<?php dynamic_sidebar( 'bottom-footer-2' ); ?>
			</div>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'bottom-footer-3' ) ) : ?>
			<div class="col-md-4 col-sm-6 col-xs-12">
				<?php dynamic_sidebar( 'bottom-footer-3' ); ?>
			</div>
		<?php endif; ?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .bottom-footer -->
