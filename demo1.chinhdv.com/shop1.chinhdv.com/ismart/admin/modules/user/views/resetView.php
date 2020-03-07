<?php
get_header();
?>

<div id="main-content-wp" class="change-pass-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?page=add_cat" title="" id="add-new" class="fl-left">Thêm mới</a>
            <h3 id="index" class="fl-left">ĐỔI MẬT KHẨU</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?php
        	get_sidebar('user');
        ?>
        <div id="content" class="fl-right">                       
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form method="POST">
                        <label for="old-pass">Mật khẩu cũ</label>
                        <input type="password" name="pass_old" id="pass-old">
                        <?php form_error('pass_old'); ?>
                        <label for="new-pass">Mật khẩu mới</label>
                        <input type="password" name="pass_new" id="pass-new">
                        <?php form_error('pass_new'); ?>
                        <label for="confirm-pass">Xác nhận mật khẩu</label>
                        <input type="password" name="confirm_pass" id="confirm-pass">
                        <?php form_error('confirm_pass'); ?>
                        <button type="submit" name="btn_submit" id="btn-submit">Cập nhật</button>
                        <?php form_error('other'); ?>
                    </form>
                   <?php form_success('ok'); ?>
                </div>
            </div>
        </div>
    </div>
</div>
	

<?php
get_footer();
?>