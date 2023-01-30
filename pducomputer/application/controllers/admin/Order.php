<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Admin_Controller
{
    protected $_data;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model('users_model');
        $this->_user = new Users_model();
        $this->load->model('order_model');
        $this->_data = new Order_model();

    }

    public function index(){
        $data['heading_title'] = "Quản lý đơn hàng";
        $data['heading_description'] = "Danh sách đơn hàng";
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function ajax_list(){
        $this->checkRequestPostAjax();
        $data = array();
        $pagination = $this->input->post('pagination');
        $page = $pagination['page'];
        $total_page = isset($pagination['pages']) ? $pagination['pages'] : 1;
        $limit = !empty($pagination['perpage']) && $pagination['perpage'] > 0 ? $pagination['perpage'] : 1;

        $queryFilter = $this->input->post('query');
        $params = [
            'page'  => $page,
            'limit' => $limit,
            'order' => array('id'=>'desc')
        ];
        if(isset($queryFilter['is_status']) && $queryFilter['is_status'] !== ''){
            $params = array_merge($params,['is_status' => $queryFilter['is_status']]);
        }

        $listData = $this->_data->getData($params);
        if(!empty($listData)) foreach ($listData as $item) {
            $row = array();
            $row['checkID']      = $item->id;
            $row['id']           = $item->id;
            $row['code']         = '<a href="'.base_url('cart/detail_order/'.$item->code).'" target="_blank">'.$item->code.'</a>';
            $row['email']        = $item->email;
            $row['full_name']    = $item->full_name;
            $row['phone']        = $item->phone;
            $row['address']      = $item->address;
            $row['is_status']    = $item->is_status;
            $row['pay_status']    = $item->pay_status;
            $row['total_amount'] = number_format($item->total_amount +$item->priceship - $item->coupon ,0,'','.');
            $row['updated_time'] = $item->updated_time;
            $row['created_time'] = $item->created_time;
            $data[] = $row;
        }

        $output = [
            "meta" => [
                "page"      => $page,
                "pages"     => $total_page,
                "perpage"   => $limit,
                "total"     => $this->_data->getTotal(),
                "sort"      => "asc",
                "field"     => "id"
            ],
            "data" =>  $data
        ];

        $this->returnJson($output);
    }
/*
ajax_load2 load data order vào thông báo ở header
 */
public function ajax_load2(){
        // $this->checkRequestPostAjax();
        $term = $this->input->post("q");
        $params = [
            'is_status'=> 1,
            'limit'=> 10,
            'order' => array('id'=>'desc'),
        ];
        $listdata = $this->_data->getData($params);
        $output = [];
        if(!empty($listdata)) foreach ($listdata as $item) {
            $output[] = ['id'=>$item->id, 'code'=>$item->code, 'fullname'=>$item->full_name,'time'=>$item->created_time];
        }
        $this->returnJson($output);

        // $html = $this->load->view($this->template_path . 'ware_import/_ajax_load_data', $data, TRUE);
        // echo $html;
        // exit();
    }
    public function ajax_edit(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        if(!empty($id)){
            $data_info  = $this->_data->single(['id' => $id]);

            $data_info->note = json_decode($data_info->note);
            $data_info->total_amount = number_format($data_info->total_amount +$data_info->priceship - $data_info->coupon,0,'','.');
            $output['data_info'] = $data_info;

            $data_product = $this->_data->getData_OrderDetail(["a.id"=>$data_info->id]);
            
            $count_product = $this->_data->getSoldProduct($data_info->id);
            
            $html = $this->load->view($this->template_path . "order/load_data_detail", ['data_product'=>$data_product,"data_info"=>$data_info], TRUE);
            $output['order_detail'] = $html;

            $print = $this->load->view($this->template_path . "order/data_print", ['data_product'=>$data_product, "data_info"=>$data_info,'count_product'=>$count_product], TRUE);
            $output['order_print'] = $print;
            $this->returnJson($output);
        }
    }

    public function ajax_update(){
        /*
        có thanh toán COIN thì sau hủy đơn cũng trả lại coin cho nó, chưa phát triển
         */
        $this->checkRequestPostAjax();
        $data = $this->_convertData();

        $id = $data['id'];
        unset($data["method"]);
        $data["note"] = json_encode($data["note"]);

        $data_old = $this->_data->single(['id' => $id],$this->_data->table);
        /*add log ref
                1. user mua hàng sẽ được thưởng 10%
                2. cha của user sẽ được thưởng 5%
                - chủ link giới thiệu thưởng 5%
            */
        if($data_old->payment_ref == 0){//=0 là chưa ấn vào nút đã thanh toán (kẻo quản lý lệch chuẩn)
            if($data['pay_status'] == 2 && ($data['is_status'] == 2 || $data['is_status'] == 3)){//=2 đã thanh toán
                $data['payment_ref'] = 1;
                $this->_settings_email  = getSetting('data_email');
                $coinadd = ((int)$this->_settings_email->coin_order * $data_old->total_amount)/(100*1000);//*1000 để tính ra coin vì 1coin=1000
                if(!empty($data_old->user_id)){
                    $user = $this->_user->getById($data_old->user_id,"id,coin_order,parent_id,coin_lock,coin_total");
                    //nếu thanh toán = COIN -> xử lý trừ coin
                    if($data_old->method == 3){
                        $total_amount_coin = ( ((int)$data_old->total_amount+(int)$data_old->priceship-(int)$data_old->coupon)/(int)$this->_settings_email->coin_price);
                        $coin_lock = ((int)$user->coin_lock - (int)$total_amount_coin);
                        $this->_user->update(['id' => $user->id],['coin_lock'=>$coin_lock]);
                        $dtlogref = array(
                            'type'=>'delete_coin','user_id'=>$user->id,
                            'child_id'=>0,
                            'reward'=>$total_amount_coin,
                            'note' =>"User id = {$user->id}, -{$total_amount_coin} coin. Thanh toán đơn hàng id = {$id}"
                        );
                        $this->addLogRef($dtlogref);
                    }
                    // đơn hàng đã login -> +coin cho user login và cha cap 1 của user
                    if((int)$this->_settings_email->level_ref >=3 && $user->parent_id != 0){
                        /*cấp độ thưởng hoa hồng >=3 thì cho chính nó và cha cấp 1*/
                        $user_c1 = $this->_user->getById($user->parent_id,"id,coin_order,parent_id");
                        $list_parent = array();
                        array_push($list_parent,$user, $user_c1);
                        $reduce = 1;
                        foreach($list_parent as $item){
                            $coinadds = ((int)$coinadd/$reduce);
                            $coin_order = (int)$item->coin_order + ((int)$coinadds); 
                            
                            $this->_user->update(array('id'=>$item->id),array('coin_order'=>$coin_order));
                            $dtlogref = array(
                                'type'=>'order','user_id'=>$item->id,'child_id'=>$user->id,
                                'reward'=>$coinadds,
                                'note' =>"User id = {$item->id}, +{$coinadds} coin, vì ". ($reduce == 1 ? 'mua':'giới thiệu')." đơn hàng mới id= {$id}"
                            );
                            $this->addLogRef($dtlogref);
                            $reduce++;
                        }
                    }else{
                        $coin_order = (int)$user->coin_order + (int)$coinadd;
                        $this->_user->update(array('id'=>$user->id),array('coin_order'=>$coin_order));
                        $dtlogref = array(
                            'type'=>'order','user_id'=>$user->id,
                            'child_id'=>0,
                            'reward'=>$coinadd,
                            'note' =>"User id = {$user->id}, +{$coinadd} coin, vì mua đơn hàng mới id= {$id}"
                        );
                        $this->addLogRef($dtlogref);
                    }
                }elseif(!empty($data_old->affilate_id)){
                    //chưa login user và có người giới thiệu -> +coin cho người giơi thiệu affilate_id
                    $user = $this->_user->getById($data_old->affilate_id,"id,coin_order,parent_id");
                    $coin_order = (int)$user->coin_order + (int)$coinadd;

                    $this->_user->update(array('id'=>$user->id),array('coin_order'=>$coin_order));
                    $dtlogref = array(
                        'type'=>'order','user_id'=>$user->id,
                        'child_id'=>0,
                        'reward'=>$coinadd,
                        'note' =>"User id = {$user->id}, +{$coinadd} coin, vì giới thiệu đơn hàng mới id= {$id}"
                    );
                    $this->addLogRef($dtlogref);
                }else{
                    //k login và không người giới thiệu -> k +coin cho ai
                }
            }
        }
        if($this->_data->update(['id' => $id],$data, $this->_data->table)){
            
            $note   = 'Update order có id là : '.$id;
            $this->addLogaction('order',$data_old,$id,$note,'Update');
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_update_field(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        $response = $this->_data->update(['id' => $id], [$field => $value]);
        if($response != false){
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_delete(){
        $this->checkRequestPostAjax();
        $ids = (int)$this->input->post('id');
        $response = $this->_data->deleteArray('id',$ids);
        if($response != false){
            $message['type'] = 'success';
            $message['message'] = "Xóa thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Xóa thất bại !";
            log_message('error',$response);
        }
        $this->returnJson($message);
    }

    private function _convertData(){
        $data = $this->input->post();
        return $data;
    }
    public function addLogRef($data)
    {
        $this->load->model("logsref_model");
        $logActionModel = new Logsref_model();
        $data_store = [
            'type' => $data['type'],
            'user_id' => $data['user_id'],
            'child_id' => $data['child_id'],
            'reward' => $data['reward'],
            'note' => $data['note'],
            
        ];
        $logActionModel->save($data_store);
    }
}