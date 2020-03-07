

<?php

function construct() {
    load_model('index');
    
}

function addAction() {
		//lấy id sp
$id = (int)$_GET["id"];
add_cart($id);
redirect("?mod=cart&controller=index&action=show");
  		
}

function showAction() {

    load_view('show');
}

function deleteAction() {
   $id = (int)$_GET["id"];//lấy id sp
delete_cart($id);
redirect("?mod=cart&controller=index&action=show");
}

function deleteallAction(){
	delete_cart();
redirect("?mod=cart&controller=index&action=show");
}

function updateAction(){
	if(isset($_POST["btn_update_cart"])){
	update_cart($_POST["qty"]);
	redirect("?mod=cart&controller=index&action=show");
    }
}
function updateajaxAction(){
$id = $_POST['id'];
$qty = $_POST['qty'];
$sub_total = $qty * $_SESSION["cart"]["buy"][$id]["price"];
//cập nhật lại mảng SESSTION cho từng sản phẩm vừa thay đổi
$_SESSION["cart"]["buy"][$id]["qty"] = $qty;
$_SESSION['cart']['buy'][$id]['sub_total'] = $sub_total;
//Cập nhật lại thông tin SESSION cho tất cả sản phẩm
$num_order = 0;
$total = 0;
foreach($_SESSION["cart"]["buy"] as $item){
    $num_order += $item["qty"];
    $total += $item["sub_total"];
}
//thông tin TỔNG hóa đơn
$_SESSION["cart"]["info"] = array(
    "num_order" => $num_order,
    "total" => $total
);

//Tạo mảng json lưu trữ để trả về ajax
    $result = array(
        'num_order' => $num_order,//tổng số lượng all sp
        'sub_total' => currency_format($sub_total),//giá * số lượng
        'total' => currency_format($total),//tổng giá all ap
        'qty' => $qty,//số lượng của sp tăng
    );
    echo json_encode($result);
}

function checkoutAction(){

global $error, $fullname, $email, $address,$phone;
if(isset($_GET['id'])){
    $id = $_GET['id'];
    add_cart($id);
}


load('helper', 'validate');
load('lib','email');//gọi hàm gửi mail
$success = array();
$error = array();//phat co
$list_checkout = get_list_buy_cart();
       

if(empty($list_checkout)){
	$error['checkout'] = 'Không có sản phẩm nào để thanh toán';
}else{
	if(isset($_POST["checkout"])){
    
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
        
        if(!is_email($_POST["email"])){
            $error["email"] = "email không đúng định dạng";
        }else{
            $email = $_POST["email"];
        }
    }

#check address

    if(empty($_POST["address"])){
        // hạ cờ
        $error["address"] = "không được để trống địa chỉ";
    }else{
             $address = $_POST["address"];
        }   

#phone
    if(empty($_POST["phone"])){
        $error["phone"] = "không được để trống phone";//hạ cờ
    }else{
        
        if(!is_phone_number($_POST["phone"])){
            $error["phone"] = "phone không đúng định dạng";
        }else{
            $phone = $_POST["phone"];
        }
    }

#note
    $note = $_POST["note"];

#payment method
    $payment = $_POST["payment-method"];
    $created_date = date('d-m-Y', time());
    $code = "DH".time();
    $count_order = get_num_order_cart();//số lượng
    $total_price = get_total_cart(); //không mã hóa, sau tính toán số ở data cho dễ
    $process_ship = base_url("?mod=cart&action=detail_order&order_code={$code}");
    //Nội dung gửi mail và sản phẩm luôn
    $product = "<div>
        <p>Chào bạn:{$fullname} . Cảm ơn bạn đã đặt hàng tại shop <strong>Ismart</strong></p>
        <h3>Đây là thông tin đơn hàng của bạn</h3>
        <p>1. Mã đơn hàng:<a href='{$process_ship}'> {$code}</a></p>
        <p>2. Thời gian đặt hàng: {$created_date}</p>
        <h3>Đây là thông tin giao hàng của bạn:</h3>
        <ul>
            <li>1. Người nhận: {$fullname}</li>
            <li>2. Địa chỉ nhận hàng: {$address} </li>
            <li>3. Số điện thoại: {$phone}</li>
            <li>4. Ghi chú: {$note}</li>
            <li>5. Hình thức thanh toán: {$payment} </li>
            <li>6. Chi phí vận chuyển: <b>Miễn phí</b> </li>
        </ul>
        <h3>Đây là chi tiết đơn hàng của bạn:</h3>
    </div>";
    $product.= "<table style='width:100%;border:1px solid #333;border-collapse: collapse;'>";
        $product.="<thead>
            <tr style='border: 1px solid black !important;'>
                <td style='border: 1px solid black;font-weight:bold;'>STT</td>
                <td style='border: 1px solid black;font-weight:bold;'>Sản phẩm</td>
                <td style='border: 1px solid black;font-weight:bold;'>Đơn giá</td>
                <td style='border: 1px solid black;font-weight:bold;'>Số lượng</td>
                <td style='border: 1px solid black;font-weight:bold;'>Thành tiền</td>
            </tr>
        </thead>";
        $product.="<tbody>";
        $temp = 0;
        foreach($list_checkout as $item){
            $temp++;
            
            $product.="<tr>
                        <td style='border: 1px solid black;'>{$temp}</td>
                        <td style='border: 1px solid black;'>{$item['product_title']}</td>
                        <td style='border: 1px solid black;'>{$item['price']}</td>
                        <td style='border: 1px solid black;'>{$item["qty"]}</td>
                        <td style='border: 1px solid black;'>".currency_format($item['sub_total'])."</td>
                    </tr>";
           };
        $product.="</tbody>";
        $product.="<tfoot style='background: red; color: #fff; font-weight: bold;'>
                        <tr>
                            <td style='border: 1px solid black;font-weight:bold;' colspan='3' >Tổng đơn hàng:</td>
                            <td style='border: 1px solid black;font-weight:bold;'>{$count_order} </td>
                            <td style='border: 1px solid black;font-weight:bold;'><strong >".currency_format($total_price)."</strong></td>
                        </tr>
                    </tfoot>";
    $product.="</table>";
    $product.= "<p>Chúng tôi sẽ gọi để xác nhận đơn hàng trong vòng 24h. Bạn nhớ để ý điện thoại nhé</p>
    <strong>Trân trọng cảm ơn!</strong>";
    
//kết luận
    if(empty($error)){
        //xử lý không lỗi
        $data = array(
            "fullname" => $fullname,
            "phone" => $phone,
            "email" => $email,
            "address" => $address,
            "note" => $note,
            "payment" => $payment,
            'product' => $product,
            'count_product' => $count_order,
            'total_price' => $total_price,
            'created_date' => $created_date,
            'code' => $code
        );
        db_insert("tbl_checkout", $data);
        $success['ok'] = "đặt hàng thành công. Vui lòng check email để xem chi tiết";
        //Nôi dung gửi mail
        //HÀM GỬI MAIL
      send_mail($email,$fullname,"ĐẶT HÀNG THEMEPDU",$product);
      redirect("?mod=cart&controller=index&action=order_success&order_code={$code}");
      //XÓA GIỎ
      unset($_SESSION["cart"]);
    }
 }
}
//LOAD VIEW
	
	
	$data["list_checkout"] =$list_checkout;
	$data["success"] =$success;
	
	load_view('checkout',$data);
}

function order_successAction() {
    $code = $_GET['order_code'];
    $order = get_order_by_code($code);
    //show_array($order);
    $data['order'] = $order;
    load_view('order_success', $data);
}

function detail_orderAction(){
$code = $_GET['order_code'];
$order = get_order_by_code($code);
$data['order'] = $order;
    load_view('detail_order',$data);
}