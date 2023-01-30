<section id="breadcrumb-wrapper" class="breadcrumb-w-img">
   <div class="breadcrumb-overlay"></div>
   <div class="breadcrumb-content">
      <div class="wrapper">
         <div class="inner text-center">
            <div class="breadcrumb-big">
               <h2>
                  Thanh toán
               </h2>
            </div>
            <div class="breadcrumb-small">
               <a href="<?php echo base_url(); ?>" title="Quay trở về trang chủ">Trang chủ</a>
               <span aria-hidden="true">/</span>
               <span>Thanh toán</span>
            </div>
         </div>
      </div>
   </div>
</section>
<div id="PageContainer" class="is-moved-by-drawer checkoutpdu">
   <div class="container">
      <div class="row_pc">
         <button class="order-summary-toggle order-summary-toggle-hide">
            <div class="wrap">
               <div class="order-summary-toggle-inner">
                  <div class="order-summary-toggle-icon-wrapper">
                     <svg width="20" height="19" class="order-summary-toggle-icon">
                        <path d="M17.178 13.088H5.453c-.454 0-.91-.364-.91-.818L3.727 1.818H0V0h4.544c.455 0 .91.364.91.818l.09 1.272h13.45c.274 0 .547.09.73.364.18.182.27.454.18.727l-1.817 9.18c-.09.455-.455.728-.91.728zM6.27 11.27h10.09l1.454-7.362H5.634l.637 7.362zm.092 7.715c1.004 0 1.818-.813 1.818-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817zm9.18 0c1.004 0 1.817-.813 1.817-1.817s-.814-1.818-1.818-1.818-1.818.814-1.818 1.818.814 1.817 1.818 1.817z"></path>
                     </svg>
                  </div>
                  <div class="order-summary-toggle-text order-summary-toggle-text-show">
                     <span>Hiển thị thông tin đơn hàng</span>
                     <svg width="11" height="6"  class="order-summary-toggle-dropdown" fill="#000">
                        <path d="M.504 1.813l4.358 3.845.496.438.496-.438 4.642-4.096L9.504.438 4.862 4.534h.992L1.496.69.504 1.812z"></path>
                     </svg>
                  </div>
                  <div class="order-summary-toggle-text order-summary-toggle-text-hide">
                     <span>Ẩn thông tin đơn hàng</span>
                     <svg width="11" height="7"  class="order-summary-toggle-dropdown" fill="#000">
                        <path d="M6.138.876L5.642.438l-.496.438L.504 4.972l.992 1.124L6.138 2l-.496.436 3.862 3.408.992-1.122L6.138.876z"></path>
                     </svg>
                  </div>
                  <div class="order-summary-toggle-total-recap">
                     <span class="total-recap-final-price"><?php echo !empty($this->cart->total()) ? number_format($this->cart->total(),0,'',',') : 0; ?>₫</span>
                  </div>
               </div>
            </div>
         </button>
         <script>
            jQuery(document).ready(function($) {
               $(".order-summary-toggle").click(function(event) {
                  /* Act on the event */
                  $(this).toggleClass('order-summary-toggle-hide');
                  $(this).toggleClass('order-summary-toggle-show');
                  $(".box-checkout").toggle();
               });
            });
         </script>
         <div class="checkoutpdu">
               <div class="box-checkout">
                  <h3>Đơn hàng</h3>
                  <table class="shop_table checkout-table">
                     <thead>
                        <tr>
                           <th class="product-name">Sản phẩm</th>
                           <th class="product-total">Tổng cộng</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php if (!empty($data_cart)) : ?>
                        <?php foreach ($data_cart as $key => $value): ?>
                        <tr class="cart_item">
                           <td class="product-name"><?php echo $value["name"]; ?>
                              <strong class="product-quantity">× <?php echo $value["qty"]; ?></strong>
                           </td>
                           <td class="product-total">
                              <span class="amount"><?php echo number_format($value["price"]*$value["qty"],0,'',',') ?><span class="currencySymbol"> VND</span></span>
                           </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: 
                           redirect(base_url('cart.html'));
                           ?>
                        <?php endif; ?>
                     </tbody>
                     <tfoot>
                        <tr>
                          <th>Phí ship</th>
                          <td> <?php echo number_format($price_shipping); ?> vnđ</td>
                        </tr>
                        <tr>
                          <th>Mã Coupon</th>
                          <td class="code_coupon"><?php if(!empty($pducoupon)){echo number_format($pducoupon['percent']);} ?> vnđ</td>
                        </tr>
                        <tr class="order-total">
                           <th>Tổng cộng</th>
                           <td>
                              <strong>
                              <span class="amount"><span id="total_amount"><?php echo !empty($total_cart) ? number_format(($total_cart),0,'',',') : 0; ?></span><span class="currencySymbol"> VND</span></span>
                              </strong>
                           </td>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </div>
            <form id="cart_form" method="post" name="cart_form">
        <h3 class="checkout_info">Chi tiết thanh toán</h3>

         <div class="row flex-reverse">
            <div class="col-sm-7 col-xs-12">
               
                  <div class="formpdu">
                     <h5>Thông tin khách hàng*</h5>
                     <div class="formpdu-checkout">
                        <div class="row">
                           <p class="form-row col-sm-12"> 
                              <label for="fullname"> Họ và tên<span style="color: red;">(*)</span></label> 
                              <input type="text" class="input-text" name="full_name" id="fullname" placeholder="Họ và tên" autofocus="autofocus" value="<?php echo @$user->fullname; ?>"> 
                           </p>
                           <p class="form-row col-sm-6"> 
                              <label for="mobile"> Số điện thoại <span style="color: red;">(*)</span> </label> 
                              <input type="text" class="input-text" name="phone" id="mobile" placeholder="Số điện thoại" value="<?php echo @$user->phone; ?>"> 
                           </p>
                           <p class="form-row col-sm-6"> 
                              <label for="email"> Email <span style="color: red;">(*)</span> </label> 
                              <input type="email" class="input-text" name="email" id="email" placeholder="Email" value="<?php echo @$user->email; ?>"> 
                           </p>
                           <p class="form-row col-sm-12">
                              <label for="address"> Địa chỉ nhận hàng <span style="color: red;">(*)</span> </label> 
                              <input type="text" class="input-text" name="address" id="address" placeholder="Địa chỉ" value="<?php echo @$user->shipping_address; ?>"> 
                           </p>
                           <p class="form-row col-sm-12"> 
                              <label for="customer_note"> Lưu ý khi giao hàng </label> 
                              <textarea name="content" class="input-text" id="customer_note" cols="40" rows="5" placeholder="Lưu ý khi giao hàng"></textarea> 
                           </p>
                           <p class="form-row col-sm-12"> 
                              <button type="button" class="button alt btn-place-order save_order" id="place_order">Đặt hàng<span class="icon_load" style="display: none;"><i class="fa fa-spinner fa-spin"></i></span>
                              </button> 
                           </p>
                        </div>
                     </div>
                  </div>
               
            </div>
            <div class="col-sm-5 col-xs-12">
               <div class="all-payment">
                <h5>Phương thức thanh toán*</h5>
                  <div class="all-paymet-border">
                     <div class="payment-method">
                      
                        <div class="pay-top sin-payment">
                           <input id="payment_method_1" name="method" class="input-radio" type="radio" value="1"  <?php if(!empty($pducoupon)){if($pducoupon['pay_method'] == 1){echo "checked='checked'";}}else{echo "checked='checked'";} ?>>
                           <label for="payment_method_1">Thanh toán khi nhận hàng - COD </label>
                           <div class="payment_box payment_method_bacs" style="display: block;">
                              <p>Bạn nhận hàng, kiểm tra và thanh toán</p>
                           </div>
                        </div>
                        <div class="pay-top sin-payment">
                           <input id="payment_method_2" name="method" class="input-radio" type="radio" value="2" <?php if(!empty($pducoupon)){if($pducoupon['pay_method'] == 2){echo "checked='checked'";}} ?>>
                           <label for="payment_method_2">Chuyển khoản</label>
                           <div class="payment_box payment_method_bacs">
                              <p>Quý khách vui lòng chuyển khoản vào số tài khoản sau:</p>
                              <p>( Nội dung chuyển tiền: HỌ TÊN + SỐ ĐIỆN THOẠI )</p>

                                <?php echo $this->_settings_home->banknumber; ?>
                             
                           </div>
                        </div>
                        <?php if(!empty($this->session->userdata('user_id'))){ ?>
                        <div class="pay-top sin-payment">
                           <input id="payment_method_2" name="method" class="input-radio" type="radio" value="3" <?php if(!empty($pducoupon)){if($pducoupon['pay_method'] == 3){echo "checked='checked'";}} ?>>
                           <label for="payment_method_2">Thanh toán bằng điểm Coin</label>
                           <div class="payment_box payment_method_bacs">
                              <p>Giá 1 Coin = <strong><?php echo number_format($this->_settings_email->coin_price,0,'','.'); ?> vnđ</strong></p>
                              <p>Số Coin bạn đang có là <b><?php echo $this->session->userdata('coin_total'); ?> COIN</b> tương đương <b><?php echo number_format(($this->session->userdata('coin_total')*$this->_settings_email->coin_price),0,'','.'); ?> vnđ</b>. Bạn có thể kiểm tra <a href="<?php echo base_url('user/index'); ?>">tại đây</a> </p>
                             
                           </div>
                        </div>
                        <?php }; ?>
                     </div>
                  </div>
                  <div class="checkcoupon">
                      <div class="input-group">
                        <input type="text" placeholder="Nhập mã giảm giá" name="code" class="input-group-field" value=" <?php if(!empty($pducoupon)){echo $pducoupon['code'];} ?>">
                        <span class="input-group-btn">
                        <button type="button"  class="btn pdu-checkcoupon"><i class="fa fa-spinner fa-spin" style="display: none;"></i><span>Áp Dụng</span></button>
                        </span>
                      </div>
                      <div id="notificationcp"></div>
                  </div>
<script>
  $(".pdu-checkcoupon").click(function(event) {
    /* Act on the event */
    let parent = $(this).parents(".checkcoupon");
    let code = parent.find("input[name='code']").val();
    let pay_method = $("input[name='method']:checked").val();
    $.ajax({
        type: "POST",
        url: base_url + "cart/checkCoupon",
        data:{code,pay_method},
        dataType: 'json',
        beforeSend: function() {
          parent.find(".fa-spinner").show();
        },
        success: function (response) {
            if(response.check == false){
              $("#notificationcp").html(response.mess);
            }else{
              $("#notificationcp").html("Đơn hàng của bạn được giảm <strong>"+formatMoney(response.coupon_price,0)+" vnđ</strong>");
              $(".code_coupon").html(formatMoney(response.coupon_price,0)+ " vnđ");
              $("#total_amount").text(formatMoney(response.total_cart,0));
            }
            
            parent.find(".fa-spinner").hide();
          
        }
    });
  });
</script>
<style>
.checkcoupon {
    margin: 30px 0;
    width: 80%;
}
#notificationcp{color: red;font-style: italic;}
.checkcoupon input {
    color: #15ca10;
    font-weight: 700;
    font-size: 1.3em;
    padding: 10px 0;
    -webkit-box-shadow: 0 0 6px 0 rgb(0 0 0 / 52%);
    box-shadow: 0 0 6px 0 rgb(0 0 0 / 52%);
}
.checkcoupon input:focus {
    font-weight: bold;
    outline: none;
    font-size: 1.4em;
}
                  </style>
               </div>
            </div>
           
         </div>
         </form>
      </div>
   </div>
</div>
<script>
  jQuery(document).ready(function($) {
   var checked = $('.sin-payment input:checked');
    if (checked) {
        $(checked).siblings('.payment_box').slideDown(900);
    };
    $('.sin-payment input').on('change', function () {
        $('.payment_box').slideUp(900);
        $(this).siblings('.payment_box').slideToggle(900);
    });

  });
</script>
<style>
  .all-paymet-border{
    background: #f1f1f1;
    border-radius: 5px;
    padding: 15px;
}

.payment_box {
    background-color: #fff;
    border-radius: 2px;
    box-sizing: border-box;
    color: #515151;
    font-size: 0.92em;
    line-height: 1.5;
    margin: 1em 0;
    padding: 1em;
    position: relative;
    width: 100%;
    display: none;
}
  .all-payment .payment_box::before {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    border-color: transparent transparent #fff;
    border-image: none;
    border-style: solid;
    border-width: 1em;
    content: "";
    display: block;
    left: 0;
    margin: -1em 0 0 2em;
    position: absolute;
    top: -0.75em;
}
h3.checkout_info {
    text-align: center;
    font-size: 2.5em;
    font-weight: 700;
    text-transform: capitalize;
}
</style>