
<div class="quickview-carts">
  <h3>
    Giỏ hàng của tôi (<span class="hd-cart-count"><?php echo !empty($this->cart->total_items()) ? $this->cart->total_items() : "0"; ?></span> sản phẩm)
    <span class="btnCloseQVCart"><i class="fa fa-times" aria-hidden="true"></i></span>
  </h3>
  <?php 
  $data_cartpd = $this->cart->contents();
  if (!empty($data_cartpd)) : ?>
    <ul class="no-bullets">
      <?php foreach ($data_cartpd as $key => $value):?>

        <li class="cart-item">
          <a href="#" class="cart__remove remove_item" data-identifier="<?php echo $key; ?>" data-id="<?php echo $value['id']; ?>" style="font-weight: bold;"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
          <div class="row clearfix">
            <div class="col-xs-4">
              <div class="cart-item-img text-center">
                <a href="<?php echo BASE_URL.'pdu'.$value['id'].'_'.$value['slug'].'.html'; ?>">
                  <img src="<?php echo getImageThumb($value['thumbnail'],100,100); ?>" alt="<?php echo $value['name']; ?>">
                </a>
              </div>
            </div>
            <div class="col-xs-8">
              <div class="cart-item-info text-left">
                <a href="<?php echo BASE_URL.'pdu'.$value['id'].'_'.$value['slug'].'.html'; ?>"><?php echo $value['name']; ?></a> 

              </div>
              <div class="cart-item-price-quantity text-left">
                <span class="quantity quantity_head">Số lượng: <?php echo $value['qty']; ?></span>
                <span class="current-price">Giá/sp: <?php echo number_format($value['price'],0,'',',') ?> ₫</span>
              </div>
            </div>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>

    <div class="qv-cart-total">
      TỔNG: <span><?php echo !empty($this->cart->total()) ? number_format($this->cart->total(),0,'',',') : 0; ?>₫</span>
    </div>

    <div class="quickview-cartactions clearfix">
      <a href="<?php echo base_url('cart.html'); ?>">Xem giỏ hàng</a>
      <a href="<?php echo base_url("thanhtoan.html"); ?>">Thanh toán</a>
    </div>
    <?php else: ?>
      <!-- nếu chưa có sp -->
      <h3>
        Giỏ hàng trống
        <span class="btnCloseQVCart"><i class="fa fa-times" aria-hidden="true"></i></span>
      </h3>
      <ul class="no-bullets">
        <li>Bạn chưa có sản phẩm nào trong giỏ hàng!</li>
      </ul>
    <?php endif; ?>
  </div>
 