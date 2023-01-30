<div class="banking">
	<form class="form_w forminfo">
		<div class="form-group">
            <label>Tên ngân hàng</label>
            <input type="text" name="bank_name" placeholder="Nhập Tên ngân hàng" class="form-control" value="<?php echo @$banking->bank_name; ?>">
        </div>
        <div class="form-group">
            <label>Số tài khoản:</label>
            <input type="text" name="bank_number" placeholder="Nhập Số tài khoản" class="form-control" value="<?php echo @$banking->bank_number; ?>">
        </div>
        <div class="form-group">
            <label>Chủ tài khoản:</label>
            <input type="text" name="bank_author" placeholder="Nhập Chủ tài khoản" class="form-control" value="<?php echo @$banking->bank_author; ?>">
        </div>
        <div class="form-group">
            <label>Chi nhánh:</label>
            <input type="text" name="bank_branch" placeholder="Nhập Chi nhánh đăng ký tài khoản" class="form-control" value="<?php echo @$banking->bank_branch; ?>">
        </div>
        <div class="form-group">
            <label>Xác minh mật khẩu đăng nhập user:</label>
            <input type="password" name="password" placeholder="Nhập mật khẩu đăng nhập User" class="form-control">
        </div>
        <div class="content_subbit">
            <button type="button" class="btn_save" onclick="pd_updatebank(this);"><?php echo !empty($banking)? "Lưu thay đổi":"Thêm banking"; ?></button>
        </div>
	</form>
</div>