<?php
get_header();
// show_array($user);
?>
<div id="main-content-wp" class="info-account-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?mod=user&controller=team&action=add" title="" id="add-new" class="fl-left">Thêm mới</a>
            <h3 id="index" class="fl-left">Thêm mới tài khoản</h3>
        </div>
    </div>
    <div class="wrap clearfix">
        <?php
            get_sidebar('user');
        ?>
        <div id="content" class="fl-right">                       
            <div class="section" id="detail-page">
                <div class="section-detail">
                    <form action="" method="POST" id="add_user">
                        
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" name="username" value="<?php echo set_value('username'); ?>">
                        <?php form_error('username'); ?>

                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo set_value('email'); ?>">
                        <?php form_error('email'); ?>
                        
                        <label for="password">Quyền</label>
                        <select name="role" id="">
                            <option value="2" >2</option>
                            <option value="1" >1</option>
                            <option value="3" >3</option>
                            <option value="null" selected="selected">NULL</option>
                        </select>
                        <?php form_error('role'); ?>

                        <label for="password">Mật khẩu</label>
                        <input type="password" name="password" id="password">
                        <?php form_error('password'); ?>

                        <button type="submit" name="btn_add" id="btn-submit">Cập nhật</button>
                        <?php form_error("account"); ?>
                    </form>
                    <?php form_success("ok"); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
?>