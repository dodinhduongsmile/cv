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
</section>    <!-- begin content -->
<div id="PageContainer" class="is-moved-by-drawer">
   <main class="main-content" role="main">
      <section id="page-wrapper">
         <div class="wrapper">
            <div class="inner">
               <div class="grid">
                  <div class="grid__item">
                     <h1><?php echo $oneItem->title; ?></h1>
                     <div class="rte">
                      <?php if(!empty($oneItem->thumbnail)): ?>
                      <p><img src="<?php echo MEDIA_URL.$oneItem->thumbnail; ?>" alt="<?php echo $oneItem->title; ?>"></p>
                      <?php endif; ?>
                        <?php echo $oneItem->content; ?>
                        <?php if(!empty($oneItem->banner)): ?>
                      <p><img src="<?php echo MEDIA_URL.$oneItem->banner; ?>" alt="<?php echo $oneItem->title; ?>"></p>
                      <?php endif; ?>
                     </div>
                     <div class="end-pro">
                        <h3>Mọi vấn đề cần liên hệ, Quý đại lý xin liên hệ với chúng tôi</h3>
                        <h2><?php echo !empty($this->_settings->title) ? $this->_settings->title : 'Công ty PDUCOMPUTER'; ?></h2>
                        <p><strong>Địa chỉ:</strong> <?php echo !empty($this->_settings->meta_address) ? $this->_settings->meta_address : ''; ?></p>
                        <p><strong>Điện thoại :</strong>  <?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?>  - Hotline: <?php echo !empty($this->_settings->meta_hotline_hn) ? $this->_settings->meta_hotline_hn : ''; ?></p>
                        <p><strong>Email:</strong> <?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?></p>
                        <p><strong>Website:</strong> <?php echo !empty($this->_settings->domain) ? $this->_settings->domain : ''; ?></p>
                        <div><strong>Xin chân thành cảm ơn</strong></div>
                        <div>===o0o===</div>
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
    width: 100px;
    height: 1.5px;
    background: #4770c1;
    margin-top: 20px;
    transition: width .7s;
    text-align: center;
    margin: 0 auto;
}
#page-wrapper h1:hover:after {
    width: 140px;
}
  .rte {
    line-height: 26px;
    font-size: 1.5em;
}
</style>