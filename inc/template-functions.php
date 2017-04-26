<?php
/**
 * Additional features to allow styling of the templates
 *
 * @package Raothue
 * @subpackage RT_Theme
 * @since 1.0
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function rt_body_classes( $classes ) {
	// Add class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Add class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'rt-customizer';
	}

	// Add class on front page.
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'rt-front-page';
	}

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Add class if sidebar is used.
	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page() ) {
		$classes[] = 'has-sidebar';
	}

	// Add class if the site title and tagline is hidden.
	if ( 'blank' === get_header_textcolor() ) {
		$classes[] = 'title-tagline-hidden';
	}

	return $classes;
}
add_filter( 'body_class', 'rt_body_classes' );

/**
 * Adds custom classes to the array of layout classes.
 *
 * @param array $classes Classes for the layout element.
 */
function rt_layout_class( $classes = array() ) {
	$classes = (array) $classes;

	if ( RT_Sidebar::has_sidebar() ) {
		$classes[] = sprintf( 'sidebar-%s', RT_Sidebar::get_sidebar_area() );
	} else {
		$classes[] = 'no-sidebar';
	}

	$classes = apply_filters( 'rt_layout_class', $classes );

	echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
}

/**
 * Primary menu fallback function.
 */
function primary_menu_fallback() {
	$classes = rt_option( 'enable_header_search', null, false ) ? 'primary-menu-container visible-lg col-md-9' : 'primary-menu-container visible-lg col-md-12';

	$fallback_menu = '<div class="' . $classes . '"><ul id="primary-menu" class="menu clearfix"><li><a href="%1$s" rel="home">%2$s</a></li></ul></div>';
	printf( $fallback_menu, esc_url( home_url( '/' ) ), esc_html__( 'Trang chủ', 'rt-theme' ) ); // WPCS: XSS OK.
}

/**
 * Mobile menu fallback function.
 */
function mobile_menu_fallback() {
	$fallback_menu = '<ul id="mobile-menu" class="mobile-menu"><li><a href="%1$s" rel="home">%2$s</a></li></ul>';
	printf( $fallback_menu, esc_url( home_url( '/' ) ), esc_html__( 'Trang chủ', 'rt-theme' ) ); // WPCS: XSS OK.
}

// Fix Seo by yoast
add_filter( 'wpseo_canonical', '__return_false' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since RT Theme 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function rt_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<a class="link-more" href="%1$s" class="more-link">%2$s</a>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Đọc thêm &raquo;<span class="screen-reader-text"> "%s"</span>', 'rt-theme' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'rt_excerpt_more' );

/**
 * Enqueue RT login Stylesheet.
 */
function rt_login_stylesheet() {
	wp_enqueue_style( 'rt-login', get_theme_file_uri( 'assets/css/login.css' ) );
}
add_action( 'login_enqueue_scripts', 'rt_login_stylesheet' );

/**
 * Remove wp admin bar logo.
 */
function remove_wp_admin_bar_logo() {
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('wp-logo');
}
add_action('wp_before_admin_bar_render', 'remove_wp_admin_bar_logo', 0);

/**
 * Disable WP emojicons.
 */
function disable_wp_emojicons() {

	// all actions related to emojis
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	// filter to remove TinyMCE emojis
	add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'disable_wp_emojicons' );

/**
 * Disable WP emojicons.
 *
 * @param  array $plugins //
 * @return array          //
 */
function disable_emojicons_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Remove script version.
 *
 * @param  string $src //
 * @return string      //
 */
function rt_remove_script_version( $src ){
	$parts = explode( '?ver', $src );
	return $parts[0];
}
add_filter( 'script_loader_src', 'rt_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'rt_remove_script_version', 15, 1 );

if ( rt_option( 'include_fb_sdk_js', null, false ) ) {
	/**
	 * Include Facebook App ID on footer.
	 */
	function rt_include_facebook_app_id() {
		?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/<?php rt_option( 'fb_language' ); ?>/sdk.js#xfbml=1&version=v2.7&appId=<?php rt_option( 'facebook_app_id' ); ?>";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	<?php
	}
	add_action( 'wp_footer', 'rt_include_facebook_app_id' );
}

/**
 * Rt layout classes.
 *
 * @param array $classes CSS selector for own site.
 */
function rt_layout_classes( $classes = array() ) {
	$classes = (array) $classes;

	if ( 'boxed' == rt_option( 'site_layout', 'full', false ) ) {
		$classes[] = 'boxed';
	} else {
		$classes[] = 'full';
	}

	if ( '1000' == $site_width = rt_option( 'site_width', '1000', false ) ) {
		$classes[] = 'w1000';
	} elseif ( '1170' == $site_width ) {
		$classes[] = 'w1170';
	} elseif ( '1200' == $site_width ) {
		$classes[] = 'w1200';
	} else {
		$classes[] = 'w1000';
	}

	$classes = apply_filters( 'rt_layout_classes', $classes );

	echo 'class="' . esc_attr( join( ' ', $classes ) ) . '"';
}

/**
 * Excerpt lenght.
 *
 * @param  int $length Number to change excerpt length.
 * @return int         //
 */
function rt_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'rt_excerpt_length', 999 );

if ( '#ea2b33' != rt_option( 'main_bg_color', null, false ) ) {
/**
 * Css for our theme.
 *
 * @return string Css
 */
function rt_main_bg_color_option() {
	$css = '.main-navigation, .widget-title, .site-footer, .top-footer, .copyright, .mobile-menu-container .close-menu {background:' . rt_option( 'main_bg_color', null, false ) . ';}';
	$css .= '.header-search .search-form .search-submit {color:' . rt_option( 'main_bg_color', null, false ) . ';}';

	wp_add_inline_style( 'rt-main', $css );
}
add_action( 'wp_enqueue_scripts', 'rt_main_bg_color_option', 11 );
}

// Support shortcodes in rt textarea widgets
add_filter('rt_textarea_widget', 'do_shortcode');

/**
 * Display back to top text
 *
 * @param  boolean $echo Echo or return value of back to top button.
 * @return string        Back to top html.
 */
function rt_back_to_top( $echo = true ) {
	if ( ! $backtotop = rt_option( 'totop', true, false ) ) {
		return;
	}

	$btt_text = '<div id="backtotop" title="' . esc_html__( 'Lên đầu trang', 'rt-theme' ) . '"></div>';

	$btt_text = apply_filters( 'rt_back_to_top_html', $btt_text );

	if ( ! $echo ) {
		return $btt_text;
	}

	print $btt_text; // WPCS: XSS OK.
}

if ( rt_option( 'header_script', null, false ) && rt_option( 'header_script_on_off', null, false ) ) {
/**
 * Adds script on wp_head.
 *
 * @return string //
 */
function rt_header_script() {
	rt_option( 'header_script' );
}
add_action( 'wp_head', 'rt_header_script' );
}

if ( rt_option( 'footer_script', null, false ) && rt_option( 'footer_script_on_off', null, false ) ) {
/**
 * Adds script on wp_footer.
 *
 * @return string //
 */
function rt_footer_script() {
	rt_option( 'footer_script' );
}
add_action( 'wp_footer', 'rt_footer_script' );
}
