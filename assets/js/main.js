(function($) {
    "use strict";

    // backtop functions
    $( '#backtotop' ).on( 'click', function () {
      $( 'html, body' ).animate( { scrollTop: 0 }, 800 );
      return false;
    });

    $( window ).on( 'scroll', function () {
      if ( $( this ).scrollTop() > 100 ) {
        $( '#backtotop' ).fadeIn( 1000, function() {
          $( 'span' , this ).fadeIn( 100 );
        });
      } else {
        $( '#backtotop' ).fadeOut( 1000, function() {
          $( 'span' , this ).fadeOut( 100 );
        });
      }
    });
    // end function backtop

    $('.mobile-menu .menu-item-has-children, .vertical-mega-mobile-menu .menu-item-has-children').prepend('<i class="fa fa-angle-down"></i>');

    $('.mobile-menu .menu-item-has-children > i, .vertical-mega-mobile-menu .menu-item-has-children > i').click(function(event) {
      $(this).parent().toggleClass('active');
    });

    $('#menu-toggle, .mobile-menu-container .close-menu').click(function(event) {
       $('.site').toggleClass('mobile-menu-active');
    });

    $('#mega-menu-toggle, .vertical-mega-mobile-menu .close-menu').click(function(event) {
       $('.site').toggleClass('vertical-mega-mobile-menu-active');
    });

    $('.vertical-mega-mobile-menu-active .overlay').click(function(event) {
        $('.site').removeClass('vertical-mega-mobile-menu-active');
    });

    $('.mobile-menu-active .overlay').click(function(event) {
        $('.site').removeClass('mobile-menu-active');
    });

    if ( rt_main.tooltip_on_off ) {
        $('.site-main').tooltip({
            track: true,
            items: '[data-tooltip]',
            content: function() {
                var tooltip_json = $(this).data( 'tooltip' );
                var title = $(this).parent( '.product_item' ).find('.rt_woocommerce-loop-product__title a').text();
                var price = $(this).parent( '.product_item' ).find('.price').html();
                var html = '';

                if ( rt_main.tooltip_image ) {
                    html += '<div class="tooltip_image"><img src="' + tooltip_json.image + '" alt=""></div>';
                }

                if ( rt_main.tooltip_title ) {
                    html +=  '<div class="tooltip_title">' + title + '</div>';
                }

                if ( rt_main.tooltip_price ) {
                    html += '<div class="tooltip_price">' + price + '</div>';
                }

                return html;
            }
        });
    }

})(jQuery);
