<?php
/**
 * RT Theme Customizer.
 *
 * @package Raothue
 * @since 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function rt_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector' => '.site-title a',
			'container_inclusive' => false,
			'render_callback' => 'rt_customize_partial_blogname',
		) );
		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector' => '.site-description',
			'container_inclusive' => false,
			'render_callback' => 'rt_customize_partial_blogdescription',
		) );
	}
}
add_action( 'customize_register', 'rt_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @since Raothue 1.0.0
 * @see rt_customize_register()
 *
 * @return void
 */
function rt_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since Raothue 1.0.0
 * @see rt_customize_register()
 *
 * @return void
 */
function rt_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function rt_customize_preview_js() {
	wp_enqueue_script( 'rt_customizer', get_theme_file_uri( 'assets/js/customizer.js' ), array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_preview_init', 'rt_customize_preview_js' );

/**
 * RT_Customizer_Manager Class.
 */
final class RT_Customizer_Manager {
	/**
	 * Register settings for the Theme Customizer.
	 */
	public static function init() {
		add_action( 'customize_register', array( __CLASS__, 'register' ) );
	}

	/**
	 * Register settings for the Theme Customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function register( WP_Customize_Manager $wp_customize ) {
		static::register_site_layout( $wp_customize );
		static::register_background( $wp_customize );
		static::register_script( $wp_customize );
		static::register_facebook( $wp_customize );
		static::register_rt_callback( $wp_customize );
		static::register_banner( $wp_customize );
		static::register_footer( $wp_customize );
		static::register_rt_general_option( $wp_customize );
	}

	/**
	 * Register site logo setting for the Theme Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function register_site_layout( WP_Customize_Manager $wp_customize ) {
		// Site logo settings.
		$wp_customize->add_setting( 'site_layout' , array(
			'default'           => rt_default( 'site_layout' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'site_layout', array(
			'section'   => 'title_tagline',
			'type'      => 'radio',
			'label'     => esc_html__( 'Chọn layout của giao diện', 'rt-theme' ),
			'priority'  => 50,
			'choices'   => array(
				'boxed' => esc_html__( 'Dạng thu gọn', 'rt-theme' ),
				'full'  => esc_html__( 'Dạng tràn chiều rộng', 'rt-theme' ),
			),
		) );

		// Site width settings.
		$wp_customize->add_setting( 'site_width' , array(
			'default'           => rt_default( 'site_width' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'site_width', array(
			'section'        => 'title_tagline',
			'type'           => 'select',
			'allow_addition' => true,
			'label'          => esc_html__( 'Chọn chiều rộng của giao diện', 'rt-theme' ),
			'priority'       => 51,
			'choices'        => array(
				'1000' => esc_html__( '1000px', 'rt-theme' ),
				'1170' => esc_html__( '1170px', 'rt-theme' ),
				'1200' => esc_html__( '1200px', 'rt-theme' ),
			),
		) );

		// Responsive settings.
		$wp_customize->add_setting( 'responsive' , array(
			'default'           => rt_default( 'responsive' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'responsive', array(
			'section'  => 'title_tagline',
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Bật/Tắt Responsive', 'rt-theme' ),
			'priority' => 52,
		) );

		// Sticky Nav Menu settings.
		$wp_customize->add_setting( 'sticky_nav_menu' , array(
			'default'           => rt_default( 'sticky_nav_menu' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'sticky_nav_menu', array(
			'section'  => 'title_tagline',
			'type'     => 'checkbox',
			'label'    => esc_html__( 'Bật/Tắt Sticky Menu', 'rt-theme' ),
			'priority' => 53,
		) );
	}

	/**
	 * Register backgroud setting for the Theme Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function register_background( WP_Customize_Manager $wp_customize ) {
		// Main background settings.
		$wp_customize->add_setting( 'main_bg_color' , array(
			'default'           => rt_default( 'main_bg_color' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
			'transport'         => 'postMessage',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'main_bg_color', array(
			'section'  => 'colors',
			'label'    => esc_html__( 'Chọn màu nền chủ đạo cho website', 'rt-theme' ),
			'priority' => 30,
		) ) );
	}

	/**
	 * Register site logo setting for the Theme Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	// public static function register_slider( WP_Customize_Manager $wp_customize ) {
	// 	// Slider section
	// 	$wp_customize->add_section( 'slider', array(
	// 		'title'    => esc_html__( 'Slider', 'rt-theme' ),
	// 		'priority' => 60,
	// 	) );
	// 	// Site slider settings.
	// 	$wp_customize->add_setting( 'slider' , array(
	// 		'default'           => rt_default( 'slider' ),
	// 		'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
	// 		'transport'         => 'postMessage',
	// 	) );

	// 	$sliders = get_posts( array(
	// 		'post_type'   => 'ml-slider',
	// 		'numberposts' => -1,
	// 	) );

	// 	$ml_ids = array();

	// 	foreach ( $sliders as $slider ) {
	// 		$ml_ids[$slider->ID] = $slider->post_title;
	// 	}

	// 	$wp_customize->add_control( 'slider', array(
	// 		'section'        => 'slider',
	// 		'type'           => 'select',
	// 		'label'          => esc_html__( 'Chọn slider muốn hiển thị', 'rt-theme' ),
	// 		'allow_addition' => true,
	// 		'choices'        => $ml_ids,
	// 	) );

	// 	$wp_customize->selective_refresh->add_partial( 'slider', array(
	// 		'selector'            => '',
	// 		'container_inclusive' => false,
	// 		'render_callback'     => 'rt_customize_partial_slider',
	// 	) );
	// }

	/**
	 * Register Script setting for the Theme Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function register_script( WP_Customize_Manager $wp_customize ) {
		// Facebook section
		$wp_customize->add_section( 'script', array(
			'title'    => esc_html__( 'Header/Footer Script', 'rt-theme' ),
			'priority' => 400,
		) );

		// Header script.
		$wp_customize->add_setting( 'header_script' , array(
			'default'           => rt_default( 'header_script' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'header_script', array(
			'type'        => 'textarea',
			'label'       => esc_html__( 'Header script', 'rt-theme' ),
			'description' => esc_html__( 'Dán nội dung để in script lên Header.', 'rt-theme' ),
			'section'     => 'script',
			'priority'    => 10,
		) );

		// Allow print Header script.
		$wp_customize->add_setting( 'header_script_on_off' , array(
			'default'           => rt_default( 'header_script_on_off' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'header_script_on_off', array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Cho phép nhúng Header script', 'rt-theme' ),
			'section'     => 'script',
			'priority'    => 20,
		) );

		// Footer script.
		$wp_customize->add_setting( 'footer_script' , array(
			'default'           => rt_default( 'banner_right' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'footer_script', array(
			'type'        => 'textarea',
			'label'       => esc_html__( 'Footer script', 'rt-theme' ),
			'description' => esc_html__( 'Dán nội dung để in script xuống Footer.', 'rt-theme' ),
			'section'     => 'script',
			'priority'    => 30,
		) );

		// Allow print Footer script.
		$wp_customize->add_setting( 'footer_script_on_off' , array(
			'default'           => rt_default( 'footer_script_on_off' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'footer_script_on_off', array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Cho phép nhúng Footer script', 'rt-theme' ),
			'section'     => 'script',
			'priority'    => 40,
		) );
	}

	/**
	 * Register site Footer setting for the Theme Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function register_footer( WP_Customize_Manager $wp_customize ) {
		$wp_customize->add_section( 'footer', array(
			'title'    => esc_html__( 'Chân trang', 'rt-theme' ),
			'priority' => 500,
		) );

		// Site Footer settings.
		$wp_customize->add_setting( 'totop' , array(
			'default'           => rt_default( 'totop' ),
			'transport' => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'totop', array(
			'type'      => 'checkbox',
			'section'   => 'footer',
			'label'     => esc_html__( 'Bật/Tắt nút back to top?', 'rt-theme' ),
		) );

		$wp_customize->selective_refresh->add_partial( 'totop', array(
			'selector' => '.backtotop',
			'container_inclusive' => false,
			'render_callback' => function () {
				rt_back_to_top();
			},
		) );

		// Footer copyright setting.
		$wp_customize->add_setting( 'copyright', array(
			'default'   => rt_default( 'copyright' ),
			'transport' => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'copyright', array(
			'type'    => 'textarea',
			'section' => 'footer',
			'label'   => esc_html__( 'Copyright', 'rt-theme' ),
			'description' => esc_html__( 'Nội dung cuối cùng của trang web.', 'rt-theme' ),
		) );

		$wp_customize->selective_refresh->add_partial( 'copyright', array(
			'selector'            => '.copyright',
			'container_inclusive' => false,
			'render_callback'     => function() {
				rt_option( 'copyright' );
			},
		) );
	}

	/**
	 * Register Facebook setting for the Theme Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function register_facebook( WP_Customize_Manager $wp_customize ) {
		// Facebook section
		$wp_customize->add_section( 'facebook', array(
			'title'    => esc_html__( 'Facebook', 'rt-theme' ),
			'priority' => 600,
		) );

		// Facebook SDK JS.
		$wp_customize->add_setting( 'include_fb_sdk_js' , array(
			'default'           => rt_default( 'include_fb_sdk_js' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'include_fb_sdk_js', array(
			'type'      => 'checkbox',
			'section'   => 'facebook',
			'label'     => esc_html__( 'Nhúng Facebook SDK Js?', 'rt-theme' ),
		) );

		// Facebook App ID.
		$wp_customize->add_setting( 'facebook_app_id' , array(
			'default'           => rt_default( 'facebook_app_id' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'facebook_app_id', array(
			'type'      => 'text',
			'section'   => 'facebook',
			'label'     => esc_html__( 'Facebook App ID', 'rt-theme' ),
		) );

		// Facebook Language.
		$wp_customize->add_setting( 'fb_language', array(
			'default'           => rt_default( 'fb_language' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'fb_language', array(
			'type'    => 'select',
			'section' => 'facebook',
			'label'   => esc_html__( 'Sử dụng ngôn ngữ Facebook', 'rt-theme' ),
			'choices' => array(
				'vi_VN'  => esc_html__( 'Tiếng Việt', 'rt-theme' ),
				'en_US'  => esc_html__( 'English', 'rt-theme' ),

			),
		) );
	}

	/**
	 * Register Callback setting for the Theme Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function register_rt_callback( WP_Customize_Manager $wp_customize ) {
		// Callback section
		$wp_customize->add_section( 'rt_callback', array(
			'title'    => esc_html__( 'Yêu cầu gọi lại', 'rt-theme' ),
			'priority' => 660,
		) );

		// Callback Email setting.
		$wp_customize->add_setting( 'rt_callback_email' , array(
			'default'           => rt_default( 'rt_callback_email' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'rt_callback_email', array(
			'label'       => esc_html__( 'Điền Email liên hệ nhận yêu cầu gọi lại' ),
			'section'     => 'rt_callback',
			'priority'    => 10,
		) );

		// Callback Email subject.
		$wp_customize->add_setting( 'rt_callback_subject' , array(
			'default'           => rt_default( 'rt_callback_subject' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'rt_callback_subject', array(
			'label'       => esc_html__( 'Điền tiêu đề Email gửi về' ),
			'section'     => 'rt_callback',
			'priority'    => 20,
		) );

		// Callback Email message.
		$wp_customize->add_setting( 'rt_callback_message' , array(
			'default'           => rt_default( 'rt_callback_message' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'rt_callback_message', array(
			'label'       => esc_html__( 'Điền nội dung Email gửi về' ),
			'section'     => 'rt_callback',
			'priority'    => 30,
		) );

		// Hotline.
		$wp_customize->add_setting( 'rt_product_hotline' , array(
			'default'           => rt_default( 'rt_product_hotline' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'rt_product_hotline', array(
			'label'       => esc_html__( 'Điền nội dung để hiển thị Hotline đặt hàng', 'rt-theme' ),
			'section'     => 'rt_callback',
			'priority'    => 40,
		) );

		$wp_customize->selective_refresh->add_partial( 'rt_product_hotline', array(
			'selector'            => '.psupport',
			'container_inclusive' => false,
			'render_callback'     => function() {
				rt_option( 'rt_product_hotline' );
			},
		) );
	}

	/**
	 * Register Banner setting for the Theme Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function register_banner( WP_Customize_Manager $wp_customize ) {
		// Facebook section
		$wp_customize->add_section( 'banner', array(
			'title'    => esc_html__( 'Banner 2 bên', 'rt-theme' ),
			'priority' => 700,
		) );

		// Banner left setting.
		$wp_customize->add_setting( 'banner_left' , array(
			'type'              => 'option',
			'default'           => rt_default( 'banner_left' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'banner_left', array(
			'label'       => esc_html__( 'Banner Trái' ),
			'description' => esc_html__( 'Upload ảnh chạy bên phải trái web.' ),
			'section'     => 'banner',
			'priority'    => 10,
			'height'      => 512,
			'width'       => 512,
		) ) );

		// Banner right setting.
		$wp_customize->add_setting( 'banner_right' , array(
			'type'              => 'option',
			'default'           => rt_default( 'banner_right' ),
			'transport'         => 'postMessage',
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'banner_right', array(
			'label'       => esc_html__( 'Banner Phải', 'rt-theme' ),
			'description' => esc_html__( 'Upload ảnh chạy bên phải trang web.', 'rt-theme' ),
			'section'     => 'banner',
			'priority'    => 20,
			'height'      => 512,
			'width'       => 512,
		) ) );
	}

	/**
	 * Register Global setting for the Theme Customizer
	 *
	 * @param  WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public static function register_rt_general_option( WP_Customize_Manager $wp_customize ) {
		// Global panel
		$wp_customize->add_panel( 'rt_general_option_panel', array(
			'title'    => esc_html__( 'Cài đặt khác', 'rt-theme' ),
			'priority' => 800,
		) );

		// Navigation section
		$wp_customize->add_section( 'navigation', array(
			'title'    => esc_html__( 'Menu Ngang', 'rt-theme' ),
			'priority' => 10,
			'panel'    => 'rt_general_option_panel',
		) );

		// Navigation setting.
		$wp_customize->add_setting( 'enable_header_search' , array(
			'default'           => rt_default( 'enable_header_search' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'enable_header_search', array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Bật/Tắt ô tìm kiếm', 'rt-theme' ),
			'description' => esc_html__( 'Check để bật/Uncheck để tắt', 'rt-theme' ),
			'panel'       => 'rt_general_option_panel',
			'section'     => 'navigation',
			'priority'    => 10,
		) );

		// Product section
		$wp_customize->add_section( 'product', array(
			'title'    => esc_html__( 'Sản phẩm', 'rt-theme' ),
			'priority' => 20,
			'panel'    => 'rt_general_option_panel',
		) );

		// Thousands sep setting.
		$wp_customize->add_setting( 'thousands_sep' , array(
			'default'           => rt_default( 'thousands_sep' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'thousands_sep', array(
			'label'       => esc_html__( 'Ngắn cách phần nghìn của giá sản phẩm', 'rt-theme' ),
			'description' => esc_html__( 'Điền dấu "." hoặc dấu ","', 'rt-theme' ),
			'panel'       => 'rt_general_option_panel',
			'section'     => 'product',
			'priority'    => 10,
		) );

		// Buy Now Btn setting.
		// $ưp_customize->add_setting( 'buy_nơ_btn' , ẩy(
		// 	'default'           => rt_default( 'buy_nơ_btn' ),
		// 	'sanitize_callback' => ẩy( __CLASS__, 'sanitize_value' ),
		// ) );

		// $ưp_customize->add_control( 'buy_nơ_btn', ẩy(
		// 	'type'        => 'checkbox',
		// 	'label'       => éc_html__( 'Bật/Tắt nút mua ngay', 'rt-thêm' ),
		// 	'description' => éc_html__( 'Check để bật/uncheck để tắt', 'rt-thêm' ),
		// 	'panel'       => 'rt_general_option_panel',
		// 	'section'     => 'product',
		// 	'priority'    => 20,
		// ) );

		// Above content section
		$wp_customize->add_section( 'above_content', array(
			'title'    => esc_html__( 'Phần trên nội dung', 'rt-theme' ),
			'priority' => 30,
			'panel'    => 'rt_general_option_panel',
		) );

		// Above content setting.
		$wp_customize->add_setting( 'above_content_full_width' , array(
			'default'           => rt_default( 'above_content_full_width' ),
			'sanitize_callback' => array( __CLASS__, 'sanitize_value' ),
		) );

		$wp_customize->add_control( 'above_content_full_width', array(
			'type'        => 'checkbox',
			'label'       => esc_html__( 'Rộng toàn màn hình cho Phần trên nội dung', 'rt-theme' ),
			'description' => esc_html__( 'Check để bật/uncheck để tắt', 'rt-theme' ),
			'panel'       => 'rt_general_option_panel',
			'section'     => 'above_content',
			'priority'    => 10,
		) );
	}

	/**
	 * Sanitize raw value.
	 *
	 * @param  mixed $value Raw string value.
	 * @return string
	 */
	public static function sanitize_value( $value ) {
		return $value;
	}
}

/**
 * Fire system settings.
 */
RT_Customizer_Manager::init();
