<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends Public_Controller {

	protected $_user;

    public function __construct() {
        parent::__construct();
        
        $this->load->model(['users_model', 'Logbank_model', 'order_model','codesale_model']);
        $this->_user = new Users_model();
        $this->_order = new Order_model();
        $this->_codesale = new Codesale_model();
        $this->_logbank = new Logbank_model();
        $this->check_login();
       
    }
public function check_login(){
   
    $userpdu =$this->session->userdata();
    
    if (empty($userpdu['user_id']) && ($this->_controller === 'user' && !in_array($this->_method, ['login', 'ajax_login','logout','register','ajax_register','activeuser','checktime','forgotpass','ref','ajax_cancel_order']))  ) {
            //chưa đăng nhập thì chuyển về page login
            redirect(base_url('user/login') . '?url=' . urlencode(current_url()), 'refresh');
        }
}
public function index()
{
    // $tinh = file_get_contents(APPPATH.'third_party/location/'.'xa_phuong.json');
    
    $datauser1['user'] = $user = $this->_user->single(['id' => $this->session->userdata('user_id')]);
    $datauser1['percent'] = 500;

    if(isset($_POST['url'])){

        $html  = $this->load->view($this->template_path . 'user/dasboard', $datauser1, TRUE);
        $data_mess = [
            'html' => $html,
            'title' => "Quản lý tài khoản"
        ];
        die(json_encode($data_mess));
    }else{
        $data['SEO'] = [
        'title' => "Quản lý tài khoản"
        ];
        $datauser['title'] = "Quản lý tài khoản";
        $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/dasboard', $datauser1, TRUE);
        $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
        $this->load->view($this->template_main, $data);
    }
    
   

    
}
// rút tiền từ ref sang ví total
public function withdraw_total()
{
    $user = $this->_user->single(['id' => $this->session->userdata('user_id')]);
    $data = $this->input->post();
    if(!empty($data['type'])){
        if($data['type'] == 'coin_ref'){
            $coinadd = $user->coin_ref;
        }elseif($data['type'] == 'coin_order'){
            $coinadd = $user->coin_order;
        }
        if((int)$coinadd > 0){
            $coin_total = ((int)$user->coin_total + (int)$coinadd);
        
            if($this->_user->update(['id' => $user->id],['coin_total'=>$coin_total,$data['type']=>0])){
                $dtlogref = array(
                    'type'=>'transfer','user_id'=>$user->id,'child_id'=>0,
                    'reward'=>$coinadd,
                    'note' =>"User id {$user->id} chuyển {$coinadd} coin từ ví {$data['type']} vào ví chính"
                );
                $this->addLogRef($dtlogref);
                //update session
                $message['type'] = 'success';
                $message['message'] = "Thao tác thành công !";
            }else{
                $message['type'] = 'error';
                $message['message'] = "Thao tác thất bại !";
            }
        }else{
            $message['type'] = 'error';
            $message['message'] = "Tài khoản phải > 1 coin!";
        }
        
        $this->returnJson($message);
    }
    

    
}
/*link ref base_url('ref/username_id')*/
public function ref($username_id='')
{
    if(!empty($username_id)){
        $user_id = str_replace("_","",strstr($username_id,"_"));
        set_cookie('affilate_id', $user_id, time() + 1296000);
        redirect(base_url());
    }
}

public function affilate($value='')
{
    /*
    1.tạo đường dẫn giới thiệu cho user
    2. khi click vào sẽ lưu cookie trong 30 ngày
    3. khi đăng ký sẽ lưu người giới thiệu lại làm parent_id
    4. giới thiệu 1 người B thưởng xxx
    4.1 Người B giới thiệu được thưởng 2xxx (ăn lợi 2 cấp)
    $start = microtime(true);
    $end = microtime(true);
    dd($end-$start);
     */

    $user_id = $this->session->userdata('user_id');
    $listchild_user = $this->_getchild_user($user_id,$lever=2);
    $datauser1['user_parent'] = $listchild_user;
    if(isset($_POST['url'])){
        $html = $this->load->view($this->template_path . 'user/affilate', $datauser1, TRUE);
        $data_mess = [
            'html' => $html,
            'title' => "affilate marketing"
        ];
        die(json_encode($data_mess));
    }else{
        $data['SEO'] = [
        'title' => "affilate marketing"
    ];
        $datauser['title'] = "affilate marketing";
        $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
        $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/affilate', $datauser1, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
        $this->load->view($this->template_main, $data);
    }
    
}
 public function ajax_cancel_bank(){
    $this->checkRequestPostAjax();
    $data = $this->input->post();
    $id = $data['id'];
    $user_id = $this->session->userdata('user_id');

    $itembank = $this->_logbank->single(['id' => $id]);
    $user = $this->_user->getById($user_id,"id,coin_total,coin_lock");

    if($itembank->type == 1){//neu rut
        //rut, chuyen coin_lock ve coin_total
        $amount = $itembank->amount;
        $coin_lock = ((int)$user->coin_lock - (int)$amount);
        $coin_total = ((int)$user->coin_total + (int)$amount);
        $this->_user->update(['id' => $user->id],['coin_lock'=>$coin_lock,'coin_total'=>$coin_total]);

    }

    $dataupdate = array(
        "note" => "Khách hủy: ".$data['note'],
        "is_status" => 0
    );
    if($this->_logbank->update(['id' => $id],$dataupdate)){
        $message['type'] = 'success';
        $message['message'] = "Thao tác thành công !";
    }else{
        $message['type'] = 'error';
        $message['message'] = "Thao tác thất bại !";
    }
    $this->returnJson($message);
}
 public function ajax_cancel_order(){
    $this->checkRequestPostAjax();
    $data = $this->input->post();
    $data['content'] = "khách hủy:".$data['content'];
    $id = $data['id'];
    $order = $this->_order->single(['id' => $id]);
    

    if($data['method'] == 3){
        $user = $this->_user->getById($order->user_id,"id,coin_total,coin_lock");
        //thanh toan bang coin -> tra lai coin_lock ve coin_total
        $total_amount_coin = ( ((int)$order->total_amount+(int)$order->priceship-(int)$order->coupon)/(int)$this->_settings_email->coin_price);
        $coin_lock = ((int)$user->coin_lock - (int)$total_amount_coin);
        $coin_total = ((int)$user->coin_total + (int)$total_amount_coin);
        $this->_user->update(['id' => $user->id],['coin_lock'=>$coin_lock,'coin_total'=>$coin_total]);
    }
    unset($data['method']);
    unset($data['id']);
    if($this->_order->update(['id' => $id],$data)){
        $message['type'] = 'success';
        $message['message'] = "Thao tác thành công !";
    }else{
        $message['type'] = 'error';
        $message['message'] = "Thao tác thất bại !";
    }
    $this->returnJson($message);
}
public function pending_coin()
{

    $page= !empty($_GET['page'])?$_GET['page']:1;
    $limit = 9;
    $user_id = $this->session->userdata('user_id');
    $datauser1['list_pending'] = $this->_logbank->getDataLogbank($user_id,$page,$limit);
    $total_log = $this->_logbank->getTotalLogbank($user_id);
    $this->load->library('pagination');
    $paging['base_url'] = base_url("user/pending_coin/{$page}");
    $paging['first_url'] = base_url("user/pending_coin/");
    $paging['total_rows'] = $total_log;
    $paging['per_page'] = $limit;
    $this->pagination->initialize($paging);
    $datauser1['pagination'] = $this->pagination->create_links();
    if(isset($_POST['url'])){

        $html  = $this->load->view($this->template_path . 'user/pending_coin', $datauser1, TRUE);
        $data_mess = [
            'html' => $html,
            'title' => "Lịch sử giao dịch coin đang chờ xử lý"
        ];
        die(json_encode($data_mess));
    }else{
        if(isset($_GET['page'])){
            $html  = $this->load->view($this->template_path . 'user/load_pending_coin', $datauser1, TRUE);
            $data_mess = [
                'html' => $html,
                'title' => "Lịch sử giao dịch coin đang chờ xử lý"
            ];
            die(json_encode($data_mess));
        }else{
            $data['SEO'] = [
            'title' => "Lịch sử giao dịch coin đang chờ xử lý",
            ];
            $datauser['title'] = "Lịch sử giao dịch coin đang chờ xử lý";
            $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
            $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/pending_coin', $datauser1, TRUE);
            $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
            $this->load->view($this->template_main, $data);
        }
        
    }
    
}
public function history()
{
    $this->load->model('Logsref_model');
    $this->_logref = new Logsref_model();
    /*
    1.load log_ref theo user_id
     */
    $page= !empty($_GET['page'])?$_GET['page']:1;
    $limit = 6;
    $type = !empty($_GET['type']) ? $_GET['type'] : "";
    $user_id = $this->session->userdata('user_id');
    $datauser1['list_log'] = $this->_logref->getDataLogref($user_id,$page,$limit,$type);
    $total_log = $this->_logref->getTotalLogref($user_id,$type);
    $this->load->library('pagination');
    $paging['base_url'] = base_url("user/history/page");
    $paging['first_url'] = base_url("user/history/");
    $paging['total_rows'] = $total_log;
    $paging['per_page'] = $limit;
    $this->pagination->initialize($paging);
    $datauser1['pagination'] = $this->pagination->create_links();
    if(isset($_POST['url'])){

        $html  = $this->load->view($this->template_path . 'user/history', $datauser1, TRUE);
        $data_mess = [
            'html' => $html,
            'title' => "lịch sử giao dịch coin"
        ];
        die(json_encode($data_mess));
    }else{
        if(isset($_GET['page'])){
            $html  = $this->load->view($this->template_path . 'user/load_history', $datauser1, TRUE);
            $data_mess = [
                'html' => $html,
                'title' => "lịch sử giao dịch coin"
            ];
            die(json_encode($data_mess));
        }else{
            $data['SEO'] = [
            'title' => "Lịch sử giao dịch coin",
            ];
            $datauser['title'] = "Lịch sử giao dịch coin";
            $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
            $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/history', $datauser1, TRUE);
            $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
            $this->load->view($this->template_main, $data);
        }
        
    }
    
}


public function voucher(){
    $pay_method = array(
       1=> "Voucher khi thanh toán bằng tiền mặt",
       2=> "Voucher khi thanh toán bằng chuyển khoản",
       3=> "Voucher khi thanh toán bằng COIN thưởng",
    );
    if(isset($_POST['url'])){
        $where = array('is_status'=>1);
        if(isset($_GET['pay_method'])){
            $where = array_merge($where,['pay_method' => $_GET['pay_method']]);
        }

        $datauser1['limit'] = $limit = 9;
        $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
        $datauser1['stt'] = $offset;
        $datauser1['list_codesale'] = $list_codesale = $this->_codesale->get_datapdu('',$where,$limit,$offset,'');

        if(!empty($offset)){
            $html  = $this->load->view($this->template_path . 'user/load_voucher', $datauser1, TRUE);
        }else{
            $html  = $this->load->view($this->template_path . 'user/voucher', $datauser1, TRUE);
        }
        
        $data_mess = [
            'html' => $html,
            'title' => !empty($_GET['pay_method']) ? $pay_method[$_GET['pay_method']] : "Tất cả Voucher / Thông báo",
            'limit' => $limit
        ];
        die(json_encode($data_mess));
    }else{

        $where = array('is_status'=>1);
        if(isset($_GET['pay_method'])){
            $where = array_merge($where,['pay_method' => $_GET['pay_method']]);
        }

        $datauser1['limit'] = $limit = 9;
        $offset = 0;
        $datauser1['list_codesale'] = $list_codesale = $this->_codesale->get_datapdu('',$where,$limit,$offset,'');
        
        $data['SEO'] = [
        'title' => isset($_GET['pay_method']) ? $pay_method[$_GET['pay_method']] : "Tất cả Voucher / Thông báo",
        ];
        $datauser['title'] = !empty($_GET['pay_method']) ? $pay_method[$_GET['pay_method']] : "Tất cả Voucher / Thông báo";
        
        /*khi load lại trang*/
        $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
        $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/voucher', $datauser1, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
//danh sách khóa học
public function edu_list($status=''){
    $this->load->model('order_edu_model');
    $this->_edu = new Order_edu_model();
    $user_id = $this->session->userdata('user_id');

    $datauser1['limit'] = $limit = 9;
    $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;

    if(isset($_POST['url'])){
        $datauser1['stt'] = $offset;
        $datauser1['list_edu']  = $this->_edu->getEduByUser($user_id,$limit,$offset);
         if($offset != 0){
            $html  = $this->load->view($this->template_path . 'user/load_edu_list', $datauser1, TRUE);
        }else{
            $html  = $this->load->view($this->template_path . 'user/edu_list', $datauser1, TRUE);
        }
        
        $data_mess = [
            'html' => $html,
            'title' => "Danh sách Khóa học của bạn",
            'limit' => $limit
        ];
        die(json_encode($data_mess));
    }else{
        $datauser1['list_edu']  = $this->_edu->getEduByUser($user_id,$limit,$offset);
        // dd($datauser1['list_edu']);
        
        $data['SEO'] = [
        'title' => "Danh sách Khóa học của bạn",
        ];
        $datauser['title'] = "Danh sách Khóa học của bạn";
        /*khi load lại trang*/
        $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
        $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/edu_list', $datauser1, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
//danh sách khóa học
public function danh_sach_don_hang($status=''){
    $user_id = $this->session->userdata('user_id');
    $is_status = array(
           0 => 'hủy đơn',
           1=> "Chờ xác nhận",
           2=> "Đang giao",
           3=> "Đã giao",
           4=> "Hoàn trả",
        );
    if(isset($_POST['url'])){
        $where = array('user_id'=>$user_id);
        if(isset($_GET['is_status'])){
            $where = array_merge($where,['is_status' => $_GET['is_status']]);
        }

        $datauser1['limit'] = $limit = 9;
        $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
        $datauser1['stt'] = $offset;
        $datauser1['list_order'] = $list_order = $this->_order->get_datapdu('',$where,$limit,$offset,'');
        $list_orderid = array_column($list_order, 'id');
        $datauser1['product_order'] = $product_order = $this->_order->order_detail($list_orderid);
        // dd($list_order);
        if(!empty($offset)){
            $html  = $this->load->view($this->template_path . 'user/load_danh_sach_don_hang', $datauser1, TRUE);
        }else{
            $html  = $this->load->view($this->template_path . 'user/danh_sach_don_hang', $datauser1, TRUE);
        }
        
        $data_mess = [
            'html' => $html,
            'title' => "Danh sách đơn hàng ".(isset($_GET['is_status']) ? $is_status[$_GET['is_status']] : ""),
            'limit' => $limit
        ];
        die(json_encode($data_mess));
    }else{

        $where = array('user_id'=>$user_id);
        if(isset($_GET['is_status'])){
            $where = array_merge($where,['is_status' => $_GET['is_status']]);
        }

        $datauser1['limit'] = $limit = 9;
        $offset = 0;
        $datauser1['list_order'] = $list_order = $this->_order->get_datapdu('',$where,$limit,$offset,'');
        $list_orderid = array_column($list_order, 'id');
        $datauser1['product_order'] = $product_order = $this->_order->order_detail($list_orderid);
        
        $data['SEO'] = [
        'title' => "Danh sách đơn hàng ".(isset($_GET['is_status']) ? $is_status[$_GET['is_status']] : ""),
        ];
        $datauser['title'] = "Danh sách đơn hàng ". (!empty($_GET['is_status']) ? $is_status[$_GET['is_status']] : "");
        
        /*khi load lại trang*/
        $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
        $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/danh_sach_don_hang', $datauser1, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
/*nạp coin*/
public function deposit_coin(){
    $user = $this->_user->single(['id' => $this->session->userdata('user_id')]);
    $datauser1['user']=$user;
    if(isset($_POST['password'])){
        $rules = array(
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'amount',
            'label' => 'Số lượng coin',
            'rules' => 'trim|required'
        )
    );
    $data = $this->_convertData($rules);
    $password = $data['password'];
    for ($i=0; $i < 5; $i++) {
        $password = md5($password);
    }
    if($user->password != $password){
        $message['type'] = "warning";
        $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
        $valid = array();
        $valid['password'] = '<span class="text-danger"> Password không đúng.</span>';

        $message['validation'] = $valid;
        $this->returnJson($message);
    }else{
        $databank = array(
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            "user_id" => $user->id,
            "type" => 2,
            "amount" => $data['amount']
        );
        if($id = $this->_logbank->save($databank)){
            $message['type'] = 'success';
            $message['message'] = "Gửi yêu cầu Nạp thành công.<br> Vui lòng đợi 30 phút, hoặc liên hệ Zalo:". (!empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : '') ." để được hỗ trợ nhanh nhất";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Gửi yêu cầu Nạp thất bại. Vui lòng thử lại !";
        }
        $this->returnJson($message);
    }  
}
    if(isset($_POST['url'])){
        $html  = $this->load->view($this->template_path . 'user/deposit_coin', $datauser1, TRUE);
        $data_mess = [
            'html' => $html,
            'title' => "Nạp coin về tài khoản ngân hàng"
        ];
        die(json_encode($data_mess));
    }else{
        /*khi load lại trang*/
        $data['SEO'] = [
            'title' => "Nạp coin về tài khoản ngân hàng"
        ];
        $datauser['title'] = "Nạp coin về tài khoản ngân hàng";
        $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
        $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/deposit_coin', $datauser1, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
public function withdraw_coin(){
    $user = $this->_user->single(['id' => $this->session->userdata('user_id')]);
    $user->banking = json_decode($user->banking);
    $datauser1['user']=$user;
    if(isset($_POST['password'])){
        $rules = array(
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'amount',
            'label' => 'Số lượng coin',
            'rules' => 'trim|required|greater_than['.(int)$this->_settings_email->limit_withdraw.']'
        )
    );
    $data = $this->_convertData($rules);
    $password = $data['password'];
    for ($i=0; $i < 5; $i++) {
        $password = md5($password);
    }
    if($user->password != $password){
        $message['type'] = "warning";
        $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
        $valid = array();
        $valid['password'] = '<span class="text-danger"> Password không đúng.</span>';

        $message['validation'] = $valid;
        $this->returnJson($message);
    }elseif((int)$user->coin_total < (int)$data['amount']){
        $message['type'] = "warning";
        $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
        $valid = array();
        $valid['amount'] = '<span class="text-danger"> Số dư tài khoản không đủ!</span>';

        $message['validation'] = $valid;
        $this->returnJson($message);
    }else{
        /*chuyen amount sang coin_lock*/
        $coin_total = ((int)$user->coin_total - (int)$data['amount']);
        $coin_lock = ((int)$user->coin_lock + (int)$data['amount']);
        $this->_user->update(array('id'=>$user->id),array('coin_total'=>$coin_total,'coin_lock'=>$coin_lock));

        $databank = array(
            'ip_address' => $this->input->ip_address(),
            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
            "user_id" => $user->id,
            "type" => 1,
            "amount" => $data['amount']
        );
        if($id = $this->_logbank->save($databank)){
            $message['type'] = 'success';
            $message['message'] = "Gửi yêu cầu rút thành công.<br> Vui lòng đợi 30 phút, hoặc liên hệ Zalo:". (!empty($this->_settings->meta_hotline) ? $this->_settings->meta_hotline : '') ." để được hỗ trợ nhanh nhất";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Gửi yêu cầu rút thất bại. Vui lòng thử lại !";
        }
        $this->returnJson($message);
    }  
}
    if(isset($_POST['url'])){
        $html  = $this->load->view($this->template_path . 'user/withdraw_coin', $datauser1, TRUE);
        $data_mess = [
            'html' => $html,
            'title' => "Rút coin về tài khoản ngân hàng"
        ];
        die(json_encode($data_mess));
    }else{
        /*khi load lại trang*/
        $data['SEO'] = [
            'title' => "Rút coin về tài khoản ngân hàng"
        ];
        $datauser['title'] = "Rút coin về tài khoản ngân hàng";
        $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
        $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/withdraw_coin', $datauser1, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
public function update_banking(){
    $user = $this->_user->single(['id' => $this->session->userdata('user_id')]);
    $datauser1['banking'] = json_decode($user->banking);
    if(isset($_POST['password'])){
        $rules = array(
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'bank_name',
            'label' => 'tên ngân hàng',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'bank_number',
            'label' => 'số tài khoản',
            'rules' => 'trim|required'
        ),array(
            'field' => 'bank_author',
            'label' => 'Tên chủ tài khoản',
            'rules' => 'trim|required'
        ),array(
            'field' => 'bank_branch',
            'label' => 'Chi nhánh đăng ký',
            'rules' => 'trim|required'
        )
    );
    $data = $this->_convertData($rules);
    $password = $data['password'];
    for ($i=0; $i < 5; $i++) {
        $password = md5($password);
    }
    if($user->password != $password){
        $message['type'] = "warning";
        $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
        $valid = array();
        $valid['password'] = '<span class="text-danger"> Password không đúng.</span>';

        $message['validation'] = $valid;
        $this->returnJson($message);
    }else{
        unset($data['password']);
        $databank = json_encode($data);
        if($this->_user->update(['id' => $this->session->userdata('user_id')],['banking'=>$databank])){

            $message['type'] = 'success';
            $message['message'] = "Cập nhật Banking thành công";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật Banking thất bại. Vui lòng thử lại !";
        }
        $this->returnJson($message);
    }  
}
    if(isset($_POST['url'])){

        $html  = $this->load->view($this->template_path . 'user/update_banking', $datauser1, TRUE);
        $data_mess = [
            'html' => $html,
            'title' => "Thay đổi tài khoản ngân hàng"
        ];
        die(json_encode($data_mess));
    }else{
        /*khi load lại trang*/
        $data['SEO'] = [
            'title' => "Thay đổi tài khoản ngân hàng"
        ];
        $datauser['title'] = "Thay đổi tài khoản ngân hàng";
        $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
        $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/update_banking', $datauser1, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
        $this->load->view($this->template_main, $data);
    }
}
public function update_password(){
if(isset($_POST['password'])){
        $rules = array(
        array(
            'field' => 'old_password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 're_password',
            'label' => 'Re Password',
            'rules' => 'trim|required|matches[password]'
        ),
    );
    $data = $this->_convertData($rules);
    $password_old = $data['old_password'];
    for ($i=0; $i < 5; $i++) {
        $password_old = md5($password_old);
    }
    $user = $this->_user->single(['id' => $this->session->userdata('user_id')]);
    if($user->password != $password_old){
        $message['type'] = "warning";
        $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
        $valid = array();
        $valid['old_password'] = '<span class="text-danger"> Password cũ không đúng.</span>';

        $message['validation'] = $valid;
        $this->returnJson($message);
    }else{
        $password = $data['password'];
        for ($i=0; $i < 5; $i++) {
            $password = md5($password);
        }
        if($this->_user->update(['id' => $this->session->userdata('user_id')],['password'=>$password])){

            $message['type'] = 'success';
            $message['message'] = "Cập nhật mật khẩu thành công";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật mật khẩu thất bại. Vui lòng thử lại !";
        }
        $this->returnJson($message);
    }  
}
if(isset($_POST['url'])){
    
    $html  = $this->load->view($this->template_path . 'user/update_password', [], TRUE);
    $data_mess = [
        'html' => $html,
        'title' => "Thay đổi mật khẩu"
    ];
    die(json_encode($data_mess));
}else{
    /*khi load lại trang*/
    $data['SEO'] = [
        'title' => "Thay đổi mật khẩu"
    ];
    $datauser['title'] = "Thay đổi mật khẩu";
    $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
    $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/update_password', [], TRUE);
    $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
    $this->load->view($this->template_main, $data);
}
    
    
}
public function callCURL($url, $data = array(), $type = "GET")
    {
        $time_star = microtime(true);
        $resource = curl_init();
        curl_setopt($resource, CURLOPT_URL, $url);

        if ($type == "POST") {
            curl_setopt($resource, CURLOPT_POST, true);
            curl_setopt($resource, CURLOPT_POSTFIELDS, http_build_query($data));
        }
        curl_setopt($resource, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($resource, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($resource, CURLOPT_TIMEOUT, 40);
        $httpcode = curl_getinfo($resource, CURLINFO_HTTP_CODE);
        $result = curl_exec($resource);
        curl_close($resource);
        return $result;
    }

public function info()
{
    $apiaddress = "https://dodinhduongsmile.github.io/cv/api/json/";
    $tinh = $this->callCURL($apiaddress."tinh_tp.json",'','get');
    
    //$tinh = file_get_contents("https://dodinhduongsmile.github.io/cv/api/json/tinh_tp.json");


    $datauser['address_tp'] = json_decode($tinh);

    $datauser['user'] = $this->_user->single(['id' => $this->session->userdata('user_id')]);
    $datauser['user']->birthday = json_decode($datauser['user']->birthday,true);
    $datauser['user']->address = $address = json_decode($datauser['user']->address,true);
    if(!empty($address)){
        $datauser['address_huyen'] = json_decode(file_get_contents($apiaddress.'quan-huyen/'.$address['city'].'.json'),true)[$address['district']];
    
        $datauser['address_xa'] = json_decode(file_get_contents($apiaddress.'xa-phuong/'.$address['district'].'.json'),true)[$address['commune']];
    }
    
    

    if(isset($_POST['url'])){
        /*trả về ajax*/
        $view = 'info';//trùng với method để load view cho đúng
        $html  = $this->load->view($this->template_path . 'user/'.$view, $datauser, TRUE);

        $data_mess = [
            'html' => $html,
            'title' => "Thông tin tài khoản"
        ];
        die(json_encode($data_mess));
    }else{
        /*khi load lại trang*/
        $data['SEO'] = [
        'title' => "Thông tin tài khoản"
        ];
        $datauser['title'] = "Thông tin tài khoản";
        $datauser['sidebar_info'] = $this->load->view($this->template_path . 'user/sidebar_info',[],TRUE);
        $datauser['viewload_noajax'] = $this->load->view($this->template_path . 'user/info', $datauser, TRUE);
        $data['main_content']  = $this->load->view($this->template_path . 'user/layout_user', $datauser, TRUE);
        $this->load->view($this->template_main, $data);
    }
   
}

public function ajax_update_logo(){
    $this->checkRequestPostAjax();
    $id = $this->session->userdata('user_id');
    // $data = $this->input->post();
    $path = USER_PATH.'memberid_'.$id.'/';
    $path2 = "/uploads/memberpdu/memberid_".$id.'/';
    $config['upload_path'] = $path;
    $config['allowed_types'] = 'gif|jpg|jpeg|png|GIF|JPG|JPEG|PNG';
    $config['max_size'] = '1000';
    $config['remove_spaces'] = false;
    $config['file_name'] = "avatarid_".$id;//thay đổi name file, bỏ thì lấy name mặc định
    $this->load->library('upload', $config);
    $this->upload->initialize($config);
    /*xoa avata cu*/
    if(file_exists(PUBLIC_PATH.$this->session->userdata('avatar'))){
        @unlink(PUBLIC_PATH.$this->session->userdata('avatar'));
    }

    if (!$this->upload->do_upload('avatar')) {
        $message['type'] = 'error';
        $message['message'] = $this->upload->display_errors();
        
    } else {
        
        $upload = array('upload_data' => $this->upload->data());
        $url_image = $path2.$upload['upload_data']['file_name'];
        //begin resize
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path.$upload['upload_data']['file_name'];//đường dẫn image đã upload
        $config['create_thumb'] = false;
        $config['maintain_ratio'] = TRUE;
        $config['width']         = 150;//kích thước resize
        $config['height']       = 100;

        $this->load->library('image_lib', $config);//gọi hàm
        $this->image_lib->initialize($config);//lưu lại cái config mới này khi resize
        $this->image_lib->resize();//thực hiện resize
        
        $response = $this->_user->update(['id' => $id], ['avatar' =>$url_image ]);
        if($response){
            $this->session->set_userdata('avatar',$url_image);
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
            $message['file'] = $url_image;
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        
    }
    $this->returnJson($message);

}

public function ajax_saveinfo()
{
    // $data = $this->input->post();
    $this->checkRequestPostAjax();
    $rules = array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email',
        ),

        array(
            'field' => 'phone',
            'label' => 'Số điện thoại',
            'rules' => 'trim|required|regex_match[/^0[0-9]{9}+$/]'
        ),
        array(
            'field' => 'fullname',
            'label' => 'Tên',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'gender',
            'label' => 'giới tính',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'birthday[day]',
            'label' => 'Ngày tháng năm sinh',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'birthday[month]',
            'label' => 'Ngày tháng năm sinh',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'birthday[year]',
            'label' => 'Ngày tháng năm sinh',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'address[city]',
            'label' => 'tỉnh/thành phố',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'address[district]',
            'label' => 'quận/huyện',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'address[commune]',
            'label' => 'xã/phường',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 'shipping_address',
            'label' => 'Địa chỉ',
            'rules' => 'trim|required'
        ),
    );
    $data = $this->_convertData($rules);
    unset($data['email']);
    $data['fullname'] = htmlentities($data['fullname']);
    $data['shipping_address'] = htmlentities($data['shipping_address']);
    $data['birthday'] = json_encode($data['birthday']);
    $data['address'] = json_encode($data['address']);
    if($this->_user->update(['id' => $this->session->userdata('user_id')],$data)){

        $message['type'] = 'success';
        $message['message'] = "Cập nhật thông tin thành công";
    }else{
        $message['type'] = 'error';
        $message['message'] = "Cập nhật thông tin thất bại. Vui lòng thử lại !";
    }

    $this->returnJson($message);
}


public function ajax_update_field(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        $response = $this->_user->update(['id' => $id], [$field => $value]);
        if($response != false){
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

public function login(){
    if ($this->session->userdata('user_id')){
        redirect(base_url("user/"));
    };
    $data['SEO'] = [
        'meta_title' => 'Đăng nhập thành viên '. (!empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDU'),
        'meta_description' => 'Đăng nhập thành viên '. (!empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDU'),
        'meta_keyword' => 'Đăng nhập thành viên '. (!empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDU'),
        'url' => base_url('user/login'),
        'is_robot' => 1,
    ];
    $data['main_content']  = $this->load->view($this->template_path . 'user/login', [], TRUE);
    $this->load->view($this->template_main, $data);
}
public function login_google() { 
        // $rediect_uri = "http://localhost/ctytoan/pducomputer/googlex/test";
        $rediect_uri = base_url("user/login");
        $this->google_api->login2($rediect_uri);
        $info = $this->google_api->getInfo_Google();
        if(!empty($info->email)){
            if($this->_user->check_oauth('email',trim($info->email))){
                $user = $this->_user->single(['email' => trim($info->email)]);
                $sessionLogin = array(
                    'user_id' => (int)$user->id,
                    'lever' => (int)$user->lever,
                    'fullname' => $user->fullname,
                    'email'    => $user->email,
                    'username'    => $user->username,
                    'avatar' => $user->avatar,
                    'coin_total' => (int)$user->coin_total,
                );
                $this->session->set_userdata($sessionLogin);
                /*update last_login*/
                $this->_user->update(array('id'=>$user->id), array('last_login'=>time()));
                dd($_SESSION);
            }else{
                /*insert*/
                $datasave = array(
                    'password' => '123456',
                    'email' => trim($info->email),
                    'username' => "taikhoan",
                    'fullname' => trim($info->name),
                    'avatar' => trim($info->picture),
                    'active' => 1,
                    'lever' => 0,
                    'ip_address' => $this->input->ip_address(),
                    // 'refresh_token' => trim($info->id),
                    'parent_id' => !empty(get_cookie('affilate_id')) ? (int)get_cookie('affilate_id') : 0,
                );

                if($id = $this->_user->save($datasave)){
                    // echo "inser thanhcong,chuyển hướng tới user";
                    redirect(base_url("user/"));
                }
            }
        }else{
            dd($info);
        }
       
       
    }
public function logout()
    {
        session_destroy();
        $this->session->sess_destroy();

        redirect(base_url('user/login'), 'refresh');
    }
public function register(){
    if ($this->session->userdata('user_id')){
        redirect(base_url("user/"));
    };
    $data['SEO'] = [
        'meta_title' => 'Đăng ký thành viên '. (!empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDU'),
        'meta_description' => 'Đăng ký thành viên '. (!empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDU'),
        'meta_keyword' => 'Đăng ký thành viên '. (!empty($this->_settings->title_short) ? $this->_settings->title_short : 'PDU'),
        'url' => base_url('user/register'),
        'is_robot' => 1,
    ];
    $data['main_content']  = $this->load->view($this->template_path . 'user/register', [], TRUE);
    $this->load->view($this->template_main, $data);

}

public function ajax_login(){
    $this->checkRequestPostAjax();
    $email = $this->input->post('email');

    $rules[] = array(
        'field' => 'email',
        'label' => 'email',
        'rules' => filter_var($email, FILTER_VALIDATE_EMAIL) ? 'trim|required|valid_email' : 'trim|required'
    );
    $rules[] = array(
        'field' => 'password',
        'label' => 'mật khẩu',
        'rules' => 'trim|required'
    );

    $this->form_validation->set_rules($rules);
    if ($this->form_validation->run() != false) {

        if($this->input->post('email') && trim($this->input->post('email')) != '' && $this->input->post('password') && trim($this->input->post('password')) != ''){

            $user = $this->_user->single(['email' => trim($this->input->post('email'))],$this->_user->table);
            
            if(!empty($user))
            {
                /*remember*/
                if ($this->input->post('rememberme')){
                  set_cookie('is_login', true, time() + 3600);
                  set_cookie('user_login', $user->email, time() + 3600);
              }else{
                  set_cookie('is_login', "", time() - 3600);
                  set_cookie('user_login', "", time() - 3600);
              }

              $password = $this->input->post('password');
              for ($i=0; $i < 5; $i++) {
                $password = md5($password);
            }

            if($user->password === $password && $user->active == 1 && $user->lever == 0)
            {

                $sessionLogin = array(
                    'user_id' => (int)$user->id,
                    'lever' => (int)$user->lever,
                    'fullname' => $user->fullname,
                    'email'    => $user->email,
                    'username'    => $user->username,
                    'avatar' => $user->avatar,
                    'coin_total' => (int)$user->coin_total,
                );
                $this->session->set_userdata($sessionLogin);
                $this->session->set_userdata('CodeIgniterAuthenticator.environment', ENVIRONMENT);
                $this->_user->update(array('id'=>$user->id), array('last_login'=>time()));

                $message['type'] = 'success';
                $message['message'] = "đăng nhập thành công";
                $message['redirect'] = base_url("user/");
                $this->returnJson($message);
            }
            else
            {
                $message['type'] = 'error';
                $message['message'] = "sai mật khẩu";
                $this->returnJson($message);
            }
        }
        else
        {
            $message['type'] = 'error';
            $message['message'] = "sai tài khoản";
            $this->returnJson($message);
        }

    }

    }else{
        $message['type'] = "warning";
        $message['message'] = "Vui lòng kiểm tra lại thông tin.";
        $valid = array();
        if (!empty($rules)) foreach ($rules as $item) {
            if (!empty(form_error($item['field']))) $valid[$item['field']] = form_error($item['field']);
        }
        $message['validation'] = $valid;
        $this->returnJson($message);
    }


}

public function ajax_register()
{
    // $data = $this->input->post();
    $this->checkRequestPostAjax();
    $rules = array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email|is_unique[' . $this->_user->_dbprefix . 'users.email]',
            'errors' => array(
                'is_unique' => '%s đã tồn tại. Vui lòng chọn email khác.',
            )
        ),
        array(
            'field' => 'phone',
            'label' => 'Số điện thoại',
            'rules' => 'trim|required|regex_match[/^0[0-9]{9}+$/]'
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required'
        ),
        array(
            'field' => 're_password',
            'label' => 'Re Password',
            'rules' => 'trim|required|matches[password]'
        ),
    );
    $data = $this->_convertData($rules);
    
    $password = $data['password'];
    for ($i=0; $i < 5; $i++) {
        $password = md5($password);
    }
    
    $datasave = array(
        'password' => $password,
        'phone' =>$data['phone'],
        'email' => $data['email'],
        'username' => "taikhoan",
        'active' => 0,
        'lever' => 0,
        'ip_address' => $this->input->ip_address(),
        'activation_code' => md5($data['email']),
        'parent_id' => !empty(get_cookie('affilate_id')) ? (int)get_cookie('affilate_id') : 0,
    );

    if($id = $this->_user->save($datasave)){

        /*sendmail*/
        $datasave['title'] = "Kích hoạt tài khoản ";
        $link_active = base_url("user/activeuser?activation_code={$datasave['activation_code']}");
        $contentmail = "
        <p>Bạn vui long click đường link sau, để kích hoạt tài khoản <a href='{$link_active}'>{$link_active}</a></p>
        <p>Nếu không phải bạn đăng ký tài khoản, thì hãy bỏ qua email này.</p>";

        $data['content'] = $contentmail;
        $data['title'] = "kích hoạt tài khoản";
        $this->sendMailUser($data);

        $message['type'] = 'success';
        $message['message'] = "Đăng ký thành công. Vui lòng check email để active tài khoản!";
    }else{
        $message['type'] = 'error';
        $message['message'] = "Đăng ký thất bại. Vui lòng thử lại !";
    }

    $this->returnJson($message);
}


public function forgotpass($forgotten_password_code="")
{
    /*
    1. nhận email user -> lấy user theo email
    2. update forgotten_password_code, và forgotten_password_time = 1 mã gì đó
    3. gửi mail link đổi pass /forgotpass/forgotten_password_code (truyền biến vào link)
    4. đổi pass mới -> update pass new
     */
    if ($this->session->userdata('user_id')){
        redirect(base_url());
    };
    $changepassnew = '';

    if(!empty($_POST) && empty($forgotten_password_code)){
         
        $rules = array(
        array(
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'trim|required|valid_email'
        )
        );
        $data = $this->_convertData($rules);
        if(!empty($data['email'])){
            $user = $this->_user->getUserByField('email', $data['email']);
            if(!empty($user)){
                $forgot_code = md5($user->id.time());
                $update = $this->_user->update(array('id'=>$user->id),array('forgotten_password_code'=>$forgot_code,'forgotten_password_time'=>time()) );
                if($update){
                    /*sendmail*/
                    $link_forgot = base_url("user/forgotpass/{$forgot_code}");
                    $contentmail = "
                    <p>Bạn vui long click đường link sau, để thay đổi mật khẩu mới <a href='{$link_forgot}'>{$link_forgot}</a></p>
                    <p>Nếu không phải bạn yêu cầu lấy lại mật khẩu, thì hãy bỏ qua email này.</p>";

                    $data['content'] = $contentmail;
                    $data['title'] = "Quên mật khẩu, đổi mật khẩu mới ";
                    $this->sendMailUser($data);

                    $message['type'] = 'success';
                    $message['message'] = "Bạn vui lòng check email để lấy lại mật khẩu !";
                }
            }else{
                $message['type'] = 'error';
                $message['message'] = "Email chưa đăng ký tài khoản";
            }
            $this->returnJson($message);
        }
    }
    $dataview['title'] = "Quên mật khẩu?";
    $dataview['descript'] = "Bạn vui lòng nhập Email tài khoản muốn lấy lại mật khẩu!";
    //
    
    if(!empty($forgotten_password_code)){
        $changepassnew = 1;
        
        if($_POST){
            $user = $this->_user->getUserByField('forgotten_password_code',$forgotten_password_code);
            if(!empty($user)){

                if(($user->forgotten_password_time + 86400) < time()){
                    $message['type'] = 'error';
                    $message['message'] = "Đường link đã hết hạn sử dụng. ";
                }else{
                    $rules = array(
                        array(
                            'field' => 'password',
                            'label' => 'Password',
                            'rules' => 'trim|required'
                        ),
                        array(
                            'field' => 're_password',
                            'label' => 'Re Password',
                            'rules' => 'trim|required|matches[password]'
                        ),
                    );
                    $data = $this->_convertData($rules);
                    
                    $password = $data['password'];
                    for ($i=0; $i < 5; $i++) {
                        $password = md5($password);
                    }
                    
                    $update = $this->_user->update(['id'=>$user->id],['password'=>$password,'forgotten_password_code'=>time()]);
                    if($update){
                        $message['type'] = 'success';
                        $message['message'] = "Đổi mật khẩu mới thành công. Vui lòng <a href=".base_url('user/login')." >Đăng nhập</a> !";
                        $this->returnJson($message);
                    }
                }
                
            }else{
                
                $message['type'] = 'error';
                $message['message'] = "Link đã hết hạn sử dụng, hoặc bạn đã thay đổi mật khẩu trước đó. Vui lòng <a href=".base_url('user/forgotpass')." >Lấy lại mật khẩu</a>";
                $message['redirect'] = base_url("user/forgotpass");
                $this->returnJson($message);
            }
        }
        
        $dataview['forgotten_password_code'] = $forgotten_password_code;
        $dataview['title'] = "Đổi mật khẩu mới";
        $dataview['descript'] = "Bạn vui lòng nhập mật khẩu mới!";
    }
    
    $dataview['changepassnew'] = $changepassnew;


    $data['main_content']  = $this->load->view($this->template_path . 'user/forgotpass', $dataview, TRUE);
    $this->load->view($this->template_main, $data);
}
public function activeuser()
{
    
    $activation_code = $this->input->get('activation_code');
    if(!empty($activation_code)){
        $this->checktime();
        $user = $this->_user->getUserByField('activation_code',$activation_code);
        if(!empty($user)){
            if($user->active == 0){
                $this->_user->update(array('id'=>$user->id),array('active'=>1));
                /*code +coin khi có ref*/
                if($user->parent_id != 0){
                    /*cấp độ hoa hồng*/
                    $user1 = $this->_user->getById($user->parent_id,"id,coin_ref,parent_id");
                    $coinadd = $this->_settings_email->coin_ref;
                    if((int)$this->_settings_email->level_ref >=2 && $user1->parent_id != 0){
                        $user_c2 = $this->_user->getById($user1->parent_id,"id,coin_ref,parent_id");
                        $list_parent = array();
                        array_push($list_parent, $user1,$user_c2);
                        foreach($list_parent as $item){
                            $coin_ref = (int)$item->coin_ref + (int)$coinadd; 
                            
                            $this->_user->update(array('id'=>$item->id),array('coin_ref'=>$coin_ref));
                            $dtlogref = array(
                                'type'=>'ref','user_id'=>$item->id,'child_id'=>$user->id,
                                'reward'=>$coinadd,
                                'note' =>"User id {$item->id} +{$coinadd} coin, vì giới thiệu user mới id= {$user->id}"
                            );
                            $this->addLogRef($dtlogref);
                        }
                    }else{
                        
                        $coin_ref = (int)$user1->coin_ref + (int)$coinadd;

                        $this->_user->update(array('id'=>$user1->id),array('coin_ref'=>$coin_ref));
                        $dtlogref = array(
                            'type'=>'ref','user_id'=>$user1->id,'child_id'=>$user->id,
                            'reward'=>$coinadd,
                            'note' =>"User id {$user1->id} +{$coinadd} coin, vì giới thiệu user mới id= {$user->id}"
                        );
                        $this->addLogRef($dtlogref);
                    }
                }
                
                $data = [
                   'nofication' => "Bạn đã active tài khoản thành công",
                   'type' => 1,
                   'title' => "Active tài khoản"
                ];
            }else{
                $data = [
                   'nofication' => "Yêu cầu kích hoạt không hợp lệ, hoặc tài khoản đã kích hoạt trước đó. Vui lòng đăng nhập thử xem.",
                   'type' => 1,
                   'title' => "Active tài khoản"
                ];
                
            }
        }else{
            $data = [
               'nofication' => "Đã quá thời gian kích hoạt là 24h, kể từ khi đăng ký. Vui lòng đăng ký lại.",
               'type' => 0,
               'title' => "Active tài khoản"
            ];
        }

        $data['main_content']  = $this->load->view($this->template_path . 'user/done', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }else{
        redirect(base_url());
    }
    
}
/*User quá 24h không active sẽ bị xóa*/
public function checktime()
{
    $listuser = $this->_user->getDataAll(['active'=>0],'users','id,created_time');
    $time_active = time();
    $ids = [];
    foreach($listuser as $item){
        $time_reg = strtotime($item->created_time);
        if($time_active > ($time_reg+86400)){
            $ids[] = $item->id;
        }
    }
    if(!empty($ids)){$this->_user->deleteArray('id', $ids);}
    return true;
}
public function sendMailUser($data){
    if(!empty($data['email'])){
        /*Config setting*/
        $domain = !empty($this->_settings->domain) ? $this->_settings->domain : 'PDU GROUP';

        $this->load->library('email');
        $emailTo   = $data['email']; //Send mail cho khach hang
        $emailToCC = !empty($this->_settings_email->email_admin) ? $this->_settings_email->email_admin : ''; //Send mail cho ban quan tri
        $emailFrom = $emailToCC;//sau trả lời thư sẽ gửi tới cái mail này
        $nameFrom  = !empty($this->_settings_email->name_from) ? $this->_settings_email->name_from : 'PDU';
        $contentHtml = $this->load->view($this->template_path . 'user/mail_user', $data, TRUE);
        $this->email->from($emailFrom, $nameFrom);

        $this->email->to($emailTo);
        if(!empty($emailToCC)) $this->email->cc($emailToCC);
        if(!empty($emailToBCC)) $this->email->bcc($emailToBCC);
        $this->email->subject($data['title']. $domain);
        $this->email->message($contentHtml);
        $this->email->send();
    }
}


    private function _validation($rules){

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

    private function _convertData($rules=array()){
        $this->_validation($rules);

        $data = $this->input->post();
        return $data;
    }


/*lấy child 2 cấp của userid cách 1*/
public function _getchild_user($user_id, $lever2=2)
{
    $child_c1 = $this->_user->getUserchild(array($user_id));
    $id_child =  array_column($child_c1, 'id');
    $child_c2 = $this->_user->getUserchild($id_child);
    $stt = 0;

    foreach($child_c1 as $v){
        $stt++;
        $list_child2 = [];
        if($lever2 > 1){
            foreach($child_c2 as $v2){
                if($v->id == $v2->parent_id){
                    $stt++;
                    $list_child2[] = $v2;
                }
            }
        }
        
        $v->sub = $list_child2;
    }
    $child_user = array();
    $child_user['row'] = $child_c1;
    $child_user['count'] = $stt;
    return $child_user;
}
/*lấy child 2 cấp của userid cách 2 - có vẻ chạy lâu hơn khi nhiều record*/
public function _recursive_childpdu($all, $parentId,$level=true){
        $stt = 0;
        $_list_child = array();
        if(!empty($all)) foreach ($all as $key => $item){
            if($item->parent_id == $parentId){ 
                $stt++;
                unset($all[$key]);
                if($level){
                    $_list_child1 = [];
                    if(!empty($all)) foreach ($all as $key => $item1){
                        if($item1->parent_id == $item->id){ 
                            $stt++;
                            $_list_child1[] = $item1;
                        }
                    }
                    $item->sub = $_list_child1;
                }
                $_list_child['row'][] = $item;   
            }
        }
        $_list_child['count'] = $stt++;
        return $_list_child;
    }

public function count_ref($all, $parentId,$level=2){
        $stt = 0;
        $stt++;
        if(!empty($all)) foreach ($all as $key => $item){
            if($item->parent_id == $parentId){
                $this->_list_child[] = $item;
                unset($all[$key]);
                if($stt < $level){
                    $this->count_ref($all, $item->id,$stt);
                }
                
            }
        }
        return count($this->_list_child);
    }
}

/* End of file Ajax.php */
/* Location: ./application/controllers/Ajax.php */