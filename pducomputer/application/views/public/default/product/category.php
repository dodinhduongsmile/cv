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
                  <section id="collection-wrapper">
                     <div class="wrapper">
                        <div class="inner">
                           <div class="row clearfix flex-reverse">
                            <div class="col-sm-3">
                                 <div class="collection-sidebar-wrapper">
                                    <div class="row clearfix">
                                       <div class="col-xs-12">
                                          <div class="collection-filter-price category_children">
                                            <button class="accordion cs-title col-sb-trigger">
                                             <span>Cùng danh mục</span>
                                             </button>
                                             <div class="panel sidebar-sor">
                                                <ul class="list-brand-check">
                                                    <?php if (!empty($list_category)) foreach ($list_category as $key => $value) : ?>
                                                   <li><h3><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="<?php echo get_url_category_product($value); ?>" title="<?php echo $value->title; ?>"><?php echo $value->title; ?></a></h3></li>
                                                   <?php endforeach; ?>
                                                </ul>
                                            </div>
                                          </div>
                                          <div class="collection-filter-price">
                                            <button class="accordion cs-title col-sb-trigger">
                                             <span>Tình trạng sản phẩm</span>
                                             </button>
                                             <div class="panel sidebar-sort">
                                                <ul class="no-bullets filter-price clearfix">
                                                   <li>
                                                      <input type="radio" name="likenew-filter" data-likenew="0" class="js_filternewlike">
                                                      <span>Đã qua sử dụng</span>
                                                     
                                                   </li>
                                                   <li>
                                                      <input type="radio" name="likenew-filter" data-likenew="1" class="js_filternewlike">
                                                      <span>Mới 100%</span>
                                                   </li>
                                                   <li>
                                                      <input type="radio" name="likenew-filter" data-likenew="" class="js_filternewlike">
                                                      <span>Tất cả</span>
                                                   </li>
                                                </ul>
                                            </div>
                                          </div>
                                          <div class="collection-filter-price">

                                             <button class="accordion cs-title col-sb-trigger">
                                             <span>Khoảng giá</span>
                                             </button>
                                             <div class="panel sidebar-sort">
                                                <ul class="no-bullets filter-price clearfix">
                                                    <li class="filter_between">
                                                        <input name="filter_price_between" class="filter_input filter-price-from" type="text" maxlength="13" placeholder="Từ" value="">
                                                        <input name="filter_price_between" class="filter_input filter-price-to" type="text" maxlength="13" placeholder="Đến" value="">
                                                        <button name="button" class="btn-primarys js_pricefilterpdu">Áp dụng<i class="fa fa-angle-double-right" aria-hidden="true"></i></button>
                                                    </li>
                                                   <li>
                                                      
                                                      <input type="radio" name="price-filter" data-price-from="0" data-price-to="1000000000" class="js_pricefilterpdux">
                                                      <span>Tất cả</span>
                                                     
                                                   </li>
                                                   <li>
                                                    
                                                      <input type="radio" name="price-filter" data-price-from="0" data-price-to="2000000" class="js_pricefilterpdux">
                                                      <span>Nhỏ hơn 2,000,000₫</span>
                                                      
                                                   </li>
                                                   <li>
                                                      
                                                      <input type="radio" name="price-filter" data-price-from="0" data-price-to="4000000" class="js_pricefilterpdux">
                                                      <span>Nhỏ hơn 4,000,000₫</span>
                                                     
                                                   </li>
                                                   <li>
                                                      
                                                      <input type="radio" name="price-filter" data-price-from="4000000" data-price-to="6000000" class="js_pricefilterpdux">
                                                      <span>Từ 4 - 6,000,000₫</span>
                                                     
                                                   </li>
                                                   <li>
                                                      
                                                      <input type="radio" name="price-filter" data-price-from="6000000" data-price-to="10000000" class="js_pricefilterpdux">
                                                      <span>Từ 6 - 10,000,000₫</span>
                                                      
                                                   </li>
                                                   <li>
                                                      
                                                      <input type="radio" name="price-filter" data-price-from="10000000" data-price-to="20000000" class="js_pricefilterpdux">
                                                      <span>Từ 10 -> 20,000,000₫</span>
                                                      
                                                   </li>
                                                   <li>
                                                      
                                                      <input type="radio" name="price-filter" data-price-from="20000000" data-price-to="1000000000" class="js_pricefilterpdux">
                                                      <span>Lớn hơn 20,000,000₫</span>
                                                      
                                                   </li>
                                                </ul>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-xs-12">
                                        <?php if(!empty($dataattribute)) foreach($dataattribute as $item): ?>
                                          <div class="collection-filter-price">
                                             <button class="accordion cs-title col-sb-trigger">
                                             <span><?php echo $item->title; ?></span>
                                             </button>
                                             <div class="panel sidebar-sort">
                                                <ul class="no-bullets filter-vendor clearfix">
                                                  <?php
                                                  $content = json_decode($item->content);
                                                  if(!empty($content)) foreach($content as $item1):
                                                  ?>
                                                   <li>
                                                      <input type="radio" data-type="<?php echo $item->slugattr; ?>" name="attribute[<?php echo $item->slugattr; ?>]" value="<?php echo $item1->value; ?>" class="js_pricefilterpdu">
                                                      <span><?php echo $item1->key; ?></span>
                                                      
                                                   </li>
                                                   <?php endforeach; ?>
                                                   <button class="reset-filter btn" data-reset="<?php echo $item->slugattr; ?>">Reset</button>
                                                </ul>
                                             </div>
                                          </div>
                                        <?php endforeach; ?>

                                       </div>

                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-9">
                                 <div class="collection-content-wrapper">
                                    <div class="collection-head">
                                       <div class="row clearfix">
                                          <div class="col-sm-6">
                                             <div class="collection-title">
                                                <h1><?php echo $oneItem->title; ?></h1>
                                                <span>Có tổng <?php echo $total; ?> sản phẩm. </span>
                                             </div>
                                             <div class="filter_likenew">
                                              <p>Bạn muốn mua sản phẩm có tình trạng nào?</p>
                                               <a href="javascript:void(0);" class="js_filternewlike" data-likenew="0"><?php echo $oneItem->title; ?> đã qua sử dụng</a>
                                               <a href="javascript:void(0);" class="js_filternewlike" data-likenew="1"><?php echo $oneItem->title; ?> mới 100%</a>
                                             </div>
                                          </div>
                                          <div class="col-sm-6">
                                             <div class="collection-sorting-wrapper">
                                                <!-- /snippets/collection-sorting.liquid -->
                                                <div class="form-horizontal text-right">
                                                   <label for="SortBy">Sắp xếp</label>
                                                   <select name="SortBy" id="sortbypdu">
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
                                              
                                             </div>
                                          </div>
                                           
                                       </div>
                                       <div class="collection-desc">
                                        <ul class="list-chidren">
                                                <?php if (!empty($list_category)) foreach ($list_category as $key => $value) : ?>

                                                <li><h2><a href="<?php echo get_url_category_product($value); ?>" title="<?php echo $value->title ?>"><?php echo $value->title ?></a></h2></li>
                                                <?php endforeach; ?>
                                            </ul>
                                       </div>
                                    </div>
                                    <div class="collection-body bodycatepdu">
                                       <div class="product-list row clearfix">

                            <?php if(!empty($list_product)) foreach($list_product as $item): ?>
                                 <div class="col-md-3 col-sm-4 col-xs-6 col-480-12">
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
                                       <div class="pagination not-filter">
                                          <div id="pagination-" class="text-center clear-left">
                                             <?php echo !empty($pagination) ? $pagination : ''; ?>
                                             
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              
                           </div>
                        </div>
                     </div>
                  </section>

                  <?php $this->load->view($this->template_path . 'block/type_product'); ?>
               </main>
            </div>

<script>
 var url_pagition = "<?php echo base_url('/product/ajax_filter/'); ?>";
  /*phân trang ajax+filter*/
$("body").on("click",".ajaxpagination", function(event){
   event.preventDefault();
   let page = $(this).children("a").attr("data-ci-pagination-page");
   paramspdu['page'] = page;
$.ajax({
        url: url_pagition+page,
        type: 'get',
        dataType: 'html',
        data: paramspdu,
         beforeSend: function () {
          $("#loadingpdu").show();
        },
        success: function (response) {
          $(".bodycatepdu").html(response);
          
          $("#loadingpdu").hide();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr);
            console.log(thrownError);
        }
    })
});
</script>
            <!-- accordion -->
            <script>
               jQuery(document).ready(function() {
                  var acc = document.getElementsByClassName("accordion");
                  var i;
               
                  for (i = 0; i < acc.length; i++) {
                     acc[i].onclick = function() {
                        this.classList.toggle("active");
                        var panel = this.nextElementSibling;
                        if (panel.style.maxHeight) {
                           panel.style.maxHeight = null;
                        } else {
                           panel.style.maxHeight = panel.scrollHeight+30 + "px";
                        }
                     }
                  }
               
                  if ($(window).width() > 767) {
                     $('.accordion.col-sb-trigger').trigger('click');
                  }
               });
            </script>