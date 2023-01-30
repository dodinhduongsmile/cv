<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comment extends Admin_Controller
{
    protected $_data;

    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model('comment_model');
        $this->_data = new Comment_model();
    }

    public function index(){
        $data['heading_title'] = "Quản lý bình luận";
        $data['heading_description'] = "Danh sách bình luận";
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
            'order'         => array('count_star'=>'asc','report'=>'desc'),
        ];
        if(isset($queryFilter['is_status']) && $queryFilter['is_status'] !== '')
            $params = array_merge($params,['is_status' => $queryFilter['is_status']]);

        $listData = $this->_data->getData($params);

        if(!empty($listData)) foreach ($listData as $item) {
            $row = array();
            $row['checkID'] = $item->id;
            $row['id'] = $item->id;
            $row['parent_id'] = $item->parent_id;
            $row['title']  = '<a href="'.get_all_url_detail($item->type,$item->target_id,"slug").'" target="_blank">'.$item->type." id: ".$item->target_id.'</a>';
            $row['count_like'] = $item->count_like;
            $row['report'] = $item->report;
            $row['count_star'] = $item->count_star;
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
                "sort"      => "asc",
                "field"     => "id"
            ],
            "data" =>  $data
        ];

        $this->returnJson($output);
    }
    
    public function ajax_add(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        
        if($id = $this->_data->save($data)){
            $note   = 'Thêm comment có id là : '.$id;
            $this->addLogaction('comment',$data,$id,$note,'Add');
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
            $output['data_info'] = $this->_data->single(['id' => $id],$this->_data->table);

            $output['data_info']->content = html_entity_decode($output['data_info']->content);
            //get thumbani
            $output['data_info']->file_attach_thumb = getPathThumb($output['data_info']->file_attach);

            
            $this->returnJson($output);
        }
    }

    public function ajax_update(){
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        $data['content'] = htmlentities($data['content']);
        $id = $data['id'];
        $data_old = $this->_data->single(['id' => $id],$this->_data->table);
        if($this->_data->update(['id' => $id],$data, $this->_data->table)){
            $note   = 'Update comment có id là : '.$id;
            $this->addLogaction('comment',$data_old,$id,$note,'Update');
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
        $id = (int)$this->input->post('id');
        $data = $this->_data->getById($id,"id,parent_id,file_attach");
        if($data->parent_id == 0){
            //delete cmt sub
            $this->_data->delete(['parent_id'=>$id]);
        }
        if(!empty($data->file_attach)){
            if(file_exists(PUBLIC_PATH.$data->file_attach)){
                @unlink(PUBLIC_PATH.$data->file_attach);
                @unlink(PUBLIC_PATH.getPathThumb($data->file_attach));
            }
        }
        $response = $this->_data->deleteArray('id',$id);
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
                'field' => "content",
                'label' => "Nội dung",
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
        if (isset($data['is_status'])){ $data['is_status'] = 1;}else{$data['is_status'] = 0;}
        $data = $this->input->post();
        return $data;
    }
}