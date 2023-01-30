<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logbank extends Admin_Controller
{
    protected $_data;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model('Logbank_model');
        $this->load->model('Users_model');
        $this->_data = new Logbank_model();
        $this->_user = new Users_model();
    }

    public function index(){
        $data['heading_title'] = "Quản lý giao dịch nạp/rút";
        $data['heading_description'] = "Quản lý giao dịch nạp/rút";
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
            $dataUser = $this->_user->getByField('id',$item->user_id);//người tạo
            $row = array();
            $row['checkID'] = $item->id;
            $row['id'] = $item->id;
            $row['type'] = $item->type;
            $row['email'] = !empty($dataUser->email) ? $dataUser->email : '';
            $row['amount'] = number_format($item->amount,0,'','.');
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
            $output['data_info'] = $this->_data->single(['id' => $id],$this->_data->table);
            $output['data_user'] = $this->_user->getById($output['data_info']->user_id,"id,email");;
            $this->returnJson($output);
        }
    }

    public function ajax_update(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        $id = $data['id'];
        unset($data['user_id']);//vì chỉ nhận yêu cầu tư user, k cho sửa
        unset($data['type']);
        unset($data['amount']);
        $data_old = $this->_data->single(['id' => $id],$this->_data->table);
        if($data_old->pay_status == 0){//trang thai chưa ấn thanh toán thành công
            if($data['is_status'] == 2){//đã thanh toan
                $data['pay_status'] = 1;

                if(!empty($data_old->user_id)){
                    $coinadd = $data_old->amount;
                    $user = $this->_user->getById($data_old->user_id,"id,coin_total,coin_lock");
                   
                    if($data_old->type == 1){
                        /*xu ly rut*/
                        $reduce = 1;
                        $coin_locks = ((int)$user->coin_lock - (int)$coinadd);
                        $type_bank = "withdraw";
                        $this->_user->update(array('id'=>$user->id),array('coin_lock'=>$coin_locks));
                    }elseif($data_old->type == 2){
                        /*xu ly nap*/
                        $reduce = 2;
                        $coin_total = ((int)$user->coin_total + (int)$coinadd);
                        $type_bank = "deposit";
                        $this->_user->update(array('id'=>$user->id),array('coin_total'=>$coin_total));
                    }

                    $dtlogref = array(
                        'type'=>$type_bank,
                        'user_id'=>$user->id,
                        'child_id'=>0,
                        'reward'=>$coinadd,
                        'note' =>"User id = {$user->id}, ". ($reduce == 1 ? '-':'+')."{$coinadd} coin, vì ". ($reduce == 1 ? 'rút':'nạp')." coin, đơn hàng id= {$id}"
                    );
                    $this->addLogRef($dtlogref);
                    
                }
            }
        }
        if($this->_data->update(['id' => $id],$data, $this->_data->table)){
            $note   = 'Update Logbank có id là : '.$id;
            $this->addLogaction('Logbank',$data_old,$id,$note,'Update');
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

    private function _validation(){
        $this->checkRequestPostAjax();
        $rules = [
            [
                'field' => "type",
                'label' => "kiểu giao dịch",
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