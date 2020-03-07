"use strict";
//$(document).ready(function(){

//active state, thêm class active vào <a  
    //$(function() {
       // $('.menu-list li').click(function(e) {
        //e.preventDefault();
        //$('.menu-list li').removeClass('active');
        //$(this).addClass('active');
    //});
   // });
//});
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
var height = 600;
//alert(batas);
if (top > height) {
	jQuery('.navigation').addClass('menu-scroll');
} else {
	jQuery('.navigation').removeClass('menu-scroll');
}
});
//
(function($) {
  "use strict"

  // NAVIGATION
  var responsiveNav = $('#responsive-nav'),
    catToggle = $('#responsive-nav .category-nav .category-header'),
    catList = $('#responsive-nav .category-nav .category-list'),
    menuToggle = $('#responsive-nav .menu-nav .menu-header'),
    menuList = $('#responsive-nav .menu-nav .menu-list');

  catToggle.on('click', function() {
    menuList.removeClass('open');
    catList.toggleClass('open');
  });

  menuToggle.on('click', function() {
    catList.removeClass('open');
    menuList.toggleClass('open');
  });

  $(document).click(function(event) {
    if (!$(event.target).closest(responsiveNav).length) {
      if (responsiveNav.hasClass('open')) {
        responsiveNav.removeClass('open');
        $('#navigation').removeClass('shadow');
      } else {
        if ($(event.target).closest('.nav-toggle > button').length) {
          if (!menuList.hasClass('open') && !catList.hasClass('open')) {
            menuList.addClass('open');
          }
          $('#navigation').addClass('shadow');
          responsiveNav.addClass('open');
        }
      }
    }
  });
  //endddd
  				$(document).ready(function(){
					$('.carousel3').owlCarousel({
						loop:true,
						margin:15,
						autoplay: false,
						autoplayTimeout:2000,
						nav:true,
						dots: false,
						//navText: ['<span class="glyphicon glyphicon-menu-left"></span>','<span class="glyphicon glyphicon-menu-right" ></span>'],
						responsive:{
							0:{
								items:1
							},
							600:{
								items:2
							},
							1000:{
								items:3
							}
						}
					})
					});
					//
				$(document).ready(function(){
					$('.carousel2').owlCarousel({
						loop:true,
						margin:15,
						autoplay: false,
						autoplayTimeout:2000,
						nav:true,
						dots: false,
						//navText: ['<span class="glyphicon glyphicon-menu-left"></span>','<span class="glyphicon glyphicon-menu-right" ></span>'],
						responsive:{
							0:{
								items:1
							},
							400:{
								items:2
							},
							600:{
								items:3
							},
							1000:{
								items:4
							}
						}
					})
					});
				//
				$(document).ready(function(){
					$('.carousel1').owlCarousel({
						loop:true,
						margin:0,
						autoplay: false,
						autoplayTimeout:2000,
						nav:true,
						dots: false,
						//navText: ['<span class="glyphicon glyphicon-menu-left"></span>','<span class="glyphicon glyphicon-menu-right" ></span>'],
						responsive:{
							0:{
								items:1
							},
							600:{
								items:1
							},
							1000:{
								items:1
							}
						}
					})
					});
					//
//add to cat
		var itemcount = 0;
		$('.add').click(function (){
		  itemcount ++;
		  $('#itemcount').html(itemcount).css('display', 'block');
		}); 
// reset cart, chi can them 1button class="clear"
		//$('.clear').click(function() {
		 // itemcount = 0;
		  //$('#itemcount').html('').css('display', 'none');
		  //$('#cartItems').html('');
		//}); 
})(jQuery);
