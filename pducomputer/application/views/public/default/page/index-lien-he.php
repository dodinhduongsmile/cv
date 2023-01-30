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
      <div id="page-wrapper">
         <div class="wrapper">
            <div class="inner">
               <div class="grid clearfix">
                  <div class="grid__item">
                     <div class="page-contact-wrapper">
                        <div class="page-head">
                           <h1><?php echo $oneItem->title; ?></h1>
                        </div>
                        <div class="page-body">
                           <div class="page-body-inner">
                              <div class="row clearfix">
                                 <div class="col-sm-12">
                                    <h3 class="contact-title">Địa chỉ trụ sở chính </h3>
                                    <div class="contact-wrapper">
                                       
                                       <div class="contact-info">
                                          <?php echo !empty($this->_settings->meta_address) ? $this->_settings->meta_address : ''; ?>
                                       </div>
                                       <div class="contact-map">
                                          <?php echo $oneItem->content; ?>
                                       </div>
                                       <div class="contact-title">
                                          <h4>
                                             Số điện thoại:
                                          </h4>
                                       </div>
                                       <div class="contact-info">
                                          <a href="tel:<?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?>"><?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : ''; ?> - <?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline_hn : ''; ?></a>
                                       </div>
                                       <div class="contact-title">
                                          <h4>
                                             Email:
                                          </h4>
                                       </div>
                                       <div class="contact-info">
                                          <a href="mailto:<?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?>"><?php echo !empty($this->_settings->meta_email) ? $this->_settings->meta_email : ''; ?></a>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-sm-12">
                                    <h3 class="contact-title">Hệ thống showroom</h3>
                                          <div class="showroom clearfix">
                                            <?php if (!empty($this->_data_store)) foreach ($this->_data_store as $value) : ?>
                                             <div class="col-sm-4">
                                                <div class="showroom_item">
                                                   <h3 style="text-align: center;"><?php echo $value->title; ?></h3>
                                                   <div class="info">
                                                      <p>
                                                         <span class="icon icon-contact">
                                                         <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                         </span>
                                                         <?php echo $value->address; ?>
                                                       </p>
                                                   
                                                      <p>
                                                         <span class="icon icon-contact" >
                                                         <i class="fa fa-phone" aria-hidden="true"></i>
                                                         </span>
                                                         <?php echo $value->phone; ?>                                         
                                                      </p>
                                                   
                                                      <p>
                                                         <span class="icon icon-contact">
                                                         <i class="fa fa-envelope" aria-hidden="true"></i>
                                                         </span> i<?php echo $value->email; ?>
                                                      </p>
                                                   </div>
                                                </div>
                                             </div>
                                         <?php endforeach; ?>
                                          </div>
                                       </div>
                                 <div class="col-sm-12">
                                    <h3 class="contact-title">form liên hệ</h3>
                                    <div class="form-vertical clearfix">
                                       <form class='contact-form' id="formContactUs">
                                          <input name='type_img' type='hidden' value='1'>
                                          
                                          <label for="ContactFormName" class="hidden-label">Họ tên của bạn</label>
                                          <input type="text" id="ContactFormName" class="input-full" name="full_name" placeholder="Họ tên của bạn">

                                          <label for="ContactFormEmail" class="hidden-label">Địa chỉ email của bạn</label>
                                          <input type="email" id="ContactFormEmail" class="input-full" name="email" placeholder="Địa chỉ email của bạn">

                                          <label for="ContactFormPhone" class="hidden-label">Số điện thoại của bạn</label>
                                          <input type="tel" id="ContactFormPhone" class="input-full" name="phone" placeholder="Số điện thoại của bạn" pattern="[0-9\-]*">

                                          <label for="ContactFormAdress" class="hidden-label">Địa chỉ</label>
                                          <input type="email" id="ContactFormAdress" class="input-full" name="address" placeholder="Địa chỉ nơi bạn ở">

                                          <label for="ContactFormMessage" class="hidden-label">Nội dung</label>
                                          <textarea rows="10" id="ContactFormMessage" class="input-full" name="content" placeholder="Nội dung"></textarea>
                                          <input type="button" class="btn right sendContact" value="Gửi">
                                          
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
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
h3.contact-title {
    font-weight: 700;
    text-transform: uppercase;
    position: relative;
    padding: 5px 0;
}

h3.contact-title:before {
    background: #55acee;
    width: 100px;
    height: 3px;
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
}

.showroom .showroom_item:hover {
    box-shadow: 1px 1px 9px #22dabed4;
}
.showroom_item {
    border: 1px solid #e6e5e5f5;
    padding: 10px;
    min-height: 218px;
    transition: all ease 0.7s;
}

.showroom {
    padding: 20px 0;
}
.showroom_item span.icon {
    font-size: 18px;
    color: #55acef;
}
.showroom_item .info {
    font-size: 20px;
    line-height: 26px;
}

.showroom_item h3 {
    font-weight: 600;
    text-transform: capitalize;
}
</style>