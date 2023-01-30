<div class="table-responsive">
   <table class="table table-bordered table-hover">
      <thead>
         <tr class="active">
            <th class="th-title3">STT</th>
            <th class="th-title th-title4" width="30%">Mã đơn hàng</th>
            <th class="th-title th-title5" width="15%">Ngày</th>
            <th class="th-title th-title6" width="20%">Trạng thái</th>
            <th class="th-title text-center th-title2" width="10%">Chi tiết</th>
         </tr>
      </thead>
      <tbody class="list_order">
         <?php if(!empty($list_order)){
            $j = 0;
            $is_status = array(
               0 => array("hủy đơn",'danger'),
               1=> array("Chờ xác nhận",'primary'),
               2=> array("Đang giao",'primary'),
               3=> array("Đã giao",'success'),
               4=> array("Hoàn trả",'danger'),
            );
            foreach($list_order as $v){
            $j++;
         ?>
         <tr>
            <th class="th-title" width="5%">
               <?php echo $j; ?>                                    
            </th>
            <th class="th-title" width="30%">
               <div data-items="id_tr<?php echo $j; ?>" onclick="show_detail(this)">
                  <a style="cursor: pointer" title="Xem chi tiết <?php echo $v->id; ?>">
                  <i class="fa fa-caret-down" style="font-size: 11px"></i> <?php echo $v->code; ?></a>
               </div>
            </th>
            <th class="th-title" width="15%"><?php echo date("d/m/Y H:i", strtotime($v->created_time)); ?> </th>
            <th class="th-title" width="20%">
               <div class="" id="status_14">
                  <a class=" dropdown-toggle">
                  <span class="label label-<?php echo $is_status[$v->is_status][1] ?>"><?php echo $is_status[$v->is_status][0]; ?></span>
                  </a>
                  
               </div>
            </th>
            <th class="th-title text-center" width="10%">
               <div class="btn btn-blue btn-sm text-center">
                  <div class="button-green" data-items="id_tr<?php echo $j; ?>" onclick="show_detail(this)">
                     <a style="color: #fff"  title="Xem chi tiết">
                     <i class="icons icon-basket-2"></i>Chi tiết</a>
                  </div>
               </div>
            </th>
         </tr>
         <tr style="display: none" id="id_tr<?php echo $j; ?>">
            <td colspan="10">
               <div class="col-md-12">
                  <div style="font-size: 15px">Thông tin chi tiết</div>
                  <table class="table table-bordered">
                     <tbody>
                        <tr>
                           <th>Ảnh</th>
                           <th>Tên hàng</th>
                           <th>Số lượng</th>
                           <th>Đơn giá(đ)</th>
                           <th colspan="2">Thành tiền(đ)</th>
                        </tr>
                        <?php if(!empty($product_order)){foreach($product_order as $u){
                           if($u->order_id == $v->id){

                         ?>
                        <tr>
                           <td>
                              <img style="max-width: 100px; height: auto" src="<?php echo getImageThumb($u->thumbnail,120,120); ?>" alt="image pdu">
                           </td>
                           <td><?php echo $u->title; ?></td>
                           <td><?php echo $u->quantity; ?></td>
                           <td><?php echo formatMoney($u->price); ?></td>
                           <td colspan="2"><?php echo formatMoney($u->subtotal); ?></td>
                        </tr>
                     <?php }}}; ?>
                        <tr>
                           <td colspan="6" class="text-right" style="color: #000;">Tổng giá trị đơn hàng:
                              <b style="font-weight: bold"><?php echo formatMoney($v->total_amount); ?></b>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="6" class="text-right" style="color: #000;">Phí giao hàng:
                              <b style=" font-weight: bold"><?php echo !empty($v->priceship) ? number_format($v->priceship,0,'','.') : 0; ?><sup>vnđ</sup></b>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="6" class="text-right" style="color: #000;">Vouchor giảm giá:
                              <b style=" font-weight: bold"><?php echo !empty($v->coupon) ? number_format($v->coupon,0,'','.') : 0; ?><sup>vnđ</sup></b>
                           </td>
                        </tr>
                        <tr>
                           <td colspan="6" class="text-right">Phải thanh toán:
                              <b style="color: red; font-weight: bold"><?php echo !empty($v->total_amount) ? number_format($v->total_amount + $v->priceship - $v->coupon,0,'','.') : 'Liên hệ'; ?><sup>vnđ</sup></b>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </td>
         </tr>
      <?php }}; ?>
      </tbody>
   </table>
   <div class="text-center" style="padding: 0px 15px">
      <button class="btn <?php if(count($list_order) < @$limit){echo 'hide';} ?>" id="btn_loadmore" data-offset="1" data-url="">Load More</button>
   </div>
</div>
<script>
function show_detail(thiss) {
   let _this = $(thiss);
   let id_tr = _this.attr("data-items");
   $("#"+id_tr).toggle(100);
   _this.children('a').toggleClass('red');
   
}
</script>