"use strict";
$(document).ready(function(){

    //active state, thêm class active vào <a  
    $(function() {
        $('ul .btn1 a').click(function(e) {
        e.preventDefault();
        $('ul .btn1 a').removeClass('active1');
        $(this).addClass('active1');
    });
    });
});
// cho menu chạy từ từ xuống
    $('.navbar-collapse').find('a[href*=#]:not([href=#])').click(function () {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            var target = $(this.hash);
            target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
            if (target.length) {
                $('html,body').animate({
                    scrollTop: (target.offset().top - 40)
                }, 1000);
                if ($('.navbar-toggle').css('display') != 'none') {
                    $(this).parents('.container').find(".navbar-toggle").trigger("click");
                }
                return false;
            }
        }
    });
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
	
// main-menu-scroll - menu chạy theo, cố định
jQuery(window).scroll(function () {
var top = jQuery(document).scrollTop();
var height = 400;
//alert(batas);

if (top > height) {
	jQuery('.navbar-fixed-top').addClass('menu-scroll');
} else {
	jQuery('.navbar-fixed-top').removeClass('menu-scroll');
}
});