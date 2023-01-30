<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_edu extends Admin_Controller
{
    protected $_data;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model('Edu_model');
        $this->load->model('Order_edu_model');
        $this->_edu = new Edu_model();
        $this->_data = new Order_edu_model();
    }

    public function index(){
        $data['heading_title'] = "Khóa học của User";
        $data['heading_description'] = "Quản lý Khóa học của User";
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
            'page'          => $page,
            'limit'         => $limit,
            'order'         => array('id'=>'desc')
        ];
        if(isset($queryFilter['is_status']) && $queryFilter['is_status'] !== '')
            $params = array_merge($params,['is_status' => $queryFilter['is_status']]);

        $listData = $this->_data->getData($params);
        if(!empty($listData)) foreach ($listData as $item) {
            $dataUser = $this->_data->getById($item->user_id,"id,email","users");//người tạo
            $row = array();
            $row['checkID'] = $item->id;
            $row['id'] = $item->id;
            $row['email'] = !empty($dataUser->email) ? $dataUser->email : '';
            $row['edu_id'] = $item->edu_id;
            $row['price'] = number_format($item->price,0,'','.');
            $row['is_status'] = $item->is_status;
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
                "sort"      => "desc",
                "field"     => "id"
            ],
            "data" =>  $data
        ];

        $this->returnJson($output);
    }


    public function ajax_edit(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        if(!empty($id)){
            $output['data_info'] = $this->_data->getAllinfo($id);
            $this->returnJson($output);
        }
    }

    public function ajax_update(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        $id = $data['id'];
        $data_old = $this->_data->single(['id' => $id],$this->_data->table);
        
        if($this->_data->update(['id' => $id],$data, $this->_data->table)){
            $note   = 'Update Order_edu có id là : '.$id;
            $this->addLogaction('Order_edu',$data_old,$id,$note,'Update');
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
        $id = (int)$this->input->post('id');

        $data_all = $this->_data->getAllinfo( $id);
        if(!empty($data_all->user_id)){
            $user_id = $data_all->user_id;
            $edu_id = $data_all->edu_id;
            $coinadd = $data_all->price;
            
            if($data_all->is_status == 2){
                /*xóa email share drive*/
                $link_id = str_replace("/", "", strrchr($data_all->link_drive,"/"));
                $email_remove = $data_all->user_email;
                $id_permission = $data_all->id_permission;
                
                $this->load->library('google_api');
                $rediect_uri = GG_rediect;
                $this->google_api->login($rediect_uri,'drive');
                $remove_share = $this->google_api->remove_share($email_remove,$link_id,$id_permission);
            }
            /*xoa recound*/
            $response = $this->_data->deleteArray('id',$id);
            if($response != false){
                /*hoàn coin*/
                if($coinadd > 0){
                    $coin_total = ((int)$data_all->coin_total + (int)$coinadd);
                    $this->_data->update(array('id'=>$user_id),array('coin_total'=>$coin_total),"users");
                    $dtlogref = array(
                        'type'=>"delete_edu",
                        'user_id'=>$user_id,
                        'child_id'=>0,
                        'reward'=>$coinadd,
                        'note' =>"User id = {$user_id} + {$coinadd} COIN, Hoàn coin vì hủy khóa học id = {$edu_id}"
                    );
                    $this->addLogRef($dtlogref);
                }
                    
                $message['type'] = 'success';
                $message['message'] = "Xóa thành công !";
            }else{
                $message['type'] = 'error';
                $message['message'] = "Xóa thất bại !";
                log_message('error',$response);
            }
            $this->returnJson($message);
        }

    }

    private function _validation(){
        $this->checkRequestPostAjax();
        $rules = [
            [
                'field' => "price",
                'label' => "Coin thanh toán",
                'rules' => "trim|required"
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

    private function _convertData(){
        $this->_validation();
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