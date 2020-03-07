
    "use strict";
  
    /*----------------------------------------------------*/
    /*  Menu scroll js //add class vaof menu
    /*----------------------------------------------------*/
    var nav_offset_top = $('.header').offset().top;
    function stickyHeader() {
		if ($('.header').length) {
			var strickyScrollPos = nav_offset_top;
			if($(window).scrollTop() > strickyScrollPos) { //strickyScrollPos=data offset =150
				$('.header').addClass('menu-scroll fadeInDown animated')
			}
			else {
				$('.header').removeClass('menu-scroll fadeInDown animated');
			}
		}
	}
    
    // instance of fuction while Window Scroll event
	$(window).on('scroll', function () {	
		stickyHeader()
	})
    
    /*----------------------------------------------------*/
    /*  Skill js
    /*----------------------------------------------------*/
    $(".skill_item").each(function() {
        $(this).waypoint(function() {
            var progressBar = $(".progress-bar");
            progressBar.each(function(indx){
                $(this).css("width", $(this).attr("aria-valuenow") + "%")
            })
        }, {
            triggerOnce: true,
            offset: 'bottom-in-view'

        });
    });
    
    /*----------------------------------------------------*/
    /*  portfolio_isotope
    /*----------------------------------------------------*/
    function our_gallery(){
        if ( $('.portfolio').length ){
            // Activate isotope in container
            $(".portfolio_list").imagesLoaded( function() {
                $(".portfolio_list").isotope({
                    itemSelector: ".col-md-3",
                }); 
            }); 
            // Add isotope(hieu ung)khi click function
            $(".porfolio_menu ul li").on('click',function(){
                $(".porfolio_menu ul li").removeClass("active");
                $(this).addClass("active");

                var selector = $(this).attr("data-filter");
                $(".portfolio_list").isotope({
                    filter: selector,
                    animationOptions: {
                        duration: 400,
                        easing: "linear",
                        queue: false,
                    }
                });
                return false;
            });
        }
    }
    our_gallery();

    
    /*----------------------------------------------------*/
//    Cho menu chạy từ từ xuống id khi click
//        $('.header_area .nav.navbar-nav li').click(function(e) {
//            e.preventDefault(); //prevent the link from being followed
//            $('.header_area .nav.navbar-nav li').removeClass('active');
//            $(this).addClass('active');
//        });
    
    
    $('.header .nav.navbar-nav li a[href^="#"]:not([href="#"])').on('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top - 80
        }, 1500);
        event.preventDefault();
    });
    
    
    function bodyScrollAnimation() {
        var scrollAnimate = $('body').data('scroll-animation');
        if (scrollAnimate === true) {
            new WOW({
                mobile: false
            }).init()
        }
    }
    bodyScrollAnimation();

    // scroll Up, back totop

	$(window).scroll(function () {
		if ($(this).scrollTop() > 500) {
			$('.totop').fadeIn('slow');// hiển thị nút totop rõ dần khi top>600px
		} else {
			$('.totop').fadeOut('slow'); // mờ dần đi khi top<600px
		}
	});

	$('.totop').click(function () {
		$("html, body").animate({scrollTop: 0}, 1000);// cho chạy chậm 1000milis khi ấn totop
		return false;
	});
