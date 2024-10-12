(function($) {

	"use strict";

	// button animation
	$(function() {
		$('.btn-1, .btn-2')
		.on('mouseenter', function(e) {
				var parentOffset = $(this).offset(),
				relX = e.pageX - parentOffset.left,
				relY = e.pageY - parentOffset.top;
				$(this).find('span').css({top:relY, left:relX})
		})
		.on('mouseout', function(e) {
				var parentOffset = $(this).offset(),
				relX = e.pageX - parentOffset.left,
				relY = e.pageY - parentOffset.top;
			$(this).find('span').css({top:relY, left:relX})
		});
	});
	// button animation

	// select2 start
    function formatState(state) {
		if (!state.id) {
			return state.text;
		}
		var baseUrl = "assets/images/mini-flag";
		var $state = $(
			'<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.svg" class="img-flag" /> ' + state.text + '</span>'
		);

		// Check if subtitle exists
		var subtitle = $(state.element).data('subtitle');
		if(subtitle) {
			$state.append('<br/><span class="subtitle">' + subtitle + '</span>');
		}
		return $state;
	};

	$('.cmn-select2-image2').select2({
		templateResult: formatState,
		templateSelection: formatState
	});

	$('.cmn-select2-image3').select2({
		templateResult: formatState,
		templateSelection: formatState
	});

	$('.cmn-select2-image4').select2({
		templateResult: formatState,
		templateSelection: formatState
	});
	// select2 end

	// INCREMENT DECREMENT COUNT START
	document.addEventListener('DOMContentLoaded', function() {
		// Function to handle count functionality
		function setupCountSection(selector, incrementSelector, decrementSelector) {
			const countElements = document.querySelectorAll(selector);
			const incrementButtons = document.querySelectorAll(incrementSelector);
			const decrementButtons = document.querySelectorAll(decrementSelector);

			let count = 0;

			function updateCount() {
				countElements.forEach(element => {
					element.textContent = count;
				});
			}

			incrementButtons.forEach(button => {
				button.addEventListener('click', function() {
					count++;
					updateCount();
				});
			});

			decrementButtons.forEach(button => {
				button.addEventListener('click', function() {
					if (count > 0) {
						count--;
						updateCount();
					}
				});
			});
		}

		// Setup count functionality for adults
		setupCountSection('.adult', '.increment', '.decrement', 0);

		// Setup count functionality for children
		setupCountSection('.childeren', '.incrementTwo', '.decrementTwo', 0);

		// Setup count functionality for room
		setupCountSection('.room', '.incrementThree', '.decrementThree', 0);
	});
	// INCREMENT DECREMENT COUNT END

	// count-container toggle
	$(document).ready(function() {
		$('.count-counter').click(function(event) {
			event.stopPropagation(); // Prevent the click event from propagating to the document
			$('.count-container').slideToggle(500);
		});

		$(document).click(function(event) {
			if (!$(event.target).closest('.count-counter').length && !$(event.target).closest('.count-container').length) {
				$('.count-container').slideUp(500);
			}
		});
	});
	// count-container toggle


	// // Social share start
	// $("#shareBlock").socialSharingPlugin({
	// 	urlShare: window.location.href,
	// 	description: $("meta[name=description]").attr("content"),
	// 	title: $("title").text(),
	// });
	// // Social share end

	// LOAD MORE STARTS
	$('.item-list').slice(0,2).show();

	$('.load-more').click(function(){
		$('.item-list:hidden').slice(0,1).slideDown(300);

		// hide btn after fully loaded
		if($('.item-list:hidden').length==0){
			$(this).fadeOut(300);
		}
	});
	// LOAD MORE ENDS

	// Tab box
	if ($('.quote-tab').length) {
		$('.quote-tab .tabs-button-box .tab-btn-item').on('click', function (e) {
			e.preventDefault();
			var target = $($(this).attr('data-tab'));

			if ($(target).hasClass('actve-tab')) {
			return false;
			} else {
			$('.quote-tab .tabs-button-box .tab-btn-item').removeClass('active-btn-item');
			$(this).addClass('active-btn-item');
			$('.quote-tab .tabs-content-box .tab-content-box-item').removeClass('tab-content-box-item-active');
			$(target).addClass('tab-content-box-item-active');
			}
		});
	}
	// Tab box

	// // flatpickr date and time
	// $(".flatpickr").flatpickr({
	// 	altInput: true,
	// 	altFormat: "d/m/y",
	// 	dateFormat: "Y-m-d",
	// 	mode: "multiple" ,
	// 	minDate: "today" ,
	// 	maxDate: "2024-05-15"
	// });
	// flatpickr date and time

	// odommeter
	if ($(".odometer").length) {
		var odo = $(".odometer");
		odo.each(function () {
		  $(this).appear(function () {
			var countNumber = $(this).attr("data-count");
			$(this).html(countNumber);
		  });

		});
	}
	// odommeter

	// magnifipopup video
	$(document).ready(function() {
		$('.hv-popup-link').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,

			fixedContentPos: false
		});
	});
	// magnifipopup video

	// magnifipopup video 2
	$(document).ready(function() {
		$('.video-link').magnificPopup({
			disableOn: 700,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,

			fixedContentPos: false
		});
	});
	// magnifipopup video 2


	//Price Range Slider
	// if ($('.price-range-slider').length) {
	// 	$(".price-range-slider").slider({
	// 		range: true,
	// 		min: 0,
	// 		max: 500,
	// 		values: [0, 500],
	// 		slide: function (event, ui) {
	// 			$("input.property-amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
	// 		}
	// 	});
	//
	// 	$("input.property-amount").val("$" + $(".price-range-slider").slider("values", 0) + " - $" + $(".price-range-slider").slider("values", 1));
	// }
	//Price Range Slider


	// input field show hide password start
	if ($('.password-box').length){
		const password = document.querySelector('.password');
		const passwordIcon = document.querySelector('.password-icon');

		passwordIcon.addEventListener("click", function () {
			if (password.type == 'password') {
				password.type = 'text';
				passwordIcon.classList.add('fa-eye-slash');
			} else {
				password.type = 'password';
				passwordIcon.classList.remove('fa-eye-slash');
			}
		})
	}
	// input field show hide password end

	// input field show hide 2 password start
	if ($('.password-box-two').length){
		const password = document.querySelector('.password-two');
		const passwordIcon = document.querySelector('.password-icon-two');

		passwordIcon.addEventListener("click", function () {
			if (password.type == 'password') {
				password.type = 'text';
				passwordIcon.classList.add('fa-eye-slash');
			} else {
				password.type = 'password';
				passwordIcon.classList.remove('fa-eye-slash');
			}
		})
	}
	// input field show hide 2 password end


	// about parollar
	$('[data-paroller-factor]').paroller();
	$('.paroller').paroller({
		factor: 0.1,
		factorXs: 0.3,
		// direction: 'horizontal',
		transition: 'transform 2s ease-out',
		type: 'foreground',
	});
	// about parollar

	//Hide Loading Box (Preloader)
	function handlePreloader() {
		if($('.loader-wrap').length){
			$('.loader-wrap').delay(1000).fadeOut(500);
		}
		TweenMax.to($(".loader-wrap .overlay"), 1.2, {
            force3D: true,
            left: "100%",
            ease: Expo.easeInOut,
        });
	}
	handlePreloader();

	if ($(".preloader-close").length) {
        $(".preloader-close").on("click", function(){
            $('.loader-wrap').delay(200).fadeOut(500);
        })
    }
	//Hide Loading Box (Preloader)


	// Menu style
    function dynamicCurrentMenuClass(selector) {
        let FileName = window.location.href.split('/').reverse()[0];

        selector.find('li').each(function () {
            let anchor = $(this).find('a');
            if ($(anchor).attr('href') == FileName) {
                $(this).addClass('current');
            }
        });
        // if any li has .current elmnt add class
        selector.children('li').each(function () {
            if ($(this).find('.current').length) {
                $(this).addClass('current');
            }
        });
        // if no file name return
        if ('' == FileName) {
            selector.find('li').eq(0).addClass('current');
        }
    }
	// Menu style

    // dynamic current class
    let mainNavUL = $('.main-menu').find('.navigation');
    dynamicCurrentMenuClass(mainNavUL);

	//Sticky Header Style and Scroll to Top
	function headerStyle() {
		if($('.main-header').length){
			var windowpos = $(window).scrollTop();
			var siteHeader = $('.main-header');
			var scrollLink = $('.scroll-to-top');
			var sticky_header = $('.main-header .sticky-header');
			if (windowpos > 100) {
				siteHeader.addClass('fixed-header');
				sticky_header.addClass("animated slideInDown");
				scrollLink.fadeIn(300);
			} else {
				siteHeader.removeClass('fixed-header');
				sticky_header.removeClass("animated slideInDown");
				scrollLink.fadeOut(300);
			}
		}
	}
	headerStyle();
	//Sticky Header Style and Scroll to Top

	//Submenu Dropdown Toggle
	if($('.main-header li.dropdown ul').length){
		$('.main-header .navigation li.dropdown').append('<div class="dropdown-btn"><span class="fa fa-angle-right"></span></div>');
	}

	//Mobile Nav Hide Show
	if($('.mobile-menu').length){
		var mobileMenuContent = $('.main-header .nav-outer .main-menu').html();
		$('.mobile-menu .menu-box .menu-outer').append(mobileMenuContent);
		$('.sticky-header .main-menu').append(mobileMenuContent);
		//Dropdown Button
		$('.mobile-menu li.dropdown .dropdown-btn').on('click', function() {
			$(this).toggleClass('open');
			$(this).prev('ul').slideToggle(500);
			$(this).prev('.mega_menu').slideToggle(500);
		});
		//Menu Toggle Btn
		$('.mobile-nav-toggler').on('click', function() {
			$('body').addClass('mobile-menu-visible');
		});
		//Menu Toggle Btn
		$('.mobile-menu .menu-backdrop,.mobile-menu .close-btn,.scroll-nav li a').on('click', function() {
			$('body').removeClass('mobile-menu-visible');
		});
	}

	//Search Popup
	if($('#search-popup').length){
		//Show Popup
		$('.search-toggler').on('click', function() {
			$('#search-popup').addClass('popup-visible');
		});
		$(document).keydown(function(e){
	        if(e.keyCode === 27) {
	            $('#search-popup').removeClass('popup-visible');
	        }
	    });
		//Hide Popup
		$('.close-search,.search-popup .overlay-layer').on('click', function() {
			$('#search-popup').removeClass('popup-visible');
		});
	}
	//Search Popup

	// banner slide
	function bannerSlider() {
		// banner slide 01
		if ($(".banner-slider-1").length > 0) {
		    // Banner Slider
			var bannerSlider2 = new Swiper('.banner-slider-1', {
				preloadImages: false,
                loop: true,
                centeredSlides: false,
                resistance: true,
                resistanceRatio: 0.6,
                speed: 2400,
                spaceBetween: 0,
                parallax: false,
                effect: "fade",
				autoplay: {
				    delay: 8000,
                    disableOnInteraction: false
				},
				pagination: {
				el: '.slider__pagination',
				clickable: true,
			  	},
	            navigation: {
	                nextEl: '.banner-slider-button-next',
	                prevEl: '.banner-slider-button-prev',
	            },
			});
		}
	}
	bannerSlider();
	// banner slide


	if ($('.theme_carousel').length) {
		$(".theme_carousel").each(function (index) {
			var $owlAttr = {},
			$extraAttr = $(this).data("options");
			$.extend($owlAttr, $extraAttr);
			$(this).owlCarousel($owlAttr);
		});
	}


	// Single item Carousel
	if ($('.single-item-carousel').length) {
		var singleItemCarousel = new Swiper('.single-item-carousel', {
			preloadImages: false,
			loop: true,
			grabCursor: true,
			centeredSlides: false,
			resistance: true,
			resistanceRatio: 0.6,
			speed: 1400,
			spaceBetween: 0,
			parallax: false,
			effect: "slide",
			pagination: {
				el: '.slider__pagination',
				clickable: true,
			  },
			//   pagination: {
			// 	el: '.slider__pagination2',
			// 	clickable: true,
			// },
			autoplay: {
				delay: 8000,
				disableOnInteraction: false
			},
			navigation: {
				nextEl: '.slider-button-next',
				prevEl: '.slider-button-prev',
			},
		});
	}
	// Single item Carousel

	// four item carousel
	if ($('.four-item-carousel').length) {
		var twoItemCarousel = new Swiper('.four-item-carousel', {
			preloadImages: false,
			loop: true,
			grabCursor: true,
			centeredSlides: false,
			resistance: true,
			resistanceRatio: 0.6,
			slidesPerView: 4,
			speed: 1400,
			spaceBetween: 30,
			parallax: false,
			effect: "slide",
			active: 'active',
			autoplay: {
				delay: 5000,
				disableOnInteraction: false
			},
			navigation: {
				nextEl: '.slider-button-next4',
				prevEl: '.slider-button-prev4',
			},
			breakpoints: {
				1400: {
					slidesPerView: 3,
				},
                991: {
                  slidesPerView: 2,
                },
                640: {
                  slidesPerView: 1,
                },
            }
		});
	}
	// four item carousel

	// ten item carousel
	if ($('.ten-item-carousel').length) {
		var tenItemCarousel = new Swiper('.ten-item-carousel', {
			preloadImages: false,
			loop: true,
			grabCursor: true,
			centeredSlides: false,
			resistance: true,
			resistanceRatio: 0.6,
			slidesPerView: 10,
			speed: 1400,
			spaceBetween: 10,
			parallax: false,
			effect: "slide",
			active: 'active',
			autoplay: {
				delay: 3000,
				disableOnInteraction: false
			},
			navigation: {
				nextEl: '.slider-button-next4',
				prevEl: '.slider-button-prev4',
			},
			breakpoints: {
				1400: {
					slidesPerView: 10,
				},
				1319: {
					slidesPerView: 8,
				},
				1024: {
					slidesPerView: 6,
				},
                991: {
                  slidesPerView: 4,
                },
                640: {
                  slidesPerView: 2,
                },
            }
		});
	}
	// ten item carousel

	// Scroll to a Specific Div
	if($('.scroll-to-target').length){
		$(".scroll-to-target").on('click', function() {
			var target = $(this).attr('data-target');
		   // animate
		   $('html, body').animate({
			   scrollTop: $(target).offset().top
			 }, 1500);
		});
	}
	// Scroll to a Specific Div

	//Accordion Box
	if($('.accordion-box').length){
		$(".accordion-box").on('click', '.acc-btn', function() {

			var outerBox = $(this).parents('.accordion-box');
			var target = $(this).parents('.accordion');

			if($(this).hasClass('active')!==true){
				$(outerBox).find('.accordion .acc-btn').removeClass('active');
			}

			if ($(this).next('.acc-content').is(':visible')){
				return false;
			}else{
				$(this).addClass('active');
				$(outerBox).children('.accordion').removeClass('active-block');
				$(outerBox).find('.accordion').children('.acc-content').slideUp(300);
				target.addClass('active-block');
				$(this).next('.acc-content').slideDown(300);
			}
		});
	}
	//Accordion Box

	// progress (scroll to top)
	if($('.prgoress_indicator path').length){
		var progressPath = document.querySelector('.prgoress_indicator path');
		var pathLength = progressPath.getTotalLength();

		progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
		progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
		progressPath.style.strokeDashoffset = pathLength;
		progressPath.getBoundingClientRect();
		progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';

		var updateProgress = function () {
		  var scroll = $(window).scrollTop();
		  var height = $(document).height() - $(window).height();
		  var progress = pathLength - (scroll * pathLength / height);
		  progressPath.style.strokeDashoffset = progress;
		}
		updateProgress();

		$(window).on('scroll', updateProgress);
		var offset = 250;
		var duration = 550;
		jQuery(window).on('scroll', function () {
		  if (jQuery(this).scrollTop() > offset) {
			jQuery('.prgoress_indicator').addClass('active-progress');
		  } else {
			jQuery('.prgoress_indicator').removeClass('active-progress');
		  }
		});
		jQuery('.prgoress_indicator').on('click', function (event) {
		  event.preventDefault();
		  jQuery('html, body').animate({ scrollTop: 0 }, duration);
		  return false;
		});

	}
	// progress (scroll to top)

	// Elements Animation
	if($('.wow').length){
		var wow = new WOW(
		  {
			boxClass:     'wow',
			animateClass: 'animated',
			offset:       0,
			mobile:       true,
			live:         true
		  }
		);
		wow.init();
	}
	// Elements Animation

/* ==========================================================================
   When document is Scrollig, do
   ========================================================================== */

	$(window).on('scroll', function() {
		headerStyle();

	});

/* ==========================================================================
   When document is loading, do
   ========================================================================== */

   // curved-circle
	$(window).scroll(function() {
		var theta = $(window).scrollTop() / 15;
		$(".curved-circle").css({ transform: "rotate(" + theta + "deg)" });
	});
	// curved-circle

	$(window).on('load', function() {

		//Jquery Curved Circle
		if ($('.curved-circle').length) {
			$('.curved-circle').circleType({
			  position: 'absolute',
			  dir: 1,
			  radius: 55,
			  forceHeight: true,
			  forceWidth: true
			});
		}
		if ($('.curved-circle-2').length) {
			$('.curved-circle-2').circleType({
			  position: 'absolute',
			  dir: 1,
			  radius: 170,
			  forceHeight: true,
			  forceWidth: true
			});
		}

	});



})(window.jQuery);
