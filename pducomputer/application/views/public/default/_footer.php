        <footer id="footer">
          <div class="footer-top-subscribe">
            <div class="wrapper">
              <div class="inner">
                <div class="row clearfix">
                  <div class="col-sm-6 footer-social wow zoomIn">
                    <a target="_blank" href="<?php echo $this->_settings_social->facebook; ?>" class="social-icon"><i class="fa fa-facebook-f"></i></a>
                    <a target="_blank" href="<?php echo $this->_settings_social->twitter; ?>" class="social-icon"><i class="fa fa-twitter"></i></a>
                    <a target="_blank" href="<?php echo $this->_settings_social->google; ?>" class="social-icon"><i class="fa fa-google-plus"></i></a>
                    <a target="_blank" href="<?php echo $this->_settings_social->youtube; ?>" class="social-icon"><i class="fa fa-youtube"></i></a>
                    <a target="_blank" href="<?php echo $this->_settings_social->instalgram; ?>" class="social-icon"><i class="fa fa-instagram"></i></a>

                  </div>
                  <div class="col-sm-6 footer-newlester wow zoomIn">
                    <form class='contact-form dkynhantin'>
                      <div class="input-group">
                        <input type="email" placeholder="Nhập email của bạn" name="email" class="input-group-field">
                        <input name='type_img' type='hidden' value='2'>
                        <span class="input-group-btn">
                        <button type="button"  class="btn subscribe"><i class="fa fa-spinner fa-spin" style="display: none;"></i><span>Đăng ký</span></button>
                        </span>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="footer-content">
            <div class="wrapper">
              <div class="inner">
                <div class="row clearfix">
                  <div class="col-sm-4 col-xs-6 col-480-12 wow fadeInLeft">
                    <div class="ft-contact">
                      <h2>
                        <a href="/"><?php echo !empty($this->_settings->title) ? $this->_settings->title : ''; ?>
                        <img src="<?php echo !empty($this->_settings->logo) ? MEDIA_URL.$this->_settings->logo : ''; ?>" alt="<?php echo !empty($this->_settings->title) ? $this->_settings->title : 'pducomputer'; ?>" />
                        </a>
                      </h2>
                      <div class="ft-contact-desc">
                        <?php echo !empty($this->_settings->meta_desc) ? $this->_settings->meta_desc : ''; ?>
                      </div>
                      <div class="ft-contact-address">
                        <span class="ft-contact-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                        <div class="ft-contact-detail">
                          Địa chỉ: <?php echo !empty($this->_settings->meta_address) ? $this->_settings->meta_address : ''; ?>
                        </div>
                      </div>
                      <div class="ft-contact-tel">
                        <span class="ft-contact-icon"><i class="fa fa-phone"></i></span>
                        <div class="ft-contact-detail">
                          Số điện thoại: <a href="tel:<?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?>"><?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?></a>
                        </div>
                      </div>
                      <div class="ft-contact-email">
                        <span class="ft-contact-icon"><i class="fa fa-envelope"></i></span>
                        <div class="ft-contact-detail">
                          Email:  <a href="mailto:<?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?>"><?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?></a>
                        </div>
                      </div>
                      <div class="ft-contact-email">
                        <span class="ft-contact-icon"><i class="fa fa-globe"></i> </span>
                        <div class="ft-contact-detail">
                          Domain:  <a href="<?php echo base_url(); ?>"><?php echo !empty($this->_settings->domain) ? $this->_settings->domain : ''; ?></a>
                        </div>
                      </div>
                      <div class="ft-contact-email">
                        <span class="ft-contact-icon"><i class="fa fa-globe"></i> </span>
                        <div class="ft-contact-detail">
                          MST: <?php echo !empty($this->_settings->mst) ? $this->_settings->mst : ''; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-2 col-xs-6 wow fadeInUp">
                    <div class="ft-nav">
                      <h3 class="ft-title">
                        Thông tin
                      </h3>
                      <ul class="no-bullets">
                        <?php $tttg = getMenuParent(0,3); ?>
                        <?php if (!empty($tttg)) foreach ($tttg as $key => $value) : ?>
                        <li>
                          <a href="<?php echo base_url($value->link); ?>"><?php echo $value->title; ?></a>
                        </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                  <div class="col-sm-2 col-xs-6 wow fadeInUp">
                    <div class="ft-nav">
                      <h3 class="ft-title">
                        Chính sách
                      </h3>
                      <ul class="no-bullets">
                        <?php $tttg = getMenuParent(0,2); ?>
                        <?php if (!empty($tttg)) foreach ($tttg as $key => $value) : ?>
                        <li>
                          <a href="<?php echo base_url($value->link); ?>"><?php echo $value->title; ?></a>
                        </li>
                         <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                  <div class="col-sm-4 col-xs-6 col-480-12 wow fadeInRight">
                    <div class="ft-fb">
                      <div class="facebook">
                        <iframe class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="https://www.facebook.com/plugins/page.php?href=<?php echo $this->_settings_social->facebook; ?>%2F&tabs&width=340&height=250&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" width="340" height="250" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>
                      </div>
                      <!-- <div class="payment">
                        <a href="/"><img class="lazyloadpd" src="<?php //echo $this->templates_assets.'dot.jpg'; ?>"  data-src="<?php //echo $this->templates_assets.'images/pdu-bo-cong-thuong-1.png';?>" alt="pdu đã thông báo bộ công thương"/></a>
                          <a href="/"><img class="lazyloadpd" src="<?php //echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php //echo $this->templates_assets.'images/pdu-bo-cong-thuong-2.png';?>" alt="pdu đã đăng ký bộ công thương"/></a>
                      </div> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="footer-copyrights">
            <div class="wrapper">
              <div class="inner">
                <div class="ft-copyrights-content wow fadeInLeft text-center" data-wow-duration="0.75s" data-wow-delay="0.2s">
                  Copyrights © 2021 by <a target="_blank" href="<?php echo base_url(); ?>">PDUCOMPUTER</a>. <a target="_blank" href="<?php echo base_url(); ?>">Powered by Themepdu</a>
                </div>
              </div>
            </div>
          </div>
        </footer>
        <div id="fixed-social-network" class="medium--hide small--hide">
          <a target="_blank" href="<?php echo !empty($this->_settings_social->facebook) ? $this->_settings_social->facebook : ''; ?>" class="fb-icon"><i class="fa fa-facebook-f"></i> Facebook</a>
          <a target="_blank" href="<?php echo !empty($this->_settings_social->instalgram) ? $this->_settings_social->instalgram : ''; ?>" class="ins-icon"><i class="fa fa-instagram"></i> Instagram</a>
          <a target="_blank" href="<?php echo !empty($this->_settings_social->youtube) ? $this->_settings_social->youtube : ''; ?>" class="yt-icon"><i class="fa fa-youtube"></i> Youtube</a>
          <a target="_blank" href="<?php echo !empty($this->_settings_social->twitter) ? $this->_settings_social->twitter : ''; ?>" class="tw-icon"><i class="fa fa-twitter"></i> Twitter</a>
          <a target="_blank" href="<?php echo !empty($this->_settings_social->google) ? $this->_settings_social->google : ''; ?>" class="gg-icon"><i class="fa fa-google-plus"></i> Google+</a>
        </div>
        <section id="mobile-bottom-navigation" class="large--hide medium--hide">
          <div class="flex clearfix">
            <div class="flex-3">
              <div class="mobile-nav-item">
                <a href="<?php echo base_url(); ?>">
                <i class="fa fa-tag"></i><br />Hàng mới
                </a>
              </div>
            </div>
            <div class="flex-2">
              <div class="mobile-nav-item">
                <a href="<?php echo base_url(); ?>">
                <i class="fa fa-gift"></i><br />Khuyến mãi
                </a>
              </div>
            </div>
            
            <div class="flex-2">
              <div class="mobile-nav-item">
                <a href="<?php echo base_url()."lien-he.html"; ?>">
                <i class="fa fa-phone"></i><br />Liên hệ 
                </a>
              </div>
            </div>
            <div class="flex-2">
              <div class="mobile-nav-item">
                <a href="<?php echo base_url()."cart.html"; ?>">
                <i class="fa fa-shopping-bag"></i><br />Giỏ hàng
                <span class="number">
                <?php echo !empty($this->cart->total_items()) ? $this->cart->total_items() : "0"; ?>
                </span>
                </a>
              </div>
            </div>
            <div class="flex-3">
              <div class="mobile-nav-item">
                <a href="#">
                <i class="fa fa-user"></i><br />Tài khoản
                </a>
              </div>
            </div>
          </div>
        </section>

<div id="loadingpdu"><i class="fa fa-spinner fa-spin"></i></div>
<div class="modal" id="productQuickView"></div>
<!-- m_confim -->
<div id="m_confim" class="m_confim"></div>
<a href="javascript:void(0)" id="back-to-top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>