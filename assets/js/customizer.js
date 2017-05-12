/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {
	var style = $( '#rt-color-scheme-css' ),
		api = wp.customize;

	if ( ! style.length ) {
		style = $( 'head' ).append( '<style type="text/css" id="rt-color-scheme-css" />' )
		                    .find( '#rt-color-scheme-css' );
	}
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
    wp.customize( 'header_textcolor', function( value ) {
        value.bind( function( to ) {
            if ( 'blank' === to ) {
                $( '.site-title a, .site-description' ).css( {
                    'clip': 'rect(1px, 1px, 1px, 1px)',
                    'position': 'absolute'
                } );
            } else {
                $( '.site-title a, .site-description' ).css( {
                    'clip': 'auto',
                    'position': 'relative'
                } );
                $( '.site-title a, .site-description' ).css( {
                    'color': to
                } );
            }
        } );
    } );

	// Body Background color.
	wp.customize( 'background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( 'body' ).css( {
					'background': 'transparent',
				} );
			} else {
				$( 'body' ).css( {
					'background': to,
				} );
			}
		} );
	} );

	// Main Background color.
	wp.customize( 'main_bg_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.main-navigation, .widget-title, .site-footer, .top-footer, .copyright, .close-menu' ).css( {
					'background': 'transparent',
				} );
			} else {
				$( '.main-navigation, .widget-title, .site-footer, .top-footer, .copyright, .close-menu' ).css( {
					'background': to,
				} );
			}
		} );
	} );

      // Submenu Background color.
      wp.customize( 'submenu_bg_color', function( value ) {
        value.bind( function( to ) {
          if ( 'blank' === to ) {
            $( '#primary-menu li ul.sub-menu' ).css( {
              'background': 'transparent',
            } );
          } else {
            $( '#primary-menu li ul.sub-menu' ).css( {
              'background': to,
            } );
          }
        } );
      } );

	// Link color.
	wp.customize( 'link_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( 'a' ).css( {
					'color': 'transparent',
				} );
			} else {
				$( 'a' ).css( {
					'color': to,
				} );
			}
		} );
	} );

	// Link hover color.
	wp.customize( 'link_hover_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( 'a:hover' ).css( {
					'color': 'transparent',
				} );
			} else {
				$( 'a:hover' ).css( {
					'color': to,
				} );
			}
		} );
	} );

	// Text color.
	wp.customize( 'text_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( 'body' ).css( {
					'color': 'transparent',
				} );
			} else {
				$( 'body' ).css( {
					'color': to,
				} );
			}
		} );
	} );

	// Slick arrow background color.
	wp.customize( 'text_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.slick-arrow' ).css( {
					'background': 'transparent',
				} );
			} else {
				$( '.slick-arrow' ).css( {
					'background': to,
				} );
			}
		} );
	} );

	// Border Topbar color.
	wp.customize( 'border_topbar_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.topbar' ).css( {
					'border-top-color': 'transparent',
				} );
			} else {
				$( '.topbar' ).css( {
					'border-top-color': to,
				} );
			}
		} );
	} );

	// Topbar background color.
	wp.customize( 'topbar_background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.topbar' ).css( {
					'background': 'transparent',
				} );
			} else {
				$( '.topbar' ).css( {
					'background': to,
				} );
			}
		} );
	} );

	// Header background color.
	wp.customize( 'header_background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-header' ).css( {
					'background': 'transparent',
				} );
			} else {
				$( '.site-header' ).css( {
					'background': to,
				} );
			}
		} );
	} );

	// Content background color.
	wp.customize( 'content_background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '#layout' ).css( {
					'background': 'transparent',
				} );
			} else {
				$( '#layout' ).css( {
					'background': to,
				} );
			}
		} );
	} );

	// Top Footer background color.
	wp.customize( 'top_footer_background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.top-footer' ).css( {
					'background': 'transparent',
				} );
			} else {
				$( '.top-footer' ).css( {
					'background': to,
				} );
			}
		} );
	} );

	// Bottom Footer background color.
	wp.customize( 'bottom_footer_background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.botom-footer' ).css( {
					'background': 'transparent',
				} );
			} else {
				$( '.bottom-footer' ).css( {
					'background': to,
				} );
			}
		} );
	} );

	// Copyright background color.
	wp.customize( 'copyright_background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.copyright' ).css( {
					'background': 'transparent',
				} );
			} else {
				$( '.copyright' ).css( {
					'background': to,
				} );
			}
		} );
	} );

	// Menu background color.
	wp.customize( 'menu_background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.main-navigation' ).css( {
					'background': 'transparent',
				} );
			} else {
				$( '.main-navigation' ).css( {
					'background': to,
				} );
			}
		} );
	} );

	// Menu link color.
	wp.customize( 'menu_link_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.main-navigation a' ).css( {
					'color': 'transparent',
				} );
			} else {
				$( '.main-navigation a' ).css( {
					'color': to,
				} );
			}
		} );
	} );

	// Menu hover background color.
	wp.customize( 'menu_hover_background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.main-navigation ul.sub-menu li, .main-navigation ul.menu li ul.sub-menu' ).css( {
					'border-bottom-color': 'transparent',
				} );
			} else {
				$( '.main-navigation ul.sub-menu li, .main-navigation ul.menu li ul.sub-menu' ).css( {
					'border-bottom-color': to,
				} );
			}
		} );
	} );

	// Menu background color.
	wp.customize( 'submenu_background_color', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.main-navigation ul.menu li ul.sub-menu, .current-menu-item, .current_page_parent' ).css( {
					'background': 'transparent',
				} );
                          $( '.header-search .search-form .search-submit' ).css( {
                              'color': 'transparent',
                          } );
                    } else {
                          $( '.main-navigation ul.menu li ul.sub-menu, .current-menu-item, .current_page_parent' ).css( {
                            'background': to,
                          } );
                          $( '.header-search .search-form .search-submit' ).css( {
                              'color': to,
                          } );
			}
		} );
	} );

    // Gutter width.
    wp.customize( 'gutter_width', function( value ) {
        value.bind( function( to ) {
            if ( ! to ) {
                $( '.rt__grid_products .product' ).css({
                    'padding-left': '15px',
                    'padding-right': '15px',
                });
                $( '.rt__grid_products.row' ).css({
                    'margin-left': '-15px',
                    'margin-right': '-15px',
                });
            } else {
                $( '.rt__grid_products .product' ).css({
                    'padding-left': to + 'px',
                    'padding-right': to + 'px',
                });
                $( '.rt__grid_products.row' ).css({
                    'margin-left': '-' + to + 'px',
                    'margin-right': '-' + to + 'px',
                });
            }
        } );
    } );

    // vertical_mega_menu_title.
  wp.customize( 'vertical_mega_menu_title', function( value ) {
    value.bind( function( to ) {
      $( '.vertical-mega-menu-title' ).text( to );
    } );
  } );

    // Copyright background color.
    wp.customize( 'copyright', function( value ) {
        value.bind( function( to ) {
            if ( '' == to ) {
                $( '.copyright' ).css({
                    display: 'none',
                });
            } else {
                $( '.copyright' ).css({
                    display: 'block',
                });
            }
        } );
    } );

    // Copyright background color.
    wp.customize( 'quickview', function( value ) {
        value.bind( function( to ) {
            if ( ! to ) {
                $( '.rt-wcqv-button' ).css({
                    display: 'none',
                });
            } else {
                $( '.rt-wcqv-button' ).css({
                    display: 'block',
                });
            }
        } );
    } );

	// Color Scheme CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			style.html( css );
		} );
	} );
} )( jQuery );
