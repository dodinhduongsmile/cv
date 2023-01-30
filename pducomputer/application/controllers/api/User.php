<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends API_Controller
{
    protected $_all_category;

    public function __construct() {
        parent::__construct();
        $this->load->helper('data');
        $this->load->model(['users_model']);
        $this->_edu = new Users_model();
    }
     

//get banking banknumberedu
public function getInfoBankEdu(){
    $data_home = getSetting('data_home');
    $banknumberedu =$data_home->banknumberedu;
    if (empty($banknumberedu)){
        $data['success'] = 0;
        $data['message'] = "not exit data";
        $this->returnJson($data);
    };
    die(json_encode($banknumberedu);
}
//rut tien
public function deposit_coin($who="",$amount="",$user_id=""){
    $params = $this->input->post();
    $who = $params['who'];
    $amount = $params['amount'];
    $user_id = $params['user_id'];

    $api_token = $this->input->get("api_token");
    // log vào bảng logs_api
    $dtlog = array(
        'api_token'=>$api_token,
        'who'=>$who,
        'modul'=>'user',
        'action'=>"deposit_coin",
        'is_status'=>1,
        'note' =>"User id: ".$user_id." Nạp ".$amount." coin từ web ".$who." chờ xử lý. (Sang web ý xác nhận)"
    );

    if($this->addLogApi($dtlog)){
        $data['success'] = 1;
        $this->returnJson($data);
    }else{
         $data['success'] = 0;
        $data['message'] = "error";
        $this->returnJson($data);   
    }
    
}


}
