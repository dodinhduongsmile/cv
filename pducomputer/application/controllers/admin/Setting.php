<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Admin_Controller {

    protected $_setting;

    public function __construct(){
        parent::__construct();

        $this->load->model('setting_model');
        $this->_setting  = new Setting_model();
    }

    public function index()
    {
        //lấy data theo key
        $data_seo = $this->_setting->get_setting_by_key('data_seo');
        $data_social = $this->_setting->get_setting_by_key('data_social');
        $data_email = $this->_setting->get_setting_by_key('data_email');
        $data_home = $this->_setting->get_setting_by_key('data_home');

        $data['data_seo'] = !empty($data_seo) ? json_decode($data_seo->value_setting) : '';
        $data['data_social'] = !empty($data_social) ? json_decode($data_social->value_setting) : '';
        $data['data_email'] = !empty($data_email) ? json_decode($data_email->value_setting) : '';
        $data['data_home'] = !empty($data_home) ? json_decode($data_home->value_setting) : '';
        $data['main_content'] = $this->load->view($this->template_path . $this->_controller . DIRECTORY_SEPARATOR . 'index', $data, TRUE);
        $this->load->view($this->template_main, $data);
    }
//xử lý cập nhật = ajax
    public function update_setting()
    {
        $this->checkRequestPostAjax();
        //lấy tất cả dữ liệu $_POST
        $data = $this->input->post();
        //lấy  $_POST['key_setting']. nó có 3 phần tử, nhưng 3 form khác nhau, nên chỉ trả về cái nào đang bật
        $key_setting = $data['key_setting'];
        // xóa bỏ hết phần tử trong mảng key_setting ở $_post trả về
        unset($data['key_setting']);
        //mảng data còn nhiều giá trị $_POST khác
        if (!empty($data)) {
            $param_store = [
                'value_setting' => json_encode($data),
                'key_setting' => $key_setting,
                'title' => $key_setting,
            ];
            //lấy hàng đầu tiên theo key_setting ở database
            $checkSetting = $this->_setting->get_setting_by_key($key_setting);
            if (!empty($checkSetting)) {
                //xóa bỏ phần tử $param_store['key_setting'] vì nó đã tồn tại ở database
                unset($param_store['key_setting']);
                //update thông tin theo id
               $this->_setting->update(['id'=>$checkSetting->id],$param_store);
            }else{
               $this->_setting->save($param_store);
            }
        }

        $data_mess = [
            'message' => 'Update thành công',
            'type' => 'success'
        ];
        die(json_encode($data_mess));
    }

    public function delete_cache_file($url = ''){
        if (empty($url)){
            $this->load->helper('file');
            $url = $this->input->get('url');
        }

        if(!empty($url)){
            $uri = str_replace(base_url(),'/',$url);
            if($this->output->delete_cache($uri)){
               $this->returnJson([
                'type' => 'success',
                'message' => 'Xóa cache file thành công !'
            ]);
            }
        }else{
            if(delete_files(FCPATH . 'application' . DIRECTORY_SEPARATOR . 'logs')){
                $this->returnJson([
                    'type' => 'success',
                    'message' => 'Xóa cache file thành công !'
                ]);
            }
        }

    }
    public function ajax_clear_cache_db(){
        $this->deleteCache();
        $this->returnJson([
            'type' => 'success',
            'message' => 'Xóa cache database thành công !'
        ]);
    }

    public function ajax_clear_cache_image(){
        if($this->recursiveDelete(MEDIA_PATH . DIRECTORY_SEPARATOR . 'thumb'))
            $this->returnJson([
                'type' => 'success',
                'message' => 'Xóa cache ảnh thành công !'
            ]);
        else
            $this->returnJson([
                'type' => 'error',
                'message' => 'Xóa cache ảnh không thành công !'
            ]);
    }
    private function recursiveDelete($str) {
        if (is_file($str)) {
            return @unlink($str);
        }
        elseif (is_dir($str)) {
            $scan = glob(rtrim($str,'/').'/*');
            foreach($scan as $index=>$path) {
                $this->recursiveDelete($path);
            }
            return @rmdir($str);
        }
    }
}