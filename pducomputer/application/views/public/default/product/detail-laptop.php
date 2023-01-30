
  <section id="breadcrumb-wrapper" class="breadcrumb-w-img">
          <div class="breadcrumb-overlay"></div>
          <div class="breadcrumb-content">
            <div class="wrapper">
              <div class="inner text-center">
                <div class="breadcrumb-big">
                  <h2>
                    <?php echo $oneItem->title; ?>
                  </h2>
                </div>
                <?php echo !empty($breadcrumb) ? $breadcrumb : ''; ?>
              </div>
            </div>
          </div>
        </section>

        <div id="PageContainer" class="is-moved-by-drawer">
          <main class="main-content" role="main">
            <section id="product-wrapper">
              <div class="wrapper">
                <div class="inner">
                    <div class="row clearfix product-single" >
<div class="col-sm-5 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
  <div class="product-single__photos" >
 <?php if (!empty($oneItem->album)): 
      $album = json_decode($oneItem->album);
  ?>
<div id="albumedu_slide" class="albumedu_slide owl-carousel owl-theme">
  <?php foreach ($album as $value): ?>
          <div class="item">
            <div class="image_dot zoompdu" data-src="<?php echo MEDIA_URL.$value; ?>">
              <img class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo MEDIA_URL.$value; ?>" alt="<?php echo $oneItem->title; ?>" />
            </div>
          </div>
        
  <?php endforeach; ?>
  <?php if(!empty($oneItem->video)){ ?>
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


                      <div class="col-sm-7 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
                        <div class="product-content">
                          <div class="pro-content-head clearfix">
                            <h1><?php echo $oneItem->title; ?></h1>
                          <?php if (!empty($category_type)): ?>
                            <div class="pro-brand">
                              <span class="title">Thương hiệu:</span> <a href="<?php echo get_url_product_type($category_type); ?>"><?php echo @$category_type->title; ?></a>
                            </div>
                            <span>|</span>
                          <?php endif; ?>
                          <?php if (!empty($category['0'])): ?>
                            <div class="pro-type">
                              <span class="title">Loại: <a href="<?php echo get_url_category_product($category['0']) ?>"><?php echo $category['0']->title ?></a></span>
                            </div>
                            <span>|</span>
                            <?php endif; ?>
                            <div class="pro-sku ProductSku">
                              <span class="title">Mã SP:</span> <span class="sku-number"><?php echo $oneItem->code; ?></span>
                            </div>
                          </div>
                          <div class="pro-price clearfix">
                            <?php echo show_price_detail1($oneItem); ?>
                            
                          </div>
                          <div class="pro-short-desc">
                            <!-- mô tả ngắn -->
                            
                            <p class="guarantee"><strong>Bảo hành: <span><?php echo $oneItem->guarantee; ?></span></strong>
                              <strong> | Tình trạng: <span><?php echo !empty($oneItem->newlike) ? 'Mới 100%' : '98%'; ?></span></strong>
                            </p>

                            <?php echo !empty($this->_settings_home->footer3) ? $this->_settings_home->footer3 : 'đang cập nhật...'; ?>

                            <p><span class="check-icon"></span>Bảo hành <?php echo $oneItem->guarantee; ?> 1 đổi 1 trong 7 ngày. <a href=""><strong> CHI TIẾT CHÍNH SÁCH</strong></a></p>
                            
                            <?php if((int)$oneItem->newlike == 0): ?>
                              <p><span class="check-icon"></span>Máy chạy mát, độ bền cao, loa tốt</p>
                            <p><span class="check-icon"></span>Cam kết máy xách tay nguyên bản 100% chưa qua sửa chữa tại các dự án thị trường Mỹ và châu âu…</p>
                          <?php endif; ?>
                            
                          </div>
                          <form id="AddToCartForm" class="form-vertical">
                          <div class="product-variants-wrapper">
                            <div class="product-size-hotline">
                            <div class="product-hotline">
                            Hotline hỗ trợ khách hàng 24/7: <a href="tel:<?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?>"><?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?></a>
                            </div>
                            <span>|</span>
                            <div class="social-network-actions text-left">
                            <div class="fb-like" data-href="<?php echo get_url_product($oneItem); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                            </div>
                            </div>
                          </div>

                          <?php if(!empty($oneItem->classify)): ?>
                          <div class="select classifypdu clearfix">
                            <?php foreach($oneItem->classify->fulldgroup as $key => $class1 ): ?>
                               <div class="group-classify" data-namegroup = "<?php echo $key; ?>">
                                  <label><?php echo $class1->name; ?></label>
                                  <ul class="clearfix style-variant-template">
                                    <?php foreach($class1->value as $class2): ?>
                                     <li><label class="field-classify"><input type="radio" value="<?php echo $class2; ?>" name="<?php echo "option".$key ?>"><span><?php echo $class2; ?></span></label></li>
                                   <?php endforeach; ?>
                                  </ul>
                               </div>
                               
                              <?php endforeach; ?>

                               <style>
                              .classifypdu{padding:0px 0 10px}.group-classify>label{padding:5px 0;display:inline-block;font-weight:bold}input,input:focus{outline:0;-webkit-appearance:none}.style-variant-template{display:block}.style-variant-template input{display:none !important}.style-variant-template li{float:left;margin-right:3px;list-style:none}.style-variant-template li span{display:block;padding:6px 8px;background:#fff;cursor:pointer;border:1px solid #ccc;font-weight:normal}.style-variant-template input[type=radio]:checked+span{border:1px solid #e60f1e;background:url(//theme.hstatic.net/200000164551/1000911738/14/checkbox-product.png?v=21) no-repeat right bottom #fff}.style-variant-template span img{margin-right:3px}#list-classifypdu{display: none;}
                            </style>
                            
                            <select name="" id="list-classifypdu">
                            <?php foreach($oneItem->classify->fulldata as $key => $class1 ): ?>
                                <option sku="<?php echo $class1->sku; ?>" value="<?php echo $class1->price; ?>" namegroup0="<?php echo $class1->namegroup0; ?>" namegroup1 ="<?php if(!empty($class1->namegroup1)){echo $class1->namegroup1;}; ?>" ><?php if(!empty($class1->namegroup1)){echo $class1->namegroup0 ." / ". $class1->namegroup1." / ".$class1->price; }else{ echo $class1->namegroup0." / ".$class1->price; }  ?></option>
                            <?php endforeach; ?>
                            </select>
                          </div>
                          <script>
                            jQuery(document).ready(function($) {
                              var value_field = {};
                              
                              $("body").on('click', '.field-classify', function(event) {
                                
                                /*event.preventDefault(); Act on the event */
                                let namegroup = $(this).parents(".group-classify").attr("data-namegroup");
                                
                                
                                let num_group = $(".group-classify").length;
                                let namegroup0,namegroup1;

                                if(num_group == 1){
                                  value_field[0] = $(this).children("input").val();
                                  $("#list-classifypdu option").each(function(i, e) {
                                    namegroup0 = e.getAttribute("namegroup0");
                                    if(value_field[0] == namegroup0){
                                      let price = formatMoney(e.value,0);
                                      $(".pro-price .current-price").text(price +" vnđ");
                                      let sku = e.getAttribute("sku");
                                      $(".sku-number").text(sku);

                                      $("button[data-classify]").attr("data-classify",1);
                                      $("button[data-sku]").attr("data-sku",sku);

                                      $("html, body").animate({scrollTop: $(".pro-price .current-price").offset().top - 170}, 1000);
                                    }
                                  });
                                }else{
                                  value_field[namegroup] = $(this).children("input").val();
                                  $("#list-classifypdu option").each(function(i, e) {
                                    namegroup0 = e.getAttribute("namegroup0");
                                    namegroup1 = e.getAttribute("namegroup1");
                                    if(value_field[0] == namegroup0 && value_field[1] == namegroup1){
                                      let sku = e.getAttribute("sku");
                                      $(".sku-number").text(sku);
                                      let price = formatMoney(e.value,0);
                                      $(".pro-price .current-price").text(price +" vnđ");

                                      $("button[data-classify]").attr("data-classify",1);
                                      $("button[data-sku]").attr("data-sku",sku);
                                      

                                      $("html, body").animate({scrollTop: $(".pro-price .current-price").offset().top - 170}, 1000);
                                      
                                    }
                                  });

                                }

                              });

                            });
                          </script>
                          <?php endif; ?>
                          <div class="row clearfix">
                          <div class="col-sm-4 col-xs-6 col-480-12">
                          <div class="product-quantity clearfix">
                          <div class="qty-addcart clearfix">
                          <span>Số lượng </span>
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
                          </div>
                          </div>
                        <?php if($oneItem->quality == 0): ?>
                          <button disabled class="btn btn-soldout">Tạm Hết hàng</button>
                          <p><i>Bạn vui lòng <a href="<?php echo base_url("lien-he.html"); ?> ">liên hệ</a> lại bên mình, để nhập hàng về cho bạn nhé!</i></p>
                        <?php else: ?>
                          <div class="col-sm-4 col-xs-6 col-480-12">
                          <div class="product-actions clearfix">
                          <button type="button" name="add" id="AddToCart" class="btnAddToCart" data-classify="false" data-sku="0" data-id="<?php echo $oneItem->id; ?>">Thêm vào giỏ hàng</button>
                          </div>   
                          </div>
                          <div class="col-sm-4 col-xs-6 col-480-12">
                          <div class="product-actions clearfix">
                          <button type="button" name="buy" id="buy-now" class="btnBuyNow" data-classify="false" data-sku="0" data-id="<?php echo $oneItem->id; ?>">Mua ngay</button>
                          </div>   
                          </div>
                        <?php endif; ?>
                          </div>      
                          </form>
                          <div class="tagpro">Tag:
                            <?php if(isset($danhmuccha)) foreach($danhmuccha as $tag):?>
                            <a href="<?php echo get_url_category_product($tag); ?>"><?php echo $tag->title; ?></a>, 
                          <?php endforeach; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="row clearfix">
                      <div class="col-sm-9">
                        <div class="product-description-wrapper">
                          <div class="tab clearfix pdutab_btn">
                            <button class="pro-tablinks active" data-href="#protab1">Mô tả sản phẩm</button>
                            <button class="pro-tablinks" data-href="#protab2">Bảng giá nâng cấp</button>
                            <button class="pro-tablinks" data-href="#proCom">Bình luận</button>
                          </div>
                        <div class="pdutab_content">
                          <div id="protab1" class="pdutab_item active">
                            <div class="showmore1 showmore">
                            <h2 class="title_content">Cấu hình chi tiết máy <?php echo $oneItem->title; ?></h2>
                            <!-- nội dung tab 1 -->
                            <table class="table">
                              <tbody>
                                <?php if(!empty($oneItem->attribute)) foreach($oneItem->attribute as $attr): 
                                if(!empty($attr->value)):
                                ?>
                                <tr>
                                  <td><?php echo $attr->name; ?></td>
                                  <td><?php echo $attr->value; ?></td>
                                </tr>
                                <?php endif; endforeach; ?>
                                <tr>
                                  <td>Bảo hành & Chính sách bán hàng</td>
                                  <td><strong>BẢO HÀNH: <?php echo $oneItem->guarantee; ?></strong> <br>
                                    + Trong 7 ngày đầu được đổi máy khác nếu không thích - không cần lý do<br>

                                    + Trong 7 ngày đầu, nếu máy có lỗi phần cứng, khách hàng được hoàn tiền 100%<br>

                                    + CÀI ĐẶT PHẦN MỀM <strong>Miễn Phí</strong> TRỌN ĐỜI MÁY<br>

                                    + CHẾ ĐỘ MỞ RỘNG BẢO HÀNH: <a href="<?php echo base_url("lien-he.html"); ?> ">liên hệ</a><br>

                                  + HỖ TRỢ TRẢ GÓP LÃI SUẤT 0% QUA THẺ TÍN DỤNG (Xem Chi Tiết)</td>
                                </tr>
                                <tr>
                                  <td>Khuyến Mãi</td>
                                  <td>BALO LAPTOP cao cấp, chuột, lót chuột, TÚI CHỐNG SỐC, THẺ BẢO DƯỠNG (VỆ SINH LAPTOP MIỄN PHÍ)</td>
                                </tr>
                                <tr>
                                  <td>Giao Hàng:</td>
                                  <td>
                                    + CHUYỂN HÀNG COD TOÀN QUỐC (Nhận Hàng - Mở Kiểm Tra - Mới Trả tiền)<br>
                                    + Miễn Phí Giao Hàng Tại Tp.Hà Nội Phạm Vi (15Km)
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                            <!-- end thông số -->
                            
                            <div class="introduct-pro">
                              <h2 class="title_content">giới thiệu tổng quan <?php echo $oneItem->title; ?></h2>
                              <p>♦ Có thiết kế mạnh mẽ, quyến rũ và nam tính, các góc bo tròn và 1 chút vuông vắn giúp máy trở nên thon gọn kèm mạnh mẽ, nhìn sang trọng dễ vận chuyển. Sở hữu màn hình <?php echo $oneItem->attribute->do_rong_man_hinh->value; ?>, với độ phân giải màn hình <?php echo $oneItem->attribute->do_phan_giai_man_hinh->value; ?> cho góc nhìn thoải mái khi làm việc cũng như giải trí.</p> 
                              <?php if(!empty($album[0])):?>
                              <p><img src="<?php echo getImageThumb($album[0],900,632);  ?> " alt="giới thiệu tổng quan <?php echo $oneItem->title; ?>"/></p>
                              <?php endif; ?>
                              <p>♦ <strong><?php echo $oneItem->title; ?></strong> Trang bị bộ vi xử lý <?php echo $oneItem->attribute->chi_tiet_cpu->value; ?>, kết hợp với Ram <?php echo $oneItem->attribute->loai_ram->value; ?> <?php echo $oneItem->attribute->dung_luong_ram->value; ?> cho bạn thoải mái chiến game và làm đồ họa thông dụng nhất hiện nay như: Photoshop, Corel, Autocad,Adobe Indesign, Premiere, CorelDraw .... Liên minh, FiFa, CF, Võ lâm. Dung lượng ổ cứng lên đến 500gb tha hồ chứa dữ liệu mà không lo hết</p>

                              <strong> Tình trạng <?php echo $oneItem->title; ?> <?php echo !empty($oneItem->newlike) ? 'Mới 100%' : '98%'; ?></strong>:<br>
                              <ul>
                                 <?php if((int)$oneItem->newlike == 0): ?>
                                <li>Hàng đã qua sử dụng, đã đi du lịch qua một Nước -> Xách tay về Việt Nam, chất lượng vẫn đảm bảo và được <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?> kiểm tra theo quy chuẩn kỹ càng.</li>
                                <li>Máy Nguyên Zin 100%, Chưa qua sửa chữa hay thay thế linh kiện (Bao thợ xem máy)</li>
                              <?php endif; ?>

                                <li>Chất lượng máy được kiểm duyệt, kiểm tra khắc khe bởi bộ phận kỹ thuật <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?></li>
                                <li>Linh kiện dễ dàng tìm kiếm thay thế khi hư hỏng, giá linh kiện không quá cao.</li>
                                <li>Tất cà mọi chức năng máy đều hoạt động tốt, không một lỗi nhỏ.</li>
                                <li>Dòng máy <?php echo $oneItem->attribute->nhu_cau_su_dung->value; ?> thương hiệu Mỹ, Nhật sài rất bền, tính đồng bộ cao.</li>
                                <li>Sẽ được cài sẵn Window, Đủ Driver và các Soft ứng dụng cần thiết. Mua về chỉ việc sử dụng.</li>
                            </ul>

<h2 class="title_content">giới thiệu về ngoài hình <?php echo $oneItem->title; ?></h2>
<?php if(!empty($album[1])):?>
<p><img src="<?php echo getImageThumb($album[1],900,632);  ?> " alt="ngoài hình <?php echo $oneItem->title; ?>"/></p>
<?php endif; ?>
  <p>+ Có Vỏ màu <?php echo $oneItem->attribute->mau_vo->value; ?>, lịch sự, sang trọng, tinh tế, đẹp đẽ.</p>
  <p>+ Khe tản nhiệt to, thoáng, giúp chiếc máy của bạn luôn luôn mát mẻ, trong mọi thời tiết.</p>
  <p>+ Hình dạng chiếc <?php echo $oneItem->title; ?> với những đường viền vuông vắn, tạo cảm giác khỏe khoắn, và các đường bo tròn cho cảm giác mềm mại khi nhìn vào.</p>
  <p>+ Bàn phím sáng đẹp, ấn nảy giúp gõ bàn phím cả ngày mà không thấy mỏi và sướng tay.
</p>
  <p>+ Màn hình có độ rộng <?php echo $oneItem->attribute->do_rong_man_hinh->value; ?>, độ phân giải <?php echo $oneItem->attribute->do_phan_giai_man_hinh->value; ?> tạo cảm giác mượt mà, màu sắc nét, không gây mỏi mắt khi nhìn vào màn hình lâu.</p>
  <p>+ Chuột, touchpad nhạy bén, mượt mà như dùng chuột cắm ngoài.</p>
  <p>+ <?php echo $oneItem->title; ?> có <?php echo $oneItem->attribute->more->value; ?>, tốc độ copy nhanh gấp 4 lần so với các các dòng máy không hỗ trợ usb 3.0.
</p>
<p>+ Cổng giao tiếp Lan <?php echo $oneItem->attribute->lan->value; ?></p>
<p>+ Ổ đĩa quang CD/DVD <?php echo $oneItem->attribute->o_dia_quang->value; ?>.</p>
<p>+ Pin có dung lượng <?php echo $oneItem->attribute->battery->value; ?>, giúp làm việc liên tục 3-4 tiếng. Pin chính hãng chống chảy nổ tuyệt đối.</p>

<h2 class="title_content">giới thiệu về Nội quan <?php echo $oneItem->title; ?>:</h2>
<?php if(!empty($album[2])):?>
<p><img src="<?php echo getImageThumb($album[2],900,632);  ?> " alt="Nội quan <?php echo $oneItem->title; ?>"/></p>
<?php endif; ?>
<p>
  + Sử dụng Chipset <?php echo $oneItem->attribute->chipset->value; ?> mạnh mẽ, giúp xử lý, giao tiếp mọi dữ liệu, thông tin, hình ảnh với CPU mạnh mẽ và nhanh chóng hơn bất cứ thứ gì.
  <br>
  + Sử dụng Bộ vi xử lý CPU <?php echo $oneItem->attribute->chi_tiet_cpu->value; ?> mạnh mẽ, giúp xử lý mọi dữ liệu, thông tin, hình ảnh một cách nhanh chóng. Người dùng không cần chờ đợi quá lâu để chờ máy tính xử lý khi thực hiện 1 tác vụ hay cài phần mềm gì đó.
  <br>
  + Có Memory / Ram là <?php echo $oneItem->attribute->loai_ram->value; ?> <?php echo $oneItem->attribute->dung_luong_ram->value; ?>. Chiếc <?php echo $oneItem->title; ?> này hỗ trợ <?php echo $oneItem->attribute->so_khe_cam_ram->value; ?>.
  <br>
  + Lắp ổ cứng <?php echo $oneItem->attribute->loai_o_cung->value; ?>, dung lượng ổ cứng <?php echo $oneItem->attribute->dung_luong_o_cung->value; ?> khá lớn, giúp lưu trữ hình ảnh, dữ liệu thoải mái mà không sợ hết dung lượng.
  <br>
  + Có GPU / Card đồ họa <?php echo $oneItem->attribute->chi_tiet_vga->value; ?>, có tác dụng hỗ trợ, giúp CPU, chipset xử lý hình ảnh nhanh chóng hơn, xử lý đồ họa tốt hơn, khiến máy không bị lag, giật khi xem video 4k hay sử dụng đồ họa cao.
</p>
<?php if(!empty($album[3])):?>
<p><img src="<?php echo getImageThumb($album[3],900,632);  ?> " alt="<?php echo $oneItem->title; ?>"/></p>
<?php endif; ?>
<!-- ứng dụng -->
<?php echo $oneItem->content; ?>

<h2 class="title_content">Cách bảo trì, bảo dưỡng <?php echo $oneItem->title; ?>:</h2>

<p>
  <h3>Để chiếc máy sống với bạn cả đời, thì sau đây là giải pháp mà <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?> gợi ý cho bạn:</h3> <br>
  1. Vệ sinh máy, tra keo tản nhiệt mới 4 tháng 1 lần nếu dùng nhiều, 6 tháng 1 lần nếu dùng ít.<br>
  2. Dùng máy thì đặt máy trên mặt phẳng, làm sao cho chỗ hút khí, và tản nhiệt thông thoáng.<br>
  3. Không đặt máy lên đùi, chăn ga để sử dụng, vì như vậy sẽ hút gió kém làm máy nóng nhanh và dễ hư linh kiện.<br>
  4. Để máy ở nơi khô giáo, không ẩm ướt.<br>
  5. Không quăng, vứt máy, mạnh tay, dễ bị xê dịch, lỏng các linh kiện dẫn tới chạm chập.<br>
  6. Dùng balo chống sốc khi di chuyển, phòng tránh va đập mạnh gây hư hại <?php echo $oneItem->title; ?> của bạn.<br>
</p>
<p>
  <h3>Hướng dẫn bảo dưỡng, bảo trì máy <?php echo $oneItem->title; ?>:</h3>
  bước 1: tháo hết ốc mà bạn nhìn thấy trên bề mặt.<br>
  bước 2: tháo pin, bàn phím, tháo ram, ổ cứng ra.<br>
  bước 3: lấy chổi cọ quét sạch bụi bẩn trên main, quạt<br>
  bước 4: tháo tản nhiệt và tra keo tản nhiệt mới.<br>
  bước 5: lắp lại.
</p>
<p>
  <?php if(!empty($oneItem->attribute->video_baotri->value)): ?>
  <h3>Dưới đây là video hướng dẫn bảo trì, bảo dưỡng máy <?php echo $oneItem->title; ?>:</h3>
  <iframe class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo $oneItem->attribute->video_baotri->value; ?>" style="width:100%;height:372px;"></iframe>
<?php endif; ?>
</p>

<h2 class="title_content">Hướng dẫn cách chọn mua máy <?php echo $oneItem->title; ?> nói riêng và máy tính laptop đã qua sử dụng - máy mới 100% nói chung:</h2>
<p>
*Bạn đang muốn mua 1 chiếc laptop hay pc cũ? <br/>
*Bạn đang không biết nơi bán nào uy tín, lo ngại mua phải hàng kém chất lượng, dịch vụ bán hàng không tốt?<br/>

*Hãy đến <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?> để trải nghiệm máy & mua hàng tại <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?> để cảm nhận dịch vụ của chúng tôi, <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?> luôn đặt cái “TÂM” lên trên hết, chúng tôi luôn muốn đem đến sản phẩm, dịch vụ tốt nhất đến tất cả khách hàng<br/>

* Tại <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDUCOMPUTER'; ?> Tất cả các máy bán ra đều được kiểm tra kĩ lưỡng với <a href="http://pducomputer.local/ad2_15-quy-trinh-chuan-test-may-nghiem-ngat.html">15 quy trình chuẩn test máy nghiêm ngặt</a>, tư vấn nhanh gọn, mua hàng nhanh chóng, thanh toán tiện lợi.<br/>
</p>
<div>
  <h3>15 bước test máy và mua máy chuẩn USA, cho 1 chiếc máy tính pc hoặc laptop</h3>
  
  <?php echo !empty($this->_settings_home->footer1) ? $this->_settings_home->footer1 : 'PDUCOMPUTER'; ?>
  
</div>

      </div>
    </div>
      <div class="viewmorex"><a href="javascript:void(0)">Xem thêm <i class="fa fa-angle-down" aria-hidden="true"></i></a></div>
                             <!-- bảng giá nâng cấp -->
    <h2 class="title_content">Bảng giá nâng cấp <?php echo $oneItem->title; ?></h2>
    <?php echo !empty($this->_settings_home->footer2) ? $this->_settings_home->footer2 : 'đang cập nhật...'; ?>
<div class="catesame">
  <strong>Danh mục cùng loại:</strong>
  <?php if(!empty($category)) foreach($category as $cate): ?>
  <a class="tag-item" href="<?php echo get_url_category_product($cate); ?>"><?php echo $cate->title; ?></a>
<?php endforeach; ?>
</div>
        <div class="end-pro">
          <h3>Mọi vấn đề cần liên hệ, Quý đại lý xin liên hệ với chúng tôi</h3>
          <h2><?php echo !empty($this->_settings->title) ? $this->_settings->title : 'Công ty PDUCOMPUTER'; ?></h2>
          <p><strong>Địa chỉ:</strong> <?php echo !empty($this->_settings->meta_address) ? $this->_settings->meta_address : ''; ?></p>
          <p><strong>Điện thoại :</strong>  <?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?>  - Hotline: <?php echo !empty($this->_settings->meta_hotline_hn) ? $this->_settings->meta_hotline_hn : ''; ?></p>
          <p><strong>Email:</strong> <?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?></p>
          <p><strong>Website:</strong> <?php echo !empty($this->_settings->domain) ? $this->_settings->domain : ''; ?></p>
          <div><strong>Xin chân thành cảm ơn</strong></div>
          <div>===o0o===</div>
        </div> 

                             
        </div>
        <div id="protab2" class="pdutab_item">
          <!-- bảng giá nâng cấp -->
          <?php echo !empty($this->_settings_home->footer2) ? $this->_settings_home->footer2 : 'đang cập nhật...'; ?>
        </div>
        <div id="proCom" class="pdutab_item">
          <div class="fb-comments" data-href="<?php echo get_url_product($oneItem); ?>" data-width="100%" data-numposts="5"></div>
          
          <div id="pducomment"><h6 class="title_cmt">Đánh giá</h6><?php echo $comment_block; ?></div>
        </div>
      </div>
    </div><!-- pdutab_content -->
    </div>
      <div class="col-sm-3">

        <?php $this->load->view($this->template_path . 'block/sidebar_category'); ?>
        <div class="cacbuoctest">
          <h3>15 bước test khi mua máy</h3>
          <?php echo !empty($this->_settings_home->footer1) ? $this->_settings_home->footer1 : 'PDUCOMPUTER'; ?>
        </div>
      </div>
    </div>
                    <!-- Sản phẩm liên quan -->
                    <?php if (!empty($list_related)) : ?>
                    <section id="related-products" class="wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
                      <div class="home-section-head clearfix">
                        <div class="section-title text-left">
                          <h2>
                            Sản phẩm liên quan
                          </h2>
                          <a href="<?php echo !empty($category['0']) ? get_url_category_product($category['0']) : '#'?>">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
                        </div>
                      </div>
                      <div class="home-section-body">
                        <div class="grid">
                          <div id="owl-related-products-slider" class="owl-carousel owl-theme">
                            <?php foreach ($list_related as $item) : ?>
                            <div class="item">
                              <div class="product-item">
                                  <div class="product-img">
                                    <a href="<?php echo get_url_product($item); ?>">
                                    <?php echo getThumbnail($item,230,240); ?>
                                    </a>
                                    <?php if($item->price_sale != 0): ?>
                                    <div class="tag-saleoff text-center">
                                      <?php echo "-".ceil((100-(($item->price_sale/$item->price)*100))) ."%"; ?>
                                    </div>
                                  <?php endif; ?>
                                    <div class="product-actions text-center clearfix">
                                      <div>
                                        <button type="button" class="btnQuickView quick-view medium--hide small--hide" data-id="<?php echo $item->id; ?>"><span><i class="fa fa-search-plus" aria-hidden="true"></i></span></button>

                                        <button type="button"  class="btnBuyNow medium--hide small--hide" title="mua ngay" data-cart="false" data-id="<?php echo $item->id; ?>"><span>Mua ngay</span></button>

                                        <button type="button"  class="btnAddToCart medium--hide small--hide" title="thêm vào giỏ" data-cart="false" data-id="<?php echo $item->id; ?>"><span><i class="fa fa-cart-plus" aria-hidden="true"></i></span></button>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="product-item-info text-center">
                                    <div class="product-title">
                                      
                                      <h2><a href="<?php echo get_url_product($item); ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></h2>
                                    </div>
                                    <div class="product-price clearfix">
                                      <?php echo show_price_detail($item); ?>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          <?php endforeach; ?>
                          </div>
                        </div>
                      </div>
                    </section>
                  <?php endif; ?>
                   <?php if (!empty($product_type_related)) : ?>
                    <section id="related-products" class="wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
                      <div class="home-section-head clearfix">
                        <div class="section-title text-left">
                          <h2>
                            Sản phẩm cùng hãng
                          </h2>
                          <a href="<?php echo !empty($category_type) ? get_url_product_type($category_type) : '#'?>">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
                        </div>
                      </div>
                      <div class="home-section-body">
                        <div class="grid mg-left-15">
                          <div id="owl-history-products-slider1" class="owl-carousel owl-theme">
                            <?php foreach ($product_type_related as $item) : ?>
                            <div class="item grid__item pd-left15">
                              <div class="product-item">
                                  <div class="product-img">
                                    <a href="<?php echo get_url_product($item); ?>">
                                    <?php echo getThumbnail($item,230,240); ?>
                                    </a>
                                    <?php if($item->price_sale != 0): ?>
                                    <div class="tag-saleoff text-center">
                                      <?php echo "-".ceil((100-(($item->price_sale/$item->price)*100))) ."%"; ?>
                                    </div>
                                  <?php endif; ?>
                                    <div class="product-actions text-center clearfix">
                                      <div>
                                        <button type="button" class="btnQuickView quick-view medium--hide small--hide" data-id="<?php echo $item->id; ?>"><span><i class="fa fa-search-plus" aria-hidden="true"></i></span></button>

                                        <button type="button"  class="btnBuyNow medium--hide small--hide" title="mua ngay" data-cart="false" data-id="<?php echo $item->id; ?>"><span>Mua ngay</span></button>

                                        <button type="button"  class="btnAddToCart medium--hide small--hide" title="thêm vào giỏ" data-cart="false" data-id="<?php echo $item->id; ?>"><span><i class="fa fa-cart-plus" aria-hidden="true"></i></span></button>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="product-item-info text-center">
                                    <div class="product-title">
                                      
                                      <h2><a href="<?php echo get_url_product($item); ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></h2>
                                    </div>
                                    <div class="product-price clearfix">
                                      <?php echo show_price_detail($item); ?>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          <?php endforeach; ?>
                          </div>
                        </div>
                      </div>
                    </section>
                  <?php endif; ?>
                    <!-- sp history -->
                    <?php if (!empty($product_history)): ?>
                    <section id="related-products" class="wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
                      <div class="home-section-head clearfix">
                        <div class="section-title text-left">
                          <h2>
                            Sản phẩm đã xem
                          </h2>
                          <span class="section-title-border"></span>
                        </div>
                      </div>
                      <div class="home-section-body">
                        <div class="grid mg-left-15">
                          <div id="owl-history-products-slider" class="owl-carousel owl-theme">
                            <?php foreach ($product_history as $item1) : ?>
                            <div class="item grid__item pd-left15">
                               <div class="product-item">
                                  <div class="product-img">
                                    <a href="<?php echo get_url_product($item1); ?>">
                                    <?php echo getThumbnail($item1,230,240); ?>
                                    </a>
                                    <?php if($item1->price_sale != 0): ?>
                                    <div class="tag-saleoff text-center">
                                      <?php echo "-".ceil((100-(($item->price_sale/$item->price)*100))) ."%"; ?>
                                    </div>
                                  <?php endif; ?>
                                    <div class="product-actions text-center clearfix">
                                      <div>
                                        <button type="button" class="btnQuickView quick-view medium--hide small--hide" data-id="<?php echo $item1->id; ?>"><span><i class="fa fa-search-plus" aria-hidden="true"></i></span></button>

                                        <button type="button"  class="btnBuyNow  medium--hide small--hide" title="mua ngay" data-cart="false" data-id="<?php echo $item1->id; ?>"><span>Mua ngay</span></button>

                                        <button type="button"  class="btnAddToCart medium--hide small--hide" title="thêm vào giỏ" data-cart="false" data-id="<?php echo $item1->id; ?>"><span><i class="fa fa-cart-plus" aria-hidden="true"></i></span></button>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="product-item-info text-center">
                                    <div class="product-title">
                                      
                                      <h2><a href="<?php echo get_url_product($item1); ?>" title="<?php echo $item1->title; ?>"><?php echo $item1->title; ?></a></h2>
                                    </div>
                                    <div class="product-price clearfix">
                                      <?php echo show_price_detail($item1); ?>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          <?php endforeach; ?>
                          </div>
                        </div>
                      </div>
                    </section>
                  <?php endif; ?>
                    <?php $this->load->view($this->template_path . 'block/type_product'); ?>
                </div>
              </div>
            </section>
          </main>
        </div>
        <script>
      jQuery(document).ready(function(event) {

          let vtweare = $(".cacbuoctest").offset().top;

          let chancuoi = $(".end-pro").offset().top;

          $(".viewmorex").click(function(event) {
            $(".showmore1").toggleClass("showmore");
            $(".viewmorex a svg").toggleClass('fa-angle-down').toggleClass('fa-angle-up');

            chancuoi = $(".end-pro").offset().top;
          });

          window.addEventListener("scroll", function(){
            if((window.pageYOffset > vtweare) && (window.pageYOffset < chancuoi)) {
                $(".cacbuoctest").addClass('stickypdu');
            }
            else{
                $(".cacbuoctest").removeClass('stickypdu');
            }
          });
      });

        </script>