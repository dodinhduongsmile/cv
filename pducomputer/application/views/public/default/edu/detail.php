
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
  <main class="main-content">
    <section id="product-wrapper">
      <div class="wrapper">
        <div class="inner">
          <div class="row clearfix product-single" >
            <div class="col-sm-5 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
              <div class="product-single__photos" >
                <div id="albumedu_slide" class="albumedu_slide owl-carousel owl-theme">
                  <?php if(!empty($oneItem->video)){ ?>
                    <div class="item-video">
                      <div class="image_dot" data-src="<?php echo $this->templates_assets.'images/playvideo.jpg'; ?>"> 
                        <a class="owl-video" href="<?php echo $oneItem->video; ?>"></a>
                      </div>
                    </div>
                  <?php }; ?>
                  <div class="item">
                    <div class="image_dot zoompdu" data-src="<?php echo MEDIA_URL.$oneItem->thumbnail; ?>">
                      <img src="<?php echo MEDIA_URL.$oneItem->thumbnail; ?>" alt="<?php echo $oneItem->title; ?>">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-7 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
              <div class="product-content">
                <div class="pro-content-head clearfix">
                  <h1><?php echo $oneItem->title; ?></h1>
                  <?php if (!empty($danhmuccha)){ ?>
                    <div class="pro-type">
                      <span class="title">Loại: <a href="<?php echo get_url_category_edu(current($danhmuccha)) ?>"><?php echo current($danhmuccha)->title ?></a></span>
                    </div>
                    <span>|</span>
                  <?php }; ?>
                  <div class="pro-sku ProductSku">
                    <span class="title">Mã SP:</span> <span class="sku-number"><?php echo $oneItem->code; ?></span>
                  </div>
                </div>
                <div class="pro-price clearfix">
                  <?php 
                    if($oneItem->is_free == 1){
                        echo '<span class="current-price">Miễn phí</span>';
                    }else{
                      $time = 24 - (int)date("H", time());
                      echo show_price_coin($oneItem);
                      echo '<div class="time-uudai"><i class="fa fa-tachometer" aria-hidden="true"></i> Thời gian ưu đãi còn '.$time.'h</div>';
                    }
                   ?>
                  
                </div>
                <div class="pro-short-desc">
                  <!-- mô tả ngắn -->
                  <?php echo $oneItem->description; ?>

                </div>
                <form id="AddToCartForm" class="form-vertical">
                  <div class="product-variants-wrapper">
                    <div class="product-size-hotline">
                      <div class="product-hotline">
                        Hotline hỗ trợ khách hàng 24/7: <a href="tel:<?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?>"><?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?></a>
                      </div>
                      <span>|</span>
                      <div class="social-network-actions text-left">
                        <div class="fb-like" data-href="<?php echo get_url_edu($oneItem); ?>" data-layout="button_count" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
                      </div>
                    </div>
                  </div>

                  <div class="row clearfix">

                    <?php if($oneItem->is_free == 1){ ?>
                      <button disabled class="btn btn-soldout">Miễn phí</button>
                      <p><i>Bạn vui lòng ấn vào Đăng ký học, để học ngay nhé. Hoặc <a href="<?php echo base_url("lien-he.html"); ?> ">liên hệ</a> lại bên mình, nếu có lỗi!</i></p>
                      <?php } ?>
                      <?php if($auth_useredu){ ?>
                        <div class="col-sm-4 col-xs-6">
                          <div class="product-actions clearfix">
                            <button type="button" id="btnLearn" data-id="<?php echo $oneItem->id; ?>">VÀO HỌC NGAY</button>
                          </div>   
                        </div>
                      <?php }else{ ?>
                        <div class="col-sm-4 col-xs-6">
                          <div class="product-actions clearfix">
                            <button type="button" class="btnBuyEdu" data-id="<?php echo $oneItem->id; ?>">Đăng Ký Ngay</button>
                          </div>   
                        </div>
                      <?php }; ?>
                    </div>      
                  </form>
                  <div class="tagpro">Tag:
                    <?php if(isset($danhmuccha)) foreach($danhmuccha as $tag):?>
                    <a href="<?php echo get_url_category_edu($tag); ?>"><?php echo $tag->title; ?></a>, 
                  <?php endforeach; ?>

                </div>
              </div>
            </div>
          </div>
          <div class="row clearfix">
            <div class="col-sm-9">
              <div class="product-description-wrapper">
                <div class="tab clearfix pdutab_btn">
                  <button class="pro-tablinks active" data-href="#protab1">Mô tả</button>
                  <button class="pro-tablinks" data-href="#protab2">Danh sách bài học</button>
                  <button class="pro-tablinks" data-href="#proCom">Thảo luận</button>
                </div>
                <div class="pdutab_content">
                  <div id="protab1" class="pdutab_item active">
                    <h2 class="title_content">Chi tiết <?php echo $oneItem->title; ?></h2>
                    <!-- nội dung tab 1 -->
                    <div class="content_edu">
                      <?php if(!empty($oneItem->video)){ ?>
                        <div class="iframe_video">
                          <iframe allowfullscreen class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo $oneItem->video; ?>"></iframe> 
                        </div>
                        
                      <?php }else{; ?>
                      <div class="thumb_edu">
                        <img class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo MEDIA_URL. $oneItem->thumbnail; ?>" alt="<?php echo $oneItem->title; ?>" />
                      </div>
                    <?php }; ?>
                      <div class="descript_edu">
                        <h3>Mô Tả Ngắn Khóa Học</h3>
                        <?php echo $oneItem->description; ?>
                      </div>
                      <?php echo $oneItem->content; ?>

                      <div class="teacher_edu">
                        <h3>GIÁO VIÊN Khóa Học</h3>
                        -<?php echo $oneItem->teacher; ?>-
                      </div>
                    </div>
                    <div class="catesame">
                      <strong>Danh mục cùng loại:</strong>
                      <?php if(!empty($category)) foreach($category as $cate): ?>
                      <a class="tag-item" href="<?php echo get_url_category_edu($cate); ?>"><?php echo $cate->title; ?></a>
                    <?php endforeach; ?>
                    </div>
                    <div class="end-pro alert-message alert-danger">
                      <p>
                      <strong>CHÚ Ý: </strong> Khóa học do admin sưu tập được, <br> Tuyệt đối không mang đi chuộc lợi cá nhân! 
                      </p>  
                    </div>
                  </div>
                  <div id="protab2" class="pdutab_item">
                    <!-- tab2 -->
                    <div class="list_edu">
                      
                        <?php echo $listvideo; ?>
                    </div>
                  </div>
                  <div id="proCom" class="pdutab_item">
                    <!-- tab3 -->
                    <div class="fb-comments" data-href="<?php echo get_url_edu($oneItem); ?>" data-width="100%" data-numposts="5"></div>

                    <div id="pducomment"><h6 class="title_cmt">Đánh giá</h6><?php echo $comment_block; ?></div>
                  </div>
                </div>
              </div><!-- pdutab_content -->

            </div>
            <div class="col-sm-3">
              <!-- load sidebar_cateedu -->
              <div class="pdu_dataload" data-loadpdu="sidebar_cateedu"></div>
            </div>
            
          </div>
          <!-- Sản phẩm liên quan -->
          <?php if (!empty($list_related)) : ?>
            <section id="related-products" class="wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
              <div class="home-section-head clearfix">
                <div class="section-title text-left">
                  <h2>
                    Khóa học liên quan
                  </h2>
                  <a href="<?php echo !empty($category['0']) ? get_url_category_edu($category['0']) : '#'?>">Xem tất cả <i class="fas fa-angle-double-right"></i></a>
                </div>
              </div>
              <div class="home-section-body">
                <div class="grid mg-left-15">
                  <div id="owl-related-products-slider" class="owl-carousel owl-theme">
                    <?php foreach ($list_related as $item) : ?>
                      <div class="item grid__item pd-left15">
                        <div class="product-item">
                          <div class="product-img">
                            <a href="<?php echo get_url_edu($item); ?>">
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
                </div>
              </div>
            </section>
          <?php endif; ?>

          <!-- sp history -->
          <?php if (!empty($product_history)): ?>
            <section id="history-products" class="wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
              <div class="home-section-head clearfix">
                <div class="section-title text-left">
                  <h2>
                    Khóa học đã xem
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
                          <a href="<?php echo get_url_edu($item1); ?>">
                            <?php echo getThumbnail($item1,230,240); ?>
                          </a>
                          <?php if($item1->price_sale != 0): ?>
                            <div class="tag-saleoff text-center">
                              <?php echo "-".(100-(($item1->price_sale/$item1->price)*100)) ."%"; ?>
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

                            <h2><a href="<?php echo get_url_edu($item1); ?>" title="<?php echo $item1->title; ?>"><?php echo $item1->title; ?></a></h2>
                          </div>
                          <div class="product-price clearfix">
                            <?php echo show_price_coin($item1); ?>
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

<style>

      .albumedu_slide.owl-carousel.owl-theme .owl-dots {
        transform: translateX(0px);
      }

.dasboard_head_action {
    display: inline-block;
    font-size: 16px;
    padding: 10px 15px;
}
.box_action {
    position: relative;
}
ul.show_content {
    display: none;
    -webkit-animation: slideUp_eff 0.7s;
      animation: slideUp_eff 0.7s;
    transition: all ease 0.5s;
    text-align: left;
    min-width: 200px;
    background: #fff;
    border-radius: 6px;
    position: absolute;
    top: 30px;
    right: 0;
}
ul.show_content li {
    border-bottom: 1px solid #e2dede;
}

.dasboard_head_action button.show_child {
    padding: 5px;
    border-radius: 100%;
    transition: all ease 0.5s;
    font-weight: bold;
    font-size: 20px;
    background: #e4dede;
    color: #000;
    width: 40px;
    height: 40px;
}
.dasboard_head_action:hover ul.show_content,ul.show_content.openp {
    display: block;
    padding: 15px;
    margin-top: 10px;
}
.dasboard_head_action:hover button.show_child,button.show_child.openp {
    background: #6d6a6a;
    border: 1px solid #3333;
}
ul.show_content:before {
  border: 12px solid transparent;
    border-bottom-color: #fff;
    position: absolute;
    top: -21px;
    right: 20px;
    content: "";
    border-radius: 5px;
}

ul.show_content a {
    display: inline-block;
    padding: 5px;
    font-size: 16px;
    text-transform: capitalize;
    color: #55acee;
}

ul.show_content a:hover {
    color: #1068ab;
}
    </style>

