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
      <section id="page-wrapper">
         <div class="wrapper">
            <div class="inner">
               <div class="page-contact-shoplist">
                  
                  <h1><?php echo $oneItem->title; ?></h1>
                  <div class="content">
                    <?php if(!empty($oneItem->thumbnail)): ?>
                       <div id="owl-home-main-slider" class="owl-carousel owl-theme" style="width: 100%;">
                          <div class="item"><a href="#"><img src="<?php echo MEDIA_URL.$oneItem->thumbnail; ?>" alt="<?php echo $oneItem->title; ?>"></a></div>
                          <?php if(!empty($oneItem->banner)): ?>
                          <div class="item"><a href="#"><img src="<?php echo MEDIA_URL.$oneItem->banner; ?>" alt="<?php echo $oneItem->title; ?>"></a></div>
                           <?php endif; ?>
                          
                       </div>
                   <?php endif; ?>
                   <?php echo $oneItem->content; ?>
                  </div>
                  <div class="pcontact-shoplist-wrapper">
                     <div class="row row-flex">
                         <?php if (!empty($this->_data_store)) foreach ($this->_data_store as $value) : ?>
                        <div class="col-md-4 col-xs-6 col-480-12">
                           <div class="pcontact-shop-item">
                              <div class="pcontact-shop-img">
                                 <img src="<?php echo getImageThumb($value->thumbnail,380,285); ?> "  alt="<?php echo $value->title; ?>">
                              </div>
                              <div class="pcontact-shop-address">
                                 <a href="https://www.google.com/maps/" target="_blank"><i class="fa fa-map-marker-alt"></i> <?php echo $value->address; ?></a>
                              </div>
                              <div class="pcontact-shop-tel">
                                 <a href="tel:<?php echo $value->phone; ?>"><i class="fa fa-phone-volume"></i> <?php echo $value->phone; ?></a>
                              </div>
                              <div class="pcontact-shop-tel">
                                 <a href="mail:<?php echo $value->email; ?>"><i class="fa fa-envelope"></i> <?php echo $value->email; ?></a>
                              </div>
                           </div>
                        </div>
                     <?php endforeach; ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <?php $this->load->view($this->template_path . 'block/type_product'); ?>
   </main>
</div>
<style>
#page-wrapper h1 {
    color: #55acee;
    padding: 0px 0px 15px 0px;
    margin: 0px 0px 15px 0px;
    border-bottom: 1px solid #f1f1f1;
    text-align: center;
    text-transform: capitalize;
}
#page-wrapper h1:after {
    content: "";
    display: block;
    width: 130px;
    height: 1.5px;
    background: #4770c1;
    margin-top: 20px;
    transition: width .7s;
    text-align: center;
    margin: 0 auto;
}
#page-wrapper h1:hover:after {
    width: 160px;
}

</style>