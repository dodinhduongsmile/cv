<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Public_Controller
{
    protected $_contact;

    public function __construct() {
        parent::__construct();
        
        $this->load->model('contact_model');
        $this->_contact = new Contact_model();
    }

    public function send_contact()
    {
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        if($id = $this->_contact->save($data)){
            $message['type'] = 'success';
            $message['message'] = "Gửi thông tin thành công";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Gửi thông tin thất bại !!!";
        }
        $this->returnJson($message);
    }

    public function send_report()
    {
        //$this->load->model('report_model');
        $this->checkRequestPostAjax();
        $data = $this->_convertData();
        if($id = $this->report_model->save($data)){
            $message['type'] = 'success';
            $message['message'] = "Gửi báo cáo thành công";
        }else{
            $message['type'] = 'error';
            $message['message'] = "Gửi thông tin thất bại !!!";
        }
        $this->returnJson($message);
    }
    private function _validation(){
        $this->checkRequestPostAjax();
        $rules = [
            [
                'field' => "full_name",
                'label' => "họ tên",
                'rules' => "trim|required|min_length[2]"
            ],[
                'field' => "email",
                'label' => "email",
                'rules' => "trim|required|valid_email|min_length[2]"
            ],[
                'field' => "phone",
                'label' => "số điện thoại",
                'rules' => "trim|required|min_length[7]"
            ],[
                'field' => "address",
                'label' => "địa chỉ",
                'rules' => "trim|required|min_length[5]"
            ],[
                'field' => "content",
                'label' => "nội dung",
                'rules' => "trim|required|min_length[5]"
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
