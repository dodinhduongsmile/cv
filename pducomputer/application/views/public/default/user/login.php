   <section class="login_1">
        <div class="container">
            <div class="login_content">
                <div class="title_login">
                    <h4>Chào mừng đến với <?php echo $this->_settings->title_short; ?>. Đăng nhập ngay !</h4>
                    <div class="registration">
                        <p>Thành viên mới ? <a href="<?php echo base_url("user/register"); ?>">Đăng ký</a> tại đây</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 col-sm-6">
                        <form class="login_form">
                            <div class="login_left">
                                <label>* Email:</label><br>
                                <input type="text" placeholder="Vui lòng nhập email của bạn" name="email" value="<?php if(!empty($_COOKIE['user_login'])){echo $_COOKIE['user_login'];} ?>">
                            </div>

                            <div class="login_left">
                                <label>* Mật khẩu:</label><br>
                                <input type="password" placeholder="Vui lòng nhập mật khẩu của bạn" name="password" value="">
                            </div>
                            <div class="login_left">
                                <input type="checkbox" name="rememberme" <?php if(isset($_COOKIE["is_login"])){echo "checked";} ?>>
                                <label class="m-checkbox">
                                (Remember me)
                                </label>

                            </div>

                            <div class="mod-login-btn">
                                <button onclick="pd_login(this);" type="button">Đăng nhập</button>
                                <a href="<?php echo base_url("user/forgotpass"); ?>">Quên mật khẩu ?</a>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-5 col-sm-6">
                     <div class="login_right">
                        <div class="login_more">
                            <h4>Hoặc đăng nhập bằng:</h4>
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