<link rel="stylesheet" href="<?php echo $this->templates_assets.'css/buildpc.css'; ?> ">
<script src="<?php echo $this->templates_assets.'js/buildpc.js'; ?>" type='text/javascript'></script>
<div id="sub-header" class="thankyou">
  <div class="container">
     <ul class="pdu-breadcrumb">
        <li>
           <a href="<?php echo base_url(); ?>"><span class="fa fa-home"></span>Trang chủ</a>
        </li>
        <span aria-hidden="true">/</span>
        <li>
           <a href="/"><?php echo $oneItem->title; ?></a>
        </li>
     </ul>
  </div>
</div>
<div class="body-new-2019" style="padding-top: 15px;">
   <!--  -->
   <main class="build-pc pc">
      <!--<div class="banner-build owl-carousel owl-theme">
         </div>-->
      <div class="content container" >
         <h1 class="buildpc-h1-title"><?php echo $oneItem->title; ?></h1>
      <?php if(!empty($oneItem->thumbnail)): ?>
         <div id="owl-home-main-slider" class="owl-carousel owl-theme" style="width: 100%;">
            <div class="item"><a href="#"><img src="<?php echo MEDIA_URL.$oneItem->thumbnail; ?>" alt="<?php echo $oneItem->title; ?>"></a></div>
            <?php if(!empty($oneItem->banner)): ?>
            <div class="item"><a href="#"><img src="<?php echo MEDIA_URL.$oneItem->banner; ?>" alt="<?php echo $oneItem->title; ?>"></a></div>
             <?php endif; ?>
            
         </div>
     <?php endif; ?>
     <?php echo $oneItem->content; ?>
         <div class="clear"></div>
         <div class="build-pc_content">
            <div class="km-pc-laprap"></div>
            <ul class="list-btn-action list-btn-action-new " style="margin-top:0; float:left; border:none;">
               <li style="width:auto;" class="active"><span class="showBuildId" data-ch="ch1" style="padding:0 20px;">Cấu hình 1</span></li>
               <li style="width:auto;"><span class="showBuildId" data-ch="ch2" style="padding:0 20px;">Cấu hình 2</span></li>
               
            </ul>
            <div class="clear"></div>
            <ul class="list-btn-action " style="margin-top:0; float:left; border:none;">
               <li><span onclick="Buildpc.Buildpc2.openPopupRebuild()" style="padding:0 20px;">Làm mới <i class="fa-refresh"></i></span></li>
            </ul>
            <div class="km-buildpc">
               <div class="km-buildpc-1">
                  <div class="chon-kho"> Mời quý khách chọn kho hàng:  </div>
                  <div id="js-buildpc-select-store" class="list-khohang">
                    <div>
                        <input type="radio" id="testall" name="showroom_pdu" value="" checked="">
                        <label for="testall">Tất cả kho</label>
                    </div>
                    <?php
                    $i =0;
                     if (!empty($this->_data_store)) foreach ($this->_data_store as $value) : 
                    $i++;
                    ?>
                     <div>
                        <input type="radio" id="showroom_<?php echo $value->id; ?>" name="showroom_pdu" value="<?php echo $value->id; ?>">
                        <label for="showroom_<?php echo $value->id; ?>"><?php echo $i.": " ?><?php echo $value->address; ?></label>
                     </div>
                     <?php endforeach; ?>
                  </div>
               </div>
               <div class="km-buildpc-2">
                  <div class="huong-dan-km-buildpc">Chỉ cần chọn đủ Main, CPU, RAM, SSD, Case, Nguồn</div>
                  <div class="huong-dan-km-buildpc">Để nhận khuyến mại giảm giá nhiều nhất!</div>
               </div>
               <div class="km-buildpc-3">
                  <div class="js-chi-phi-du-tinh">
                     <table>
                        <tbody>
                           <tr>
                              <td>Chi phí dự tính</td>
                              <td>
                                 <span class="js-config-summary" style="color: #d00; font-weight: bold">
                                    <span class="total-price-config"><?php echo number_format(@$totalprice,0,'','.'); ?> đ</span>
                                    <p> </p>
                                 </span>
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <div class="clear"></div>
                  <div class="js-buildpc-promotion-content" style="margin-bottom: 0px;"></div>
               </div>
            </div>
            <div class="clear"></div>
            <div class="list-drive" id="js-buildpc-layout">
               
               <?php if(!empty($category_child)) foreach($category_child as $cate): ?>
               <div class="item-drive">
                  <span class="d-name"><?php echo $cate->title; ?></span>
                  <div class="drive-checked">
                     <span class="show-popup_select span-last open-selection" id="js-category-info-<?php echo $cate->id; ?>" data-info='{"id":"<?php echo $cate->id; ?>","name":"<?php echo $cate->title; ?>","layout":"<?php echo $cate->layout; ?>"}'><i class="fa fa-plus"></i> Chọn <?php echo $cate->title; ?></span>
                     <div id="js-selected-item-<?php echo $cate->id; ?>">
                         <!-- itempc -->
                         <?php if(!empty($data_pro_pc[$cate->id])): 
                            $data_product = getByIdProduct($data_pro_pc[$cate->id]['id']);
                            ?>
                            <div class="contain-item-drive" data-product_id="<?php echo $data_product->id; ?>">
                               <a target="_blank" href="<?php echo get_url_product($data_product); ?>" class="d-img"><img src="<?php echo getThumbnailnoajax($data_product->thumbnail,230,240); ?>"></a>
                               <span class="d-name">
                               <a target="_blank" href="<?php echo get_url_product($data_product); ?>"> <?php echo $data_product->title; ?>  </a> <br>
                               Mã sản phẩm: <?php echo $data_product->code; ?> <br>
                               Bảo hành: <?php echo $data_product->guarantee; ?><br>
                               Kho hàng: <?php echo !empty($data_product->quality) ? "Còn hàng" : "Tạm Hết hàng"; ?>
                               </span>
                               <span class="d-price">
                                  <?php 
                                     if (!empty($data_product->price) && !empty($data_product->price_sale)) {
                                     $price = $data_product->price_sale;
                                     $subtotal  = number_format($price *$data_pro_pc[$cate->id]['quantity'],0,'','.');
                                     $price = number_format($price,0,'','.')."<sup>đ </sup>";

                                 }elseif(!empty($data_product->price) && empty($data_product->price_sale)){
                                     $price = $data_product->price;
                                      $subtotal  = number_format($price *$data_pro_pc[$cate->id]['quantity'],0,'','.');
                                     $price = number_format($price,0,'','.')."<sup>đ </sup>";
                                 }else{
                                     $price = "Liên hệ ";
                                     $subtotal  = "Liên hệ ";
                                 }
                                 echo $price;

                                  ?>
                                                             
                               </span>
                               <i style="padding:0 5px;"> x </i> <input class="count-p quantity_item_pc" type="number" value="<?php echo $data_pro_pc[$cate->id]['quantity']; ?>" min="1" max="99" pattern="[0-9]*"> <i> = </i>
                               <span class="sum_price"><?php echo $subtotal; ?></span>
                               <span class="btn-action_seclect show-popup_select edit_item_pc"><i class="fas fa-edit edit-item"></i></span>
                               <span class="btn-action_seclect delete_select remove_item_pc" data-id="<?php echo $data_product->id; ?>"><i class="fas fa-trash-alt remove-item"></i></span>
                            </div>


                         <?php endif; ?>
                     </div>
                  </div>
               </div>
               <?php endforeach; ?>

            </div>
            <div class="clear"></div>
            <div class="lis-top-build-pc-ct-right" style="width: 40%;float: right; margin-top: 20px">
               <div class="js-chi-phi-du-tinh">
                  <table>
                     <tbody>
                        <tr>
                           <td>Chi phí dự tính</td>
                           <td>
                              <span class="js-config-summary" style="color: #d00; font-weight: bold">
                                 <span class="total-price-config"><?php echo number_format(@$totalprice,0,'','.'); ?> đ</span>
                                 <p> </p>
                              </span>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>

            <div class="clear"></div>
            <ul class="list-btn-action" id="js-buildpc-action">
               <li><span class="download_excel_listpc">tải file excel cấu hình <i class="fa fa-file-excel-o" aria-hidden="true"></i></span></li>

               <li><span id="create_img">tải ảnh cấu hình <i class="fa fa-picture-o" aria-hidden="true"></i></span>
                <a id="btn-Convert-Image" href="#">cccc</a>
              </li>
               

               <li><span class="print_view">Xem &amp; In <i class="fa fa-print" aria-hidden="true"></i></span></li>
               <li><span class="add_cart_listpc">Thêm vào giỏ hàng <i class="fa fa-shopping-cart" aria-hidden="true"></i></span></li>
            </ul>
         </div>
         <!---->
         <div class="cat-product-list " style="overflow:hidden; margin-bottom:20px;" id="list-collection-homepage2019">
            <div id="js-modal-popup">

            </div><!-- end js-modal-popup -->
         </div>
          <?php $this->load->view($this->template_path . 'block/type_product'); ?>
      </div>
   </main>
</div>

<script src="<?php echo $this->templates_assets.'js/html2canvas.min.js'; ?>" type='text/javascript'></script>
<div id="html-content-img" style="position: absolute;bottom: 0;z-index: -1;"></div>
<script>
$(document).ready(function(){
/*cách 1:convert html to image
var element = $("#html-content-img");
html2canvas(element, {
 onrendered: function (canvas) {
        var getCanvas = canvas;
        canvas.toBlob(function(blob){//tạo đối tượng blob
          link = window.URL.createObjectURL(blob);
          $("#btn-Convert-Image").attr("download", "your_pic_name.png").attr("href", link);
        },'image/png');
     }
 });
setTimeout(function () {
  document.querySelector("#btn-Convert-Image").click();
},4000);
 */

$("body").on('click','#create_img',function (event) {
        let cauhinh = paramspc['cauhinh'];
        let type = "buildpc";
        let _this = $(this);
        $.ajax({
            url: '/page/view_print',
            type: 'get',
            dataType: 'html',
            data: {cauhinh},
        })
        .done(function(response) {
          let html = document.querySelector("#html-content-img");
          html.innerHTML = response;
            
            setTimeout(function () {
              let element = $("#printable");
              var element_d = document.querySelector("#btn-Convert-Image");

              var getCanvas;
              html2canvas(element, {
               onrendered: function (canvas) {
                      getCanvas = canvas;
                   }
               });
              element_d.onclick  = function () {
                let day = get_date();
                  var imgageData = getCanvas.toDataURL("image/png");
                  /*Now browser starts downloading it instead of just showing it*/ 
                  var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
                  element_d.setAttribute("download", "bao-gia-pducomputer-"+day+".png");
                  element_d.setAttribute("href", newData);
                };
              setTimeout(function () {
                  element_d.click();/*click download, thực hiện 1 thao tác click , khác onclick là event*/
              },1000);
              
            },500);

         });
    });

});
/*popup-save_config*/
    var popup = {
        init : function(){
           this.closePopup(); 
        },
        closePopup : function(){
            $(".mask-popup").removeClass('active');
            reset_filter_search();
        },
    };
</script>

<script>
 var url_pagition = "<?php echo base_url('/product/ajax_buildpc/'); ?>";
  /*phân trang ajax+filter*/
$("body").on("click",".ajaxpagination", function(event){
   event.preventDefault();
   let page = $(this).children("a").attr("data-ci-pagination-page");
   paramspc['page'] = page;
$.ajax({
        url: url_pagition+page,
        type: 'get',
        dataType: 'html',
        data: paramspc,
         beforeSend: function () {
          $("#loadingpdu").show();
        },
        success: function (response) {
          $("#js-modal-popup").html(response);
          $(".mask-popup").addClass('active');
          $("#loadingpdu").hide();
          setTimeout(function() {checked_filter_search();},400);
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(thrownError);
        }
    })
});
</script>