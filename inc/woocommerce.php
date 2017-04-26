<?php
/**
 * Woocommerce functions.
 *
 * @package Raothue.
 */

remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
add_action( 'woocommerce_before_shop_loop_item_title', 'rt_woocommerce_template_loop_product_thumbnail', 10 );

add_action( 'woocommerce_after_shop_loop_item_title', 'rt_woocommerce_product_excerpt', 20 );

remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
add_action( 'woocommerce_shop_loop_item_title', 'rt_woocommerce_template_loop_product_title', 10 );

remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
add_action( 'woocommerce_after_shop_loop_item_title', 'rt_woocommerce_template_loop_rating', 15 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );

add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 6 );


remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );

// Breadcrumb
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );
add_action( 'woocommerce_before_single_product', 'woocommerce_breadcrumb', 5 );

if ( ! function_exists( 'rt_woocommerce_get_product_thumbnail' ) ) {

	/**
	 * Get the product thumbnail, or the placeholder if not set.
	 *
	 * @subpackage	Loop
	 * @param string $size (default: 'shop_catalog')
	 * @param int $deprecated1 Deprecated since WooCommerce 2.0 (default: 0)
	 * @param int $deprecated2 Deprecated since WooCommerce 2.0 (default: 0)
	 * @return string
	 */
	function rt_woocommerce_get_product_thumbnail( $size = 'shop_catalog', $deprecated1 = 0, $deprecated2 = 0 ) {
		global $post;
		$image_size = apply_filters( 'rt_single_product_archive_thumbnail_size', $size );

		if ( has_post_thumbnail() ) {
			$props = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
			return get_the_post_thumbnail( $post->ID, $image_size, array(
				'alt'    => $props['alt'],
			) );
		} elseif ( wc_placeholder_img_src() ) {
			return wc_placeholder_img( $image_size );
		}
	}
}

/**
 * rt_woocommerce_template_loop_product_thumbnail
 *
 * @return [type] [description]
 */
function rt_woocommerce_template_loop_product_thumbnail() {
	echo '<a href="' . get_the_permalink() . '">' . rt_woocommerce_get_product_thumbnail() . '</a>';
}

/**
 * [rt_add_to_cart_text description]
 * @return [type] [description]
 */
function rt_add_to_cart_text() {
	return apply_filters( 'rt_woocommerce_product_add_to_cart_text', esc_html__( 'Đặt mua', 'rt-theme' ) );
}
add_filter( 'woocommerce_product_add_to_cart_text', 'rt_add_to_cart_text' );

/**
 * [rt_woocommerce_product_single_add_to_cart_text description]
 * @return [type] [description]
 */
function rt_woocommerce_product_single_add_to_cart_text() {
	return apply_filters( 'rt_woocommerce_product_single_add_to_cart_text', esc_html__( 'Mua ngay', 'rt-theme' ) );
}
add_filter( 'woocommerce_product_single_add_to_cart_text', 'rt_woocommerce_product_single_add_to_cart_text' );

/**
 * [rt_woocommerce_product_excerpt description]
 * @return [type] [description]
 */
function rt_woocommerce_product_excerpt() {
	echo '<div class="rt_product_excerpt">';
	echo wp_trim_words( get_the_content(), 13, ' ...' );
	echo '</div>';
}

if ( ! function_exists( 'rt_woocommerce_template_loop_product_title' ) ) {

	/**
	 * Show the product title in the product loop. By default this is an H3.
	 */
	function rt_woocommerce_template_loop_product_title() {
		echo '<h2 class="rt_woocommerce-loop-product__title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h2>';
	}
}

/**
 * [rt_woocommerce_template_loop_rating description]
 * @return [type] [description]
 */
function rt_woocommerce_template_loop_rating() {
	echo '<div class="rt_rating"></div>';
}

/**
 * [rt_qv_woocommerce_template_single_title description]
 * @return [type] [description]
 */
function rt_qv_woocommerce_template_single_title() {
	the_title( '<h3 class="product_title entry-title"><a href="' . get_the_permalink() . '">', '</a></h3>' );
}

/**
 * [rt_qv_woocommerce_template_single_price description]
 * @param  [type] $product [description]
 * @return [type]          [description]
 */
function rt_qv_woocommerce_template_single_price() {
	global $product;

	$regular_price = $product->get_regular_price();
	$sale_price = $sale_price = $product->get_sale_price();

	if ( ! empty( $regular_price ) ) : ?>
	<span class="price<?php echo $sale_price ? '' : ' no-sale-price' ?>">
		<?php if ( ! empty( $sale_price ) ) : ?>
		<span class="sale-price">
			<?php printf( '%s₫', number_format_i18n( $sale_price ) ); ?>
		</span>

		<?php endif; ?>
		<span class="regular-price">
			<?php printf( '%s₫', number_format_i18n( $regular_price ) ); ?>
		</span>
	</span>
	<?php
	endif;
}

/**
 * [rt_qv_woocommerce_template_single_excerpt description]
 * @return [type] [description]
 */
function rt_qv_woocommerce_template_single_excerpt() {
	global $post;

	if ( ! $post->post_excerpt ) {
		return;
	}
	printf( '<div class="woocommerce-product-details__short-description"><strong>%1$s</strong>%2$s</div>', esc_html__( 'Mô tả:', 'rt-core' ), wp_trim_words( get_the_excerpt(), 40, '<a href="' . get_the_permalink() . '" title="' . esc_html__( 'Xem chi tiết sản phẩm này', 'rt-core' ) . '">' . esc_html__( '...Xem chi tiết', 'rt-core' ) . '</a>' ) );
}

/**
 * Single add to cart template.
 *
 * @return string single add to cart template.
 */
function rt_qv_woocommerce_template_single_add_to_cart() { ?>
	<form class="cart" method="post" enctype="multipart/form-data">
		<div class="quantity_wanted_p">
			<div class="quantity">
				<label for="quantity-detail" class="quantity-selector slg_g">Số lượng</label>
				<a class="btn_num button_qty" onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty ) &amp;&amp; qty > 1 ) result.value--;return false;" type="button">-</a>
				<input id="qty" type="text" class="input-text qty text" name="quantity" value="1" title="SL">
				<a class="btn_num button_qty" onclick="var result = document.getElementById('qty'); var qty = result.value; if( !isNaN( qty )) result.value++;return false;" type="button">+</a>
			</div>
		</div>

		<button type="submit" name="add-to-cart" value="<?php the_ID(); ?>" class="rt_qv_btn"><?php esc_html_e( 'Mua Ngay', 'rt-core' ); ?></button>

	</form>
<?php
}

/**
 * Product product images teamplate.
 *
 * @return string Product Images template.
 */
function rt_qv_woocommerce_show_product_images() {
	global $post, $product;

	$attachment_ids = $product->get_gallery_image_ids();

	if ( $attachment_ids && has_post_thumbnail() ) { ?>
		<div class="rt_galleries_products images">
			<div class="rt_product_thumbnails">
				<?php
				foreach ( $attachment_ids as $attachment_id ) {
					$full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
					$thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
					$thumbnail_post   = get_post( $attachment_id );
					$image_title      = $thumbnail_post->post_content;

					$attributes = array(
						'title'                   => $image_title,
						'data-src'                => $full_size_image[0],
						'data-large_image'        => $full_size_image[0],
						'data-large_image_width'  => $full_size_image[1],
						'data-large_image_height' => $full_size_image[2],
					);

					$html  = '<div class="rt-product-gallery__image">';
					$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
					$html .= '</div>';

					echo $html;
				} ?>
			</div>
			<div class="rt_product_thumbnails_gallery">
				<?php
				foreach ( $attachment_ids as $attachment_id ) {
					$full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
					$thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
					$thumbnail_post   = get_post( $attachment_id );
					$image_title      = $thumbnail_post->post_content;

					$attributes = array(
						'title'                   => $image_title,
						'data-src'                => $full_size_image[0],
						'data-large_image'        => $full_size_image[0],
						'data-large_image_width'  => $full_size_image[1],
						'data-large_image_height' => $full_size_image[2],
					);

					$html  = '<div class="rt-product-gallery__image">';
					$html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
					$html .= '</div>';

					echo $html;
				} ?>
			</div>
		</div>
	<?php
	}
}

/**
 * Single Product summary template.
 *
 * @return string Woocommerce single product summary html template.
 */
function rt_woocommerce_single_product_summary() { ?>
	<div class="rt_woocommerce_single_product_summary clearfix">
		<div class="rt_woocommerce_single_product_summary-left">
			<?php woocommerce_template_single_excerpt(); ?>
			<?php woocommerce_template_single_price(); ?>
			<?php woocommerce_template_single_add_to_cart(); ?>
			<div class="rt_box_callback">
				<form id="rt_box_callback" class="clearfix" method="post" action="<?php the_permalink(); ?>">
					<label for="rt_callback_phone"><?php esc_html_e( 'Yêu Cầu Gọi Lại:', 'rt-theme' ); ?></label>
					<input id="rt_callback_phone" type="text" name="phone" placeholder="<?php esc_html_e( 'Nhập số điện thoại', 'rt-theme' ); ?>">
					<input type="submit" value="<?php esc_html_e( 'Gửi', 'rt-theme' ); ?>">
				</form>

				<?php if ( ! empty( $_POST['phone'] ) ) {
					$to = rt_option( 'rt_callback_email', null, false );
					$subject = rt_option( 'rt_callback_subject', null, false );
					$message = rt_option( 'rt_callback_message', null, false ) . ': ' . $_POST['phone'];
					$headers = array('Content-Type: text/html; charset=UTF-8');

					wp_mail( $to, $subject, $message, $headers );
				} ?>
			</div>
		</div>

		<div class="rt_woocommerce_single_product_summary-right ctsp-thongdiep">
			<div class="ctsp-giaohang">
				<i class="bg-gh"></i>
				<p><?php esc_html_e( 'Giao hàng toàn Quốc', 'rt-theme' ); ?></p>
			</div>
			<div class="ctsp-doihang">
				<i class="bg-dh"></i>
				<p><?php esc_html_e( 'Đổi hàng 07 ngày miễn phí', 'rt-theme' ); ?></p>
			</div>
			<div class="ctsp-chinhhang">
				<i class="bg-ch"></i>
				<p><?php esc_html_e( 'Đảm bảo hàng chính hãng', 'rt-theme' ); ?></p>
			</div>
			<div class="note-ship">
				<span class="money-icon"></span><?php esc_html_e( 'Quý khách có thể "Thanh toán khi nhận hàng', 'rt-theme' ); ?>
			</div>
		</div>
	</div>
	<div class="psupport"><?php rt_option( 'rt_product_hotline' ); ?></div>
<?php
}
add_action( 'woocommerce_single_product_summary', 'rt_woocommerce_single_product_summary', 20 );

/**
 * Tabs of content product.
 *
 * @param  array  $tabs Tabs of content.
 * @return array       //
 */
function rt_woocommerce_product_tabs( $tabs = array() ) {
	global $product, $post;

	// Description tab - shows product content
	if ( $post->post_content ) {
		$tabs['description'] = array(
			'title'    => esc_html__( 'Mô tả sản phẩm', 'rt-theme' ),
			'priority' => 10,
			'callback' => 'woocommerce_product_description_tab',
		);
	}

	unset($tabs['reviews']);

	return $tabs;
}
add_filter( 'woocommerce_product_tabs', 'rt_woocommerce_product_tabs' );

/**
 * Under Singular Sidebar.
 */
function rt_under_singular_sidebar() {
	if ( is_active_sidebar( 'under-singular' ) ) {
		dynamic_sidebar( 'under-singular' );
	}
}
add_action( 'woocommerce_after_single_product_summary', 'rt_under_singular_sidebar', 16 );

if ( rt_option( 'buy_now_btn', null, false ) ) {
	/**
	 * [rt_enable_disable_buynow_btn description]
	 * @param  array  $args [description]
	 * @return [type]       [description]
	 */
	function rt_enable_disable_buynow_btn( $args = array() ) {
		global $product;

		if ( $product ) {
			$defaults = array(
				'quantity' => 1,
				'class'    => implode( ' ', array_filter( array(
						'button',
						'product_type_' . $product->get_type(),
						$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
						$product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : '',
				) ) ),
			);

			$args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );

			echo apply_filters( 'woocommerce_loop_add_to_cart_link',
				sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
					esc_url( $product->add_to_cart_url() ),
					esc_attr( isset( $quantity ) ? $quantity : 1 ),
					esc_attr( $product->get_id() ),
					esc_attr( $product->get_sku() ),
					esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
					esc_html( $product->add_to_cart_text() )
				),
			$product );
		}
	}
	add_action( 'rt_add_to_cart', 'rt_enable_disable_buynow_btn', 10 );
}
