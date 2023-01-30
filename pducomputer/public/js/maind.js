/* 
AJAX LOAD HTMK
<div class="pdu_dataload" data-loadpdu="note"></div>
note là tên file view
 */
document.addEventListener("DOMContentLoaded", function() {
      lazyLoadHtml();
  });
var lazyLoadHtml = function() {
    let lazyHtmls = [];
    lazyHtmls = lazyHtmls.slice.call(document.querySelectorAll(".pdu_dataload"));
  if(lazyHtmls.length){
    let active = false;
    let cmt_target_id = $("#idcate").val();
    let cmt_type = $("#idcate").attr("data-controler");
    const lazyLoad2 = function() {
        if (active === false) {
            active = true;
            setTimeout(function() {
                lazyHtmls.forEach(function(lazyHtml) {
                    if ((lazyHtml.getBoundingClientRect().top <= window.innerHeight && lazyHtml.getBoundingClientRect().bottom >= 0) && getComputedStyle(lazyHtml).display !== "none") {
                        let info = lazyHtml.getAttribute("data-loadpdu");
                        /*ajjax*/
                        $.ajax({
                            type: "POST",
                            url: base_url + "ajax/ajax_load",
                            data:{info,cmt_target_id,cmt_type},
                            dataType: 'html',
                            beforeSend: function () {
                              lazyHtml.classList.add("slideUp_eff");
                            },
                            success: function (response) {
                                $("[data-loadpdu='"+info+"']").html(response);
                            }
                        });

                        lazyHtml.classList.remove("pdu_dataload");
                        lazyHtmls = lazyHtmls.filter(function(image) {
                            return image !== lazyHtml;
                        });

                        if (lazyHtmls.length === 0) {
                            document.removeEventListener("scroll", lazyLoad2);
                            window.removeEventListener("resize", lazyLoad2);
                            window.removeEventListener("orientationchange", lazyLoad2);
                        }
                    }
                });

                active = false;
            }, 200);
        }
    };

    document.addEventListener("scroll", lazyLoad2);
    window.addEventListener("resize", lazyLoad2);
    window.addEventListener("orientationchange", lazyLoad2);
    lazyLoad2();
  }
    
}
/* Owl carousel */
$(document).ready(function() {
  var navLeftText = '<i class="fa fa-angle-left" aria-hidden="true"></i>';
var navRightText = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
  $("#ProductPhoto").owlCarousel({
        items: 1,
        responsive: {
          480: { items: 1 },
          0: { items: 1 }
       },
        loop:false,
        margin:20,
        autoplay: false,
        autoplayTimeout:2000,
        nav:true,
        dots: false,
        navText: [navLeftText, navRightText],
   });
    $("#owl-home-main-slider").owlCarousel({
        items: 1,
        responsive: {
          480: { items: 1 },
          0: { items: 1 }
       },
        loop:false,
        margin:20,
        autoplay: true,
        autoplayTimeout:2000,
        nav:true,
        dots: true,
        navText: [navLeftText, navRightText],
   });

    $("#owl-related-products-slider").owlCarousel({
        items: 5,
        responsive: {
          1200: { item: 5 },
          982: { items: 4 },
          768: { items: 3 },
          480: { items: 2 },
          0: { items: 2 }
       },
        loop:true,
        margin:20,
        autoplay: true,
        autoplayTimeout:2000,
        nav:true,
        dots: false,
        navText: [navLeftText, navRightText],
   });
    $("#owl-history-products-slider").owlCarousel({
     items: 4,
        responsive: {
          1200: { item: 4 },
          982: { items: 4 },
          768: { items: 3 },
          480: { items: 2 },
          0: { items: 2 }
       },
        loop:false,
        margin:20,
        autoplay: true,
        autoplayTimeout:2000,
        nav:true,
        dots: false,
        navText: [navLeftText, navRightText],
});
    $("#owl-history-products-slider1").owlCarousel({
     items: 5,
        responsive: {
          1200: { item: 5 },
          982: { items: 4 },
          768: { items: 3 },
          480: { items: 2 },
          0: { items: 2 }
       },
        loop:false,
        margin:20,
        autoplay: true,
        autoplayTimeout:2000,
        nav:true,
        dots: false,
        navText: [navLeftText, navRightText],
});
    $("#owl-home-featured-products-slider").owlCarousel({
        items: 5,
        responsive: {
          1200: { item: 5 },
          982: { items: 4 },
          768: { items: 3 },
          480: { items: 2 },
          0: { items: 1 }
       },
        loop:false,
        margin:20,
        autoplay: true,
        autoplayTimeout:2000,
        nav:true,
        dots: false,
        navText: [navLeftText, navRightText],
   });
    
    $("#owl-home-articles-slider").owlCarousel({

        items: 3,
        responsive: {
          1200: { item: 3 },
          982: { items: 3 },
          768: { items: 2 },
          480: { items: 1 },
          0: { items: 1 }
       },
        loop:false,
        margin:20,
        autoplay: true,
        autoplayTimeout:2000,
        nav:true,
        dots: false,
        navText: [navLeftText, navRightText],
   });
    
    
    $("#owl-brands-slider").owlCarousel({
        items: 6,
                responsive: {
                    1200: { item: 6, },// breakpoint from 1200 up
                    982: { items: 5, },
                    768: { items: 4, },
                    480: { items: 3, },
                    0: { items: 2, }
                },
                autoplay: true,
                margin:20,
                autoplayTimeout: 2000,
                dots: false,
                loop: false,
                nav: false,
                navText: [navLeftText, navRightText],
                
   });
    
    $("#owl-blog-single-slider").owlCarousel({
        items: 6,
        responsive: {
          1200: { item: 6 },
          982: { items: 5 },
          768: { items: 4 },
          480: { items: 2 },
          0: { items: 1 }
       },
        loop:true,
        margin:20,
        autoplay: true,
        autoplayTimeout:2000,
        nav:true,
        dots: false,
        navText: [navLeftText, navRightText],
   });
    

      // slider_review
$(".slider_review").owlCarousel({
    items: 4,
    responsive: {
      1200: { item: 4 },
      982: { items: 4 },
      768: { items: 3 },
      480: { items: 2 },
      0: { items: 1 }
   },
    loop:true,
    margin:20,
    autoplay: false,
    autoplayTimeout:2000,
    nav:true,
    dots: false,
    navText: [navLeftText, navRightText],
});


});

// <!-- Back to top -->
jQuery(document).ready(function() {
     var offset = 220;
     var duration = 500;
     jQuery(window).scroll(function() {
          if (jQuery(this).scrollTop() > offset) {
               jQuery('#back-to-top').fadeIn(duration);
          } else {
               jQuery('#back-to-top').fadeOut(duration);
          }
     });

     jQuery('#back-to-top').click(function(event) {
          event.preventDefault();
          jQuery('html, body').animate({
               scrollTop: 0
          }, duration);
          return false;
     });
//đính kèm header khi cuộn
window.onscroll = changePos;
function changePos() {
     var header = $("#header");
     var headerheight = $("#header").height();
     if (window.pageYOffset > headerheight) {          
          header.addClass('scrolldown');
     } else {
          header.removeClass('scrolldown');
     }
}
});

$(document).ready(function(){
     /*tab pdu*/
     function activeTab(obj)
     {
          $(obj).siblings().removeClass('active');

          $(obj).addClass('active');

          let id = $(obj).attr('data-href');

          $(obj).parent(".pdutab_btn").siblings('.pdutab_content').children('.pdutab_item').removeClass('active').end().children(id).addClass('active');

          
     }
     $('.pdutab_btn button').click(function(){
          activeTab(this);
          return false;
     });
     /*show_child menu*/
     $("body").on('click','button.show_child',function (event) {
        $(this).siblings('.show_content').toggleClass('openp');
        $(this).toggleClass('openp');
    });
});
