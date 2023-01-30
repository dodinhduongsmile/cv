
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