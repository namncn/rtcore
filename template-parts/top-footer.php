<?php
/**
 * Footer template part.
 *
 * @package  Raothue
 */

if ( ! is_active_sidebar( 'top-footer' ) ) {
	return;
}

?>

<div class="top-footer">
	<div class="container">
		<div class="row">
		<?php if ( is_active_sidebar( 'top-footer' ) ) : ?>
			<div class="col-xs-12">
				<?php dynamic_sidebar( 'top-footer' ); ?>
			</div>
		<?php endif; ?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .top-footer -->
