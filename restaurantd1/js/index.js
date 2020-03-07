//1 add class active1 vào <a - restaurent
//$(document).ready(function(){

    //active state  
   // $(function() {
    //    $('ul .btn1 a').click(function(e) {
    //    e.preventDefault();
    //    $('ul .btn1 a').removeClass('active1');
    //    $(this).addClass('active1');
    //});
    //});
//});
//2 scrollspy dùng scrollspy thì không cần dùng cái 1 nữa - tác động vào thằng class navbar
$(document).ready(function(){
    $('body').scrollspy({target: ".navbar", offset: 50});   
});
//3 cho menu chạy từ từ xuống - tác động vào class navbar-collapse
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

// 4 scroll Up, back totop - class totop
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

// 5 main-menu-scroll, menu chạy theo
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

//6 tạo popup cho ảnh, cho class portfolio-img vào thằng bao ảnh - index(bino)
$('.portfolio-img').magnificPopup({
  delegate: 'a',  // child items selector, by clicking on it popup will open
  gallery:{enabled:true}, // cho phép hiện danh sách, bỏ đi chỉ hiện 1 ảnh thôi.
  type: 'image'
  // other options
});


