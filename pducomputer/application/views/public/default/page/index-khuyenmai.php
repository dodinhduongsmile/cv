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
                  <?php $this->load->view($this->template_path . 'block/sidebar_category'); ?>
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
                    <div class="list_order">
                    <?php if(!empty($list_codesale)){
                      $pay_method =[
                        1 => "Thanh toán khi nhận hàng",
                        2 => "Thanh toán banking",
                        3 => "Thanh toán bằng điểm Coin"
                      ];
                        foreach($list_codesale as $v){
                    ?>
                    <div class="notification_page">
                        <div class="notifi_img">
                            <a href="<?php echo get_url_codesale($v); ?>" title="<?php echo $v->title; ?>"><img src="<?php echo getImageThumb($v->thumbnail,120,120); ?>" alt="<?php echo $v->title; ?>"></a>
                        </div>
                        <div class="notifi_content">
                            <h4><a href="<?php echo get_url_codesale($v); ?>"><?php echo $v->title; ?></a></h4>
                            <p>💐 <?php echo $v->title; ?> 🎁 Giảm <strong><?php echo $v->type == 1 ? number_format($v->percent,0,'','.').' vnđ' : $v->percent.' %'; ?></strong> áp dụng đơn hàng từ <?php echo number_format($v->price_condition,0,'','.').' vnđ'; ?> ❤️ Mã voucher: <b><?php echo $v->code; ?></b></p>
                            <p><strong>Áp dụng từ:</strong> <?php echo date("H:i d/m/Y", time()); ?> - Đến ngày <?php echo date("H:i d/m/Y", (time()+864000)); ?></p>
                            <p><strong>Điều kiện sử dụng:</strong> Đơn hàng từ <?php echo number_format($v->price_condition,0,'','.').' vnđ'; if($v->pay_method >= 2){echo " và ".$pay_method[$v->pay_method];} ?>
                            </p>
                            <div class="bts">
                                <a href="<?php echo get_url_codesale($v); ?>" class="btn_viewNow">Xem ngay!</a>

                                <button class="btn btn_copy" onclick="copy_code(this)" >Copy mã: <input type="text" class="valuecopy" value="<?php echo $v->code; ?>" readonly></button>
                            </div>
                        </div>
                    </div>
                    <?php }}; ?>
                    </div>
                    <div class="text-center" style="padding: 0px 15px">
                      <button class="btn <?php if(count($list_codesale) < @$limit){echo 'hide';} ?>" id="btn_loadmore" data-offset="<?php echo $limit; ?>">Load More</button>
                    </div>

                  
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
    /*Load more*/
$("body").on('click','#btn_loadmore',function (event) {
    event.preventDefault();
  let _this = $(this);
  let offset = _this.attr('data-offset');
  var url_load_comment = "<?php echo base_url('ajax/comment'); ?>";
  $.ajax({
        type: "POST",
        url: base_url+"page/sale_voucher",
        data: {offset},
        dataType: 'json',
        beforeSend: function() {
          _this.append('<i class="fa fa-spinner fa-spin ml-2" style="font-size:24px;color: #ffffff;"></i>');
        },
        success: function (response) {
            _this.find('.fa-spin').remove();
            $(".list_order").append(response.html);
            if(response.html != ""){
              _this.attr('data-offset',Number(response.limit) + Number(offset));
            }else{
              _this.hide();
            }

        }
    });
});

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
<style>
.notification_page {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  border-bottom: 1px solid #eee;
  padding-bottom: 15px;
  margin-bottom: 15px;
}
.notification_page .notifi_img {
  -webkit-box-flex: 0;
      -ms-flex: 0 0 100px;
          flex: 0 0 100px;
  margin-right: 15px;
}
.notification_page .notifi_img img {
  height: 100px;
  -o-object-fit: contain;
     object-fit: contain;
  width: 100%;
}
@media (max-width: 480px) {
  .notification_page .notifi_img {
    -webkit-box-flex: 0;
        -ms-flex: 0 0 70px;
            flex: 0 0 70px;
  }
  .notification_page .notifi_img img {
    height: 70px;
  }
}
.notification_page .notifi_content {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  width: 100%;
}
.notification_page .notifi_content h4 {
  font-size: 18px;
  overflow: hidden;
  -o-text-overflow: ellipsis;
     text-overflow: ellipsis;
  -webkit-line-clamp: 1;
  display: -webkit-box;
  -webkit-box-orient: vertical;
}
@media (max-width: 480px) {
  .notification_page .notifi_content h4 {
    font-size: 16px;
  }
}

.notification_page .notifi_content p {
  font-size: 15px;
}
.notification_page .notifi_content .bts {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: baseline;
      -ms-flex-align: baseline;
          align-items: baseline;
  -webkit-box-pack: justify;
      -ms-flex-pack: justify;
          justify-content: space-between;
}
.notification_page .notifi_content .bts .btn_viewNow {
  margin-top: 5px;
  padding: 3px 15px;
  border: 1px solid #eee;
  width: 100px;
}
.notification_page .notifi_content .bts .btn_viewNow:hover {
  border-color: #55acee;
}
</style>