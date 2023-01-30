<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
    
    <table class="table" style="width:100%;overflow-x: auto;">
        <thead>
            <th>ảnh</th>
            <th>tên</th>
            <th>số lượng</th>
            <th>đơn giá (đ)</th>
            <th>thành tiền (đ)</th>
        </thead>
        <tbody>
            <?php
            $price_total = 0;
             if (!empty($data_product)){foreach ($data_product as $key => $value){ ?>
            <tr>
                <td>
                    <img src="<?php echo getImageThumb($value->thumbnail,100,100) ?>" alt="<?php echo $value->title ?>">
                </td>
                <td>
                    <a href="<?php echo get_url_product($value); ?> "><?php echo $value->title ?></a>
                </td>
                <td>
                    <?php echo $value->quantity_order; ?>
                </td>
                <td>
                    <?php 
                    if(!empty($value->price)){
                        $price = $value->price;
                        echo number_format($price,0,'','.');
                    }else{
                        echo "Liên hệ";
                    }
                    
                    ?>
                </td>
                <td>
                    <?php echo number_format($value->price_order,0,'','.'); ?>
                </td>
            </tr>

<?php }}; ?>
            <tr>
                <td colspan="4">Phí ship:</td>
                <td colspan="1">+<?php echo  number_format($data_info->priceship,0,'','.');?>   </td>
            </tr>
            <tr>
                <td colspan="4">Coupon:</td>
                <td colspan="1">-<?php echo  number_format($data_info->coupon,0,'','.');?></td>
            </tr>
            <tr>
                <td colspan="3">Tổng tiền:</td>
                <td colspan="2"><?php echo  $data_info->total_amount;?></td>
            </tr>
        </tbody>
    </table>
<style>
    tr,th,td{
        border:1px solid #efeaea;
    }
</style>
