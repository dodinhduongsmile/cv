<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends Public_Controller
{
    protected $_product;
    protected $_order;

    public function __construct() {
        parent::__construct();
        
        $this->load->model(['product_model','order_model']);
        $this->_product  = new Product_model();
        $this->_order    = new Order_model();
    }

    public function index()
    {
        // $this->db->truncate('order_detail');
        // dd("x");
        $data['data_cart'] = $this->cart->contents();
        // dd($data['data_cart']);
        $data['main_content'] = $this->load->view($this->template_path . 'cart/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

public function ajax_viewcart()
{
    $data['pdu'] = [];
    $html = $this->load->view($this->template_path . 'cart/cart_ajax', $data, TRUE);
    echo $html;
    exit();
}

public function detail_order($code)
{
    $data['product'] = $this->_order->getData_OrderDetail(['a.code'=>$code]);
// dd($data['product']);
    $data['order_detail'] = $this->_order->getByField('code',$code);

    $data['main_content'] = $this->load->view($this->template_path . 'cart/detail_order', $data, TRUE);
    $this->load->view($this->template_main, $data);
}


public function checkout()
{
    /*nêu login thì vào checkout sẽ lấy coin_total*/
    if(!empty($this->session->userdata('user_id'))){
        $data["user"] = $user = $this->_order->getById($this->session->userdata('user_id'),"id,coin_total,fullname,email,phone,shipping_address","users");
        $this->session->set_userdata('coin_total',(int)$user->coin_total);
        
    }
     $data['data_cart'] = $this->cart->contents();

     $data["pducoupon"] = $this->session->userdata('pducoupon');
     $data['price_shipping'] = !empty($this->_settings_home->shipprice) ? $this->_settings_home->shipprice : 0;
     $data['total_cart'] = $this->cart->total() + $data['price_shipping'] - @$data["pducoupon"]['percent'];
     // dd($data);
        $data['main_content'] = $this->load->view($this->template_path . 'cart/checkout', $data, TRUE);
        $this->load->view($this->template_main, $data);
}
    public function done()
    {
        if (empty($_SESSION['orderId'])) {
            redirect('/','','301');
        }

        $data['data_cart'] = $this->cart->contents();
        $data['info_cart'] = $info_cart =  $this->_order->getByField('id',$_SESSION['orderId']);
        $data['total_cart'] = $info_cart->total_amount + $info_cart->priceship - $info_cart->coupon;
        
        
        $data['main_content'] = $this->load->view($this->template_path . 'cart/done', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
//lưu đơn hàng
    public function saveOrder()
    {
        $this->checkRequestPostAjax();

        $this->_validation();
        $data_store = $this->input->post();
        $price_shipping = !empty($this->_settings_home->shipprice) ? $this->_settings_home->shipprice : 0;
        $coupon = !empty($this->session->userdata['pducoupon']) ? $this->session->userdata['pducoupon'] : 0;
        if(!empty($coupon)){
            /*kiểm tra xem nhỡ nãy nó chọn banking để add coupon xong lại chọn cod để đặt hàng*/
            if($coupon['pay_method'] > 1 && $data_store['method'] != $coupon['pay_method']){//=1 là COD thì auto cho chạy
                $method = array(2 => "Chuyển khoản Banking", 3 => "Đồng Coin");
                $data_mess = array(
                    'message' => "Mã chỉ áp dụng cho Phương thức thanh toán ".$method[$coupon['pay_method']].". Vui lòng chọn lại!",
                    'type' => 'warning'
                );
                die(json_encode($data_mess));
            }
        }

        if($data_store['method'] == 3){
            /*thanh toan bằng coin thì check coin_total xem đủ thanh toán không*/
            $coupon_percent = !empty($coupon['percent']) ? $coupon['percent'] : 0;
            $total_cart = $this->cart->total() + $price_shipping - $coupon_percent;
            $coin_total = (int)$this->session->userdata('coin_total')*(int)$this->_settings_email->coin_price;
            if($coin_total < (int)$total_cart){
                $data_mess = array(
                    'message' => "Số đồng COIN hiện tại của bạn không đủ để thanh toán.<br> Vui lòng chọn phương thức khác!",
                    'type' => 'warning'
                );
                die(json_encode($data_mess));
            }
        }
        
        $data['order_info'] = [
            'user_id' => !empty($this->session->userdata('user_id')) ? $this->session->userdata('user_id') : 0,
            'affilate_id' => !empty(get_cookie('affilate_id')) ? (int)get_cookie('affilate_id') : 0,
            'full_name' => $data_store['full_name'],
            'phone' => $data_store['phone'],
            'code' => time(),
            'email' => $data_store['email'],
            'address' => $data_store['address'],
            'method' => $data_store['method'],
            'content' => $data_store['content'],
            'coupon' => !empty($coupon) ? $coupon['percent'] : 0,
            'priceship' => $price_shipping,
            // 'another_phone' => $data_store['another_phone'],
            'total_amount' => $this->cart->total()
        ];
        $data['order_detail'] = $this->cart->contents();
        $orderId = $this->_order->saveDataOrder($data);
        if (!empty($orderId)) {
             
             if($data_store['method'] == 3){
                //chuyen coin tu coin_total sang coin_lock nếu thanh toán bằng coin
                $total_cart_coin = ((int)$total_cart/(int)$this->_settings_email->coin_price);
                $user = $this->_order->getById($this->session->userdata('user_id'),"id,coin_total,coin_lock",'users');
                $coin_lock = ((int)$user->coin_lock + (int)$total_cart_coin);
                $coin_totals = ((int)$user->coin_total - (int)$total_cart_coin);
                $this->_order->update(['id' => $user->id],['coin_lock'=>$coin_lock,'coin_total'=>$coin_totals],'users');
             }
             
             
            $data_mess = array(
                'message' => 'Mua đơn hàng thành công',
                'type' => 'success'
            );
            $_SESSION['orderId'] = $orderId;
            
            $this->sendMailCart($data);
            die(json_encode($data_mess));
        }else{
            $data_mess = array(
                'message' => 'Lỗi vui lòng thử lại !!!',
                'type' => 'warning'
            );
            die(json_encode($data_mess));
        }
    }

    public function viewmail()
    {
        $data['order_info'] = [
            'full_name' => "đỗ dương",
            'phone' => "0986490196",
            'code' => time(),
            'email' => "dodinhduong@gmail.com",
            'address' => "hiệp thuận,hà nội",
            'method' => "3",
            'content' => "nhanh nhanh",
            'coupon' => 15000,
            'priceship' => 30000,
            'total_amount' => $this->cart->total()
        ];

        $data['order_detail'] = $this->cart->contents();
        $this->load->view($this->template_path . 'cart/mail_cart', $data);
        
        
    }
public function sendMailCart($data){
        if(!empty($data['order_info']['email'])){
            /*Config setting*/
            $domain = !empty($this->_settings->domain) ? $this->_settings->domain : 'PDU GROUP';

            $this->load->library('email');
            $emailTo   = $data['order_info']['email']; //Send mail cho khach hang
            $emailToCC = !empty($this->_settings_email->email_admin) ? $this->_settings_email->email_admin : 'pdu@gmail.com'; //Send mail cho ban quan tri
            $emailFrom = $emailToCC;
            $nameFrom  = !empty($this->_settings_email->name_from) ? $this->_settings_email->name_from : 'PDU';
            $contentHtml = $this->load->view($this->template_path . 'cart/mail_cart', $data, TRUE);
            $this->email->from($emailFrom, $nameFrom);

            $this->email->to($emailTo);
            if(!empty($emailToCC)) $this->email->cc($emailToCC);
            if(!empty($emailToBCC)) $this->email->bcc($emailToBCC);
            $this->email->subject('Thông tin đơn hàng từ: '. $domain);
            $this->email->message($contentHtml);
            $this->email->send();
        }
    }
    public function addCart()
    {
        $this->checkRequestPostAjax();
        $data_sku = $this->input->post('data_sku');
        
        $product_id = $this->input->post('product_id');
        $num_order = $this->input->post('num_order') ? $this->input->post('num_order') : 1;
        if (empty($product_id)) {
            $data_mess = array(
                'message' => 'Lỗi vui lòng thử lại !!!',
                'type' => 'warning'
            );
            die(json_encode($data_mess));
        }
        $data_product = $this->_product->getByField('id',$product_id,'id,title,thumbnail,slug,price,price_sale,classify,guarantee');
        
        $subname = "";
        if(!empty($data_sku)){
            /*
            $str = "259_1";
            echo str_replace(strstr($str,"_"),"",$str);
             */
            foreach(json_decode($data_product->classify)->fulldata as $key => $item){
                if($item->sku == $data_sku){
                    $product_ids = $product_id."_".$key;
                    $price = $item->price;
                    $subname = " Phân Loại: " .$item->namegroup0 . "/". @$item->namegroup1;
                }
            }
        }else{
            if (!empty($data_product->price) && !empty($data_product->price_sale)) {
                $price = $data_product->price_sale;
            }elseif(!empty($data_product->price) && empty($data_product->price_sale)){
                $price = $data_product->price;
            }else{
                $price = 0;
            }

        }

        $item = array(
            'id' => !empty($data_sku) ? $product_ids : $product_id,
            'qty' => $num_order,
            'price' => $price,
            'name' => $data_product->title.$subname,//có dấu / ở tên là méo thêm đc, sửa ở library/cart
            'slug' => $data_product->slug,
            'thumbnail' => $data_product->thumbnail,
            'guarantee' => $data_product->guarantee,
        );

        $this->cart->insert($item);
        $total_cart = $this->cart->total();
        $total_item = $this->cart->total_items();
        // $xx = $this->cart->contents();
// dd($xx);
        $data_mess = array(
            'message' => 'Thêm sản phẩm thành công',
            'type' => 'success',
            'total_cart' => $total_cart,
            'total_item' => $total_item
        );
        die(json_encode($data_mess));
    }


    public function removeItem()
    {
        $this->checkRequestPostAjax();
        $product_id = $this->input->post('product_id');
        $identifier = $this->input->post('identifier');
        foreach ($this->cart->contents() as $key => $item) {
            if ($item['id'] == $product_id && $key == $identifier) {
                $this->cart->remove($identifier);//identifier là key của mảng cart
                $total_cart = $this->cart->total();
                $data_mess = array(
                    'message' => 'Xoá sản phẩm thành công',
                    'type' => 'success',
                    'total_cart' => number_format($total_cart, 0,'',','),
                    'total_item' => $this->cart->total_items()
                );
                echo json_encode($data_mess);
                break;
            }
        }
        $this->session->unset_userdata('pducoupon');//hủy coupon nếu chỉnh sửa giá
    }

    public function updateQuantity()
    {
        $this->checkRequestPostAjax();
        $product_id = $this->input->post('product_id');
        $quantity    = $this->input->post('quantity');
        $identifier = $this->input->post('identifier');
        if (isset($identifier) && isset($quantity) && isset($product_id)) {
            foreach ($this->cart->contents() as $key => $value) {
                if ($value['id'] == $product_id && $key == $identifier) {
                    $data = array('rowid' => $value['rowid'], 'qty' => $quantity);
                    $this->cart->update($data);
                    $this->cart->contents()[$key]['subtotal'] = $value['price'] * $quantity;
                    $data_mess = array(
                        'message' => 'Cập nhật giỏ hàng thành công',
                        'type' => 'success',
                        'total_item' => $this->cart->total_items(),
                        'total_cart' => number_format($this->cart->total(),0,'','.'),
                        'subtotal' => !empty($this->cart->contents()[$key]) ? number_format($this->cart->contents()[$key]['subtotal'], 0, '', ',') : '',
                    );
                    echo json_encode($data_mess);
                    break;
                }
            }
        }
        $this->session->unset_userdata('pducoupon');//hủy coupon nếu chỉnh sửa giá
    }
 //check ma giam gia
    public function checkCoupon(){
        $code = trim($_POST['code']);
        $pay_method = trim($_POST['pay_method']);
        $item = $this->_order->single(array('code' => $code),"codesale");

        $data['check'] = false;
        $total_cart = $this->cart->total();

        if(!empty($item)){
            //1. chỉ áp dụng cho đơn hàng >= price_condition
            if($item->price_condition > $total_cart){
                $data['mess'] = "Mã chỉ áp dụng cho đơn hàng >".$item->price_condition;
                echo json_encode($data);die();
            }else if($item->pay_method > 1 && $pay_method != $item->pay_method){//=1 là COD thì auto cho chạy
                $method = array(2 => "Chuyển khoản Banking", 3 => "Đồng COIN");
                $data['mess'] = "Mã chỉ áp dụng cho Phương thức thanh toán bằng ".$method[$item->pay_method].". Vui lòng chọn lại!";
                echo json_encode($data);die();
            }else{
                $data['check'] = true;
                $data['coupon_price'] = $couponcode = $item->percent;
                $pducoupon = array("percent" => $item->percent, "code" => $item->code, "pay_method" => $pay_method);
                $this->session->set_userdata('pducoupon',$pducoupon);
            }
        }else{
            $data['mess'] = "Mã Coupon không tồn tại.";
            echo json_encode($data);die();
        }
        $price_shipping = !empty($this->_settings_home->shipprice) ? $this->_settings_home->shipprice : 0;
        
        $data['total_cart'] = $total_cart - $couponcode + $price_shipping;
        
        // dd($this->session->userdata['pducoupon']);
        echo json_encode($data);
    }

    private function _validation(){
        $this->checkRequestPostAjax();
        if (empty($this->cart->contents())) {
            $data_mess = array(
                'message' => 'Không có sản phẩm nào trong giỏ hàng !!!',
                'type' => 'warning'
            );
            die(json_encode($data_mess));
        }
        $rules = [
           [
                'field' => "full_name",
                'label' => "họ và tên",
                'rules' => "trim|required|min_length[2]"
            ],[
                'field' => "phone",
                'label' => "số điện thoại",
                'rules' => 'callback_validdate_phone'
            ],[
                'field' => "address",
                'label' => "địa chỉ",
                'rules' => "trim|required|min_length[5]|max_length[1000]"
            ],[
                'field' => "email",
                'label' => "địa chỉ",
                'rules' => "trim|valid_email|min_length[5]|max_length[50]"
            ],[
                'field' => "content",
                'label' => "yêu cầu khác",
                'rules' => "trim|max_length[1000]"
            ],[
                'field' => "method",
                'label' => "Phương thức",
                'rules' => "trim"
            ]
        ];
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $message['type'] = "warning";
            $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
            $valid = array();
            if(!empty($rules)) foreach ($rules as $item){
                if(!empty(form_error($item['field']))) $valid[$item['field']] = form_error($item['field']);
            }
            $message['validation'] = $valid;
            $this->returnJson($message);
        }
    }

    public function validdate_phone(){
        $phone   = $this->input->post('phone');
        $count_phone = strlen($phone);
        if (preg_match('/((09|03|07|08|05)+([0-9]{8})\b)/iu',$phone)) {
            if (empty($phone)) {
                $this->form_validation->set_message('validdate_phone', 'Trường số điện thoại không được để trống');
                return false;
            }elseif($count_phone < 7 || $count_phone > 10){
                $this->form_validation->set_message('validdate_phone', 'Trường số điện thoại không hợp lệ');
                return false;
            }else {
                return true;
            }
        }else{
            $this->form_validation->set_message('validdate_phone', 'Trường số điện thoại không hợp lệ');
            return false;
        }
    }

    public function validdate_another_phone(){
        $another_phone   = $this->input->post('another_phone');
        $count_phone = strlen($another_phone);
        if (!empty($another_phone)) {
            if (preg_match('/((09|03|07|08|05)+([0-9]{8})\b)/iu',$another_phone)) {
                if($count_phone < 7 || $count_phone > 10){
                    $this->form_validation->set_message('validdate_another_phone', 'Trường số điện thoại 2 không hợp lệ');
                    return false;
                }else {
                    return true;
                }
            }else{
                $this->form_validation->set_message('validdate_another_phone', 'Trường số điện thoại 2 không hợp lệ');
                return false;
            }
        }
    }


    

}
