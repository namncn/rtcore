<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $related_products ) : ?>

	<div class="related">

		<h3 class="widget-title"><?php esc_html_e( 'Sản phẩm liên quan', 'woocommerce' ); ?></h3>

		<?php woocommerce_product_loop_start(); ?>

			<?php foreach ( $related_products as $related_product ) : ?>

				<?php
					$post_object = get_post( $related_product->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

					wc_get_template_part( 'content', 'product' ); ?>

			<?php endforeach; ?>

		<?php woocommerce_product_loop_end(); ?>

	</div>

<?php endif;

wp_reset_postdata();

if ( rt_option( 'related_on_off', null, false ) ) :
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	"use strict";
	$( '.related > ul' ).slick({
		infinite: true,
		speed: <?php rt_option( 'related_slider_speed' ); ?>,
		slidesToShow: <?php rt_option( 'related_slider_show' ); ?>,
		slidesToScroll: <?php rt_option( 'related_slider_scroll' ); ?>,
		autoplay: <?php rt_option( 'related_slider_autoplay' ); ?>,
		autoplaySpeed: <?php rt_option( 'related_slider_autoplayspeed' ); ?>,
		arrows: <?php rt_option( 'related_slider_arrows' ); ?>,
		prevArrow: '<button type="button" class="slick-prev"></button>',
		nextArrow: '<button type="button" class="slick-next"></button>',
		dots: false,
		responsive: [
		{
		  breakpoint: 769,
		  settings: {
			slidesToShow: 2,
			slidesToScroll: 1,
		  }
		},
		{
		  breakpoint: 321,
		  settings: {
			slidesToShow: 1,
			slidesToScroll: 1,
		  }
		},
		]
	});
});
</script>
<?php endif; ?>
