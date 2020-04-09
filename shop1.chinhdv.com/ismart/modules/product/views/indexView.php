<?php
get_header();

?>
<script src="<?php echo base_url("public/js/product.js"); ?>"></script>
<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="<?php echo base_url(); ?>" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title=""><?php echo $info_cat['cat_title']; ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left"><?php echo $info_cat['cat_title']; ?></h3>
                    <div class="filter-wp fl-right">
                        <p class="desc">Hiển thị 8 trên 50 sản phẩm</p>
                        <div class="form-filter">
                            <form method="POST" action="">
                                <!-- CHƯA LÀM CHỨC NĂNG => bắt buộc phải thao tác với sql chứ không dùng sort php đc -->
                                <select name="select_sort">
                                    <option value="0">Sắp xếp</option>
                                    <option value="az">Từ A-Z</option><!-- sắp xếp theo tên -->
                                    <option value="za">Từ Z-A</option>
                                    <option value="rsort">Giá cao xuống thấp</option><!-- order by `price` -->
                                    <option value="sort">Giá thấp lên cao</option>
                                </select>
                                <button type="submit">Lọc</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix" id="filter">
                        <?php
                            if(!empty($list_product)){
                                foreach($list_product as $item){
                                $item['url_product'] = base_url("{$item['product_slug']}-{$item['id']}");
                                $item['url_addcart'] = base_url("?mod=cart&action=add&id={$item['id']}");
                                $item['url_checkout'] = base_url("?mod=cart&action=checkout&id={$item['id']}");
                            ?>
                        <li>
                            <a href="<?php echo $item['url_product'] ?>" title="" class="thumb">
                                <img src="<?php echo base_url("admin/{$item['product_thumb']}"); ?>">
                            </a>
                            <a href="<?php echo $item['url_product'] ?>" title="" class="product-name"><?php echo $item['product_title']; ?></a>
                            <div class="price">
                                <span class="new"><?php echo currency_format($item['price']); ?></span>
                                <span class="old"><?php echo currency_format($item['old_price']); ?></span>
                            </div>
                            <div class="action clearfix">
                                <a href="<?php echo $item['url_addcart']; ?>" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="<?php echo $item['url_checkout']; ?>" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                       <?php
                       }}
                       ?>
                    </ul>
                </div>
            </div>
            <div class="section" id="paging-wp">
                <div class="section-detail">
                    <?php
                        echo $get_pagging;
                    ?>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <?php
                get_sidebar('product_cat');
            ?>
            <div class="section" id="filter-product-wp">
                <!-- LỌC NÀY XỬ LÝ BẰNG AJAX, CHƯA LÀM ĐC, TÌM HIỂU SAU, chọn yêu cầu, gửi lên server = ajax lọc ra các sản phẩm với điều kiện đó -->
                <div class="section-head">
                    <h3 class="section-title">Bộ lọc</h3>
                </div>
                <div class="section-detail">
                    <form id="form_filter" method="POST" action="#" data-url="<?php echo base_url("?mod=product&action=filter"); ?>">
                        <table>
                    <thead>
                        <tr>
                            <td colspan="2">Giá</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="radio" name="r-price" class="r-price" value="1"></td>
                            <td>Dưới 500.000đ</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-price" class="r-price" value="2"></td>
                            <td>500.000đ - 1.000.000đ</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-price" class="r-price" value="3"></td>
                            <td>1.000.000đ - 5.000.000đ</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-price" class="r-price" value="4"></td>
                            <td>5.000.000đ - 10.000.000đ</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-price" class="r-price" value="5"></td>
                            <td>10.000.000đ - 20.000.000đ</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="r-price" class="r-price" value="6"></td>
                            <td>Trên 20.000.000đ</td>
                        </tr>
                    </tbody>
                </table>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>