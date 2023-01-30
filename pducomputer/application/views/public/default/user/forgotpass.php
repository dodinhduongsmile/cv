
<section class="register">
        <div class="container ctn_login">
            <div class="register_content">
                <div class="row">
                    <div class="col-md-7 col-sm-6">
                     <div class="re_title v2">
                        <h4><?php echo $title; ?></h4>
                        <div class="registration">
                            <p><?php echo $descript; ?></p>
                        </div>
                    </div>
                    <?php
                    if(!empty($changepassnew)):
                    ?>
                    <form class="register_form">
                        <input type="hidden" name="forgotten_password_code" id="forgotten_password_code" value="<?php echo $forgotten_password_code; ?>">
                        <div class="login_left">
                            <label>Mật khẩu mới:</label><br>
                            <input type="password" name="password" placeholder="Vui lòng nhập mật khẩu của bạn" >
                        </div>

                        <div class="login_left">
                            <label>Nhập lại mật khẩu mới:</label><br>
                            <input type="password" name="re_password" placeholder="Vui lòng nhập lại mật khẩu của bạn" >
                        </div>

                        <div class="mod-login-btn">
                            <button onclick="pd_forgotpass(this);" type="button" id="btn_forgotpass">Đổi mật khẩu</button>
                        </div>
                    </form>
                    <?php else: ?>
                    <form class="register_form">
                        <div class="login_left">
                            <label>Email:</label><br>
                            <input type="text" placeholder="Nhập email của bạn..." name="email">
                        </div>

                        <div class="mod-login-btn">
                            <button onclick="pd_forgotpass(this);" type="button" >Tiếp tục</button>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>

                <div class="col-md-5 col-sm-6">
                    <a href=""><img src="images/logo.png" width="100%"></a>
                </div>
            </div>
        </div>
    </div>
</section>