"use strict";

// scroll Up, back totop

	$(window).scroll(function () {
		if ($(this).scrollTop() > 600) {
			$('.totop').fadeIn('slow');// hiển thị nút totop rõ dần khi top>600px
		} else {
			$('.totop').fadeOut('slow'); // mờ dần đi khi top<600px
		}
	});

	$('.totop').click(function () {
		$("html, body").animate({scrollTop: 0}, 1000);// cho chạy chậm 1000milis khi ấn totop
		return false;
	});
	

//number counter
$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 4000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});
//
$(document).ready(function(){
					$('.carousel2').owlCarousel({
						loop:true,
						margin:30,
						autoplay: false,
						autoplayTimeout:2000,
						nav:false,
						dots: true,
						//navText: ['<span class="glyphicon glyphicon-menu-left"></span>','<span class="glyphicon glyphicon-menu-right" ></span>'],
						responsive:{
							0:{
								items:1
							},
							800:{
								items:1
							},
							1000:{
								items:1
							}
						}
					})
					});
//
$(document).ready(function(){
					$('.carousel1').owlCarousel({
						loop:true,
						margin:30,
						autoplay: false,
						autoplayTimeout:2000,
						nav:true,
						dots: true,
						//navText: ['<span class="glyphicon glyphicon-menu-left"></span>','<span class="glyphicon glyphicon-menu-right" ></span>'],
						responsive:{
							0:{
								items:1
							},
							800:{
								items:1
							},
							1000:{
								items:1
							}
						}
					})
					});
					