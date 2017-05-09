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

    // Menu Mobile
    // $('.main-menu-mobile').each( function() {

    //   var menu = $( '.main-menu-mobile' );
    //   menu.find( '.menu-item-has-children > a' ).after( '<button class="dropdown-toggle" aria-expanded="false"></button>' );

    //   $('.secondary-toggle').click( function(){
    //     menu.slideToggle('500');
    //     $( this ).toggleClass( 'toggled-on' );
    //   });

    //   $( '.dropdown-toggle', this ).click( function(){
    //     $( this ).toggleClass( 'toggled-on' );
    //     $( this ).next( '.children, .sub-menu' ).toggleClass( 'toggled-on' );
    //   });

    //   $( '.close-menu' ).click( function() {
    //     $( '.main-menu-mobile' ).hide( '700' );
    //   });

    // });
    // end function Menu Mobile

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

    // $('.rt__posts_sliders').slick({
    //   speed: 300,
    //   slidesToShow: 3,
    //   slidesToScroll: 1,
    //   autoplay: true,
    //   autoplaySpeed: 10000,
    //   arrows: true,
    //   prevArrow: '<button type="button" class="slick-prev"></button>',
    //   nextArrow: '<button type="button" class="slick-next"></button>',
    //   responsive: [
    //   {
    //     breakpoint: 769,
    //     settings: {
    //       slidesToShow: 2,
    //       slidesToScroll: 1,
    //       arrows: true,
    //     }
    //   },
    //   {
    //     breakpoint: 321,
    //     settings: {
    //       slidesToShow: 1,
    //       slidesToScroll: 1,
    //       arrows: true,
    //     }
    //   },
    //   ]
    // });

    if ( tooltip.on_off ) {
        $('.site-main').tooltip({
            track: true,
            items: '[data-tooltip]',
            content: function() {
                var tooltip_json = $(this).data( 'tooltip' );
                var title = $(this).find('.rt_woocommerce-loop-product__title a').text();
                var price = $(this).find('.price').html();
                var html = '';

                if ( tooltip.image ) {
                    html += '<div class="tooltip_image"><img src="' + tooltip_json.image + '" alt=""></div>';
                }

                if ( tooltip.title ) {
                    html +=  '<div class="tooltip_title">' + title + '</div>';
                }

                if ( tooltip.price ) {
                    html += '<div class="tooltip_price">' + price + '</div>';
                }

                return html;
            }
        });
    }

})(jQuery);
