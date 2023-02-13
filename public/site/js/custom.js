(function ($, window, Typist) {

	// Dropdown Menu Fade    
	jQuery(document).ready(function () {
		$(".dropdown").hover(
			function () {
				$('.dropdown-menu', this).fadeIn("fast");
			},
			function () {
				$('.dropdown-menu', this).fadeOut("fast");
			});
	});

	/*-------active---------*/

	$(document).ready(function () {
		$(".nav-link").click(function () {
			$(".nav-link").removeClass("active");
			$(this).addClass("active");
		});
	});


	/*-------------headder_fixed-------------*/


	$(window).scroll(function () {
		var sticky = $('.header'),
			scroll = $(window).scrollTop();

		if (scroll >= 20) sticky.addClass('fixed');
		else sticky.removeClass('fixed');
	});

	/*------------slider-------------*/

	var swiper = new Swiper(".smplace", {
		pagination: {
			el: ".swiper-pagination",
			clickable: true,
		},
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		breakpoints: {
			640: {
				slidesPerView: 1,
				spaceBetween: 0,
			},
			768: {
				slidesPerView: 2,
				spaceBetween: 0,
			},
			1024: {
				slidesPerView: 3,
				spaceBetween: 0,
			},
		},
	});

	var swiper = new Swiper(".Bestdeals", {
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		breakpoints: {
			640: {
				slidesPerView: 1,
				spaceBetween: 10,
			},
			768: {
				slidesPerView: 2,
				spaceBetween: 10,
			},
			1024: {
				slidesPerView: 3,
				spaceBetween: 30,
			},
		},
	});
	var swiper = new Swiper(".top_dect", {
		navigation: {
			nextEl: ".swiper-button-next",
			prevEl: ".swiper-button-prev",
		},
		breakpoints: {
			640: {
				slidesPerView: 1,
				spaceBetween: 10,
			},
			768: {
				slidesPerView: 2,
				spaceBetween: 10,
			},
			1024: {
				slidesPerView: 4,
				spaceBetween: 30,
			},
		},
	});

	$('.toggle').click(function (e) {
		e.preventDefault();

		var $this = $(this);

		if ($this.next().hasClass('show')) {
			$this.next().removeClass('show');
			$this.next().slideUp(350);
		} else {
			$this.parent().parent().find('li .inner').removeClass('show');
			$this.parent().parent().find('li .inner').slideUp(350);
			$this.next().toggleClass('show');
			$this.next().slideToggle(350);
		}
	});

	$('.toggle').click(function(e){
		var $child = $(this).find('.plus-sign');
		if($child.hasClass('fa-plus')){
			$child.removeClass('fa-plus');
			$child.addClass('fa-minus')
		}else if($child.hasClass('fa-minus')){
			$child.removeClass('fa-minus');
			$child.addClass('fa-plus');
		}
	})



	setTimeout( () => $('.job__desc > p').addClass('style'), 300)
	


})(jQuery, window);