<!DOCTYPE html>
<html>
    <head>
        <title>ISMART STORE</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo base_url();  ?>public/css/bootstrap/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url();  ?>public/css/bootstrap/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url();  ?>public/reset.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url();  ?>public/css/carousel/owl.carousel.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url();  ?>public/css/carousel/owl.theme.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url();  ?>public/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url();  ?>public/style.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url();  ?>public/responsive.css" rel="stylesheet" type="text/css"/>

        <script src="<?php echo base_url();  ?>public/js/jquery-2.2.4.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();  ?>public/js/elevatezoom-master/jquery.elevatezoom.js" type="text/javascript"></script>
        <script src="<?php echo base_url();  ?>public/js/bootstrap/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url();  ?>public/js/carousel/owl.carousel.js" type="text/javascript"></script>
        <script src="<?php echo base_url();  ?>public/js/main.js" type="text/javascript"></script>
        
    </head>
    <body>
        <div id="site">
            <div id="container">
                <div id="header-wp">
                    <div id="head-top" class="clearfix">
                        <div class="wp-inner">
                            <a href="" title="" id="payment-link" class="fl-left">Hình thức thanh toán</a>
                            <div id="main-menu-wp" class="fl-right">
                                <ul id="main-menu" class="clearfix">
                                    <li>
                                        <a href="<?php echo base_url(); ?>" title="">Trang chủ</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url(); ?>" title="">Sản phẩm</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url("post"); ?>" title="">Blog</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url("page/gioi-thieu-2"); ?>" title="">Giới thiệu</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url("page/lien-he-3"); ?>" title="">Liên hệ</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div id="head-body" class="clearfix">
                        <div class="wp-inner">
                            <a href="<?php echo base_url(); ?>" title="" id="logo" class="fl-left"><?php echo html_entity_decode(phone('logo')); ?>" </a>
                            <div id="search-wp" class="fl-left">
                                <form method="POST" action="<?php echo base_url("?mod=product&action=search"); ?>">
                                    <!-- CHƯA LÀM ĐC NÚT TÌM KIẾM -->
                                    <input type="text" name="search" id="s" placeholder="Nhập từ khóa tìm kiếm tại đây!">
                                    <button type="submit" id="sm-s" name="btn_search">Tìm kiếm</button>
                                </form>
                            </div>
                            <div id="action-wp" class="fl-right">
                                <div id="advisory-wp" class="fl-left">
                                    <span class="title">Tư vấn</span>
                                    <span class="phone"><?php echo html_entity_decode(phone('phone')); ?></span>
                                </div>
                                <div id="btn-respon" class="fl-right"><i class="fa fa-bars" aria-hidden="true"></i></div>
                                <a href="<?php echo base_url("?mod=cart&action=show"); ?>" title="giỏ hàng" id="cart-respon-wp" class="fl-right">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span id="num"><?php echo get_num_order_cart(); ?></span>
                                </a>
                                <div id="cart-wp" class="fl-right">
                                    <div id="btn-cart">
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        <span id="num"><?php echo get_num_order_cart(); ?></span>
                                    </div>
                                    <div id="dropdown">
                                        <p class="desc">Có <span><?php echo get_num_order_cart(); ?> sản phẩm</span> trong giỏ hàng</p>
                                        <?php
                                            $list_checkout = get_list_buy_cart();
                                            if(!empty($list_checkout)){
                                        ?>


                                        <ul class="list-cart">
                                            <?php
                                                foreach($list_checkout as $item){
                                            ?>
                                                <li class="clearfix">
                                                <a href="<?php echo base_url("{$item['url']}-{$item['id']}"); ?>" title="" class="thumb fl-left">
                                                    <img src="<?php echo base_url("admin/{$item['product_thumb']}"); ?>" alt="">
                                                </a>
                                                <div class="info fl-right">
                                                    <a href="<?php echo base_url("{$item['url']}-{$item['id']}"); ?>" title="" class="product-name"><?php echo $item['product_title']; ?></a>
                                                    <p class="price"><?php echo currency_format($item['price']); ?></p>
                                                    <p class="qty qty_<?php echo $item['id']; ?>">Số lượng: <span><?php echo $item['qty']; ?></span></p>
                                                </div>
                                            </li>
                                            <?php
                                                }
                                            ?>
                                            
                                            
                                        </ul>
                                        <?php
                                            }
                                        ?>
                                        <div class="total-price clearfix">
                                            <p class="title fl-left">Tổng:</p>
                                            <p class="price fl-right"><?php echo currency_format(get_total_cart()); ?></p>
                                        </div>
                                        <dic class="action-cart clearfix">
                                            <a href="<?php echo base_url("?mod=cart&action=show"); ?>" title="Giỏ hàng" class="view-cart fl-left">Giỏ hàng</a>
                                            <a href="<?php echo base_url("?mod=cart&action=checkout"); ?>" title="Thanh toán" class="checkout fl-right">Thanh toán</a>
                                        </dic>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>