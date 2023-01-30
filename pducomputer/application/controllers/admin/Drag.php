<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Drag extends Admin_Controller
{
    protected $_data;
    protected $type;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('drag_model');
        $this->_data = new Drag_model();
        $this->type = $this->uri->segment(3);
    }

    public function index($data){
        $data['data'] = [];
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function home_featured(){
        $data['heading_title'] = "Nổi bật trang chủ";
        $data['heading_type'] = "home_featured";
        $data['heading_description'] = "Danh sách phim nổi bật trang chủ";
        $data['dragInfo'] = $this->_data->getDataDrag($this->type);
        $this->index($data);
    }

    public function save_drag(){
        $input = $this->input->post()['s'];
        $type  = $this->input->post('type');
        foreach ($input as $k => $value){
            $input[$k]['order'] = $k;
            $input[$k]['phim_id'] = $value['id'];
            $input[$k]['type'] = $type;
            unset($input[$k]['id']);
        }
        $this->_data->delete(['type' => $type],'drag');
        if ($this->_data->insertMultiple($input,'drag')){
            echo 1;
        } else {
            echo 0;
        };
    }
    /*end drag*/

    public function ajax_load(){
        $term = $this->input->get("q");
        $params = [
            'is_status'=> 1,
            'keyword' => $term,
            'limit'=> 20
        ];

        $data = $this->_data->getData($params);
        $output = [];
        if(!empty($data)) foreach ($data as $item) {
            $output[] = ['id'=>$item->id, 'text'=>$item->title];
        }
        $this->returnJson($output);
    }
  
}