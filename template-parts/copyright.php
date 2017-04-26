<?php
/**
 * Copyright template part.
 *
 * @package  Raothue
 */

if ( ! rt_option( 'copyright', null, false ) ) {
	return;
}
?>

<div class="copyright text-center">
	<div class="container">
		<?php rt_option( 'copyright' ); ?>
	</div>
</div>
