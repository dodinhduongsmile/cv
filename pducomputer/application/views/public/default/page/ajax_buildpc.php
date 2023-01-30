<div class="mask-popup">
  <div class="close-pop-biuldpc" onclick="popup.closePopup()" style="width: 100%;float: left;height: 100%;position: fixed;z-index: 1;"></div>
  <div class="popup-select" style="z-index: 99;">
     <div class="header">
        <div class="top clearfix">
            <h4>Chọn linh kiện</h4>
            <form>
               <input type="text" value="" id="buildpc-search-keyword" class="input-search" placeholder="Bạn cần tìm linh kiện gì?">
               <button class="btn-search" id="js-buildpc-search-btn"><i class="fas fa-search" aria-hidden="true"></i></button>
            </form>
        </div>
        <div class="bottom clearfix">
            <div class="icon-menu-filter-mobile"><i class="fa fa-filter" aria-hidden="true"></i> Lọc</div>
            <span class="close-popup" onclick="popup.closePopup()"><i class="fa fa-times" aria-hidden="true"></i></span>
        </div>
     </div>
     <div class="popup-main clearfix">
        <div class="popup-main_filter w-30 float_l active">
           <h4>Lọc sản phẩm theo</h4>
           <div class="list-filter">
           	<div class="gr-filter">
           		<ul class="no-bullets filter-price clearfix">
                    <li class="filter_between">
                        <input name="filter_price_between" class="filter_input filter-price-from" type="text" maxlength="13" placeholder="Từ" value="">
                        <input name="filter_price_between" class="filter_input filter-price-to" type="text" maxlength="13" placeholder="Đến" value="">
                        <button name="button" class="btn-primarys js_pricefilterpc">Áp dụng<i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
                    </li>
                   <li>
                      
                      <input type="radio" name="price-filter" data-price-from="0" data-price-to="9000000000" class="js_pricefilterpcx">
                      <span>Tất cả</span>
                     
                   </li>
                   <li>
                    
                      <input type="radio" name="price-filter" data-price-from="0" data-price-to="1000000" class="js_pricefilterpcx">
                      <span>Nhỏ hơn 1,000,000₫</span>
                      
                   </li>
                   <li>
                      
                      <input type="radio" name="price-filter" data-price-from="0" data-price-to="2000000" class="js_pricefilterpcx">
                      <span>Nhỏ hơn 2,000,000₫</span>
                     
                   </li>
                   <li>
                      
                      <input type="radio" name="price-filter" data-price-from="2000000" data-price-to="3000000" class="js_pricefilterpcx">
                      <span>Từ 2 - 3,000,000₫</span>
                     
                   </li>
                   <li>
                      
                      <input type="radio" name="price-filter" data-price-from="3000000" data-price-to="5000000" class="js_pricefilterpcx">
                      <span>Từ 3 - 5,000,000₫</span>
                      
                   </li>
                   <li>
                      
                      <input type="radio" name="price-filter" data-price-from="5000000" data-price-to="7000000" class="js_pricefilterpcx">
                      <span>Từ 5 -> 10,000,000₫</span>
                      
                   </li>
                   <li>
                      
                      <input type="radio" name="price-filter" data-price-from="10000000" data-price-to="1000000000" class="js_pricefilterpcx">
                      <span>Lớn hơn 10,000,000₫</span>
                      
                   </li>
                </ul>
           </div>
           <?php if(!empty($list_attrFilter)){
            foreach($list_attrFilter as $attr){
            ?>

              <div class="gr-filter brand">
                 <h5 class="title-filter"><?php echo $attr->title; ?></h5>
                 <ul>
                 	<?php
                 	$datacontent = json_decode($attr->content);
                 	if(!empty($datacontent)) foreach($datacontent as $attr1):
                 	?>
                    <li>
                    	 <input type="radio" data-type="<?php echo $attr->slugattr; ?>" name="attribute[<?php echo $attr->slugattr; ?>]" id="<?php echo $attr1->value; ?>" value="<?php echo $attr1->value; ?>" class="js_pricefilterpc"/>
                    	<label for="<?php echo $attr1->value; ?>"><?php echo $attr1->key; ?></label>
                      
                    </li>
                    <?php endforeach; ?>
                    <button class="reset-filter" data-reset="<?php echo $attr->slugattr; ?>">Reset</button>
                 </ul>
              </div>
              <?php }; };?>
           <!--list-filter-->
        </div>
    </div>
        <!--popup-main_filter-->
        <div class="popup-main_content w-70 float_r">
           <div class="sort-paging clear">
              <div class="sort-block float_l">
                 <span>Sắp xếp: </span>
                 <select name="SortBy" id="sortbybuilpc">
                      <option value="">Tùy chọn</option>
                      <option data-key="countsell" value="desc">Sản phẩm bán chạy</option>
                      <option data-key="title" value="asc">Theo bảng chữ cái từ A-Z</option>
                      <option data-key="title" value="desc">Theo bảng chữ cái từ Z-A</option>
                      <option data-key="price" value="asc">Giá từ thấp tới cao</option>
                      <option data-key="price" value="desc">Giá từ cao tới thấp</option>
                      <option data-key="created_time" value="desc">Mới nhất</option>
                      <option data-key="created_time" value="asc">Cũ nhất</option>
                   </select>
              </div>
              <div class="paging-block float_r paging-ajax">
                
                  <div id="pagination-" class="text-center clear-left">
                      <?php echo !empty($pagination) ? $pagination : ''; ?>
                  </div>
                
              </div>
           </div>
           <div class="list-product-select">
           	<?php if(!empty($list_product)) foreach($list_product as $item): ?>
              <div class="p-item">
                 <a href="<?php echo get_url_product($item); ?>" class="p-img">
                 <img src="<?php echo getThumbnailnoajax($item->thumbnail,230,240); ?>" alt="<?php echo $item->title; ?>">
                 </a>
                 <div class="info">
                    <a href="<?php echo get_url_product($item); ?>" class="p-name"><?php echo $item->title; ?></a>
                    <table>
                       <tbody>
                          <tr>
                             <td width="80">Mã SP:</td>
                             <td><?php echo $item->code; ?></td>
                          </tr>
                          <tr>
                             <td>Bảo hành:</td>
                             <td><?php echo $item->guarantee; ?></td>
                          </tr>
                          <tr>
                             <td valign="top">Kho hàng:</td>
                             <td>
                             	<?php if($item->quality): ?>
                         		<span class="dongbotonkho">
                                    <span class="detail" style="background: #278c56; color: #fff; padding: 2px 10px; white-space: pre-line;"><i class="fa fa-check" aria-hidden="true"></i> Còn hàng</span>
                                  </span>
                                  <?php else: ?>
                                <span style="background: #eaeaea; color: #555; padding: 2px 10px; white-space: pre-line;"><i class="fas fa-phone fa-flip-horizontal"></i> Liên hệ</span><br>
                            <?php endif; ?>
                             </td>
                          </tr>
                          <tr>
                             <td valign="top">giá:</td>
                             <td>
                                <span class="p-price">
                                	<?php 
                                	if (!empty($item->price) && !empty($item->price_sale)) {
							            $price = $item->price_sale;
							            $price = number_format($price,0,'','.');
							        }elseif(!empty($item->price) && empty($item->price_sale)){
							            $price = $item->price;
							            $price = number_format($price,0,'','.');
							        }else{
							            $price = "Liên hệ";
							        }
							        echo $price;

							         ?>

                                </span>
                             </td>
                          </tr>
                       </tbody>
                    </table>
                    
                 </div>
                 <span class="save_item_pc btn-buy js-select-product <?php if(!$item->quality){ echo 'sp-het-hang';} ?>" data-id="<?php echo $item->id; ?>">
                 <span class="canh-bao-het-hang">1. Sản phẩm chỉ tạm hết hàng<br>
                 2. Quý khách có thể lựa chọn sang sản phẩm khác<br>
                 3. Hoặc liên hệ với NV. Kinh Doanh để đặt hàng
                 </span>
                 </span>
              </div>
          <?php endforeach; ?>
              
           </div>
        </div>
     </div>
  </div>
</div>
<script>
	jQuery(document).ready(function($) {
        /*
        $(".show-popup_select").click(function(event) {
            $(".mask-popup").addClass('active');
        });
         */
        $(".icon-menu-filter-mobile").click(function(event) {
            $(".popup-main_filter").toggleClass('w-30 active');
            $(".popup-main_content").toggleClass('w-70 float_r');
        });
        if($(window).width() < 800){
            $(".popup-main_filter").removeClass('w-30 active');
        }

    });
</script>
