<?php
get_header();
?>

<div id="main-content-wp" class="clearfix category-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="<?php echo base_url(); ?>" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="" title="">search</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="list-product-wp">
                <div class="section-head clearfix">
                    <h3 class="section-title fl-left"><?php form_error('search'); ?>
                        <?php form_success('search'); ?></h3>
                    <div class="filter-wp fl-right">
                        <p class="desc">Hiển thị <?php echo count($result); ?> sản phẩm</p>
                    </div>
                </div>
                <div class="section-detail">
                    <ul class="list-item clearfix">
                        <?php
                            if(!empty($result)){
                                foreach($result as $item){
                            ?>
                        <li>
                            <a href="<?php echo base_url("{$item['product_slug']}-{$item['id']}"); ?>" title="" class="thumb">
                                <img src="<?php echo base_url("admin/{$item['product_thumb']}"); ?>">
                            </a>
                            <a href="<?php echo base_url("{$item['product_slug']}-{$item['id']}"); ?>" title="" class="product-name"><?php echo $item['product_title']; ?></a>
                            <div class="price">
                                <span class="new"><?php echo currency_format($item['price']); ?></span>
                                <span class="old"><?php echo currency_format($item['old_price']); ?></span>
                            </div>
                            <div class="action clearfix">
                                <a href="<?php echo base_url("?mod=cart&action=add&id={$item['id']}"); ?>" title="Thêm giỏ hàng" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="<?php echo base_url("?mod=cart&action=checkout&id={$item['id']}"); ?>" title="Mua ngay" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                       <?php
                       }}
                       ?>
                    </ul>
                </div>
            </div>

        </div>
        <div class="sidebar fl-left">
            <?php
                get_sidebar('product_cat');
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