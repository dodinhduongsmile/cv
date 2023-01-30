<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<div id="sub-header" class="thankyou">
  <div class="container">
     <ul class="pdu-breadcrumb">
        <li>
           <a href="<?php echo base_url(); ?>"><span class="fa fa-home"></span>Trang chủ</a>
        </li>
        <span aria-hidden="true">/</span>
        <li>
           <a href="<?php echo base_url(); ?>">Tình trạng đơn hàng</a>
        </li>
     </ul>
     <div class="meta-header-inside">
           <h1>Tình trạng đơn hàng</h1>
     </div>
  </div>
</div>
<div class="order_detail">
    <div class="container">

        
        <div class="table-responsive">
            <table class="table">
              <tbody>
                <tr>
                  <th>Mã số đơn hàng:</th>
                  <td><?php echo $order_detail->code; ?></td>
                </tr>
                <tr>
                  <th>Tên khách hàng:</th>
                  <td><?php echo $order_detail->full_name; ?></td>
                </tr>
                <tr>
                  <th>Email khách hàng:</th>
                  <td><?php echo $order_detail->email; ?></td>
                </tr>
                <tr>
                  <th>Số điện thoại khách hàng:</th>
                  <td><?php echo $order_detail->phone; ?></td>
                </tr>
                <tr>
                  <th>Địa chỉ nhận hàng:</th>
                  <td><?php echo $order_detail->address; ?></td>
                </tr>
                <tr>
                  <th>Ghi chú khách hàng:</th>
                  <td><?php echo $order_detail->content; ?></td>
                </tr>
                <tr>
                  <th>Trạng thái đơn hàng:</th>
                  <td>
                      <?php 
                      $status = array(
                        0 => "hủy đơn hàng",
                        1 => "chờ xác nhận",
                        2 => "đang vận chuyển",
                        3 => "đã giao hàng",
                        4 => "hoàn trả",
                      );
                      echo $status[$order_detail->is_status];
                       ?>
                  </td>
                </tr>
                <tr>
                  <th>Trạng thái thanh toán:</th>
                  <td>
                      <?php 
                      $paystatus = array(
                        0 => "hủy đơn hàng",
                        1 => "chưa thanh toán",
                        2 => "đã thanh toán",
                        3 => "hoàn trả",
                      );
                      echo $paystatus[$order_detail->pay_status];
                       ?>
                  </td>
                </tr>
                <tr>
                    <th>hình thức thanh toán:</th>
                    <td>
                        
                        <?php if($order_detail->method == 1){
                            echo "COD giao hàng mới thanh toán";
                        }elseif($order_detail->method == 2){
                            echo "Chuyển khoản, quý khách vui lòng chuyển khoản theo thông tin sau:".$this->_settings_home->banknumber;
                            echo "<strong>Nội dung:</strong> Thanh toán đơn hàng: {$order_detail->code}";
                        }else{
                          echo "Thanh toán bằng điểm COIN. Số COIN này tạm thời bị khóa trên tài khoản của bạn, cho đến khi chúng tôi giao hàng thành công.";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                  <th>Ngày mua hàng:</th>
                  <td><?php echo convertDetailTime($order_detail->created_time); ?></td>
                </tr>
                
                <tr>
                  <th>Lịch sử đơn hàng:</th>
                  <td>
                      <ul>
                        <?php 
                        $note = json_decode($order_detail->note);
                        $i = 0;
                        if(!empty($note)) foreach($note as $item):
                        $i++;
                        ?>
                          <li><?php echo $i; ?>: <?php echo $item; ?></li>
                        <?php endforeach; ?>
                      </ul>
                  </td>
                </tr>
                <?php if(!empty($order_detail->shipping)): ?>
                <tr>
                  <th>Đơn vị Giao Hàng:</th>
                  <td>
                    <?php $this->config->load('menus');
                    if (!empty($this->config->item('shipping'))){
                        $shipping = $this->config->item('shipping');
                    } ?>
                    <?php echo $shipping[$order_detail->shipping]; ?>: <a href="">kiểm tra lịch sử vận chuyển</a>
                  </td>
                </tr>
            <?php endif; ?>
              </tbody>
            </table>
            <h3>CHI TIẾT ĐƠN HÀNG</h3>
            <table class="table table-striped table-my-order">
                        <thead>
                            <tr>
                                <th>Ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th style="width: 15%;" class="text-center">Số lượng</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">Thành tiền</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($product)) foreach ($product as $key => $value) : ?>
                        <tr>
                            <td>
                                 <img src="<?php echo getImageThumb($value->thumbnail,120,120); ?>" style="max-width: 120px" class="img-thumb-small-table" alt="<?php echo $value->title ?>">
                             </td>
                             <td>
                                <a href="<?php echo get_url_product($value); ?>" title="<?php echo $value->title ?>" class="titleprd"><?php echo $value->title ?></a>

                                <?php if (!empty($value->guarantee)): ?>
                                    <div class="content" style="padding-top: 6px;"><strong>Bảo hành:</strong> <span style="text-transform: lowercase"><?php echo $value->guarantee ?></span></div>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $value->quantity_order; ?></td>
                            <?php echo show_price_cart($value,$value->quantity_order); ?>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="4" style="text-align: center!important;"><strong>Phí ship</strong></td>
                        <td class="text-right">
                           <?php echo !empty($order_detail) ? number_format($order_detail->priceship,0,'','.') : 0; ?><sup>₫</sup>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: center!important;"><strong>Vouchor giảm giá</strong></td>
                        <td class="text-right">
                           <?php echo !empty($order_detail) ? number_format($order_detail->coupon,0,'','.') : 0; ?><sup>₫</sup>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: center!important;"><strong>Tổng thanh toán</strong></td>
                        <td class="text-right">
                           <?php echo !empty($order_detail) ? number_format($order_detail->total_amount + $order_detail->priceship - $order_detail->coupon,0,'','.') : 0; ?><sup>₫</sup>
                        </td>
                    </tr>
                </tbody>
            </table>
            <h3>HÀNH ĐỘNG</h3>
            <div class="action_order" style="text-align: center;">
                <?php if($order_detail->is_status ==1): ?>
                <button class="btn btn-danger" id="cancel_order" data-method="<?php echo $order_detail->method; ?>" data-id="<?php echo $order_detail->id; ?>" data-status="0">Hủy đơn</button>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $('#cancel_order').click( function(event) {
        var _this = $(this);
        let id = $(this).data('id');
        let is_status = $(this).data('status');
        let pay_status = $(this).data('status');
        let method = $(this).data('method');
        let  content = prompt("Lí do hủy đơn của bạn?");
        if(content){
                $.ajax({
                    type: "POST",
                    url: base_url + "user/ajax_cancel_order",
                    data:{id,content,pay_status,is_status,method},
                    dataType: 'json',
                    success: function (response) {
                         Toastr[response.type](response.message);
                         _this.remove();
                      
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr);
                        console.log(thrownError);
                    }
                });
            }else{
                confirm("Bạn cần phải ghi lí do hủy đơn, mới hủy được ạ.");
                return false;
            }
        });
</script>   
<style>
    .order_detail {
    padding: 30px 0;
}
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
</style>
