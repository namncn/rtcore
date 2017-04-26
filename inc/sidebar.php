<?php
/**
 * Sidebar feature support for Raothue theme.
 *
 * @package Raothue
 */

/**
 * Raothue Sidebar Class.
 */
final class RT_Sidebar {
	/**
	 * //
	 *
	 * @var string
	 */
	protected static $cache_setting = array();

	/**
	 * Conditionally hook into WordPress.
	 */
	public static function init() {
		// add_action( 'rtfw_init', array( __CLASS__, 'register_metabox' ) );
		// add_action( 'rtfw_init', array( __CLASS__, 'register_termmeta' ) );
		add_action( 'customize_register', array( __CLASS__, 'register_customizer' ) );
	}

	/**
	 * Get sidebar name in current screen.
	 *
	 * @param string $name //
	 * @return string
	 */
	public static function get_sidebar( $name = '' ) {
		return static::has_sidebar() ? static::get_setting( $name ) : '';
	}

	/**
	 * Get sidebar area in current screen.
	 *
	 * @return string
	 */
	public static function get_sidebar_area() {
		return static::get_setting( 'area' );
	}

	/**
	 * If current screen is no sidebar.
	 *
	 * @return boolean
	 */
	public static function is_no_sidebar() {
		return static::get_setting( 'area' ) === 'none';
	}

	/**
	 * If current screen have a sidebar.
	 *
	 * @return boolean
	 */
	public static function has_sidebar( $name = '' ) {
		if ( 'left_sidebar_name' == $name ) {
			$sidebar = static::get_setting( 'left_sidebar_name' );
		} elseif ( 'right_sidebar_name' == $name ) {
			$sidebar = static::get_setting( 'right_sidebar_name' );
		} else {
			$sidebar = static::get_setting( 'area' ) !== 'none';
		}

		if ( ! empty( $sidebar ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get sidebar setting in current screen.
	 *
	 * @param  string $get Key name to get.
	 * @return string|array
	 */
	public static function get_setting( $get = null ) {
		if ( $setting = static::$cache_setting ) {
			return isset( $setting[ $get ] ) ? $setting[ $get ] : $setting;
		}

		/**
		 * //
		 *
		 * @var array
		 */
		$default = array(
			'left_sidebar_name'  => static::default_sidebar( 'sidebar-1' ),
			'right_sidebar_name' => static::default_sidebar( 'sidebar-2' ),
			'area'               => static::default_area( 'left' ),
		);

		$options = (array) get_option( 'rt-sidebar', array() );

		foreach ( static::allowed_pages() as $id => $name ) {
			if ( isset( $options[ $id ] ) ) {
				$options[ $id ] = wp_parse_args( $options[ $id ], $default );
			} else {
				$options[ $id ] = $default;
			}
		}

		/**
		 * //
		 *
		 * @var array
		 */
		$setting = $default;

		if ( is_category() || is_tag() || is_tax() ) {

			$setting = $options['category']; // Change "archive" to "category" if Category enable.

			$term = get_queried_object();
			$meta_data = get_term_meta( $term->term_id, 'rt-sidebar', true );

			if ( is_array( $meta_data ) && ! empty( $meta_data['is_overwrite'] ) ) {
				unset( $meta_data['is_overwrite'] );
				$setting = wp_parse_args( $meta_data, $options['archive'] ); // Change "archive" to "category" if Category enable.
			}
		} elseif ( is_single() || is_page() && ! is_front_page() ) {

			$key = is_single() ? 'single' : 'page';
			$setting = $options[ $key ];

			$meta_data = get_post_meta( get_the_ID(), 'rt-sidebar', true );

			if ( is_array( $meta_data ) && ! empty( $meta_data['is_overwrite'] ) ) {
				unset( $meta_data['is_overwrite'] );
				$setting = wp_parse_args( $meta_data, $options[ $key ] );
			}
		} elseif ( is_archive() || is_search() ) {

			$setting = $options['archive'];

		} elseif ( is_home() ) {

			$setting = $options['home'];

		} elseif ( is_front_page() ) {

			$setting = $options['front'];
		}

		/**
		 * //
		 *
		 * @var array
		 */
		static::$cache_setting = apply_filters( 'rt_get_sidebar_setting', $setting, $options );

		return isset( static::$cache_setting[ $get ] ) ? static::$cache_setting[ $get ] : static::$cache_setting;
	}

	/**
	 * Allowed pages can register in customizer.
	 *
	 * @return array
	 */
	protected static function allowed_pages() {
		return array(
			'front'    => esc_html__( 'Trang Chủ', 'rt-theme' ),
			'home'     => esc_html__( 'Trang Tin tức', 'rt-theme' ),
			'category' => esc_html__( 'Trang Chuyên mục', 'rt-theme' ),
			'archive'  => esc_html__( 'Trang Lưu trữ chung', 'rt-theme' ),
			'page'     => esc_html__( 'Trang Tĩnh', 'rt-theme' ),
			'single'   => esc_html__( 'Trang Bài viết', 'rt-theme' ),
		);
	}

	/**
	 * Add settings to the Customizer.
	 *
	 * @param WP_Customize_Manager $wp_customize Customizer object.
	 */
	public static function register_customizer( $wp_customize ) {
		$wp_customize->add_panel( 'rt_sidebar', array(
			'title'          => esc_html__( 'Thanh bên', 'rt-theme' ),
			'theme_supports' => '',
		) );

		foreach ( static::allowed_pages() as $id => $name ) {
			$id = sanitize_key( $id );
			$section_id = sprintf( 'rt_sidebar_%s', $id );

			$left_sidebar_id = sprintf( 'rt-sidebar[%s][left_sidebar_name]', $id );
			$right_sidebar_id = sprintf( 'rt-sidebar[%s][right_sidebar_name]', $id );
			$sidebar_area_id = sprintf( 'rt-sidebar[%s][area]', $id );

			// Add Customizer Section.
			$wp_customize->add_section( $section_id, array(
				'title' => $name,
				'panel' => 'rt_sidebar',
			) );

			// Add Customizer Settings.
			$wp_customize->add_setting( $sidebar_area_id, array(
				'default'           => static::default_area( 'left' ),
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_key',
			) );

			// Add Customizer Controls.
			$wp_customize->add_control( $sidebar_area_id, array(
				'type'    => 'select',
				'section' => $section_id,
				'label'   => esc_html__( 'Kiểu hiển thị Thanh bên', 'rt-theme' ),
				'choices' => static::sidebar_area(),
			) );

			// Add Customizer Settings.
			$wp_customize->add_setting( $left_sidebar_id, array(
				'default'           => static::default_sidebar( 'sidebar-1' ),
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_key',
			) );

			// Add Customizer Controls.
			$wp_customize->add_control( $left_sidebar_id, array(
				'type'    => 'select',
				'section' => $section_id,
				'label'   => esc_html__( 'Thanh bên Trái', 'rt-theme' ),
				'choices' => static::registered_sidebars(),
			) );

			// Add Customizer Settings.
			$wp_customize->add_setting( $right_sidebar_id, array(
				'default'           => static::default_sidebar( 'sidebar-2' ),
				'type'              => 'option',
				'sanitize_callback' => 'sanitize_key',
			) );

			// Add Customizer Controls.
			$wp_customize->add_control( $right_sidebar_id, array(
				'type'    => 'select',
				'section' => $section_id,
				'label'   => esc_html__( 'Thanh bên Phải', 'rt-theme' ),
				'choices' => static::registered_sidebars(),
			) );
		}
	}

	/**
	 * Register sidebar metabox.
	 *
	 * @param  RTFW $rtfw RTFW Instance.
	 */
	public static function register_metabox( RTFW $rtfw ) {
		$screen = apply_filters( 'rt_sidebar_metabox_screen', array( 'post', 'page', 'product' ) );

		$args = array(
			'title'   => esc_html__( 'Kiểu hiển thị Thanh bên', 'rt-theme' ),
			'screen'  => $screen,
			'fields'  => static::metabox_fields(),
			'context' => 'side',
		);

		$rtfw->register_metabox( new RTFW_Metabox( 'rt-sidebar', $args ) );
	}

	/**
	 * Register sidebar term meta.
	 *
	 * @param  RTFW $rtfw RTFW Instance.
	 */
	public static function register_termmeta( RTFW $rtfw ) {
		/**
		 * //
		 *
		 * @var string|array
		 */
		$taxonomy = apply_filters( 'rt_sidebar_taxonomy', array( 'category', 'post_tag', 'product_cat', 'product_tag' ) );

		/**
		 * //
		 *
		 * @var array
		 */
		$args = array(
			'id'       => 'rt-sidebar',
			'title'    => esc_html__( 'Kiểu hiển thị Thanh bên', 'rt-theme' ),
			'taxonomy' => $taxonomy,
		);

		/**
		 * Register term metabox.
		 */
		$rtfw->register_term_metabox( $args, static::metabox_fields() );
	}

	/**
	 * //
	 *
	 * @return array
	 */
	protected static function metabox_fields() {
		return array(
			array(
				'id'      => 'is_overwrite',
				'type'    => 'checkbox',
				'label'   => esc_html__( 'Sử dụng cài đặt Thanh bên?', 'rt-theme' ),
				'default' => false,
			),
			array(
				'id'         => 'area',
				'type'       => 'select',
				'title'      => esc_html__( 'Kiểu hiển thị Thanh bên', 'rt-theme' ),
				'options'    => static::sidebar_area(),
				'default'    => static::default_area( 'left' ),
				'dependency' => array( 'is_overwrite', '==', 'true' ),
			),
			array(
				'id'         => 'left_sidebar_name',
				'type'       => 'select',
				'title'      => esc_html__( 'Thanh bên Trái', 'rt-theme' ),
				'options'    => static::registered_sidebars(),
				'default'    => static::default_sidebar( 'sidebar-1' ),
				'dependency' => array( 'is_overwrite|area', '==|!=', 'true|none' ),
			),
			array(
				'id'         => 'right_sidebar_name',
				'type'       => 'select',
				'title'      => esc_html__( 'Thanh bên Phải', 'rt-theme' ),
				'options'    => static::registered_sidebars(),
				'default'    => static::default_sidebar( 'sidebar-2' ),
				'dependency' => array( 'is_overwrite|area', '==|!=', 'true|none' ),
			),
		);
	}

	/**
	 * //
	 *
	 * @param string $default //
	 * @return string
	 */
	public static function default_sidebar( $default  = '' ) {
		if ( 'sidebar-1' === $default ) {
			$default_sidebar = 'sidebar-1';
		} else {
			$default_sidebar = 'sidebar-2';
		}

		return apply_filters( 'rt_sidebar_default', $default_sidebar );
	}

	/**
	 * //
	 *
	 * @param string $default //
	 * @return string
	 */
	public static function default_area( $default  = '' ) {
		if ( 'left' === $default ) {
			$default_sidebar = 'left';
		} elseif ( 'right' ) {
			$default_sidebar = 'right';
		} else {
			$default_sidebar = 'both';
		}

		return apply_filters( 'rt_sidebar_area_default', $default_sidebar );
	}

	/**
	 * Get default sidebar area.
	 *
	 * @return array
	 */
	public static function sidebar_area() {
		$sidebar_area = array(
			'none'  => esc_html__( 'Nội dung', 'rt-theme' ),
			'left'  => esc_html__( 'Thanh bên/Nội dung', 'rt-theme' ),
			'right' => esc_html__( 'Nội dung/Thanh bên', 'rt-theme' ),
			'both'  => esc_html__( 'Thanh bên/Nội dung/Thanh bên', 'rt-theme' ),
		);

		/**
		 * Apply filter and return sidebar area.
		 */
		return apply_filters( 'rt_sidebar_area', $sidebar_area );
	}

	/**
	 * Get WP registered sidebar.
	 *
	 * @return array
	 */
	public static function registered_sidebars() {
		global $wp_registered_sidebars;

		$sidebars = array();

		foreach ( $wp_registered_sidebars as $id => $sidebar ) {
			$sidebars[ $id ] = $sidebar['name'];
		}

		return $sidebars;
	}
}

RT_Sidebar::init();
