/**
 * Theme functions file
 *
 * Contains handlers for navigation, accessibility, header sizing
 * footer widgets and Featured Content slider
 *
 */

 var shopera = {};

jQuery(document).ready(function($) {
	( function( $ ) {
		var body    = $( 'body' ),
			_window = $( window );

		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('.scroll-to-top').fadeIn();
			} else {
				$('.scroll-to-top').fadeOut();
			}
		});

		$('.scroll-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});

		// Shrink header on scroll down
		if($('.site-header').length > 0) {
			var y = $(window).scrollTop();
			var padding_element = $('.slider');

			if ( padding_element.length === 0 ) {
				padding_element = $('#main');
			}

			if($(window).width() > 979) {
				masthead_height = $('.site-header').height();
				masthead_top    = $('.site-header').offset().top+$('.site-header').height()+50; 

				if( y > masthead_top ) { 
					$('.site-header').addClass('fixed'); 
					padding_element.css('padding-top', (masthead_height)+'px'); 
				}

				if( y > 150 ) {
					$('.site-header').addClass('shrink');
					$('body').addClass('sticky_header_active');
				} else {
					$('.site-header').removeClass('shrink');
					$('body').removeClass('sticky_header_active');
				}
				
				// Shrink menu on scroll
				var didScroll = false;
				$(window).scroll(function() {
					didScroll = true;
				});

				setInterval(function() {
					if ( didScroll ) {
						didScroll = false;
						y = $(window).scrollTop();

						if(y > masthead_top){ 
							$('.site-header').addClass('fixed'); 
							padding_element.css('padding-top', (masthead_height)+'px'); 
						}
						else{ 
							$('.site-header').removeClass('fixed'); 
							padding_element.css('padding-top', ''); 
						}
						if(y > 500){  
							$('.site-header').addClass('shrink'); $('body').addClass('sticky_header_active'); 
						}
						else{ 
							$('.site-header').removeClass('shrink'); $('body').removeClass('sticky_header_active'); 
						}
					}
				}, 50);
			} else {
				$('.site-header').removeClass('shrink');
				$('.site-header').removeClass('fixed');
			}

		} else {
			$('#page').addClass('static-header'); 
		}

		$('.search-form-submit').click(function() {
			if ( $(this).hasClass('active') ) {
				if ( $(this).parent().find('form .search-field').val() != '' ) {
					$(this).css('color', '#333');
					$(this).parent().find('form').submit();
				} else {
					$(this).css('color', '#e5534c');
				}
			} else {
				$(this).parent().find('form').stop().fadeIn();
			}
			$(this).addClass('active');
		})

		jQuery('.testimonial-container').jcarousel({
			wrap: "circular",
			animation: {
				duration: 0
			}
		}).jcarouselAutoscroll({
			interval: 5000,
			target: '+=1',
			autostart: true
		}).on("jcarousel:scroll", function(event, carousel) {
			jQuery("#tbtestimonial-listing").parent().hide().fadeIn(700);
		});

		if ( jQuery('.testimonial-container').length ) {
			jQuery('.testimonial-container').css({'left': '-'+jQuery('.testimonial-container').offset().left+'px', 'width': jQuery(window).width()+'px'});
			jQuery('.in-content-testimonial').css({'width': jQuery(window).width()+'px'});
		};

		if ( jQuery('.brand-carousel-container').length ) {
			jQuery('.brand-carousel-container').jcarousel({
				wrap: "circular",
				animation: {
					duration: 0
				}
			}).jcarouselAutoscroll({
				interval: 3000,
				target: '+=1',
				autostart: true
			}).on("jcarousel:scroll", function(event, carousel) {
				jQuery(".brand-carousel-container").hide().fadeIn(700);
			});
		};

		jQuery(window).resize(function() {
			if ( jQuery('.testimonial-container').length ) {
				jQuery('.testimonial-container').css({'left': '-'+jQuery('.site-content').offset().left+'px', 'width': jQuery(window).width()+'px'});
				jQuery('.in-content-testimonial').css({'width': jQuery(window).width()+'px'});
			};
		});

		// Enable menu toggle for small screens.
		( function() {
			var nav = $( '#primary-navigation' ), button, menu;
			if ( ! nav ) {
				return;
			}

			button = nav.find( '.menu-toggle' );
			if ( ! button ) {
				return;
			}

			// Hide button if menu is missing or empty.
			menu = nav.find( '.nav-menu' );
			if ( ! menu || ! menu.children().length ) {
				button.hide();
				return;
			}

			$( '.menu-toggle' ).on( 'click.shopera', function() {
				nav.toggleClass( 'toggled-on' );
			} );
		} )();

		/*
		 * Makes "skip to content" link work correctly in IE9 and Chrome for better
		 * accessibility.
		 *
		 * @link http://www.nczonline.net/blog/2013/01/15/fixing-skip-to-content-links/
		 */
		_window.on( 'hashchange.shopera', function() {
			var element = document.getElementById( location.hash.substring( 1 ) );

			if ( element ) {
				if ( ! /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) {
					element.tabIndex = -1;
				}

				element.focus();

				// Repositions the window on jump-to-anchor to account for header height.
				window.scrollBy( 0, -80 );
			}
		} );

		$( function() {

			/*
			 * Fixed header for large screen.
			 * If the header becomes more than 48px tall, unfix the header.
			 *
			 * The callback on the scroll event is only added if there is a header
			 * image and we are not on mobile.
			 */
			if ( _window.width() > 781 ) {
				var mastheadHeight = $( '#masthead' ).height(),
					toolbarOffset, mastheadOffset;

				if ( mastheadHeight > 48 ) {
					body.removeClass( 'masthead-fixed' );
				}

				if ( body.is( '.header-image' ) ) {
					toolbarOffset  = body.is( '.admin-bar' ) ? $( '#wpadminbar' ).height() : 0;
					mastheadOffset = $( '#masthead' ).offset().top - toolbarOffset;

					_window.on( 'scroll.shopera', function() {
						if ( ( window.scrollY > mastheadOffset ) && ( mastheadHeight < 49 ) ) {
							body.addClass( 'masthead-fixed' );
						} else {
							body.removeClass( 'masthead-fixed' );
						}
					} );
				}
			}

			// Focus styles for menus.
			$( '.primary-navigation, .secondary-navigation' ).find( 'a' ).on( 'focus.shopera blur.shopera', function() {
				$( this ).parents().toggleClass( 'focus' );
			} );
		} );
	} )( jQuery );

	jQuery('.comment-form-author input, .comment-form-email input, .comment-form-url input, .comment-form-comment textarea, .form-row input:not(.select2-focusser), .form-row textarea, .wpcf7-form input[type=email], .wpcf7-form input[type=text], .wpcf7-form textarea, .woocommerce form .form-row select').focus(function() {
		jQuery(this).parent().addClass('input-focused');
	});

	jQuery('.comment-form-author input, .comment-form-email input, .comment-form-url input, .comment-form-comment textarea, .form-row input:not(.select2-focusser), .form-row textarea, .wpcf7-form input[type=email], .wpcf7-form input[type=text], .wpcf7-form textarea, .woocommerce form .form-row select').blur(function() {
		if ( jQuery(this).val() == '' ) {
			jQuery(this).parent().removeClass('input-focused');
		} else {
			jQuery(this).parent().addClass('input-focused');
		}
	});

	jQuery('.wpcf7-form input[type=email], .wpcf7-form input[type=text], .wpcf7-form textarea').focus(function() {
		jQuery(this).parent().parent().addClass('cf-input-focused');
	});

	jQuery('.wpcf7-form input[type=email], .wpcf7-form input[type=text], .wpcf7-form textarea').blur(function() {
		if ( jQuery(this).val() == '' ) {
			jQuery(this).parent().parent().removeClass('cf-input-focused');
		} else {
			jQuery(this).parent().parent().addClass('cf-input-focused');
		}
	});

	if ( jQuery('.select2-container').length ) {
		jQuery('.select2-container')['0'].addEventListener('DOMSubtreeModified', select_changed, false);
	};
	
	if ( jQuery('#s2id_shipping_country').length ) {
		jQuery('#s2id_shipping_country')['0'].addEventListener('DOMSubtreeModified', select_changed, false);
	};

	function select_changed() {
		if ( jQuery(this).attr('class').indexOf("select2-dropdown-open") > 0 ) {
			jQuery(this).parent().addClass('input-focused');
		} else {
			jQuery(this).parent().removeClass('input-focused');
		}
	}

	jQuery('[for="billing_country"]').hide();

	jQuery('body.home .site-content').isotope();

});

jQuery( document ).ajaxStop(function() {
	jQuery('.cart-contents .cart-items').click(function() {
		if ( jQuery(this).hasClass('active') ) {
			jQuery('.cart-content-list').stop().fadeOut();
		} else {
			jQuery('.cart-content-list').stop().fadeIn();
		}
		jQuery(this).toggleClass('active');
	});
});

jQuery(window).load(function($) {
	jQuery('.comment-form-author input, .comment-form-email input, .comment-form-comment textarea, .form-row input, .form-row textarea').each(function() {
		if ( jQuery(this).val() != '' ) {
			jQuery(this).parent().addClass('input-focused');
		};
	});
	jQuery('body.home .site-content').isotope();
});