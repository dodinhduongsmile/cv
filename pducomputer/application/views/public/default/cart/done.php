<div id="sub-header" class="thankyou">
  <div class="container">
         <ul class="pdu-breadcrumb">
            <li>
               <a href="<?php echo base_url(); ?>"><span class="fa fa-home"></span>Trang chủ</a>
            </li>
            <span aria-hidden="true">/</span>
            <li>
               <a href="<?php echo base_url("done.html"); ?>">cảm ơn</a>
            </li>
         </ul>
         <div class="meta-header-inside">
               <h1>Cảm Ơn</h1>
         </div>
  </div>
</div>
<div class="section">
    <div class="container">
        <div class="order_success">
            <!-- Product same -->
            <div class="order_success_thank">
                <div class="order_success_thank_a">
                    <p><strong><i class="fa-smile-pdu"></i>
                    Cảm ơn bạn đã mua hàng</strong></p>
                    <p>Mã đơn hàng của bạn là <b><?php echo $info_cart->code ?></b><a href="<?php echo base_url("cart/detail_order/").$info_cart->code;?>"> theo dõi đơn hàng</a></p>
                    <p>Bạn có thể quản lý và kiểm tra đơn hàng của bạn tại<a href="<?php echo base_url("cart/detail_order/").$info_cart->code;?>"> Tài khoản của tôi &gt; Đơn hàng của tôi</a></p>
                </div>
                <div class="order_success_thank_b">
                    <div class="order_success_thank_b1">
                        <?php if($info_cart->method == 2){
                            echo "<p>Vui lòng chuyển khoản Banking số tiền <b>". number_format($total_cart,0,'','.')." <sup>₫</sup></b> vào thông tin bên dưới: <br> Nội dung: Thanh toan don hang ".$info_cart->code." </p>";
                            echo $this->_settings_home->banknumber;
                        }elseif($info_cart->method == 3){
                        ?>
                        <p>Đơn hàng của bạn trị giá: <strong><?php echo !empty($total_cart) ? ($total_cart/$this->_settings_email->coin_price) : 0; ?> COIN</strong> <br> Số COIN này tạm thời bị khóa cho đến khi chúng tôi giao hàng thành công.
                        </p>
                        <?php }else{ ?>
                        <p>Vui lòng chuẩn bị số tiền tương ứng vào ngày giao hàng<strong><?php echo !empty($total_cart) ? number_format($total_cart,0,'','.') : 0; ?><sup>₫</sup></strong></p>
                        <?php
                        }?>

                        
                        
                        <p><i class="fa-envelope-pdu"></i>
                        Thông báo về việc đặt hàng của bạn đã được gửi tới email <b><?php echo $info_cart->email ?></b>
                        </p>
                        <p><i class="fa-car-pdu"></i>
                        Chúng tôi sẽ gọi cho bạn để xác nhận đơn hàng trong vòng 24h. <br> Nếu đây <strong><?php echo $info_cart->phone ?> <?php echo !empty($info_cart->another_phone) ? ' - '.$info_cart->another_phone : ''; ?></strong> <i>không phải</i> số điện thoại của bạn , thì bạn hãy <a href="<?php echo base_url('cart'); ?>" target="_self" class=" secondary back_cart">
                        <span>TẠO LẠI ĐƠN HÀNG</span></a> nhé.
                        </p>
                    </div>
                    <div class="order_success_thank_b2">
                        <p>Vui lòng kiểm tra kỹ đơn hàng và ngoại quan sản phẩm trước khi thanh toán. Cảm ơn!</p>
                        <p><span>Chi tiết đơn hàng</span><span><?php echo !empty($total_cart) ? number_format($total_cart,0,'','.') : 0; ?><sup>₫</sup></span></p>
                        <div class="table-responsive">
             <table class="table table-striped table-my-order">
                <thead>
                    <tr>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Tên sản phẩm</th>
                        <th scope="col" style="width: 15%;" class="text-center">Số lượng</th>
                        <th scope="col" class="text-center">Đơn giá</th>
                        <th scope="col" class="text-center">Thành tiền</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data_cart)) foreach ($data_cart as $key => $value) : 
                    // $data_product = getByIdProduct($value['id']);
                    $product_id = !empty(strstr($value['id'],"_")) ? str_replace(strstr($value['id'],"_"),"",$value['id']) : $value['id'];
                     $data_product = [
                      "id" => $product_id,
                      "title" => $value['name'],
                      "price" => $value['price'],
                      "thumbnail" => $value['thumbnail'],
                      "slug" => $value['slug'],
                      "guarantee" => $value['guarantee']
                     ];
                     $data_product = (object)$data_product;
                    ?>
                    <tr>
                        <td>
                         <img src="<?php echo getImageThumb($data_product->thumbnail,120,120); ?>" style="max-width: 120px" class="img-thumb-small-table" alt="<?php echo $data_product->title ?>">
                     </td>
                     <td>
                        <a href="<?php echo get_url_product($data_product); ?>" title="<?php echo $data_product->title ?>" class="titleprd"><?php echo $data_product->title ?></a>

                        <?php if (!empty($data_product->guarantee)): ?>
                            <div class="content" style="padding-top: 6px;"><strong>Bảo hành:</strong> <span style="text-transform: lowercase"><?php echo $data_product->guarantee ?></span></div>
                        <?php endif; ?>
                    </td>
                    <td><?php echo $value['qty']; ?></td>
                    <?php echo show_price_cart($data_product,$value['qty']); ?>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" style="text-align: center!important;"><strong>Phí ship: +</strong></td>
                <td class="text-right">
                    <?php echo number_format($info_cart->priceship,0,'','.'); ?><sup>₫</sup>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center!important;"><strong>giảm giá: -</strong></td>
                <td class="text-right">
                    <?php echo number_format($info_cart->coupon,0,'','.'); ?><sup>₫</sup>
                </td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center!important;"><strong>Tổng thanh toán</strong></td>
                <td class="text-right">
                    <?php echo !empty($total_cart) ? number_format($total_cart,0,'','.') : 0; ?><sup>₫</sup>
                </td>
            </tr>
        </tbody>
    </table>
</div>
                        <a href="<?php echo base_url(); ?>">tiếp tục mua sắm</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <style>
.meta-header-inside h1 {
    text-align: center;
    font-weight: bold;
    text-transform: uppercase;
}

.meta-header-inside:after {content: "";display: block;width: 100px;height: 1px;background: #4770c1;margin-top: 20px;transition: width .7s;text-align: center;margin: 0 auto;}

.meta-header-inside {
    position: relative;
}


.meta-header-inside:hover:after {
    width: 140px;
}

ul.pdu-breadcrumb {
    display: flex;
    list-style: none;
    align-items: center;
    padding: 15px 0;
    margin: 0;
    font-size: 18px;
}

ul.pdu-breadcrumb li {
    padding-right: 10px;
}
        .thank p {
    text-align: center;
}

.address_done {
    padding-top: 35px;
    font-weight: 600;
}
.thank p a {
    background-color: #ed1b24;
    color: #fff;
    padding: 12px 15px;
    font-weight: bold;
    display: inline-block;
    margin: 15px 0;
}
.back_cart {
    background-color: #1e97ce;
    padding: 5px;
    border-radius: 5px;
    color: #fff;
}
table tr, table th, table td {
    border: 1px solid #b7b0b0;
    padding: 5px;
    text-align: left;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: rgba(0,0,0,.05);
}
.table td, .table th {
    padding: 8px;
    line-height: 1.42857143;
    vertical-align: middle;
    border-top: 1px dotted #d7d7d7;
}
span.fa-check-pdu,.fa-smile-pdu,.fa-envelope-pdu,.fa-car-pdu {
    display: inline-block;
    font: normal normal normal 14px/1 FontAwesome;
    font-size: inherit;
    text-rendering: auto;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}
span.fa-check-pdu:before {
    content: "\f046";
}
.fa-smile-pdu:before {
    content: "\f118";
}
.fa-envelope-pdu:before {
    content: "\f003";
}
.fa-car-pdu:before {
    content: "\f1b9";
}
/*order success*/
div.section {
    background: #f3f3f3;
}
.order_success_thank {
    padding: 25px 0px;
    margin: 0 auto;
}
.order_success_thank_a,.order_success_thank_b {
    margin-bottom: 20px;
    background: #fff;
    padding: 15px;
}
.order_success_thank_a p,.order_success_thank_b p {
    font-size: 20px;
    line-height: 30px;
}
.order_success_thank_a p:first-child {
    font-size: 30px;
    text-align: center;
    text-transform: uppercase;
    color: #e38021;
    padding-bottom: 25px;
}
.order_success_thank_b1 p:first-child {
    text-align: center;
    font-size: 26px;
    padding-bottom: 20px;
}
.order_success_thank_b1 p:first-child strong {
    display: block;
    color: #f2af12;
    line-height:36px;
}
.order_success_thank_b1 p + p {
    border: 1px solid #666;
    padding: 15px;
}
.order_success_thank_b1 p + p > i {
    color: #00c9ff;
    font-size: 24px;
    padding-right: 10px;
}
.order_success_thank_b1 {
    padding-bottom: 20px;
    margin-bottom: 20px;
    border-bottom: 1px solid #a29e9e;
}
.order_success_thank_b2 >a {
    display: block;
    text-align: center;
    width: 25%;
    margin: 0 auto;
    padding: 10px 15px;
    color: #fff;
    font-size: 16px;
    background: #17adf1;
    text-transform: uppercase;
    text-decoration: none;
    border-radius: 4px;
    transition: all ease 0.6s;
}
.order_success_thank_b2 >a:hover{
    background: #1e93c7;
}
.order_success_thank_b2 p:nth-child(2) {
    background: #eae4e4;
    line-height: 36px;
    padding:5px 15px;
    margin: 15px auto 25px;
}
.order_success_thank_b2 p:nth-child(2) span + span {
    float: right;
    display: inline-block;
}
    </style>
