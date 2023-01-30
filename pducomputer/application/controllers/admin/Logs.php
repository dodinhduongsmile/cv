<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs extends Admin_Controller
{
    protected $_data;

    const STATUS_CANCEL = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 2;
    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model(['logs_model','users_model']);
        $this->_data = new Logs_model();
        $this->users = new Users_model();
    }

    public function index($data,$view){
        $data['data'] = [];
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . $view, $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function logs_user(){
        $data['heading_title'] = "Quản lý hành vi users";
        $data['heading_description'] = "Danh sách bài viết";
        $data['view'] = $view = "index";
        $this->index($data,$view);
    }
    public function logs_cms(){
        $data['heading_title'] = "Quản lý lỗi CMS";
        $data['heading_description'] = "Danh sách lỗi CMS";
        $data['view'] = $view = "cms";
        $file = FCPATH . 'application/logs/' . 'log-'.date('Y-m-d').'.log';
        if (file_exists($file)) {
            $size = filesize($file);

            if ($size >= 5242880) {
                $suffix = array(
                    'B',
                    'KB',
                    'MB',
                    'GB',
                    'TB',
                    'PB',
                    'EB',
                    'ZB',
                    'YB'
                );

                $i = 0;

                while (($size / 1024) > 1) {
                    $size = $size / 1024;
                    $i++;
                }

                $error_warning = 'Warning: Your error log file %s is %s!';

                $data['error_warning'] = sprintf($error_warning, basename($file), round(substr($size, 0, strpos($size, '.') + 4), 2) . $suffix[$i]);
            } else {
                $log = file_get_contents($file, FILE_USE_INCLUDE_PATH, null); 
                $lines = explode("ERROR - ", $log); 
                $data['logs'] = array_reverse($lines);
            }
        }
        $this->index($data,$view);
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
            'page'    => $page,
            'limit'   => $limit,
            'order'   => ['id'=>'DESC']
        ];
        $listData = $this->_data->getData($params);
        if(!empty($listData)) foreach ($listData as $item) {
            $user = $this->users->getUserByField('id',$item->uid);
            $row = array();
            $row['checkID'] = $item->id;
            $row['id'] = $item->id;
            $row['uid'] = !empty($user->username) ? $user->username.' ('.$user->email.')' : '';
            $row['module'] = $item->module;
            $row['action'] = $item->action;
            $row['note'] = $item->note;
            $row['created_time'] = date('H:i d-m-Y',strtotime($item->created_time));
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

    public function ajax_edit(){
        $this->checkRequestPostAjax();
        $id = $this->input->post('id');
        if(!empty($id)){
            $output['data_info'] = $this->_data->single(['id' => $id],$this->_data->table);
            $this->returnJson($output);
        }
    }
    public function ajax_delete_log_user(){
        if($this->_data->delete_loguser()){
            $this->returnJson([
            'type' => 'success',
            'message' => 'Xóa log user thành công !'
            ]);
        }else{
            $this->returnJson([
            'type' => 'success',
            'message' => 'Xóa log user thất bại !'
            ]);
        }
        
    }
}