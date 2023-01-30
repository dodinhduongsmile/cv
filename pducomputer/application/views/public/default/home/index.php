
<!-- main-slider -->
        <div id="main-slider">
          <div class="wrapper">
            <div class="inner">
              <div class="row clearfix">
                 <?php if(!empty($list_banner)): ?>
                <div class="col-sm-9 col-xs-12 mg-bottom-10">
                  <section id="home-main-slider">
                    <div id="owl-home-main-slider" class="owl-carousel owl-theme">
                      <?php foreach($list_banner as $item): ?>
                      <div class="item">
                        <a href="<?php echo $item->link_url; ?>"><?php echo getThumbnailStatic($item->thumbnail,$item->title); ?></a>
                      </div>
                     <?php endforeach; ?>
                    </div>
                  </section>
                </div>
              <?php endif; ?>
                <div class="col-sm-3 col-xs-12">
                  <?php if(!empty($list_bannerright)) foreach($list_bannerright as $item): ?>
                  <div class="banner-slider mg-bottom-10 wow fadeInRight">
                    <a href="<?php echo $item->link_url; ?>">
                    <?php echo getThumbnailStatic($item->thumbnail,$item->title); ?>
                    </a>
                  </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- end main-slider -->
        <!-- PageContainer -->
        <div id="PageContainer" class="is-moved-by-drawer">
          <main class="main-content" role="main">
            <div id="home-policy">
              <div class="wrapper">
                <div class="inner">
                  <div class="row clearfix">
                    <div class="col-xs-4 col-480-12 wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
                      <div class="hservice-item">
                        <div class="hservice-img">
                          <img src="<?php echo $this->templates_assets.'images/hservice_icon19d71.png'; ?>" alt="PDUCOMPUTER Miễn phí vận chuyển" />
                        </div>
                        <div class="hservice-item-content">
                          <div class="hservice-title">
                            <a href="<?php echo base_url(); ?>">Miễn phí vận chuyển</a>
                          </div>
                          <div class="hservice-desc">
                            Cho tất cả các sản phẩm
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-4 col-480-12 wow fadeInUp" data-wow-delay="0.4s" data-wow-duration="0.75s">
                      <div class="hservice-item">
                        <div class="hservice-img">
                          <img src="<?php echo $this->templates_assets.'images/hservice_icon29d71.png'; ?>" alt="PDUCOMPUTER Luôn giữ uy tín" />
                        </div>
                        <div class="hservice-item-content">
                          <div class="hservice-title">
                            <a href="<?php echo base_url(); ?>">Luôn giữ uy tín</a>
                          </div>
                          <div class="hservice-desc">
                            1 đổi 1 trong 7 ngày đầu
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-4 col-480-12 wow fadeInUp" data-wow-delay="0.6s" data-wow-duration="0.75s">
                      <div class="hservice-item">
                        <div class="hservice-img">
                          <img src="<?php echo $this->templates_assets.'images/hservice_icon39d71.png'; ?>" alt="PDUCOMPUTER Khuyến mãi 20%" />
                        </div>
                        <div class="hservice-item-content">
                          <div class="hservice-title">
                            <a href="<?php echo base_url(); ?>">Khuyến mãi 20%</a>
                          </div>
                          <div class="hservice-desc">
                            Cho khách hàng tới lần 2
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <section id="home-collection-tabs2">
              <div class="wrapper">
                <div class="inner">
                  <div class="section-title wow fadeInDown clearfix">
                    <h2>
                      Danh mục sản phẩm nổi bật
                    </h2>
                    <a href="<?php if(!empty($cate_featured)){echo get_url_category_product($cate_featured[0]);}?>">Xem tất cả <i class="fa fa-angle-double-right"></i></a>
                  </div>
                  <div class="row clearfix">
                    <div class="col-sm-3 hidden-xs custom-banner wow fadeInLeft">
                      <a href="<?php echo !empty($this->_settings_home->linkintro_img) ? $this->_settings_home->linkintro_img : ''; ?>" class="banner_1">
                        <div class="ov1"></div>
                        <div class="ov2"></div>
                        <div class="ov3"></div>
                        <div class="ov4"></div>
                        <img class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo !empty($this->_settings_home->intro_img) ? MEDIA_URL.$this->_settings_home->intro_img : ''; ?>" alt="<?php echo !empty($this->_settings_home->linkintro_img) ? $this->_settings_home->linkintro_img : ''; ?>" />
                      </a>
                    </div>
                    <div class="col-sm-9">
                      
                      <div class="hmp-tab-wrapper1">
                        
                        <div class="tab text-right clearfix">
                          <?php
                          $i=0;
                          if(!empty($cate_featured)) foreach($cate_featured as $item): 
                            $i++;
                          ?>
                          <button class="hmp-tablinks2 wow fadeInLeft" data-wow-delay="0.2s" data-wow-duration="0.75s" data-hrref="#<?php echo "hmptab2_".$i; ?>"><?php echo $item->title; ?></button>
                          <?php endforeach; ?>
                        </div>
                        <?php
                        $i=0;
                        if(isset($cate_featuredx)) foreach($cate_featuredx as $value): 
                        $i++;
                        ?>
                        <div id="<?php echo "hmptab2_".$i; ?>" class="hmp-tabcontent2">

                          <div class="row clearfix">
                            <?php if(!empty($value['product'])) foreach($value['product'] as $item): ?>
                            <div class="col-md-3 col-sm-4 col-xs-6 col-480-12 wow fadeInUp">
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

                                      <button type="button"  class="btnBuyNow cart-add-btnnow medium--hide small--hide" title="mua ngay" data-cart="false" data-id="<?php echo $item->id; ?>"><span>Mua ngay</span></button>

                                      <button type="button"  class="btnAddToCart medium--hide small--hide cart-add-btn" title="thêm vào giỏ" data-cart="false" data-id="<?php echo $item->id; ?>"><span><i class="fa fa-cart-plus" aria-hidden="true"></i></span></button>
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
                          <div class="viewmore"><a href="<?php echo get_url_category_product($value['cate']); ?>">Xem tất cả <i class="fa fa-angle-double-right"></i></a></div>
                        </div>
                        <?php endforeach; ?>
                        <!-- end -->
                      </div>
                    
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <!-- we about -->
            <section class="weabout wow fadeInUp" data-wow-delay="0.3" data-wow-duration="0.85s">
              <div class="wrapper">
                <section class="event_box">
                  <div class="container">
                    <div class="row_pc">
                      <h2 class="resources_title">về chúng tôi</h2>
                      <div class="row">
                        <div class="col-sm-6">
                          <div class="event_left"> 
                            <iframe class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo $this->_settings_home->videoyt1; ?>"></iframe> 
                          </div>
                        </div>
                        <div class="col-sm-6">
                          <div class="box_video">
                            <iframe class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo $this->_settings_home->videoyt2; ?>"></iframe> 
                              <iframe class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo $this->_settings_home->videoyt3; ?>"></iframe> 
                              <iframe class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo $this->_settings_home->videoyt4; ?>"></iframe> 
                              <iframe class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo $this->_settings_home->videoyt5; ?>"></iframe> 
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
              </div>
            </section>
            <!-- end we about -->
            <section id="home-collection-tabs">
              <div class="wrapper">
                
                <div class="inner">
                <?php
                if(!empty($category_product['category'])) foreach ($category_product['category'] as $key=> $value): 
                ?>
                  <div class="section-title wow fadeInDown clearfix">
                    <h2>
                      <?php echo $value->title; ?>
                    </h2>
                    <a href="<?php echo get_url_category_product_menu($value); ?>">Xem tất cả <i class="fa fa-angle-double-right"></i></a>
                  </div>
                  <div class="row clearfix">
                    <div class="col-xs-12">
                      <div class="hmp-tab-wrapper1">
                        <div class="tab text-right clearfix">
                          <?php
                          if(!empty($category_product['child_category'][$value->data_id])) foreach ($category_product['child_category'][$value->data_id] as $key1=> $item):
                          ?>
                          <button class="hmp-tablinks1 wow fadeInLeft" data-wow-delay="0.2s" data-wow-duration="0.75s" data-hrref="#<?php echo "pdutab".$key."_".$key1; ?>"><?php echo $item->title; ?></button>
                          <?php endforeach; ?>
                        </div>
                        <?php
                          if(!empty($category_product['child_category'][$value->data_id])) foreach ($category_product['child_category'][$value->data_id] as $key1=> $item):
                          ?>
                        <div id="<?php echo "pdutab".$key."_".$key1; ?>" class="hmp-tabcontent2">
                          <div class="row clearfix">
    <?php if(!empty($category_product['data_product'][$value->data_id])) foreach ($category_product['data_product'][$value->data_id][$key1] as $item1): ?>
                            <div class="col-md-3 col-sm-4 col-xs-6 col-480-12 wow fadeInUp">
                              <div class="product-item">
                                <div class="product-img">
                                  <a href="<?php echo get_url_product($item1); ?>">
                                  <?php echo getThumbnail($item1,230,240); ?>
                                  </a>
                                <?php if($item1->price_sale != 0): ?>
                                  <div class="tag-saleoff text-center">
                                    <?php echo "-".ceil((100-(($item1->price_sale/$item1->price)*100))) ."%"; ?>
                                  </div>
                                <?php endif; ?>
                                  <div class="product-actions text-center clearfix">
                                    <div>
                                      <button type="button" class="btnQuickView quick-view medium--hide small--hide" data-id="<?php echo $item1->id; ?>"><span><i class="fa fa-search-plus" aria-hidden="true"></i></span></button>

                                      <button type="button"  class="btnBuyNow cart-add-btnnow medium--hide small--hide" title="mua ngay" data-cart="false" data-id="<?php echo $item1->id; ?>"><span>Mua ngay</span></button>

                                      <button type="button"  class="btnAddToCart medium--hide small--hide cart-add-btn" title="thêm vào giỏ" data-cart="false" data-id="<?php echo $item1->id; ?>"><span><i class="fa fa-cart-plus" aria-hidden="true"></i></span></button>
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
                           <div class="viewmore"><a href="<?php echo get_url_category_product_menu($item); ?>">Xem tất cả <i class="fa fa-angle-double-right"></i></a></div>
                        </div>
                        <?php endforeach; ?>
                        <!-- end -->
                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>
                </div>
              
              </div>
            </section>
            <section id="home-banner-1">
              <div class="wrapper">
                <div class="inner">
                  <div class="custom-banner wow zoomIn">
                    <a href="<?php echo !empty($this->_settings_home->linkintro_img1) ? $this->_settings_home->linkintro_img1 : ''; ?>" class="banner_1">
                      <div class="ov1"></div>
                      <div class="ov2"></div>
                      <div class="ov3"></div>
                      <div class="ov4"></div>
                      <img class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo !empty($this->_settings_home->intro_img1) ? MEDIA_URL.$this->_settings_home->intro_img1 : ''; ?>" alt="<?php echo !empty($this->_settings_home->linkintro_img1) ? $this->_settings_home->linkintro_img1 : ''; ?>" />
                    </a>
                  </div>
                </div>
              </div>
            </section>
            <section id="home-featured-products">
              <div class="wrapper">
                <div class="inner">
                  <div class="section-title wow fadeInDown clearfix">
                    <h2>
                      Mặt hàng tiêu biểu
                    </h2>
                    <a href="<?php if(!empty($cate_featured)){echo get_url_category_product($cate_featured[0]);}?>">Xem tất cả <i class="fa fa-angle-double-right"></i></a>
                  </div>
                  <div class="box_feature">
                    <div id="owl-home-featured-products-slider" class="owl-carousel owl-theme">
                      <?php if(!empty($hot_product)) foreach($hot_product as $item): ?>
                      <div class="item wow fadeInUp">
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

                                  <button type="button"  class="btnBuyNow cart-add-btnnow medium--hide small--hide" title="mua ngay" data-cart="false" data-id="<?php echo $item->id; ?>"><span>Mua ngay</span></button>

                                  <button type="button"  class="btnAddToCart medium--hide small--hide cart-add-btn" title="thêm vào giỏ" data-cart="false" data-id="<?php echo $item->id; ?>"><span><i class="fa fa-cart-plus" aria-hidden="true"></i></span></button>
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
              </div>
            </section>

            <!-- begin review -->
            <section class="slider_box wow fadeInUp" data-wow-delay="0.3s" data-wow-duration="0.75s">
              <div class="container">
                <div class="row_pc">
                  <h2 class="resources_title">PHẢN HỒI CỦA KHÁCH HÀNG</h2>
                  <?php if(!empty($customer_review)): ?>
                  <div id="" class="slider_review owl-carousel owl-theme">
                    <?php foreach($customer_review as $item): ?>
                    <div class="item">
                      <div class="full_box_sld">
                        <div class="img_box_sld">
                          <?php echo getAvatar($item,350,350); ?>
                        </div>
                        <div class="star">
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                          <i class="fa fa-star" aria-hidden="true"></i>
                        </div>
                        <div class="text_content_sld">
                          <?php echo $item->reviewcontent; ?>
                        </div>
                        <div class="name_box">
                           <h3 class="name_content_box"><a href="<?php echo $item->link_url; ?>"><?php echo $item->fullname; ?></a></h3>
                            <p><?php echo $item->position; ?></p>
                        </div>
                      </div>
                    </div>
                    <?php endforeach; ?>
                  </div>
                <?php endif; ?>
                </div>
              </div>
            </section>
            <!-- end review -->
            <!-- Tin tức nổi bật -->
            <section id="home-articles">
              <div class="wrapper">
                <div class="inner">
                  <div class="section-title wow fadeInDown text-left">
                    <h2>
                      Tin tức nổi bật
                    </h2>
                    <a href="<?php if(!empty($post_featured)){echo get_url_category_post($post_featured[0]);}?>">Xem tất cả <i class="fa fa-angle-double-right"></i></a>
                  </div>
                  <div class="grid">
                    <div id="owl-home-articles-slider" class="owl-carousel owl-theme">
                      <?php if(!empty($post_featured1)) foreach($post_featured1 as $value): ?>
                      <div class="item wow fadeInUp" data-wow-delay="0.2s" data-wow-duration="0.75s">
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
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section id="home-brands">
              <div class="wrapper">
                <div class="inner">
                  <div class="box_brand">
                    <?php if(!empty($list_review)): ?>
                    <div id="owl-brands-slider" class="owl-carousel owl-theme">
                      <?php foreach($list_review as $item): ?>
                      <div class="item wow zoomIn" data-wow-delay="0.2s" data-wow-duration="0.75s">
                        <a href="<?php echo $item->link_url; ?>" class="text-center"><img class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo MEDIA_URL. $item->thumbnail; ?>" alt="<?php echo $item->title; ?>" /></a>
                      </div>
                      <?php endforeach; ?>
                    </div>
                  <?php endif; ?>
                  </div>
                </div>
              </div>
            </section>
          </main>
        </div>

        <script>

          jQuery(document).ready(function($) {
            var modal = document.getElementById('popup-subscribe');
            var spanx = document.getElementsByClassName("close-popup")[0];
            
            var btn = document.getElementById("popup-btn");
            btn.onclick = function() {
              modal.style.display = "block";
              setTimeout(function(){
                 $('#popup-modal').addClass('show');
              }, 500);
            };
            spanx.onclick = function() {
              hidePopupSub(modal);
            };
            
            window.onclick = function(event) {
              if (event.target == modal) {
                 hidePopupSub(modal);
              };
            };
            function hidePopupSub(modal){
              $('#popup-modal').removeClass('show');
              setTimeout(function(){
                 modal.style.display = "none";
              }, 500)
            }
            if (getCookie('popupNewLetterStatus') != 'closed') {
                   $('#popup-btn').click();
                   setCookie('popupNewLetterStatus', 'closed', 1);
              };
          });

</script>
<script language="javascript">
            
            $(document).ready(function()
            {
                function activeTab(obj)
                {
                    $(obj).siblings().removeClass('active');

                    $(obj).addClass('active');

                    var id = $(obj).attr('data-hrref');

                  $(obj).parent(".tab").siblings('.hmp-tabcontent2').hide();

                  if(obj.length){
                    var id1,i;
                      for(i=0; i<obj.length;i++){
                    
                      id1 = obj[i].getAttribute('data-hrref');

                      $(id1).show();
                    }
                  }
                  
                    $(id).show();
                }
               
                $('.tab button').click(function(){
                    activeTab(this);
                    return false;
                });
            
                activeTab($('.tab button:first-child'));
            });
        </script>
    