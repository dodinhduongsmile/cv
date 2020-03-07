<div id="footer-wp">
    <div id="foot-body">
        <div class="wp-inner clearfix">
            <div class="block" id="info-company">
                <?php echo html_entity_decode(phone('footer2')); ?>
            </div>
            <div class="block menu-ft" id="info-shop">
                <h3 class="title"><?php echo html_entity_decode(block_title('footer1')); ?></h3>
                <?php echo html_entity_decode(phone('footer1')); ?>
            </div>
            <div class="block menu-ft policy" id="info-shop">
                <h3 class="title"><?php echo html_entity_decode(block_title('footer3')); ?></h3>
                <?php echo html_entity_decode(phone('footer3')); ?>
            </div>
            <div class="block" id="newfeed">
                <h3 class="title"><?php echo html_entity_decode(block_title('footer4')); ?></h3>
                <p class="desc"><?php echo html_entity_decode(phone('footer4')); ?></p>
                
            </div>
        </div>
    </div>
    <div id="foot-bot">
        <div class="wp-inner">
            <p id="copyright">© Bản quyền thuộc về phoker.com | Php Store</p>
        </div>
    </div>
</div>
</div>
<div id="menu-respon">
    <a href="<?php echo base_url(); ?>" title="" class="logo">PHP STORE</a>
    <div id="menu-respon-wp">
        <ul class="" id="main-menu-respon">
            <li>
                <a href="<?php echo base_url(); ?>" title>Trang chủ</a>
            </li>
            <li>
                <a href="?page=category_product" title>Điện thoại</a>
                <ul class="sub-menu">
                    <li>
                        <a href="?page=category_product" title="">Iphone</a>
                    </li>
                    <li>
                        <a href="?page=category_product" title="">Samsung</a>
                        <ul class="sub-menu">
                            <li>
                                <a href="?page=category_product" title="">Iphone X</a>
                            </li>
                            <li>
                                <a href="?page=category_product" title="">Iphone 8</a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="?page=category_product" title="">Nokia</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="?page=category_product" title>Máy tính bảng</a>
            </li>
            <li>
                <a href="?page=category_product" title>Laptop</a>
            </li>
            <li>
                <a href="?page=category_product" title>Đồ dùng sinh hoạt</a>
            </li>
            <li>
                <a href="?page=blog" title>Blog</a>
            </li>
            <li>
                <a href="#" title>Liên hệ</a>
            </li>
        </ul>
    </div>
</div>
<div id="btn-top"><img src="<?php echo base_url("public/images/icon-to-top.png"); ?>" alt=""/></div>
<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=849340975164592";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
</body>
</html>