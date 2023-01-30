<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Logs_ware extends Admin_Controller
{
    protected $_data;
    protected $_product;

    const STATUS_CANCEL = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DRAFT = 2;
    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model(['logsware_model','users_model','product_model']);
        $this->_data = new Logsware_model();
        $this->users = new Users_model();
        $this->_product = new Product_model();
    }

    public function index($data,$view){
        $data['data'] = [];
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . $view, $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function logs_ware(){
        $data['heading_title'] = "Quản lý hoạt động kho";
        $data['heading_description'] = "Danh sách hoạt động";
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
            $user = $this->users->getUserByField('id',$item->user);
            $row = array();
            $row['checkID'] = $item->id;
            $row['id'] = $item->id;
            $row['user'] = !empty($user->username) ? $user->username.' ('.$user->email.')' : '';
            // $row['module'] = $item->module;
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
            $data = $this->_data->single(['id' => $id],$this->_data->table);
            $output['data_info'] = $this->_product->single(['id' => $data->module_id],$this->_product->table);
            $output['data_cu'] = json_decode($data->data);
            $this->returnJson($output);
        }
    }

}