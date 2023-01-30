<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<?php $this->_settings = getSetting('data_seo'); ?>
<div class="order-info-right" id="printable">
    <div class="order_part1 flex">
        <div class="left"><img style="width:56%;" src="<?php echo !empty($this->_settings->logo) ? MEDIA_URL.$this->_settings->logo : ''; ?>" alt=""></div>
        <div class="right">
            <p>Mã vận đơn: <?php echo $data_info->code; ?></p>
            <p>Đơn vị vận chuyển: 
                <?php $this->config->load('menus');
                if (!empty($this->config->item('shipping'))){
                    $shipping = $this->config->item('shipping');
                    echo @$shipping[$data_info->shipping];
                } ?>
            </p>
            <p>Mã đơn hàng: <?php echo $data_info->code; ?></p>
        </div>
    </div>
    <hr>
    <div class="order_part2 flex">
        <div class="left">
            <p><strong>Từ:</strong></p>
            <p><?php echo !empty($this->_settings->title_short) ? $this->_settings->title_short : $this->_settings->title; ?></p>
            <p>Địa chỉ: <?php echo !empty($this->_settings->meta_address) ? $this->_settings->meta_address : ""; ?></p>

            <p><strong>SĐT:</strong><?php echo !empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : "0397.152.197"; ?> - <?php echo !empty($this->_settings->meta_hotline_hn) ? $this->_settings->meta_hotline_hn : "0397.152.197"; ?></p>
        </div>
        <div class="right">
            <p><strong>Đến:</strong></p>
            <p><?php echo $data_info->full_name; ?></p>
            <p><?php echo $data_info->address; ?></p>
            <p><strong>SĐT:</strong><?php echo !empty($data_info->phone)? $data_info->phone:''; ?> - <?php echo $data_info->another_phone; ?></p>
        </div>
    </div>
    <hr>
    <div class="order_part3">
        <h3>Nội dung hàng (Tổng SL sản phẩm <?php echo !empty($count_product) ? $count_product : '0'; ?>)</h3>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số Lượng</th>
                        <th>Giá</th>
                        <th>Thành tiền</th>

                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data_product)) foreach ($data_product as $key => $value) : ?>
                    <tr>
                        <td><a href="<?php echo get_url_product($value); ?>"><?php echo $value->title ?></a></td>
                        <td><?php echo $value->quantity_order; ?></td>
                        <td><?php 
                        if(!empty($value->price)){
                            $price = $value->price;
                            echo number_format($price,0,'','.')." vnđ";
                        }else{
                            echo "Liên hệ";
                        }
                        
                        ?>
                        </td>

                    <td> <?php echo number_format($value->price_order,0,'','.'); ?> vnđ</td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="3">Phí ship:</td>
                <td colspan="1">+<?php echo  number_format($data_info->priceship,0,'','.');?>   </td>
            </tr>
            <tr>
                <td colspan="3">Coupon:</td>
                <td colspan="1">-<?php echo  number_format($data_info->coupon,0,'','.');?></td>
            </tr>
            <tr>
                <td colspan="3">Tổng tiền cần thanh toán: </td>
                <td><strong><?php echo  $data_info->total_amount;?> vnđ</strong></td>
            </tr>
        </tbody>
    </table>
</div>
</div>
<!-- <button type="button" onclick="In_Content('printable')" class="btn btn-primary btn-print">print1</button> -->

<style>.flex {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

.flex .left {
    flex: 40%;
}

.flex .right {
    flex: 60%;
}
.table {
    width: 100%;
    max-width: 100%;
    margin-bottom: 1rem;
    background-color: transparent;
}
.table-responsive>.table-bordered {
    border: 0;
}
.table-bordered thead td, .table-bordered thead th {
    border-bottom-width: 2px;
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 2px solid #dee2e6;
}
.table-bordered td, .table-bordered th {
    border: 1px solid #dee2e6;
}
.table td, .table th {
    padding: .75rem;
    vertical-align: top;
    border-top: 1px solid #dee2e6;
}
</style>
<script>
    /* in don hang*/
    function In_Content(strid) {
        // document.getElementsByClassName("btn-print")[0].remove();
        
        var prtContent = document.getElementById(strid);
        var WinPrint =
        window.open('', '', 'left=0,top=0,width=1300px,height=800px,toolbar=0,scrollbars=1,status=0');
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        //WinPrint.close();
        return true;  
        // document.write(document.getElementById('printable').innerHTML);  
    }
</script>
</div>