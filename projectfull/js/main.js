(function($) {
  "use strict"

  // PRODUCT DETAILS SLICK
  $('#product-main-view').slick({
    infinite: true, // vòng lặp vô hạn khi trượt
    speed: 300, // tốc độ trượt ms
    dots: false, //dấu tròn
    arrows: true,  // nút mũi tên
    fade: true, // độ mờ fade
    asNavFor: '#product-view',
  });

  $('#product-view').slick({
    slidesToShow: 3, //số trang trình bày hiển thị
    slidesToScroll: 1, // số trang trình bày để cuộn
    arrows: true, // nút mũi tên
    centerMode: true, //hiện ở giữa
    focusOnSelect: true, // bật tiêu điểm trên phần tử chọn nhấp
    asNavFor: '#product-main-view', //đặt thanh trượt là thanh trượt của slide #product-main-view
  });

  // PRODUCT ZOOM
  $('#product-main-view .product-view').zoom();

})(jQuery);
