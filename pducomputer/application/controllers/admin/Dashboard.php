<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        //tải thư viện
        $this->load->model('users_model');
        $this->_user = new Users_model();
        $this->load->model('order_model');
        $this->_data = new Order_model();
    }

    public function index(){
        $data['heading_title'] = "Báo cáo, thống kê";
        $data['heading_description'] = 'Báo cáo, thống kê';
        //get tổng recond chưa được xem của order,deposit, withdraw, contact
        
        $data['main_content'] = $this->load->view($this->template_path.'dashboard/index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }

    public function ajax_load1(){
        
        //bình luận kém chất lượng
        $output['comment_bad'] = $this->_data->count(["count_star <"=>4],"comment");
        //đơn hàng chờ xử lý
        $output['count_order'] = $this->_data->count(["is_status"=>1],"order");
        //lệnh nạp coin
        $output['count_nap'] = $this->_data->count(["is_status"=>1,"type"=>2],"logbank");
        //lệnh rút coin
        $output['count_rut'] = $this->_data->count(["is_status"=>1,"type"=>1],"logbank");
        //khóa học chưa share drive
        $output['count_edu_user'] = $this->_data->count(["is_status"=>1],"edu_user");

        $this->returnJson($output);

        // $html = $this->load->view($this->template_path . 'ware_import/_ajax_load_data', $data, TRUE);
        // echo $html;
        // exit();
    }
}