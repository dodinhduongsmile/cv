<?php get_header()?>
<style type="text/css">
    #content_order_success {
    font-family: 'Roboto Regular';
    font-size: 14px;
    line-height: normal;
    color: #272727;
    line-height: 24px;
    width: 1080px;
    margin: 20px auto;
    border: 1px solid #d2c67a;
    border-radius: 3px;
    padding: 50px;
}
#title_order {
    text-transform: uppercase;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 15px;
    position: relative;
}

#title_order:before {
    font-family: 'FontAwesome';
    content: '\f00c';
    position: absolute;
    left: -31px;
    color: #1eb51e;
    font-size: 25px;
}
.detail_order {
    display: inline-block;
    background: red;
    color: #fff;
    padding: 10px;
    border-radius: 3px;
    margin: 13px 0px;
    cursor: pointer;
}
.go_home {
    display: inline-block;
    background: #17adf1;
    color: #fff;
    padding: 10px;
    border-radius: 3px;
    margin: 13px 0px 20px 13px;
    cursor: pointer;
}
</style>
<div id="wp_order_success">
    <div id="content_order_success">
        <h2 id="title_order">Đặt hàng thành công</h2>
        <p>Chào <strong><?php if (!empty($order)) echo $order['fullname'];?></strong>!</p>
        <p>Quý khách vừa đặt thành công sản phẩm của ISMART, mã đơn hàng của quý khách là: <strong><?php if (!empty($order)) echo $order['code'];?></strong></p>
        <p>Sau khi shop xác nhận có hàng, sản phẩm sẽ được giao hàng đến địa chỉ của quý khách tại địa chỉ: <strong><?php if (!empty($order)) echo $order['address'];?></strong> trong 3 - 4 ngày.</p>
        <p>Mọi thông tin về đơn hàng sẽ được gửi tới email của quý khách, vui lòng kiểm tra email để biết thêm chi tiết.</p>
        <p>Vào email của quý khách để xem chi tiết đơn hàng:</p>
        <a href="https://mail.google.com/mail" class="detail_order" target='_blank'>Chi tiết đơn hàng</a>
        <a href="<?php echo base_url(); ?> " class="go_home">Mua sắm tiếp</a>
        <p>Cảm ơn quý khách đã tin tưởng và giao dịch tại ISMART STORE!</p>
    </div>
</div>
<?php get_footer();?>