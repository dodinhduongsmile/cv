<?php 
    get_header(); 
?>

<div id="main-content-wp" class="clearfix detail-product-page">
    <div class="wp-inner">
        <div class="secion" id="breadcrumb-wp">
            <div class="secion-detail">
                <ul class="list-item clearfix">
                    <li>
                        <a href="<?php echo base_url(); ?>" title="">Trang chủ</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url("product/{$info_cat['url']}-{$info_cat['cat_id']}"); ?>" title=""><?php echo $info_cat['cat_title']; ?></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-content fl-right">
            <div class="section" id="detail-product-wp">
                <div class="section-detail clearfix">
                    <!-- sẽ dùng js để lấy ảnh từ phần content get lên đây => CHƯA BIẾT LÀM -->
                    <div class="thumb-wp fl-left">
                        <a href="" title="" id="main-thumb">
                            <img id="zoom" src="<?php echo base_url("admin/{$item['product_thumb']}"); ?>"/>
                        </a>
                        <!-- <div id="list-thumb">
                            <a href="" data-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_ab1f47_350x350_maxb.jpg" data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_70aaf2_700x700_maxb.jpg">
                                <img id="zoom" src="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_02d57e_50x50_maxb.jpg" />
                            </a>
                            <a href="" data-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_ab1f47_350x350_maxb.jpg" data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_70aaf2_700x700_maxb.jpg">
                                <img id="zoom" src="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_02d57e_50x50_maxb.jpg" />
                            </a>
                            <a href="" data-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_ab1f47_350x350_maxb.jpg" data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_70aaf2_700x700_maxb.jpg">
                                <img id="zoom" src="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_02d57e_50x50_maxb.jpg" />
                            </a>
                            <a href="" data-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_ab1f47_350x350_maxb.jpg" data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_70aaf2_700x700_maxb.jpg">
                                <img id="zoom" src="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_02d57e_50x50_maxb.jpg" />
                            </a>
                            <a href="" data-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_ab1f47_350x350_maxb.jpg" data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_70aaf2_700x700_maxb.jpg">
                                <img id="zoom" src="https://media3.scdn.vn/img2/2017/10_30/sxlpFs_simg_02d57e_50x50_maxb.jpg" />
                            </a>
                            <a href="" data-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_ab1f47_350x350_maxb.jpg" data-zoom-image="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_70aaf2_700x700_maxb.jpg">
                                <img id="zoom" src="https://media3.scdn.vn/img2/2017/10_30/BlccRg_simg_02d57e_50x50_maxb.jpg" />
                            </a>
                        </div> -->
                    </div>
                    <div class="thumb-respon-wp fl-left">
                        <img src="<?php echo base_url("admin/{$item['product_thumb']}"); ?>" alt="">
                    </div>
                    <div class="info fl-right">
                        <h3 class="product-name"><?php echo $item['product_title']; ?></h3>
                        <div class="desc">
                            <?php echo html_entity_decode($item['product_des']); ?>
                        </div>
                        <div class="num-product">
                            <span class="title">Sản phẩm: </span>
                            <span class="status"><?php echo $item['product_status']; ?></span>
                        </div>
                        <p class="price"><?php echo currency_format($item['price']); ?></p>
                        <div id="num-order-wp">
                            <a title="" id="minus"><i class="fa fa-minus"></i></a>
                            <input type="text" name="num-order" value="1" id="num-order">
                            <a title="" id="plus"><i class="fa fa-plus"></i></a>
                        </div>
                        <a href="<?php echo base_url("?mod=cart&action=add&id={$item['id']}"); ?>" title="Thêm giỏ hàng" class="add-cart">Thêm giỏ hàng</a>
                    </div>
                </div>
            </div>
            <div class="section" id="post-product-wp">
                <div class="section-head">
                    <h3 class="section-title">Mô tả sản phẩm</h3>
                </div>
                <div class="section-detail">
                    <?php echo html_entity_decode($item['product_content']); ?>
                </div>
            </div>
            <div class="section" id="same-category-wp">
                <div class="section-head">
                    <h3 class="section-title">Cùng chuyên mục</h3>
                </div>
                <div class="section-detail">
                    <ul class="list-item">
                        <?php
                            if(!empty($list_product)){
                                foreach($list_product as $item){
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
                                <a href="<?php echo base_url("?mod=cart&action=add&id={$item['id']}"); ?>" title="" class="add-cart fl-left">Thêm giỏ hàng</a>
                                <a href="<?php echo base_url("?mod=cart&action=checkout&id={$item['id']}"); ?>" title="" class="buy-now fl-right">Mua ngay</a>
                            </div>
                        </li>
                        <?php
                                }
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="sidebar fl-left">
            <?php
                get_sidebar("product_cat");
                get_sidebar("selling");
            ?>
            
        </div>
    </div>
</div>
<?php 
    get_footer(); 
?>