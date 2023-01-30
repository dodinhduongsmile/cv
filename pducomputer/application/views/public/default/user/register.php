<section class="register">
        <div class="container">
            <div class="register_content">
                <div class="re_title">
                    <h4>Tạo tài khoản <?php echo $this->_settings->title_short; ?></h4>
                    <div class="registration">
                        <p>Bạn đã là thành viên ? <a href="<?php echo base_url("user/login"); ?>">Đăng nhập</a> tại đây</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7 col-sm-6">
                        <form class="register_form">
                            <div class="login_left">
                                <label>Email:</label><br>
                                <input type="text" name="email" placeholder="Vui lòng nhập email của bạn" value="">
                            </div>
                            <div class="login_left">
                                <label>Phone:</label><br>
                                <input type="text" name="phone" placeholder="Vui lòng nhập số điện thoại của bạn" value="">
                            </div>
                            <div class="login_left">
                                <label>Mật khẩu:</label><br>
                                <input type="password" name="password" placeholder="Vui lòng nhập mật khẩu của bạn" value="">
                            </div>

                            <div class="login_left">
                                <label>Nhập lại mật khẩu:</label><br>
                                <input type="re_password" name="re_password" placeholder="Vui lòng nhập lại mật khẩu của bạn" value="">
                            </div>

                            <div class="mod-login-btn">
                                <button type="button" onclick="pd_register(this);">Đăng ký</button>
                                <a href="<?php echo base_url("user/forgotpass"); ?>">Quên mật khẩu ?</a>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-5 col-sm-6">
                        <div class="register_right">
                            <div class="login_more">
                                <h4>Hoặc đăng ký bằng:</h4>
                                <button class="btn_login_facebook"><span class="fa fa-facebook"></span>facebook</button><br>
                                <button class="btn_login_google"><span class="fa fa-google"></span>google</button>
                                <button class="btn_login_zalo"><span class="zl">Z</span>Zalo</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

