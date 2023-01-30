<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Attribute extends Admin_Controller
{
    protected $_data;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model('Attribute_model');
        $this->_data = new Attribute_model();
    }

    public function index(){
        $data['heading_title'] = "Quản lý Attribute";
        $data['heading_description'] = "Danh sách Attribute";
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
            'order' => array('parent_id'=>'asc','type_img'=>'asc')
        ];
        if(isset($queryFilter['is_status']) && $queryFilter['is_status'] !== ''){
            $params = array_merge($params,['is_status' => $queryFilter['is_status']]);
        }

        $listData = $this->_data->getData($params);
        if(!empty($listData)) foreach ($listData as $item) {
            $row = array();
            $row['checkID'] = $item->id;
            $row['id'] = $item->id;
            $row['title'] = $item->title;
            $row['order'] = $item->order;
            $row['parent_id'] = $item->parent_id;
            $row['type_img'] = $item->type_img;
            $row['is_status'] = $item->is_status;
            $row['is_featured'] = $item->is_featured;
            $row['is_filter'] = $item->is_filter;
            $row['updated_time'] = $item->updated_time;
            $row['created_time'] = $item->created_time;
            $data[] = $row;
        }

        $output = [
            "meta" => [
                "page"      => $page,
                "pages"     => $total_page,
                "perpage"   => $limit,
                "total"     => $this->_data->getTotal($params),
                "sort"      => "asc",
                "field"     => "id"
            ],
            "data" =>  $data
        ];

        $this->returnJson($output);
    }
    //load dữ liệu bảng atrribute này, cho cái ajax nào gọi đến
    public function ajax_load(){
        $term = $this->input->get("q");
        $id = $this->input->get('id')?$this->input->get('id'):0;
        $params = [
            'is_status'=> 1,
            'type_img'=> " ",
            'keyword' => $term,
            'limit'=> 30
        ];
        $data = $this->_data->getData($params);
        $output = [];
        if(!empty($data)) foreach ($data as $item) {
            $output[] = ['id'=>$item->id, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }
/*Load thuộc tính này cho add và edit ở Controller category, vì ở frontend gọi bộ lọc ra theo name nhóm thuộc tính
$item->slugattr dùng slugattr hoặc gọi id cũng được, vì tao thích gọi slugattr (sửa thành id thì ở Category/edit sửa theo để cho nó load đúng dữ liệu)
*/
    public function ajax_load2(){
        $term = $this->input->get("q");
        $id = $this->input->get('id')?$this->input->get('id'):0;
        $params = [
            'is_status'=> 1,
            'type_img'=> " ",
            'keyword' => $term,
            'limit'=> 30
        ];
        $data = $this->_data->getData($params);
        $output = [];
        if(!empty($data)) foreach ($data as $item) {
            $output[] = ['id'=>$item->slugattr, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }

    public function ajax_add(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        $data['is_status'] = 1;
        //xử lý dữ liệu json, để add
        $content = $data['content'];
        $contentkey = $data['key'];
        $datax = [];
        foreach ($content as $key => $value){
            $datax[] = array("key"=>$contentkey[$key],"value"=>$value);
        }
        $data['content'] = json_encode($datax);
        unset($data['key']);//vì database không có cột key

        if($id = $this->_data->save($data)){
            $note   = 'Thêm location có id là : '.$id;
            $this->addLogaction('location',$data,$id,$note,'Add');
            $message['type'] = 'success';
            $message['message'] = "Thêm mới thành công !";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Thêm mới thất bại !";
        }
        $this->returnJson($message);
    }

//lấy thông tin cái cần sửa
    public function ajax_edit(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        if(!empty($id)){
            $output['data_info'] = $data_info = $this->_data->single(['id' => $id],$this->_data->table);
            $output['data_info']->content = json_decode($data_info->content);

            $output['data_category'] = [];
            if (!empty($data_info->parent_id)) {
                $output['data_category'][] = $this->_data->getByField('id',$data_info->parent_id,'id,title as text');
            }

            $this->returnJson($output);
        }
    }
//update thông tin vừa sửa
    public function ajax_update(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        $id = $data['id'];
// dd($data);
        //xử lý dữ liệu json, để add
        if(isset($data['content'])){
            $content = $data['content'];
            $contentkey = $data['key'];
            $datax = [];
            foreach ($content as $key => $value){
                $datax[] = array("key"=>$contentkey[$key],"value"=>$value);
            }
            $data['content'] = json_encode($datax);
            unset($data['key']);
        }
        
        

        $data_old = $this->_data->single(['id' => $id],$this->_data->table);
        if($this->_data->update(['id' => $id],$data, $this->_data->table)){
            $note   = 'Update location có id là : '.$id;
            $this->addLogaction('location',$data_old,$id,$note,'Update');
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

//validate dữ liệu
    private function _validation(){
        $this->checkRequestPostAjax();
        $rules = [
            [
                'field' => "title",
                'label' => "Tiêu đề",
                'rules' => "trim|required"
            ],[
                'field' => "slugattr",
                'label' => "Đường dẫn",
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
}