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

<section id="dev-product" class="pb-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-12 sidebar">
                <?php $this->load->view($this->template_path . 'block/sidebar_category') ?>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="title-bx-main mb-10">
                    <div class="name-ctgr-main mb-30">Báo giá tổng hợp</div>
                    <div class="center_content" style="clear: both;">
                        <?php echo !empty($this->_settings->sp_in_bg) ? $this->_settings->sp_in_bg : ''; ?>
                   </div>
                </div>
                <div class="tit-print">Danh sách sản phẩm đã chọn in</div>
                <table class="table table-striped table-my-order">
                    <thead>
                        <tr>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col" style="width: 15%;" class="text-center">Số lượng</th>
                            <th scope="col" class="text-center">Đơn giá</th>
                            <th scope="col" class="text-center">Thành tiền</th>
                            <th class="text-center">Tùy chọn</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total_price = 0; ?>
                        <?php if (!empty($data_arr_bg)) foreach ($data_arr_bg as $key => $value) : 
                            $data_product = getByIdProduct($value->id);
                            $total_price += $value->price*$value->quantity;
                        ?>
                            <tr>
                                <td>
                                    <img src="<?php echo getImageThumb($data_product->thumbnail,100,100); ?>" style="width: 100px;" class="img-thumb-small-table" alt="<?php echo $data_product->title; ?>">
                                </td>
                                <td>
                                    <a href="<?php echo get_url_product($data_product); ?>" title="<?php echo $data_product->title ?>" class="titleprd">
                                        <?php echo $data_product->title ?>
                                    </a>
                                    <div class="content" style="padding-top: 6px;"><strong>Kích thước:</strong> 
                                        <span style="text-transform: lowercase"><?php echo $data_product->size; ?></span>
                                        </div>

                                    <div class="content" style="padding-top: 6px;"><strong>Trọng lượng:</strong> <span style="text-transform: lowercase"><?php echo $data_product->mass; ?></span></div>

                                    <div class="content" style="padding-top: 6px;"><strong>Bảo hành:</strong> <span style="text-transform: lowercase"><?php echo $data_product->guarantee; ?></span></div>

                                </td>
                                <td>
                                    <input type="number" class="form-control text-center quantity_item_bg number" min="1" max="9999" value="<?php echo $value->quantity ?>">
                                </td>
                                <?php echo show_price_cart($data_product,$value->quantity); ?>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-danger remove_item_bg" data-id="<?php echo $value->id ?>">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="5"><strong>Tổng tiền thanh toán</strong></td>
                            <td class="text-right total_price" style="font-weight: bold; color: #d72623; font-size: 16px;">
                                <?php echo number_format($total_price,0,'','.') ?><sup>₫</sup>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-striped table-my-mb" style="display: none;">
                    <thead>
                        <tr>
                            <th scope="col">Ảnh</th>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col" style="width: 15%;" class="text-center">Số lượng</th>
                            <th scope="col" class="text-center">Đơn giá</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data_arr_bg)) foreach ($data_arr_bg as $key => $value) : 
                            $data_product = getByIdProduct($value->id);
                        ?>
                            <tr>
                                <td>
                                    <img src="<?php echo getImageThumb($data_product->thumbnail,80,80); ?>" style="width: 100px;" class="img-thumb-small-table" alt="<?php echo $data_product->title; ?>">
                                    <a class="btn btn-sm btn-danger fr remove_item_bg" data-id="<?php echo $value->id ?>" style="color: white; padding: 1px 2px;" ><i class="fa fa-trash"></i></a>
                                </td>
                                <td>
                                    <a href="<?php echo get_url_product($data_product); ?>" title="<?php echo $data_product->title ?>" class="titleprd">
                                        <?php echo $data_product->title ?>
                                    </a>
                                </td>
                                <td>
                                    <input type="number" class="form-control text-center quantity_item_bg number" min="1" max="9999" value="<?php echo $value->quantity ?>">
                                </td>
                                <?php if (!empty($value->price) && !empty($value->price_sale)): ?>
                                    <td class="text-center"><?php echo number_format($value->price_sale,0,'','.'); ?><sup>₫</sup></td>
                                <?php elseif(!empty($value->price) && empty($value->price_sale)): ?>     
                                    <td class="text-center"><?php echo number_format($value->price,0,'','.'); ?><sup>₫</sup></td>
                                <?php else: ?>                                
                                    <td class="text-center">Liên hệ</td>
                                <?php endif; ?>                                
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="3"><strong>Tổng tiền thanh toán</strong></td>
                            <td class="text-right total_price" style="font-weight: bold; color: #d72623; font-size: 16px;">
                                <?php echo number_format($total_price,0,'','.') ?><sup>₫</sup>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="print-footer" style="clear: both;">
                    <a style="background: #ff5722; color: white; padding: 0px 5px; margin: 5px; border: none;" href="<?php echo base_url('print_bao_gia.html?vat=1'); ?>" target="_blank" class="btn btn-order btn-next-order">
                        <i class="fa fa-print" aria-hidden="true"></i>&nbsp;In báo giá sau thuế
                        <br>
                        <span style="font-size: 13px; font-style: italic;">(Nếu bạn lấy hóa đơn VAT)</span>
                    </a>
                    <a style="background: #ff5722; color: white; padding: 0px 5px; margin: 5px; border: none;" href="<?php echo base_url('print_bao_gia.html'); ?>" target="_blank" class="btn btn-order btn-next-order"><i class="fa fa-print" aria-hidden="true"></i>&nbsp;In báo giá trước thuế
                        <br>
                        <span style="font-size: 13px; font-style: italic;">(Nếu bạn không lấy hóa đơn VAT)</span>
                    </a>
                </div>  
              
                <div class="col-12 seclect-sp" style="clear: both;">        
                    <b>Chọn danh mục</b>
                    <select class="sortBy" id="sort_category">
                        <?php if (!empty($list_category)) foreach ($list_category as $key => $value) : ?>
                            <option <?php echo $category_id == $value['id'] ? 'selected' : ''; ?> value="<?php echo get_url_bao_gia($oneItem).'/page/'.$page.'?category='.$value['id']; ?>"><?php echo $value['title']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div> 
                <table class="table table-striped table-my">
                    <thead>
                        <tr>
                            <th scope="col">Tên sản phẩm</th>
                            <th scope="col">Ảnh</th>
                            <th scope="col" class="text-center">Đơn giá</th>
                            <th scope="col" class="text-center">Tùy chọn In</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($list_product)) foreach ($list_product as $key => $value) : ?>
                            <tr>
                                <td>
                                    <a href="<?php echo get_url_product($value); ?>" title="<?php echo $value->title ?>" class="titleprd"><?php echo $value->title ?></a>
                                </td>
                                <td>
                                    <?php echo getThumbnail($value,100,100); ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($value->price) && !empty($value->price_sale)){
                                        echo number_format($value->price_sale,0,'','.').'<sup>₫</sup>';
                                    }elseif(!empty($value->price) && empty($value->price_sale)){
                                        echo number_format($value->price,0,'','.').'<sup>₫</sup>';
                                    }else{
                                        echo 'Liên hệ';
                                    } ?>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0)" class="btn btn-block btn-tragop btn-print in_bao_gia" data-id="<?php echo $value->id; ?>" rel="nofollow">Chọn In báo giá</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>      
                <div class="shop_toolbar t_bottom">
                    <div class="pagination">
                        <?php echo !empty($pagination) ? $pagination : ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
  