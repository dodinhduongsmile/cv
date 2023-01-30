 <section id="breadcrumb-wrapper" class="breadcrumb-w-img">
               <div class="breadcrumb-overlay"></div>
               <div class="breadcrumb-content">
                  <div class="wrapper">
                     <div class="inner text-center">
                        <div class="breadcrumb-big">
                           <h2>
                             <?php echo $keyword ? $keyword : ''; ?>
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
                                    <div class="grid">
                                       <div class="grid__item large--one-whole small--one-whole">
                                        
                                       <?php $this->load->view($this->template_path . 'block/sidebar_category'); ?>

                                      </div>
                                   </div>
                                </div>
                             </div>
                              <div class="col-sm-9">
                                 <div class="collection-content-wrapper">
                                    <div class="collection-head">
                                       <div class="grid">
                                          <div class="grid__item large--seven-twelfths medium--one-whole small--one-whole">
                                             <div class="collection-title">
                                                <h1>Từ khóa tìm kiếm <?php echo $type; ?>: <strong><?php echo $keyword ? $keyword : ''; ?></strong></h1>
                                                <span>Có tổng <?php echo count($data_product); ?> sản phẩm. </span>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="collection-body bodycatepdu">
                                       <div class="product-list row clearfix">
                            <?php if($type == "product"): ?>
                            <?php if(!empty($data_product)) foreach($data_product as $item): ?>
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
                                            <?php if($item->price_sale == 0): ?>
                                              <span class="current-price"><?php echo formatMoney($item->price); ?></span>
                                              <?php else: ?>
                                              <span class="current-price"><?php echo formatMoney($item->price_sale); ?></span>
                                              <span class="original-price"><s><?php echo formatMoney($item->price); ?></s></span>
                                            <?php endif; ?>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                            <?php endforeach; ?>
                    <?php elseif($type == "post"): ?>
                      <?php if (!empty($data_product)) foreach ($data_product as $key => $value) : ?>
			                      <div class="col-md-4 col-xs-6 col-480-12">
			                        <div class="article-item">
			                          <div class="article-img">
			                            <a href="<?php echo get_url_post($value); ?>">
			                            <?php echo getThumbnail($value,400,370); ?>
			                            </a>
			                          </div>
			                          <div class="article-info-wrapper">
			                            <div class="article-date">
			                              <span class="datetime_m"><?php echo time_GMT_7x($value->created_time,'d'); ?></span>
			                              <span class="datetime_b">Thg <?php echo time_GMT_7x($value->created_time,'m'); ?></span>
			                            </div>
			                            <div class="article-title">
			                              <h2><a href="<?php echo get_url_post($value); ?>" title="<?php echo $value->title; ?>"><?php echo $value->title; ?></a></h2>
			                            </div>
			                          
			                            <div class="article-desc">
			                                <?php echo $value->description; ?>
			                            </div>
			                            <div class="article-info">
			                                <div class="article-author">
			                                  <i class="fa fa-user"></i> Admin PDU
			                                </div>
			                                <div class="article-comment">
			                                  <i class="fa fa-comments"></i>2
			                                </div>
			                                 <a href="<?php echo get_url_post($value); ?>" title="<?php echo $value->title; ?>">Xem thêm <i class="fa fa-angle-double-right"></i></a>
			                            </div>
			                          </div>
			                        </div>
			                      </div>
                      <?php endforeach; ?>
                    <?php else: ?>
                        <?php if (!empty($data_product)) foreach ($data_product as $key => $item) : ?>
                          <div class="col-md-3 col-sm-4 col-xs-6 col-480-12">
                            <div class="product-item edu_item">
                              <div class="product-img">
                                <a href="<?php echo get_url_edu($item); ?>">
                                <?php echo getThumbnail($item,230,240); ?>
                                </a>
                                <?php if($item->price_sale != 0): ?>
                                <div class="tag-saleoff text-center">
                                  <?php echo "-".ceil((100-(($item->price_sale/$item->price)*100))) ."%"; ?>
                                </div>
                              <?php endif; ?>
                                
                              </div>
                              <div class="product-item-info text-center">
                                <div class="product-title">
                                  
                                  <h2><a href="<?php echo get_url_edu($item); ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></h2>
                                </div>
                                <div class="product-price clearfix">
                                  <?php echo show_price_coin($item); ?>
                                </div>
                              </div>
                            </div>
                          </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                                        </div>
                                       <div class="pagination not-filter">
                                          <div id="pagination-" class="text-center clear-left">
                                             <?php echo !empty($pagination) ? $pagination : ''; ?>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              

                        </div></div>
                     </div>
                  </section>

                  <?php $this->load->view($this->template_path . 'block/type_product'); ?>
               </main>
            </div>
            <!-- accordion -->

<script>
  /*phân trang ajax
  ở category product thì nó gọi tới 1 hàm ajax xử lý riêng
  ở đây sẽ gọi chung vào 1 action.
  - Không để vào file .js dùng chung đc, vì ở product nó còn kèm theo cả lọc+phân trang. muốn dùng chung thì cũng phải gộp vào action category
  */
$("body").on("click",".ajaxpagination", function(event){
   event.preventDefault();
   let page = $(this).children("a").attr("data-ci-pagination-page");
   let url = $(this).children("a").attr("href");
$.ajax({
        url: url,
        type: 'get',
        dataType: 'html',
        data: {page},
         beforeSend: function () {
          $("#loadingpdu").show();
        },
        success: function (response) {
          $(".bodycatepdu").html(response);
          
          $("#loadingpdu").hide();
        }
    })
});
</script>