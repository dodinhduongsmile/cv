
        <!-- Trigger/Open The Modal -->
        <button id="popup-btn">open</button>
        <!-- The Modal form hiện khi load xong -->
        <div id="popup-subscribe" class="popup">
          <!-- Modal content -->
          <div id="popup-modal" class="popup-content  animate down" style='background-image: url("<?php echo !empty($this->_settings_home->popup_img) ? MEDIA_URL.$this->_settings_home->popup_img : ''; ?> ");'>
            <span class="close-popup"><i class="fa fa-times" aria-hidden="true"></i></span>
            <div  class="row clearfix">
              <div class="col-sm-6 fl_right">
                <div class="popup-wrapper">
                  <div class="popup-title">
                    <?php echo !empty($this->_settings_home->intro_title) ? $this->_settings_home->intro_title : ''; ?>
                  </div>
                  
                  <div class="popup-desc">
                   <?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDU GROUP'; ?>  hứa sẽ không gửi những mail với nội dung không quan trọng hoặc spam. Các bạn là người đầu tiên biết được về:
                  </div>
                  <?php echo !empty($this->_settings_home->intro_content) ? $this->_settings_home->intro_content : ''; ?>
                  <div class="popup-form">
                    <div class="form-desc">
                      Đăng ký nhận tin khuyến mãi:
                    </div>
                    <form class='contact-form dkynhantin'>
                      <input name='type_img' type='hidden' value='2'>
                      <div class="input-group">
                        <input type="email" value="" placeholder="Nhập email của bạn..." name="email" id="Email" class="input-group-field"/>

                        <button type="button" class="subscribe" value="GỬI"><i class="fa fa-spinner fa-spin" style="display: none;"></i><i class="fa fa-telegram" aria-hidden="true"></i></button>
                        <div>
                          <a href="<?php echo $this->_settings_social->facebook; ?>" class="popup-social-network" target="_blank"><i class="fa fa-facebook-f"></i></a>
                          <a href="<?php echo $this->_settings_social->google; ?>" class="popup-social-network" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                          <a href="<?php echo $this->_settings_social->instalgram; ?>" class="popup-social-network" target="_blank"><i class="fa fa-instagram"></i></a>
                          <a href="<?php echo $this->_settings_social->twitter; ?>" class="popup-social-network" target="_blank"><i class="fa fa-twitter"></i></a>
                          <a href="<?php echo $this->_settings_social->youtube; ?>" class="popup-social-network" target="_blank"><i class="fa fa-youtube"></i></a>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
       
        <!-- menu mobie -->
        <div id="NavDrawer" class="drawer drawer--right">
          <div class="drawer__header">
            <div class="drawer__close js-drawer-close">
              <button type="button" class="icon-fallback-text">
              <i class="fa fa-times"></i>
              </button>
            </div>
          </div>
          <!-- begin mobile-nav -->
          <ul class="mobile-nav">
            <li class="mobile-nav__item mobile-nav__search">
              <form class="input-group search-bar searchform">
                <input type="hidden" name="type" value="product">
                <input type="search" id="main-search-form-input" name="q" value="" placeholder="Tìm sản phẩm..." class="input-group-field">
                <span class="input-group-btn">
                <button type="submit" class="btn icon-fallback-text searchsubmit">
                <i class="fa fa-search" aria-hidden="true"></i>
                </button>
                </span>
              </form>
            </li>
             <?php $c1 = getMenuParent(0,6); ?>
              <?php if (!empty($c1)) foreach ($c1 as $value): 
                $c2 = getMenuParent($value->id,6);
              ?>
            <!-- c1 -->
            <li class="mobile-nav__item" aria-haspopup="true">
              <?php if(!empty($c2)): ?>
              <div class="mobile-nav__has-sublist">
                <a href="<?php echo base_url().$value->link; ?>" class="mobile-nav__link" title="<?php echo $value->title; ?>"><?php echo $value->title; ?></a>
                <div class="mobile-nav__toggle">
                  <button type="button" class="icon-fallback-text mobile-nav__toggle-open">
                  <i class="fa fa-plus" aria-hidden="true"></i>
                  <span class="fallback-text">See More</span>
                  </button>
                  <button type="button" class="icon-fallback-text mobile-nav__toggle-close">
                  <i class="fa fa-minus" aria-hidden="true"></i>
                  <span class="fallback-text">"Đóng"</span>
                  </button>
                </div>
              </div>

              <ul class="mobile-nav__sublist">
                <!-- c2 -->
                <?php foreach($c2 as $value2): 
                  $c3 = getMenuParent($value2->id,6);
                ?>
                <li class="mobile-nav__item mobile-nav__item--active" aria-haspopup="true">
                  <?php if(!empty($c3)): ?>
                  <div class="mobile-nav__has-sublist">
                    <a href="<?php echo base_url().$value2->link; ?>" class="mobile-nav__link"><?php echo $value2->title; ?></a>
                    <div class="mobile-nav__toggle">
                      <button type="button" class="icon-fallback-text mobile-nav__toggle-open">
                      <i class="fa fa-plus" aria-hidden="true"></i>
                      <span class="fallback-text">See More</span>
                      </button>
                      <button type="button" class="icon-fallback-text mobile-nav__toggle-close">
                      <i class="fa fa-minus" aria-hidden="true"></i>
                      <span class="fallback-text">"Đóng"</span>
                      </button>
                    </div>
                  </div>
                  <ul class="mobile-nav__sublist">
                    <!-- c3 -->
                  <?php foreach($c3 as $value3): ?>
                    <li class="mobile-nav__item ">
                      <a href="<?php echo base_url().$value3->link; ?>" class="mobile-nav__link"><?php echo $value3->title; ?></a>
                    </li>
                    <?php endforeach; ?>
                  </ul>
                  
                  <?php else: ?>
                    <a href="<?php echo base_url().$value2->link; ?>" class="mobile-nav__link"><?php echo $value2->title; ?></a>
                  <?php endif; ?>
                </li>
                <?php endforeach; ?>
              </ul>
              <?php else: ?>
              <a href="<?php echo base_url().$value->link; ?>" class="mobile-nav__link" title="<?php echo $value->title; ?>"><?php echo $value->title; ?></a>
            <?php endif; ?>
            </li>
          <?php endforeach; ?>

          </ul>
          <!-- //mobile-nav -->
        </div>

        <header id="header">
          <div class="desktop-header medium--hide small--hide">
            <div class="desktop-header-top">
              <div class="wrapper">
                <div class="inner">
                  <div class="row clearfix">
                    <div class="col-sm-8">
                      <div class="hdt-left-contact wow fadeInLeft" data-wow-duration="0.75s" data-wow-delay="0.2s">
                        <strong>Tư vấn 24h :</strong><a href="tel:<?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?>"><?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?></a>
                        <p>
                          <strong>Địa chỉ :</strong><span><?php echo !empty($this->_settings->meta_address) ? $this->_settings->meta_address : ''; ?></span>
                        </p>
                      </div>
                    </div>
                    <div class="col-sm-4 text-right">
                      <div class="hd-account wow fadeInRight">
                        <a href="javascript:void()"><i class="fa fa-user" aria-hidden="true"></i> Tài khoản</a>
                        <div class="hd-account-content">
                          <ul class="no-bullets">
                            <?php if(empty($this->session->userdata('user_id'))): ?>
                            <li>
                              <a href="<?php echo base_url("user/login"); ?>">Đăng nhập</a>
                            </li>
                            <li>
                              <a href="<?php echo base_url("user/register"); ?>">Đăng ký</a>
                            </li>
                            <?php else: ?>
                            <li>
                              <a href="<?php echo base_url("user/index"); ?>">Hello,<?php echo !empty($this->session->userdata('fullname')) ? $this->session->userdata('fullname') : 'User'; ?> </a>
                            </li>
                            <li>
                              <a href="<?php echo base_url("user/logout"); ?>">Đăng xuất</a>
                            </li>
                            <?php endif ?>
                          </ul>
                        </div>
                      </div>
                      <div class="desktop-cart-wrapper wow fadeInRight">
                        <a href="<?php echo base_url('cart.html'); ?>" class="hd-cart">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>Giỏ hàng(<span class="hd-cart-count"><?php echo !empty($this->cart->total_items()) ? $this->cart->total_items() : "0"; ?></span>)
                        </a>
                        <div class="cart_ajaxpdu quickview-cart">
                      <?php $this->load->view($this->template_path."cart/cart_ajax"); ?>
                      </div>
                      </div>
                      <!-- end -->
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="desktop-header-center">
              <div class="wrapper">
                <div class="inner">
                  <div class="row clearfix">
                    <div class="col-sm-3">
                      <div class="hd-logo wow fadeInUp">
                        <?php if($this->_controller == "home"): ?>
                        <h1>
                          <a href="<?php echo base_url(); ?>">
                          <?php echo !empty($this->_settings->title) ? $this->_settings->title : ''; ?><img src="<?php echo !empty($this->_settings->logo) ? MEDIA_URL.$this->_settings->logo : ''; ?>" alt="<?php echo !empty($this->_settings->title) ? $this->_settings->title : ''; ?>" />
                          </a>
                        </h1>
                        <?php else: ?>
                          <h2>
                          <a href="<?php echo base_url(); ?>">
                          <?php echo !empty($this->_settings->title) ? $this->_settings->title : ''; ?><img src="<?php echo !empty($this->_settings->logo) ? MEDIA_URL.$this->_settings->logo : ''; ?>" alt="<?php echo !empty($this->_settings->title) ? $this->_settings->title : ''; ?>" />
                          </a>
                        </h2>
                      <?php endif; ?>
                      </div>
                    </div>
                    <!-- search desktop -->
                    <div class="col-sm-6">
                      <div class="hdt-right-search wow zoomIn">
                        <div class="search-form-wrapper">
                          <form id="searchauto" class="searchform-categoris ultimate-search searchform">
                            <div class="wpo-search">
                              <div class="wpo-search-inner">
                                <select class="select-collection" name="type">
                                  <option value="product">sản phẩm</option>
                                  <option value="post">bài viết</option>
                                  <option value="edu">Khóa học</option>
                                </select>
                                <div class="input-group">
                                  <input id="searchtext" name="q" id="s" maxlength="40" class="form-control input-search" type="text" size="20" placeholder="Tìm kiếm sản phẩm...">
                                  <span class="input-group-btn">
                                  <button type="submit" id="searchsubmit" class="searchsubmit"><i class="fa fa-search"></i></button>
                                  </span>
                                </div>
                              </div>
                            </div>
                          </form>
                          <!-- gõ search sẽ js trả về sp -->
                          <div class="smart-search-wrapper search-wrapper">
                            <i class="fa fa-spinner fa-spin" style="display: none;"></i>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="home-hotline">
                        <div class="hotline-bg wow fadeInRight">
                          <p class="hd-hotline-phone">
                            <strong>Hottline: </strong><a href="tel:<?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?>"><?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?></a>
                          </p>
                          <p class="hd-hotline-email">
                            <strong>Email: </strong><a href="mailto:<?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?>"><i class="fa fa-envelope"></i> <?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?></a>
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="desktop-header-main-menu">
              <div class="wrapper">
                <div class="inner">
                  <div class="text-left">
                    <div class="desktop-header-navbar">
                      <ul class="no-bullets">
              <?php $c1 = getMenuParent(0,5); ?>
              <?php if (!empty($c1)) foreach ($c1 as $value): 
                $c2 = getMenuParent($value->id,5);
              ?>
              <!-- c1 -->
                        <li class="wow fadeInRight dropdown" data-wow-delay="0.3s" data-wow-duration="0.7s">
                          <a href="<?php echo base_url().$value->link; ?>" title="<?php echo $value->title; ?>"><?php echo $value->title; ?>
                          <?php if(!empty($c2)){echo "<i class='fa fa-angle-down' aria-hidden='true'></i>";} ?>
                          </a>
              <!-- c2 -->
              <?php if(!empty($c2)): ?>
                          <ul class="no-bullets">
              <?php foreach($c2 as $value2): 
                $c3 = getMenuParent($value2->id,5);
              ?>
                            <li class="has-child">
                              <i class="fa fa-caret-right"></i> 
                              <a href="<?php echo base_url().$value2->link; ?>" title="<?php echo $value2->title; ?>"><?php echo $value2->title; ?> 
                              <?php if(!empty($c3)){echo "<i class='fa fa-angle-right'></i>";} ?>
                              </a>
                              <?php if(!empty($c3)): ?>
                                <!-- c3 -->
                              <ul class="no-bullets">
                                <?php foreach($c3 as $value3): ?>
                                <li>
                                  <i class="fa fa-circle"></i>
                                  <a href="<?php echo base_url().$value3->link; ?>" title="<?php echo $value3->title; ?>"><?php echo $value3->title; ?></a>
                                </li>
                                <?php endforeach; ?>
                              </ul>
                            <?php endif; ?>
                            </li>
              <?php endforeach; ?>
                          </ul>
                        <?php endif; ?>
                        </li>
<?php endforeach; ?>

                        
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- header menu mobie -->


          <div class="mobile-header large--hide">
            <div class="wrapper">
              <div class="inner">
                <div class="row clearfix">
                  <div class="col-xs-4">
                    <div class="hd-logo text-left">
                      <a href="<?php echo base_url(); ?>">
                      <img src="<?php echo !empty($this->_settings->logo) ? MEDIA_URL.$this->_settings->logo : ''; ?>" alt="<?php echo !empty($this->_settings->title) ? $this->_settings->title : ''; ?>" />
                      </a>
                    </div>
                  </div>
                  <div class="col-xs-8 text-right">
                    <div class="desktop-cart-wrapper1">
                      <a href="javascript:void(0)" class="hd-cart">
                      <i class="fa fa-shopping-basket" aria-hidden="true"></i><span class="hd-cart-count"><?php echo !empty($this->cart->total_items()) ? $this->cart->total_items() : "0"; ?></span>
                      </a>
                      <div class="cart_ajaxpdu quickview-cart">
                      <?php $this->load->view($this->template_path."cart/cart_ajax"); ?>
                      </div>
                    </div>
                    <div class="hd-btnMenu">
                      <a href="javascript:void(0)" class="icon-fallback-text site-nav__link js-drawer-open-right" aria-controls="NavDrawer" aria-expanded="false">
                      <i class="fa fa-bars"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </header>