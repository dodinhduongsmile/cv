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
    <section id="blog-wrapper">
      <div class="wrapper">
        <div class="inner">
          <div class="row clearfix flex-reverse">
            <div class="col-sm-3">
              <div class="blog-sidebar">
                <div class="list-categories">
                  <div class="category_children">
                    <button class="accordion cs-title col-sb-trigger">
                    <span>Danh mục cùng loại</span>
                    </button>
                    <div class="panel sidebar-sor">
                      <ul class="list-brand-check">
                        <?php if (!empty($list_category)) foreach ($list_category as $key => $value) : ?>
                        <li>
                          <h3> <a href="<?php echo get_url_category_post($value); ?>" title="<?php echo $value->title; ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i> <?php echo $value->title; ?></a></h3>
                        </li>
                        <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                  <?php $this->load->view($this->template_path . 'block/sidebar_category'); ?>
                </div>

                <div class="all-tags">
                  <div class="blog-sb-title clearfix">
                    <h3>
                      Từ khóa
                    </h3>
                  </div>
                  <div class="all-tags-wrapper clearfix">
                    <?php if(!empty($keysearch)) foreach($keysearch as $item): ?>
                    <a class="tag-item" href="<?php echo base_url("pa_ket-qua-tim-kiem.html?type={$item->type}&q=$item->slug"); ?>"><?php echo $item->title; ?></a>
                  <?php endforeach; ?>
                  </div>
                </div>
                <div class="blog-sb-banner">
                  <a href="<?php echo !empty($this->_settings_home->linkintro_img) ? $this->_settings_home->linkintro_img : ''; ?>" class="banner_1">
                        <div class="ov1"></div>
                        <div class="ov2"></div>
                        <div class="ov3"></div>
                        <div class="ov4"></div>
                        <img class="lazyloadpd" src="<?php echo $this->templates_assets.'dot.jpg'; ?>" data-src="<?php echo !empty($this->_settings_home->intro_img) ? MEDIA_URL.$this->_settings_home->intro_img : ''; ?>" alt="<?php echo !empty($this->_settings_home->linkintro_img) ? $this->_settings_home->linkintro_img : ''; ?>" />
                      </a>
                </div>
                
              </div>
            </div>
            <div class="col-sm-9">
              <div class="blog-content">
                <div class="blog-content-wrapper">
                  <div class="blog-head">
                    <div class="blog-title">
                      <h1><?php echo $oneItem->title; ?></h1>
                    </div>
                  </div>
                  <div class="blog-body">
                    <div class="row clearfix">
                      <?php if (!empty($list_post)) foreach ($list_post as $key => $value) : ?>
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
                    </div>
                    <div class="text-center"><?php echo !empty($pagination) ? $pagination : ''; ?></div>
                  </div>
                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>
    </section>
  </main>
</div>


<script>
  jQuery(document).ready(function() {
    let acc = document.getElementsByClassName("accordion");
    let i;
    for (i = 0; i < acc.length; i++) {
     acc[i].onclick = function() {
      this.classList.toggle("active");
      let panel = this.nextElementSibling;
      if (panel.style.maxHeight) {
       panel.style.maxHeight = null;
     } else {
       panel.style.maxHeight = panel.scrollHeight+15 + "px";
     }
   }
 }
 if ($(window).width() > 767) {
   $('.accordion.col-sb-trigger').trigger('click');
 }
});
</script>

<style>
  .category_children {
    margin-bottom: 10px;
  }
  button.accordion.cs-title.col-sb-trigger {
    display: block;
    text-align: center;
    text-transform: uppercase;
    padding: 10px 3px;
    border-bottom: 1px solid #f1f1f1;
    color: #ffffff;
    font-weight: 700;
    background: #55acee;
    width: 100%;
    position: relative;
  }

  button.accordion.cs-title.col-sb-trigger.active:after {
    content: "\2212";
  }
  button.accordion.cs-title.col-sb-trigger:after {content: '\002B';font-family: FontAwesome;color: #fff;position: absolute;top: calc(50% - 9px);right: 10px;line-height: normal;font-weight: bold;}

  .panel.sidebar-sor {
    max-height: 0px;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
    padding: 0 15px;
  }
.category_children ul.list-brand-check {
    padding: 0;
    margin: 0;
}
.blog-title h1:after {
    content: "";
    display: block;
    width: 100px;
    height: 1.5px;
    background: #4770c1;
    margin-top: 20px;
    transition: width .7s;
    text-align: center;
    margin: 0 auto;
}
.blog-title h1:hover:after {
    width: 140px;
}
</style>