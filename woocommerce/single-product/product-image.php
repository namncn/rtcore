<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product;

?>
<div class="rt_woocommerce-product-gallery <?php echo ( 'vertical' == rt_option( 'thumbelina', null, false ) ) ? 'vertical' : 'horizontal'; ?>">
	<figure class="rt-woocommerce-product-gallery__wrapper clearfix">
		<div class="rt-woocommerce-product-thumbnail">
			<img class="cloudzoom" alt ="Cloud Zoom small image" id ="zoom1" src="<?php echo get_the_post_thumbnail_url( $post->ID, 'full' ) ?>" data-cloudzoom="zoomSizeMode:'image',autoInside: 550">
		</div>

		<div class="rt-woocommerce-product-gallery-nav">
			<div class="thumbelina-but left"></div>
			<?php do_action( 'woocommerce_product_thumbnails' ); ?>
			<div class="thumbelina-but right"></div>
		</div>
	</figure>
</div>
