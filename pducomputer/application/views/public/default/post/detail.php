
<section id="breadcrumb-wrapper" class="breadcrumb-w-img">
   <div class="breadcrumb-overlay"></div>
   <div class="breadcrumb-content">
      <div class="wrapper">
         <div class="inner text-center">
            <div class="breadcrumb-big">
               <h2>
                  <?php echo $oneItem->title ?>
               </h2>
            </div>
            <?php echo !empty($breadcrumb) ? $breadcrumb : ''; ?>
         </div>
      </div>
   </div>
</section>
<div id="PageContainer" class="is-moved-by-drawer">
  <main class="main-content" role="main">
    <section id="blog-wrapper">
      <div class="wrapper">
        <div class="inner">
          <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
              <div class="sofabo_left article-content">
                <div class="sofabo_left_top">
                  <div class="article-head">
                    <h1><?php echo $oneItem->title ?></h1>
                    <div class="row">
                      <div class="col-xs-8 pd-left15 col-480-12">
                        <div class="article-date-comment">
                          <div class="date"><i class="fa fa-calendar-alt"></i> <?php echo convertDetailTime($oneItem->created_time) ?></div>
                          <div class="comment"><i class="fa fa-comment-alt"></i> <span class="fb-comments-count" data-href="<?php echo get_url_post($oneItem); ?>"></span> 
                            <i class="fa fa-eye" aria-hidden="true"></i><?php echo $oneItem->viewed; ?>
                          </div>
                          <div class="author">
                            <i class="fa fa-user"></i> Admin PDU
                          </div>
                        </div>
                      </div>
                      <div class="col-xs-4 col-480-12">
                        <div class="social-network-actions text-right">
                          <div class="fb-like" data-href="<?php echo get_url_post($oneItem); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="product clearfix">
                    <a href=""><img src="<?php echo MEDIA_URL.$oneItem->thumbnail; ?>" alt=""></a>
                    <div class="product_content">
                      <h3><a href=""><?php echo $oneItem->title ?></a></h3>
                      <p><?php echo $oneItem->description; ?></p>
                    </div>
                  </div>
                  <div class="post_detail">
                    <?php echo $oneItem->content ?>
                    <?php if(!empty($list_backlink)): ?>
                    <div class="backlink">
                      <strong>Xem thêm:</strong>
                      <?php foreach($list_backlink as $item): ?>
                      <a href="<?php echo get_url_post($item); ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                    <div class="catesame">
                      <strong>Tags:</strong>
                      <?php if(!empty($category)) foreach($category as $cate): ?>
                      <a class="tag-item" href="<?php echo get_url_category_post($cate); ?>"><?php echo $cate->title; ?></a>
                    <?php endforeach; ?>
                    </div>
                  </div>
                  <div id="comment">
                    <h6 class="title_cmt">Bình luận facebook</h6>
                    <div class="fb-comments" data-href="<?php echo get_url_post($oneItem); ?>" data-width="100%" data-numposts="5"></div>
                  </div>
                  <div id="pducomment"><h6 class="title_cmt">Đánh giá</h6><?php echo $comment_block; ?></div>
                </div>
                <div class="sofa_left_bot">
                  <h3>sản phẩm HOT</h3>
                  <div class="bodycatepdu">
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
                            <?php echo "-".(100-(($item->price_sale/$item->price)*100)) ."%"; ?>
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
                             <?php echo show_price_detail1($item); ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endforeach; ?>
                  </div>
                  <div class="text-center"><?php echo !empty($pagination) ? $pagination : ''; ?></div>
                </div>
              </div>
                
                <div class="news">
                  <div class="row">
                    <div class="col-md-5 col-xs-12">
                      <div class="new_left">
                        <h4>tin tức - sự kiện</h4>
                        <ul>
                          <?php if (!empty($list_post)) foreach ($list_post as $key => $value) : ?>
                          <li>
                            <a href="<?php echo get_url_post($value); ?>"><img class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo getImageThumb($value->thumbnail,230,230) ?>" alt="<?php echo $value->title; ?>"></a>
                            <h3><a href="<?php echo get_url_post($value); ?>" title="<?php echo $value->title; ?>"><?php echo $value->title; ?></a></h3>
                          </li>
                          <?php endforeach; ?>
                        </ul>
                      </div>
                    </div>
                    <div class="col-md-7 col-xs-12">
                      <div class="new_right">
                        <h4>video</h4>
                        <div class="video">
                          <iframe class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo $this->_settings_home->videoyt1; ?>"></iframe> 
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
              <div class="sofabo_right">
                
                <?php $this->load->view($this->template_path . 'block/sidebar_category'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</div>

<script>
 var url_pagition = "<?php echo base_url('/product/ajaxProductInPost/'); ?>";
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

<style>
.sofabo_left .sofabo_left_top .product {
    background: #f1f1f1;
    margin: 20px auto;
}
.sofabo_left .sofabo_left_top .product>a {
    display: block;
    float: left;
    width: 63%;
}
.sofabo_left .sofabo_left_top .product a img {
    display: block;
    width: 100%;
    height: 287px;
    object-fit: contain;
    box-shadow: 0px 1px 3px #33333345;
}
.sofabo_left .sofabo_left_top .product .product_content {
    overflow: hidden;
    padding: 0 10px 0 15px;
    float: left;
    width: 37%;
}
.sofabo_left .sofabo_left_top .product .product_content h3 {
    font-size: 18px;
    line-height: 30px;
    font-weight: bold;
    padding: 10px 0 15px;
}

.sofabo_left .sofabo_left_top .product .product_content p {
    text-align: justify;
    font-size: 14px;
    line-height: 20px;
    color: #333333;
    overflow: hidden;
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
    white-space: normal;
    -webkit-line-clamp: 5;
    display: -webkit-box;
}
.post_detail {
    line-height: 25px;
    font-size: 18px;
    padding: 30px 0;
}
.sofabo_right {
    margin-top: 36px;
}
.article-head h1 {
    text-transform: capitalize;
}
.sofabo_left .sofa_left_bot > h3 {
    font-size: 24px;
    line-height: 30px;
    font-weight: bold;
    padding-bottom: 15px;
    margin-bottom: 15px;
    border-bottom: 1px solid #cfcfcf;
    text-transform: uppercase;
    position: relative;
}
.sofa_left_bot h3:before {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 80px;
    height: 3px;
    background: #0d83e8;
}
.sofabo_left .news {
    padding-top: 50px;
}
.sofabo_left .news .new_left h4 {
    font-size: 14px;
    position: relative;
    text-transform: uppercase;
    padding-bottom: 12px;
    margin-bottom: 12px;
}
.sofabo_left .news .new_left h4::before {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 150px;
    height: 3px;
    background: #0d83e8;
}
.sofabo_left .news .new_left ul li {
    display: flex;
    padding-bottom: 15px;
    align-items: center;
}
.sofabo_left .news .new_left ul li a {
    display: block;
    padding-right: 15px;
}
.sofabo_left .news .new_left ul li a img {
    display: block;
    height: 67px;
    object-fit: cover;
}
.sofabo_left .news .new_left ul li h3 {
    font-size: 14px;
    line-height: 20px;
    text-align: justify;
}
.sofabo_left .news .new_left ul li p a {
    display: block;
    overflow: hidden;
    -webkit-box-orient: vertical;
    text-overflow: ellipsis;
    white-space: normal;
    -webkit-line-clamp: 3;
    display: -webkit-box;
}
.sofabo_left .news .new_right h4 {
    font-size: 14px;
    position: relative;
    text-transform: uppercase;
    padding-bottom: 12px;
    margin-bottom: 12px;
}
.sofabo_left .news .new_right h4::before {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 80px;
    height: 3px;
    background: #0d83e8;
}
.sofabo_left .news .new_right .video iframe {
    width: 100%;
    height: 308px;
    border: none;
}
div#comment {
    padding: 30px 0 15px;
    border: 2px dashed #55acee;
    margin-bottom: 30px;
    box-shadow: 0px 1px 10px #55acee;
}
.product-item {
    margin-bottom: 30px;
}
@media (max-width: 767px){
  .sofabo_left .sofabo_left_top .product>a,.sofabo_left .sofabo_left_top .product .product_content {
    display: block;
    float: none;
    width: 100%;
}
}
</style>