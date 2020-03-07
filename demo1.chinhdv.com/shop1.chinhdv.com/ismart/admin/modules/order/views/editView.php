<?php
get_header();
?>

<div id="main-content-wp" class="add-cat-page">
    <div class="wrap clearfix">
        <?php get_sidebar(); ?>
        <div id="content" class="fl-right">
            <div class="section" id="title-page">
                <div class="clearfix">
                    <h3 id="index" class="fl-left">Chỉnh sửa đơn hàng</h3>
                </div>
            </div>
            <div class="section" id="detail-page">
                <div class="section-detail">
                   <?php form_success('ok'); ?>
                    <form method="POST" enctype="multipart/form-data" action="">
                        <label for="title">Mã đơn hàng</label>
        <input type="text" name="title" id="title" readonly="readonly" value="<?php echo $order['code']; ?>">


                        

                        <label for="price">Tổng giá sản phẩm</label>
                        <input type="number" name="price" id="price" value="<?php echo $order['total_price']; ?>">
                        
                        <label for="price">Số lượng sản phẩm</label>
                        <input type="number" name="count" id="price" value="<?php echo $order['count_product']; ?>">

                        <label for="desc">Nội dung đơn hàng</label>
                        <textarea name="content" id="desc" class="ckeditor"><?php echo $order['product']; ?></textarea>
                        
                        
                        <label>Trạng thái</label>
                        <select name="status">
                            <option value="4" <?php if($order['status'] == 4){echo "selected = 'selected'";}  ?>>đã thu tiền</option>
                            <option value="3" <?php if($order['status'] == 3){echo "selected = 'selected'";}  ?>>đã xác nhận</option>
                            <option value="2" <?php if($order['status'] == 2){echo "selected = 'selected'";}  ?>>chờ xác nhận</option>
                            <option value="1" <?php if($order['status'] == 1){echo "selected = 'selected'";}  ?>>Thùng rác</option>
                        </select>
                        <button type="submit" name="btn_submit" id="btn-submit">LƯU</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>