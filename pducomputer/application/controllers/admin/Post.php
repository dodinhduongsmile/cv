<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends Admin_Controller
{
    protected $_data;
    protected $_user;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model(['post_model','users_model']);
        $this->_data         = new Post_model();
        $this->_user         = new Users_model();
    }

    public function index(){
        $data['heading_title'] = "Quản lý tin tức";
        $data['heading_description'] = "Danh sách tin tức";
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
            'order'         => array('id','desc')
        ];
        if(isset($queryFilter['is_status']) && $queryFilter['is_status'] !== '')
            $params = array_merge($params,['is_status' => $queryFilter['is_status']]);

        $listData = $this->_data->getData($params);
        if(!empty($listData)) foreach ($listData as $item) {
            $dataUser = $this->_user->getByField('id',$item->user_id);
            $row = array();
            $row['checkID']    = $item->id;
            $row['id']         = $item->id;
            $row['title']        = '<a href="'.get_url_post($item).'" target="_blank">'.$item->title.'</a>';
            $row['thumbnail']  = $item->thumbnail;
            $row['username']   = !empty($dataUser->username) ? $dataUser->username : '';
            $row['is_status']  = $item->is_status;
            $row['is_featured']  = $item->is_featured;
            $row['viewed']     = $item->viewed;
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

    private function save_category($id, $data) {
        $this->_data->delete(['post_id'=>$id],'post_category');
        if(!empty($data)) foreach ($data as $category_id){
            $tmp = ["post_id" => $id, 'category_id' => $category_id];
            $data_category[] = $tmp;
        }

        if(!$this->_data->insertMultiple($data_category, 'post_category')){
            $message['type'] = 'error';
            $message['message'] = "Thêm 'post_category' thất bại !";
            log_message('error', $message['message'] . '=>' . json_encode($data_category));
        }
    }

    public function ajax_load(){
        $term = $this->input->get("q");
        $id = $this->input->get('id')?$this->input->get('id'):0;
        $params = [
            'is_status'=> 1,
            'not_in' => ['id' => $id],
            'search' => $term,
            'limit'=> 10
        ];
        $data = $this->_data->getData($params);
        $output = [];
        if(!empty($data)) foreach ($data as $item) {
            $output[] = ['id'=>$item->id, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }
    public function ajax_add(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();

        //validate riquired category_id
        if(!isset($data['category_id'])){
            $message['type'] = 'error';
            $message['message'] = "Bạn chưa chọn Danh Mục !";
            $this->returnJson($message);
            exit();
         }
        $data_category = $data['category_id'];
        $data['category_id'] = end($data['category_id']);//lấy phần tử cuối của mảng category_id

        if($id = $this->_data->save($data)){
            $note   = 'Thêm post có id là : '.$id;
            $this->addLogaction('post',$data,$id,$note,'Add');
            $this->save_category($id, $data_category);

            $message['type'] = 'success';
            $message['message'] = "Thêm mới thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Thêm mới thất bại !";
        }
        $this->returnJson($message);
    }

    public function ajax_edit(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        if(!empty($id)){
            $output['data_info'] = $data_info = $this->_data->single(['id' => $id],$this->_data->table);
            $output['data_category'] = $this->_data->getSelect2Category($id);
            $this->returnJson($output);
        }
    }

    public function ajax_update(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        
        $id = $data['id'];
        $data_old = $this->_data->single(['id' => $id],$this->_data->table);

        //validate riquired category_id
        if(!isset($data['category_id'])){
            $message['type'] = 'error';
            $message['message'] = "Bạn chưa chọn Danh Mục !";
            $this->returnJson($message);
            exit();
         }
        $data_category = $data['category_id'];
        $data['category_id'] = end($data['category_id']);//lấy phần tử cuối của mảng category_id

        if($this->_data->update(['id' => $id],$data, $this->_data->table)){
            $this->save_category($id, $data_category);
            $note   = 'Update post có id là : '.$id;
            $this->addLogaction('post',$data_old,$id,$note,'Update');
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
            //xóa cate bảng trung gian
            $this->_data->deleteArray('post_id',$ids,'post_category');
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
                'field' => "title",
                'label' => "Tiêu đề",
                'rules' => "trim|required"
            ],[
                'field' => "slug",
                'label' => "Đường dẫn",
                'rules' => "trim|required"
            ],[
                'field' => "meta_title",
                'label' => "Tiêu đề SEO",
                'rules' => "trim|required"
            ],[
                'field' => "meta_description",
                'label' => "Mô tả SEO",
                'rules' => "trim|required"
            ],[
                'field' => "thumbnail",
                'label' => "ảnh đại diện",
                'rules' => "trim|required"
            ],[
                'field' => "category_id",
                'label' => "danh mục",
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

    private function _convertData(){
        $this->_validation();
        $data = $this->input->post();
        if (isset($data['is_status'])) $data['is_status'] = 1;else $data['is_status'] = 0;
        return $data;
    }
}