<?php
$list_product =  db_fetch_array("SELECT * FROM `tbl_product`  LIMIT 0, 8");

?>
<div class="section" id="selling-wp">
                <div class="section-head">
                    <h3 class="section-title">Sản phẩm bán chạy</h3>
                </div>
                <div class="section-detail">
                    <?php
                        if(!empty($list_product)){
                    ?>

                    <ul class="list-item">
                        <?php
                            foreach($list_product as $item){
                            $item['url_product'] = base_url("{$item['product_slug']}-{$item['id']}");
                            $item['url_checkout'] = base_url("?mod=cart&action=checkout&id={$item['id']}");
                        ?>
                            <li class="clearfix">
                            <a href="<?php echo $item['url_product']; ?>" title="" class="thumb fl-left">
                                <img src="<?php echo base_url('admin/'.$item['product_thumb']); ?>" alt="">
                            </a>
                            <div class="info fl-right">
                                <a href="<?php echo $item['url_product']; ?>" title="" class="product-name"><?php echo $item['product_title']; ?></a>
                                <div class="price">
                                    <span class="new"><?php echo currency_format($item['price']); ?></span>
                                    <span class="old"><?php echo currency_format($item['old_price']); ?></span>
                                </div>
                                <a href="<?php echo $item['url_checkout']; ?>" title="" class="buy-now">Mua ngay</a>
                            </div>
                        </li>
                        <?php
                            }
                        ?>
                        
                        
                    </ul>
                    <?php
                        }
                    ?>
                </div>
            </div>