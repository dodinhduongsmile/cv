<?php
get_header();
?>
<?php
if(isset($_POST["checkout"])){
    $error = array();//phat co
    $alert = array();
#fullname
    if(empty($_POST["fullname"])){
        $error["fullname"] = "không được để trống fullname";
    }else{
        $fullname = $_POST["fullname"];
    }

#chuẩn hóa email
    if(empty($_POST["email"])){
        $error["email"] = "không được để trống email";//hạ cờ
    }else{
        //validation username
        $partern = "/^[A-Za-z0-9_.]{2,32}@([a-zA-Z0-9]{2,12})(.[a-zA-Z]{2,12})+$/";
        if(!preg_match($partern, $_POST["email"],$matchs)){
            $error["email"] = "email cho phép dùng các chữ in hoa, in thường,số, gạch dưới, chấm,ký tự đặc biệt và dài 6 đến 32 ký tự trước @.";
        }else{
            $email = $_POST["email"];
        }
    }

#check address

    if(empty($_POST["address"])){
        // hạ cờ
        $error["address"] = "không được để trống address";
    }else{
             $address = $_POST["address"];
        }   

#phone
    if(empty($_POST["phone"])){
        $error["phone"] = "không được để trống phone";//hạ cờ
    }else{
        //validation username
        $partern = "/^((09|03)[2|6|8|9])+([0-9]{7})$/";
        // $partern = "/^(03|08|09[2|6|8|9])+([0-9]{7})$/";
        if(!preg_match($partern, $_POST["phone"],$matchs)){
            $error["phone"] = "phone không đúng định dạng";
        }else{
            $phone = $_POST["phone"];
        }
    }

#note
    $note = $_POST["note"];
# product order ==> chưa lấy đc danh sách sản phẩm
#payment method
    $payment = $_POST["payment"];

//kết luận
    if(empty($error)){
        //xử lý không lỗi
        // echo "đăng ký thành công";

        // $sql = "INSERT INTO `tbl_user` (`fullname` , `username` , `email`, `password`, `gender`)
        // VALUE ('{$fullname}', '{$username}', '{$email}','{$password}','{$gender}')";
        // if(mysqli_query($conn,$sql)){
        //  $alert["success"] = "đã thêm dữ liệu thành công";
        // }else{
        //  echo "lỗi" . mysqli_error($conn);
        // }
        $data = array(
            "fullname" => $fullname,
            "phone" => $phone,
            "email" => $email,
            "note" => $note,
            "payment" => $payment
        );
        $id_insert = db_insert("btl_checkout", $data);
        if(isset($id_insert)){
            $alert["success"] = "đã thêm thành công";
            unset($_SESSION["cart"]);
        }
        
    }else{
        //xử lý có lỗi, xuất lỗi trong mảng error
        show_array($error);
    }
}
?>
<div id="main-content-wp" class="checkout-page ">
    <div class="wp-inner clearfix">
        <?php
get_sidebar();
?>
<?php if(!empty($alert["success"])){
?>
    <p class="success"> <?php echo $alert["success"]; ?> </p>
<?php
}
?>
        <div id="content" class="fl-right">
            <div class="section" id="checkout-wp">
                <div class="section-head">
                    <h3 class="section-title">Thanh toán</h3>
                </div>
                <div class="section-detail">
                    <div class="wrap clearfix">
                        <form method="POST">
                            <div id="custom-info-wp" class="fl-left">
                                <h3 class="title">Thông tin khách hàng</h3>
                                <div class="detail">
                                    <div class="field-wp">
                                        <label>Họ tên</label>
                                        <input type="text" name="fullname" id="fullname">
                                    </div>
                                    <div class="field-wp">
                                        <label>Email</label>
                                        <input type="email" name="email" id="email">
                                    </div>
                                    <div class="field-wp">
                                        <label>Địa chỉ nhận hàng</label>
                                        <input type="text" name="address" id="address">
                                    </div>
                                    <div class="field-wp">
                                        <label>Số điện thoại</label>
                                        <input type="tel" name="phone" id="tel">
                                    </div>
                                    <div class="field-full-wp">
                                        <label>Ghi chú</label>
                                        <textarea name="note"></textarea>
                                    </div>

                                </div>
                            </div>
                            <div id="order-review-wp" class="fl-right">
                                <h3 class="title">Thông tin đơn hàng</h3>
                                <div class="detail">
                                    <table class="shop-table">
                                        <thead>
                                            <tr>
                                                <td>Sản phẩm(<?php echo get_num_order_cart(); ?>)</td>
                                                <td>Tổng</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                foreach($list_checkout as $item){
                                            ?>

                                            <tr class="cart-item">
                                                <td class="product-name"><?php echo $item["product_title"]; ?><strong class="product-quantity">x <?php echo $item["qty"]; ?></strong></td>
                                                <td class="product-total"><?php echo currency_format($item["sub_total"]); ?></td>
                                            </tr>

                                            <?php
                                                }
                                            ?>
                                            
                                        </tbody>
                                        <tfoot>
                                            <tr class="order-total">
                                                <td>Tổng đơn hàng:</td>
                                                <td><strong class="total-price"><?php echo currency_format(get_total_cart()); ?></strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div id="payment-checkout-wp">
                                        <ul id="payment_methods">
                                            <li>
                                                <input type="radio" checked="checked" id="direct-payment" name="payment" value="online">
                                                <label for="direct-payment">Thanh toán online</label>
                                            </li>
                                            <li>
                                                <input type="radio" id="payment-home" name="payment" value="cod">
                                                <label for="payment-home">Thanh toán tại nhà</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="place-order-wp clearfix">
                                        <button type="submit" name="checkout">Đặt hàng</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
get_footer();
?>