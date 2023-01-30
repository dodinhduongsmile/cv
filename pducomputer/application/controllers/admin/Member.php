<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends Admin_Controller
{
    protected $_data;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện

        $this->load->model(['users_model']);
        $this->_data = new Users_model();
        
    }

    public function index()
    {
        $data['heading_title'] = "Quản lý thành viên";
        $data['heading_description'] = 'Danh sách thành viên';
        $data['main_content'] = $this->load->view($this->template_path . 'user' . DIRECTORY_SEPARATOR . 'member', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }


    public function ajax_list()
    {
        $this->checkRequestPostAjax();
        $data = array();
        $pagination = $this->input->post('pagination');
        $page = $pagination['page'];
        $total_page = isset($pagination['pages']) ? $pagination['pages'] : 1;
        $limit = !empty($pagination['perpage']) && $pagination['perpage'] > 0 ? $pagination['perpage'] : 1;

        $queryFilter = $this->input->post('query');
        $params = [
            'page' => $page,
            'limit' => $limit,
            'order' => ['users.id'=>'DESC'],
            'whereall' => ['lever =' => 0]
        ];
        if (isset($queryFilter['is_status']) && $queryFilter['is_status'] !== '')
            $params = array_merge($params, ['is_status' => $queryFilter['is_status']]);
        if (isset($queryFilter['active']) && $queryFilter['active'] !== '')
            $params = array_merge($params, ['active' => $queryFilter['active']]);
        
        $listData = $this->_data->getData($params);
        
        if (!empty($listData)) foreach ($listData as $item) {

            $row = array();
            $row['checkID'] = $item->id;
            $row['id'] = $item->id;
            $row['username'] = $item->username;
            $row['email'] = $item->email;
            $row['is_status'] = $item->is_status;
            $row['updated_time'] = $item->updated_time;
            $row['created_time'] = $item->created_time;
            $data[] = $row;
        }

        $output = [
            "meta" => [
                "page" => $page,
                "pages" => $total_page,
                "perpage" => $limit,
                "total" => $this->_data->getTotal(),
                "sort" => "asc",
                "field" => "id"
            ],
            "data" => $data
        ];

        $this->returnJson($output);
    }



    public function ajax_add() {
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        // dd($data);
        if($id = $this->_data->save($data)){
            $note   = 'Thêm user có id là : '.$id;
            $this->addLogaction('user',$data,$id,$note,'Add');
            $message['type'] = 'success';
            $message['message'] = "Thêm mới thành công !";
        } else {
            $message['type'] = 'error';
            $message['message'] = "Thêm mới thất bại !";
        }

        $this->returnJson($message);
    }

    public function ajax_edit()
    {
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        if (!empty($id)) {
            $dataItem = $this->_data->getById($id);
            unset($dataItem->password);
            $output['data'] = $dataItem;

            $this->returnJson($output);
        }
    }

    public function ajax_update()
    {
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        
        $id = $data['id'];
        $data_old = $this->_data->getUserByField('id',$id);
        

        if($this->_data->update(['id' => $id],$data, $this->_data->table)){
            $note   = 'Update users có id là : '.$id;
            $this->addLogaction('users',$data_old,$id,$note,'Update');
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_update_field()
    {
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        $field = $this->input->post('field');
        $value = $this->input->post('value');
        $response = $this->_data->update(['id' => $id], [$field => $value]);
        if ($response != false) {
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
        } else {
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_delete()
    {
        $this->checkRequestPostAjax();
        $ids = $this->input->post('id');
        if ((is_array($ids) && array_search(1, $ids)) || $ids == 1) {
            $message['type'] = 'error';
            $message['message'] = "Bạn không có quyền xóa Admin !";
            $this->returnJson($message);
        } else {
            $response = $this->_data->deleteArray('id', $ids);
            if ($response != false) {
                $message['type'] = 'success';
                $message['message'] = "Xóa thành công !";
            } else {
                $message['type'] = 'error';
                $message['message'] = "Xóa thất bại !";
                log_message('error', $response);
            }
            $this->returnJson($message);
        }
    }

    public function ajax_load()
    {
        $this->checkRequestGetAjax();
        $term = $this->input->get("q");
        $params = [
            'search' => $term,
            'limit' => 100
        ];
        $list = $this->_data->getUserSelect2($params);
        $json = [];
        if (!empty($list)) foreach ($list as $item) {
            $item = (object)$item;
            $json[] = ['id' => $item->id, 'text' => $item->email . '(' . $item->fullname . ')'];
        }
        print json_encode($json);
        exit;
    }

    private function _validation()
    {
        $rules = array(
            array(
                'field' => 'fullname',
                'label' => 'Họ và tên',
                'rules' => 'trim'
            ),
            array(
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'trim|required|valid_email' . ($this->input->post('id') == 0 ? '|is_unique[' . $this->_data->_dbprefix . 'users.email]' : ''),
                'errors' => array(
                    'is_unique' => '%s đã tồn tại. Vui lòng chọn email khác.',
                )
            ),
            array(
                'field' => 'phone',
                'label' => 'Số điện thoại',
                'rules' => 'trim|regex_match[/^0[0-9]{9}+$/]'
            ),
            array(
                'field' => 'username',
                'label' => 'Username',
                'rules' => 'trim|required' . ($this->input->post('id') == 0 ? '|is_unique[' . $this->_data->_dbprefix . 'users.username]' : ''),
                'errors' => array(
                    'is_unique' => '%s đã tồn tại. Vui lòng chọn username khác.',
                )
            ),
            array(
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim' . ($this->input->post('id') == 0 ? '|required' : '')
            ),
            array(
                'field' => 're-password',
                'label' => 'Re Password',
                'rules' => 'trim|matches[password]' . ($this->input->post('id') == 0 ? '|required' : '')
            )
        );
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == false) {
            $message['type'] = "warning";
            $message['message'] = "Vui lòng kiểm tra lại thông tin vừa nhập.";
            $valid = array();
            if (!empty($rules)) foreach ($rules as $item) {
                if (!empty(form_error($item['field']))) $valid[$item['field']] = form_error($item['field']);
            }
            $message['validation'] = $valid;
            $this->returnJson($message);
            exit;
        }
    }

    private function _convertData()
    {
        $this->_validation();
        $data = $this->input->post();

        
        if (isset($data['is_status'])){ $data['is_status'] = 1;}else{$data['is_status'] = 0;}
        if(!empty($data['password'])){
            $password = $data['password'];
            for ($i=0; $i < 5; $i++) {
                $password = md5($password);
            }
            $data['password'] = $password;
            unset($data['re-password']);
        }else{
            unset($data['re-password']);
            unset($data['password']);
        }
        
        return $data;
    }

}