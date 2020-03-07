

// menu toggle
$(function() {
    var html = $('html, body'),
        navContainer = $('.nav-container'),
        navToggle = $('.nav-toggle'),
        navDropdownToggle = $('.has-dropdown');
        overlay =$("<div class='overlay'></div> ");
        colseMenu =$("<button class='nav-toggle nav-toggle-mb'><img src='img/x.png' width='25'></button>");



    // Nav toggle
    navToggle.on('click', function(e) {
        // overlay.toggle();
        var $this = $(this);
        e.preventDefault();
        $this.toggleClass('is-active');
        navContainer.toggleClass('is-visible');
        html.toggleClass('nav-open');
    });

    // Nav toggle
    $( ".nav-container" ).prepend(colseMenu);
    colseMenu.click(function(){
        navToggle.trigger('click');
        // $(this).toggle();
    })



    $( "body" ).prepend(overlay);
    overlay.click(function(){
        // navToggle.trigger('click');
         $(this).toggle();
    })


    // Nav dropdown toggle
    navDropdownToggle.on('click', function() {
        var $this = $(this);
        $(".nav-dropdown").slideUp();
        $this.toggleClass('is-active').siblings().removeClass('is-active');
        if(!$(this).children('ul').is(":visible"))
        {
          $(this).children('ul').slideDown();
        }
    });

    // Prevent click events from firing on children of navDropdownToggle
    navDropdownToggle.on('click', '*', function(e) {
        e.stopPropagation();
    });


});

 // style img

function render_size() {

    // var h_7714 = $('.h_7714 img').width();
    // $('.h_7714 img').height(Math.ceil(0.7714 * parseInt(h_7714)));


}

function reRender_img() {
    'use strict';
    $(".reRenderImg img").css('height', 'auto');
    $(".imgRow").each(function() {
        var thisRow,
            imgs,
            w,
            h,
            ratio;

        thisRow = $(this);
        imgs = thisRow.find(".reRenderImg img");

        w = imgs.width();
        h = imgs.height();
        ratio = h / w;

        imgs.height(Math.ceil(ratio * parseInt(w)));
    });
}
var t;
function debounce_render() {
    clearTimeout(t);
    t = setTimeout(reRender_img, 100);
}
$(function() {
    render_size();

    debounce_render();

    var url = window.location.href;
    $('.menu-item  a').parent().removeClass('active');
    $('.menu-item  a[href="' + url + '"]').parent().addClass('active');
});

$(window).resize(function() {
    render_size();
    reRender_img();
});



 // scroll add class
if (window.innerWidth > 768) {
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 100) {
            $('.sticky-header').addClass('fixed');
        } else{
            $('.sticky-header').removeClass('fixed');
        }
    });
}
if (window.innerWidth > 320) {
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 100) {
            $('.sticky-header').addClass('clearfix');
        } else {
            $('.sticky-header').removeClass('clearfix');
        }
    });
}


// btn_search
$(function () {
      // search dropdown button
      $('.btn_search').click(function (e) {
          overlay.toggle();
          e.preventDefault();
          $(this).parents('.search_drop').find('.form_search').toggleClass('open')
      })
      $(document).click(function (event) {
          // Check if clicked outside target
          if (!($(event.target).closest(".search_drop").length)) {
              // Hide target
              $(".form_search").removeClass('open');

          }

      });
    });




//scroll to top button
$(function() {
    $("a[href='#top']").click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, "slow");
        return false;
    });
}, 0);

$(window).scroll(function () {
    if ($(window).scrollTop() >=200) {
        $('#go_top').show();
    }
    else {
        $('#go_top').hide();
    }
});


// search

$(function () {
    // search dropdown button
    $('.drop-button, .dropdown-content .close').click(function (e) {
        e.preventDefault();
        $(this).parents('.search-drop').find('.dropdown-content').toggleClass('visible')
    })
    $(document).click(function (event) {
        // Check if clicked outside target
        if (!($(event.target).closest(".search-drop").length)) {
            // Hide target
            $(".dropdown-content").removeClass('visible');
        }


    });
})




// slider

$(function() {
    $(".slider_main").owlCarousel({
        items: 1,
        responsive: {
            1200: { item: 1, },// breakpoint from 1200 up
            982: { items: 1, },
            768: { items: 1, },
            480: { items: 1, },
            0: { items: 1, }
        },
        rewind: false,
        autoplay: true,
        autoplayHoverPause: true,
        autoplayTimeout: 5000,
        smartSpeed: 1000, //slide speed smooth
        dots: true,
        dotsEach: false,
        loop: true,
        nav: false,
        navText: ['<i class="fa fa-angle-left icon_slider"></i>','<i class="fa fa-angle-right icon_slider"></i>'],
        margin: 20,
    });
});
//
$(function() {
    $(".slider_main1").owlCarousel({
        items: 1,
        rewind: false,
        autoplay: false,
        autoplayHoverPause: true,
        autoplayTimeout: 5000,
        smartSpeed: 1000, //slide speed smooth
        dots: true,
        dotsEach: false,
        loop: true,
        nav: false,
        navText: ['<i class="fa fa-angle-left icon_slider"></i>','<i class="fa fa-angle-right icon_slider"></i>'],
        margin: 10,
    });
});
//
$(function() {
    $(".slider_main2").owlCarousel({
        items: 4,
        responsive: {
            1200: { item: 4, },// breakpoint from 1200 up
            982: { items: 4, },
            768: { items: 3, },
            480: { items: 2, },
            0: { items: 2, }
        },
        rewind: false,
        autoplay: false,
        autoplayHoverPause: true,
        autoplayTimeout: 5000,
        smartSpeed: 1000, //slide speed smooth
        dots: false,
        dotsEach: false,
        loop: true,
        nav: true,
        navText: ['<i class="fa fa-angle-left icon_slider"></i>','<i class="fa fa-angle-right icon_slider"></i>'],
        margin: 10,
    });
});
//
