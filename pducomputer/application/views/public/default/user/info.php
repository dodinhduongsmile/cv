
<div class="boxuser_content">
    <div class="row">
        <div class="col-md-2">
            <div class="avt_edit">
                <img src="<?php echo TEMPLATES_ASSETS.$this->session->userdata('avatar'); ?>" alt="<?php echo $this->session->userdata('fullname'); ?>">
                <input type="file" name="avatar" id="userlogo" style="display: none;">
                <button class="btn changelogo">Thay đổi</button>
                <button class="btn updatelogo savelogo" style="display: none;margin-top:5px;">Lưu</button>
            </div>
        </div>

        <div class="col-md-10">
            <form class="pro_file forminfo">

                <div class="settting_name flex_1 form-group">
                    <label for="">Tên:</label><br>
                    <input name="fullname" type="text" placeholder="" value="<?php echo $user->fullname; ?>">
                </div>

                <div class="email_1 flex_1 form-group">
                    <label for="">Email:</label><br>
                    <input name="email" type="text" value="<?php echo $user->email; ?>" readonly>
                </div>
                <div class="phone_num flex_1 form-group">
                    <label for="">Số điện thoại:</label><br>
                    <input name="phone" type="text" value="<?php echo $user->phone; ?>">
                </div>

                <div class="males form-group">
                    <label for="">Giới tính:</label><br>
                    <div class="males_box ">
                        <div class="male_check">
                            <input type="radio" name="gender" id="male1" value="1" <?php if($user->gender == 1){echo "checked";} ?> >
                            <label for="male1" style="font-weight: 100;">Nam</label>
                        </div>
                        <div class="male_check">
                            <input type="radio" name="gender" id="male2" value="2" <?php if($user->gender == 2){echo "checked";} ?> >
                            <label for="male2" style="font-weight: 100;">Nữ</label>
                        </div>
                        <div class="male_check">
                            <input type="radio" name="gender" id="male3" value="0" <?php if($user->gender == 0){echo "checked";} ?>>
                            <label for="male3" style="font-weight: 100;">Khác</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="date">Ngày - Tháng - Năm sinh:</label>
                    <div class="date_of_birth ">
                        <input type="text" maxlength="2" placeholder="Ngày sinh" name="birthday[day]" value="<?php echo $user->birthday['day']; ?>">
                        <input type="text" maxlength="2" placeholder="Tháng sinh" name="birthday[month]" value="<?php echo $user->birthday['month']; ?>">
                        <input type="text" maxlength="4" placeholder="Năm sinh" name="birthday[year]" value="<?php echo $user->birthday['year']; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="date">Tỉnh - huyện - xã</label>
                    <div class="address">
                        <select name="address[city]" id="city">
                        <?php if(!empty($address_tp)) {foreach($address_tp as $v){?>
                            <option value="<?php echo $v->code; ?>" <?php if($user->address['city'] == $v->code){echo "selected";} ?>><?php echo $v->name_with_type; ?></option>
                        <?php }}; ?>
                        </select>
                        <select name="address[district]" id="district">
                            <option value="<?php echo $user->address['district']; ?>"><?php echo !empty($address_huyen) ? $address_huyen['name_with_type'] : '--quận/huyện--'; ?></option>
                            <option value="">--quận/huyện--</option>
                        </select>
                        <select name="address[commune]" id="commune">
                            <option value="<?php echo $user->address['commune']; ?>"><?php echo !empty($address_xa) ? $address_xa['name_with_type'] : '--xã/phường--'; ?></option>
                        </select>
                        
                    </div>
                </div>
                <div class="form-group flex_1">
                    <label>Địa chỉ cụ thể (dùng khi gửi hàng):</label> <br>
                    <textarea name="shipping_address" placeholder="số nhà,xã-huyện-tỉnh" class="form-control"><?php echo $user->shipping_address; ?></textarea>
                </div>

                <div class="btn_submit">
                    <button type="button" class="saveinfo" onclick="pd_updateinfo(this);">Lưu lại</button>
                </div>
            </form>
        </div>
    </div>
</div>

