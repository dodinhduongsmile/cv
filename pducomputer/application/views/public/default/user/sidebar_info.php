<div class="left_accInfo">
    <div class="infopdu">
        <div class="info_ boxmenu_item">
            <div class="avt_">
                <a href="<?php echo base_url('user/index'); ?>" title="tổng quan">
                <img src="<?php echo TEMPLATES_ASSETS.$this->session->userdata('avatar'); ?>" alt="<?php echo $this->session->userdata('fullname'); ?>">
                </a>
            </div>
            <div class="name">
                <p><a href="<?php echo base_url('user/index'); ?>" title="tổng quan"><?php echo $this->session->userdata('fullname'); ?></a></p>
                <a href="<?php echo base_url('user/info'); ?>" title="Sửa thông tin">Sửa thông tin</a>
            </div>
        </div>
        <div class="show_sidebar">
            <i class="fa fa-chevron-down" aria-hidden="true"></i>
        </div>
    </div>

    <div class="boxmenu">
        <div class="acc_management jointly_st">
        <span class="acc_t">Quản lý tài khoản</span>
        <ul class="boxmenu_list">
            <li class="boxmenu_item"><a href="<?php echo base_url('user/info'); ?>" title="Thông tin tài khoản">Thông tin tài khoản</a></li>
            <!-- <li><a href="address.html">Địa chỉ</a></li> -->
            <li class="boxmenu_item"><a href="<?php echo base_url('user/update_password'); ?>" title="Đổi mật khẩu">Đổi mật khẩu</a></li>
            <li class="boxmenu_item"><a href="<?php echo base_url('user/update_banking'); ?>" title="Tài khoản">Tài khoản ngân hàng</a></li>
            <li class="boxmenu_item"><a href="<?php echo base_url('user/withdraw_coin'); ?>" title="Rút tiền">Rút tiền</a></li>
            <li class="boxmenu_item"><a href="<?php echo base_url('user/deposit_coin'); ?>" title="Nạp tiền">Nạp tiền</a></li>
            <li class="boxmenu_item"><a href="<?php echo base_url('user/pending_coin'); ?>" title="Lịch sử Nạp/Rút">Lịch sử Nạp/Rút</a></li>
        </ul>
        </div>

        <div class="order_management jointly_st">
            <span class="acc_t">Quản lý đơn hàng</span>
            <ul class="boxmenu_list">
                <li class="boxmenu_item"><a href="<?php echo base_url('user/danh_sach_don_hang'); ?>" title="Tất cả đơn hàng">Tất cả đơn hàng</a></li>
                <li class="boxmenu_item"><a href="<?php echo base_url('user/danh_sach_don_hang?is_status=1'); ?>" title="Chờ lấy hàng">Chờ lấy hàng</a></li>
                <li class="boxmenu_item"><a href="<?php echo base_url('user/danh_sach_don_hang?is_status=2'); ?>" title="Đang giao"> Đang giao</a></li>
                <li class="boxmenu_item"><a href="<?php echo base_url('user/danh_sach_don_hang?is_status=3'); ?>" title="Đã giao">Đã giao</a></li>
                <li class="boxmenu_item"><a href="<?php echo base_url('user/danh_sach_don_hang?is_status=4'); ?>" title="Hoàn trả">Hoàn trả</a></li>
                <li class="boxmenu_item"><a href="<?php echo base_url('user/danh_sach_don_hang?is_status=0'); ?>" title="Đã hủy">Đã hủy</a></li>
            </ul>
        </div>
        <div class="order_management jointly_st">
            <span class="acc_t">Quản lý khóa học</span>
            <ul class="boxmenu_list">
                <li class="boxmenu_item"><a href="<?php echo base_url('user/edu_list'); ?>" title="Khóa học của tôi">Khóa học của tôi</a></li>
                <li class="boxmenu_item"><a href="#" title="updating" >Danh sách yêu thích</a></li>
                <li class="boxmenu_item"><a href="#" title="updating" >Danh sách bình luận</a></li>
            </ul>
        </div>

        <div class="notification_management jointly_st">
            <span class="acc_t">Thông báo</span>
            <ul class="boxmenu_list">
                <li class="boxmenu_item"><a href="<?php echo base_url('user/voucher'); ?>" title="Tất cả thông báo">Tất cả thông báo</a></li>
                <li class="boxmenu_item"><a href="<?php echo base_url('user/voucher?pay_method=1'); ?>" title="Voucher khi thanh toán bằng tiền mặt">Voucher COD</a></li>
                <li class="boxmenu_item"><a href="<?php echo base_url('user/voucher?pay_method=2'); ?>" title="Voucher khi thanh toán bằng chuyển khoản">Voucher Banking</a></li>
                <li class="boxmenu_item"><a href="<?php echo base_url('user/voucher?pay_method=3'); ?>" title="Voucher khi thanh toán bằng COIN thưởng">Voucher Coin</a></li>
            </ul>
        </div>

        <div class="sale_code jointly_st">
            <span class="acc_t">affilate</span>
            <ul class="boxmenu_list">
                <li class="boxmenu_item"><a href="<?php echo base_url('user/affilate'); ?>" title="affilate">affilate</a></li>
                <li class="boxmenu_item"><a href="<?php echo base_url('user/history'); ?>" title="Lịch sử">Lịch sử</a></li>
            </ul>
        </div>
    </div>
</div>