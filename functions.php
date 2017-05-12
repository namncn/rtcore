<?php
/**
 * RT Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Raothue
 * @subpackage RT_Theme
 * @since 1.0
 */

/**
 * RT Theme only works in WordPress 4.7 or later.
 */
if ( version_compare( $GLOBALS['wp_version'], '4.7.3', '<' ) ) {
	require get_theme_file_path( '/inc/back-compat.php' );
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function rt_setup() {
	/*
	 * Make theme available for translation.
	 */
	load_child_theme_textdomain( 'rt-theme', apply_filters( 'rt_theme_textdomain', get_theme_file_path( '/languages' ), 'rt-theme' ) );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary'            => esc_html__( 'Primary Menu', 'rt-theme' ),
		'secondary'          => esc_html__( 'Mobile Menu', 'rt-theme' ),
		'vertical-mega-menu' => esc_html__( 'Vertical Mega Menu', 'rt-theme' ),
	) );

	// Add theme support for Custom Logo.
	add_theme_support( 'custom-logo', array(
		'width'       => 300,
		'height'      => 100,
		'flex-width'  => true,
	) );

	// Adds theme support WooCommerce
	add_theme_support( 'woocommerce' );
	// add_theme_support( 'wc-product-gallery-zoom' );
	// add_theme_support( 'wc-product-gallery-lightbox' );
	// add_theme_support( 'wc-product-gallery-slider' );

	// Add support for custom background
	add_theme_support( 'custom-background' );

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

}
add_action( 'after_setup_theme', 'rt_setup' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function rt_widgets_init() {

	register_sidebar( array(
		'name'          => esc_html__( 'Thanh bên (Trái)', 'rt-theme' ),
		'id'            => 'sidebar-1',
		'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị cột bên cạnh nội dung.', 'rt-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Thanh bên (Phải)', 'rt-theme' ),
		'id'            => 'sidebar-2',
		'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị cột bên cạnh nội dung.', 'rt-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Quảng cáo', 'rt-theme' ),
		'id'            => 'header-right',
		'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung quảng cáo trên header.', 'rt-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Phần trên nội dung', 'rt-theme' ),
		'id'            => 'above-content',
		'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung phía trên nội dung.', 'rt-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Trang chủ', 'rt-theme' ),
		'id'            => 'front-page',
		'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung trang chủ.', 'rt-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Dưới mỗi bài viết', 'rt-theme' ),
		'id'            => 'under-singular',
		'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung phía dưới mỗi bài viết.', 'rt-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Phần dưới nội dung', 'rt-theme' ),
		'id'            => 'under-content',
		'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung phía dưới nội dung.', 'rt-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Chân trang phần trên', 'rt-theme' ),
		'id'            => 'top-footer',
		'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung chân trang phần trên.', 'rt-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebars( 3, array(
		'name'          => esc_html__( 'Cột %d Chân Trang', 'rt-theme' ),
		'id'            => 'bottom-footer',
		'description'   => esc_html__( 'Thêm tiện ích vào đây để hiển thị nội dung chân trang.', 'rt-theme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'rt_widgets_init' );

/**
 * Register custom fonts.
 */
function rt_fonts_url() {
	$fonts_url = '';

	/**
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'rt-theme' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Open Sans:400,300,300italic,400italic,600,600italic,700,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,vietnamese' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since RT Theme 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function rt_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'rt-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'rt_resource_hints', 10, 2 );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since RT Theme 1.0
 */
function rt_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'rt_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function rt_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'rt_pingback_header' );

/**
 * Enqueue scripts and styles.
 */
function rt_enqueue_scripts() {

	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'rt-fonts', rt_fonts_url(), array(), null );

	wp_enqueue_style( 'bootstrap', get_theme_file_uri( 'assets/css/bootstrap.min.css' ), array(), '3.3.7' );

	wp_enqueue_style( 'font-awesome', get_theme_file_uri( 'assets/css/font-awesome.min.css' ), array(), '4.7.0' );

	wp_enqueue_style( 'slick', get_theme_file_uri( 'assets/css/slick.min.css' ), array(), '1.6.0' );

	wp_enqueue_style( 'rt-main', get_theme_file_uri( 'assets/css/main.css' ), array(), '1.0.0' );

	wp_enqueue_style( 'jquery-ui-base', '//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css', array(), '1.0.0' );

	if ( ! rt_option( 'responsive', true, false ) ) {
		wp_enqueue_style( 'rt-non-responsive', get_theme_file_uri( 'assets/css/non-responsive.css' ), array(), '1.0.0' );
	}

	if ( rt_option( 'sticky_nav_menu', false, false ) ) {

		wp_enqueue_script( 'headroom',  get_theme_file_uri( 'assets/js/headroom.min.js' ), array( 'jquery' ), '0.9.3', true );

		wp_enqueue_script( 'jQuery.headroom',  get_theme_file_uri( 'assets/js/jQuery.headroom.min.js' ), array( 'jquery' ), '0.9.3', true );

		wp_enqueue_script( 'rt-sticky-nav-menu',  get_theme_file_uri( 'assets/js/sticky_nav_menu.min.js' ), array( 'jquery' ), '1.0.0', true );

	}

	if ( function_exists( 'WC' ) && rt_option( 'tooltip', null, false ) ) {
		wp_enqueue_script( 'jquery-ui-tooltip' );

	}

	wp_enqueue_script( 'rt-main',  get_theme_file_uri( 'assets/js/main.js' ), array( 'jquery' ), '1.0.0', true );

	wp_localize_script( 'rt-main', 'rt_main', array(
		'tooltip_on_off'        => rt_option( 'tooltip', null, false ),
		'tooltip_image'         => rt_option( 'tooltip_image', null, false ),
		'tooltip_title'         => rt_option( 'tooltip_title', null, false ),
		'tooltip_price'         => rt_option( 'tooltip_price', null, false ),
	) );
}
add_action( 'wp_enqueue_scripts', 'rt_enqueue_scripts' );

/**
 * Get default option for Raothue.
 *
 * @param  string $name Option key name to get.
 * @return mixin
 */
function rt_default( $name ) {
	static $defaults;

	if ( ! $defaults ) {
		$defaults = apply_filters( 'rt_defaults', array(
			'responsive'                   => true,
			'site_layout'                  => 'full',
			'site_width'                   => '1000',
			'widget_title_bg'              => '',
			'category_title_bg'            => '',
			'main_bg_color'                => '#ea2b33',
			'submenu_bg_color'             => '#484848',
			'sticky_nav_menu'              => false,
			'include_fb_sdk_js'            => false,
			'fb_language'                  => 'vi_VN',
			'facebook_app_id'              => '1491529591098383',
			'header_script'                => '',
			'header_script_on_off'         => true,
			'footer_script'                => '',
			'footer_script_on_off'         => true,
			'banner_left'                  => '',
			'banner_right'                 => '',
			'enable_header_search'         => true,
			'above_content_full_width'     => false,
			'thousands_sep'                => '.',
			'buy_now_btn'                  => false,
			'colums_product_lg'            => 'col-lg-3',
			'colums_product_md'            => 'col-md-4',
			'colums_product_sm'            => 'col-sm-6',
			'colums_product_xs'            => 'col-xs-12',
			'gutter_width'                 => 15,
			'quickview'                    => true,
			'quickview_mobile'             => false,
			'tooltip'                      => true,
			'tooltip_image'                => true,
			'tooltip_title'                => true,
			'tooltip_price'                => true,
			'vertical_mega_menu'           => false,
			'vertical_mega_menu_title'     => esc_html__( 'Danh mục sản phẩm', 'rt-theme' ),
			'related_on_off'               => 1,
			'related_product_items'        => 5,
			'related_slider_arrows'        => true,
			'related_slider_speed'         => 1000,
			'related_slider_show'          => 4,
			'related_slider_scroll'        => 1,
			'related_slider_autoplay'      => true,
			'related_slider_autoplayspeed' => 1000,
			'rt_callback_email'            => '',
			'rt_callback_subject'          => esc_html__( 'Yêu cầu gọi lại', 'rt-theme' ),
			'rt_callback_message'          => esc_html__( 'Có yêu cầu gọi lại theo số điện thoại', 'rt-theme' ),
			'rt_product_hotline'           => 'Hotline đặt hàng (07:00 - 22:00): <strong>093 777 83 77</strong> hoặc <strong>0976 79 5678</strong>',
			'totop'                        => true,
			'copyright'                    => '<a rel="nofollow" target="_blank" href="http://thietkewebmienphi.com/" title="thiet ke website">Design by RT Group</a>',
		) );
	}

	return isset( $defaults[ $name ] ) ? $defaults[ $name ] : null;
}

/**
 * Raothue Option.
 *
 * Get all options to setting for our theme.
 *
 * @param string    $name      option name.
 * @param string    $default     option default.
 * @param bool      $echo        echo or return.
 */
function rt_option( $name, $default = null, $echo = true ) {
	$name = sanitize_key( $name );

	if ( is_null( $default ) ) {
		$default = rt_default( $name );
	}

	$option = get_theme_mod( $name, $default );

	/**
	 * Apply filter to custom option value.
	 *
	 * @param string $option Option value.
	 *
	 * @var mixed
	 */
	$option = apply_filters( 'rt_option_' . $name, $option );

	if ( ! $echo ) {
		return $option;
	} else {
		echo $option; // WPCS: XSS OK.
	}

}

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since RT Theme 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function rt_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'rt_front_page_template' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since RT Theme 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function rt_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'rt_content_image_sizes_attr', 10, 2 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since RT Theme 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return string A source size value for use in a post thumbnail 'sizes' attribute.
 */
function rt_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'rt_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Custom template tags for this theme.
 */
require get_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
require get_theme_file_path( '/inc/template-functions.php' );

/**
 * Register customizer.
 */
require get_theme_file_path( '/inc/customizer.php' );

/**
 * Register custom Header.
 */
require get_theme_file_path( '/inc/custom-header.php' );

/**
 * Load woocommerce functions.
 */
require get_theme_file_path( '/inc/woocommerce.php' );

/**
 * Include the TGM_Plugin_Activation class.
 */
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';

/**
 * Register required plugins.
 */
require get_template_directory() . '/inc/tgm-register.php';

/**
 * Load Sidebar feature class.
 */
require get_template_directory() . '/inc/sidebar.php';

/**
 * Load RT Quickview feature class.
 */
if ( function_exists( 'WC' ) ) {
	require get_template_directory() . '/inc/quickview.php';
}
