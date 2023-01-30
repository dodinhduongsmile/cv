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
                     <div class="container">
                        <div class="inner">
                           <div class="row clearfix">

                              <div class="col-sm-3 col-xs-12">
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
                                                   <li><h3><i class="fa fa-angle-double-right" aria-hidden="true"></i> <a href="<?php echo get_url_category_edu($value); ?>" title="<?php echo $value->title; ?>"><?php echo $value->title; ?></a></h3></li>
                                                   <?php endforeach; ?>
                                                </ul>
                                            </div>
                                          </div>
                                          
                                       </div>

                                    </div>
                                 </div>
                              </div>
                              <div class="col-sm-9 col-xs-12">
                                 <div class="collection-content-wrapper">
                                    <div class="collection-head">
                                       <div class="row clearfix">
                                          <div class="col-sm-6">
                                             <div class="collection-title">
                                                <h1><?php echo $oneItem->title; ?></h1>
                                                <span>Có tổng <?php echo $total; ?> khóa học. </span>
                                             </div>
                                          </div>
                                          <div class="col-sm-6">
                                             <div class="collection-sorting-wrapper">
                                                <!-- /snippets/collection-sorting.liquid -->
                                                <div class="form-horizontal text-right">
                                                   <label for="SortBy">Sắp xếp</label>
                                                   <select name="SortBy" id="sortbypdu">
                                                      <option data-key="id" value="asc">Tùy chọn</option>
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

                                                <li><h2><a href="<?php echo get_url_category_edu($value); ?>" title="<?php echo $value->title ?>"><?php echo $value->title ?></a></h2></li>
                                                <?php endforeach; ?>
                                            </ul>
                                       </div>
                                    </div>
                                    <div class="collection-body bodycatepdu">
                                       <div class="product-list row clearfix">

                            <?php if(!empty($list_product)) foreach($list_product as $item): ?>
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
   var url_pagition = "<?php echo get_url_category_edu($oneItem); ?>";
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
<style>
  .edu_item .product-img{
    position: relative;
    overflow: hidden;
}
.edu_item h2{    font-size: 16px;}
.edu_item img {
    transition: all ease 0.7s;
}

.edu_item img:hover {
    transform: scale(1.5);
}
</style>