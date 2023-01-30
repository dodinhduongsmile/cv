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
        <p><strong>Áp dụng từ:</strong> <?php echo date("H:i d/m/Y", strtotime($v->created_time)); ?> - Đến ngày <?php echo date("H:i d/m/Y", (strtotime($v->created_time)+864000)); ?></p>
        <p><strong>Điều kiện sử dụng:</strong> Đơn hàng từ <?php echo number_format($v->price_condition,0,'','.').' vnđ'; if($v->pay_method >= 2){echo " và ".$pay_method[$v->pay_method];} ?>
                            </p>
        <div class="bts">
            <a href="<?php echo get_url_codesale($v); ?>" class="btn_viewNow">Xem ngay!</a>
            <button class="btn btn_copy" onclick="copy_code(this)" >Copy mã: <input type="text" class="valuecopy" value="<?php echo $v->code; ?>" readonly></button>
        </div>
    </div>
</div>
<?php }}; ?>