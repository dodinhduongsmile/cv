<?php
get_header();
// show_array($user);
?>
<div id="main-content-wp" class="info-account-page">
    <div class="section" id="title-page">
        <div class="clearfix">
            <a href="?page=add_cat" title="" id="add-new" class="fl-left">Thêm mới</a>
            <h3 id="index" class="fl-left">Chỉnh sửa tài khoản</h3>
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
                        <label for="display-name">Tên hiển thị</label>
                        <input type="text" name="fullname" id="display-name" value="<?php echo $user['fullname']; ?>">
                        <label for="username">Tên đăng nhập</label>
                        <input type="text" name="username" id="username" placeholder="admin" readonly="readonly" value="<?php echo $user['username']; ?>">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo $user['email']; ?>">
                        <?php form_error('email'); ?>
                        <label for="tel">Số điện thoại</label>
                        <input type="tel" name="tel" id="tel" value="<?php echo $user['phone_number']; ?>">
                        <?php form_error('tel'); ?>
                        <label for="password">Quyền</label>
                        <select name="role" id="">
                            <option value="2" >2</option>
                            <option value="1" >1</option>
                            <option value="3" >3</option>
                            <option value="null" selected="selected">NULL</option>
                        </select>
                        <label for="address">Địa chỉ</label>
                        <textarea name="address" id="address"><?php echo $user['address']; ?></textarea>
                        <button type="submit" name="btn_update" id="btn-submit">Cập nhật</button>
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