<?php
/**
 * RT Ajax Quick View
 *
 * @package Raothue
 * @subpackage RT_Theme
 * @author  NamNCN
 * @since  1.0.0
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

if ( ! class_exists( 'RT_WCQV' ) ) {
	/**
	 * RT WooCommerce Quick View
	 *
	 * @since 1.0.0
	 */
	class RT_WCQV {
		/**
		 * Single instance of class
		 *
		 * @var \RT_WCQV
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Returns single instance of the class
		 *
		 * @return \RT_WCQV
		 * @since  1.0.0
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @return mixed //
		 * @since 1.0.0
		 */
		public function __construct() {
			$action = array(
				'woocommerce_get_refreshed_fragments',
				'woocommerce_apply_coupon',
				'woocommerce_remove_coupon',
				'woocommerce_update_shipping_method',
				'woocommerce_update_order_review',
				'woocommerce_add_to_cart',
				'woocommerce_checkout'
			);

			// Exit if is woocommerce ajax
			if ( defined( 'DOING_AJAX' ) && DOING_AJAX && isset( $_REQUEST['action'] ) && in_array( $_REQUEST['action'], $action ) ) {
				return;
			}

			if ( $this->load_frontend() ) {
				RT_WCQV_Frontend();
			}
		}

		/**
		 * Check if load or not frontend
		 *
		 * @since 1.0.0
		 * @return boolean
		 */
		public function load_frontend() {
			$enable = rt_option( 'quickview', null, false );
			$enable_on_mobile = rt_option( 'quickview_mobile', null, false );
			$is_mobile = wp_is_mobile();

			return apply_filters( 'rt_quickview_load_frontend', ( ! $is_mobile && $enable ) || ( $is_mobile && $enable_on_mobile ) );
		}
	}
}

/**
 * Unique access to instance of RT_WCQV class
 *
 * @return \RT_WCQV
 * @since 1.0.0
 */
function RT_WCQV() {
	return RT_WCQV::get_instance();
}

if ( rt_option( 'quickview', null, false ) ) {
	add_action( 'after_setup_theme', 'RT_WCQV' );
}

if( ! class_exists( 'RT_WCQV_Frontend' ) ) {
	/**
	 * Admin class.
	 * The class manage all the Frontend behaviors.
	 *
	 * @since 1.0.0
	 */
	class RT_WCQV_Frontend {

		/**
		 * Single instance of the class
		 *
		 * @var \RT_WCQV_Frontend
		 * @since 1.0.0
		 */
		protected static $instance;

		/**
		 * Plugin version
		 *
		 * @var string
		 * @since 1.0.0
		 */
		public $version = '1.0.0';

		/**
		 * Returns single instance of the class
		 *
		 * @return \RT_WCQV_Frontend
		 * @since 1.0.0
		 */
		public static function get_instance(){
			if( is_null( self::$instance ) ){
				self::$instance = new self();
			}

			return self::$instance;
		}

		/**
		 * Constructor
		 *
		 * @access public
		 * @since 1.0.0
		 */
		public function __construct() {

			// custom styles and javascripts
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles_scripts' ) );

			// quick view ajax
			add_action( 'wp_ajax_rt_load_product_quick_view', array( $this, 'rt_load_product_quick_view_ajax' ) );
			add_action( 'wp_ajax_nopriv_rt_load_product_quick_view', array( $this, 'rt_load_product_quick_view_ajax' ) );

			// add button
			add_action( 'rt_add_to_cart', array( $this, 'rt_add_quick_view_button' ), 15 );
			add_action( 'rt_wcwl_table_after_product_name', array( $this, 'rt_add_quick_view_button' ), 15, 0 );

			// load modal template
			add_action( 'wp_footer', array( $this, 'rt_quick_view' ) );

			// load action for product template
			$this->rt_quick_view_action_template();

			add_shortcode( 'rt_quick_view', array( $this, 'quick_view_shortcode' ) );
		}

		/**
		 * Enqueue styles and scripts
		 *
		 * @access public
		 * @return void
		 * @since 1.0.0
		 * @author Nam NCN
		 */
		public function enqueue_styles_scripts() {

			wp_register_script( 'rt-wcqv-frontend', get_theme_file_uri( 'assets/js/frontend.js' ), array( 'jquery' ), $this->version, true);
			wp_enqueue_script( 'rt-wcqv-frontend' );
			wp_enqueue_style( 'rt-quick-view', get_theme_file_uri( 'assets/css/rt-quick-view.css' ) );
		}

		/**
		 * Add quick view button in wc product loop
		 *
		 * @access public
		 * @param integer|string $product_id The product id
		 * @param string $label The button label
		 * @param boolean $return
		 * @return string|void
		 * @since  1.0.0
		 * @author Nam NCN
		 */
		public function rt_add_quick_view_button( $product_id = 0, $label = '', $return = false ) {

			global $product;

			// get product id
			! $product_id && $product_id = rt_get_prop( $product, 'id', true );
			// get label
			! $label && $label = $this->get_button_label();

			$button = '<a href="#" class="button rt-wcqv-button pull-right" data-product_id="' . $product_id . '">' . $label . '</a>';
			$button = apply_filters( 'rt_add_quick_view_button_html', $button, $label, $product );

			if( $return ) {
				return $button;
			}

			echo $button;
		}

		/**
		 * Enqueue scripts and pass variable to js used in quick view
		 *
		 * @access public
		 * @return bool
		 * @since 1.0.0
		 * @author Nam NCN
		 */
		public function rt_woocommerce_quick_view() {

			wp_enqueue_script( 'wc-add-to-cart-variation' );

			// enqueue wc color e label variation style
			wp_enqueue_script( 'rt_wccl_frontend' );
			wp_enqueue_style( 'rt_wccl_frontend' );

			// loader gif
			$loader = apply_filters( 'rt_quick_view_loader_gif', get_theme_file_uri( 'assets/images/qv-loader.gif' ) );

			// Allow user to load custom style and scripts
			do_action( 'rt_quick_view_custom_style_scripts' );

			wp_localize_script( 'rt-wcqv-frontend', 'rt_qv', array (
					'ajaxurl'           => admin_url( 'admin-ajax.php', 'relative' ),
					'loader'            => $loader,
				)
			);

			return true;
		}

		/**
		 * Ajax action to load product in quick view
		 *
		 * @access public
		 * @return void
		 * @since 1.0.0
		 * @author Nam NCN
		 */
		public function rt_load_product_quick_view_ajax() {

			if ( ! isset( $_REQUEST['product_id'] ) ) {
				die();
			}

			$product_id = intval( $_REQUEST['product_id'] );

			// set the main wp query for the product
			wp( 'p=' . $product_id . '&post_type=product' );

			// remove product thumbnails gallery
			// remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );

			ob_start();

			while ( have_posts() ) : the_post(); ?>

			 <div class="product">

				<div id="product-<?php the_ID(); ?>" <?php post_class('product'); ?>>

					<?php do_action( 'rt_wcqv_product_image' ); ?>

					<div class="summary entry-summary">
						<div class="summary-content">
							<?php do_action( 'rt_wcqv_product_summary' ); ?>
						</div>
					</div>

				</div>

			</div>

			<?php endwhile; // end of the loop.

			echo ob_get_clean();

			die();
		}

		/**
		 * Load quick view template
		 *
		 * @access public
		 * @return void
		 * @since 1.0.0
		 * @author Nam NCN
		 */
		public function rt_quick_view() {
			$this->rt_woocommerce_quick_view(); ?>
			<div id="rt-quick-view-modal">

				<div class="rt-quick-view-overlay"></div>

				<div class="rt-wcqv-wrapper">

					<div class="rt-wcqv-main">

						<div class="rt-wcqv-head">
							<a href="#" id="rt-quick-view-close" class="rt-wcqv-close">X</a>
						</div>

						<div id="rt-quick-view-content" class="woocommerce single-product"></div>

					</div>

				</div>

			</div>
			<?php
		}

		/**
		 * Load wc action for quick view product template
		 *
		 * @access public
		 * @return void
		 * @since 1.0.0
		 * @author Nam NCN
		 */
		public function rt_quick_view_action_template() {

			// Image
			add_action( 'rt_wcqv_product_image', 'woocommerce_show_product_sale_flash', 10 );
			add_action( 'rt_wcqv_product_image', 'rt_qv_woocommerce_show_product_images', 20 );

			// Summary
			add_action( 'rt_wcqv_product_summary', 'rt_qv_woocommerce_template_single_title', 5 );
			// add_action( 'rt_wcqv_product_summary', 'woocommerce_template_single_rating', 15 );
			add_action( 'rt_wcqv_product_summary', 'woocommerce_template_single_meta', 10 );
			add_action( 'rt_wcqv_product_summary', 'rt_qv_woocommerce_template_single_price', 10 );
			add_action( 'rt_wcqv_product_summary', 'rt_qv_woocommerce_template_single_excerpt', 20 );
			add_action( 'rt_wcqv_product_summary', 'rt_qv_woocommerce_template_single_add_to_cart', 25 );
		}

		/**
		 * Get Quick View button label
		 *
		 * @author Nam NCN
		 * @since 1.2.0
		 * @return string
		 */
		public function get_button_label() {
			$label = esc_html__( 'Xem nhanh', 'raothue' );

			return apply_filters( 'rt_qv_button_label', $label );
		}

		/**
		 * Quick View shortcode button
		 *
		 * @access public
		 * @since 1.0.7
		 * @param array $atts
		 * @return string
		 * @author Nam NCN
		 */
		public function quick_view_shortcode( $atts ) {

			$atts = shortcode_atts(array(
				'product_id' => 0,
				'label'		 => ''
			), $atts );

			extract( $atts );

			if( ! intval( $product_id ) ) {
				return '';
			}

			return $this->rt_add_quick_view_button( $product_id, $label, true );
		}
	}
}
/**
 * Unique access to instance of RT_WCQV_Frontend class
 *
 * @return \RT_WCQV_Frontend
 * @since 1.0.0
 */
function RT_WCQV_Frontend(){
	return RT_WCQV_Frontend::get_instance();
}

if ( ! function_exists( 'rt_get_prop' ) ) {
	/**
	 * //
	 *
	 * @param  [type]  $object  //
	 * @param  [type]  $key     //
	 * @param  boolean $single  //
	 * @param  string  $context //
	 * @return //
	 */
	function rt_get_prop( $object, $key, $single = true, $context = 'view' ) {

		$prop_map   = rt_return_new_attribute_map();
		$is_wc_data = $object instanceof WC_Data;

		if ( $is_wc_data ) {
			$key = ( array_key_exists( $key, $prop_map ) ) ? $prop_map[ $key ] : $key;

			if ( ( $getter = "get{$key}" ) && method_exists( $object, $getter ) ) {
				return $object->$getter( $context );
			} elseif ( ( $getter = "get_{$key}" ) && method_exists( $object, $getter ) ) {
				return $object->$getter( $context );
			} else {
				return $object->get_meta( $key, $single );
			}
		} else {
			$key = ( in_array( $key, $prop_map ) ) ? array_search( $key, $prop_map ) : $key;

			if ( isset( $object->$key ) ) {
				return $object->$key;
			} elseif ( yit_wc_check_post_columns( $key ) ) {
				return $object->post->$key;
			} else {
				$getter = 'get_user_meta';
				!$object instanceof WC_Customer && $getter = 'get_post_meta';

				$object_id = is_callable( array( $object, 'get_id' ) ) ? $object->get_id() : $object->id;

				return $getter( $object_id, $key, true );
			}
		}
	}
}

if ( ! function_exists( 'rt_return_new_attribute_map' ) ) {
	/**
	 * //
	 *
	 * @return //
	 */
	function rt_return_new_attribute_map() {
		return array(
			'post_parent'            => 'parent_id',
			'post_title'             => 'name',
			'post_status'            => 'status',
			'post_content'           => 'description',
			'post_excerpt'           => 'short_description',
			/* Orders */
			'paid_date'              => 'date_paid',
			'_paid_date'             => '_date_paid',
			'completed_date'         => 'date_completed',
			'_completed_date'        => '_date_completed',
			'_order_date'            => '_date_created',
			'order_date'             => 'date_created',
			'order_total'            => 'total',
			'customer_user'          => 'customer_id',
			'_customer_user'         => 'customer_id',
			/* Products */
			'visibility'             => 'catalog_visibility',
			'_visibility'            => '_catalog_visibility',
			'sale_price_dates_from'  => 'date_on_sale_from',
			'_sale_price_dates_from' => '_date_on_sale_from',
			'sale_price_dates_to'    => 'date_on_sale_to',
			'_sale_price_dates_to'   => '_date_on_sale_to',
			/*Coupons*/
			'coupon_amount'              => 'amount',
			'exclude_product_ids'        => 'excluded_product_ids',
			'exclude_product_categories' => 'excluded_product_categories',
			'customer_email'             => 'email_restrictions',
			'expiry_date'                => 'date_expires',
		);
	}
}
