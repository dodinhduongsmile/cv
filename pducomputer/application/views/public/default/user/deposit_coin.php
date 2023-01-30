<div class="banking">
    <?php if(!empty($user)){ ?>
	<form class="form_w forminfo">
        <h3>Vui lòng thực hiện các bước sau:</h3>
        <div class="guide_bank">
        	<p><b>Bước 1:</b> Nhập số lượng coin muốn nạp vào form bên dưới và gửi yêu cầu.</p>
        	<p><b>Bước 2:</b> Chuyển khoản theo thông tin ngân hàng bên dưới, số tiền tương ứng số Coin bạn nạp.</p>
        </div>
		<div class="deposit_bank alert-message alert-danger">
			<?php echo !empty($this->_settings_home->banknumber) ? $this->_settings_home->banknumber : "Liên hệ admin";
			echo "<strong>Nội dung: </strong>".$user->username."_".$user->id;
			?>
		</div>
        <hr>
        <div class="form-group">
            <label>Giá 1 Coin = <strong><?php echo number_format($this->_settings_email->coin_price,0,'','.'); ?> vnđ</strong></label>
            <div class="input-group">
                <input type="number" readonly="readonly" placeholder="Giá coin" class="form-control" value="<?php echo @$this->_settings_email->coin_price; ?>">
                <span class="icon icon-prev"><b>Giá 1 Coin:</b></span>
                <span class="icon icon-after"><b>vnđ</b></span>
            </div>
        </div>
        <div class="form-group">
            <label>Số lượng Nạp:</label>
            <div class="input-group">
                <input type="number" name="amount" placeholder="Số lượng coin muốn rút" class="form-control" id="value_range" value="">
                <span class="icon icon-prev"><b>Số lượng</b></span>
                <span class="icon icon-after"><b>coin</b></span>
            </div>
        </div>
        <div class="form-group">
            <label>Xác minh mật khẩu đăng nhập user:</label>
            <input type="password" name="password" placeholder="Nhập mật khẩu đăng nhập User" class="form-control">
        </div>
        <div class="content_subbit">
            <button type="button" class="btn_save" onclick="pd_deposit(this);">Gửi yêu cầu</button>
        </div>
	</form>
<?php }else{ ?>
    <strong>Vui lòng liên hệ admin <a href="<?php echo base_url('lien-he.html'); ?>">tại đây</a></strong>
<?php }; ?>
</div>