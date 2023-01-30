
          <div class="modal-content">
            <span id="close" class="close">&times;</span>
            <form class="row clearfix" id="form-quick-view" >
              <div class="col-sm-6">
                <div class="image-zoom">
                   <?php if (!empty($product->album)): 
                    ?>
                  <div id="albumedu_slide2" class="albumedu_slide owl-carousel owl-theme">
                    <?php foreach ($product->album as $value): ?>
                            <div class="item">
                              <div class="image_dot zoompdu" data-src="<?php echo MEDIA_URL.$value; ?>">
                                <img src="<?php echo getThumbnailnoajax($value,230,240); ?>" alt="<?php echo $product->title; ?>" />
                              </div>
                            </div>
                          
                    <?php endforeach; ?>
                    <?php if(!empty($product->video)){ ?>
                          <div class="item-video">
                            <div class="image_dot" data-src="<?php echo $this->templates_assets.'images/playvideo.jpg'; ?>"> 
                              <a class="owl-video" href="<?php echo $oneItem->video; ?>"></a>
                            </div>
                          </div>
                          <?php }; ?>
                      </div>
                    <?php endif; ?>
                </div>
              </div>
              <div class="col-sm-6">
                <h4 class="p-title modal-title " id=""><?php echo $product->title; ?></h4>
                <p class="product-more-info">
                  <span class="product-sku">
                  Mã sản phẩm: <span id="ProductSku"><?php echo $product->code; ?></span> 
                  </span>
                </p>
                <div class="form-input product-price-wrapper">
                  <div class="product-price">Giá:
                    <?php echo show_price_detail1($product); ?>
                  </div>
                  
                </div>

                <div class="form-input hidden">
                  <label>Số lượng</label>
                  <div class="js-qty">
                      <button type="button" class="js-qty__adjust js-qty__adjust--minus icon-fallback-text">
                      <i class="fa fa-minus" aria-hidden="true"></i>
                      <span class="fallback-text" aria-hidden="true">−</span>
                      <span class="visually-hidden">Giảm số lượng sản phẩm đi 1</span>
                      </button>
                      <input type="number" class="js-qty__num" value="1" min="1" pattern="[0-9]*" name="quantity" id="Quantity">
                      <button type="button" class="js-qty__adjust js-qty__adjust--plus icon-fallback-text">
                      <i class="fa fa-plus" aria-hidden="true"></i>
                      <span class="fallback-text" aria-hidden="true">+</span>
                      <span class="visually-hidden">Tăng số lượng sản phẩm lên 1</span>
                      </button>
                  </div>
                          <script>
                            jQuery(document).ready(function($) {
                               var count = 0;
                               $('.js-qty__adjust--minus').click(function () {
                                   if (count - 1 >= 0) {
                                       count = $(this).parent().find('#Quantity').val();
                                       count = count - 1;
                                       $(this).parent().find('#Quantity').val(count);
                                   } else {
                                       $(this).parent().find('#Quantity').val(0);
                                   }
                               });
                               $('.js-qty__adjust--plus').click(function () {
                                   count = parseInt($(this).parent().find('#Quantity').val());
                                   count = count + 1;
                                   $(this).parent().find('#Quantity').val(count);
                               });
                            });
                          </script>
                </div>
                <div class="form-input" style="width: 100%">
                  <?php if($product->quality ==0): ?>
                  <button disabled class="btn btn-soldout">Tạm Hết hàng</button>
                  <p><i>Bạn vui lòng <a href="<?php echo base_url("lien-he.html"); ?> ">liên hệ</a> lại bên mình, để nhập hàng về cho bạn nhé!</i></p>
                  <?php else: ?>
                    <button class="btn btnAddToCart" id="AddToCardQuickView" data-cart="false" data-id="<?php echo $product->id; ?>">Thêm vào giỏ</button>
                  <?php endif; ?>
                  <div class="qv-readmore">
                    <span> hoặc </span><a class="read-more p-url" href="<?php echo get_url_product($product); ?>" role="button">Xem chi tiết</a>
                  </div>
                </div>
              </div>
            </form>
          </div>
<style>
  div#p-sliderproduct ul {
    display: flex;
    justify-content: space-around;
    align-items: center;
    margin: 5px 0;
    flex-wrap: wrap;
}

div#p-sliderproduct ul a {
    padding: 0 5px;
    width: 20%;
}

.image-zoom img#p-product-image-feature {
    width: 100%;
    padding: 10px;
}
/*css qick view*/
.modal {
display: none;
position: fixed;
z-index: 99999;
left: 0;
top: 0;
width: 100%;
height: 100%;
overflow: hidden; 
background-color: rgba(0,0,0,0.4);
transition: all ease 1s;
overflow: auto;
}
.modal-content {
    background-color: #fefefe;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 780px;
    transition: all ease 1s;
    opacity: 0;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
}
.close {
color: #aaa;
font-size: 28px;
font-weight: bold;
position: absolute;
right: 0;
top: 0;
width: 40px;
text-align: center;
}
.close:hover,
.close:focus {
color: black;
text-decoration: none;
cursor: pointer;
}

.desktop-cart-wrapper:hover .quickview-cart{
display: block;
}</style>
<script>
 
         $('#close').click(function(){
            setTimeout(function(){
               $('#productQuickView').hide();
            }, 300);
            document.getElementById("form-quick-view").reset();
         })
         window.onclick = function(event) {
            if (event.target == document.getElementById('productQuickView')) {
               setTimeout(function(){
                  $('#productQuickView').hide();
               }, 300);
               document.getElementById("form-quick-view").reset();
            }
         }

if($('#albumedu_slide2').length){
  /*hover hoặc đợi 3s sẽ add backgroup*/
  var hover = "ok";
  var elm_tar = $('#albumedu_slide2 .item .zoompdu');
var elm_tar2 = $('#albumedu_slide2 .item');

function background_dot() {
  let img_arr = $("#albumedu_slide2 .image_dot");
  let dot_arr = $("#albumedu_slide2 .owl-dot span");
    $.each(img_arr,function(index, el) {
      let src = el.getAttribute("data-src");
      
      dot_arr[index].style.backgroundImage = "url("+src+")";
    });

};
function background() {
    elm_tar.each(function () {
      $(this).css({
        'background-image': 'url(' + $(this).attr('data-src') + ')'
      });
    });
    hover = 'nook';
    clearTimeout(timeout);
}
  elm_tar.hover(function () {
    if (hover == 'ok') {
      background();
      background_dot();
    }
  });
  let timeout = setTimeout(function () {
    background();
    background_dot();
  }, 3000);

   elm_tar2.on('mouseover', function () {
    $(this).children('.zoompdu').css({
      'transform': 'scale(3)'
    });
  });
  elm_tar2.on('mouseout', function () {
    $(this).children('.zoompdu').css({
      'transform': 'scale(1)'
    });
  });
  elm_tar2.on('mousemove', function (e) {
    $(this).children('.zoompdu').css({
      'transform-origin': ((e.pageX - $(this).offset().left) / $(this).width()) * 100 + '% ' + ((e.pageY - $(this).offset().top) / $(this).height()) * 100 + '%'
    });
  });

  $("#albumedu_slide2").owlCarousel({
        items: 1,
        responsive: {
            480: { items: 1, },
            0: { items: 1, }
        },
        autoplay: false,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        smartSpeed: 500,

        dots: true,
        dotsEach: false,
        loop: false,
        nav: true,
        navText: ['<i class="fa fa-angle-left icon_slider"></i>', '<i class="fa fa-angle-right icon_slider"></i>'],
        autoWidth: false,
        margin: 10,
        lazyContent: false,
        lazyLoad: true,
        center: true,
        URLhashListener: false,
        video: true,
    }).on('changed.owl.carousel', syncPosition);

var current_ = 0;
var dots_ = $("#albumedu_slide2.owl-carousel.owl-theme .owl-dots");
function syncPosition(el) {
      /*
      1. click vào ptu trước hay sau
      - lưu vị trí index hiện tại
      - khi click thì so sánh vị trí click và vị trí trước đó để nhận biết
      -> tính temp để transform
      
      dots_.css({
          transform: "translateX("+temp_+"px)"
        });
       */
      let number_ = el.item.index;
      let temp_ = 0;
      var leftPos = dots_.scrollLeft();
      if(number_ > current_){
        current_ = number_;
        dots_.animate({scrollLeft: leftPos + 110}, 700);
        
      }else if(number_ < current_){
        current_ = number_;
        dots_.animate({scrollLeft: (leftPos - 110)}, 700);
      }  
    }

}

</script>
       