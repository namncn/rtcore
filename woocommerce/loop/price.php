<?php
/**
 * Loop Price
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/price.php.
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
 * @version     3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();

$thousands_sep = '.';
$thousands_sep = rt_option( 'thousands_sep', null, false );

?>

<?php if ( ! empty( $regular_price ) ) : ?>
	<span class="price<?php echo $sale_price ? '' : ' no-sale-price' ?>">
		<span class="regular-price">
			<?php printf( '%sđ', number_format( $regular_price, 0, '.', $thousands_sep ) ); ?>
		</span>

		<?php if ( ! empty( $sale_price ) ) : ?>
		<span class="sale-price">
			<?php printf( '%sđ', number_format( $sale_price, 0, '.', $thousands_sep ) ); ?>
		</span>
		<?php endif; ?>
	</span>
<?php endif; ?>
