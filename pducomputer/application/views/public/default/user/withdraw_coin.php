<div class="banking">
    <?php if(!empty($user->banking)){ ?>
	<form class="form_w forminfo">
        <h3>Thông tin người nhận</h3>
		<div class="form-group">
            <label>Tên ngân hàng</label>
            <input type="text" readonly="readonly" placeholder="Nhập Tên ngân hàng" class="form-control" value="<?php echo @$user->banking->bank_name; ?>">
        </div>
        <div class="form-group">
            <label>Số tài khoản:</label>
            <input type="text" readonly="readonly" placeholder="Nhập Số tài khoản" class="form-control" value="<?php echo @$user->banking->bank_number; ?>">
        </div>
        <div class="form-group">
            <label>Chủ tài khoản:</label>
            <input type="text" readonly="readonly" placeholder="Nhập Chủ tài khoản" class="form-control" value="<?php echo @$user->banking->bank_author; ?>">
        </div>
        <div class="form-group">
            <label>Chi nhánh:</label>
            <input type="text" readonly="readonly" placeholder="Nhập Chi nhánh đăng ký tài khoản" class="form-control" value="<?php echo @$user->banking->bank_branch; ?>">
        </div>
        <hr>
        <div class="deposit_bank alert-message alert-danger">
            <p><strong>Điều kiện rút: </strong>Số dư tài khoản phải >= <?php echo $this->_settings_email->limit_withdraw; ?> coin</p>
        </div>
        <div class="form-group">
            <label>Giá 1 Coin = <strong><?php echo number_format($this->_settings_email->coin_price,0,'','.'); ?> vnđ</strong></label>
            <div class="input-group">
                <input type="number" readonly="readonly" placeholder="Giá coin" class="form-control" value="<?php echo @$this->_settings_email->coin_price; ?>">
                <span class="icon icon-prev"><b>Giá 1 Coin:</b></span>
                <span class="icon icon-after"><b>vnđ</b></span>
            </div>
        </div>
        <div class="form-group">
            <label>Số lượng rút: (<strong>khả dụng:<?php echo $user->coin_total; ?> coin</strong>)</label>
            <div class="input-group">
                <input type="number" name="amount" placeholder="Số lượng coin muốn rút" class="form-control" id="value_range" value="">
                <span class="icon icon-prev"><b>Số lượng</b></span>
                <span class="icon icon-after"><b>coin</b></span>
            </div>
            <div class="box-range">
                <input type="range" min="1" max="<?php echo (int)$user->coin_total; ?>" value="1" class="input_slider" id="myRange">
                <span class="p25">1/4</span>
                <span class="p50">2/4</span>
                <span class="p75">3/4</span>
                <span class="p100">all</span>
            </div>
        </div>
        <div class="form-group">
            <label>Xác minh mật khẩu đăng nhập user:</label>
            <input type="password" name="password" placeholder="Nhập mật khẩu đăng nhập User" class="form-control">
        </div>
        <div class="content_subbit">
            <button type="button" class="btn_save" onclick="pd_withdraw(this);">Gửi yêu cầu rút</button>
        </div>
	</form>
<?php }else{ ?>
    <strong class="boxmenu_item">Bạn chưa thêm tài khoản ngân hàng. Vui lòng thêm tài khoản ngân hàng <a href="<?php echo base_url('user/update_banking'); ?>">tại đây</a></strong>
<?php }; ?>
</div>
<script>
var slider = document.getElementById("myRange");
var output = document.getElementById("value_range");
output.value = slider.value;

slider.oninput = function() {
  output.value = this.value;
};
output.oninput = function() {
  slider.value = this.value;
};
</script>