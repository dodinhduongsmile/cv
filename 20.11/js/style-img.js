/*global $*/
/*browser:true*/
/*global window*/

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


if (window.innerWidth > 768) {
    $(window).scroll(function () {
        if ($(window).scrollTop() >= 100) {
            $('.sticky-header').addClass('fixed');
        } else {
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