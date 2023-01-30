<?php
get_header();
?>
<div id="main-content-wp" class="home-page clearfix">
    <div class="wp-inner">
        <div class="main-content fl-right">
            <div class="section" id="slider-wp">
                <div class="section-detail">
                    <?php
                        if(!empty($slide)){
                            foreach($slide as $item){
                    ?>
                    <div class="item">
                        <img src="<?php echo base_url("admin/{$item['slide_img']}"); ?>" alt="">
                    </div>
                    <?php
                        }
                     }
                    ?>
                </div>
            </div>
            <div class="section" id="support-wp">
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-1.png">
                            </div>
                            <h3 class="title">Miễn phí vận chuyển</h3>
                            <p class="desc">Tới tận tay khách hàng</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-2.png">
                            </div>
                            <h3 class="title">Tư vấn 24/7</h3>
                            <p class="desc">1900.9999</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-3.png">
                            </div>
                            <h3 class="title">Tiết kiệm hơn</h3>
                            <p class="desc">Với nhiều ưu đãi cực lớn</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-4.png">
                            </div>
                            <h3 class="title">Thanh toán nhanh</h3>
                            <p class="desc">Hỗ trợ nhiều hình thức</p>
                        </li>
                        <li>
                            <div class="thumb">
                                <img src="public/images/icon-5.png">
                            </div>
                            <h3 class="title">Đặt hàng online</h3>
                            <p class="desc">Thao tác đơn giản</p>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="section" id="feature-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm nổi bật</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                         <?php
                            if(!empty($list_product)){
                                foreach($list_product as $item){
                                $item['url_product'] = base_url("{$item['product_slug']}-{$item['id']}");
                                $item['url_addcart'] = base_url("?mod=cart&action=add&id={$item['id']}");
                                $item['url_checkout'] = base_url("?mod=cart&action=checkout&id={$item['id']}");
                            ?>
                        <li>
                            <a href="<?php echo $item['url_product']; ?>" title="" class="thumb">
                                <img src="<?php echo base_url("admin/{$item['product_thumb']}"); ?>">
                            </a>
                            <a href="<?php echo $item['url_product']; ?>" title="" class="product-name"><?php echo $item['product_title']; ?></a>
                            <div class="price">
                                <span class="new"><?php echo currency_format($item['price']); ?></span>
                                <span class="old"><?php echo currency_format($item['old_price']); ?></span>
                            </div>
                            <div class="action clearfix">
                                <a href="<?php echo $item['url_addcart']; ?>" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="<?php echo $item['url_checkout']; ?>" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <?php
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <!-- end -->
            <?php
            if(!empty($list_cat)){
                foreach($list_cat as $cat){
                    $cat_id = $cat['cat_id'];
            ?>


            <div class="section" id="list-product-wp">
                <div class="section-head">
                    <h3 class="section-title"><?php echo $cat['cat_title']; ?></h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <?php
                            $list_product = list_product_by_cat_parent($cat_id);
                            if(!empty($list_product)){
                                foreach($list_product as $item){
                                $item['url_product'] = base_url("{$item['product_slug']}-{$item['id']}");
                                $item['url_addcart'] = base_url("?mod=cart&action=add&id={$item['id']}");
                                $item['url_checkout'] = base_url("?mod=cart&action=checkout&id={$item['id']}");
                            ?>
                        <li>
                            <a href="<?php echo $item['url_product']; ?>" title="" class="thumb">
                                <img src="<?php echo base_url("admin/{$item['product_thumb']}"); ?>">
                            </a>
                            <a href="<?php echo $item['url_product']; ?>" title="" class="product-name"><?php echo $item['product_title']; ?></a>
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
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
                }
            }
            ?>
            
        </div>
        <div class="sidebar fl-left">
            <?php
                get_sidebar("product_cat");
            ?>
            <?php
get_sidebar("selling");
            ?>
            
        </div>
    </div>
</div>
<?php
get_footer();
?>